<?php

use App\Livewire\FaaliyetEkle;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Yayin\AvesisProfili;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

/**
 * AVESİS yayın sayfasının yapısı: açılır bölümler (`ac-item`), başlıkta
 * bölüm adı, gövdede `pub-item`'lar. İndeks anahtarları `data-filters`'ta.
 *
 * @param  array<string, list<array<string, string>>>  $bolumler
 */
function avesisYayinSayfasi(array $bolumler): string
{
    $html = '';

    foreach ($bolumler as $ad => $ogeler) {
        $govde = '';

        foreach ($ogeler as $i => $o) {
            $filtre = $o['filtre'] ?? '';
            $govde .= sprintf(
                '<div class="pub-item with-icon" data-filters="%s">'
                .'<h3 class="title"><a target="_blank" href="/yayin/%s/bir-slug">'
                .'<span style="color:#bbb;">%d.</span> <strong>%s</strong></a></h3>'
                .'<div class="description"><div class="citation">%s</div>'
                .'<div class="citation"><span>%s</span></div></div></div>',
                $filtre,
                $o['id'],
                $i + 1,
                $o['baslik'],
                $o['yazarlar'] ?? '',
                $o['kunye'] ?? '',
            );
        }

        $html .= '<div class="ac-item open"><div class="item-head"><span>'.$ad
            .'</span><span class="badge">'.count($ogeler).'</span></div>'
            .'<div class="item-body">'.$govde.'</div></div>';
    }

    return "<html><body>{$html}</body></html>";
}

/**
 * @param  list<array<string, string>>  $projeler
 */
function avesisProjeSayfasi(array $projeler): string
{
    $govde = '';

    foreach ($projeler as $p) {
        $govde .= sprintf(
            '<li><h3 class="project-item title"><span class="shaded-label">%s</span>'
            .'<a target="_blank" href="/proje/%s/bir-slug"><strong>%s</strong></a></h3>'
            .'<div class="description">%s</div></li>',
            $p['yil'] ?? '',
            $p['id'],
            $p['baslik'],
            $p['fon'] ?? '',
        );
    }

    return '<html><body><div class="ac-item open"><div class="item-head"><span>Desteklenen Projeler</span></div>'
        ."<div class=\"item-body\"><ul>{$govde}</ul></div></div></body></html>";
}

/**
 * @param  array<string, list<array<string, string>>>  $yayinlar
 * @param  list<array<string, string>>  $projeler
 */
function avesisTaklidi(array $yayinlar = [], array $projeler = []): void
{
    Http::fake([
        '*/yayinlar' => Http::response(avesisYayinSayfasi($yayinlar)),
        '*/projeler' => Http::response(avesisProjeSayfasi($projeler)),
    ]);
}

function avesis(): AvesisProfili
{
    return new AvesisProfili;
}

function uuid(int $n): string
{
    return sprintf('%08d-0000-4000-8000-000000000000', $n);
}

// ─────────────────────────── ADRES ───────────────────────────

/**
 * ADRESİ ADAY VERİYOR, İSTEĞİ BİZ ATIYORUZ.
 *
 * Sunucu adı `avesis.<...>.edu.tr` kalıbına sıkıca bağlanmazsa bu alan
 * sunucumuzu istediği yere istek attırmanın (SSRF) kapısı olur.
 */
test('yalnız avesis alan adları kabul ediliyor', function (string $girdi, ?array $beklenen) {
    expect(avesis()->adres($girdi))->toBe($beklenen);
})->with([
    ['https://avesis.ktu.edu.tr/bc.demirbag', ['taban' => 'https://avesis.ktu.edu.tr', 'kullanici' => 'bc.demirbag']],
    ['avesis.deu.edu.tr/mehmetyilmaz', ['taban' => 'https://avesis.deu.edu.tr', 'kullanici' => 'mehmetyilmaz']],
    ['https://avesis.ktu.edu.tr/bc.demirbag/yayinlar', ['taban' => 'https://avesis.ktu.edu.tr', 'kullanici' => 'bc.demirbag']],
    // Başka sunucu: reddedilmeli.
    ['https://evil.example.com/x', null],
    ['https://avesis.ktu.edu.tr.evil.com/x', null],
    ['http://127.0.0.1/admin', null],
    // Sitenin kendi sayfaları profil değil.
    ['https://avesis.ktu.edu.tr/arama?q=x', null],
    ['', null],
]);

