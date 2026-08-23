<?php

use App\Enums\Kategori;
use App\Livewire\FaaliyetEkle;
use App\Models\Faaliyet;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\ProfilCozucu;
use App\Services\Scoring\Sart\SartDeposu;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    // Puan önizlemesi kullanıcının KENDİ üniversitesinin cetvelinden gelir.
    Universite::factory()->create(['ad' => 'Test Üniversitesi']);

    app()->instance(SartDeposu::class, new SartDeposu(
        esikVerisi: [[
            'anahtar' => 'test-dr-ilahiyat', 'universite' => 'Test Üniversitesi',
            'kadro' => 'dr_ogr_uyesi', 'alan' => 'ilahiyat', 'birim' => null,
            'cetvel' => 'test-cetvel', 'notlar' => '',
            'sart' => ['tip' => 'puan', 'rol' => 'toplam', 'aciklama' => 'Toplam',
                'maddeler' => ['*'], 'min_puan' => 50],
        ]],
        cetvelVerisi: ['test-cetvel' => ['maddeler' => [
            'M1' => ['baslik' => 'Q2 makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 20],
            'M2' => ['baslik' => 'TR Dizin makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
        ]]],
    ));

    $this->user = User::factory()->onboarded()->create([
        'universite' => 'Test Üniversitesi',
    ]);
    actingAs($this->user);
});

test('ekleme sayfası ayrı bir sayfa olarak açılır', function () {
    $this->get(route('faaliyetler.ekle'))
        ->assertOk()
        ->assertSee('Faaliyet Ekle')
        ->assertSee('Manuel Ekle')
        ->assertSee("AVESİS'ten Çek");
});

test('manuel faaliyet ekler; puan SAKLANMAZ, cetvelden türetilir', function () {
    Livewire::test(FaaliyetEkle::class)
        ->set('kategori', Kategori::Makale->value)
        ->set('baslik', 'Kelam İlminde Yöntem')
        ->set('yazarlar', ['Ahmet K.', 'Mehmet Y.'])
        ->set('kaynak', 'SCIE/SSCI (Q2)')
        ->set('tarih', '2025-04-15')
        ->call('kaydet')
        ->assertHasNoErrors()
        ->assertRedirect(route('faaliyetler'));

    $faaliyet = $this->user->faaliyetler()->sole();

    expect($faaliyet->baslik)->toBe('Kelam İlminde Yöntem')
        ->and($faaliyet->kategori)->toBe(Kategori::Makale)
        ->and($faaliyet->tur)->toBe('Makale') // tür kategori etiketinden türetilir
        ->and($faaliyet->yazarlar)->toBe('Ahmet K., Mehmet Y.')
        // Puan artık kayda yazılmıyor: her yönerge kendi cetveliyle puanlıyor.
        ->and($faaliyet->puan)->toBe(0)
        ->and($faaliyet->durum)->toBe('onaylandi')
        ->and($faaliyet->tarih?->format('Y-m-d'))->toBe('2025-04-15');
});

test('yazar eklenip silinebilir ve kaydederken birleştirilir', function () {
    Livewire::test(FaaliyetEkle::class)
        ->assertSet('yazarlar', [''])
        ->call('yazarEkle')
        ->call('yazarEkle')
        ->assertCount('yazarlar', 3)
        ->set('yazarlar.0', 'Yazar Bir')
        ->set('yazarlar.1', 'Yazar İki')
        ->call('yazarSil', 1)
        ->assertCount('yazarlar', 2)
        ->set('kategori', Kategori::Makale->value)
        ->set('baslik', 'Çok Yazarlı Makale')
        ->call('kaydet')
        ->assertHasNoErrors();

    expect($this->user->faaliyetler()->sole()->yazarlar)->toBe('Yazar Bir');
});

test('düzenlemede yazarlar diziye ayrıştırılır', function () {
    $faaliyet = Faaliyet::factory()->for($this->user)->create(['yazarlar' => 'Ali V., Veli A.']);

    Livewire::test(FaaliyetEkle::class, ['faaliyet' => $faaliyet])
        ->assertSet('yazarlar', ['Ali V.', 'Veli A.']);
});

test('hızlı-ekle kategori query parametresi ön-seçili gelir', function () {
    Livewire::withQueryParams(['kategori' => 'tez_yayini'])
        ->test(FaaliyetEkle::class)
        ->assertSet('kategori', 'tez_yayini');
});

test('geçersiz kategori query parametresi varsayılanı korur', function () {
    Livewire::withQueryParams(['kategori' => 'olmayan'])
        ->test(FaaliyetEkle::class)
        ->assertSet('kategori', 'makale');
});

test('kategori değişince kaynak sıfırlanır', function () {
    Livewire::test(FaaliyetEkle::class)
        ->set('kaynak', 'SCIE/SSCI (Q2)')
        ->set('kategori', Kategori::Kitap->value)
        ->assertSet('kaynak', '');
});

