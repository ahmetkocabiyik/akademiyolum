<?php

use App\Livewire\FaaliyetEkle;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Yayin\ApbsProfili;
use App\Services\Yayin\AramaException;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

/**
 * APBS bölüm sayfasının yapısı: üstte sekme çubuğu, altta her sekme için bir
 * `tab-pane`, içinde kayıt başına bir `callout` kutusu. Kutuda başlık `<h5>`,
 * künye satırları `<p>`/`<div>`, en altta rozetler.
 *
 * Gerçek sayfadan alınan biçim; rozet sınıfları bölüme göre başka şey
 * anlatıyor (makalede success=yıl, projede success=durum).
 *
 * @param  list<array{etiket?: string|null, id?: string, kutular?: list<array<string, mixed>>}>  $sekmeler
 */
function apbsSayfa(array $sekmeler): string
{
    $nav = '';
    $panel = '';

    foreach ($sekmeler as $i => $sekme) {
        $id = 'custom-content-above-'.($sekme['id'] ?? 'sekme'.$i);
        $etiket = $sekme['etiket'] ?? null;
        $kutular = $sekme['kutular'] ?? [];

        if ($etiket !== null) {
            $nav .= sprintf(
                '<li class="nav-item"><a class="x_button btn btn-app nav-link" id="%s-tab" '
                .'data-toggle="pill" href="#%s" role="tab" aria-selected="false">'
                .'<span class="kucuk_sayi_iconu badge bg-purple">%d</span>'
                .'<i class="fas fa-book"></i> %s </a></li>',
                $id, $id, count($kutular), $etiket,
            );
        }

        $govde = '';

        foreach ($kutular as $kutu) {
            $govde .= apbsKutu($kutu);
        }

        $panel .= sprintf(
            '<div class="tab-pane fade show active" id="%s" role="tabpanel">%s</div>',
            $id,
            $govde,
        );
    }

    return '<html><body><div class="card-body"><ul class="nav nav-tabs">'.$nav.'</ul>'
        .'<div class="tab-content">'.$panel.'</div></div></body></html>';
}

/**
 * @param  array<string, mixed>  $kutu
 */
function apbsKutu(array $kutu): string
{
    $govde = '';

    foreach ($kutu['satirlar'] ?? [] as $satir) {
        $govde .= '<p>'.$satir.'</p>';
    }

    $rozetler = '';

    foreach ($kutu['rozet'] ?? [] as $sinif => $deger) {
        $ek = $sinif === 'danger' ? ' text-wrap' : '';
        $rozetler .= sprintf('<span class="badge badge-%s%s">%s</span>', $sinif, $ek, $deger);
    }

    if (isset($kutu['doi'])) {
        $rozetler .= sprintf(
            '<a class="badge" target="_blank" href="https://doi.org/%s"><i class="fas fa-link"></i> Link</a>',
            $kutu['doi'],
        );
    }

    return sprintf(
        '<div class="callout callout-success"><h5>%s</h5>%s<div>%s'
        .'<img src="/bm_sdg/kuresel_amaclar_04_renkli.png" class="float-right m-1"></div></div>',
        $kutu['baslik'],
        $govde,
        $rozetler,
    );
}

/**
 * Bir profilin bölümleri.
 *
 * TEK Http::fake ÇAĞRISI: art arda çağrıldığında kurallar silinmiyor,
 * EKLENİYOR ve ilk eşleşen kazanıyor. Listelenmeyen bölümler boş sayfa
 * dönüyor ki gerçek istek gitmesin.
 *
 * @param  array<string, string>  $bolumler
 */
function apbsTaklidi(array $bolumler): void
{
    $kurallar = [];

    foreach ($bolumler as $ad => $html) {
        $kurallar['*/'.$ad] = Http::response($html);
    }

    $kurallar['*'] = Http::response(apbsSayfa([]));

    Http::fake($kurallar);
}

function apbs(): ApbsProfili
{
    return new ApbsProfili;
}

/**
 * @return array{taban: string, kullanici: string}
 */
function apbsAdresi(): array
{
    return ['taban' => 'https://apbs.mersin.edu.tr', 'kullanici' => '410660'];
}

// ─────────────────────────── ADRES ───────────────────────────

/**
 * ADRESİ ADAY VERİYOR, İSTEĞİ BİZ ATIYORUZ.
 *
 * Sunucu adı `apbs.<...>.edu.tr` kalıbına sıkıca bağlanmazsa bu alan
 * sunucumuza istediği yere istek attırmanın (SSRF) kapısı olur.
 */
test('yalnız apbs alan adları kabul ediliyor', function (string $girdi, ?array $beklenen) {
    expect(apbs()->adres($girdi))->toBe($beklenen);
})->with([
    ['https://apbs.mersin.edu.tr/profiles/410660', ['taban' => 'https://apbs.mersin.edu.tr', 'kullanici' => '410660']],
    ['apbs.mersin.edu.tr/profiles/137993', ['taban' => 'https://apbs.mersin.edu.tr', 'kullanici' => '137993']],
    // Bölüm sayfasını yapıştıran aday da tanınmalı.
    ['https://apbs.mersin.edu.tr/profiles/410660/makaleler', ['taban' => 'https://apbs.mersin.edu.tr', 'kullanici' => '410660']],
    // Başka sunucu: reddedilmeli.
    ['https://evil.example.com/profiles/1', null],
    ['https://apbs.mersin.edu.tr.evil.com/profiles/1', null],
    ['http://127.0.0.1/profiles/1', null],
    // Sicil numarası sayı; kullanıcı adı değil.
    ['https://apbs.mersin.edu.tr/profiles/kullanici', null],
    ['https://apbs.mersin.edu.tr/makaleler', null],
    ['', null],
]);