// ─────────────────────────── OKUMA ───────────────────────────

test('bölüm adları kategoriye çevriliyor', function () {
    avesisTaklidi([
        'Makaleler' => [['id' => uuid(1), 'baslik' => 'Bir makale', 'kunye' => 'Dergi, cilt.1, 2020 (ESCI)']],
        'Hakemli Bilimsel Toplantılarda Yayımlanmış Bildiriler' => [['id' => uuid(2), 'baslik' => 'Bir bildiri']],
        'Kitaplar' => [['id' => uuid(3), 'baslik' => 'Bir kitap']],
        'Metrikler' => [['id' => uuid(4), 'baslik' => 'Sayılmamalı']],
    ]);

    $kayitlar = avesis()->kayitlar(avesis()->adres('avesis.ktu.edu.tr/kullanici'));

    expect(array_column($kayitlar, 'kategori'))->toBe(['makale', 'bildiri', 'kitap'])
        ->and($kayitlar[0]['baslik'])->toBe('Bir makale')
        ->and($kayitlar[0]['yil'])->toBe(2020);
});

/**
 * Başlık `<strong>` içinde ve önünde sıra numarası var ("1."). Numarayı
 * temizlemezsek faaliyet listesinde "1. Bir makale" diye görünür.
 */
test('başlıktaki sıra numarası temizleniyor', function () {
    avesisTaklidi(['Makaleler' => [['id' => uuid(1), 'baslik' => 'Bir makale', 'yazarlar' => 'YILMAZ A., KURT B.']]]);

    $kayit = avesis()->kayitlar(avesis()->adres('avesis.ktu.edu.tr/kullanici'))[0];

    expect($kayit['baslik'])->toBe('Bir makale')
        ->and($kayit['yazarlar'])->toBe('YILMAZ A., KURT B.');
});

/**
 * ÇEYREKLİK BURADA DA UYDURULMUYOR.
 *
 * Sözlükte SCIE/SSCI ve Scopus kademeleri yalnız çeyrekli var; AVESİS
 * çeyrekliği yazmıyor. Kademe boş kalıp uyarı çıkıyor.
 */
test('indeks anahtarları kademeye çevriliyor', function (string $filtre, ?string $kaynak, ?string $uyariParcasi) {
    avesisTaklidi(['Makaleler' => [['id' => uuid(1), 'baslik' => 'X', 'filtre' => $filtre]]]);

    $kayit = avesis()->kayitlar(avesis()->adres('avesis.ktu.edu.tr/kullanici'))[0];

    expect($kayit['kaynak'])->toBe($kaynak);

    $uyariParcasi === null
        ? expect($kayit['uyari'])->toBeNull()
        : expect($kayit['uyari'])->toContain($uyariParcasi);
})->with([
    'esci' => ['esci,sci_ssci_ahci_esci,scopus', 'ESCI', null],
    'tr dizin' => ['trdizin', 'TR Dizin', null],
    'scie' => ['sci_ssci_ahci,sci_ssci_ahci_esci', null, 'çeyrek'],
    'yalnız scopus' => ['scopus', null, 'Scopus'],
    'tanınmayan' => ['other', null, null],
    'anahtarsız' => ['', null, null],
]);

test('projeler fon programıyla okunuyor', function () {
    avesisTaklidi([], [
        ['id' => uuid(7), 'baslik' => '. Bir TÜBİTAK projesi', 'yil' => '2019 - 2021', 'fon' => 'TÜBİTAK 1001'],
        ['id' => uuid(8), 'baslik' => 'Süren proje', 'yil' => '2024 - Devam Ediyor', 'fon' => 'Yükseköğretim Kurumları destekli'],
    ]);

    $kayitlar = avesis()->kayitlar(avesis()->adres('avesis.ktu.edu.tr/kullanici'));

    expect($kayitlar)->toHaveCount(2)
        // Başlıktaki başıboş nokta AVESİS verisinden geliyor, temizleniyor.
        ->and($kayitlar[0]['baslik'])->toBe('Bir TÜBİTAK projesi')
        ->and($kayitlar[0]['kategori'])->toBe('proje')
        // Bitiş yılı: yönergeler tamamlanmış projeyi sayıyor.
        ->and($kayitlar[0]['yil'])->toBe(2021)
        ->and($kayitlar[0]['kaynak'])->toBe('TÜBİTAK')
        ->and($kayitlar[1]['yil'])->toBe(2024)
        ->and($kayitlar[1]['kaynak'])->toBe('BAP (Üniversite)');
});

