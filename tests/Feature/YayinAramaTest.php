<?php

use App\Livewire\FaaliyetEkle;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Yayin\AramaException;
use App\Services\Yayin\CrossrefArama;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;
use Livewire\Livewire;

/**
 * Crossref künyesi taklidi.
 *
 * @param  array<string, mixed>  $ustyaz
 * @return array<string, mixed>
 */
function kunye(array $ustyaz = []): array
{
    return array_replace([
        'DOI' => '10.1234/ornek.1',
        'type' => 'journal-article',
        'title' => ['Bir Örnek Makale'],
        'container-title' => ['Bilgi Dünyası'],
        'ISSN' => ['2148-354X'],
        'issued' => ['date-parts' => [[2024, 5, 10]]],
        'author' => [
            ['given' => 'Kasım', 'family' => 'BİNİCİ', 'sequence' => 'first'],
            ['given' => 'Ayşe', 'family' => 'Kurt', 'sequence' => 'additional'],
        ],
    ], $ustyaz);
}

/**
 * @param  list<array<string, mixed>>  $kayitlar
 */
function crossrefDonsun(array $kayitlar): void
{
    Http::fake([
        'api.crossref.org/*' => Http::response(['message' => ['items' => $kayitlar]]),
    ]);
}

function arama(): CrossrefArama
{
    return new CrossrefArama(taban: 'https://api.crossref.org', posta: 'test@akademiyolum.test');
}

test('künye faaliyet alanlarına çevriliyor', function () {
    crossrefDonsun([kunye()]);

    $yayin = arama()->ara('Kasım Binici')[0];

    expect($yayin['doi'])->toBe('10.1234/ornek.1')
        ->and($yayin['baslik'])->toBe('Bir Örnek Makale')
        ->and($yayin['dergi'])->toBe('Bilgi Dünyası')
        ->and($yayin['yil'])->toBe(2024)
        ->and($yayin['tarih'])->toBe('2024-05-10')
        ->and($yayin['yazarlar'])->toBe(['Kasım BİNİCİ', 'Ayşe Kurt'])
        ->and($yayin['kategori'])->toBe('makale');
});

/**
 * Künyelerde "BİNİCİ" de "Binici" de geçiyor. mb_strtolower Türkçe "İ"yi
 * i + birleşen noktaya çeviriyor ve iki yazım eşleşmiyor; sıra bulunamazsa
 * rol boş kalır ve aday kendi sırasını elle aramak zorunda kalır.
 */
test('türkçe harfli ad künyedeki yazımı yakalıyor', function () {
    crossrefDonsun([kunye()]);

    expect(arama()->ara('Kasım Binici')[0]['sira'])->toBe(1)
        // Soyadı önce yazılmış künye de aynı kişiyi göstermeli.
        ->and(arama()->ara('BİNİCİ Kasım')[0]['sira'])->toBe(1)
        // Kısaltılmış ad tam eşleşmiyor: sıra uydurulmuyor ama yayın da
        // elenmiyor, çünkü soyadı tutuyor.
        ->and(arama()->ara('K. Binici')[0]['sira'])->toBeNull();
});

/**
 * AD SORGUSUNUN GÜRÜLTÜSÜ.
 *
 * Crossref ad sorgusunu alakaya göre sıralıyor ve adın hiçbir yazarda
 * geçmediği yayınları da döndürüyor — gerçek bir sorguda 30 sonucun yarısı
 * başka kişilerindi. Aday onları teker teker eleyemez.
 */
test('adla kelime paylaşmayan yayın ad sorgusundan elenir', function () {
    crossrefDonsun([
        kunye(['DOI' => '10.1/baskasi', 'author' => [
            ['given' => 'Friedrich August', 'family' => 'Hayek'],
        ]]),
        kunye(['DOI' => '10.1/benim']),
    ]);

    expect(array_column(arama()->ara('Kasım Binici'), 'doi'))->toBe(['10.1/benim']);
});

/**
 * ORCID süzgecinden gelen yayın ELENMEZ: künyede adı hiç yazmamış olabilir
 * (yalnız ORCID gönderilmiş ya da soyadı değişmiş) ama yayın yine onun.
 */
test('orcid sonucu ad tutmasa da elenmiyor', function () {
    Http::fake([
        'api.crossref.org/works?*orcid*' => Http::response(['message' => ['items' => [
            kunye(['DOI' => '10.1/orcid', 'author' => [['name' => 'Anonim Kurul']]]),
        ]]]),
        'api.crossref.org/*' => Http::response(['message' => ['items' => []]]),
    ]);

    $yayinlar = arama()->ara('Kasım Binici', '0000-0002-8071-9693');

    expect($yayinlar)->toHaveCount(1)
        ->and($yayinlar[0]['sira'])->toBeNull();
});

/**
 * Sıra: önce ORCID eşleşmeleri, sonra adı yazarlar arasında tam geçenler,
 * sonra kalanlar. Yıla göre tek sıralama gürültüyü kesinlerin arasına
 * serpiştiriyordu.
 */
