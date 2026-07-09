<?php

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Services\Scoring\PuanRaporu;
use App\Services\Scoring\RuleSet;

beforeEach(function () {
    $this->motor = new PuanRaporu(RuleSet::fromConfig('ilahiyat_2026'));
});

function kayit(Kategori $kategori, int $puan): Faaliyet
{
    return new Faaliyet(['kategori' => $kategori, 'puan' => $puan]);
}

test('boş kümede tüm kategoriler sıfır ve toplam sıfırdır', function () {
    $rapor = $this->motor->olustur([]);

    expect($rapor->toplamPuan)->toBe(0)
        ->and($rapor->tumKategoriler())->toHaveCount(count(Kategori::cases()))
        ->and($rapor->kategori(Kategori::Makale)->puan)->toBe(0)
        ->and($rapor->kategori(Kategori::Makale)->adet)->toBe(0);
});

test('aynı kategorideki puanları toplar ve adet sayar', function () {
    $rapor = $this->motor->olustur([
        kayit(Kategori::Makale, 10),
        kayit(Kategori::Makale, 8),
    ]);

    expect($rapor->kategori(Kategori::Makale)->hamPuan)->toBe(18)
        ->and($rapor->kategori(Kategori::Makale)->puan)->toBe(18)
        ->and($rapor->kategori(Kategori::Makale)->adet)->toBe(2)
        ->and($rapor->toplamPuan)->toBe(18);
});

test('kategori tavanı ham puanı sınırlar', function () {
    // Makale tavanı 40; toplam ham 50 → puan 40'a kırpılır.
    $rapor = $this->motor->olustur([
        kayit(Kategori::Makale, 20),
        kayit(Kategori::Makale, 20),
        kayit(Kategori::Makale, 10),
    ]);

    $sonuc = $rapor->kategori(Kategori::Makale);

    expect($sonuc->hamPuan)->toBe(50)
        ->and($sonuc->puan)->toBe(40)
        ->and($sonuc->tavanAsildi())->toBeTrue()
        ->and($sonuc->yuzde())->toBe(100)
        ->and($rapor->toplamPuan)->toBe(40);
});

test('toplam puan tavan uygulanmış kategori puanlarının toplamıdır', function () {
    $rapor = $this->motor->olustur([
        kayit(Kategori::Makale, 10),
        kayit(Kategori::TezYayini, 5),
        kayit(Kategori::Atif, 1),
    ]);

    expect($rapor->toplamPuan)->toBe(16)
        ->and($rapor->toplamAdet())->toBe(3);
});

test('hedef yüzdeleri ve kalan puan doğru hesaplanır', function () {
    $faaliyetler = [];
    // 25 puanlık makale (tavan 40 altında).
    $faaliyetler[] = kayit(Kategori::Makale, 25);

    $rapor = $this->motor->olustur($faaliyetler);

    expect($rapor->toplamPuan)->toBe(25)
        ->and($rapor->uakHedef)->toBe(100)
        ->and($rapor->uakYuzde())->toBe(25)
        ->and($rapor->kalanUakPuan())->toBe(75)
        ->and($rapor->universiteYuzde())->toBe(11); // 25/220 ≈ %11
});

test('yüzdeler 100 ile sınırlıdır', function () {
    // Aşırı yüksek toplam için birçok kategoriyi tavana kadar doldur.
    $faaliyetler = [];
    foreach (Kategori::cases() as $kategori) {
        $faaliyetler[] = kayit($kategori, 1000);
    }

    $rapor = $this->motor->olustur($faaliyetler);

    expect($rapor->uakYuzde())->toBe(100)
        ->and($rapor->kalanUakPuan())->toBe(0);
});
