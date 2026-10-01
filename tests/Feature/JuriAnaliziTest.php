<?php

use App\Enums\JuriAdimi;
use App\Enums\JuriKarari;
use App\Enums\JuriSapkasi;
use App\Enums\JuriSertligi;
use App\Enums\Kategori;
use App\Livewire\JuriAnalizi;
use App\Models\Faaliyet;
use App\Models\JuriRaporu;
use App\Models\Universite;
use App\Models\User;
use App\Services\AI\JuriRaporcu;
use App\Services\AI\SaglayiciException;
use App\Services\AI\SohbetSaglayici;
use App\Services\Scoring\Sart\SartDeposu;
use Illuminate\Support\Str;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

/**
 * Jüri testlerinin kendi cetveli: 4 faaliyet tam 70 puan eder.
 *
 * Yönerge Analizi testindeki yardımcılar bu dosyadan çağrılamıyor (ikisi de
 * global fonksiyon; aynı adı taşısalar Pest tek süreçte ikisini yükleyip
 * çakışırdı), o yüzden burada `juri` önekiyle duruyorlar.
 *
 * @return array<string, array<string, mixed>>
 */
function juriCetvelleri(): array
{
    return [
        'juri-cetvel' => [
            'maddeler' => [
                'M2' => ['baslik' => 'Q2 makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 20],
                'K1' => ['baslik' => 'Kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 20],
                'T1' => ['baslik' => 'Tez yayını', 'kategori' => 'tez_yayini', 'puan' => 10],
            ],
            'gruplar' => ['YAYIN' => ['M*', 'K*', 'T1']],
        ],
    ];
}

/**
 * Toplam puan barajı taşıyan eşik kaydı.
 *
 * @return array<string, mixed>
 */
function juriEsigi(string $universite, int $baraj, string $kadro = 'dr_ogr_uyesi', string $alan = 'ilahiyat'): array
{
    return [
        'anahtar' => Str::slug($universite)."-{$kadro}-{$alan}",
        'universite' => $universite,
        'kadro' => $kadro,
        'alan' => $alan,
        'birim' => null,
        'cetvel' => 'juri-cetvel',
        'notlar' => "Test eşiği: {$baraj} puan.",
        'sart' => ['tip' => 've', 'aciklama' => 'Asgari şartlar', 'cocuklar' => [
            [
                'tip' => 'puan',
                'rol' => 'toplam',
                'aciklama' => "Tüm faaliyetlerden toplam en az {$baraj} puan",
                'maddeler' => ['*'],
                'min_puan' => $baraj,
            ],
        ]],
    ];
}

/**
 * @param  list<array<string, mixed>>  $esikler
 */
function juriDepoBagla(array $esikler): void
{
    app()->instance(SartDeposu::class, new SartDeposu($esikler, juriCetvelleri()));
}

/**
 * Jüri katmanının sağlayıcısını verilen yanıtla değiştirir.
 *
 * Bağlama CONTEXTUAL: sohbet sağlayıcısı yerinde kalır, yalnızca
 * {@see JuriRaporcu} içindeki değişir — jüri JSON okur, sohbet metin.
 */
function juriSaglayiciBagla(callable $yanit): void
{
    app()->when(JuriRaporcu::class)
        ->needs(SohbetSaglayici::class)
        ->give(fn (): SohbetSaglayici => new class($yanit) implements SohbetSaglayici
        {
            public function __construct(private readonly Closure $uretici) {}

            public function yanitla(string $sistemPrompt, array $mesajlar): string
            {
                return ($this->uretici)($sistemPrompt, $mesajlar);
            }
        });
}

/**
 * Geçerli bir rapor JSON'u — istenen adımlar, istenen ağırlıkla.
 *
 * @param  array<string, string>  $adimlar  adım anahtarı => içerik
 */
function juriRaporJsonu(array $adimlar, string $ozet = 'Son söz.'): string
{
    return (string) json_encode([
        'adimlar' => collect($adimlar)
            ->map(fn (string $icerik) => ['agirlik' => 'kritik', 'icerik' => $icerik])
            ->all(),
        'ozet' => $ozet,
    ], JSON_UNESCAPED_UNICODE);
}

beforeEach(function () {
    Universite::factory()->create(['ad' => 'Mersin Üniversitesi', 'sehir' => 'Mersin', 'tur' => 'devlet']);
    Universite::factory()->create(['ad' => 'Ankara Üniversitesi', 'sehir' => 'Ankara', 'tur' => 'devlet']);

    // Mersin 90 puan ister (aday 70 ile karşılamaz), Ankara 55 (karşılar).
    juriDepoBagla([
        juriEsigi('Mersin Üniversitesi', 90),
        juriEsigi('Ankara Üniversitesi', 55),
    ]);

    // Arş. Gör. → hedef kadro Dr. Öğr. Üyesi (eşiklerle uyumlu).
    $this->user = User::factory()->onboarded()->create(['unvan' => 'Arş. Gör.']);

    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCIE/SSCI (Q2)']);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCIE/SSCI (Q2)']);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Kitap, 'kaynak' => 'Uluslararası/Ulusal Kitap']);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::TezYayini, 'kaynak' => 'ESCI / Scopus']);

    actingAs($this->user);
});

