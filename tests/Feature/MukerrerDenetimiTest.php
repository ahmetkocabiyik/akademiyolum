<?php

use App\Livewire\FaaliyetEkle;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Yayin\MukerrerDenetimi;
use Livewire\Livewire;

function denetim(): MukerrerDenetimi
{
    return new MukerrerDenetimi;
}

/**
 * @param  array<string, mixed>  $meta
 */
function kayit(User $kullanici, string $baslik, array $meta = [], string $kategori = 'makale'): Faaliyet
{
    return Faaliyet::factory()->for($kullanici)->create([
        'kategori' => $kategori,
        'baslik' => $baslik,
        'meta' => $meta,
    ]);
}

const UZUN_BASLIK = 'Bir Örnek Makalenin Uzunca Yazılmış Başlığı';

// ─────────────────────────── İZLER ───────────────────────────

test('aynı doi farklı yazımlarla da yakalanıyor', function (string $yazim) {
    $kullanici = User::factory()->create();
    kayit($kullanici, 'Herhangi bir başlık', ['doi' => '10.1234/Ornek.1']);

    $harita = denetim()->harita($kullanici);

    expect(denetim()->eslesme($harita, 'makale', 'Bambaşka bir başlık', ['doi' => $yazim]))->toBe('doi');
})->with([
    '10.1234/ornek.1',
    '10.1234/ORNEK.1',
    'https://doi.org/10.1234/ornek.1',
    'http://dx.doi.org/10.1234/ornek.1',
    'doi: 10.1234/ornek.1',
]);

/**
 * ASIL SEBEP: üç yolun üçü de kendi anahtarına bakıyordu. Crossref'ten
 * eklenen bir makale AVESİS listesinde "yeni" görünüyor ve ikinci kez
 * ekleniyordu; adet koşulları ("en az 3 SCIE makale") onu iki sayıyordu.
 */
test('crossreften eklenen yayın avesis listesinde ekli görünüyor', function () {
    $kullanici = User::factory()->create();
    kayit($kullanici, UZUN_BASLIK, ['doi' => '10.1234/ornek.1', 'kaynak_sistem' => 'crossref']);

    $sebep = denetim()->eslesme(denetim()->harita($kullanici), 'makale', 'Başlık farklı yazılmış olabilir', [
        'avesis_id' => 'abc', 'doi' => '10.1234/ornek.1', 'kaynak_sistem' => 'avesis',
    ]);

    expect($sebep)->toBe('doi');
});

/**
 * DOI yoksa başlık kalıyor: DergiPark arşivinden gelen eski yayınların
 * DOI'si zaten yok, AVESİS'te de yalnız %15'inde var.
 */
test('doi yokken aynı başlık yakalanıyor', function () {
    $kullanici = User::factory()->create();
    kayit($kullanici, UZUN_BASLIK, ['dergipark' => 'deneme', 'dergipark_makale' => '1']);

    $harita = denetim()->harita($kullanici);

    // Büyük/küçük harf, Türkçe harf ve noktalama farkı eşleşmeyi bozmamalı.
    expect(denetim()->eslesme($harita, 'makale', 'BİR ÖRNEK MAKALENİN UZUNCA YAZILMIŞ BAŞLIĞI!', ['avesis_id' => 'x']))
        ->toBe('baslik');
});

/**
 * AYNI ÇALIŞMANIN ÖNCE BİLDİRİSİ SONRA MAKALESİ yayımlanıyor ve ikisi
 * yönergede ayrı ayrı sayılıyor. Başlık izi kategoriye bağlı olmasaydı
 * biri diğerini bastırırdı.
 */
test('aynı başlık farklı kategoride mükerrer sayılmıyor', function () {
    $kullanici = User::factory()->create();
    kayit($kullanici, UZUN_BASLIK, [], 'bildiri');

    expect(denetim()->eslesme(denetim()->harita($kullanici), 'makale', UZUN_BASLIK, []))->toBeNull();
});

/**
 * Kitap bölümlerinde "Giriş", "Anhang", "Sonuç" gibi adlar var ve farklı
 * kitapların bölümleri aynı adı taşıyabiliyor. Kısa başlıkta iz
 * üretilmiyor; kesin bir anahtar (DOI ya da kayıt kimliği) gerekiyor.
 */
