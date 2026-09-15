<?php

use App\Enums\Kategori;
use App\Enums\TemelAlan;
use App\Livewire\YonergeAnalizi;
use App\Models\BeyanOnayi;
use App\Models\Faaliyet;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Scoring\Sart\SartSonucu;
use Illuminate\Support\Str;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

const BEYAN_METNI = 'Doktora sonrası altı ay yurt dışında bulunmak';

/**
 * Test cetveli: kullanıcının 4 faaliyeti tam 70 puan eder.
 * makale Q2 20 + Q2 20 + kitap 20 + tez 10 = 70.
 *
 * @return array<string, array<string, mixed>>
 */
function testCetvelleri(): array
{
    return [
        'test-cetvel' => [
            'maddeler' => [
                'M1' => ['baslik' => 'Q1 makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 30],
                'M2' => ['baslik' => 'Q2 makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)', 'AHCI'], 'puan' => 20],
                'M3' => ['baslik' => 'TR Dizin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
                'M4' => ['baslik' => 'ESCI/Scopus makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 10],
                'K1' => ['baslik' => 'Kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap'], 'puan' => 20],
                'T1' => ['baslik' => 'Tez yayını', 'kategori' => 'tez_yayini', 'puan' => 10],
            ],
            'gruplar' => [
                'MAKALE' => ['M*'],
                'YAYIN' => ['M*', 'K*', 'T1'],
            ],
        ],
    ];
}

/**
 * Yalnızca toplam puan barajı taşıyan eşik kaydı.
 *
 * @param  list<array<string, mixed>>  $ekKosullar
 * @return array<string, mixed>
 */
function testEsik(string $universite, int $baraj, string $kadro = 'dr_ogr_uyesi', string $alan = 'ilahiyat', array $ekKosullar = []): array
{
    return [
        'anahtar' => Str::slug($universite)."-{$kadro}-{$alan}",
        'universite' => $universite,
        'kadro' => $kadro,
        'alan' => $alan,
        'birim' => null,
        'cetvel' => 'test-cetvel',
        'notlar' => "Test eşiği: {$baraj} puan.",
        'sart' => ['tip' => 've', 'aciklama' => 'Asgari şartlar', 'cocuklar' => array_merge([
            [
                'tip' => 'puan',
                'rol' => 'toplam',
                'aciklama' => "Tüm faaliyetlerden toplam en az {$baraj} puan",
                'maddeler' => ['*'],
                'min_puan' => $baraj,
            ],
        ], $ekKosullar)],
    ];
}

/**
 * Verilen eşiklerle depo bağlar (üretim veri dosyalarını devre dışı bırakır).
 *
 * @param  list<array<string, mixed>>  $esikler
 * @param  array<string, string>|null  $kaynakPdfleri  üniversite adı → PDF dosya adı
 */
function depoBagla(array $esikler, ?array $kaynakPdfleri = null): void
{
    app()->instance(SartDeposu::class, new SartDeposu($esikler, testCetvelleri(), $kaynakPdfleri));
}

beforeEach(function () {
    // Kontrollü 6 üniversite (belirli barajlar, hepsi Dr. Öğr. Üyesi / ilahiyat).
    $veriler = [
        ['Mersin Üniversitesi', 'Mersin', 'devlet', 90],
        ['Necmettin Erbakan Üniversitesi', 'Konya', 'devlet', 60],
        ['Ankara Üniversitesi', 'Ankara', 'devlet', 120],
        ['Marmara Üniversitesi', 'İstanbul', 'devlet', 100],
        ['İstanbul 29 Mayıs Üniversitesi', 'İstanbul', 'vakif', 55],
        ['Sakarya Üniversitesi', 'Sakarya', 'devlet', 80],
    ];

    $esikler = [];

    foreach ($veriler as [$ad, $sehir, $tur, $baraj]) {
        Universite::factory()->create(['ad' => $ad, 'sehir' => $sehir, 'tur' => $tur]);
        $esikler[] = testEsik($ad, $baraj);
    }

    $this->esikler = $esikler;
    depoBagla($esikler);

    // Arş. Gör. → varsayılan hedef kadro Dr. Öğr. Üyesi (eşiklerle uyumlu).
    $this->user = User::factory()->onboarded()->create(['unvan' => 'Arş. Gör.']);

    // Toplam 70 puan (test cetveline göre).
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCIE/SSCI (Q2)']);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCIE/SSCI (Q2)']);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Kitap, 'kaynak' => 'Uluslararası/Ulusal Kitap']);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::TezYayini, 'kaynak' => 'ESCI / Scopus']);

    actingAs($this->user);
});

test('durum sayaçları (özet) doğru hesaplanır', function () {
    // 70 puan: barajlar 55,60 uygun; 80 yakın (%88); 90,100,120 yetersiz.
    $ozet = Livewire::test(YonergeAnalizi::class)->instance()->ozet();

    expect($ozet['toplam'])->toBe(6)
        ->and($ozet['uygun'])->toBe(2)
        ->and($ozet['yakin'])->toBe(1)
        ->and($ozet['yetersiz'])->toBe(3)
        ->and($ozet['eksik_bilgi'])->toBe(0);
});

test('özet sayacına tıklayınca liste o duruma daralır', function () {
    // 70 puan / barajlar: 55,60 uygun · 80 yakın · 90,100,120 yetersiz.
    $bilesen = Livewire::test(YonergeAnalizi::class)
        ->call('durumSec', 'yetersiz')
        ->assertSet('durumFiltre', 'yetersiz');

    expect(array_column($bilesen->instance()->listelenen(), 'durum'))
        ->toBe(['yetersiz', 'yetersiz', 'yetersiz']);

    // Sayaçlar daralmaz: aday diğer durumların kaç tane olduğunu görmeye
    // devam etmeli, yoksa filtre kendi ölçüsünü yok eder.
    expect($bilesen->instance()->ozet())
        ->toBe(['toplam' => 6, 'uygun' => 2, 'eksik_bilgi' => 0, 'yakin' => 1, 'yetersiz' => 3, 'alan_yok' => 0]);
});

test('aynı sayaca yeniden tıklamak filtreyi kaldırır', function () {
    $bilesen = Livewire::test(YonergeAnalizi::class)
        ->call('durumSec', 'uygun')
        ->assertSet('durumFiltre', 'uygun')
        ->call('durumSec', 'uygun')
        ->assertSet('durumFiltre', '');

    expect($bilesen->instance()->listelenen())->toHaveCount(6);
});

