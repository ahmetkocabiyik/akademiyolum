<?php

use App\Enums\JuriAdimi;
use App\Enums\JuriAgirligi;
use App\Enums\Kategori;
use App\Livewire\CiktiYonetimi;
use App\Models\Faaliyet;
use App\Models\JuriRaporu;
use App\Models\User;
use App\Services\Cikti\RaporDerleyici;
use App\Services\Scoring\Sart\SartDeposu;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    // İki kurum, aynı cetvel: Test 50 puan, Zor 200 puan istiyor.
    $esik = fn (string $anahtar, string $universite, int $baraj) => [
        'anahtar' => $anahtar, 'universite' => $universite,
        'kadro' => 'docentlik', 'alan' => 'ilahiyat', 'birim' => null,
        'cetvel' => 'test-cetvel', 'notlar' => '',
        'sart' => ['tip' => 'puan', 'rol' => 'toplam', 'aciklama' => 'Toplam puan',
            'maddeler' => ['*'], 'min_puan' => $baraj],
    ];

    app()->instance(SartDeposu::class, new SartDeposu(
        esikVerisi: [
            $esik('test-doc', 'Test Üniversitesi', 50),
            $esik('zor-doc', 'Zor Üniversitesi', 200),
        ],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => [
            'M1' => ['baslik' => 'Q2 makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 40],
            'M2' => ['baslik' => 'TR Dizin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 20],
            'T1' => ['baslik' => 'Doktora danışmanlığı', 'kategori' => 'tez_danismanligi', 'puan' => 5],
        ]]],
    ));

    // Dr. Öğr. Üyesi → hedef kadro doçentlik.
    $this->user = User::factory()->onboarded()->create([
        'name' => 'Ayşe Yılmaz',
        'unvan' => 'Dr. Öğr. Üyesi',
        'universite' => 'Test Üniversitesi',
        'temel_alan' => 'ilahiyat',
        'doktora_tarihi' => '2018-06-01',
    ]);

    $this->q2 = Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::Makale, 'baslik' => 'Eski Q2 makale', 'kaynak' => 'SCIE/SSCI (Q2)', 'tarih' => '2016-03-01',
    ]);
    $this->trDizin = Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::Makale, 'baslik' => 'Yeni TR Dizin makale', 'kaynak' => 'TR Dizin', 'tarih' => now()->subMonths(3),
    ]);

    actingAs($this->user);
});

test('çıktı yönetimi sayfası açılır, ayarlar ve rapor önizlemesi görünür', function () {
    $this->get(route('cikti-yonetimi'))
        ->assertOk()
        ->assertSee(['Rapor Şablonu', 'Rapor Bilgileri', 'İçerik Seçimi', 'Akademik Faaliyet Raporu — '.now()->year])
        ->assertSee('Ayşe Yılmaz')
        ->assertSee('id="rapor-sayfa"', escape: false);
});

test('varsayılan hedef adayın kendi üniversitesi ve bir üst kadrosu', function () {
    Livewire::test(CiktiYonetimi::class)
        ->assertSet('hedefKadro', 'docentlik')
        ->assertSet('hedefKurum', 'Test Üniversitesi')
        ->assertSet('kurumlar', ['Test Üniversitesi', 'Zor Üniversitesi']);
});

test('rapordaki puan yönerge motoruyla aynı: tavanlı toplam, baraj ve ilerleme', function () {
    $rapor = Livewire::test(CiktiYonetimi::class)->get('rapor');

    expect($rapor['hedef'])->toBe(['universite' => 'Test Üniversitesi', 'kadro' => 'Doçent'])
        ->and($rapor['ozet']['toplam'])->toBe(60)
        ->and($rapor['ozet']['baraj'])->toBe(50)
        ->and($rapor['ozet']['oran'])->toBe(100)
        ->and($rapor['ozet']['faaliyet'])->toBe(2)
        // Test (50) karşılanıyor, Zor (200) karşılanmıyor.
        ->and($rapor['ozet']['uygunKurum'])->toBe(1)
        ->and($rapor['ozet']['kurum'])->toBe(2)
        ->and(array_column($rapor['universiteler'], 'ad'))->toBe(['Test Üniversitesi', 'Zor Üniversitesi']);
});

