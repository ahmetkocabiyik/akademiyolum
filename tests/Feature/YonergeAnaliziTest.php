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

    foreach ($veriler as [$ad, $sehir, $tur, $baraj, $kadro]) {
        $uni = Universite::factory()->create(['ad' => $ad, 'sehir' => $sehir, 'tur' => $tur]);
        Yonerge::factory()->ilahiyatKurallari()->create([
            'universite_id' => $uni->id,
            'ad' => $ad,
            'kadro' => $kadro,
            'universite_hedef' => $baraj,
        ]);
    }

    $this->user = User::factory()->onboarded()->create();

    // Toplam 70 puan: makale 40 (tavan), kitap 20, tez 10.
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCI/SSCI', 'puan' => 20]);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Makale, 'kaynak' => 'SCI/SSCI', 'puan' => 20]);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::Kitap, 'kaynak' => 'Uluslararası Yayınevi', 'puan' => 20]);
    Faaliyet::factory()->for($this->user)->create(['kategori' => Kategori::TezYayini, 'kaynak' => 'SCI/SSCI', 'puan' => 10]);

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

test('kadroya göre filtreler', function () {
    $sonuclar = Livewire::test(YonergeAnalizi::class)
        ->set('kadroFiltre', 'dr_ogr_uyesi')
        ->instance()->sonuclar();

    expect($sonuclar)->toHaveCount(2);
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
