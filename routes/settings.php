<?php

use App\Http\Controllers\ProfilFotoController;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Security;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::livewire('settings/profile', Profile::class)->name('profile.edit');

    // Profil fotoğrafı public/ dışında; yalnızca sahibine bu rotadan akıtılır.
    Route::get('settings/profil-foto', ProfilFotoController::class)->name('profil.foto');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('settings/security', Security::class)
        ->middleware([
            'password.confirm',
        ])
        ->name('security.edit');
});

Route::get('.well-known/passkey-endpoints', function () {
    return response()->json([
        'enroll' => route('security.edit'),
        'manage' => route('security.edit'),
    ]);
})->name('well-known.passkeys');