test('avesis adresi apbs okuyucusuna düşmüyor', function () {
    expect(apbs()->adres('https://avesis.ktu.edu.tr/bc.demirbag'))->toBeNull();
});

// ─────────────────────────── MAKALE ───────────────────────────

/**
 * APBS'İN AVESİS'TEN FARKI BURADA: çeyreklik yazıyor.
 *
 * İndeks rozetinin yanındaki Q1–Q4, sözlüğün en çok kullanılan kademe
 * ailesini tahmin etmeden doldurabildiğimiz tek veri.
 */
test('indeks ve çeyreklik birlikte kademeye çevriliyor', function (string $indeks, string $ceyrek, ?string $kaynak, bool $uyari) {
    apbsTaklidi(['makaleler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [[
            'baslik' => 'Bir makale başlığı',
            'satirlar' => ['DERGİ ADI, vol. 19, no. 1, pp. 1-10', 'Ayşe Yılmaz, Murat Demir'],
            'rozet' => ['success' => '2026', 'primary' => 'Hakemli', 'info' => $indeks, 'danger' => $ceyrek],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kaynak'])->toBe($kaynak)
        ->and($kayit['uyari'] !== null)->toBe($uyari);
})->with([
    'SCIE + Q1' => ['SCI-Expanded', 'Q1', 'SCIE/SSCI (Q1)', false],
    'SSCI + Q3' => ['SSCI', 'Q3', 'SCIE/SSCI (Q3)', false],
    'Scopus + Q2' => ['Scopus', 'Q2', 'Scopus (Q2)', false],
    // Çeyreksiz çekirdek indeks: uydurulmuyor, gerekçesi adaya yazılıyor.
    'SCIE çeyreksiz' => ['SCI-Expanded', '', null, true],
    'Scopus çeyreksiz' => ['Scopus', '', null, true],
    // Sözlükte tek karşılığı olanlarda çeyreklik aranmıyor.
    'ESCI' => ['ESCI', '', 'ESCI', false],
    'AHCI' => ['AHCI', '', 'AHCI', false],
    'TR Dizin' => ['TR DİZİN', '', 'TR Dizin', false],
    // Sözlükte karşılığı olmayan indeks: kademe boş, uyarı da yok.
    'jgate' => ['jgate', '', null, false],
    'indekssiz' => ['', '', null, false],
    // Gerçek profilde çıplak "SCI" de yazılabiliyor; aynı aile.
    'SCI çeyreksiz' => ['SCI', '', null, true],
    'ESCI uzun yazım' => ['ESCI: Emerging Sources Citation Index', '', 'ESCI', false],
]);

/**
 * ULUSAL SEKMEDEKİ HAKEMLİ DERGİ.
 *
 * Sekme "Ulusal" ve rozet "Hakemli" ise sözlükteki "Diğer Ulusal Hakemli"
 * satırının tam tanımı; indeks aranmıyor. ULUSLARARASI sekmede aynı şey
 * YAPILMIYOR: oradaki "Index Copernicus", "DRJI", "google scholar" gibi
 * rozetlerin uluslararası indeks sayılıp sayılmayacağı yönergeden
 * yönergeye değişiyor.
 */
test('çekirdek indekste olmayan makale yalnız ulusal hakemli sayılıyor', function (string $etiket, string $tur, string $indeks, ?string $kaynak) {
    apbsTaklidi(['makaleler' => apbsSayfa([[
        'id' => 'sekme',
        'etiket' => $etiket,
        'kutular' => [[
            'baslik' => 'Bir makale',
            'rozet' => ['success' => '2020', 'primary' => $tur, 'info' => $indeks],
        ]],
    ]])]);

    expect(apbs()->kayitlar(apbsAdresi())[0]['kaynak'])->toBe($kaynak);
})->with([
    ['Ulusal', 'Hakemli', 'Endekste taranmıyor', 'Diğer Ulusal Hakemli'],
    ['Ulusal', 'Hakemli', 'Index Copernicus', 'Diğer Ulusal Hakemli'],
    ['Ulusal', '', 'Index Copernicus', null],
    ['Uluslararası', 'Hakemli', 'Index Copernicus', null],
    ['Uluslararası', 'Hakemli', 'google scholar', null],
]);

test('makalenin künyesi, yazarları, yılı ve doisi okunuyor', function () {
    apbsTaklidi(['makaleler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [[
            'baslik' => 'Dust storm risk mapping',
            'satirlar' => ['INTERNATIONAL JOURNAL OF DIGITAL EARTH, vol. 19, no. 1', 'Peyman Yariyan, Murat Yakar'],
            'rozet' => ['success' => '2026', 'info' => 'SCI-Expanded', 'danger' => 'Q1'],
            'doi' => '10.1080/17538947.2026.2654262',
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('makale')
        ->and($kayit['baslik'])->toBe('Dust storm risk mapping')
        ->and($kayit['yazarlar'])->toBe('Peyman Yariyan, Murat Yakar')
        ->and($kayit['kunye'])->toStartWith('INTERNATIONAL JOURNAL OF DIGITAL EARTH')
        ->and($kayit['yil'])->toBe(2026)
        ->and($kayit['doi'])->toBe('10.1080/17538947.2026.2654262');
});

// ─────────────────────────── BİLDİRİ ───────────────────────────

/**
 * Bildiride kademe iki eksenden çıkıyor: sekme (uluslararası/ulusal) ve
 * tür rozeti (tam metin/özet). İkisi de sayfada yazılı, tahmin yok.
 */
test('bildiri kademesi sekme ve tür rozetinden çıkıyor', function (string $sekme, string $etiket, string $tur, ?string $kaynak) {
    apbsTaklidi(['bildiriler' => apbsSayfa([[
        'id' => $sekme,
        'etiket' => $etiket,
        'kutular' => [[
            'baslik' => 'Bir bildiri başlığı',
            'satirlar' => ['Bir Sempozyum (25.04.2025 - 30.04.2025)', 'Murat Yakar'],
            'rozet' => ['success' => '2025', 'primary' => $tur, 'info' => 'Sözlü Sunum'],
        ]],
    ]])]);

    expect(apbs()->kayitlar(apbsAdresi())[0]['kaynak'])->toBe($kaynak);
})->with([
    ['uluslararasi', 'Uluslararası', 'Tam metin bildiri', 'Uluslararası Tam Metin'],
    ['uluslararasi', 'Uluslararası', 'Özet bildiri', 'Uluslararası Özet/Poster'],
    ['ulusal', 'Ulusal', 'Tam metin bildiri', 'Ulusal Tam Metin'],
    ['ulusal', 'Ulusal', 'Özet bildiri', 'Ulusal Özet/Poster'],
    // "Diğer" sekmesinde yer ekseni yok: kademe yazılmıyor.
    ['diger', 'Diğer', 'Tam metin bildiri', null],
    // Tür yazmıyorsa da yazılmıyor.
    ['uluslararasi', 'Uluslararası', '', null],
]);

/**
 * CPCI AYRIMI SAYFADA YOK.
 *
 * Sözlükte "Uluslararası Tam Metin (CPCI)" ayrı ve daha yüksek puanlı;
 * hangisi olduğu bilinmediğinde §0 uyarınca düşük olan yazılıyor.
 */
test('cpci olup olmadığı bilinmediğinden düşük kademe yazılıyor', function () {
    apbsTaklidi(['bildiriler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [[
            'baslik' => 'Bir bildiri',
            'rozet' => ['success' => '2025', 'primary' => 'Tam metin bildiri'],
        ]],
    ]])]);

    expect(apbs()->kayitlar(apbsAdresi())[0]['kaynak'])->toBe('Uluslararası Tam Metin');
});

