<?php

namespace App\Livewire;

use App\Enums\Plan;
use App\Enums\TemelAlan;
use App\Models\AbonelikTalebi;
use App\Models\Paket;
use App\Models\Universite;
use App\Models\User;
use App\Services\Abonelik\AbonelikTalepleri;
use App\Services\Abonelik\PaketKatalogu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * @property-read Collection<string, Paket> $paketler
 */
#[Title('Kurulum')]
#[Layout('layouts.auth')]
class Onboarding extends Component
{
    /** Tanıtım sayfasında seçilen paketin oturum anahtarı (bkz. CreateNewUser). */
    public const SECILEN_PAKET = 'secilen_paket';

    public const SON_ADIM = 3;

    public int $step = 1;

    public string $unvan = '';

    public string $name = '';

    public string $universite = '';

    public string $fakulte = '';

    public string $bolum = '';

    public string $temelAlan = 'sosyal';

    public string $orcid = '';

    public string $paket = 'ucretsiz';

    public string $donem = 'aylik';

    /**
     * Available academic titles.
     *
     * @var list<string>
     */
    public array $unvanlar = User::UNVANLAR;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user->hasCompletedOnboarding()) {
            $this->redirectRoute('dashboard', navigate: true);

            return;
        }

        $this->name = $user->name;

        $secilen = Plan::tryFrom((string) session(self::SECILEN_PAKET));

        if ($secilen !== null && $this->paketler()->has($secilen->value)) {
            $this->paket = $secilen->value;
        }
    }

    /**
     * Seçilebilecek paketler: satıştakiler. Ücretsiz satıştan kaldırılmış
     * olsa da her zaman seçilebilir; kimse kuruluma ücretli bir paket
     * seçmeden giremez durumda kalmasın.
     *
     * @return Collection<string, Paket>
     */
    #[Computed]
    public function paketler(): Collection
    {
        $katalog = app(PaketKatalogu::class);
        $satistakiler = $katalog->satistakiler();

        return $katalog->hepsi()->filter(fn (Paket $p): bool => $p->plan === Plan::Ucretsiz || $satistakiler->has($p->plan->value));
    }

    /** Seçili paketin yıllık fiyatı yoksa dönem aylığa döner. */
    public function updatedPaket(): void
    {
        if ($this->paketler()->get($this->paket)?->yillik_fiyat_kurus === null) {
            $this->donem = 'aylik';
        }
    }

    public function next(): void
    {
        $this->validate($this->rulesForStep($this->step));

        $this->step = min($this->step + 1, self::SON_ADIM);
    }

    public function back(): void
    {
        $this->step = max($this->step - 1, 1);
    }

    public function cikis(): void
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirectRoute('login');
    }

    public function updatedTemelAlan(): void
    {
        $this->tutarliligiSagla();
    }

    public function updatedFakulte(): void
    {
        $this->tutarliligiSagla();
    }

    public function updatedBolum(): void
    {
        $this->tutarliligiSagla();
    }

    /**
     * Kaskad tutarlılık: temel alan → fakülte → bölüm.
     * Bir üst seçim değişince alt seçim listede yoksa sıfırlanır.
     */
    private function tutarliligiSagla(): void
    {
        $fakulteler = TemelAlan::tryFrom($this->temelAlan)?->fakulteler() ?? [];
        if (! in_array($this->fakulte, $fakulteler, true)) {
            $this->fakulte = '';
        }

        $bolumler = $this->bolumHaritasi()[$this->fakulte] ?? [];
        if (! in_array($this->bolum, $bolumler, true)) {
            $this->bolum = '';
        }
    }

    /**
     * @return array<string, list<string>>
     */
    private function bolumHaritasi(): array
    {
        return require database_path('data/bolumler.php');
    }

    public function submit(): void
    {
        $this->validate([...$this->rulesForStep(1), ...$this->rulesForStep(2), ...$this->rulesForStep(3)]);

        $user = Auth::user();

        $user->fill([
            'name' => $this->name,
            'unvan' => $this->unvan,
            'universite' => $this->universite,
            'fakulte' => $this->fakulte ?: null,
            'bolum' => $this->bolum ?: null,
            'temel_alan' => $this->temelAlan,
            'orcid' => $this->orcid ?: null,
            'onboarded_at' => now(),
        ])->save();

        // Ücretli paket: ödeme gelene kadar talep olarak yöneticiye düşer;
        // kullanıcı bu sırada ücretsiz planda devam eder.
        $plan = Plan::from($this->paket);

        if ($plan !== Plan::Ucretsiz) {
            app(AbonelikTalepleri::class)->olustur($user, $plan, $this->donem);
        }

        session()->forget(self::SECILEN_PAKET);

        $this->redirectRoute('dashboard', navigate: true);
    }

    /**
     * Validation rules for a given step.
     *
     * @return array<string, mixed>
     */
    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'name' => ['required', 'string', 'max:255'],
                'unvan' => ['required', Rule::in($this->unvanlar)],
            ],
            2 => [
                'universite' => ['required', 'string', 'max:255'],
                'fakulte' => ['nullable', 'string', 'max:255'],
                'bolum' => ['nullable', 'string', 'max:255'],
                'temelAlan' => ['required', Rule::enum(TemelAlan::class)],
                'orcid' => ['nullable', 'string', 'max:255'],
            ],
            3 => [
                'paket' => ['required', Rule::in($this->paketler()->keys()->all())],
                'donem' => ['required', Rule::in(array_keys(AbonelikTalebi::DONEMLER)), function (string $alan, mixed $deger, \Closure $hata): void {
                    if ($deger === 'yillik' && $this->paketler()->get($this->paket)?->yillik_fiyat_kurus === null) {
                        $hata('Bu paketin yıllık seçeneği yok.');
                    }
                }],
            ],
            default => [],
        };
    }

    public function render(): View
    {
        return view('livewire.onboarding', [
            'universiteler' => Universite::query()->orderBy('ad')->pluck('ad'),
            'temelAlanlar' => TemelAlan::secenekler(),
            'bolumler' => $this->bolumHaritasi(),
        ]);
    }
}
