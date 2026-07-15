<?php

namespace App\Livewire\Settings;

use App\Concerns\ProfileValidationRules;
use App\Enums\TemelAlan;
use App\Models\Universite;
use Flux\Flux;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Profil ayarları')]
class Profile extends Component
{
    use ProfileValidationRules;

    public string $name = '';

    public string $email = '';

    public string $universite = '';

    public string $fakulte = '';

    public string $bolum = '';

    public string $temelAlan = 'sosyal';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->universite = $user->universite ?? '';
        $this->fakulte = $user->fakulte ?? '';
        $this->bolum = $user->bolum ?? '';
        $this->temelAlan = $user->temel_alan?->value ?? 'sosyal';
    }

    public function updatedTemelAlan(): void
    {
        $this->kaskadiSagla();
    }

    public function updatedFakulte(): void
    {
        $this->kaskadiSagla();
    }

    /**
     * Kaskad tutarlılık: temel alan → fakülte → bölüm.
     * Bir üst seçim değişince alt seçim listede yoksa sıfırlanır.
     */
    private function kaskadiSagla(): void
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

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $this->validate($this->profileRules($user->id) + [
            'universite' => ['nullable', 'string', 'max:255'],
            'fakulte' => ['nullable', 'string', 'max:255'],
            'bolum' => ['nullable', 'string', 'max:255'],
            'temelAlan' => ['required', Rule::enum(TemelAlan::class)],
        ]);

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'universite' => $this->universite ?: null,
            'fakulte' => $this->fakulte ?: null,
            'bolum' => $this->bolum ?: null,
            'temel_alan' => $this->temelAlan,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: __('A new verification link has been sent to your email address.'));
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        $user = Auth::user();

        return $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        $user = Auth::user();

        return ! $user instanceof MustVerifyEmail || $user->hasVerifiedEmail();
    }

    public function render()
    {
        return view('livewire.settings.profile', [
            'universiteler' => Universite::query()->orderBy('ad')->pluck('ad'),
            'temelAlanlar' => TemelAlan::secenekler(),
            'bolumler' => $this->bolumHaritasi(),
        ]);
    }
}
