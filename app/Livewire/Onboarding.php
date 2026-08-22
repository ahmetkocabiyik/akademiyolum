<?php

namespace App\Livewire;

use App\Enums\TemelAlan;
use App\Models\Universite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Kurulum')]
#[Layout('layouts.auth')]
class Onboarding extends Component
{
    public int $step = 1;

    public string $unvan = '';

    public string $name = '';

    public string $universite = '';

    public string $fakulte = '';

    public string $bolum = '';

    public string $temelAlan = 'sosyal';

    public string $orcid = '';

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
    }

    public function next(): void
    {
        $this->validate($this->rulesForStep($this->step));

        $this->step = min($this->step + 1, 2);
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
        $this->validate($this->rulesForStep(2));

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
            default => [],
        };
    }

    public function render()
    {
        return view('livewire.onboarding', [
            'universiteler' => Universite::query()->orderBy('ad')->pluck('ad'),
            'temelAlanlar' => TemelAlan::secenekler(),
            'bolumler' => $this->bolumHaritasi(),
        ]);
    }
}