test('durum filtresi arama ve tür filtresiyle birlikte çalışır', function () {
    // Arama sonuçları 90 (yetersiz) ve 100 (yetersiz) barajlı ikisi; durum
    // filtresi bunların üstüne biniyor, yerlerine geçmiyor.
    $bilesen = Livewire::test(YonergeAnalizi::class)
        ->set('arama', 'Üniversitesi')
        ->call('durumSec', 'uygun');

    $adlar = array_map(fn (array $s) => $s['universite']->ad, $bilesen->instance()->listelenen());

    expect($adlar)->toBe(['İstanbul 29 Mayıs Üniversitesi', 'Necmettin Erbakan Üniversitesi']);
});

test('sonuç vermeyen durum filtresi temizleme düğmesi gösterir', function () {
    Livewire::test(YonergeAnalizi::class)
        ->call('durumSec', 'eksik_bilgi')
        ->assertSee('Seçili filtrelere uygun yönerge bulunamadı.')
        ->assertSee('Durum filtresini kaldır');
});

test('şehir filtresi listeyi o şehirle sınırlar', function () {
    $bilesen = Livewire::test(YonergeAnalizi::class)
        ->set('sehirFiltre', 'İstanbul');

    $adlar = array_map(fn (array $s) => $s['universite']->ad, $bilesen->instance()->listelenen());

    expect($adlar)->toBe(['İstanbul 29 Mayıs Üniversitesi', 'Marmara Üniversitesi']);
});

test('şehir seçenekleri Türkçe alfabe sırasında', function () {
    // PHP'nin düz `sort()`u 'İstanbul'u listenin DİBİNE atar (İ çok baytlı,
    // z'den büyük görünür). Sıra bozulursa bu test kırılır.
    expect(Livewire::test(YonergeAnalizi::class)->instance()->sehirler())
        ->toBe(['Ankara', 'İstanbul', 'Konya', 'Mersin', 'Sakarya']);
});

test('şehir seçenekleri yalnız yönergesi girili üniversitelerden gelir', function () {
    Universite::factory()->create(['ad' => 'Yönergesiz Üni', 'sehir' => 'Van', 'tur' => 'devlet']);

    expect(Livewire::test(YonergeAnalizi::class)->instance()->sehirler())
        ->not->toContain('Van');
});

test('görünüm grid ve list arasında değişir', function () {
    Livewire::test(YonergeAnalizi::class)
        ->assertSet('gorunum', 'grid')
        ->set('gorunum', 'list')
        ->assertSet('gorunum', 'list')
        ->assertOk();
});

test('karşılaştırma modu tabloyu gösterir', function () {
    Livewire::test(YonergeAnalizi::class)
        ->assertSet('karsilastirma', false)
        ->set('karsilastirma', true)
        ->assertSee('Kartlara Dön')
        ->assertSee('Min. Baraj')
        ->assertSee('Fark');
});

test('tüm üniversite yönergelerini listeler', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)->instance()->sonuclar();

    expect($sonuclar)->toHaveCount(6);
});

test('barajı karşılayan yönerge yapılabilir işaretlenir', function () {
    $sonuclar = collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
        ->keyBy(fn (array $s) => $s['universite']->ad);

    // İstanbul 29 Mayıs barajı 55 → 70 puan yeterli.
    $istanbul = $sonuclar['İstanbul 29 Mayıs Üniversitesi'];
    expect($istanbul['toplam'])->toBe(70)
        ->and($istanbul['yapilabilir'])->toBeTrue()
        ->and($istanbul['kalan'])->toBe(0);

    // Ankara barajı 120 → 50 puan eksik.
    $ankara = $sonuclar['Ankara Üniversitesi'];
    expect($ankara['yapilabilir'])->toBeFalse()
        ->and($ankara['kalan'])->toBe(50);
});

test('kullanıcının temel alanına göre doğru eşik seçilir', function () {
    Universite::factory()->create(['ad' => 'Alan Test Üni', 'tur' => 'devlet']);

    depoBagla(array_merge($this->esikler, [
        testEsik('Alan Test Üni', 50, alan: 'ilahiyat'),
        testEsik('Alan Test Üni', 150, alan: 'fen'),
    ]));

    $bul = fn () => collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
        ->first(fn (array $s) => $s['universite']->ad === 'Alan Test Üni');

    // İlahiyat kullanıcı (70 puan): kendi alanının eşiği (min 50) → uygun
    expect($bul()['baraj'])->toBe(50)
        ->and($bul()['durum'])->toBe('uygun');

    // Fen kullanıcısı: min 150 → yetersiz
    $this->user->update(['temel_alan' => 'fen']);
    expect($bul()['baraj'])->toBe(150)
        ->and($bul()['durum'])->toBe('yetersiz');
});

test('eşleşme tam alan eşleşmesidir, başka alana düşülmez', function () {
    // Gruplama/fallback yok: yönergede o alanın satırı yoksa üniversite listeye
    // girmez. Grup satırları veri dosyasında alan başına açılır.
    Universite::factory()->create(['ad' => 'Tam Eşleşme Üni', 'tur' => 'devlet']);

    depoBagla(array_merge($this->esikler, [testEsik('Tam Eşleşme Üni', 60, alan: 'sosyal')]));

    $bul = function (string $alan) {
        $this->user->update(['temel_alan' => $alan]);

        return collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
            ->first(fn (array $s) => $s['universite']->ad === 'Tam Eşleşme Üni');
    };

    expect($bul('sosyal'))->not->toBeNull()
        ->and($bul('sosyal')['baraj'])->toBe(60)
        ->and($bul('ilahiyat'))->toBeNull()
        ->and($bul('mimarlik'))->toBeNull();
});

test('hedef kadro değişince o kadronun eşiği kullanılır', function () {
    Universite::factory()->create(['ad' => 'Kadro Test Üni', 'tur' => 'devlet']);

    depoBagla(array_merge($this->esikler, [
        testEsik('Kadro Test Üni', 50, kadro: 'dr_ogr_uyesi'),
        testEsik('Kadro Test Üni', 300, kadro: 'docentlik'),
    ]));

    $baraj = fn (string $kadro) => collect(
        Livewire::test(YonergeAnalizi::class)->set('hedefKadro', $kadro)->instance()->sonuclar()
    )->first(fn (array $s) => $s['universite']->ad === 'Kadro Test Üni')['baraj'];

    expect($baraj('dr_ogr_uyesi'))->toBe(50)
        ->and($baraj('docentlik'))->toBe(300);
});

test('hedef kadro varsayılanı bir üst kadrodur', function () {
    $this->user->update(['unvan' => 'Dr. Öğr. Üyesi']);
    Livewire::test(YonergeAnalizi::class)->assertSet('hedefKadro', 'docentlik');

    $this->user->update(['unvan' => 'Doç. Dr.']);
    Livewire::test(YonergeAnalizi::class)->assertSet('hedefKadro', 'profesorluk');

    $this->user->update(['unvan' => 'Arş. Gör.']);
    Livewire::test(YonergeAnalizi::class)->assertSet('hedefKadro', 'dr_ogr_uyesi');
});