test('kesin sonuçlar listenin başında', function () {
    Http::fake([
        'api.crossref.org/works?*orcid*' => Http::response(['message' => ['items' => [
            kunye(['DOI' => '10.1/orcid-eski', 'issued' => ['date-parts' => [[2001]]]]),
        ]]]),
        'api.crossref.org/*' => Http::response(['message' => ['items' => [
            kunye(['DOI' => '10.1/ad-yeni', 'issued' => ['date-parts' => [[2026]]]]),
            kunye(['DOI' => '10.1/soyad-yeni', 'issued' => ['date-parts' => [[2025]]], 'author' => [
                ['given' => 'K.', 'family' => 'Binici'],
            ]]),
        ]]]),
    ]);

    expect(array_column(arama()->ara('Kasım Binici', '0000-0002-8071-9693'), 'doi'))
        ->toBe(['10.1/orcid-eski', '10.1/ad-yeni', '10.1/soyad-yeni']);
});

test('cetvelde karşılığı olmayan yayın türü atlanıyor', function () {
    crossrefDonsun([
        kunye(['DOI' => '10.1/a', 'type' => 'posted-content']),
        kunye(['DOI' => '10.1/b', 'type' => 'dataset']),
        kunye(['DOI' => '10.1/c', 'type' => 'proceedings-article']),
        kunye(['DOI' => '10.1/d', 'type' => 'book-chapter']),
    ]);

    $kategoriler = array_column(arama()->ara('Kasım Binici'), 'kategori', 'doi');

    expect($kategoriler)->toBe(['10.1/c' => 'bildiri', '10.1/d' => 'kitap']);
});

/**
 * Erken erişimde künye ileri tarihli olabiliyor. Dönem koşulları
 * "doçentlikten sonra" gibi kıyaslar yapıyor; olmamış bir tarih sessizce
 * yanlış sonuç üretir, bu yüzden tarih boş bırakılıp yıl gösteriliyor.
 */
test('gelecek tarihli künye tarihsiz geliyor', function () {
    $gelecek = (int) now()->addYears(2)->format('Y');

    crossrefDonsun([kunye(['issued' => ['date-parts' => [[$gelecek, 3, 1]]]])]);

    $yayin = arama()->ara('Kasım Binici')[0];

    expect($yayin['tarih'])->toBeNull()
        ->and($yayin['yil'])->toBe($gelecek);
});

/**
 * İki sorgunun iki ayrı zayıflığı var: ORCID kesin ama eksik, ad geniş ama
 * kirli. Aynı yayın ikisinden de gelirse KESİN olan kazanmalı — yoksa aday
 * kendi yayınını "belki sizindir" diye görür.
 */
test('orcid ve ad sonuçları birleşiyor, kesinlik korunuyor', function () {
    Http::fake([
        'api.crossref.org/works?*orcid*' => Http::response(['message' => ['items' => [
            kunye(['DOI' => '10.1/ortak']),
        ]]]),
        'api.crossref.org/*' => Http::response(['message' => ['items' => [
            kunye(['DOI' => '10.1/ortak']),
            kunye(['DOI' => '10.1/yalniz-ad', 'issued' => ['date-parts' => [[2020]]]]),
        ]]]),
    ]);

    $yayinlar = array_column(arama()->ara('Kasım Binici', '0000-0002-8071-9693'), null, 'doi');

    expect($yayinlar)->toHaveCount(2)
        ->and($yayinlar['10.1/ortak']['kesin'])->toBeTrue()
        ->and($yayinlar['10.1/yalniz-ad']['kesin'])->toBeFalse()
        // Yıl azalan: 2024 önce.
        ->and(array_key_first($yayinlar))->toBe('10.1/ortak');
});

test('ulaşılamayan servis adaya okunur mesaj veriyor', function () {
    Sleep::fake();
    Http::fake(['api.crossref.org/*' => Http::response('', 503)]);

    arama()->ara('Kasım Binici');
})->throws(AramaException::class, 'hizmet veremiyor');

test('ad da orcid de boşsa istek atılmıyor', function () {
    Http::fake();

    expect(arama()->ara('', null))->toBe([]);

    Http::assertNothingSent();
});

// ─────────────────────────── EKRAN ───────────────────────────

/**
 * "N yayını ekle" sayacı ile ORCID rozeti — ikisi de ekranın adaya verdiği
 * tek geri bildirim. Sayaç ertelenmiş bağlamada 0'da takılı kalıyordu.
 */
