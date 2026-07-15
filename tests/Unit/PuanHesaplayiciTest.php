<?php

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Services\Scoring\PuanHesaplayici;
use App\Services\Scoring\RuleSet;

beforeEach(function () {
    $this->hesaplayici = new PuanHesaplayici(RuleSet::fromConfig('ilahiyat_2026'));
});

function faaliyet(Kategori $kategori, ?string $kaynak = null): Faaliyet
{
    return new Faaliyet(['kategori' => $kategori, 'kaynak' => $kaynak]);
}

test('kaynağa göre eşleşen puanı döndürür', function () {
    expect($this->hesaplayici->hesapla(faaliyet(Kategori::Makale, 'SCIE/SSCI (Q1)')))->toBe(30)
        ->and($this->hesaplayici->hesapla(faaliyet(Kategori::Makale, 'SCIE/SSCI (Q2)')))->toBe(20)
        ->and($this->hesaplayici->hesapla(faaliyet(Kategori::Makale, 'TR Dizin')))->toBe(10)
        ->and($this->hesaplayici->hesapla(faaliyet(Kategori::TezYayini, 'TR Dizin')))->toBe(5);
});

test('kaynak yoksa kategori varsayılanını kullanır', function () {
    expect($this->hesaplayici->hesapla(faaliyet(Kategori::Makale)))->toBe(4)
        ->and($this->hesaplayici->hesapla(faaliyet(Kategori::ToplumsalKatki)))->toBe(5)
        ->and($this->hesaplayici->hesapla(faaliyet(Kategori::Atif)))->toBe(1);
});

test('tanımsız kaynak varsayılana düşer', function () {
    expect($this->hesaplayici->hesapla(faaliyet(Kategori::Makale, 'Bilinmeyen Dizin')))->toBe(4);
});
