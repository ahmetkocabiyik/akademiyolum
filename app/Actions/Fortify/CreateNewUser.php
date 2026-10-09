<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Enums\Plan;
use App\Livewire\Onboarding;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        // Tanıtım sayfasında seçilen paket: kurulumun paket adımında önceden
        // seçili gelir. Kullanıcı satırına değil oturuma yazılıyor; seçim
        // ancak kurulumda talebe dönüşüyor.
        if (Plan::tryFrom($input['paket'] ?? '') !== null) {
            session()->put(Onboarding::SECILEN_PAKET, $input['paket']);
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
    }
}