// ─────────────────────────── EKRAN ───────────────────────────

/**
 * DİĞER İKİ YOLDAN FARKI: kademe dolu iniyor.
 *
 * Crossref ile DergiPark dergi indeksini bilmiyordu; AVESİS biliyor. Yine
 * de durum "beklemede": okunan kademe adayın onayından geçmeli.
 */
test('avesis kaydı kademesiyle birlikte ekleniyor', function () {
    $kullanici = User::factory()->create(['avesis_id' => null]);

    avesisTaklidi(
        ['Makaleler' => [
            ['id' => uuid(1), 'baslik' => 'ESCI makalem', 'filtre' => 'esci', 'kunye' => 'Dergi, 2020 (ESCI)', 'yazarlar' => 'KURT A.'],
            ['id' => uuid(2), 'baslik' => 'SCIE makalem', 'filtre' => 'sci_ssci_ahci', 'kunye' => 'Dergi, 2021'],
        ]],
        [['id' => uuid(7), 'baslik' => 'Projem', 'yil' => '2019 - 2021', 'fon' => 'TÜBİTAK 1001']],
    );

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'https://avesis.ktu.edu.tr/kullanici')
        ->call('avesisGetir')
        ->assertSee('ESCI makalem')
        ->assertSee('Projem')
        ->call('avesisTumunuSec')
        ->assertSee('3 kaydı ekle')
        ->call('avesistenEkle');

    $faaliyetler = $kullanici->faaliyetler()->get()->keyBy('baslik');

    expect($faaliyetler)->toHaveCount(3)
        ->and($faaliyetler['ESCI makalem']->kaynak)->toBe('ESCI')
        ->and($faaliyetler['ESCI makalem']->durum)->toBe('beklemede')
        ->and($faaliyetler['ESCI makalem']->yazarlar)->toBe('KURT A.')
        ->and($faaliyetler['ESCI makalem']->meta['avesis_id'])->toBe(uuid(1))
        // Çeyreklik bilinmiyor: kademe boş.
        ->and($faaliyetler['SCIE makalem']->kaynak)->toBeNull()
        ->and($faaliyetler['Projem']->kategori->value)->toBe('proje')
        ->and($faaliyetler['Projem']->kaynak)->toBe('TÜBİTAK');

    // Adres profile yazıldı: aday bir daha girmesin.
    expect($kullanici->fresh()->avesis_id)->toBe('https://avesis.ktu.edu.tr/kullanici');
});

/**
 * AVESİS yalnız YIL veriyor. 1 Ocak, dönem koşullarında ("doçentlikten
 * sonra", "son beş yıl") en muhafazakâr tarih.
 */
test('yıldan üretilen tarih yılın başına konuyor', function () {
    $kullanici = User::factory()->create();

    avesisTaklidi(['Makaleler' => [
        ['id' => uuid(1), 'baslik' => 'Yıllı', 'kunye' => 'Dergi, cilt.3, 2020'],
        ['id' => uuid(2), 'baslik' => 'Yılsız', 'kunye' => 'Dergi'],
    ]]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('avesisAdres', 'avesis.ktu.edu.tr/kullanici')
        ->call('avesisGetir')
        ->call('avesisTumunuSec')
        ->call('avesistenEkle');

    $faaliyetler = $kullanici->faaliyetler()->get()->keyBy('baslik');

    expect($faaliyetler['Yıllı']->tarih->format('Y-m-d'))->toBe('2020-01-01')
        ->and($faaliyetler['Yılsız']->tarih)->toBeNull();
});

/**
 * Okunan kademe o kategorinin sözlüğünde yoksa yazılmamalı: cetvelde
 * karşılığı olmayan etiket faaliyeti sessizce puansız bırakır.
 */
test('kategoride geçerli olmayan kademe yazılmıyor', function () {
    $kullanici = User::factory()->create();

    // Kitap bölümünde "TR Dizin" diye bir kademe yok.
    avesisTaklidi(['Kitaplar' => [['id' => uuid(1), 'baslik' => 'Kitabım', 'filtre' => 'trdizin']]]);

    $bilesen = Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('avesisAdres', 'avesis.ktu.edu.tr/kullanici')
        ->call('avesisGetir');

    expect($bilesen->get('avesisBulunanlar')[0]['kaynak'])->toBeNull();
});

test('zaten eklenmiş avesis kaydı işaretlenemiyor', function () {
    $kullanici = User::factory()->create();

    Faaliyet::factory()->for($kullanici)->create(['meta' => ['avesis_id' => uuid(1)]]);

    avesisTaklidi(['Makaleler' => [['id' => uuid(1), 'baslik' => 'Zaten var']]]);

    $bilesen = Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'avesis.ktu.edu.tr/kullanici')
        ->call('avesisGetir')
        ->assertSee('Zaten ekli');

    expect($bilesen->get('avesisBulunanlar')[0]['ekli_sebep'])->toBe('kayit');

    $bilesen->set('avesisSecilenler', [uuid(1)])->call('avesistenEkle');

    expect($kullanici->faaliyetler()->count())->toBe(1);
});