test('jüri analizi sayfası boş durumla açılır', function () {
    $this->get(route('juri-analizi'))
        ->assertOk()
        ->assertSee('YZ Jüri Masası Hazır')
        ->assertSee('Jüri Masasına Taşı');
});

test('kurum listesi yalnızca eşiği olan kurumları gösterir', function () {
    // Üniversite tablosunda olup yönergesi girilmemiş kurum listeye girmemeli:
    // jüri raporu tahmini bir barajın üzerine yazılamaz.
    Universite::factory()->create(['ad' => 'Yönergesiz Üniversite', 'sehir' => 'İzmir', 'tur' => 'devlet']);

    $kurumlar = Livewire::test(JuriAnalizi::class)->instance()->kurumlar();

    expect($kurumlar)->toBe(['Ankara Üniversitesi', 'Mersin Üniversitesi']);
});

test('varsayılan kurum adayın kendi üniversitesi olur', function () {
    Livewire::test(JuriAnalizi::class)->assertSet('hedefKurum', 'Mersin Üniversitesi');
});

test('analiz iki adımda çalışır ve rapor adayın dosyasına yazılır', function () {
    juriSaglayiciBagla(fn () => juriRaporJsonu(
        collect(JuriAdimi::cases())->mapWithKeys(fn (JuriAdimi $a) => [$a->value => $a->baslik().' gövdesi'])->all(),
        'Dosya bugünkü hâliyle yetersiz.',
    ));

    $bilesen = Livewire::test(JuriAnalizi::class)
        ->call('analizBaslat')
        ->assertSet('bekleniyor', true)
        ->assertDispatched('juri-raporu-uret')
        ->assertSee('jüri masasına taşınıyor');

    $bilesen->call('raporUret')
        ->assertSet('bekleniyor', false)
        ->assertSet('hata', null)
        ->assertSee('Dosya Değerlendirmesi')
        ->assertSee('Dosya bugünkü hâliyle yetersiz.');

    $rapor = $this->user->juriRaporlari()->sole();

    expect($rapor->universite)->toBe('Mersin Üniversitesi')
        ->and($rapor->hedef_kadro)->toBe('dr_ogr_uyesi')
        ->and($rapor->adimSatirlari())->toHaveCount(10);
});

test('karar ve ölçüm YZ değil motordan gelir', function () {
    // Sağlayıcı kararı etkilemeye çalışsa bile: metni o yazıyor, kararı motor.
    juriSaglayiciBagla(fn () => juriRaporJsonu(
        ['karar' => 'Bence aday rahatça başvurabilir.'],
        'Tebrikler!',
    ));

    Livewire::test(JuriAnalizi::class)->call('analizBaslat')->call('raporUret');

    $rapor = $this->user->juriRaporlari()->sole();

    // 70 puan, Mersin 90 ister → motor "sağlanmadı" diyor.
    expect($rapor->karar)->toBe(JuriKarari::Basvuramaz)
        ->and($rapor->olcumler[0]['mevcut'])->toBe(70)
        ->and($rapor->olcumler[0]['gerekli'])->toBe(90);
});

test('koşulu karşılayan kurumda karar başvurabilir olur', function () {
    juriSaglayiciBagla(fn () => juriRaporJsonu(['karar' => 'Dosya tamam.']));

    Livewire::test(JuriAnalizi::class)
        ->set('hedefKurum', 'Ankara Üniversitesi')
        ->call('analizBaslat')
        ->call('raporUret');

    expect($this->user->juriRaporlari()->sole()->karar)->toBe(JuriKarari::Basvurabilir);
});

