<?php

use App\Livewire\Dashboard;
use App\Livewire\Onboarding;
use App\Livewire\YayinEkle;
use App\Livewire\Yayinlar;
use App\Livewire\YonergeAnalizi;
use App\Livewire\YzDanisman;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('onboarding', Onboarding::class)->name('onboarding');
});

Route::middleware(['auth', 'verified', 'onboarded'])->group(function () {
    Route::livewire('dashboard', Dashboard::class)->name('dashboard');

    Route::livewire('yayinlar', Yayinlar::class)->name('yayinlar');
    Route::livewire('yayinlar/ekle', YayinEkle::class)->name('yayinlar.ekle');
    Route::livewire('yayinlar/{faaliyet}/duzenle', YayinEkle::class)->name('yayinlar.duzenle');

    Route::view('toplumsal-katki', 'modules.placeholder', [
        'heading' => 'Toplumsal Katkı',
        'subheading' => 'Topluma yönelik faaliyet kayıtları',
        'phase' => 'Faz 1',
    ])->name('toplumsal-katki');

    Route::livewire('yonerge-analizi', YonergeAnalizi::class)->name('yonerge-analizi');

    Route::livewire('yz-danisman', YzDanisman::class)->name('yz-danisman');

    Route::view('juri-analizi', 'modules.placeholder', [
        'heading' => 'YZ Jüri Analizi',
        'subheading' => 'Jüri gözünden değerlendirme raporu',
        'phase' => 'Faz 3',
    ])->name('juri-analizi');

    Route::view('cv-olusturucu', 'modules.placeholder', [
        'heading' => 'CV Oluşturucu',
        'subheading' => 'Akademik CV üretimi ve dışa aktarım',
        'phase' => 'Faz 5',
    ])->name('cv-olusturucu');

    Route::view('cikti-yonetimi', 'modules.placeholder', [
        'heading' => 'Çıktı Yönetimi',
        'subheading' => 'Rapor şablonları ve PDF çıktıları',
        'phase' => 'Faz 5',
    ])->name('cikti-yonetimi');
});

require __DIR__.'/settings.php';