// ─────────────────────────── KİTAP ───────────────────────────

test('kitapta bölüm ile kitap ayrılıyor', function () {
    apbsTaklidi(['kitaplar' => apbsSayfa([
        [
            'id' => 'uluslararasi',
            'etiket' => 'Kitap Bölümü',
            'kutular' => [[
                'baslik' => 'İnsansız Hava Aracı Teknolojisi',
                'satirlar' => ['Bölüm Adı: KUMANDA EDİLEBİLİR SİSTEMLER', 'Yayın Evi: Harita Kitapları, ISBN: 978', 'YAKAR MURAT, ULVİ ALİ'],
                'rozet' => ['success' => '2023', 'info' => 'Ders Kitabı'],
            ]],
        ],
        [
            'id' => 'ulusal',
            'etiket' => 'Kitap',
            'kutular' => [[
                'baslik' => 'Hava Lidar',
                'satirlar' => ['Yayın Evi: Atlas akademi, ISBN: 978-625', 'YAKAR MURAT'],
                'rozet' => ['success' => '2025', 'info' => 'Bilimsel Kitap'],
            ]],
        ],
    ])]);

    $kayitlar = apbs()->kayitlar(apbsAdresi());

    // Bölüm önce bakılıyor: "Ders Kitabı" rozeti bölüm olduğu gerçeğini
    // bastırmamalı.
    expect(array_column($kayitlar, 'kaynak'))->toBe(['Kitap Bölümü', 'Uluslararası/Ulusal Kitap'])
        ->and($kayitlar[1]['yazarlar'])->toBe('YAKAR MURAT')
        ->and($kayitlar[1]['kunye'])->toStartWith('Yayın Evi: Atlas akademi');
});

test('ders kitabı kendi kademesine gidiyor', function () {
    apbsTaklidi(['kitaplar' => apbsSayfa([[
        'id' => 'ulusal',
        'etiket' => 'Kitap',
        'kutular' => [[
            'baslik' => 'Bir ders kitabı',
            'satirlar' => ['Yayın Evi: X, ISBN: 1', 'YAZAR ADI'],
            'rozet' => ['success' => '2020', 'info' => 'Ders Kitabı'],
        ]],
    ]])]);

    expect(apbs()->kayitlar(apbsAdresi())[0]['kaynak'])->toBe('Ders / Metot Kitabı');
});