test('şapka ve ton ölçümü değiştirmez, yalnızca üslubu seçer', function () {
    juriSaglayiciBagla(fn (string $sistemPrompt) => juriRaporJsonu(['karar' => 'Rapor.'], $sistemPrompt));

    foreach ([JuriSapkasi::Mentor, JuriSapkasi::SertJuri] as $sapka) {
        Livewire::test(JuriAnalizi::class)
            ->set('sapka', $sapka->value)
            ->set('sertlik', JuriSertligi::Sert->value)
            ->call('analizBaslat')
            ->call('raporUret');
    }

    $raporlar = $this->user->juriRaporlari()->get();

    expect($raporlar)->toHaveCount(2)
        ->and($raporlar[0]->karar)->toBe($raporlar[1]->karar)
        ->and($raporlar[0]->olcumler)->toBe($raporlar[1]->olcumler)
        // Üslup gerçekten prompta giriyor: özet, sağlayıcıya ulaşan sistem promptu.
        ->and($raporlar[0]->ozet)->not->toBe($raporlar[1]->ozet)
        ->and($raporlar->pluck('ozet')->implode(' '))->toContain('tavizsiz');
});

test('rapor iskeleti sabit: adımlar sırayla, eksik adım atlanarak çizilir', function () {
    // Sağlayıcı adımları ters sırada ve eksik döndürüyor.
    juriSaglayiciBagla(fn () => juriRaporJsonu([
        'karar' => 'Son söz.',
        'envanter' => 'Envanter.',
        'kriterler' => 'Kriterler.',
    ]));

    Livewire::test(JuriAnalizi::class)->call('analizBaslat')->call('raporUret');

    $satirlar = $this->user->juriRaporlari()->sole()->adimSatirlari();

    expect(array_column(array_map(fn (array $s) => ['v' => $s['adim']->value], $satirlar), 'v'))
        ->toBe(['kriterler', 'envanter', 'karar']);
});

test('eşiği olmayan kurum seçilirse analiz başlamaz', function () {
    Livewire::test(JuriAnalizi::class)
        ->set('hedefKurum', 'Yönergesiz Üniversite')
        ->call('analizBaslat')
        ->assertSet('bekleniyor', false)
        ->assertNotDispatched('juri-raporu-uret')
        ->assertSee('yönergesi girilmiş bir kurum seçin');

    expect($this->user->juriRaporlari()->count())->toBe(0);
});

test('sağlayıcı hatası gösterilir ve yarım rapor kaydedilmez', function () {
    juriSaglayiciBagla(function () {
        throw SaglayiciException::httpDurumundan(429);
    });

    Livewire::test(JuriAnalizi::class)
        ->call('analizBaslat')
        ->call('raporUret')
        ->assertSet('bekleniyor', false)
        ->assertSee('bakiye yükleyip');

    expect($this->user->juriRaporlari()->count())->toBe(0);
});

test('JSON olmayan yanıt rapor sayılmaz', function () {
    juriSaglayiciBagla(fn () => 'Merhaba, raporu sohbet gibi yazdım.');

    Livewire::test(JuriAnalizi::class)
        ->call('analizBaslat')
        ->call('raporUret')
        ->assertSee('Jüri raporu okunamadı');

    expect($this->user->juriRaporlari()->count())->toBe(0);
});

test('kod bloğuna sarılmış JSON yine okunur', function () {
    juriSaglayiciBagla(fn () => "```json\n".juriRaporJsonu(['karar' => 'Son söz.'])."\n```");

    Livewire::test(JuriAnalizi::class)->call('analizBaslat')->call('raporUret');

    expect($this->user->juriRaporlari()->sole()->adimSatirlari())->toHaveCount(1);
});

test('geçmiş rapor seçilebilir ve silinebilir', function () {
    $eski = JuriRaporu::factory()->for($this->user)->create(['universite' => 'Ankara Üniversitesi']);

    Livewire::test(JuriAnalizi::class)
        ->call('raporSec', $eski->id)
        ->assertSet('aktifRaporId', $eski->id)
        ->assertSee('Ankara Üniversitesi')
        ->call('raporSil', $eski->id)
        ->assertSet('aktifRaporId', null);

    expect($this->user->juriRaporlari()->count())->toBe(0);
});

test('başka kullanıcının raporu ne görünür ne silinir', function () {
    $baskasi = User::factory()->create();
    $rapor = JuriRaporu::factory()->for($baskasi)->create(['ozet' => 'gizli değerlendirme']);

    Livewire::test(JuriAnalizi::class)
        ->set('aktifRaporId', $rapor->id)
        ->assertDontSee('gizli değerlendirme')
        ->call('raporSil', $rapor->id);

    expect(JuriRaporu::query()->whereKey($rapor->id)->exists())->toBeTrue();
});

test('hedef kadro değişince kurum seçimi yeniden hesaplanır', function () {
    // Doçentlik için eşik yok: eski seçim kalırsa analiz hata verirdi.
    Livewire::test(JuriAnalizi::class)
        ->assertSet('hedefKurum', 'Mersin Üniversitesi')
        ->set('hedefKadro', 'docentlik')
        ->assertSet('hedefKurum', '')
        ->assertSee('yönergesi girilmiş kurum yok');
});
