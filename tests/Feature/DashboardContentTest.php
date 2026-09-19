<?php

use App\Enums\Kategori;
use App\Livewire\Dashboard;
use App\Models\BeyanOnayi;
use App\Models\Faaliyet;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\Durum;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Scoring\Sart\SartSonucu;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

/**
 * Dashboard artık Yönerge Analizi ile AYNI motoru kullanıyor: kullanıcının
 * kendi üniversitesinin şart ağacı değerlendirilir. Yönergesi girilmemiş
 * kullanıcıya tahmini puan gösterilmez.
 */
function dashboardDeposu(int $baraj = 50): SartDeposu
{
    return new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'test-dr-ilahiyat',
            'universite' => 'Test Üniversitesi',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => 'ilahiyat',
            'birim' => null,
            'cetvel' => 'test-cetvel',
            'notlar' => '',
            'sart' => ['tip' => 've', 'aciklama' => 'Asgari şartlar', 'cocuklar' => [
                ['tip' => 'puan', 'rol' => 'toplam', 'aciklama' => "Toplam en az {$baraj} puan",
                    'maddeler' => ['*'], 'min_puan' => $baraj],
            ]],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => [
            'M1' => ['baslik' => 'TR Dizin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
            'T1' => ['baslik' => 'Tez yayını', 'kategori' => 'tez_yayini', 'puan' => 5],
        ]]],
    );
}

test('dashboard faaliyetleri ve kategori dağılımını gösterir', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu());

    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);

    Faaliyet::factory()->for($user)->create([
        'kategori' => Kategori::Makale,
        'baslik' => 'Tasavvufi Düşüncenin Öncüleri',
        'kaynak' => 'TR Dizin',
        'durum' => 'onaylandi',
    ]);
    Faaliyet::factory()->for($user)->kategori(Kategori::TezYayini)->create(['durum' => 'onaylandi']);

    actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertOk()
        ->assertSee('Tasavvufi Düşüncenin Öncüleri')
        ->assertSee('Kategori Puan Dağılımı');
});

test('sadece onaylı faaliyetler puana katılır', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu());

    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);

    Faaliyet::factory()->for($user)->create(['kaynak' => 'TR Dizin', 'durum' => 'onaylandi']);
    Faaliyet::factory()->for($user)->beklemede()->create(['kaynak' => 'TR Dizin']);

    actingAs($user);

    // Onaylı tek makale → M1 = 10 puan. Bekleyen sayılmaz.
    expect(Livewire::test(Dashboard::class)->instance()->toplam())->toBe(10);
});

test('puan faaliyette saklanmaz, kendi üniversitesinin cetvelinden hesaplanır', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu());

    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);

    // puan sütunu kasten yanlış: motor cetvelden hesaplamalı.
    Faaliyet::factory()->for($user)->create([
        'kaynak' => 'TR Dizin', 'durum' => 'onaylandi', 'puan' => 9999,
    ]);

    actingAs($user);

    expect(Livewire::test(Dashboard::class)->instance()->toplam())->toBe(10);
});

test('yönergesi girilmemiş üniversitede puan gösterilmez', function () {
    Universite::factory()->create(['ad' => 'Verisi Olmayan Üni']);
    app()->instance(SartDeposu::class, dashboardDeposu());

    $user = User::factory()->onboarded()->create(['universite' => 'Verisi Olmayan Üni', 'unvan' => 'Arş. Gör.']);
    Faaliyet::factory()->for($user)->create(['kaynak' => 'TR Dizin', 'durum' => 'onaylandi']);

    actingAs($user);

    $bilesen = Livewire::test(Dashboard::class);

    expect($bilesen->instance()->esik())->toBeNull()
        ->and($bilesen->instance()->baraj())->toBeNull()
        // Tahmini baraj üretilmez, kullanıcıya durum açıkça söylenir.
        ->and($bilesen->instance()->toplam())->toBe(0);

    $bilesen->assertSee('yönergesi henüz girilmedi');
});

test('bildirimler eşik sonucundan türer', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu(baraj: 100));

    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);
    Faaliyet::factory()->for($user)->create(['kaynak' => 'TR Dizin', 'durum' => 'onaylandi']);

    actingAs($user);

    $bildirimler = Livewire::test(Dashboard::class)->instance()->bildirimler();
    $basliklar = array_column($bildirimler, 'baslik');

    // 10/100 → hem karşılanmayan koşul hem kalan puan bildirimi
    expect($basliklar)->toContain('Toplam en az 100 puan')
        ->and(implode(' ', $basliklar))->toContain('90 puan kaldı');
});

test('boş dashboard faaliyet uyarısı gösterir', function () {
    app()->instance(SartDeposu::class, dashboardDeposu());
    actingAs(User::factory()->onboarded()->create(['universite' => 'Verisi Olmayan Üni', 'unvan' => 'Arş. Gör.']));

    Livewire::test(Dashboard::class)
        ->assertOk()
        ->assertSee('Henüz faaliyet eklenmemiş.');
});