test('sayaç ve orcid rozeti işaretlemeyi yansıtıyor', function () {
    $kullanici = User::factory()->create(['name' => 'Kasım Binici', 'orcid' => '0000-0002-8071-9693']);

    Http::fake([
        'api.crossref.org/works?*orcid*' => Http::response(['message' => ['items' => [kunye()]]]),
        'api.crossref.org/*' => Http::response(['message' => ['items' => []]]),
    ]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->call('yayinAra')
        ->assertSee('ORCID eşleşmesi')
        ->assertSee('0 yayını ekle')
        ->call('tumunuSec')
        ->assertSee('1 yayını ekle');
});

test('arama sekmesi profildeki ad ve orcid ile açılıyor', function () {
    $kullanici = User::factory()->create(['name' => 'Kasım Binici', 'orcid' => '0000-0002-8071-9693']);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->assertSet('aramaAdi', 'Kasım Binici')
        ->assertSet('aramaOrcid', '0000-0002-8071-9693');
});

/**
 * İÇE AKTARILAN KAYIT BEKLEMEDE VE KAYNAKSIZ İNİYOR.
 *
 * Crossref dergi indeksini (SCIE, Q2, TR Dizin…) bilmiyor — o bilgi
 * Clarivate ile Elsevier'in ürünü. İndeks de puanı belirleyen tek alan.
 * Kayıt "onaylandi" inseydi aday hiçbir şey yapmadan yönerge analizine
 * kaynaksız satırlarla girer ve adet koşulları sahte sağlanırdı.
 */
test('seçilen yayın beklemede ve kaynaksız ekleniyor', function () {
    $kullanici = User::factory()->create(['name' => 'Kasım Binici', 'orcid' => null]);
    crossrefDonsun([kunye()]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->call('yayinAra')
        ->assertSee('Bir Örnek Makale')
        ->assertSee('Bilgi Dünyası')
        ->set('secilenler', ['10.1234/ornek.1'])
        ->call('yayinlariEkle');

    $faaliyet = $kullanici->faaliyetler()->sole();

    expect($faaliyet->durum)->toBe('beklemede')
        ->and($faaliyet->kaynak)->toBeNull()
        ->and($faaliyet->yayin_turu)->toBeNull()
        ->and($faaliyet->kategori->value)->toBe('makale')
        ->and($faaliyet->baslik)->toBe('Bir Örnek Makale')
        ->and($faaliyet->yazarlar)->toBe('Kasım BİNİCİ, Ayşe Kurt')
        ->and($faaliyet->rol)->toBe('ilk')
        ->and($faaliyet->tarih->format('Y-m-d'))->toBe('2024-05-10')
        ->and($faaliyet->meta['doi'])->toBe('10.1234/ornek.1')
        ->and($faaliyet->meta['dergi'])->toBe('Bilgi Dünyası');

    // Beklemedeki kayıt motora girmiyor.
    expect(Faaliyet::query()->onaylanmis()->count())->toBe(0);
});

/**
 * Aday adını künyedekinden farklı yazmış olabilir ("K. Binici" ↔ "Kasım
 * BİNİCİ"). Yanlış sıra bazı yönergelerde doğrudan yanlış puan demek, o
 * yüzden rol boş bırakılıyor ve onay ekranında aday seçiyor.
 */
test('sırası bulunamayan yayında rol uydurulmuyor', function () {
    $kullanici = User::factory()->create(['name' => 'K. Binici', 'orcid' => null]);
    crossrefDonsun([kunye()]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->call('yayinAra')
        ->set('secilenler', ['10.1234/ornek.1'])
        ->call('yayinlariEkle');

    expect($kullanici->faaliyetler()->sole()->rol)->toBeNull();
});

/**
 * Aynı yayın iki kez eklenirse aday listesinde çift satır görür ve adet
 * koşulları iki sayar. DOI tekilleştirme anahtarı.
 */
test('zaten ekli yayın işaretlenemiyor ve yeniden eklenmiyor', function () {
    $kullanici = User::factory()->create(['name' => 'Kasım Binici', 'orcid' => null]);

    Faaliyet::factory()->for($kullanici)->create([
        'baslik' => 'Bir Örnek Makale',
        'meta' => ['doi' => '10.1234/ornek.1'],
    ]);

    crossrefDonsun([kunye()]);

    $bilesen = Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->call('yayinAra')
        ->assertSee('Zaten ekli');

    expect($bilesen->get('bulunanlar')[0]['ekli_sebep'])->toBe('doi');

    // Kutusu çizilmiyor ama istek elle de gönderilse yeni kayıt açılmamalı.
    $bilesen->set('secilenler', ['10.1234/ornek.1'])->call('yayinlariEkle');

    expect($kullanici->faaliyetler()->count())->toBe(1);
});

test('servise ulaşılamazsa ekran çökmüyor, mesaj gösteriyor', function () {
    Sleep::fake();
    $kullanici = User::factory()->create(['name' => 'Kasım Binici', 'orcid' => null]);
    Http::fake(['api.crossref.org/*' => Http::response('', 503)]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'yayin')
        ->call('yayinAra')
        ->assertOk()
        ->assertSee('hizmet veremiyor')
        ->assertSet('bulunanlar', []);
});

/**
 * Faaliyeti DÜZENLERKEN sekme çubuğu çizilmiyor: sekme değiştirmek formdaki
 * değişikliği sessizce çöpe atıyordu.
 */
test('düzenleme ekranında arama sekmesi yok', function () {
    $kullanici = User::factory()->create();
    $faaliyet = Faaliyet::factory()->for($kullanici)->create();

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class, ['faaliyet' => $faaliyet])
        ->assertDontSee('Yayınlarımı Bul');
});
