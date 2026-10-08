<?php

use App\Http\Controllers\CvFotoController;
use App\Http\Controllers\TaklitController;
use App\Http\Controllers\YonergeKaynakController;
use App\Livewire\Admin;
use App\Livewire\CiktiYonetimi;
use App\Livewire\CvOlusturucu;
use App\Livewire\Dashboard;
use App\Livewire\FaaliyetEkle;
use App\Livewire\Faaliyetler;
use App\Livewire\JuriAnalizi;
use App\Livewire\Onboarding;
use App\Livewire\YonergeAnalizi;
use App\Livewire\YzDanisman;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('onboarding', Onboarding::class)->name('onboarding');
});

Route::middleware(['auth', 'verified', 'onboarded'])->group(function () {
    Route::livewire('dashboard', Dashboard::class)->name('dashboard');

    Route::livewire('faaliyetler', Faaliyetler::class)->name('faaliyetler');
    Route::livewire('faaliyetler/ekle', FaaliyetEkle::class)->name('faaliyetler.ekle');
    Route::livewire('faaliyetler/{faaliyet}/duzenle', FaaliyetEkle::class)->name('faaliyetler.duzenle');

    // Toplumsal Katkı ayrı bir bölüm değil: Faaliyetler içinde bir kategori
    // (App\Enums\Kategori::ToplumsalKatki). Eski bağlantılar oraya yönlendirilir.
    Route::redirect('toplumsal-katki', 'faaliyetler');

    Route::livewire('yonerge-analizi', YonergeAnalizi::class)->name('yonerge-analizi');

    // Analizin dayandığı kaynak belge. Yönerge PDF'leri public/ dışında
    // duruyor; kimliği doğrulanmış adaya bu rota üzerinden akıtılır.
    Route::get('yonerge-analizi/kaynak/{universite}', YonergeKaynakController::class)
        ->name('yonerge-analizi.kaynak');

    Route::livewire('yz-danisman', YzDanisman::class)->name('yz-danisman');

    Route::livewire('juri-analizi', JuriAnalizi::class)->name('juri-analizi');

    Route::livewire('cv-olusturucu', CvOlusturucu::class)->name('cv-olusturucu');

    // CV fotoğrafı public/ dışında; yalnızca sahibine bu rotadan akıtılır.
    Route::get('cv-olusturucu/foto', CvFotoController::class)->name('cv-olusturucu.foto');

    Route::livewire('cikti-yonetimi', CiktiYonetimi::class)->name('cikti-yonetimi');
});

// ── YÖNETİM PANELİ ──
// Yetkisi olmayana 404 (super.admin). Onboarding şartı yok: yönetici
// uygulamayı akademisyen olarak kullanmıyor olabilir.
Route::middleware(['auth', 'verified', 'super.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::livewire('/', Admin\Pano::class)->name('pano');
    Route::livewire('kullanicilar', Admin\Kullanicilar::class)->name('kullanicilar');
    Route::livewire('kullanicilar/{user}', Admin\KullaniciDetay::class)->name('kullanici');
    Route::livewire('abonelikler', Admin\Abonelikler::class)->name('abonelikler');
    Route::livewire('paketler', Admin\Paketler::class)->name('paketler');
    Route::livewire('islemler', Admin\IslemKaydi::class)->name('islemler');
    Route::livewire('eposta-sablonlari', Admin\EpostaSablonlari::class)->name('eposta-sablonlari');
    Route::livewire('eposta-sablonlari/{tur}', Admin\EpostaSablonuDuzenle::class)->name('eposta-sablonu');

    Route::post('kullanicilar/{user}/olarak-gor', [TaklitController::class, 'baslat'])->name('taklit.baslat');
});

// Taklit sürerken oturum taklit edilen kullanıcıda; bu yüzden yalnızca
// `auth` — yöneticinin kimliği oturumdaki anahtardan doğrulanıyor.
Route::middleware('auth')->post('taklit/bitir', [TaklitController::class, 'bitir'])->name('taklit.bitir');

require __DIR__.'/settings.php';