test('Yönerge Analizi\'nde işaretlenen beyan dashboard\'da da geçerli', function () {
    // İki ekran aynı eşiği değerlendiriyor; biri "Eksik Bilgi", öteki "uygun"
    // deseydi aday hangisine inanacağını bilemezdi.
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);

    $depo = new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'test-dr-ilahiyat',
            'universite' => 'Test Üniversitesi',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => 'ilahiyat',
            'birim' => null,
            'cetvel' => 'test-cetvel',
            'notlar' => '',
            'sart' => ['tip' => 've', 'aciklama' => 'Asgari şartlar', 'cocuklar' => [
                ['tip' => 'beyan', 'aciklama' => 'Doktora sonrası altı ay yurt dışında bulunmak', 'madde' => 'md. 5'],
            ]],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => []]],
    );

    app()->instance(SartDeposu::class, $depo);

    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.']);
    actingAs($user);

    expect(Livewire::test(Dashboard::class)->instance()->sonuc()->durum)->toBe(Durum::Belirsiz);

    BeyanOnayi::query()->create([
        'user_id' => $user->id,
        // Enjekte edilen eşik verisinde anahtara alan EKLENMEZ; üretim yolunda
        // `esikler()` `-{alan}` ekliyor, burada olduğu gibi kalıyor.
        'esik_anahtari' => 'test-dr-ilahiyat',
        'kosul_anahtari' => SartSonucu::beyanAnahtariUret('Doktora sonrası altı ay yurt dışında bulunmak', 'md. 5'),
    ]);

    expect(Livewire::test(Dashboard::class)->instance()->sonuc()->durum)->toBe(Durum::Saglandi);
});

test('dashboard onay bekleyen durumu Yönerge Analizi ile aynı adla anıyor', function () {
    // Durumun adı iki ekranda farklı olursa aday aynı sonucu iki şey sanır.
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);

    app()->instance(SartDeposu::class, new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'test-dr-ilahiyat',
            'universite' => 'Test Üniversitesi',
            'kadro' => 'dr_ogr_uyesi',
            'alan' => 'ilahiyat',
            'birim' => null,
            'cetvel' => 'test-cetvel',
            'notlar' => '',
            'sart' => ['tip' => 've', 'aciklama' => 'Asgari şartlar', 'cocuklar' => [
                ['tip' => 'beyan', 'aciklama' => 'Belge ile teyit edilecek koşul'],
            ]],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => []]],
    ));

    actingAs(User::factory()->onboarded()->create([
        'universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.',
    ]));

    Livewire::test(Dashboard::class)
        ->assertSee('Onay Gerek')
        ->assertDontSee('Eksik Bilgi');
});

test('dashboard koşulları sağlanan durumu "Uygun" diye anıyor', function () {
    // Yönerge Analizi ile aynı sözcük; eskiden burada "Karşılandı" yazıyordu.
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu(baraj: 5));

    $user = User::factory()->onboarded()->create([
        'universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.',
    ]);
    Faaliyet::factory()->for($user)->create([
        'kategori' => Kategori::Makale, 'kaynak' => 'TR Dizin', 'durum' => 'onaylandi',
    ]);

    actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertSee('Uygun')
        ->assertDontSee('Karşılandı');
});

/**
 * ÖLÇÜM ANİMASYONLARININ MARKUP SÖZLEŞMESİ.
 *
 * Gauge yayı ile baraj çubuklarının hareketi CSS'te (`.olcek-yay`,
 * `.baraj-cubuk` + `@starting-style`), sayıların hareketi Alpine'daki `sayac`
 * bileşeninde. İkisi de şablondaki KANCALARA bağlı: sınıf adı, `--olcek-tam`
 * değişkeni ya da `x-data` düşerse animasyon sessizce kaybolur, hiçbir test
 * kırılmaz ve kimse fark etmez. Bu test o kancaları donduruyor.
 *
 * `role="progressbar"` aynı satırda duruyor çünkü çubuk yalnız renkle
 * konuşuyordu; ekran okuyucu için değer artık markup'ta.
 */
test('dashboard ölçümleri animasyon ve erişilebilirlik kancalarını taşıyor', function () {
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu(baraj: 50));

    $user = User::factory()->onboarded()->create([
        'universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.',
    ]);
    Faaliyet::factory()->for($user)->create([
        'kategori' => Kategori::Makale, 'kaynak' => 'TR Dizin', 'durum' => 'onaylandi',
    ]);

    actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertOk()
        // Gauge: sınıf + yay uzunluğu değişkeni (@starting-style bunu okuyor).
        ->assertSeeHtml('class="olcek-yay"')
        ->assertSeeHtml('--olcek-tam: 232.5')
        // Baraj çubuğu: sınıf, sıra gecikmesi ve progressbar rolü.
        ->assertSeeHtml('class="baraj-cubuk h-full rounded-full"')
        ->assertSeeHtml('--cubuk-gecikme: 0ms')
        ->assertSeeHtml('role="progressbar"')
        ->assertSeeHtml('aria-valuemax="100"')
        // Sayaç: toplam puan, faaliyet sayısı, eksik koşul ve gauge metni.
        ->assertSeeHtml('x-data="sayac"');
});

test('sayaç hedefi sunucudan gelen metinde duruyor, x-text ile değil', function () {
    // JavaScript çalışmazsa doğru sayı yine ekranda olmalı; animasyon metni
    // yalnızca geçici olarak değiştiriyor. Bu yüzden şablonda x-text YOK.
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);
    app()->instance(SartDeposu::class, dashboardDeposu(baraj: 50));

    $user = User::factory()->onboarded()->create([
        'universite' => 'Test Üniversitesi', 'unvan' => 'Arş. Gör.',
    ]);
    Faaliyet::factory()->for($user)->create([
        'kategori' => Kategori::Makale, 'kaynak' => 'TR Dizin', 'durum' => 'onaylandi',
    ]);

    actingAs($user);

    Livewire::test(Dashboard::class)
        ->assertSeeHtml('x-data="sayac">10</span>')
        // Eşittirle arıyoruz: Flux'ın `data-flux-text` özniteliği çıplak
        // "x-text" aramasına takılıyor.
        ->assertDontSeeHtml('x-text=');
});