test('telafi ile sağlanan koşul sayaçla değil adıyla basılır', function () {
    // Ana yol: tez danışmanlığından 5 puan (adayda yok). Telafi: TR Dizin makalesinden 20 puan.
    app()->instance(SartDeposu::class, new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'test-doc', 'universite' => 'Test Üniversitesi',
            'kadro' => 'docentlik', 'alan' => 'ilahiyat', 'birim' => null,
            'cetvel' => 'test-cetvel', 'notlar' => '',
            'sart' => ['tip' => 've', 'aciklama' => 'Tüm koşullar', 'cocuklar' => [[
                'tip' => 'puan', 'aciklama' => 'Tez danışmanlığından 5 puan', 'maddeler' => ['T1'], 'min_puan' => 5,
                'telafi' => ['tip' => 'puan', 'aciklama' => 'Yerine TR Dizin makalesi', 'maddeler' => ['M2'], 'min_puan' => 20],
            ]]],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => [
            'M2' => ['baslik' => 'TR Dizin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 20],
            'T1' => ['baslik' => 'Doktora danışmanlığı', 'kategori' => 'tez_danismanligi', 'puan' => 5],
        ]]],
    ));

    $bilesen = Livewire::test(CiktiYonetimi::class);
    $kosul = collect($bilesen->get('rapor')['kosullar'])->firstWhere('aciklama', 'Tez danışmanlığından 5 puan');

    expect($kosul['not'])->toBe('Telafi ile sağlandı')
        ->and($kosul['mevcut'])->toBe(0);

    $bilesen->assertSee('Telafi ile sağlandı')->assertDontSee('0 / 5');
});

test('beklemedeki faaliyet rapora ve puana girmez', function () {
    Faaliyet::factory()->for($this->user)->beklemede()->create([
        'kategori' => Kategori::Makale, 'baslik' => 'Onay bekleyen makale', 'kaynak' => 'SCIE/SSCI (Q2)',
    ]);

    Livewire::test(CiktiYonetimi::class)
        ->assertDontSee('Onay bekleyen makale')
        ->assertSet('rapor.ozet.toplam', 60);
});

test('tarih aralığı listeleri daraltır ama puanı değiştirmez', function () {
    Livewire::test(CiktiYonetimi::class)
        ->set('aralik', 'son1')
        ->assertSee('Yeni TR Dizin makale')
        ->assertDontSee('Eski Q2 makale')
        ->assertSet('rapor.ozet.toplam', 60)
        ->set('aralik', 'doktora')
        ->assertDontSee('Eski Q2 makale')
        ->set('aralik', 'tum')
        ->assertSee('Eski Q2 makale');
});

test('tarihsiz faaliyet yalnızca tüm dönem raporunda listelenir', function () {
    Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::Makale, 'baslik' => 'Tarihsiz makale', 'kaynak' => 'TR Dizin', 'tarih' => null,
    ]);

    Livewire::test(CiktiYonetimi::class)
        ->assertSee('Tarihsiz makale')
        ->set('aralik', 'son5')
        ->assertDontSee('Tarihsiz makale');
});

test('geçersiz aralık, kadro ve kurum yazılmaz', function () {
    Livewire::test(CiktiYonetimi::class)
        ->set('aralik', 'son100')
        ->assertSet('aralik', 'tum')
        ->set('hedefKurum', 'Uydurma Üniversitesi')
        ->assertSet('hedefKurum', '')
        ->set('hedefKadro', 'rektor')
        ->assertSet('hedefKadro', 'docentlik');
});

test('hedef seçilmeden puan basılmaz, faaliyetler yine listelenir', function () {
    Livewire::test(CiktiYonetimi::class)
        ->set('hedefKurum', '')
        ->assertSet('rapor.hedef', null)
        ->assertSet('rapor.ozet.toplam', null)
        ->assertSee('Yeni TR Dizin makale')
        ->assertSee('Hedef kurum seçilmeden puan ve koşullar basılmaz');
});

test('kadro değişince hedef yeniden kendi üniversitesine bakar', function () {
    // Profesörlük için eşik yok: kurum listesi boşalır, hedef düşer.
    Livewire::test(CiktiYonetimi::class)
        ->set('hedefKadro', 'profesorluk')
        ->assertSet('kurumlar', [])
        ->assertSet('hedefKurum', '');
});

test('kapatılan bölüm rapordan düşer, açılan bölüm basılır', function () {
    Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::TezDanismanligi, 'baslik' => 'Danışılan doktora tezi', 'rol' => 'danisman',
    ]);

    Livewire::test(CiktiYonetimi::class)
        ->assertDontSee('Danışılan doktora tezi')
        ->call('bolumDegistir', 'tez')
        ->assertSee('Danışılan doktora tezi')
        ->call('bolumDegistir', 'faaliyetler')
        ->assertDontSee('Yeni TR Dizin makale')
        ->call('bolumDegistir', 'ozet')
        ->assertDontSee('Onaylı faaliyet')
        ->call('bolumDegistir', 'yok-boyle')
        ->assertSet('bolumler', [
            'ozet' => false, 'faaliyetler' => false, 'hedef' => true,
            'tez' => true, 'katki' => false, 'juri' => true,
        ]);
});