test('avesis dışı adres istek atmadan reddediliyor', function () {
    $kullanici = User::factory()->create();
    Http::fake();

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'https://evil.example.com/profil')
        ->call('avesisGetir')
        ->assertOk()
        ->assertSee('Adresi tanıyamadım');

    Http::assertNothingSent();
});

test('avesis adresi profilden ön doluyor', function () {
    $kullanici = User::factory()->create(['avesis_id' => 'https://avesis.deu.edu.tr/birisi']);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->assertSet('avesisAdres', 'https://avesis.deu.edu.tr/birisi');
});

// ────────────────── BİLİMSEL FAALİYETLER / İDARİ GÖREVLER ──────────────────

/**
 * Bölümlü sayfa taklidi (bilimselfaaliyetler, deneyim).
 *
 * @param  array<string, list<array<string, string>>>  $bolumler
 */
function avesisBolumSayfasi(array $bolumler): string
{
    $html = '';

    foreach ($bolumler as $ad => $ogeler) {
        $govde = '';

        foreach ($ogeler as $o) {
            $etiket = isset($o['etiket']) ? '<span class="shaded-label">'.$o['etiket'].'</span>' : '';
            $duzey = isset($o['duzey']) ? '<span style="font-size: 90%; font-weight: bold; color: #aaa">'.$o['duzey'].'</span>' : '';
            $bag = isset($o['id'])
                ? '<span><a target="_blank" href="/yonetilen-tez/'.$o['id'].'/slug"><strong>'.$o['baslik'].'</strong></a></span>'
                : '<strong>'.$o['baslik'].'</strong>';
            // Gerçek sayfada `citation` description'ın İÇİNDE duruyor;
            // tezin düzeyi ("Yüksek Lisans, 2019") oradan okunuyor.
            $ek = isset($o['citation']) ? '<div class="citation">'.$o['citation'].'</div>' : '';

            $govde .= '<li>'.$duzey.'<h3 class="title">'.$etiket.' '.$bag.'</h3>'
                .'<div class="description"><p>'.($o['aciklama'] ?? '').'</p>'.$ek.'</div></li>';
        }

        $html .= '<div class="ac-item open"><div class="item-head"><span>'.$ad
            .'</span><span class="badge">'.count($ogeler).'</span></div>'
            .'<div class="item-body"><ul>'.$govde.'</ul></div></div>';
    }

    return "<html><body>{$html}</body></html>";
}

/**
 * @param  array<string, list<array<string, string>>>  $bilimsel
 * @param  array<string, list<array<string, string>>>  $deneyim
 */
function avesisSayfaTaklidi(array $bilimsel = [], array $deneyim = []): void
{
    Http::fake([
        '*/yayinlar' => Http::response(avesisYayinSayfasi([])),
        '*/projeler' => Http::response(avesisProjeSayfasi([])),
        '*/bilimselfaaliyetler' => Http::response(avesisBolumSayfasi($bilimsel)),
        '*/deneyim' => Http::response(avesisBolumSayfasi($deneyim)),
    ]);
}

/**
 * @return list<array<string, mixed>>
 */
function avesisOku(): array
{
    return array_values(array_filter(
        avesis()->kayitlar(avesis()->adres('avesis.ktu.edu.tr/kullanici')),
        fn (array $k): bool => ! $k['atlandi'],
    ));
}

