<?php

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Services\Scoring\KosulDegerlendirici;

function faal(Kategori $kategori, ?string $kaynak, string $rol): Faaliyet
{
    return new Faaliyet(['kategori' => $kategori, 'kaynak' => $kaynak, 'yazar_rolu' => $rol]);
}

test('adet ve yazarlık koşulları doğru sayılır', function () {
    $faaliyetler = [
        faal(Kategori::Makale, 'AHCI', 'baslica'),
        faal(Kategori::Makale, 'TR Dizin', 'tek'),
        faal(Kategori::Makale, 'TR Dizin', 'tek'),
        faal(Kategori::Makale, 'TR Dizin', 'ortak'),
    ];

    $kosullar = [
        ['aciklama' => 'uluslararası başlıca ≥1', 'kategori' => 'makale', 'kaynaklar' => ['AHCI', 'ESCI / Scopus'], 'yazar' => 'baslica', 'min_adet' => 1],
        ['aciklama' => 'TR Dizin ≥5', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'min_adet' => 5],
        ['aciklama' => 'TR Dizin tek yazar ≥3', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'yazar' => 'tek', 'min_adet' => 3],
    ];

    $sonuc = (new KosulDegerlendirici)->degerlendir($faaliyetler, $kosullar);

    expect($sonuc[0]->saglandi())->toBeTrue()                    // 1 başlıca uluslararası
        ->and($sonuc[1]->mevcut)->toBe(3)                       // 3 TR Dizin
        ->and($sonuc[1]->saglandi())->toBeFalse()               // 3 < 5
        ->and($sonuc[2]->mevcut)->toBe(2)                       // 2 tek yazar
        ->and($sonuc[2]->saglandi())->toBeFalse();              // 2 < 3
});

test('tek yazar başlıca sayılır', function () {
    $kosul = [['aciklama' => 'başlıca ≥1', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'yazar' => 'baslica', 'min_adet' => 1]];

    $sonuc = (new KosulDegerlendirici)->degerlendir([faal(Kategori::Makale, 'AHCI', 'tek')], $kosul);

    expect($sonuc[0]->saglandi())->toBeTrue();
});

test('bilgi koşulu belge ile doğrulanır ve uygunluğu engellemez', function () {
    $sonuc = (new KosulDegerlendirici)->degerlendir([], [
        ['aciklama' => 'Yayınların en az 2\'si son 7 yılda', 'bilgi' => true],
    ]);

    expect($sonuc[0]->bilgi)->toBeTrue()
        ->and($sonuc[0]->saglandi())->toBeTrue();          // gerekli 0 → bloke etmez
});

test('veya koşulu seçeneklerden biri sağlanınca geçer', function () {
    $faaliyetler = [
        faal(Kategori::Kitap, 'Kitap Bölümü', 'ortak'),
        faal(Kategori::Kitap, 'Kitap Bölümü', 'ortak'),
    ];

    $kosul = [['aciklama' => 'kitap veya 2 bölüm', 'veya' => [
        ['kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'min_adet' => 1],
        ['kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'min_adet' => 2],
    ]]];

    $sonuc = (new KosulDegerlendirici)->degerlendir($faaliyetler, $kosul);

    expect($sonuc[0]->saglandi())->toBeTrue();                  // 2 bölüm → ikinci seçenek
});
