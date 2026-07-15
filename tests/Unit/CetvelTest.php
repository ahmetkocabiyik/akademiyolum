<?php

test('üniversiteye özel cetvel ÜAK cetvelinden farklı puanlar taşır', function () {
    /** @var array<string, array<string, array{puanlar: array<string, int>}>> $cetveller */
    $cetveller = require database_path('data/cetveller.php');

    $afyonMakale = $cetveller['Afyon Kocatepe Üniversitesi']['makale']['puanlar'];
    $uakMakale = config('yonerge.setler.ilahiyat_2026.kategoriler.makale.puanlar');

    // Afyon Ek-1 ölçeği ÜAK'ın ~8 katı → aynı faaliyet farklı puan alır.
    expect($afyonMakale['TR Dizin'])->toBe(80)
        ->and($uakMakale['TR Dizin'])->toBe(10)
        ->and($afyonMakale['SCIE/SSCI (Q1)'])->toBe(160)
        ->and($uakMakale['SCIE/SSCI (Q1)'])->toBe(30);
});