test('idari görev unvanı kademeye çevriliyor', function (string $unvan, ?string $kaynak) {
    avesisSayfaTaklidi(deneyim: ['Yönetimsel Görevler' => [
        ['baslik' => $unvan, 'etiket' => '2001 - 2004', 'aciklama' => 'Bir Üniversite'],
    ]]);

    $kayit = avesisOku()[0];

    expect($kayit['kategori'])->toBe('idari_gorev')
        ->and($kayit['kaynak'])->toBe($kaynak)
        ->and($kayit['yil'])->toBe(2004);
})->with([
    // Sıra tuzağı: "Müdür Yardımcısı" içinde "Müdür" geçiyor.
    ['Yüksekokul Müdür Yardımcısı', 'Dekan Yrd. / Müdür Yrd.'],
    ['Enstitü Müdürü', 'Dekan / Enstitü-YO Müdürü'],
    ['Rektör Yardımcısı', 'Rektör Yardımcısı'],
    ['Bölüm Başkan Yardımcısı', 'Bölüm Başkan Yardımcısı'],
    ['Bölüm Başkanı', 'Bölüm Başkanı'],
    ['Yönetim Kurulu Üyesi', 'Kurul / Komisyon Üyeliği'],
    ['Bilinmeyen Bir Görev', null],
]);

test('yönetilen tez düzeyiyle okunuyor', function () {
    avesisSayfaTaklidi(deneyim: ['Yönetilen Tezler' => [
        ['id' => uuid(5), 'baslik' => 'Bir yüksek lisans tezi başlığı', 'citation' => 'A.Yılmaz(Öğrenci), Yüksek Lisans, 2019'],
        ['id' => uuid(6), 'baslik' => 'Bir doktora tezi başlığı', 'citation' => 'B.Kurt(Öğrenci), Doktora, 2021'],
    ]]);

    $kayitlar = avesisOku();

    expect($kayitlar[0]['kategori'])->toBe('tez_danismanligi')
        ->and($kayitlar[0]['kaynak'])->toBe('Yüksek Lisans Tezi')
        ->and($kayitlar[0]['id'])->toBe(uuid(5))
        ->and($kayitlar[1]['kaynak'])->toBe('Doktora Tezi');
});

/**
 * Tek bir `<li>` aynı düzeydeki birkaç dersi birden taşıyor: düzey etiketi
 * ortak, her ders ayrı başlık.
 */
test('bir li içindeki birden çok ders ayrı ayrı okunuyor', function () {
    // Http::fake() art arda çağrılınca eski kurallar silinmiyor, ekleniyor
    // ve İLKİ kazanıyor — tek taklit kurulmalı.
    Http::fake([
        '*/yayinlar' => Http::response(avesisYayinSayfasi([])),
        '*/projeler' => Http::response(avesisProjeSayfasi([])),
        '*/bilimselfaaliyetler' => Http::response(avesisBolumSayfasi([])),
        '*/deneyim' => Http::response(
            '<html><body><div class="ac-item"><div class="item-head"><span>Verdiği Dersler</span></div>'
            .'<div class="item-body"><ul><li>'
            .'<span style="font-size: 90%; font-weight: bold; color: #aaa">Yüksek Lisans</span>'
            .'<h3 class="title"> Birinci Ders Adı </h3><h3 class="title"> İkinci Ders Adı </h3>'
            .'</li></ul></div></div></body></html>'
        ),
    ]);

    $kayitlar = avesisOku();

    expect($kayitlar)->toHaveCount(2)
        ->and(array_column($kayitlar, 'baslik'))->toBe(['Birinci Ders Adı', 'İkinci Ders Adı'])
        // "Yüksek Lisans" içinde "Lisans" geçiyor; üst düzey önce denenmeli.
        ->and($kayitlar[0]['kaynak'])->toBe('Lisansüstü Ders');
});

test('hakemlik ve yayın kurulu üyeliği ayrışıyor', function () {
    avesisSayfaTaklidi(bilimsel: [
        'Bilimsel Dergilerdeki Faaliyetler' => [['baslik' => 'Bir Dergi', 'etiket' => '2018 - Devam Ediyor', 'aciklama' => 'Değerlendirme Kurul Üyesi']],
        'Bilimsel Yayınlarda Hakemlikler' => [['baslik' => 'Başka Dergi', 'etiket' => 'Nisan 2019', 'aciklama' => 'Hakemli Bilimsel Dergi']],
        // Proje hakemliği yayın hakemliği değil: kademe boş kalıyor.
        'Bilimsel Projelerde Hakemlikler' => [['baslik' => 'TÜBİTAK Projesi', 'etiket' => 'Haziran 2014']],
    ]);

    $kaynaklar = array_column(avesisOku(), 'kaynak', 'baslik');

    expect($kaynaklar)->toBe([
        'Bir Dergi' => 'Yayın Kurulu Üyeliği',
        'Başka Dergi' => 'Hakemlik',
        'TÜBİTAK Projesi' => null,
    ]);
});

