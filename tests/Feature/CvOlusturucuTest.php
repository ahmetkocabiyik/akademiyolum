<?php

use App\Enums\CvBolumu;
use App\Enums\CvSablonu;
use App\Enums\CvYaziTipi;
use App\Enums\Kategori;
use App\Livewire\CvOlusturucu;
use App\Models\CvProfili;
use App\Models\Faaliyet;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->onboarded()->create([
        'name' => 'Ahmet Yılmaz',
        'orcid' => '0000-0002-1825-0097',
        'doktora_tarihi' => '2019-06-15',
    ]);

    $this->makale = Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::Makale,
        'baslik' => 'Anadolu Tasavvuf Geleneği',
        'kaynak' => 'TR Dizin',
        'durum' => 'onaylandi',
    ]);

    $this->kitap = Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::Kitap,
        'baslik' => 'Mânevî Gelişim Üzerine',
        'durum' => 'onaylandi',
    ]);

    actingAs($this->user);
});

test('cv sayfası açılır ve önizleme çizilir', function () {
    $this->get(route('cv-olusturucu'))
        ->assertOk()
        ->assertSee('CV Oluşturucu')
        ->assertSee('Ahmet Yılmaz')
        ->assertSee('Anadolu Tasavvuf Geleneği');
});

test('ilk açılışta cv akademik profilden doldurulur', function () {
    Livewire::test(CvOlusturucu::class)
        ->assertSet('ad', 'Ahmet Yılmaz')
        ->assertSet('kurum', 'Mersin Üniversitesi')
        ->assertSet('eposta', $this->user->email)
        ->assertSet('web', '0000-0002-1825-0097');

    $profil = $this->user->cvProfili()->sole();

    // Doktora tarihi biliniyorsa eğitim satırı taslak olarak açılır.
    expect($profil->egitimler)->toHaveCount(1)
        ->and($profil->egitimler[0]['derece'])->toBe('Doktora')
        ->and($profil->egitimler[0]['bitis'])->toBe('2019');
});

test('cv künyesi akademik profilden BAĞIMSIZ: cv düzenlemek profili değiştirmez', function () {
    // Aday CV'sinde "Dr." yazdırmak isteyebilir; bu, yönerge analizinin
    // kadro hesabını değiştirmemeli.
    Livewire::test(CvOlusturucu::class)
        ->set('unvan', 'Dr.')
        ->set('kurum', 'Başka Üniversite');

    expect($this->user->cvProfili()->sole()->unvan)->toBe('Dr.')
        ->and($this->user->fresh()->unvan)->toBe('Dr. Öğr. Üyesi')
        ->and($this->user->fresh()->universite)->toBe('Mersin Üniversitesi');
});

test('alanlar ayrı bir kaydet adımı olmadan saklanır', function () {
    Livewire::test(CvOlusturucu::class)->set('ozet', 'Tasavvuf alanında çalışıyorum.');

    expect($this->user->cvProfili()->sole()->ozet)->toBe('Tasavvuf alanında çalışıyorum.');

    // Sayfa yeniden açıldığında değer yerinde.
    Livewire::test(CvOlusturucu::class)->assertSet('ozet', 'Tasavvuf alanında çalışıyorum.');
});

test('yalnızca onaylı faaliyetler cv listesine girer', function () {
    Faaliyet::factory()->for($this->user)->create([
        'baslik' => 'Beklemedeki yayın',
        'durum' => 'beklemede',
    ]);

    $bilesen = Livewire::test(CvOlusturucu::class);

    expect($bilesen->instance()->faaliyetler()->pluck('baslik')->all())
        ->toContain('Anadolu Tasavvuf Geleneği')
        ->not->toContain('Beklemedeki yayın');

    $bilesen->assertDontSee('Beklemedeki yayın');
});

test('cvden çıkarılan faaliyet silinmez, yalnızca önizlemeden düşer', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->call('faaliyetDegistir', $this->makale->id);

    expect($bilesen->instance()->secilenler()->pluck('id')->all())->toBe([$this->kitap->id])
        ->and($this->user->cvProfili()->sole()->haric_faaliyetler)->toBe([$this->makale->id])
        // Faaliyetin KENDİSİ duruyor: CV'den çıkarmak puanı silmek değil.
        ->and(Faaliyet::query()->whereKey($this->makale->id)->exists())->toBeTrue();

    // Aynı düğme geri alır.
    $bilesen->call('faaliyetDegistir', $this->makale->id);

    expect($bilesen->instance()->secilenler())->toHaveCount(2);
});

