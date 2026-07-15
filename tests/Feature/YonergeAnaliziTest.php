<?php

use App\Enums\Kategori;
use App\Livewire\YonergeAnalizi;
use App\Models\Faaliyet;
use App\Models\Universite;
use App\Models\User;
use App\Models\Yonerge;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    // Kontrollü 6 üniversite yönergesi (belirli barajlar/kadro).
    $veriler = [
        ['Mersin Üniversitesi', 'Mersin', 'devlet', 90, 'docentlik'],
        ['Necmettin Erbakan Üniversitesi', 'Konya', 'devlet', 60, 'dr_ogr_uyesi'],
        ['Ankara Üniversitesi', 'Ankara', 'devlet', 120, 'docentlik'],
        ['Marmara Üniversitesi', 'İstanbul', 'devlet', 100, 'docentlik'],
        ['İstanbul 29 Mayıs Üniversitesi', 'İstanbul', 'vakif', 55, 'dr_ogr_uyesi'],
        ['Sakarya Üniversitesi', 'Sakarya', 'devlet', 80, 'docentlik'],
    ];

    foreach ($veriler as [$ad, $sehir, $tur, $baraj]) {
        $uni = Universite::factory()->create(['ad' => $ad, 'sehir' => $sehir, 'tur' => $tur]);
        $yonerge = Yonerge::factory()->ilahiyatKurallari()->create([
            'universite_id' => $uni->id,
            'ad' => $ad,
        ]);
        // Doğrulanmış Dr. Öğr. Üyesi eşiği (kullanıcı ilahiyat → sosyal fallback).
        $yonerge->esikler()->create([
            'kadro' => 'dr_ogr_uyesi', 'alan' => 'sosyal', 'min_toplam' => $baraj, 'kaynak' => 'pdf',
        ]);
    }

    // Arş. Gör. → varsayılan hedef kadro Dr. Öğr. Üyesi (eşiklerle uyumlu).
    $this->user = User::factory()->onboarded()->create(['unvan' => 'Arş. Gör.']);

    // Toplam 70 puan: makale 20+20, kitap 20, tez 10 (yeniden puanlamayla da aynı).
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCIE/SSCI (Q2)', 'puan' => 20]);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCIE/SSCI (Q2)', 'puan' => 20]);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Kitap, 'kaynak' => 'Uluslararası/Ulusal Kitap', 'puan' => 20]);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::TezYayini, 'kaynak' => 'ESCI / Scopus', 'puan' => 10]);

    actingAs($this->user);
});

test('durum sayaçları (özet) doğru hesaplanır', function () {
    // 70 puan: barajlar 55,60 uygun; 80 yakın; 90,100,120 yetersiz.
    $ozet = Livewire::test(YonergeAnalizi::class)->instance()->ozet();

    expect($ozet['toplam'])->toBe(6)
        ->and($ozet['uygun'])->toBe(2)
        ->and($ozet['yakin'])->toBe(1)
        ->and($ozet['yetersiz'])->toBe(3);
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
        ->keyBy(fn ($s) => $s['yonerge']->universite->ad);

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
    $uni = Universite::factory()->create(['ad' => 'Alan Test Üni', 'tur' => 'devlet']);
    $yonerge = Yonerge::factory()->ilahiyatKurallari()->create([
        'universite_id' => $uni->id, 'ad' => 'Alan Test Üni', 'universite_hedef' => 999,
    ]);
    // Sosyal: min 50 (uygun), Fen: min 150 (yetersiz)
    $yonerge->esikler()->create(['kadro' => 'dr_ogr_uyesi', 'alan' => 'sosyal', 'min_toplam' => 50, 'kaynak' => 'pdf']);
    $yonerge->esikler()->create(['kadro' => 'dr_ogr_uyesi', 'alan' => 'fen', 'min_toplam' => 150, 'kaynak' => 'pdf']);

    $bul = fn () => collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
        ->first(fn ($s) => $s['yonerge']->universite->ad === 'Alan Test Üni');

    // İlahiyat kullanıcı (70 puan): ilahiyat eşiği yok → sosyal'e düşer (min 50) → uygun
    expect($bul()['baraj'])->toBe(50)
        ->and($bul()['durum'])->toBe('uygun');

    // Fen kullanıcısı: min 150 → yetersiz
    $this->user->update(['temel_alan' => 'fen']);
    expect($bul()['baraj'])->toBe(150)
        ->and($bul()['durum'])->toBe('yetersiz');
});