/**
 * Jüri üyeliklerinin yalnız TEZ ile ilgili olanları sözlükte karşılık
 * buluyor. Personel sınavı jürisini uydurma bir kategoriye atmak adayın
 * listesini kirletirdi; atlanıyor ve sayısı ekranda yazıyor.
 */
test('tez dışı jüri üyeliği atlanıyor', function () {
    avesisSayfaTaklidi(bilimsel: ['Jüri Üyelikleri' => [
        ['baslik' => 'Tez Savunma (Doktora)', 'etiket' => 'Ocak 2019', 'aciklama' => 'Bir Üniversite'],
        ['baslik' => 'Doktora Yeterlik Sınavı', 'etiket' => 'Ağustos 2018', 'aciklama' => 'Bir Üniversite'],
        ['baslik' => 'Akademik Personel Sınavı', 'etiket' => 'Ocak 2019', 'aciklama' => 'Doktora Giriş sınavı'],
    ]]);

    $kayitlar = avesisOku();

    expect($kayitlar)->toHaveCount(2)
        ->and($kayitlar[0]['kategori'])->toBe('tez_danismanligi')
        ->and($kayitlar[0]['kaynak'])->toBe('Tez İzleme / Jüri Üyeliği');
});

/**
 * "Akademik Ünvanlar" ve "Akademi Dışı Deneyim" profil bilgisi — faaliyet
 * değil. Listeye girmemeli ama sayısı adaya söylenmeli.
 */
test('profil bilgisi bölümleri atlanıyor ve sayısı ekranda yazıyor', function () {
    $kullanici = User::factory()->create();

    avesisSayfaTaklidi(deneyim: [
        'Akademik Ünvanlar' => [['baslik' => 'Prof. Dr.', 'etiket' => '2019 - Devam Ediyor']],
        'Akademi Dışı Deneyim' => [['baslik' => 'Öğretim Görevlisi', 'etiket' => '1997 - 2011']],
        'Yönetimsel Görevler' => [['baslik' => 'Bölüm Başkanı', 'etiket' => '2001 - 2004']],
    ]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'avesis.ktu.edu.tr/kullanici')
        ->call('avesisGetir')
        ->assertSet('avesisAtlanan', 2)
        ->assertSee('2 kayıt eşlenemedi')
        ->assertSee('Bölüm Başkanı')
        ->assertDontSee('Öğretim Görevlisi');
});

/**
 * AYNI GÖREV İKİ AYRI DÖNEM ayrı ayrı sayılıyor. Bir yayının adı onu tek
 * başına tanımlar, bir görevin adı tanımlamaz — mükerrer izi yayın dışı
 * kategorilerde yılı da içeriyor.
 */
test('aynı görev farklı dönemde mükerrer sayılmıyor', function () {
    $kullanici = User::factory()->create();

    avesisSayfaTaklidi(deneyim: ['Yönetimsel Görevler' => [
        ['baslik' => 'Yüksekokul Müdür Yardımcısı', 'etiket' => '2001 - 2004'],
        ['baslik' => 'Yüksekokul Müdür Yardımcısı', 'etiket' => '2010 - 2013'],
    ]]);

    Livewire::actingAs($kullanici)->test(FaaliyetEkle::class)
        ->set('sekme', 'avesis')
        ->set('avesisAdres', 'avesis.ktu.edu.tr/kullanici')
        ->call('avesisGetir')
        ->call('avesisTumunuSec')
        ->call('avesistenEkle');

    $faaliyetler = $kullanici->faaliyetler()->get();

    expect($faaliyetler)->toHaveCount(2)
        ->and($faaliyetler->pluck('tarih')->map(fn ($t) => $t->year)->sort()->values()->all())->toBe([2004, 2013])
        ->and($faaliyetler->first()->kaynak)->toBe('Dekan Yrd. / Müdür Yrd.');
});