test('üniversite adına göre arama filtreler', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)
        ->set('arama', 'Mersin')
        ->instance()->sonuclar();

    expect($sonuclar)->toHaveCount(1)
        ->and($sonuclar[0]['universite']->ad)->toBe('Mersin Üniversitesi');
});

test('üniversite türüne göre filtreler', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)
        ->set('turFiltre', 'vakif')
        ->instance()->sonuclar();

    expect($sonuclar)->toHaveCount(1)
        ->and($sonuclar[0]['universite']->ad)->toBe('İstanbul 29 Mayıs Üniversitesi');
});

test('alt koşullar ağaç olarak değerlendirilir', function () {
    Universite::factory()->create(['ad' => 'Alt Koşul Üni', 'tur' => 'devlet']);

    depoBagla(array_merge($this->esikler, [
        testEsik('Alt Koşul Üni', 100, ekKosullar: [
            ['tip' => 'puan', 'aciklama' => 'Makalelerden en az 40 puan', 'maddeler' => ['MAKALE'], 'min_puan' => 40],
            ['tip' => 'adet', 'aciklama' => 'En az 3 yayın', 'maddeler' => ['YAYIN'], 'min_adet' => 3],
        ]),
    ]));

    $s = collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
        ->first(fn (array $s) => $s['universite']->ad === 'Alt Koşul Üni');

    $kosullar = collect($s['sonuc']->cocuklar)->keyBy('aciklama');

    // Üç koşuldan ikisi tam, biri %70 → eşleşme %90 ("yakın"), ama puan barajı
    // karşılanmadığı için başvuru hâlâ yapılamaz.
    expect($s['durum'])->toBe('yakin')
        ->and($s['oran'])->toBe(90)
        ->and($s['toplam'])->toBe(70)
        ->and($kosullar['Tüm faaliyetlerden toplam en az 100 puan']->saglandi())->toBeFalse()
        ->and($kosullar['Makalelerden en az 40 puan']->saglandi())->toBeTrue()   // 40 ≥ 40
        ->and($kosullar['En az 3 yayın']->saglandi())->toBeTrue();               // 4 ≥ 3
});

test('baraja göre artan sıralar', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)
        ->set('siralama', 'baraj_artan')
        ->instance()->sonuclar();

    expect(array_column($sonuclar, 'baraj'))->toBe([55, 60, 80, 90, 100, 120]);
});

test('profil doluluğu girilen akademik alanlara göre artar', function () {
    expect(Livewire::test(YonergeAnalizi::class)->instance()->profilDoluluk())->toBe(0);

    // Elle girilen 8 alandan 2'si dolu → %25. Atıf/proje/tez sayaçları bu orana
    // girmez; onların kaynağı Faaliyetler bölümüdür.
    $this->user->update(['doktora_tarihi' => '2020-01-01', 'yds_puani' => 75]);

    expect(Livewire::test(YonergeAnalizi::class)->instance()->profilDoluluk())->toBe(25);
});

test('karta tıklayınca detay modalı açılır ve dağılımı gösterir', function () {
    $uniId = Universite::query()->where('ad', 'Ankara Üniversitesi')->value('id');

    $bilesen = Livewire::test(YonergeAnalizi::class)
        ->assertSet('detayAcik', false)
        ->call('detayAc', $uniId)
        ->assertSet('detayAcik', true)
        ->assertSet('secilenUniversiteId', $uniId)
        ->assertSee('Ankara Üniversitesi')
        ->assertSee('Asgari Koşullar')
        ->assertSee('Puanımın Dağılımı');

    $detay = $bilesen->instance()->detay();

    // Detay, sonuç satırının üstüne bu cetvele göre kategori dağılımını ekler.
    expect($detay['baraj'])->toBe(120)
        ->and($detay['durum'])->toBe('yetersiz')
        ->and($detay['toplam'])->toBe(70)
        ->and($detay['dagilim']['makale'])->toBe(['puan' => 40, 'adet' => 2])
        ->and($detay['dagilim']['kitap'])->toBe(['puan' => 20, 'adet' => 1]);
});

test('detay paneli analizin dayandığı kaynak PDF\'e bağlantı verir', function () {
    $dosya = '17536987652.ornek yonerge.pdf';
    depoBagla($this->esikler, ['Ankara Üniversitesi' => $dosya]);

    $uniId = Universite::query()->where('ad', 'Ankara Üniversitesi')->value('id');

    Livewire::test(YonergeAnalizi::class)
        ->call('detayAc', $uniId)
        ->assertSee($dosya)
        ->assertSee(route('yonerge-analizi.kaynak', 'Ankara Üniversitesi'), escape: false);
});

test('kaynak PDF eşlemesi olmayan üniversitede bağlantı hiç çıkmaz', function () {
    // Üretim dışı/enjekte edilmiş veride eşleme boş; panel bozulmadan çalışmalı.
    $uniId = Universite::query()->where('ad', 'Ankara Üniversitesi')->value('id');

    $bilesen = Livewire::test(YonergeAnalizi::class)->call('detayAc', $uniId);

    expect($bilesen->instance()->detay()['kaynak_pdf'])->toBeNull();
    $bilesen->assertDontSee('Analizin dayandığı yönerge');
});

/**
 * Beyan koşulu taşıyan eşik: 55 puan barajı SAĞLANIYOR (aday 70 puan), tek
 * belirsizlik "belge ile" satırı — böylece kutunun etkisi tek başına okunur.
 *
 * @return array<string, mixed>
 */
function beyanliEsik(string $universite): array
{
    return testEsik($universite, 55, ekKosullar: [
        ['tip' => 'beyan', 'aciklama' => BEYAN_METNI, 'madde' => 'md. 5'],
    ]);
}

function beyanAnahtari(): string
{
    return SartSonucu::beyanAnahtariUret(BEYAN_METNI, 'md. 5');
}

