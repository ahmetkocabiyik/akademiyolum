<?php

use App\Enums\Kategori;
use App\Livewire\CvOlusturucu;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Cv\CvDuzeni;
use App\Services\Cv\KunyeYazici;
use Illuminate\Support\Carbon;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

/**
 * CV'nin künye satırları ve YÖK EK-4A dağıtımı.
 */
function kunyeFaaliyeti(Kategori $kategori, array $alanlar = []): Faaliyet
{
    return Faaliyet::factory()->create([
        'kategori' => $kategori, 'baslik' => 'Bir Başlık', 'yazarlar' => 'Kaya, A., Yılmaz, B.',
        'tarih' => '2024-03-01', 'kaynak' => null, 'rol' => null, 'meta' => null, 'durum' => 'onaylandi',
        ...$alanlar,
    ]);
}

test('makale künyesi: yazarlar, yıl, başlık, italik dergi, cilt(sayı), sayfa, doi', function () {
    $f = kunyeFaaliyeti(Kategori::Makale, ['meta' => ['dergi' => 'Dinbilimleri', 'cilt' => '12', 'sayi' => '2', 'sayfa' => '45-67', 'doi' => '10.1/x']]);

    expect((string) app(KunyeYazici::class)->yaz($f))
        ->toBe('Kaya, A., Yılmaz, B. (2024). Bir Başlık. <i>Dinbilimleri</i>, 12(2), 45-67. doi: 10.1/x');
});

test('künye html kaçışlı: başlıktaki etiket metin olarak basılır', function () {
    $f = kunyeFaaliyeti(Kategori::Makale, ['baslik' => '<script>x</script>', 'meta' => ['dergi' => 'A & B']]);

    expect((string) app(KunyeYazici::class)->yaz($f))
        ->toContain('&lt;script&gt;')->toContain('<i>A &amp; B</i>')->not->toContain('<script>');
});

test('yapılandırılmış alan yoksa içe aktarılan ham künyenin ilk parçası kullanılır', function () {
    $f = kunyeFaaliyeti(Kategori::Makale, ['meta' => ['kunye' => 'Kilis İlahiyat Dergisi, vol. 13, no. 1, pp. 313–343 · Uluslararası']]);

    expect((string) app(KunyeYazici::class)->yaz($f))
        ->toBe('Kaya, A., Yılmaz, B. (2024). Bir Başlık. Kilis İlahiyat Dergisi, vol. 13, no. 1, pp. 313–343.');
});

test('kitap bölümü: editör ve kitap adı, yer: yayınevi', function () {
    $f = kunyeFaaliyeti(Kategori::Kitap, ['meta' => ['kitap_adi' => 'Kelam Tarihi', 'editor' => 'Ali Veli', 'sayfa' => '10-30', 'yer' => 'Ankara', 'yayinevi' => 'Fecr']]);

    expect((string) app(KunyeYazici::class)->yaz($f))
        ->toBe('Kaya, A., Yılmaz, B. (2024). Bir Başlık. Ali Veli (Ed.), <i>Kelam Tarihi</i> (s. 10-30). Ankara: Fecr.');
});

test('proje künyesi kurum, proje no, rol ve dönem taşır', function () {
    $f = kunyeFaaliyeti(Kategori::Proje, ['rol' => 'yurutucu', 'kaynak' => 'TÜBİTAK', 'meta' => ['kurum' => 'TÜBİTAK 1001', 'proje_no' => '123K456']]);

    expect((string) app(KunyeYazici::class)->yaz($f))
        ->toBe('Bir Başlık. TÜBİTAK 1001, Proje No: 123K456, Yürütücü / koordinatör. 2024–devam ediyor.');
});