test('tez danışmanlığı ana listede değil kendi bölümünde', function () {
    Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::TezDanismanligi, 'baslik' => 'Danışılan doktora tezi',
    ]);

    $rapor = Livewire::test(CiktiYonetimi::class)->get('rapor');

    expect(array_keys($rapor['faaliyetler']))->toBe([Kategori::Makale->label()])
        ->and(array_column($rapor['tezDanismanligi'], 'baslik'))->toBe(['Danışılan doktora tezi']);
});

test('jüri özeti seçili hedefin en yeni raporundan gelir', function () {
    JuriRaporu::factory()->for($this->user)->create([
        'universite' => 'Test Üniversitesi', 'ozet' => 'Eski özet.',
    ]);
    JuriRaporu::factory()->for($this->user)->create([
        'universite' => 'Test Üniversitesi',
        'ozet' => 'Dosya güçlü, uluslararası yayın az.',
        'adimlar' => [JuriAdimi::Plan->value => ['agirlik' => JuriAgirligi::Bilgi->value, 'icerik' => 'Bir SSCI makalesi hedefleyin.']],
    ]);
    JuriRaporu::factory()->for($this->user)->create([
        'universite' => 'Zor Üniversitesi', 'ozet' => 'Başka kurumun özeti.',
    ]);

    Livewire::test(CiktiYonetimi::class)
        ->assertSee('Dosya güçlü, uluslararası yayın az.')
        ->assertSee('Bir SSCI makalesi hedefleyin.')
        ->assertDontSee('Eski özet.')
        ->assertDontSee('Başka kurumun özeti.');
});

test('jüri raporu yoksa bölüm basılmaz, aday nereden üreteceğini görür', function () {
    Livewire::test(CiktiYonetimi::class)
        ->assertSet('rapor.juri', null)
        ->assertDontSee('Stratejik tamamlama planı')
        ->assertSee('Bu hedef için jüri raporu yok; YZ Jüri Analizi');
});

test('şablon yalnızca tanınan değerleri kabul eder ve sayfaya yazılır', function () {
    Livewire::test(CiktiYonetimi::class)
        ->assertSee('Kurumsal')
        ->assertDontSee('Prestijli')
        ->call('sablonSec', 'prestijli')
        ->assertSee('rapor-sayfa rapor-prestijli', escape: false)
        ->call('sablonSec', 'resmi')
        ->assertSet('sablon', 'prestijli');
});

test('rapor başlığı boş ya da çok uzun olamaz', function () {
    Livewire::test(CiktiYonetimi::class)
        ->set('baslik', '')
        ->assertHasErrors(['baslik' => 'required'])
        ->set('baslik', str_repeat('a', 121))
        ->assertHasErrors(['baslik' => 'max'])
        ->set('baslik', '2026 Doçentlik Dosyası')
        ->assertHasNoErrors()
        ->assertSee('2026 Doçentlik Dosyası');
});

test('excel indirmesi türkçe excelin açtığı csv: bom, noktalı virgül, hedef puanı', function () {
    $yanit = Livewire::test(CiktiYonetimi::class)
        ->call('excelIndir')
        ->assertFileDownloaded('akademik-faaliyetler-'.now()->format('Y-m-d').'.csv');

    $icerik = base64_decode($yanit->effects['download']['content']);

    expect($icerik)->toStartWith("\xEF\xBB\xBF")
        ->and($icerik)->toContain('Kategori;Başlık;Tür;Yazarlar;"Kaynak / Kademe";Yıl;"Puan (Test Üniversitesi)"')
        ->and($icerik)->toContain('Yeni TR Dizin makale')
        ->and($icerik)->toContain(';20')
        ->and($icerik)->toContain(';40');
});

test('başka kullanıcının faaliyetleri rapora girmez', function () {
    Faaliyet::factory()->for(User::factory())->create(['baslik' => 'Yabancı makale']);

    Livewire::test(CiktiYonetimi::class)->assertDontSee('Yabancı makale');
});

test('yazdırmada rapor kendi adlı sayfasında, renkleri korunarak basılır', function () {
    $css = file_get_contents(resource_path('css/app.css'));

    preg_match('/@media print\s*\{(.*)\n\}/s', $css, $yazdirma);

    expect($yazdirma[1] ?? '')
        ->toMatch('/body:has\(#rapor-sayfa\)\s*\{\s*page:\s*rapor/')
        ->toMatch('/#rapor-sayfa\s*\{[^}]*(?<!-)print-color-adjust:\s*exact/')
        ->toMatch('/@page rapor\s*\{/');
});

test('derleyici aralık listesi ekrandaki seçeneklerle aynı', function () {
    expect(array_keys(RaporDerleyici::ARALIKLAR))->toBe(['tum', 'son1', 'son3', 'son5', 'doktora']);
});