// ─────────────────────────── PROJE ───────────────────────────

test('projede fon kaynağı ve görev okunuyor', function (string $fon, string $gorev, ?string $kaynak, ?string $rol) {
    apbsTaklidi(['projeler' => apbsSayfa([[
        'id' => 'ulusal',
        'etiket' => 'Ulusal',
        'kutular' => [[
            'baslik' => 'Bir proje başlığı',
            'satirlar' => ['Uzaktan Algılama', '01.01.2018 – 31.12.2020'],
            'rozet' => ['success' => 'Tamamlandı', 'primary' => $fon, 'info' => $gorev],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('proje')
        ->and($kayit['kaynak'])->toBe($kaynak)
        ->and($kayit['rol'])->toBe($rol)
        // Yıl durum rozetinden değil künyedeki tarihlerden: proje bitiş
        // yılıyla sayılıyor.
        ->and($kayit['yil'])->toBe(2020);
})->with([
    ['TÜBİTAK PROJESİ', 'Yürütücü', 'TÜBİTAK', 'yurutucu'],
    ['BAP', 'Araştırmacı', 'BAP (Üniversite)', 'arastirmaci'],
    ['Bilinmeyen Fon', 'Danışman', null, 'danisman'],
]);

// ─────────────────────────── ÖDÜL ───────────────────────────

test('ödül kademesi yalnız veren kurum kesinse yazılıyor', function (string $baslik, string $kurum, ?string $kaynak) {
    // Ödüller bölümünde sekme çubuğu yok; okuyucu bunu kaldırabilmeli.
    apbsTaklidi(['oduller' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => null,
        'kutular' => [[
            'baslik' => $baslik,
            'satirlar' => [$kurum, 'Yurtdışı kurum veya kuruluşlardan alınan bilim ödülü'],
            'rozet' => ['success' => '2024', 'primary' => 'TÜRKİYE', 'info' => 'Yayın Teşvik Ödülü'],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('odul')
        ->and($kayit['kaynak'])->toBe($kaynak);
})->with([
    ['Teşvik Ödülü', 'TÜBİTAK', 'TÜBİTAK / TÜBA Ödülü'],
    ['GEBİP Ödülü', 'TÜBA', 'TÜBA GEBİP / TWAS Teşvik Ödülü'],
    // Serbest metin: yarışma derecesi mi bilim ödülü mü belli değil.
    ['Sözel Sunum 3. Ödülü', 'Bir Kongre', null],
]);

// ─────────────────────────── PATENT / TASARIM ───────────────────────────

test('patent kapsamı sekmeden, türü künyeden çıkıyor', function (string $sekme, string $etiket, string $kunye, ?string $kaynak) {
    apbsTaklidi(['patentler' => apbsSayfa([[
        'id' => $sekme,
        'etiket' => $etiket,
        'kutular' => [[
            'baslik' => 'Bir buluş başlığı',
            'satirlar' => [$kunye],
            'rozet' => ['success' => '2022'],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('patent')
        ->and($kayit['kaynak'])->toBe($kaynak);
})->with([
    ['uluslararasi', 'Uluslararası', 'Patent Tescil Edildi', 'Uluslararası Patent'],
    ['ulusal', 'Ulusal', 'Patent Tescil Edildi', 'Ulusal Patent'],
    // Künyede tür açıkça yazıyorsa sekmeye bakılmıyor.
    ['ulusal', 'Ulusal', 'Faydalı Model Tescil Edildi', 'Faydalı Model'],
    ['diger', 'Diğer', 'Patent Tescil Edildi', null],
]);

/**
 * "Tasarımlar" bölümü TESCİLLİ tasarımı değil tasarım İŞİNİ listeliyor;
 * sözlükteki "Endüstriyel Tasarım" tescil demek. Kademe boş, aday seçer.
 */
test('tasarım kaydında kademe yazılmıyor', function () {
    apbsTaklidi(['tasarimlar' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => null,
        'kutular' => [[
            'baslik' => 'Bir tasarım işi',
            'rozet' => ['success' => '2021'],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('patent')
        ->and($kayit['kaynak'])->toBeNull();
});

// ─────────────────────────── EDİTÖRLÜK / HAKEMLİK ───────────────────────────

test('editörlükte görev ve dergi indeksi kademeyi belirliyor', function (string $gorev, string $indeks, ?string $kaynak, bool $uyari) {
    apbsTaklidi(['editorlukler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [[
            'baslik' => 'Turkish Journal of Engineering',
            'satirlar' => ['YAKAR MURAT', 'Tubitak Dergipark 01.05.2017– ISSN: 2587-1366'],
            'rozet' => ['success' => '2026', 'primary' => 'Dergi', 'info' => $indeks, 'danger' => $gorev],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('editorluk')
        ->and($kayit['kaynak'])->toBe($kaynak)
        ->and($kayit['uyari'] !== null)->toBe($uyari);
})->with([
    'yayın kurulu' => ['Yayın Kurulu Üyesi', 'Scopus', 'Yayın Kurulu Üyeliği', false],
    'ESCI editörü' => ['Editör', 'esci', 'ESCI Dergi', false],
    'TR Dizin editörü' => ['Editör', 'TR Dizin', 'TR Dizin Dergi', false],
    // Editörlükte çeyreklik ayrımı var ama sayfada çeyreklik yazmıyor.
    'Scopus editörü' => ['Editör', 'Scopus', null, true],
    'WoS editörü' => ['Editör', 'SCI-Expanded', null, true],
    'indekssiz' => ['Editör', '', null, false],
]);

test('hakemlik kendi kademesine gidiyor', function () {
    apbsTaklidi(['hakemlikler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [[
            'baslik' => 'African Journal of Biotechnology',
            'satirlar' => ['Dergi, hakemli bilimsel dergilerde yayımlanmış tam makale'],
            'rozet' => ['success' => '2016', 'primary' => 'İngilizce'],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('editorluk')
        ->and($kayit['kaynak'])->toBe('Hakemlik');
});

// ─────────────────────────── TEZ DANIŞMANLIĞI ───────────────────────────

test('tez düzeyi rozetten okunuyor', function (string $duzey, ?string $kaynak) {
    apbsTaklidi(['tez_danismanliklari' => apbsSayfa([[
        'id' => 'yl',
        'etiket' => $duzey,
        'kutular' => [[
            'baslik' => 'Bir tez başlığı',
            'satirlar' => ['ZEYNEP ATAÇ', 'MERSİN ÜNİVERSİTESİ - FEN BİLİMLERİ ENSTİTÜSÜ'],
            'rozet' => ['success' => '2024', 'primary' => $duzey, 'info' => 'TezMerkezi', 'danger' => 'Yurt İçi'],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('tez_danismanligi')
        ->and($kayit['kaynak'])->toBe($kaynak);
})->with([
    ['Yüksek Lisans', 'Yüksek Lisans Tezi'],
    ['Doktora', 'Doktora Tezi'],
    ['Tıpta Uzmanlık', 'Tıpta/Diş/Sanatta Yeterlik Tezi'],
    ['Sanatta Yeterlik', 'Tıpta/Diş/Sanatta Yeterlik Tezi'],
    ['Diğer', null],
]);

// ─────────────────────────── DENEYİM / ÜYELİK ───────────────────────────

/**
 * "Deneyimler" tek callout kullanmayan bölüm: zaman tüneli düzeninde.
 *
 * Yalnız İdari Görevler alınıyor; akademik unvan geçmişi ile üniversite dışı
 * deneyim puanlanan bir faaliyet değil, ATLANAN olarak sayılıyor ki aday
 * "eksik geldi" sanmasın.
 */
test('deneyimlerde yalnız idari görevler faaliyete çevriliyor', function () {
    $tunel = function (string $baslik, string $kurum, string $yil): string {
        return '<div class="timeline timeline-inverse">'
            .'<div class="time-label"><span class="btn btn-outline-success"> Devam ediyor </span></div>'
            .'<div><div class="timeline-item"><h3 class="timeline-header"><a href="#"> '.$baslik.' </a></h3>'
            .'<div class="timeline-body">'.$kurum.'</div></div></div>'
            .'<div class="time-label"><span class="btn btn-outline-success"> '.$yil.' </span></div></div>';
    };

    $html = '<html><body><div class="card-body"><ul class="nav nav-tabs">'
        .'<li class="nav-item"><a href="#custom-content-above-uluslararasi"><span class="kucuk_sayi_iconu badge bg-purple">1</span> Akademik Görevler </a></li>'
        .'<li class="nav-item"><a href="#custom-content-above-ulusal"><span class="kucuk_sayi_iconu badge bg-warning">2</span> İdari Görevler </a></li>'
        .'<li class="nav-item"><a href="#custom-content-above-diger"><span class="kucuk_sayi_iconu badge bg-danger">1</span> Üniversite Dışı Deneyimler </a></li>'
        .'</ul><div class="tab-content">'
        .'<div class="tab-pane fade show active" id="custom-content-above-uluslararasi">'.$tunel('PROFESÖR', 'MERSİN ÜNİVERSİTESİ', '2017').'</div>'
        .'<div class="tab-pane fade" id="custom-content-above-ulusal">'
        .$tunel('Bölüm Başkanı', 'MERSİN ÜNİVERSİTESİ', '2023')
        .$tunel('Dekan Yardımcısı', 'MERSİN ÜNİVERSİTESİ', '2019')
        .'</div>'
        .'<div class="tab-pane fade" id="custom-content-above-diger">'.$tunel('External Examiner', 'University of Peshawar', '2021').'</div>'
        .'</div></div></body></html>';

    apbsTaklidi(['deneyimler' => $html]);

    $kayitlar = apbs()->kayitlar(apbsAdresi());
    $alinan = array_values(array_filter($kayitlar, fn (array $k): bool => ! $k['atlandi']));

    expect(array_column($alinan, 'baslik'))->toBe(['Bölüm Başkanı', 'Dekan Yardımcısı'])
        ->and(array_column($alinan, 'kategori'))->toBe(['idari_gorev', 'idari_gorev'])
        ->and(array_column($alinan, 'kaynak'))->toBe(['Bölüm Başkanı', 'Dekan Yrd. / Müdür Yrd.'])
        ->and($alinan[0]['yil'])->toBe(2023)
        // Akademik görev ve üniversite dışı deneyim: atlanan olarak sayılıyor.
        ->and(count($kayitlar) - count($alinan))->toBe(2);
});

test('üyeliklerde kademe yazılmıyor', function () {
    apbsTaklidi(['uyelikler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => null,
        'kutular' => [[
            'baslik' => 'Türkiye Fotogrametri Birliği',
            'rozet' => ['success' => '2020'],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('idari_gorev')
        ->and($kayit['kaynak'])->toBeNull();
});

// ─────────────────────────── SANATSAL / SERTİFİKA ───────────────────────────

test('sanatsal etkinlikte kademe yazılmıyor', function () {
    apbsTaklidi(['sanatsal_faaliyetler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [[
            'baslik' => 'Bir sergi',
            'rozet' => ['success' => '2023'],
        ]],
    ]])]);

    $kayit = apbs()->kayitlar(apbsAdresi())[0];

    expect($kayit['kategori'])->toBe('sanatsal_etkinlik')
        ->and($kayit['kaynak'])->toBeNull();
});

test('araştırma sertifikalarında yalnız düzenleme görevi alınıyor', function () {
    apbsTaklidi(['arastirma_sertifikalari' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [
            [
                'baslik' => '9th Advanced Engineering Symposium',
                'satirlar' => ['Mühendislik', 'Tebriz universitesi 09.07.2024 – 10.07.2024'],
                'rozet' => ['success' => 'Kongre Düzenleme'],
            ],
            [
                'baslik' => 'PENMAN MONTEITH yöntemi eğitimi',
                'satirlar' => ['Katılım belgesi'],
                'rozet' => ['success' => 'Eğitim'],
            ],
        ],
    ]])]);

    $kayitlar = apbs()->kayitlar(apbsAdresi());
    $alinan = array_values(array_filter($kayitlar, fn (array $k): bool => ! $k['atlandi']));

    expect($alinan)->toHaveCount(1)
        ->and($alinan[0]['kategori'])->toBe('diger')
        ->and($alinan[0]['kaynak'])->toBeNull()
        // Sertifikanın yılı künyedeki tarihten; rozette yıl yok.
        ->and($alinan[0]['yil'])->toBe(2024);
});

// ─────────────────────────── KENAR DURUMLAR ───────────────────────────

/**
 * Boş bölümün kendisi de bir kutu: "Ulusal kategoride proje bulunamadı!".
 * Kayıt değil, ATLANAN da değil — aksi hâlde her boş bölüm adaya
 * "eşlenemedi" diye sayılırdı.
 */
test('boş bölüm iletisi kayıt sayılmıyor', function () {
    apbsTaklidi(['projeler' => apbsSayfa([
        ['id' => 'uluslararasi', 'etiket' => 'Uluslararası', 'kutular' => [['baslik' => 'Uluslararası kategoride proje bulunamadı!']]],
        ['id' => 'ulusal', 'etiket' => 'Ulusal', 'kutular' => [['baslik' => 'Ulusal kategoride proje bulunamadı!']]],
    ])]);

    expect(apbs()->kayitlar(apbsAdresi()))->toBe([]);
});

/**
 * APBS kayıtlarının kalıcı kimliği yok; kimlik künyeden türetiliyor. Aynı
 * kayıt profilde iki kez duruyorsa aynı kimliği alır ve ikincisi elenir —
 * ekrandaki `wire:key` tekil olmalı.
 */
/**
 * Aynı kitabın hem kendisi hem bir bölümü aynı adla listelenebiliyor.
 * Kademeleri farklı olduğu için ikisi ayrı kayıt sayılıyor; kimliğe
 * kademe de giriyor.
 */
test('kitap ile aynı adlı bölümü ayrı kayıt', function () {
    apbsTaklidi(['kitaplar' => apbsSayfa([[
        'id' => 'ulusal',
        'etiket' => 'Kitap',
        'kutular' => [
            [
                'baslik' => 'Moğolistan daki Türk Anıtları Projesi',
                'satirlar' => ['Yayın Evi: Semih Ofset, ISBN: 975', 'YAKAR MURAT'],
                'rozet' => ['success' => '2003', 'info' => 'Bilimsel Kitap'],
            ],
            [
                'baslik' => 'Moğolistan daki Türk Anıtları Projesi',
                'satirlar' => ['Bölüm Adı: Haritacılık çalışmaları', 'Yayın Evi: Semih Ofset, ISBN: 975', 'YAKAR MURAT'],
                'rozet' => ['success' => '2003', 'info' => 'Bilimsel Kitap'],
            ],
        ],
    ]])]);

    expect(array_column(apbs()->kayitlar(apbsAdresi()), 'kaynak'))
        ->toBe(['Uluslararası/Ulusal Kitap', 'Kitap Bölümü']);
});

test('aynı kayıt iki kez listelenmiyor', function () {
    $kutu = [
        'baslik' => 'Aynı makale başlığı burada',
        'satirlar' => ['DERGİ, vol. 1', 'Bir Yazar'],
        'rozet' => ['success' => '2020', 'info' => 'ESCI'],
    ];

    apbsTaklidi(['makaleler' => apbsSayfa([[
        'id' => 'uluslararasi', 'etiket' => 'Uluslararası', 'kutular' => [$kutu, $kutu],
    ]])]);

    expect(apbs()->kayitlar(apbsAdresi()))->toHaveCount(1);
});

test('ulaşılamayan bölüm diğerlerini düşürmüyor', function () {
    Http::fake([
        '*/makaleler' => Http::response(apbsSayfa([[
            'id' => 'uluslararasi', 'etiket' => 'Uluslararası',
            'kutular' => [['baslik' => 'Bir makale', 'rozet' => ['success' => '2020', 'info' => 'ESCI']]],
        ]])),
        '*' => Http::response('', 504),
    ]);

    expect(apbs()->kayitlar(apbsAdresi()))->toHaveCount(1);
});

// ─────────────────────────── EKRAN ───────────────────────────

test('apbs adresi ekrandan okunup faaliyete çevriliyor', function () {
    $kullanici = User::factory()->create();

    apbsTaklidi(['makaleler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [[
            'baslik' => 'Spatiotemporal dust storm risk mapping',
            'satirlar' => ['JOURNAL OF DIGITAL EARTH, vol. 19', 'Bir Yazar, Başka Yazar'],
            'rozet' => ['success' => '2024', 'info' => 'SCI-Expanded', 'danger' => 'Q1'],
            'doi' => '10.1080/17538947.2024.1',
        ]],
    ]])]);

    Livewire::actingAs($kullanici)
        ->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'https://apbs.mersin.edu.tr/profiles/410660')
        ->call('avesisGetir')
        ->assertSet('avesisHatasi', '')
        ->assertSet('avesisSistemAdi', 'APBS')
        ->call('avesisTumunuSec')
        ->call('avesistenEkle');

    $faaliyet = Faaliyet::query()->where('user_id', $kullanici->id)->sole();

    expect($faaliyet->baslik)->toBe('Spatiotemporal dust storm risk mapping')
        ->and($faaliyet->kategori->value)->toBe('makale')
        ->and($faaliyet->kaynak)->toBe('SCIE/SSCI (Q1)')
        // Kurum profilinden gelen kayıt onaylı iner.
        ->and($faaliyet->durum)->toBe('onaylandi')
        ->and($faaliyet->meta['kaynak_sistem'])->toBe('apbs')
        ->and($faaliyet->meta['apbs_id'])->not->toBeEmpty()
        ->and($faaliyet->tarih->year)->toBe(2024);

    // Adres profile kaydediliyor: aday bir daha yazmasın.
    expect($kullanici->refresh()->avesis_id)->toBe('https://apbs.mersin.edu.tr/profiles/410660');
});

test('tanınmayan adres iki sistemin örneğini birden gösteriyor', function () {
    Livewire::actingAs(User::factory()->create())
        ->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'https://example.com/ben')
        ->call('avesisGetir')
        ->assertSee('avesis.ktu.edu.tr', false)
        ->assertSee('apbs.mersin.edu.tr', false);
});

/**
 * MÜKERRER DENETİMİ KAYNAKLAR ARASI ÇALIŞMALI: aynı makaleyi Crossref'ten
 * almış aday APBS'te onu "ekli" görmeli, yoksa adet koşulları onu iki
 * sayar.
 */
test('crossrefden eklenmiş makale apbste ekli çıkıyor', function () {
    $kullanici = User::factory()->create();

    Faaliyet::factory()->for($kullanici)->create([
        'kategori' => 'makale',
        'baslik' => 'Spatiotemporal dust storm risk mapping',
        'meta' => ['doi' => '10.1080/17538947.2024.1', 'kaynak_sistem' => 'crossref'],
    ]);

    apbsTaklidi(['makaleler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [[
            'baslik' => 'Spatiotemporal dust storm risk mapping',
            'rozet' => ['success' => '2024', 'info' => 'ESCI'],
            'doi' => '10.1080/17538947.2024.1',
        ]],
    ]])]);

    $bilesen = Livewire::actingAs($kullanici)
        ->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'https://apbs.mersin.edu.tr/profiles/410660')
        ->call('avesisGetir');

    expect($bilesen->get('avesisBulunanlar')[0]['ekli_sebep'])->toBe('doi');
});

/**
 * SUNUCU YANIT VERMEDİĞİNDE "KAYIT YOK" DENMEZ.
 *
 * APBS yoğun anlarda dakikalarca 504 veriyor; o sırada "profilinizde
 * okunabilir kayıt yok" demek adayı profilinin boş olduğuna inandırırdı.
 */
test('hiçbir bölüm okunamazsa ulaşılamadı hatası veriliyor', function () {
    Http::fake(['*' => Http::response('', 504)]);

    expect(fn () => apbs()->kayitlar(apbsAdresi()))
        ->toThrow(AramaException::class, 'APBS şu an yanıt vermiyor. Sunucusu yoğun olabilir; biraz sonra tekrar deneyin.');
});

test('ulaşılamayan profil ekranda hata olarak görünüyor', function () {
    Http::fake(['*' => Http::response('', 504)]);

    Livewire::actingAs(User::factory()->create())
        ->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'https://apbs.mersin.edu.tr/profiles/410660')
        ->call('avesisGetir')
        ->assertSet('avesisBulunanlar', [])
        ->assertSee('APBS şu an yanıt vermiyor', false);
});

/**
 * YARIM OKUMA SAKLANMIYOR.
 *
 * Bir bölüm zaman aşımına uğradıysa liste eksik; 6 saat boyunca doğru
 * sanılsaydı aday kalan kayıtları bir daha göremezdi.
 */
test('eksik okuma önbelleğe alınmıyor', function () {
    $sayfa = apbsSayfa([[
        'id' => 'uluslararasi', 'etiket' => 'Uluslararası',
        'kutular' => [['baslik' => 'Bir makale', 'rozet' => ['success' => '2020', 'info' => 'ESCI']]],
    ]]);

    $bildiriler = apbsSayfa([[
        'id' => 'ulusal', 'etiket' => 'Ulusal',
        'kutular' => [['baslik' => 'Bir bildiri', 'rozet' => ['success' => '2021', 'primary' => 'Tam metin bildiri']]],
    ]]);

    // TEK Http::fake: ikinci kez çağrılsa kurallar silinmez, EKLENİR ve
    // ilk eşleşen kazanırdı — bildiriler hep 504 dönerdi.
    $bildiriDussun = true;

    Http::fake(function ($istek) use ($sayfa, $bildiriler, &$bildiriDussun) {
        $adres = (string) $istek->url();

        return match (true) {
            str_ends_with($adres, '/makaleler') => Http::response($sayfa),
            str_ends_with($adres, '/bildiriler') => $bildiriDussun
                ? Http::response('', 504)
                : Http::response($bildiriler),
            default => Http::response(apbsSayfa([])),
        };
    });

    expect(apbs()->kayitlar(apbsAdresi()))->toHaveCount(1);

    // İkinci okumada bildiriler de geliyor: kopya kalmadığı için yeniden
    // istek atılıyor.
    $bildiriDussun = false;

    expect(apbs()->kayitlar(apbsAdresi()))->toHaveCount(2);
});

test('eksiksiz okuma önbelleğe alınıyor', function () {
    apbsTaklidi(['makaleler' => apbsSayfa([[
        'id' => 'uluslararasi', 'etiket' => 'Uluslararası',
        'kutular' => [['baslik' => 'Bir makale', 'rozet' => ['success' => '2020', 'info' => 'ESCI']]],
    ]])]);

    expect(apbs()->kayitlar(apbsAdresi()))->toHaveCount(1);

    Http::fake(['*' => Http::response('', 504)]);

    // Kopyadan geliyor: sunucu düşse de aday listesini kaybetmiyor.
    expect(apbs()->kayitlar(apbsAdresi()))->toHaveCount(1);
});

test('okunamayan bölüm ekranda bildiriliyor', function () {
    Http::fake([
        '*/makaleler' => Http::response(apbsSayfa([[
            'id' => 'uluslararasi', 'etiket' => 'Uluslararası',
            'kutular' => [['baslik' => 'Bir makale', 'rozet' => ['success' => '2020', 'info' => 'ESCI']]],
        ]])),
        '*/projeler' => Http::response('', 504),
        '*' => Http::response(apbsSayfa([])),
    ]);

    Livewire::actingAs(User::factory()->create())
        ->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'https://apbs.mersin.edu.tr/profiles/410660')
        ->call('avesisGetir')
        ->assertSet('avesisEksikBolum', 1)
        ->assertSee('1 bölüm okunamadı', false);
});

/**
 * YAZAR LİSTESİ KESİLMEZ.
 *
 * Çok yazarlı bildirilerde liste 255 karakteri aşıyor ve sütun varchar
 * olduğu sürece ekleme "Data too long" ile yarıda kalıyordu. Kesip yazmak
 * da çözüm değil: puan motoru yazar sayısını bu alandaki virgüllerden
 * buluyor ve AZ yazar DAHA YÜKSEK çarpan demek.
 */
test('uzun yazar listesi kesilmeden kaydediliyor', function () {
    $yazarlar = implode(', ', array_map(fn (int $i): string => "Yazar Adı Soyadı {$i}", range(1, 40)));

    expect(mb_strlen($yazarlar))->toBeGreaterThan(255);

    apbsTaklidi(['bildiriler' => apbsSayfa([[
        'id' => 'uluslararasi',
        'etiket' => 'Uluslararası',
        'kutular' => [[
            'baslik' => 'Çok yazarlı bir bildiri',
            'satirlar' => ['Bir Kongre (2024)', $yazarlar],
            'rozet' => ['success' => '2024', 'primary' => 'Tam metin bildiri'],
        ]],
    ]])]);

    $kullanici = User::factory()->create();

    Livewire::actingAs($kullanici)
        ->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'https://apbs.mersin.edu.tr/profiles/410660')
        ->call('avesisGetir')
        ->call('avesisTumunuSec')
        ->call('avesistenEkle');

    expect(Faaliyet::query()->where('user_id', $kullanici->id)->sole()->yazarlar)->toBe($yazarlar);
});