test('canlı puan önizlemesi kullanıcının kendi cetvelinden gelir', function () {
    $component = Livewire::test(FaaliyetEkle::class)
        ->set('kategori', Kategori::Makale->value)
        ->set('kaynak', 'TR Dizin');

    expect($component->instance()->tahminiPuan())->toBe(10);
});

test('yönergesi girilmemiş üniversitede puan önizlemesi gösterilmez', function () {
    // Tahmini puan uydurmak yerine null döner; arayüz "yönerge girilmedi" der.
    $this->user->update(['universite' => 'Verisi Olmayan Üni']);

    $component = Livewire::test(FaaliyetEkle::class)
        ->set('kategori', Kategori::Makale->value)
        ->set('kaynak', 'TR Dizin');

    expect($component->instance()->tahminiPuan())->toBeNull();
});

test('zorunlu alanlar doğrulanır', function () {
    Livewire::test(FaaliyetEkle::class)
        ->set('baslik', '')
        ->call('kaydet')
        ->assertHasErrors(['baslik']);

    expect($this->user->faaliyetler()->count())->toBe(0);
});

test('mevcut faaliyet düzenlenir', function () {
    $faaliyet = Faaliyet::factory()->for($this->user)->create([
        'kategori' => Kategori::Makale,
        'kaynak' => 'TR Dizin',
        'puan' => 10,
    ]);

    Livewire::test(FaaliyetEkle::class, ['faaliyet' => $faaliyet])
        ->assertSet('baslik', $faaliyet->baslik)
        ->set('kaynak', 'SCIE/SSCI (Q2)')
        ->call('kaydet')
        ->assertHasNoErrors();

    expect($faaliyet->refresh()->kaynak)->toBe('SCIE/SSCI (Q2)');
});

test('başka kullanıcının faaliyeti düzenlenemez', function () {
    $baskasi = Faaliyet::factory()->for(User::factory())->create();

    $this->get(route('faaliyetler.duzenle', $baskasi))->assertNotFound();
});

test('tez ilişkisi düzeyiyle birlikte kaydedilir ve düzenlemede korunur', function () {
    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi']);

    Livewire::actingAs($user)->test(FaaliyetEkle::class)
        ->set('kategori', 'makale')
        ->set('baslik', 'Tezden üretilmiş makale')
        ->set('kaynak', 'SCIE/SSCI (Q1)')
        ->set('donem', 'yuksek_lisans')
        ->call('kaydet')
        ->assertHasNoErrors();

    $faaliyet = Faaliyet::firstOrFail();

    expect($faaliyet->donem)->toBe('yuksek_lisans')
        // Yüksek lisans tezi, "doktora tezinden üretilmemiş" koşuluna sayılır.
        ->and($faaliyet->haricDegeri('doktora_tezinden'))->toBeFalse()
        // Ama ÜAK'ın "lisansüstü tezlerden üretilmiş" tanımına girer.
        ->and($faaliyet->haricDegeri('lisansustu_tezden'))->toBeTrue();

    // Alana dokunmadan düzenleme değeri silmemeli.
    Livewire::actingAs($user)->test(FaaliyetEkle::class, ['faaliyet' => $faaliyet])
        ->set('baslik', 'Yeni başlık')
        ->call('kaydet')
        ->assertHasNoErrors();

    expect($faaliyet->fresh()->donem)->toBe('yuksek_lisans');
});

test('düzeyi belirsiz eski kayıt düzenlenebilir ama doktora varsayılmaz', function () {
    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi']);

    $eski = $user->faaliyetler()->create([
        'kategori' => Kategori::Makale, 'tur' => 'Makale', 'baslik' => 'Eski kayıt',
        'kaynak' => 'SCIE/SSCI (Q1)', 'rol' => 'tek', 'donem' => 'tezden', 'durum' => 'onaylandi',
    ]);

    expect($eski->haricDegeri('doktora_tezinden'))->toBeNull()
        ->and($eski->haricDegeri('lisansustu_tezden'))->toBeTrue();

    Livewire::actingAs($user)->test(FaaliyetEkle::class, ['faaliyet' => $eski])
        ->call('kaydet')
        ->assertHasNoErrors();

    expect($eski->fresh()->donem)->toBe('tezden');
});

test('tez ilişkisi yalnızca tezden üretilebilen yayın türlerinde sorulur', function () {
    expect(Kategori::Makale->tezdenUretilebilir())->toBeTrue()
        ->and(Kategori::Bildiri->tezdenUretilebilir())->toBeTrue()
        ->and(Kategori::Kitap->tezdenUretilebilir())->toBeTrue()
        // Tez danışmanlığında tezin düzeyi zaten alt tür alanında seçiliyor;
        // ikinci bir "tez ilişkisi" sorusu kafa karıştırıyordu.
        ->and(Kategori::TezDanismanligi->tezdenUretilebilir())->toBeFalse()
        // Bu kategorinin tanımı zaten "tezden üretilmiş yayın".
        ->and(Kategori::TezYayini->tezdenUretilebilir())->toBeFalse()
        ->and(Kategori::Proje->tezdenUretilebilir())->toBeFalse();
});