test('"belge ile" koşulu işaretlenince üniversite yapılabilire döner', function () {
    Universite::factory()->create(['ad' => 'Beyan Üni', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    depoBagla([beyanliEsik('Beyan Üni')]);

    $bul = fn (array $sonuclar) => collect($sonuclar)
        ->first(fn (array $s) => $s['universite']->ad === 'Beyan Üni');

    $bilesen = Livewire::test(YonergeAnalizi::class);
    $once = $bul($bilesen->instance()->sonuclar());

    // Tek "belge ile" satırı bütün üniversiteyi Eksik Bilgi'de tutuyor.
    expect($once['durum'])->toBe('eksik_bilgi')
        ->and($once['beyan_sayisi'])->toBe(1);

    $bilesen->call('beyanDegistir', $once['esik']['anahtar'], beyanAnahtari());
    $sonra = $bul($bilesen->instance()->sonuclar());

    expect($sonra['durum'])->toBe('uygun')
        ->and($sonra['beyan_sayisi'])->toBe(0);

    // İşaret kalıcı: bileşen yeniden kurulunca da duruyor.
    expect($bul(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())['durum'])->toBe('uygun');
});

test('kartta beyan koşulu işaretlenmeden "onay gerek", işaretlenince "beyan edildi"', function () {
    // Kart ile detay paneli aynı koşul için aynı sözcüğü kullanmalı; eskiden
    // kart "belge ile" diyor ve işaretlendikten SONRA da öyle kalıyordu.
    Universite::factory()->create(['ad' => 'Beyan Üni', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    depoBagla([beyanliEsik('Beyan Üni')]);

    $esikAnahtari = Livewire::test(YonergeAnalizi::class)->instance()->sonuclar()[0]['esik']['anahtar'];
    $uniId = Universite::query()->where('ad', 'Beyan Üni')->value('id');

    $bilesen = Livewire::test(YonergeAnalizi::class)
        ->assertSee('onay gerek')
        ->assertDontSee('belge ile')
        ->call('detayAc', $uniId)
        ->assertSee('onay gerek');

    $bilesen->call('beyanDegistir', $esikAnahtari, beyanAnahtari())
        ->assertSee('beyan edildi')
        ->assertDontSee('onay gerek');
});

test('cetvel eksikliği adayın onay bekleyen koşullarından ayrı sayılır', function () {
    // İkisi de beyan düğümü ama adaya anlamları zıt: birinde kutu var, ötekinde
    // yok. Tek sayaçta toplanınca kart "2 koşul onayınızı bekliyor" diyor, aday
    // olmayan ikinci kutuyu arıyordu.
    Universite::factory()->create(['ad' => 'Karışık Üni', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    depoBagla([testEsik('Karışık Üni', 55, ekKosullar: [
        ['tip' => 'beyan', 'aciklama' => BEYAN_METNI, 'madde' => 'md. 5'],
        ['tip' => 'beyan', 'aciklama' => 'Dış ölçeğe göre en az 100 puan', 'kaynak_eksik' => true],
    ])]);

    $sonuc = Livewire::test(YonergeAnalizi::class)->instance()->sonuclar()[0];

    expect($sonuc['beyan_sayisi'])->toBe(1)
        ->and($sonuc['cetvel_eksigi_sayisi'])->toBe(1);

    Livewire::test(YonergeAnalizi::class)
        ->assertSee('1 koşul onayınızı bekliyor.')
        ->assertSee('1 koşulu kendiniz değerlendirmelisiniz.')
        // Etiket de ayrışıyor: biri işaretlenebilir, öteki bizim eksiğimiz.
        ->assertSee('onay gerek')
        ->assertSee('siz değerlendirin')
        ->assertDontSee('hesaplanamıyor');
});

test('aynı kutuya yeniden tıklamak beyanı geri alır', function () {
    Universite::factory()->create(['ad' => 'Beyan Üni', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    depoBagla([beyanliEsik('Beyan Üni')]);

    $esikAnahtari = Livewire::test(YonergeAnalizi::class)->instance()->sonuclar()[0]['esik']['anahtar'];

    $bilesen = Livewire::test(YonergeAnalizi::class)
        ->call('beyanDegistir', $esikAnahtari, beyanAnahtari());

    expect(BeyanOnayi::count())->toBe(1)
        ->and($bilesen->instance()->sonuclar()[0]['durum'])->toBe('uygun');

    $bilesen->call('beyanDegistir', $esikAnahtari, beyanAnahtari());

    expect(BeyanOnayi::count())->toBe(0)
        ->and($bilesen->instance()->sonuclar()[0]['durum'])->toBe('eksik_bilgi');
});

test('işaret yalnız işaretlendiği üniversiteye işler', function () {
    // Aynı cümle iki yönergede geçiyor; biri işaretlenince öteki değişmemeli.
    Universite::factory()->create(['ad' => 'Beyan Üni', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    Universite::factory()->create(['ad' => 'Öteki Üni', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    depoBagla([beyanliEsik('Beyan Üni'), beyanliEsik('Öteki Üni')]);

    $bilesen = Livewire::test(YonergeAnalizi::class);
    $esikAnahtari = collect($bilesen->instance()->sonuclar())
        ->first(fn (array $s) => $s['universite']->ad === 'Beyan Üni')['esik']['anahtar'];

    $bilesen->call('beyanDegistir', $esikAnahtari, beyanAnahtari());

    $durumlar = collect($bilesen->instance()->sonuclar())
        ->mapWithKeys(fn (array $s) => [$s['universite']->ad => $s['durum']]);

    expect($durumlar['Beyan Üni'])->toBe('uygun')
        ->and($durumlar['Öteki Üni'])->toBe('eksik_bilgi');
});

test('detay panelinde "belge ile" koşulu işaretlenebilir kutu olarak çıkar', function () {
    Universite::factory()->create(['ad' => 'Beyan Üni', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    depoBagla([beyanliEsik('Beyan Üni')]);

    $uniId = Universite::query()->where('ad', 'Beyan Üni')->value('id');
    $esikAnahtari = Livewire::test(YonergeAnalizi::class)->instance()->sonuclar()[0]['esik']['anahtar'];

    Livewire::test(YonergeAnalizi::class)
        ->call('detayAc', $uniId)
        ->assertSee('Belgeniz varsa kutuyu işaretleyin')
        ->assertSeeHtml('type="checkbox"')
        ->assertSeeHtml("beyanDegistir('{$esikAnahtari}', '".beyanAnahtari()."')");
});

test('cetveli girilmemiş koşula kutu konmaz', function () {
    // Bizim veri açığımız; aday işaretleyebilseydi kendi lehine kapatırdı.
    Universite::factory()->create(['ad' => 'Beyan Üni', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    depoBagla([testEsik('Beyan Üni', 55, ekKosullar: [
        ['tip' => 'beyan', 'aciklama' => 'Dış ölçeğe göre en az 100 puan', 'kaynak_eksik' => true],
    ])]);

    $uniId = Universite::query()->where('ad', 'Beyan Üni')->value('id');

    Livewire::test(YonergeAnalizi::class)
        ->call('detayAc', $uniId)
        ->assertSee('Dış ölçeğe göre en az 100 puan')
        ->assertDontSeeHtml('type="checkbox"');
});

test('detay paneli kapanınca içerik korunur (kapanış animasyonu titremesin)', function () {
    $uniId = collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())[0]['universite']->id;

    Livewire::test(YonergeAnalizi::class)
        ->call('detayAc', $uniId)
        ->set('detayAcik', false)
        ->assertSet('secilenUniversiteId', $uniId)
        ->assertSee('Asgari Koşullar');
});

test('filtre dışında kalan yönergenin detayı boş döner', function () {
    $uniId = Universite::query()->where('ad', 'Ankara Üniversitesi')->value('id');

    $detay = Livewire::test(YonergeAnalizi::class)
        ->call('detayAc', $uniId)
        ->set('arama', 'Mersin')
        ->instance()->detay();

    expect($detay)->toBeNull();
});

test('detay paneli animasyon için data-detay-flyout kancasını taşır', function () {
    // app.css'teki [data-flux-modal][data-detay-flyout] > dialog kuralı bu ikiliye bağlı.
    $html = Livewire::test(YonergeAnalizi::class)->html();

    expect($html)->toMatch('/<ui-modal[^>]*data-detay-flyout[^>]*data-flux-modal/');
});

test('sayfa render olur ve üniversiteleri gösterir', function () {
    Livewire::test(YonergeAnalizi::class)
        ->assertOk()
        ->assertSee('Mersin Üniversitesi')
        ->assertSee('Mevcut Profilim');
});

// ─────────────────────────────────────────────────────────────────────────────
// Üç değerli sonucun ekrana yansıması
// ─────────────────────────────────────────────────────────────────────────────

test('profil değeri girilmemişse durum "eksik bilgi" olur, yetersiz değil', function () {
    Universite::factory()->create(['ad' => 'YDS Üni', 'tur' => 'devlet']);

    depoBagla(array_merge($this->esikler, [
        testEsik('YDS Üni', 50, ekKosullar: [
            ['tip' => 'metrik', 'aciklama' => 'Yabancı dil sınavından en az 70', 'metrik' => 'yds', 'min' => 70],
        ]),
    ]));

    $bul = fn () => collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
        ->first(fn (array $s) => $s['universite']->ad === 'YDS Üni');

    // Puan barajı (50) aşılıyor ama YDS bilinmiyor → karara bağlanamaz.
    expect($bul()['durum'])->toBe('eksik_bilgi')
        ->and($bul()['belirsiz_sayisi'])->toBe(1)
        ->and($bul()['eksik_sayisi'])->toBe(0);

    // Değer girilince kesin sonuca dönüşür.
    $this->user->update(['yds_puani' => 75]);
    expect($bul()['durum'])->toBe('uygun');

    // 60/70 → en zayıf koşulun oranı %86, eşiğe yakın.
    $this->user->update(['yds_puani' => 60]);
    expect($bul()['durum'])->toBe('yakin');

    // 30/70 → %43, açık ara yetersiz.
    $this->user->update(['yds_puani' => 30]);
    expect($bul()['durum'])->toBe('yetersiz');
});

test('eksik bilgi kartta gerekçesiyle gösterilir', function () {
    Universite::factory()->create(['ad' => 'Belirsiz Üni', 'tur' => 'devlet']);

    depoBagla([testEsik('Belirsiz Üni', 50, ekKosullar: [
        ['tip' => 'metrik', 'aciklama' => 'WoS h-indeksi en az 5', 'metrik' => 'h_indeksi', 'min' => 5],
    ])]);

    $uniId = Universite::query()->where('ad', 'Belirsiz Üni')->value('id');

    Livewire::test(YonergeAnalizi::class)
        ->assertSee('Onay Gerek')
        ->assertSee('koşul için eksik bilgilerinizi tamamlamalısınız.')
        // Durumun ADI ekranın her yerinde aynı olmalı: özet bardaki sayaç,
        // kart rozeti ve detay panelindeki rozet aynı sözcüğü kullanır.
        // Eski ad hiçbir yerde kalmamalı.
        ->call('detayAc', $uniId)
        ->assertSee('Onay Gerek')
        ->assertDontSee('Eksik Bilgi');
});

test('dönem koşulu faaliyet tarihi girilince kesinleşir', function () {
    Universite::factory()->create(['ad' => 'Dönem Üni', 'tur' => 'devlet']);

    depoBagla([testEsik('Dönem Üni', 50, ekKosullar: [
        [
            'tip' => 'adet',
            'aciklama' => 'Doktora sonrası en az 2 makale',
            'maddeler' => ['MAKALE'],
            'min_adet' => 2,
            'donem' => ['baslangic' => 'doktora', 'son_yil' => null],
        ],
    ])]);

    $this->user->update(['doktora_tarihi' => '2020-01-01']);

    $bul = fn () => collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
        ->first(fn (array $s) => $s['universite']->ad === 'Dönem Üni');

    // Faaliyetlerin tarihi yok → belirsiz.
    expect($bul()['durum'])->toBe('eksik_bilgi');

    // Tarihler girilince kesinleşir.
    $this->user->faaliyetler()->where('kategori', Kategori::Makale)->update(['tarih' => '2022-06-01']);
    expect($bul()['durum'])->toBe('uygun');
});

test('puan barajı olmayan yönergede baraj sıfır değil YOK olarak taşınır', function () {
    // Sabancı ve Samsun gibi yönergeler şartlarını adetle yazıyor; ağaçta
    // 'toplam' rolünde düğüm yoktur. Bunu 0 ile temsil etmek kartta "0 / 0 pt"
    // gibi bozuk bir değer ve %100'lük sahte bir ilerleme çubuğu üretiyordu.
    depoBagla([[
        'anahtar' => 'puansiz-dr-ilahiyat',
        'universite' => 'Puansız Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => 'ilahiyat',
        'birim' => null,
        'cetvel' => 'test-cetvel',
        'notlar' => 'Puan barajı olmayan yönerge.',
        'sart' => [
            'tip' => 'adet',
            'aciklama' => 'En az 4 makale',
            'maddeler' => ['MAKALE'],
            'min_adet' => 4,
        ],
    ]]);

    Universite::factory()->create(['ad' => 'Puansız Üniversitesi', 'tur' => 'vakif']);

    $s = collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
        ->firstWhere(fn (array $s) => $s['universite']->ad === 'Puansız Üniversitesi');

    expect($s['baraj'])->toBeNull()
        ->and($s['toplam'])->toBeNull()
        ->and($s['kalan'])->toBe(0)
        // İlerleme puandan değil koşul doluluğundan okunmalı.
        ->and($s['puan_orani'])->toBe($s['oran'])
        ->and($s['puan_orani'])->not->toBe(100);
});

test('detay panelinde resmi yönerge PDF bağlantısı gösterilir', function () {
    $uni = Universite::where('ad', 'Ankara Üniversitesi')->firstOrFail();
    $uni->update(['yonerge_url' => 'https://personel.yok.gov.tr/documentFiles/ornek.pdf']);

    Livewire::test(YonergeAnalizi::class)
        ->call('detayAc', $uni->id)
        ->assertSee('Resmi yönerge sayfası')
        ->assertSeeHtml('href="https://personel.yok.gov.tr/documentFiles/ornek.pdf"')
        // Yeni sekmede açılmalı: aday analizi kaybetmemeli.
        ->assertSeeHtml('target="_blank"');
});

test('yönerge bağlantısı olmayan üniversitede PDF kutusu çıkmaz', function () {
    $uni = Universite::where('ad', 'Ankara Üniversitesi')->firstOrFail();
    $uni->update(['yonerge_url' => null]);

    Livewire::test(YonergeAnalizi::class)
        ->call('detayAc', $uni->id)
        ->assertDontSee('Resmi yönerge sayfası');
});

test('detay panelinde ham yönerge notu değil aday notu gösterilir', function () {
    $uni = Universite::where('ad', 'Ankara Üniversitesi')->firstOrFail();

    depoBagla([array_merge(testEsik('Ankara Üniversitesi', 120), [
        // `notlar` denetim izidir: yönergeden birebir alıntı ve madde kodu içerir.
        'notlar' => 'Madde 2.a-ç/h,ı kapsamında… Tablo-1 [C] sütunu boş.',
        'aday_notu' => 'Makale sayısı yetmiyor, en az birinde başlıca yazar olmalısınız.',
    ])]);

    Livewire::test(YonergeAnalizi::class)
        ->call('detayAc', $uni->id)
        ->assertSee('Bu Yönerge Hakkında')
        ->assertSee('en az birinde başlıca yazar olmalısınız')
        // Madde kodu adaya sızmamalı.
        ->assertDontSee('2.a-ç/h,ı')
        ->assertDontSee('Tablo-1 [C]');
});

test('cetvelin kapsam sınırı adaya taşınır', function () {
    $uni = Universite::where('ad', 'Ankara Üniversitesi')->firstOrFail();

    $cetveller = testCetvelleri();
    $cetveller['test-cetvel']['kapsam_notu'] = 'Ders kalemleri hesaba katılmadı.';

    app()->instance(SartDeposu::class, new SartDeposu(
        [testEsik('Ankara Üniversitesi', 120)],
        $cetveller,
    ));

    Livewire::test(YonergeAnalizi::class)
        ->call('detayAc', $uni->id)
        ->assertSee('Ders kalemleri hesaba katılmadı.');
});

test('kartta en fazla 6 koşul gösterilir, kalanı sayıyla belirtilir', function () {
    $uni = Universite::where('ad', 'Ankara Üniversitesi')->firstOrFail();

    // Toplam barajı + 8 alt koşul = 9 koşul.
    $ek = [];
    foreach (range(1, 8) as $i) {
        $ek[] = ['tip' => 'adet', 'aciklama' => "Koşul {$i} açıklaması", 'maddeler' => ['MAKALE'], 'min_adet' => $i];
    }

    depoBagla([testEsik('Ankara Üniversitesi', 100, ekKosullar: $ek)]);

    $sayfa = Livewire::test(YonergeAnalizi::class)->set('gorunum', 'grid');

    $sayfa->assertSee('Koşul 5 açıklaması')   // 6. sırada
        ->assertDontSee('Koşul 6 açıklaması') // 7. sırada, kesilmeli
        ->assertSee('+3 koşul daha');

    // Detay panelinde tamamı görünmeli.
    $sayfa->call('detayAc', $uni->id)->assertSee('Koşul 8 açıklaması');
});

test('kadro veya alanı kapsamayan üniversiteler gerekçesiyle bildirilir', function () {
    // İki gerekçe adaya bambaşka şey söylüyor, bu yüzden ayrı gösteriliyor:
    //   Ankara → alanı kapsanıyor ama ölçüt BİRİME bağlı ve birden çok aday
    //            var; aday birimini seçerse listeye girer.
    //   Mersin → o temel alan için hiç eşik yok; yapılabilecek bir şey yok.
    $birimli = fn (string $birim): array => [
        ...testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        'anahtar' => 'ankara-dr-sosyal-'.Str::slug($birim),
        'birim' => $birim,
    ];

    depoBagla([
        $birimli('Hukuk Fakültesi'),
        $birimli('Siyasal Bilgiler Fakültesi'),
        testEsik('Mersin Üniversitesi', 90, 'dr_ogr_uyesi', 'ilahiyat'),
    ]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal,
        'unvan' => 'Arş. Gör.',
        'birim' => null,
    ]);

    $bilesen = Livewire::actingAs($kullanici)->test(YonergeAnalizi::class)
        ->assertOk()
        ->assertSee('birim seçilmesini bekliyor')
        ->assertSee('Temel alanınıza ölçüt tanımlamayan üniversiteler')
        ->assertSee('Bu üniversitede sizin temel alanınıza ait bir eşik bulunamadı.');

    $kapsamDisi = $bilesen->instance()->kapsamDisi();

    expect($kapsamDisi['birim'])->toBe(['Ankara Üniversitesi'])
        ->and($kapsamDisi['alan_yok'])->toBe(['Mersin Üniversitesi']);
});

test('"Ölçüt Yok" sayacı kapsam dışı üniversiteleri filtreler', function () {
    depoBagla([
        testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        testEsik('Mersin Üniversitesi', 90, 'dr_ogr_uyesi', 'ilahiyat'),
    ]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal, 'unvan' => 'Arş. Gör.', 'birim' => null,
    ]);

    $bilesen = Livewire::actingAs($kullanici)->test(YonergeAnalizi::class);

    // Sayaç 'toplam'a dâhil değil: sonuç satırı olmayanları sayıyor.
    expect($bilesen->instance()->ozet())
        ->toBe(['toplam' => 1, 'uygun' => 0, 'eksik_bilgi' => 0, 'yakin' => 0, 'yetersiz' => 1, 'alan_yok' => 1]);

    $bilesen->call('durumSec', 'alan_yok')->assertSet('durumFiltre', 'alan_yok');

    // Sonuç listesi tamamen atlanıyor — "yönerge bulunamadı" kartı ÇIKMAMALI.
    expect($bilesen->instance()->listelenen())->toBe([]);
    $bilesen->assertDontSee('Seçili filtrelere uygun yönerge bulunamadı.')
        ->assertSee('Temel alanınıza ölçüt tanımlamayan üniversiteler')
        ->assertSee('Mersin Üniversitesi')
        ->assertDontSee('Ankara Üniversitesi');
});

test('başka bir durum seçiliyken kapsam dışı bölümü gizlenir', function () {
    depoBagla([
        testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        testEsik('Mersin Üniversitesi', 90, 'dr_ogr_uyesi', 'ilahiyat'),
    ]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal, 'unvan' => 'Arş. Gör.', 'birim' => null,
    ]);

    Livewire::actingAs($kullanici)->test(YonergeAnalizi::class)
        ->assertSee('Temel alanınıza ölçüt tanımlamayan üniversiteler')
        ->call('durumSec', 'yetersiz')
        ->assertDontSee('Temel alanınıza ölçüt tanımlamayan üniversiteler');
});

test('şehir filtresi kapsam dışı listesini de daraltır', function () {
    // Aksi hâlde "Ankara" seçen aday Mersin'i kapsam dışı kartları arasında
    // görmeye devam ederdi; filtre ekranın yarısına işlemez olurdu.
    depoBagla([
        testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        testEsik('Mersin Üniversitesi', 90, 'dr_ogr_uyesi', 'ilahiyat'),
    ]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal, 'unvan' => 'Arş. Gör.', 'birim' => null,
    ]);

    $bilesen = Livewire::actingAs($kullanici)->test(YonergeAnalizi::class);

    expect($bilesen->instance()->kapsamDisi()['alan_yok'])->toBe(['Mersin Üniversitesi']);

    $bilesen->set('sehirFiltre', 'Ankara');

    expect($bilesen->instance()->kapsamDisi()['alan_yok'])->toBe([]);
});

test('birim seçilince kapsam dışı uyarısı kalkar', function () {
    // "Birim seçin" uyarısının işe yaradığının kanıtı: aynı korpusta profiline
    // birimini yazan aday üniversiteyi listede görüyor.
    $birimli = fn (string $birim): array => [
        ...testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        'anahtar' => 'ankara-dr-sosyal-'.Str::slug($birim),
        'birim' => $birim,
    ];

    depoBagla([$birimli('Hukuk Fakültesi'), $birimli('Siyasal Bilgiler Fakültesi')]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal,
        'unvan' => 'Arş. Gör.',
        'birim' => 'Hukuk Fakültesi',
    ]);

    $bilesen = Livewire::actingAs($kullanici)->test(YonergeAnalizi::class)->assertOk();

    expect($bilesen->instance()->kapsamDisi())->toBe(['birim' => [], 'alan_yok' => []])
        ->and($bilesen->instance()->sonuclar())->toHaveCount(1);
});

test('ekrandan seçilen birim profildekini ezer ve üniversiteyi listeye sokar', function () {
    // ASIL SORUN: profildeki tek `birim` alanı adayın KENDİ üniversitesinin
    // birimlerini listeliyor (Profile::birimSecenekleri). Korpustaki 181 birim
    // adının yalnız 25'i birden çok üniversitede ortak, yani o alan başka
    // üniversitelerde çoğunlukla tutmuyor. Seçim bu yüzden üniversite BAŞINA
    // yapılıyor ve profili eziyor.
    $birimli = fn (string $universite, string $birim): array => [
        ...testEsik($universite, 100, 'dr_ogr_uyesi', 'sosyal'),
        'anahtar' => Str::slug($universite).'-dr-sosyal-'.Str::slug($birim),
        'birim' => $birim,
    ];

    depoBagla([
        $birimli('Ankara Üniversitesi', 'Hukuk Fakültesi'),
        $birimli('Ankara Üniversitesi', 'Siyasal Bilgiler Fakültesi'),
        $birimli('Mersin Üniversitesi', 'İletişim Fakültesi'),
        $birimli('Mersin Üniversitesi', 'Mimarlık Fakültesi'),
    ]);

    // Profilde Ankara'nın birimi seçili; Mersin'in birimleriyle hiç örtüşmüyor.
    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal,
        'unvan' => 'Arş. Gör.',
        'birim' => 'Hukuk Fakültesi',
    ]);

    $bilesen = Livewire::actingAs($kullanici)->test(YonergeAnalizi::class)->assertOk();

    // Ankara profil alanından çözülüyor, Mersin hâlâ birim bekliyor.
    expect($bilesen->instance()->kapsamDisi()['birim'])->toBe(['Mersin Üniversitesi'])
        ->and($bilesen->instance()->sonuclar())->toHaveCount(1);

    // Seçenekler Mersin'in KENDİ birimleri; profildeki değer aralarında yok.
    expect($bilesen->instance()->birimSecenekleri())
        ->toBe(['Mersin Üniversitesi' => ['İletişim Fakültesi', 'Mimarlık Fakültesi']]);

    // Ekrandan seçilince Mersin de karşılaştırmaya giriyor.
    $bilesen->set('birimSecimleri.Mersin Üniversitesi', 'Mimarlık Fakültesi');

    expect($bilesen->instance()->kapsamDisi())->toBe(['birim' => [], 'alan_yok' => []])
        ->and($bilesen->instance()->sonuclar())->toHaveCount(2)
        ->and($bilesen->instance()->birimSecenekleri())->toBe([]);
});

test('ekran seçimi aynı üniversitede profildeki birimi ezer', function () {
    // Seçim profilin ÜSTÜNE yazar: aday kendi üniversitesinde başka bir
    // fakültenin ölçütünü de görmek isteyebilir.
    $birimli = fn (string $birim): array => [
        ...testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        'anahtar' => 'ankara-dr-sosyal-'.Str::slug($birim),
        'birim' => $birim,
        'notlar' => $birim.' ölçütü',
    ];

    depoBagla([$birimli('Hukuk Fakültesi'), $birimli('Siyasal Bilgiler Fakültesi')]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal,
        'unvan' => 'Arş. Gör.',
        'birim' => 'Hukuk Fakültesi',
    ]);

    $bilesen = Livewire::actingAs($kullanici)->test(YonergeAnalizi::class)->assertOk();
    expect($bilesen->instance()->sonuclar()[0]['esik']['notlar'])->toBe('Hukuk Fakültesi ölçütü');

    $bilesen->set('birimSecimleri.Ankara Üniversitesi', 'Siyasal Bilgiler Fakültesi');
    expect($bilesen->instance()->sonuclar()[0]['esik']['notlar'])->toBe('Siyasal Bilgiler Fakültesi ölçütü');
});

test('bütün üniversiteler kapsandığında uyarı çıkmaz', function () {
    $kullanici = User::factory()->onboarded()->create(['temel_alan' => TemelAlan::Sosyal]);

    $bilesen = Livewire::actingAs($kullanici)->test(YonergeAnalizi::class);
    $kapsamDisi = $bilesen->instance()->kapsamDisi();

    // Her iki kapsam dışı liste ile gösterilen kart sayısı birlikte tüm
    // korpusu vermeli; aradaki fark sessizce kaybolan üniversite demek olurdu.
    // İki listenin kesişmemesi de şart: bir üniversite tek gerekçeye düşer.
    $depo = app(SartDeposu::class);
    $toplam = count($kapsamDisi['birim']) + count($kapsamDisi['alan_yok']);

    expect($toplam + count($bilesen->instance()->sonuclar()))
        ->toBe(count($depo->universiteler()))
        ->and(array_intersect($kapsamDisi['birim'], $kapsamDisi['alan_yok']))->toBe([]);
});

test('birim seçicileri boş başlar ve ilk seçenek seçilince güncellenir', function () {
    // HATA: seçicide boş seçenek yoksa tarayıcı İLK seçeneği görünür biçimde
    // seçili gösteriyor ama bağlı değer hâlâ boş. Aday o ilk seçeneği tıkladığında
    // `change` olayı tetiklenmiyor (değer zaten "seçili" görünüyordu) ve ekran
    // güncellenmiyordu. Boş seçenek hem başlangıç durumunu doğru gösteriyor
    // hem de ilk seçeneğe geçişi gerçek bir değişiklik yapıyor.
    $birimli = fn (string $birim): array => [
        ...testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        'anahtar' => 'ankara-dr-sosyal-'.Str::slug($birim),
        'birim' => $birim,
    ];

    // Alfabetik olarak ilk seçenek: 'Diş Hekimliği Fakültesi'.
    depoBagla([$birimli('Diş Hekimliği Fakültesi'), $birimli('Hukuk Fakültesi')]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal,
        'unvan' => 'Arş. Gör.',
        'birim' => null,
    ]);

    $bilesen = Livewire::actingAs($kullanici)->test(YonergeAnalizi::class)->assertOk();

    // Başlangıç: her bekleyen üniversite için BOŞ bir değer bağlı olmalı.
    // Anahtar hiç yoksa seçici bağlanacak bir şey bulamıyor ve ilk seçeneği
    // seçili gösteriyor.
    expect($bilesen->get('birimSecimleri'))->toBe(['Ankara Üniversitesi' => '']);

    // Boş seçenek görünüyor; aksi hâlde ilk seçenek sahte biçimde seçili gelir.
    $bilesen->assertSee('Birim seçilmedi');

    // İLK seçeneği seçmek gerçekten çalışıyor.
    $bilesen->set('birimSecimleri.Ankara Üniversitesi', 'Diş Hekimliği Fakültesi');

    expect($bilesen->instance()->sonuclar())->toHaveCount(1)
        ->and($bilesen->instance()->kapsamDisi()['birim'])->toBe([]);
});

test('birim kutusu kapalı başlar, başlığı tıklayınca açılır', function () {
    // On dört seçici ekranın tepesini kaplıyordu. Başlık kapalıyken de duruyor:
    // aday bekleyen iş olduğunu kutuyu açmadan görüyor.
    $birimli = fn (string $birim): array => [
        ...testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        'anahtar' => 'ankara-dr-sosyal-'.Str::slug($birim),
        'birim' => $birim,
    ];

    depoBagla([$birimli('Hukuk Fakültesi'), $birimli('Siyasal Bilgiler Fakültesi')]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal, 'unvan' => 'Arş. Gör.', 'birim' => null,
    ]);

    Livewire::actingAs($kullanici)->test(YonergeAnalizi::class)
        ->assertSet('birimPaneliAcik', false)
        ->assertSee('birim seçilmesini bekliyor')
        // Panel kapalıyken de ÇİZİLİYOR (x-collapse kapanışı canlandırabilsin
        // diye), gizlemeyi `display:none` yapıyor. Kapalı olduğunun sunucudan
        // okunabilen işareti bu ikisi.
        ->assertSeeHtml('style="display: none"')
        ->assertSeeHtml('aria-expanded="false"')
        ->assertSee('Hukuk Fakültesi')
        // Animasyonun kendisi istemcide; testin doğrulayabileceği, kancaların
        // Flux'un kök elemanına GEÇTİĞİ. Bileşen bunları yutsaydı kutu hiç
        // açılmazdı ve hiçbir PHP testi bunu görmezdi.
        ->assertSeeHtml('x-collapse')
        ->assertSeeHtml("\$wire.entangle('birimPaneliAcik')")
        ->toggle('birimPaneliAcik')
        ->assertSeeHtml('aria-expanded="true"')
        ->assertDontSeeHtml('style="display: none"')
        ->toggle('birimPaneliAcik')
        ->assertSeeHtml('style="display: none"');
});

test('kutu açıkken birim seçilince açık kalır', function () {
    // Seçiciler `wire:model.live`; her seçim yeni render tetikliyor. Durum
    // istemcide tutulsaydı kutu adayın yüzüne kapanırdı.
    $birimli = fn (string $birim): array => [
        ...testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        'anahtar' => 'ankara-dr-sosyal-'.Str::slug($birim),
        'birim' => $birim,
    ];

    Universite::factory()->create(['ad' => 'Boş Üni', 'sehir' => 'Ankara', 'tur' => 'devlet']);
    depoBagla([
        $birimli('Hukuk Fakültesi'),
        $birimli('Siyasal Bilgiler Fakültesi'),
        [...testEsik('Boş Üni', 100, 'dr_ogr_uyesi', 'sosyal'), 'anahtar' => 'bos-dr-sosyal-2', 'birim' => 'Tıp Fakültesi'],
        [...testEsik('Boş Üni', 100, 'dr_ogr_uyesi', 'sosyal'), 'anahtar' => 'bos-dr-sosyal-3', 'birim' => 'Diş Hekimliği Fakültesi'],
    ]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal, 'unvan' => 'Arş. Gör.', 'birim' => null,
    ]);

    Livewire::actingAs($kullanici)->test(YonergeAnalizi::class)
        ->set('birimPaneliAcik', true)
        ->set('birimSecimleri.Ankara Üniversitesi', 'Hukuk Fakültesi')
        ->assertSet('birimPaneliAcik', true)
        // Ankara listeden düştü ama kutu duruyor: Boş Üni hâlâ bekliyor.
        ->assertSee('Tıp Fakültesi');
});

test('birim seçimi geri boşaltılınca üniversite yeniden bekleyene düşer', function () {
    // Seçim geri alınabilmeli: aday yanlış birimi seçtiyse "Birim seçilmedi"ye
    // dönebilmeli ve üniversite yine seçici kutusunda görünmeli.
    $birimli = fn (string $birim): array => [
        ...testEsik('Ankara Üniversitesi', 100, 'dr_ogr_uyesi', 'sosyal'),
        'anahtar' => 'ankara-dr-sosyal-'.Str::slug($birim),
        'birim' => $birim,
    ];

    depoBagla([$birimli('Hukuk Fakültesi'), $birimli('Siyasal Bilgiler Fakültesi')]);

    $kullanici = User::factory()->onboarded()->create([
        'temel_alan' => TemelAlan::Sosyal,
        'unvan' => 'Arş. Gör.',
        'birim' => null,
    ]);

    $bilesen = Livewire::actingAs($kullanici)->test(YonergeAnalizi::class)
        ->set('birimSecimleri.Ankara Üniversitesi', 'Hukuk Fakültesi');

    expect($bilesen->instance()->sonuclar())->toHaveCount(1);

    $bilesen->set('birimSecimleri.Ankara Üniversitesi', '');

    expect($bilesen->instance()->sonuclar())->toBe([])
        ->and($bilesen->instance()->kapsamDisi()['birim'])->toBe(['Ankara Üniversitesi']);
});
