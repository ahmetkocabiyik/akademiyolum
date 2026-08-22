<?php

/**
 * Bursa Uludağ Üniversitesi — Tablo-1/Tablo-2'nin atıf yaptığı dergi kümeleri
 * Kaynak: pdf/1766060294419.bursa-uludag-kriter-18122025.pdf
 *
 * PUANSIZ CETVEL — bilinçli olarak.
 *
 * Bursa Uludağ'ın PDF'inde madde→puan listesi YOK. Değerlendirme Esasları
 * madde 6: "...Üniversitelerarası Kurul tarafından kabul edilen 2024 Mart
 * Doçentlik Başvuru Şartlarında belirlenen puan sistemi esas alınır."
 * Tablo-1 ve Tablo-2 birer EŞİK tablosu; içlerindeki `1`, `2a`, `7a` kodları
 * Bursa Uludağ'ın değil, atıf yapılan dış cetvelin madde numaraları.
 *
 * Bu yüzden burada yalnızca ADET koşullarının ihtiyaç duyduğu dergi kümeleri
 * tanımlı. Puana bağlı koşullar ağaçta `beyan` düğümü olarak duruyor; ÜAK
 * puan ölçeği eklendiğinde onlar gerçek `puan` düğümüne çevrilecek.
 */

return [
    'maddeler' => [
        'M-Q12' => ['baslik' => 'SCIE/SSCI Q1 veya Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)']],
        'M-Q13' => ['baslik' => 'SCIE/SSCI Q1, Q2 veya Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)']],
        'M-AQ13' => ['baslik' => 'SCIE/SSCI/AHCI Q1, Q2 veya Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'AHCI']],
    ],
    'gruplar' => [],
];