test('kategori tez ilişkisi sormuyorsa değer kaydedilmez', function () {
    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi']);

    // Makale iken seçilen değer, kategori tez danışmanlığına çevrilince
    // görünmez biçimde kaydedilmemeli.
    Livewire::actingAs($user)->test(FaaliyetEkle::class)
        ->set('kategori', 'makale')
        ->set('donem', 'doktora')
        ->set('kategori', 'tez_danismanligi')
        ->set('baslik', 'Doktora tezi danışmanlığı')
        ->set('kaynak', 'Doktora Tezi')
        ->call('kaydet')
        ->assertHasNoErrors();

    expect(Faaliyet::firstOrFail()->donem)->toBeNull();
});

test('faaliyet tarihi dönem koşullarını kesin sonuca bağlar', function () {
    $user = User::factory()->onboarded()->create([
        'universite' => 'Test Üniversitesi',
        'docentlik_tarihi' => '2022-06-01',
    ]);

    Livewire::actingAs($user)->test(FaaliyetEkle::class)
        ->set('kategori', 'makale')
        ->set('baslik', 'Doçentlik sonrası makale')
        ->set('kaynak', 'SCIE/SSCI (Q1)')
        ->set('tarih', '2024-03-10')
        ->call('kaydet')
        ->assertHasNoErrors();

    $faaliyet = Faaliyet::firstOrFail();

    expect($faaliyet->tarih?->format('Y-m-d'))->toBe('2024-03-10');

    // Dönüm tarihiyle aynı yıla düşen bir faaliyet artık ay/gün sayesinde
    // kesin olarak sınıflanabiliyor; yalnızca yıl saklansaydı belirsiz kalırdı.
    $profil = (new ProfilCozucu)->coz($user, [$faaliyet]);

    expect($profil->docentlikTarihi?->format('Y-m-d'))->toBe('2022-06-01')
        ->and($faaliyet->tarih->gt($profil->docentlikTarihi))->toBeTrue();
});

test('gelecek tarihli faaliyet reddedilir', function () {
    $user = User::factory()->onboarded()->create(['universite' => 'Test Üniversitesi']);

    Livewire::actingAs($user)->test(FaaliyetEkle::class)
        ->set('kategori', 'makale')
        ->set('baslik', 'Yarınki makale')
        ->set('tarih', now()->addDay()->format('Y-m-d'))
        ->call('kaydet')
        ->assertHasErrors('tarih');
});

test('yazar sırası seçenekleri girilen yazar sayısıyla sınırlanır', function () {
    actingAs(User::factory()->create());

    $secenekler = fn (Testable $t) => array_keys($t->instance()->rolSecenekleri());

    $bilesen = Livewire::test(FaaliyetEkle::class)->set('kategori', 'makale');

    // Yazar girilmemişken kısıtlama yapılamaz.
    expect($secenekler($bilesen))->toContain('yazar_5');

    // Tek yazarlı eserde sıra ya da ortaklık rolü anlamsız.
    $bilesen->set('yazarlar', ['Ada Lovelace']);
    expect($secenekler($bilesen))->toBe(['tek']);

    // Üç yazarlı eserde 4. ve sonraki sıralar seçilemez.
    $bilesen->set('yazarlar', ['A', 'B', 'C']);
    expect($secenekler($bilesen))->toBe(['ilk', 'baslica', 'yazar_2', 'yazar_3', 'ortak']);

    // "6. yazar ve sonrası" ancak altı yazardan itibaren görünür.
    $bilesen->set('yazarlar', ['A', 'B', 'C', 'D', 'E', 'F']);
    expect($secenekler($bilesen))->toContain('yazar_6');
});

test('yazar silinince geçersiz kalan rol temizlenir', function () {
    actingAs(User::factory()->create());

    Livewire::test(FaaliyetEkle::class)
        ->set('kategori', 'makale')
        ->set('yazarlar', ['A', 'B', 'C', 'D'])
        ->set('rol', 'yazar_4')
        ->assertSet('rol', 'yazar_4')
        // Dördüncü yazar silinince "4. yazar" seçimi tutarsız kalır.
        ->call('yazarSil', 3)
        ->assertSet('rol', '');
});

test('yazar alanı, sıra seçenekleri süzülse de görünür kalır', function () {
    actingAs(User::factory()->create());

    // Yazar bölümünün görünürlüğü kategorinin TAM rol listesinden türetilmeli;
    // süzülmüş listeye bakılsaydı ikinci yazar girilince 'tek' düşer ve alan
    // kullanıcının gözü önünde kaybolurdu.
    Livewire::test(FaaliyetEkle::class)
        ->set('kategori', 'makale')
        ->set('yazarlar', ['A', 'B'])
        ->assertSee('Yazarlar')
        ->assertSee('2. yazar');
});