test('kapsam kaynaktan, kaynak boşsa ham künyenin etiketinden okunur', function () {
    $yazici = app(KunyeYazici::class);

    expect($yazici->siniflandir(kunyeFaaliyeti(Kategori::Makale, ['kaynak' => 'SCIE/SSCI (Q1)'])))->toBe(['dergi', 'uluslararasi'])
        ->and($yazici->siniflandir(kunyeFaaliyeti(Kategori::Makale, ['kaynak' => 'TR Dizin'])))->toBe(['dergi', 'ulusal'])
        ->and($yazici->siniflandir(kunyeFaaliyeti(Kategori::Bildiri, ['kaynak' => 'Ulusal Özet/Poster'])))->toBe(['bildiri', 'ulusal'])
        ->and($yazici->siniflandir(kunyeFaaliyeti(Kategori::Kitap, ['kaynak' => 'Uluslararası/Ulusal Kitap'])))->toBe(['kitap', null])
        ->and($yazici->siniflandir(kunyeFaaliyeti(Kategori::TezYayini, ['kaynak' => 'CPCI Bildiri'])))->toBe(['bildiri', 'uluslararasi'])
        ->and($yazici->siniflandir(kunyeFaaliyeti(Kategori::Makale, ['meta' => ['kunye' => 'Dergi · Ulusal']])))->toBe(['dergi', 'ulusal'])
        // YÖKSİS'in sınıflandırması dizinden önce: TR Dizin dergisi uluslararası olabilir.
        ->and($yazici->siniflandir(kunyeFaaliyeti(Kategori::Makale, ['kaynak' => 'TR Dizin', 'meta' => ['kunye' => 'Dergi, vol. 1 · Uluslararası']])))->toBe(['dergi', 'uluslararasi']);
});

test('EK-4A yayınları 7.1–7.6ya dağıtır; kapsamı bilinmeyen 7.6ya düşer, hiçbiri kaybolmaz', function () {
    $faaliyetler = collect([
        kunyeFaaliyeti(Kategori::Makale, ['baslik' => 'Q1 makale', 'kaynak' => 'SCIE/SSCI (Q1)']),
        kunyeFaaliyeti(Kategori::Bildiri, ['baslik' => 'Uluslararası bildiri', 'kaynak' => 'Uluslararası Tam Metin']),
        kunyeFaaliyeti(Kategori::Kitap, ['baslik' => 'BKCI kitap', 'kaynak' => 'BKCI / Scopus Kitap']),
        kunyeFaaliyeti(Kategori::Makale, ['baslik' => 'TR Dizin makale', 'kaynak' => 'TR Dizin']),
        kunyeFaaliyeti(Kategori::Bildiri, ['baslik' => 'Ulusal bildiri', 'kaynak' => 'Ulusal Tam Metin']),
        kunyeFaaliyeti(Kategori::Kitap, ['baslik' => 'Ulusal kitap', 'kaynak' => 'Ulusal Kitap']),
        kunyeFaaliyeti(Kategori::Makale, ['baslik' => 'Kaynaksız makale']),
    ]);

    $yayinlar = collect(app(CvDuzeni::class)->ek4a($faaliyetler, now())['yayinlar'])
        ->map(fn (array $kayitlar) => collect($kayitlar)->map(fn ($k) => str(strip_tags((string) $k))->betweenFirst('(2024). ', '.')->value())->all());

    expect($yayinlar->all())->toBe([
        '7.1' => ['Q1 makale'],
        '7.2' => ['Uluslararası bildiri'],
        '7.3' => ['BKCI kitap'],
        '7.4' => ['TR Dizin makale'],
        '7.5' => ['Ulusal bildiri'],
        '7.6' => ['Ulusal kitap', 'Kaynaksız makale'],
    ]);
});

test('EK-4A tezleri düzeye göre ayırır, jüri üyeliğini almaz', function () {
    $ek = app(CvDuzeni::class)->ek4a(collect([
        kunyeFaaliyeti(Kategori::TezDanismanligi, ['kaynak' => 'Yüksek Lisans Tezi']),
        kunyeFaaliyeti(Kategori::TezDanismanligi, ['kaynak' => 'Doktora Tezi']),
        kunyeFaaliyeti(Kategori::TezDanismanligi, ['kaynak' => 'Tez İzleme / Jüri Üyeliği']),
    ]), now());

    expect($ek['tezler']['yuksek_lisans'])->toHaveCount(1)
        ->and($ek['tezler']['doktora'])->toHaveCount(1);
});