test('hedef kadro değişince o kadronun eşiği kullanılır', function () {
    $uni = Universite::factory()->create(['ad' => 'Kadro Test Üni', 'tur' => 'devlet']);
    $yonerge = Yonerge::factory()->ilahiyatKurallari()->create([
        'universite_id' => $uni->id, 'ad' => 'Kadro Test Üni', 'universite_hedef' => 999,
    ]);
    // onboarded kullanıcı 'ilahiyat' → sosyal fallback
    $yonerge->esikler()->create(['kadro' => 'dr_ogr_uyesi', 'alan' => 'sosyal', 'min_toplam' => 50, 'kaynak' => 'pdf']);
    $yonerge->esikler()->create(['kadro' => 'docentlik', 'alan' => 'sosyal', 'min_toplam' => 300, 'kaynak' => 'pdf']);

    $baraj = fn (string $kadro) => collect(
        Livewire::test(YonergeAnalizi::class)->set('hedefKadro', $kadro)->instance()->sonuclar()
    )->first(fn ($s) => $s['yonerge']->universite->ad === 'Kadro Test Üni')['baraj'];

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
        ->and($sonuclar[0]['yonerge']->universite->ad)->toBe('Mersin Üniversitesi');
});

test('üniversite türüne göre filtreler', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)
        ->set('turFiltre', 'vakif')
        ->instance()->sonuclar();

    expect($sonuclar)->toHaveCount(1)
        ->and($sonuclar[0]['yonerge']->universite->ad)->toBe('İstanbul 29 Mayıs Üniversitesi');
});

test('doğrulanmış eşik alt-koşulları değerlendirilir', function () {
    $uni = Universite::factory()->create(['ad' => 'Doğrulanmış Test Üni', 'tur' => 'devlet']);
    $yonerge = Yonerge::factory()->ilahiyatKurallari()->create([
        'universite_id' => $uni->id, 'ad' => 'Doğrulanmış Test Üni', 'universite_hedef' => 100,
    ]);
    $yonerge->esikler()->create([
        'kadro' => 'dr_ogr_uyesi', 'alan' => 'sosyal',
        'min_toplam' => 100, 'yayin_min' => 40, 'yds_min' => 55, 'kaynak' => 'pdf',
    ]);

    $sonuclar = collect(Livewire::test(YonergeAnalizi::class)->instance()->sonuclar())
        ->keyBy(fn ($s) => $s['yonerge']->universite->ad);

    $s = $sonuclar['Doğrulanmış Test Üni'];
    $kosullar = collect($s['sonuc']->kosullar)->keyBy('ad');

    expect($s['dogrulandi'])->toBeTrue()
        ->and($s['durum'])->toBe('yetersiz')                                  // toplam 70 < 100
        ->and($s['sonuc']->toplam)->toBe(70)
        ->and($kosullar['Toplam puan']->saglandi())->toBeFalse()
        ->and($kosullar['Yayın puanı (makale/kitap/tez)']->saglandi())->toBeTrue(); // 70 ≥ 40
});

test('baraja göre artan sıralar', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)
        ->set('siralama', 'baraj_artan')
        ->instance()->sonuclar();

    $barajlar = array_column($sonuclar, 'baraj');

    expect($barajlar)->toBe([55, 60, 80, 90, 100, 120]);
});

test('profil toplamı kullanıcının kendi puanını yansıtır', function () {
    expect(Livewire::test(YonergeAnalizi::class)->instance()->profilToplam())->toBe(70);
});

test('sayfa render olur ve üniversiteleri gösterir', function () {
    Livewire::test(YonergeAnalizi::class)
        ->assertOk()
        ->assertSee('Mersin Üniversitesi')
        ->assertSee('Mevcut Profilim');
});
