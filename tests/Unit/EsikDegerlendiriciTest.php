<?php

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Models\YonergeEsik;
use App\Services\Scoring\EsikDegerlendirici;
use App\Services\Scoring\RuleSet;

beforeEach(function () {
    $this->motor = new EsikDegerlendirici(RuleSet::fromConfig('ilahiyat_2026'));
});

function faaliyetKumesi(): array
{
    // makale 20 + 20, kitap 20, tez 10 → toplam 70, yayın 70; indeks (SCIE/SSCI/AHCI) = 20+20+10 = 50
    return [
        new Faaliyet(['kategori' => Kategori::Makale, 'kaynak' => 'SCIE/SSCI (Q2)', 'puan' => 20]),
        new Faaliyet(['kategori' => Kategori::Makale, 'kaynak' => 'SCIE/SSCI (Q2)', 'puan' => 20]),
        new Faaliyet(['kategori' => Kategori::Kitap, 'kaynak' => 'Uluslararası/Ulusal Kitap', 'puan' => 20]),
        new Faaliyet(['kategori' => Kategori::TezYayini, 'kaynak' => 'SCIE/SSCI/AHCI', 'puan' => 10]),
    ];
}

test('tüm koşullar sağlanınca uygun', function () {
    $esik = new YonergeEsik(['min_toplam' => 60, 'yayin_min' => 40, 'index_min' => 40]);
    $sonuc = $this->motor->degerlendir(faaliyetKumesi(), $esik);

    expect($sonuc->uygun)->toBeTrue()
        ->and($sonuc->durum)->toBe('uygun')
        ->and($sonuc->toplam)->toBe(70)
        ->and($sonuc->eksikler())->toBe([]);
});

test('bir alt-koşul patlarsa yetersiz ve eksikte görünür', function () {
    $esik = new YonergeEsik(['min_toplam' => 100, 'yayin_min' => 30, 'index_min' => 40]);
    $sonuc = $this->motor->degerlendir(faaliyetKumesi(), $esik);

    // toplam 70<100 (patlar), yayın 70>=30, indeks 50>=40
    expect($sonuc->uygun)->toBeFalse()
        ->and($sonuc->durum)->toBe('yetersiz')
        ->and(collect($sonuc->eksikler())->pluck('ad')->all())->toBe(['Toplam puan']);
});

test('YDS koşulu bilgi amaçlıdır, uygunluğu engellemez', function () {
    $esik = new YonergeEsik(['min_toplam' => 60, 'yds_min' => 85]);
    $sonuc = $this->motor->degerlendir(faaliyetKumesi(), $esik, yds: null);

    // YDS bilgi → uygunluğu bozmaz
    expect($sonuc->uygun)->toBeTrue()
        ->and(collect($sonuc->kosullar)->firstWhere('ad', 'Yabancı dil (YDS)')->bilgi)->toBeTrue();
});

test('indeks puanı yalnızca uluslararası kaynaklardan sayılır', function () {
    $esik = new YonergeEsik(['min_toplam' => 10, 'index_min' => 60]);
    $sonuc = $this->motor->degerlendir(faaliyetKumesi(), $esik);

    // indeks = SCIE/SSCI olanlar: 20+20+10 = 50 (kitap indeks değil) → 50<60 patlar
    $indeks = collect($sonuc->kosullar)->firstWhere('ad', 'Uluslararası indeks (SCIE/SSCI/AHCI)');
    expect($indeks->mevcut)->toBe(50)
        ->and($indeks->saglandi())->toBeFalse();
});
