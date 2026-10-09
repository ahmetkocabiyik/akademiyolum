<?php

namespace App\Livewire\Settings;

use App\Enums\Plan;
use App\Models\Abonelik as AbonelikModeli;
use App\Models\AbonelikTalebi;
use App\Models\Paket;
use App\Services\Abonelik\AbonelikTalepleri;
use App\Services\Abonelik\PaketKatalogu;
use Closure;
use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Ayarlar → Abonelik: kullanıcının planı, bekleyen talebi, yükseltme ya da
 * yenileme talebi ve abonelik geçmişi.
 *
 * Online ödeme yok: talep yöneticiye düşer, ödeme alınınca abonelik
 * tanımlanır ({@see AbonelikTalepleri}). Ücretsize geçiş için talep yok;
 * abonelik süresi dolunca kullanıcı kendiliğinden ücretsiz plana döner.
 *
 * @property-read AbonelikModeli|null $aktif
 * @property-read AbonelikTalebi|null $bekleyen
 * @property-read Collection<string, Paket> $paketler
 * @property-read Collection<int, AbonelikModeli> $gecmis
 */
#[Title('Abonelik')]
class Abonelik extends Component
{
    public string $paket = '';

    public string $donem = 'aylik';

    public function mount(): void
    {
        // Varsayılan seçim: aktif paket (yenileme), yoksa öne çıkan paket.
        $this->paket = $this->aktif?->plan->value
            ?? $this->paketler->first(fn (Paket $p): bool => $p->one_cikan)?->plan->value
            ?? (string) $this->paketler->keys()->first();
    }

    #[Computed]
    public function aktif(): ?AbonelikModeli
    {
        return Auth::user()->aktifAbonelik();
    }

    #[Computed]
    public function bekleyen(): ?AbonelikTalebi
    {
        return Auth::user()->bekleyenTalep();
    }

    /**
     * Talep edilebilecek paketler: satıştaki ücretliler.
     *
     * @return Collection<string, Paket>
     */
    #[Computed]
    public function paketler(): Collection
    {
        return app(PaketKatalogu::class)->satistakiler()->filter(fn (Paket $p): bool => $p->plan !== Plan::Ucretsiz);
    }

    /**
     * @return Collection<int, AbonelikModeli>
     */
    #[Computed]
    public function gecmis(): Collection
    {
        return Auth::user()->abonelikler()->latest('baslangic')->latest('id')->get();
    }

    public function updatedPaket(): void
    {
        if ($this->paketler->get($this->paket)?->yillik_fiyat_kurus === null) {
            $this->donem = 'aylik';
        }
    }

    public function talepEt(): void
    {
        $this->validate([
            'paket' => ['required', Rule::in($this->paketler->keys()->all())],
            'donem' => ['required', Rule::in(array_keys(AbonelikTalebi::DONEMLER)), function (string $alan, mixed $deger, Closure $hata): void {
                if ($deger === 'yillik' && $this->paketler->get($this->paket)?->yillik_fiyat_kurus === null) {
                    $hata('Bu paketin yıllık seçeneği yok.');
                }
            }],
        ]);

        app(AbonelikTalepleri::class)->olustur(Auth::user(), Plan::from($this->paket), $this->donem);

        unset($this->bekleyen);
        Flux::toast(variant: 'success', text: 'Talebiniz alındı. Ödeme bilgilerini e-postayla göndereceğiz.');
    }

    public function geriCek(): void
    {
        if ($this->bekleyen !== null) {
            app(AbonelikTalepleri::class)->geriCek($this->bekleyen, Auth::user());
        }

        unset($this->bekleyen);
        Flux::toast(text: 'Talebiniz geri çekildi.');
    }

    public function render(): View
    {
        return view('livewire.settings.abonelik');
    }
}
