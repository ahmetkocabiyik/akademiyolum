<?php

namespace App\Livewire;

use App\Models\Universite;
use App\Models\Yonerge;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
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

    public string $alan = '';

    public string $yonergeId = '';

    public string $orcid = '';

    /**
     * Available academic titles.
     *
     * @var list<string>
     */
    public array $unvanlar = [
        'Arş. Gör.', 'Öğr. Gör.', 'Dr. Öğr. Üyesi', 'Doç. Dr.', 'Prof. Dr.',
    ];

    /**
     * Seçilebilir yönergeler (ÜAK genel önce, sonra üniversiteler).
     *
     * @return Collection<int, Yonerge>
     */
    #[Computed]
    public function yonergeler(): Collection
    {
        return Yonerge::query()
            ->orderByRaw('universite_id is not null')
            ->orderBy('ad')
            ->get();
    }

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

        $this->step = min($this->step + 1, 3);
    }

    public function back(): void
    {
        $this->step = max($this->step - 1, 1);
    }

    public function submit(): void
    {
        $this->validate($this->rulesForStep(3));

        $user = Auth::user();
        $yonerge = Yonerge::query()->findOrFail($this->yonergeId);

        $user->fill([
            'name' => $this->name,
            'unvan' => $this->unvan,
            'universite' => $this->universite,
            'fakulte' => $this->fakulte,
            'bolum' => $this->bolum,
            'alan' => $this->alan,
            'yonerge' => $yonerge->ad,
            'yonerge_id' => $yonerge->id,
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
                'fakulte' => ['required', 'string', 'max:255'],
                'bolum' => ['nullable', 'string', 'max:255'],
                'alan' => ['required', 'string', 'max:255'],
            ],
            3 => [
                'yonergeId' => ['required', Rule::exists('yonergeler', 'id')],
                'orcid' => ['nullable', 'string', 'max:255'],
            ],
            default => [],
        };
    }

    public function render()
    {
        return view('livewire.onboarding', [
            'universiteler' => Universite::query()->orderBy('ad')->pluck('ad'),
        ]);
    }
}