test('EK-4A ders tablosu son iki akademik yılı alır, lisansüstü dersi işaretler, sıralar', function () {
    $bugun = Carbon::parse('2026-10-17');

    $ek = app(CvDuzeni::class)->ek4a(collect([
        kunyeFaaliyeti(Kategori::EgitimOgretim, ['baslik' => 'Eski ders', 'kaynak' => 'Lisans/Önlisans Ders', 'meta' => ['akademik_yil' => '2023-2024']]),
        kunyeFaaliyeti(Kategori::EgitimOgretim, ['baslik' => 'Bahar dersi', 'kaynak' => 'Lisans/Önlisans Ders', 'meta' => ['akademik_yil' => '2025-2026', 'yariyil' => 'Bahar']]),
        kunyeFaaliyeti(Kategori::EgitimOgretim, ['baslik' => 'Güz dersi', 'kaynak' => 'Lisansüstü Ders', 'meta' => ['akademik_yil' => '2025-2026', 'yariyil' => 'Güz', 'teorik' => '3', 'ogrenci_sayisi' => '12']]),
        kunyeFaaliyeti(Kategori::EgitimOgretim, ['baslik' => 'Bu yılın dersi', 'kaynak' => 'Lisans/Önlisans Ders', 'meta' => ['akademik_yil' => '2026-2027', 'yariyil' => 'Güz']]),
        kunyeFaaliyeti(Kategori::EgitimOgretim, ['baslik' => 'Akreditasyon', 'kaynak' => 'Akreditasyon Faaliyeti', 'meta' => ['akademik_yil' => '2026-2027']]),
    ]), $bugun);

    expect(array_column($ek['dersler'], 'ad'))->toBe(['Bu yılın dersi', 'Güz dersi', 'Bahar dersi'])
        ->and($ek['dersler'][1])->toMatchArray(['teorik' => '3', 'ogrenci' => '12', 'lisansustu' => true]);
});

test('YÖK formatı seçilince EK-4A çizilir; tasarım ayarları gizlenir', function () {
    $user = User::factory()->onboarded()->create();
    Faaliyet::factory()->for($user)->create([
        'kategori' => Kategori::Makale, 'baslik' => 'Uluslararası Makalem', 'kaynak' => 'SCIE/SSCI (Q2)', 'durum' => 'onaylandi',
    ]);
    actingAs($user);

    $html = Livewire::test(CvOlusturucu::class)
        ->call('sablonSec', 'yok_ek4a')
        ->assertSeeHtml('data-ek4a')
        ->assertSeeHtml('data-resmi-not')
        ->assertDontSee('Çizgi Rengi')
        ->html();

    $konumlar = array_map(
        fn (string $parca) => mb_strpos($html, $parca),
        ['ÖZGEÇMİŞ', '1. Adı Soyadı', '4. Öğrenim Durumu', '7.1. Uluslararası hakemli dergilerde', 'Uluslararası Makalem', '7.2.', '12. Son iki yılda'],
    );

    expect($konumlar)->not->toContain(false)
        ->and($konumlar)->toBe(collect($konumlar)->sort()->values()->all());
});

test('tasarımlı şablon faaliyetleri YÖKSİS başlıklarıyla ve künyeyle basar; atıflar listelenmez', function () {
    $user = User::factory()->onboarded()->create();
    Faaliyet::factory()->for($user)->create([
        'kategori' => Kategori::Makale, 'baslik' => 'Künyeli Makale', 'durum' => 'onaylandi', 'meta' => ['dergi' => 'Dinbilimleri'],
    ]);
    Faaliyet::factory()->for($user)->create(['kategori' => Kategori::Atif, 'baslik' => 'Bir atıf', 'durum' => 'onaylandi']);
    actingAs($user);

    Livewire::test(CvOlusturucu::class)
        ->assertSee('Makaleler')
        ->assertSeeHtml('<i>Dinbilimleri</i>')
        ->assertDontSee('Bir atıf');
});