test('eğitim, deneyim, beceri ve dil satırları eklenip silinir', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->call('egitimEkle')
        ->call('deneyimEkle')
        ->set('yeniBeceri', 'Tasavvuf')
        ->call('beceriEkle')
        ->set('yeniDil', 'Arapça')
        ->call('dilEkle');

    $profil = $this->user->cvProfili()->sole();

    expect($profil->egitimler)->toHaveCount(2) // taslak + eklenen
        ->and($profil->deneyimler)->toHaveCount(1)
        ->and($profil->beceriler)->toBe(['Tasavvuf'])
        ->and($profil->diller)->toBe([['ad' => 'Arapça', 'seviye' => 3]]);

    $bilesen->call('dilSeviye', 0, 5)->call('beceriSil', 0)->call('deneyimSil', 0);

    $profil->refresh();

    expect($profil->diller[0]['seviye'])->toBe(5)
        ->and($profil->beceriler)->toBe([])
        ->and($profil->deneyimler)->toBe([]);
});

test('aynı beceri iki kez eklenmez', function () {
    Livewire::test(CvOlusturucu::class)
        ->set('yeniBeceri', 'Kelam')->call('beceriEkle')
        ->set('yeniBeceri', 'Kelam')->call('beceriEkle')
        ->assertSet('yeniBeceri', '');

    expect($this->user->cvProfili()->sole()->beceriler)->toBe(['Kelam']);
});

test('dil seviyesi 1-5 aralığının dışına çıkamaz', function () {
    Livewire::test(CvOlusturucu::class)
        ->set('yeniDil', 'İngilizce')->call('dilEkle')
        ->call('dilSeviye', 0, 99);

    expect($this->user->cvProfili()->sole()->diller[0]['seviye'])->toBe(5);
});

test('şablon, renk ve yazı tipi yalnızca tanınan değerleri kabul eder', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->call('sablonSec', 'prestijli')
        ->call('renkSec', CvProfili::RENKLER[2])
        ->call('yaziTipiSec', 'serif');

    $profil = $this->user->cvProfili()->sole();

    expect($profil->sablon)->toBe(CvSablonu::Prestijli)
        ->and($profil->renk)->toBe(CvProfili::RENKLER[2])
        ->and($profil->yazi_tipi)->toBe(CvYaziTipi::Serif);

    // Uydurma değerler sessizce yoksayılır: renk doğrudan style'a yazıldığı
    // için kapalı listeden çıkamaz.
    $bilesen->call('sablonSec', 'yok-boyle')->call('renkSec', 'red; background:url(x)')->call('yaziTipiSec', 'comic');

    $profil->refresh();

    expect($profil->sablon)->toBe(CvSablonu::Prestijli)
        ->and($profil->renk)->toBe(CvProfili::RENKLER[2])
        ->and($profil->yazi_tipi)->toBe(CvYaziTipi::Serif);
});

test('kapatılan bölüm önizlemeden düşer ama verisi durur', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('ozet', 'Gizlenecek biyografi')
        ->assertSee('Gizlenecek biyografi')
        ->call('bolumDegistir', CvBolumu::Ozet->value)
        ->assertDontSee('Gizlenecek biyografi');

    $profil = $this->user->cvProfili()->sole();

    expect($profil->bolumler[CvBolumu::Ozet->value])->toBeFalse()
        // Metin silinmedi: anahtar geri açılınca geri gelmeli.
        ->and($profil->ozet)->toBe('Gizlenecek biyografi');

    $bilesen->call('bolumDegistir', CvBolumu::Ozet->value)->assertSee('Gizlenecek biyografi');
});

test('json dışa aktarımı cvdeki faaliyetleri taşır, çıkarılanları taşımaz', function () {
    $bilesen = Livewire::test(CvOlusturucu::class)
        ->set('ozet', 'Özet metni')
        ->call('faaliyetDegistir', $this->kitap->id);

    $yanit = $bilesen->instance()->jsonIndir();

    ob_start();
    $yanit->sendContent();
    $veri = json_decode((string) ob_get_clean(), true);

    expect($veri['kunye']['ad'])->toBe('Ahmet Yılmaz')
        ->and($veri['kunye']['ozet'])->toBe('Özet metni')
        ->and(collect($veri['faaliyetler'])->pluck('baslik')->all())->toBe(['Anadolu Tasavvuf Geleneği']);
});

test('başka kullanıcının cvsi sızmaz', function () {
    $baskasi = User::factory()->create();
    CvProfili::factory()->for($baskasi)->create(['ozet' => 'gizli biyografi']);

    Livewire::test(CvOlusturucu::class)->assertDontSee('gizli biyografi');
});