test('kısa başlık tek başına mükerrer saydırmıyor', function () {
    $kullanici = User::factory()->create();
    kayit($kullanici, 'Giriş', [], 'kitap');

    $harita = denetim()->harita($kullanici);

    expect(denetim()->eslesme($harita, 'kitap', 'Giriş', []))->toBeNull()
        ->and(denetim()->eslesme($harita, 'kitap', 'Sonuç ve Değerlendirme', []))->toBeNull();
});

test('elle girilmiş faaliyet de mükerreri engelliyor', function () {
    $kullanici = User::factory()->create();
    // Künyesiz, elle girilmiş kayıt.
    kayit($kullanici, UZUN_BASLIK, []);

    expect(denetim()->eslesme(denetim()->harita($kullanici), 'makale', UZUN_BASLIK, ['doi' => '10.1/x']))
        ->toBe('baslik');
});

test('başka adayın kaydı mükerrer saymıyor', function () {
    $baskasi = User::factory()->create();
    kayit($baskasi, UZUN_BASLIK, ['doi' => '10.1234/ornek.1']);

    $ben = User::factory()->create();

    expect(denetim()->eslesme(denetim()->harita($ben), 'makale', UZUN_BASLIK, ['doi' => '10.1234/ornek.1']))
        ->toBeNull();
});

// ─────────────────────────── EKRAN ───────────────────────────

/**
 * Uçtan uca: AVESİS'ten eklenmiş bir yayın, Crossref aramasında DOI
 * üstünden ekli görünmeli ve işaretlense bile ikinci kez yazılmamalı.
 */
test('avesisten eklenen yayın crossref aramasında ekli çıkıyor', function () {
    $kullanici = User::factory()->create(['name' => 'Kasım Binici', 'orcid' => null]);

    kayit($kullanici, 'AVESİS başlığı biraz farklı yazılmış', [
        'avesis_id' => 'abc', 'doi' => '10.1234/ornek.1', 'kaynak_sistem' => 'avesis',
    ]);

    crossrefDonsun([kunye(['DOI' => '10.1234/Ornek.1'])]);

    $bilesen = Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->call('yayinAra')
        ->assertSee('Zaten ekli');

    expect($bilesen->get('bulunanlar')[0]['ekli_sebep'])->toBe('doi');

    $bilesen->set('secilenler', ['10.1234/ornek.1'])->call('yayinlariEkle');

    expect($kullanici->faaliyetler()->count())->toBe(1);
});

/**
 * Tek bir partinin İÇİNDE de mükerrer olabiliyor: AVESİS aynı yayını hem
 * düzgün hem künyesi başlığa yapışmış hâlde listeleyebiliyor. Harita her
 * kayıttan sonra tazelendiği için ikincisi yazılmıyor.
 */
test('aynı parti içindeki mükerrer de yazılmıyor', function () {
    $kullanici = User::factory()->create();

    avesisTaklidi(['Makaleler' => [
        ['id' => uuid(1), 'baslik' => UZUN_BASLIK, 'kunye' => 'Dergi, 2020'],
        ['id' => uuid(2), 'baslik' => UZUN_BASLIK.'!', 'kunye' => 'Dergi, 2020'],
    ]]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'avesis.ktu.edu.tr/kullanici')
        ->call('avesisGetir')
        ->call('avesisTumunuSec')
        ->call('avesistenEkle');

    expect($kullanici->faaliyetler()->count())->toBe(1);
});

/**
 * Mükerrer sebebi ekranda ayırt ediliyor: "baslik" bir TAHMİN, aday
 * neden işaretleyemediğini anlamalı.
 */
test('başlıktan gelen eşleşme ayrı etiketle gösteriliyor', function () {
    $kullanici = User::factory()->create(['name' => 'Kasım Binici', 'orcid' => null]);
    kayit($kullanici, 'Bir Örnek Makale Başlığı Yeterince Uzun', []);

    crossrefDonsun([kunye(['title' => ['Bir Örnek Makale Başlığı Yeterince Uzun'], 'DOI' => '10.9/yeni'])]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->call('yayinAra')
        ->assertSee('Aynı başlık zaten var')
        ->assertDontSee('>Zaten ekli<', escape: false);
});
