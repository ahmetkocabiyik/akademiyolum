<?php

/*
|--------------------------------------------------------------------------
| ŞART AĞACI — ŞEMA TASLAĞI (esikler.php'nin halefi)
|--------------------------------------------------------------------------
|
| Bu dosya HENÜZ SEEDER'A BAĞLI DEĞİL. Amacı, önerilen şemanın 179 yönergelik
| korpustaki dört farklı arketipi gerçekten tutup tutmadığını göstermek:
|
|   1) Gümüşhane      → faaliyet grubu bazlı asgari puan + dipnot telafileri
|   2) Samsun         → puansız, tamamen adet/tür tabanlı, alternatif bloklar
|   3) Sabancı        → program bazlı eşik + kotalı eşdeğerlik + dergi metriği
|   4) Bursa Uludağ   → ÜAK cetveline devir + [A]+[B]/[C] telafi + çarpanlar
|
| Her üniversitede yönergenin TAMAMI değil, şemanın her özelliğini en az bir kez
| zorlayan dilim yazıldı; hangi dilimin yazıldığı blok başlıklarında belirtildi.
|
|
| ── DÜĞÜM TİPLERİ ───────────────────────────────────────────────────────────
|
| BİRLEŞTİRİCİ
|   ['tip' => 've' | 'veya' | 'k_ile',
|    'k'        => int,               // yalnızca k_ile: kaç çocuk sağlanmalı
|    'aciklama' => string,
|    'cocuklar' => list<düğüm>,
|    'telafi'   => düğüm|null]        // bu düğüm sağlanmazsa devreye giren alternatif
|
| YAPRAK 'puan'   — bir madde kümesinden asgari puan
|   ['tip' => 'puan', 'aciklama' => string,
|    'maddeler'   => list<kod> | ['*'],
|    'min_puan'   => int,             // XOR min_oran
|    'min_oran'   => float,           // 0..1 — paydası oran_payda
|    'oran_payda' => list<kod>|['*'],
|    'donem'      => dönem|null,
|    'telafi'     => düğüm|null,
|    'telafi_carpani' => int|null]    // telafi düğümünde: gereken puan = eksik × çarpan
|                                     // (Trabzon "her eksik puanın iki katı")
|
| YAPRAK 'adet'   — bir madde kümesinden asgari eser sayısı
|   ['tip' => 'adet', 'aciklama' => string,
|    'maddeler'   => list<kod>,
|    'min_adet'   => int,
|    'yazar'      => 'tek'|'ilk'|'baslica'|null,
|    'haric'      => list<string>|null,   // ör. ['lisansustu_tezden']
|    'donem'      => dönem|null,
|    'donusumler' => list<dönüşüm>|null,
|    'telafi'     => düğüm|null]
|
| YAPRAK 'metrik' — faaliyet satırı olmayan profil ölçütü
|   ['tip' => 'metrik', 'aciklama' => string,
|    'metrik'     => 'h_indeksi'|'yds'|'tez_danismanlik'|'doktora_tez_danismanlik'
|                   |'ders_yariyil'|'yurtdisi_ay'|'atif_sayisi'|'proje_yurutuculuk',
|    'min'        => int|float,           // XOR kademeler
|    'kademeler'  => array<string,int>,   // ör. yds: program türüne göre eşik
|    'donem'      => dönem|null,
|    'donusumler' => list<dönüşüm>|null,
|    'telafi'     => düğüm|null]
|
| YAPRAK 'referans' — başka bir eşiğin şartını yeniden çağırır
|   ['tip' => 'referans', 'aciklama' => string,
|    'esik'   => string,              // hedef eşiğin anahtarı
|    'donem'  => dönem|null,          // hangi dönemde yeniden sağlanacak
|    'haric'  => list<string>|null]   // hedef şartın dışlanan parçaları
|
| YAPRAK 'beyan' — otomatik doğrulanamaz, kullanıcı beyanı / belge ile
|   ['tip' => 'beyan', 'aciklama' => string]
|
|
| ── YARDIMCI YAPILAR ────────────────────────────────────────────────────────
|
| dönem   ['baslangic' => 'lisans'|'doktora'|'docentlik'|'son_atama'|null,
|          'son_yil'   => int|null]
|
| dönüşüm ['aciklama'    => string,
|          'kaynak'      => list<kod>,
|          'kaynak_adet' => int,        // kaç kaynak eser
|          'hedef_adet'  => int,        // kaç hedef birime denk
|          'azami'       => int,        // bu yolla en fazla kaç hedef üretilebilir
|          'kota_grubu'  => string|null] // aynı grup kotayı PAYLAŞIR; null = bağımsız
|
|
| ── EŞİK KAYDI ──────────────────────────────────────────────────────────────
|
|   'anahtar'    => string            // referans düğümlerinin hedefi
|   'universite' => string
|   'kadro'      => 'dr_ogr_uyesi' | 'dr_ogr_uyesi_yeniden' | 'docentlik'
|                 | 'docentlik_yeniden' | 'profesorluk'
|   'alan'       => string|list<string>|null    // null = alandan bağımsız
|   'birim'      => string|null                 // fakülte / bölüm / program
|   'cetvel'     => string                      // hangi puan cetveli
|   'gecerlilik' => ['baslangic' => ?string, 'bitis' => ?string]
|   'notlar'     => string                      // yönergenin kendi cümlesi, tırnak içinde
|   'sart'       => düğüm
|
| NOT: 'maddeler' daima İLGİLİ YÖNERGENİN KENDİ madde kodlarıdır (Gümüşhane A1,
| Samsun D3, ÜAK 7a ...). Kodlar `yonerge_maddeleri` tablosunda tanımlanır; bu
| yüzden şart ağacı 'kaynak' etiketlerine değil koda bağlanır — yönergelerin
| alt-koşulları zaten kendi kod aralıklarına atıf yapıyor ("1.1.1-1.3.4.1 arası").
|
*/

// ── Kısayollar ───────────────────────────────────────────────────────────────
$doktoraSonrasi = ['baslangic' => 'doktora', 'son_yil' => null];
$docentlikSonrasi = ['baslangic' => 'docentlik', 'son_yil' => null];
$sonAtamaSonrasi = ['baslangic' => 'son_atama', 'son_yil' => null];

return [

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  1) GÜMÜŞHANE ÜNİVERSİTESİ — grup bazlı asgari puan + dipnot telafileri
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/178176998238.gumushane-kriter-18062026.pdf, EK-2 TABLO-3.
    | Yazılan dilim: TABLO-3 (Filoloji/Hukuk/İlahiyat/Sosyal), dört kadro sütunu.
    | Kod uzayı (EK-1): A1-A7 makale · B1-B9 bildiri · C1-C11 kitap · D1-D10 atıf
    |                   E1-E9 proje · İ1-İ4 lisansüstü · M1-M4 öğretim
    |
    | ŞEMAYI ZORLADIĞI YER: her satır ayrı bir `puan` yaprağı (grup bazlı asgari
    | puan), tabloda iki farklı toplam var (ASGARİ PUAN = zorunlu grupların
    | toplamı, TOPLAM ASGARİ PUAN = tüm faaliyetler), ve dört ayrı dipnot birer
    | `telafi` düğümü.
    */

    [
        'anahtar' => 'gumushane-dr-sosyal',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['filoloji', 'hukuk', 'ilahiyat', 'sosyal'],
        'birim' => null,
        'cetvel' => 'gumushane-2026',
        'gecerlilik' => ['baslangic' => '2026-06-18', 'bitis' => null],
        'notlar' => 'EK-2 TABLO-3, İLK ATANMA sütunu. Dipnot (1): "Makale asgari puanı A1-A2 '
            .'kategorilerinden sağlayanların A3 kategorisinden yayın yapmaları şartı aranmaz."',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Dr. Öğr. Üyesi ilk atanma asgari şartları',
            'cocuklar' => [
                [
                    'tip' => 'adet',
                    'aciklama' => 'A1-A2 kategorilerinden en az 1 yayın',
                    'maddeler' => ['A1', 'A2'],
                    'min_adet' => 1,
                ],
                [
                    'tip' => 'adet',
                    'aciklama' => 'A3 kategorisinden en az 1 yayın',
                    'maddeler' => ['A3'],
                    'min_adet' => 1,
                    // Dipnot (1): makale asgari puanı A1-A2'den karşılanmışsa bu şart düşer.
                    'telafi' => [
                        'tip' => 'puan',
                        'aciklama' => 'Makale asgari puanının tamamı A1-A2\'den karşılanmış olmalı',
                        'maddeler' => ['A1', 'A2'],
                        'min_puan' => 35,
                    ],
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'A grubundan (makale) toplamda en az 35 puan',
                    'maddeler' => ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7'],
                    'min_puan' => 35,
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'B grubundan (bildiri) en az 10 puan',
                    'maddeler' => ['B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9'],
                    'min_puan' => 10,
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'Zorunlu gruplardan asgari puan (45P)',
                    'maddeler' => ['A*', 'B*'],
                    'min_puan' => 45,
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'Tüm faaliyetlerden toplam asgari puan (55P)',
                    'maddeler' => ['*'],
                    'min_puan' => 55,
                ],
            ],
        ],
    ],

    [
        'anahtar' => 'gumushane-dr-yeniden-sosyal',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => ['filoloji', 'hukuk', 'ilahiyat', 'sosyal'],
        'birim' => null,
        'cetvel' => 'gumushane-2026',
        'gecerlilik' => ['baslangic' => '2026-06-18', 'bitis' => null],
        'notlar' => 'EK-2 TABLO-3, YENİDEN ATANMA / Dr. Öğretim Üyesi sütunu. Dipnot (2): '
            .'"Puan şartlarını sağlayamayanlar, A1-A2 kategorilerinden ilave olarak 1 yayın ya da '
            .'A3 kategorisinden ilave olarak 2 yayın yapmak zorundadır." — "ilave olarak" ifadesi '
            .'telafi yayınının asgari puana sayılıp sayılmayacağını açıkça söylemiyor.',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Dr. Öğr. Üyesi yeniden atanma asgari şartları',
            'cocuklar' => [
                [
                    'tip' => 'puan',
                    'aciklama' => 'A1-A3 kategorilerinden toplamda en az 30 puan',
                    'maddeler' => ['A1', 'A2', 'A3'],
                    'min_puan' => 30,
                    'donem' => $sonAtamaSonrasi,
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'B grubundan en az 10 puan',
                    'maddeler' => ['B*'],
                    'min_puan' => 10,
                    'donem' => $sonAtamaSonrasi,
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'E grubundan (proje) en az 15 puan',
                    'maddeler' => ['E*'],
                    'min_puan' => 15,
                    'donem' => $sonAtamaSonrasi,
                    // Dipnot (2)
                    'telafi' => [
                        'tip' => 'veya',
                        'aciklama' => 'Sağlanamazsa: A1-A2\'den ilave 1 yayın ya da A3\'ten ilave 2 yayın',
                        'cocuklar' => [
                            ['tip' => 'adet', 'aciklama' => 'A1-A2\'den ilave 1 yayın',
                                'maddeler' => ['A1', 'A2'], 'min_adet' => 1, 'donem' => $sonAtamaSonrasi],
                            ['tip' => 'adet', 'aciklama' => 'A3\'ten ilave 2 yayın',
                                'maddeler' => ['A3'], 'min_adet' => 2, 'donem' => $sonAtamaSonrasi],
                        ],
                    ],
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'M grubundan (öğretim) en az 20 puan',
                    'maddeler' => ['M*'],
                    'min_puan' => 20,
                    'donem' => $sonAtamaSonrasi,
                    'telafi' => [
                        'tip' => 'veya',
                        'aciklama' => 'Sağlanamazsa: A1-A2\'den ilave 1 yayın ya da A3\'ten ilave 2 yayın',
                        'cocuklar' => [
                            ['tip' => 'adet', 'aciklama' => 'A1-A2\'den ilave 1 yayın',
                                'maddeler' => ['A1', 'A2'], 'min_adet' => 1, 'donem' => $sonAtamaSonrasi],
                            ['tip' => 'adet', 'aciklama' => 'A3\'ten ilave 2 yayın',
                                'maddeler' => ['A3'], 'min_adet' => 2, 'donem' => $sonAtamaSonrasi],
                        ],
                    ],
                ],
                [
                    'tip' => 'puan', 'aciklama' => 'Zorunlu gruplardan asgari puan (75P)',
                    'maddeler' => ['A*', 'B*', 'E*', 'M*'], 'min_puan' => 75, 'donem' => $sonAtamaSonrasi,
                ],
                [
                    'tip' => 'puan', 'aciklama' => 'Toplam asgari puan (90P)',
                    'maddeler' => ['*'], 'min_puan' => 90, 'donem' => $sonAtamaSonrasi,
                ],
            ],
        ],
    ],

    [
        'anahtar' => 'gumushane-profesor-sosyal',
        'universite' => 'Gümüşhane Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['filoloji', 'hukuk', 'ilahiyat', 'sosyal'],
        'birim' => null,
        'cetvel' => 'gumushane-2026',
        'gecerlilik' => ['baslangic' => '2026-06-18', 'bitis' => null],
        'notlar' => 'EK-2 TABLO-3, Profesör sütunu. Dipnot (3) proje satırına, dipnot (4) '
            .'lisansüstü eğitim satırına, dipnot (2) öğretim satırına uygulanır.',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Profesör asgari şartları',
            'cocuklar' => [
                ['tip' => 'adet', 'aciklama' => 'A1-A2 kategorilerinden en az 1 yayın',
                    'maddeler' => ['A1', 'A2'], 'min_adet' => 1, 'donem' => $docentlikSonrasi],
                ['tip' => 'puan', 'aciklama' => 'A1-A3 kategorilerinden toplamda en az 80 puan',
                    'maddeler' => ['A1', 'A2', 'A3'], 'min_puan' => 80, 'donem' => $docentlikSonrasi],
                ['tip' => 'puan', 'aciklama' => 'B grubundan en az 20 puan',
                    'maddeler' => ['B*'], 'min_puan' => 20, 'donem' => $docentlikSonrasi],
                ['tip' => 'puan', 'aciklama' => 'C grubundan (kitap) en az 20 puan',
                    'maddeler' => ['C*'], 'min_puan' => 20, 'donem' => $docentlikSonrasi],
                ['tip' => 'puan', 'aciklama' => 'D grubundan (atıf) en az 30 puan',
                    'maddeler' => ['D*'], 'min_puan' => 30, 'donem' => $docentlikSonrasi],
                [
                    'tip' => 've',
                    'aciklama' => 'Proje koşulu',
                    'cocuklar' => [
                        ['tip' => 'adet', 'aciklama' => 'E1-E7 kategorilerinden en az 1 faaliyet',
                            'maddeler' => ['E1', 'E2', 'E3', 'E4', 'E5', 'E6', 'E7'], 'min_adet' => 1],
                        ['tip' => 'puan', 'aciklama' => 'E grubundan en az 20 puan',
                            'maddeler' => ['E*'], 'min_puan' => 20],
                    ],
                    // Dipnot (3)
                    'telafi' => [
                        'tip' => 've',
                        'aciklama' => 'Sağlanamazsa: A1-A2 ve A3 kategorilerinden ilave 1\'er yayın',
                        'cocuklar' => [
                            ['tip' => 'adet', 'aciklama' => 'A1-A2\'den ilave 1 yayın',
                                'maddeler' => ['A1', 'A2'], 'min_adet' => 1],
                            ['tip' => 'adet', 'aciklama' => 'A3\'ten ilave 1 yayın',
                                'maddeler' => ['A3'], 'min_adet' => 1],
                        ],
                    ],
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'İ1 veya İ2 kategorisinden en az 10 puan (tez danışmanlığı)',
                    'maddeler' => ['İ1', 'İ2'],
                    'min_puan' => 10,
                    // Dipnot (4)
                    'telafi' => [
                        'tip' => 'adet', 'aciklama' => 'Sağlanamazsa: A1-A2\'den ilave 1 yayın',
                        'maddeler' => ['A1', 'A2'], 'min_adet' => 1,
                    ],
                ],
                [
                    'tip' => 've',
                    'aciklama' => 'Öğretim koşulu',
                    'cocuklar' => [
                        ['tip' => 'puan', 'aciklama' => 'M3-M4 kategorilerinden en az 15 puan',
                            'maddeler' => ['M3', 'M4'], 'min_puan' => 15],
                        ['tip' => 'puan', 'aciklama' => 'M grubundan en az 30 puan',
                            'maddeler' => ['M*'], 'min_puan' => 30],
                    ],
                    'telafi' => [
                        'tip' => 'veya',
                        'aciklama' => 'Sağlanamazsa: A1-A2\'den ilave 1 yayın ya da A3\'ten ilave 2 yayın',
                        'cocuklar' => [
                            ['tip' => 'adet', 'aciklama' => 'A1-A2\'den ilave 1 yayın',
                                'maddeler' => ['A1', 'A2'], 'min_adet' => 1],
                            ['tip' => 'adet', 'aciklama' => 'A3\'ten ilave 2 yayın',
                                'maddeler' => ['A3'], 'min_adet' => 2],
                        ],
                    ],
                ],
                ['tip' => 'puan', 'aciklama' => 'Zorunlu gruplardan asgari puan (210P)',
                    'maddeler' => ['A*', 'B*', 'C*', 'D*', 'E*', 'İ*', 'M*'], 'min_puan' => 210,
                    'donem' => $docentlikSonrasi],
                ['tip' => 'puan', 'aciklama' => 'Toplam asgari puan (300P)',
                    'maddeler' => ['*'], 'min_puan' => 300, 'donem' => $docentlikSonrasi],
            ],
        ],
    ],

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  2) SAMSUN ÜNİVERSİTESİ — puansız, tamamen adet/tür tabanlı
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17537007522.samsununiverstesi.pdf, MADDE 5 + MADDE 10.
    | Yazılan dilim: Sosyal ve Beşerî Bilimler (MADDE 10/2), dört kadro.
    | Kod uzayı (MADDE 5, "başlıca çalışma" türleri):
    |   A1-A4 makale · B1-B4 kitap · C1-C2 bildiri · D1-D6 proje
    |   E1-E4 patent/tasarım · F1-F3 mimarlık · G1-G8 ödül/danışmanlık
    |
    | ŞEMAYI ZORLADIĞI YER: hiç puan yok — `puan` yaprağı hiç kullanılmıyor,
    | `min_toplam` diye bir alan olmadığı için sorun çıkmıyor. Kadro şartları
    | "a,b,c,d,e'den herhangi biri" biçiminde, her seçenek kendi içinde iç içe
    | adet kısıtı taşıyor ("en az 2 tanesi A1 olmak koşuluyla toplamda 6").
    */

    [
        'anahtar' => 'samsun-dr-sosyal',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'filoloji', 'ilahiyat', 'hukuk', 'egitim'],
        'birim' => null,
        'cetvel' => null, // puan cetveli yok
        'gecerlilik' => ['baslangic' => null, 'bitis' => null],
        'notlar' => 'MADDE 10/2: "Doktor Öğretim Üyesi kadrosuna ilk kez atanmak üzere başvuran '
            .'adayların en az 2 tanesi A1/A2/A3 türü olmak koşuluyla en az 3 adet başlıca '
            .'çalışmaya sahip olmaları gerekir."',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Dr. Öğr. Üyesi ilk atanma',
            'cocuklar' => [
                ['tip' => 'adet', 'aciklama' => 'A1/A2/A3 türünde en az 2 başlıca çalışma',
                    'maddeler' => ['A1', 'A2', 'A3'], 'min_adet' => 2],
                ['tip' => 'adet', 'aciklama' => 'Toplamda en az 3 başlıca çalışma',
                    'maddeler' => ['*'], 'min_adet' => 3],
            ],
        ],
    ],

    [
        'anahtar' => 'samsun-dr-yeniden-sosyal',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => ['sosyal', 'filoloji', 'ilahiyat', 'hukuk', 'egitim'],
        'birim' => null,
        'cetvel' => null,
        'gecerlilik' => ['baslangic' => null, 'bitis' => null],
        'notlar' => 'MADDE 10/2: "...bir önceki atama tarihinden sonraki çalışmaları kapsamak '
            .'üzere aşağıdaki a, b, c şartlarından birini yerine getirmesi gerekir." '
            .'(b) şıkkı birebir şöyle: "En az 1 tanesi A1 veya A2 olmak kaydıyla A3/B1/B2/B3/C1 '
            .'türü en az 4 adet başlıca çalışma sahibi olmak." — A1/A2 sayılan kümede yer '
            .'almadığı için cümle kendi içinde tutarsız; burada 4 adedin A1-A2 dahil birleşik '
            .'kümeden sayıldığı yorumu uygulandı.',
        'sart' => [
            'tip' => 'veya',
            'aciklama' => 'a, b veya c şartlarından biri (son atamadan sonraki çalışmalarla)',
            'cocuklar' => [
                [
                    'tip' => 'adet',
                    'aciklama' => '(a) A1/A2 türünde en az 2 başlıca çalışma',
                    'maddeler' => ['A1', 'A2'], 'min_adet' => 2, 'donem' => $sonAtamaSonrasi,
                ],
                [
                    'tip' => 've',
                    'aciklama' => '(b) En az 1\'i A1/A2 olmak üzere A3/B1/B2/B3/C1 türü 4 çalışma',
                    'cocuklar' => [
                        ['tip' => 'adet', 'aciklama' => 'En az 1 tanesi A1 veya A2',
                            'maddeler' => ['A1', 'A2'], 'min_adet' => 1, 'donem' => $sonAtamaSonrasi],
                        ['tip' => 'adet', 'aciklama' => 'Toplamda en az 4 çalışma',
                            'maddeler' => ['A1', 'A2', 'A3', 'B1', 'B2', 'B3', 'C1'],
                            'min_adet' => 4, 'donem' => $sonAtamaSonrasi],
                    ],
                ],
                [
                    'tip' => 'adet',
                    'aciklama' => '(c) D1/D3/D5 türünde en az 1 başlıca çalışma',
                    'maddeler' => ['D1', 'D3', 'D5'], 'min_adet' => 1, 'donem' => $sonAtamaSonrasi,
                ],
            ],
        ],
    ],

    [
        'anahtar' => 'samsun-profesor-sosyal',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'filoloji', 'ilahiyat', 'hukuk', 'egitim'],
        'birim' => null,
        'cetvel' => null,
        'gecerlilik' => ['baslangic' => null, 'bitis' => null],
        'notlar' => 'MADDE 10/2: "Profesör kadrosuna atama yapılırken adaylarda doçentlik sonrası '
            .'en az 4 yarıyıl bir yükseköğretim kurumunda ders vermiş olma şartı aranır. Bunun '
            .'yanı sıra adayların aşağıda belirtilen a, b, c, d, e şartlarından herhangi birini '
            .'karşılamaları gerekir."',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Profesör asgari şartları',
            'cocuklar' => [
                [
                    'tip' => 'metrik',
                    'aciklama' => 'Doçentlik sonrası en az 4 yarıyıl ders vermiş olmak',
                    'metrik' => 'ders_yariyil', 'min' => 4, 'donem' => $docentlikSonrasi,
                ],
                [
                    'tip' => 'veya',
                    'aciklama' => 'a, b, c, d veya e şartlarından herhangi biri',
                    'cocuklar' => [
                        ['tip' => 'adet', 'aciklama' => '(a) A1 türü en az 4 çalışma',
                            'maddeler' => ['A1'], 'min_adet' => 4, 'donem' => $docentlikSonrasi],
                        [
                            'tip' => 've', 'aciklama' => '(b) En az 2\'si A1, toplamda 6 çalışma',
                            'cocuklar' => [
                                ['tip' => 'adet', 'aciklama' => 'A1 türü en az 2',
                                    'maddeler' => ['A1'], 'min_adet' => 2, 'donem' => $docentlikSonrasi],
                                ['tip' => 'adet', 'aciklama' => 'Toplamda en az 6',
                                    'maddeler' => ['*'], 'min_adet' => 6, 'donem' => $docentlikSonrasi],
                            ],
                        ],
                        [
                            'tip' => 've', 'aciklama' => '(c) En az 4\'ü A1/A2, toplamda 8 çalışma',
                            'cocuklar' => [
                                ['tip' => 'adet', 'aciklama' => 'A1/A2 türü en az 4',
                                    'maddeler' => ['A1', 'A2'], 'min_adet' => 4, 'donem' => $docentlikSonrasi],
                                ['tip' => 'adet', 'aciklama' => 'Toplamda en az 8',
                                    'maddeler' => ['*'], 'min_adet' => 8, 'donem' => $docentlikSonrasi],
                            ],
                        ],
                        [
                            'tip' => 've', 'aciklama' => '(d) En az 6\'sı belirli türlerden, toplamda 10',
                            'cocuklar' => [
                                ['tip' => 'adet', 'aciklama' => 'A1/A2/A3/A4/B1/B3/D1/D3/D5 türü en az 6',
                                    'maddeler' => ['A1', 'A2', 'A3', 'A4', 'B1', 'B3', 'D1', 'D3', 'D5'],
                                    'min_adet' => 6, 'donem' => $docentlikSonrasi],
                                ['tip' => 'adet', 'aciklama' => 'Toplamda en az 10',
                                    'maddeler' => ['*'], 'min_adet' => 10, 'donem' => $docentlikSonrasi],
                            ],
                        ],
                        [
                            'tip' => 've', 'aciklama' => '(e) D1/D3/D5 türü 2 çalışma, en az 1\'i doçentlik sonrası',
                            'cocuklar' => [
                                ['tip' => 'adet', 'aciklama' => 'D1/D3/D5 türü en az 2 çalışma',
                                    'maddeler' => ['D1', 'D3', 'D5'], 'min_adet' => 2],
                                ['tip' => 'adet', 'aciklama' => 'Bunlardan en az 1\'i doçentlik sonrası',
                                    'maddeler' => ['D1', 'D3', 'D5'], 'min_adet' => 1,
                                    'donem' => $docentlikSonrasi],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  3) SABANCI ÜNİVERSİTESİ — program bazlı eşik + kotalı eşdeğerlik
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/17537103422.sabanciuniversitesi.pdf, EK-1 MDBF.
    | Yazılan dilim: Bilgisayar Bilimleri ve Mühendisliği Programı, üç kadro.
    | Kod uzayı bu yönergede yok; aşağıdaki kodlar taslakta tanımlandı:
    |   SU-M1 SCI/SCIE/SSCI Q1-Q2 **veya** CWTS SNIP ≥ 1.0 dergide makale
    |   SU-M2 JCR Q3-Q4 dergide yayın
    |   SU-K1 WoS/SCOPUS listeli uluslararası konferans bildirisi
    |   SU-K2 yüksek etki değerli konferans/sempozyum/çalıştay bildirisi (program listesi)
    |   SU-B1 saygın yayınevi kitap bölümü
    |
    | ŞEMAYI ZORLADIĞI YER: eşik `birim` (program) düzeyinde; eşdeğerlikler
    | ORANLI ve KOTALI; iki kota birbirinden bağımsız ("üstteki maddeden bağımsız
    | şekilde"); dönüşümler `metrik` yapraklarına da uygulanıyor (proje, tez);
    | tarihe bağlı muafiyet var.
    */

    [
        'anahtar' => 'sabanci-dr-mdbf-cs',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => null,
        'birim' => 'MDBF — Bilgisayar Bilimleri ve Mühendisliği Programı',
        'cetvel' => null,
        'gecerlilik' => ['baslangic' => null, 'bitis' => null],
        'notlar' => 'EK-1 MDBF, "EĞİTİM ve ARAŞTIRMA AĞIRLIKLI ÖĞRETİM ÜYESİ / DR. ÖĞRETİM ÜYESİ". '
            .'İki eşdeğerlik kuralı var ve yönerge ikincisi için açıkça "üstteki maddeden '
            .'bağımsız şekilde en fazla bir bilimsel makale için kullanılabilir" diyor.',
        'sart' => [
            'tip' => 'adet',
            'aciklama' => 'Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 3 bilimsel makale',
            'maddeler' => ['SU-M1'],
            'min_adet' => 3,
            'donusumler' => [
                [
                    'aciklama' => '2 adet Q3/Q4 yayın 1 makaleye denk',
                    'kaynak' => ['SU-M2'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                    'azami' => 1, 'kota_grubu' => 'ikame-a',
                ],
                [
                    'aciklama' => '2 adet WoS/SCOPUS listeli uluslararası konferans 1 makaleye denk',
                    'kaynak' => ['SU-K1'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                    'azami' => 1, 'kota_grubu' => 'ikame-a',
                ],
                [
                    'aciklama' => '2 adet saygın yayınevi kitap bölümü 1 makaleye denk',
                    'kaynak' => ['SU-B1'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                    'azami' => 1, 'kota_grubu' => 'ikame-a',
                ],
                [
                    'aciklama' => 'Yüksek etki değerli konferans yayını 1 makale sayılır (bağımsız kota)',
                    'kaynak' => ['SU-K2'], 'kaynak_adet' => 1, 'hedef_adet' => 1,
                    'azami' => 1, 'kota_grubu' => 'ikame-b',
                ],
            ],
        ],
    ],

    [
        'anahtar' => 'sabanci-docent-mdbf-cs',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => null,
        'birim' => 'MDBF — Bilgisayar Bilimleri ve Mühendisliği Programı',
        'cetvel' => null,
        'gecerlilik' => ['baslangic' => null, 'bitis' => null],
        'notlar' => 'EK-1 MDBF / DOÇENT. Proje ve tez koşullarının kendi eşdeğerlik kuralları var: '
            .'"İki projede araştırmacı olmak bir proje yürütücülüğüne eşdeğer olarak '
            .'değerlendirilebilir." · "İki eş danışmanlık bir baş danışmanlığa eşdeğer olarak '
            .'değerlendirilebilir. Bu koşul en fazla bir lisansüstü tez baş danışmanlığı için '
            .'kullanılabilir."',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Doçent asgari şartları',
            'cocuklar' => [
                [
                    'tip' => 'adet',
                    'aciklama' => 'Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 8 makale',
                    'maddeler' => ['SU-M1'], 'min_adet' => 8,
                    'donusumler' => [
                        ['aciklama' => '2 adet Q3/Q4 yayın 1 makaleye denk',
                            'kaynak' => ['SU-M2'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                            'azami' => 2, 'kota_grubu' => 'ikame-a'],
                        ['aciklama' => '2 adet WoS/SCOPUS konferans 1 makaleye denk',
                            'kaynak' => ['SU-K1'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                            'azami' => 2, 'kota_grubu' => 'ikame-a'],
                        ['aciklama' => '2 adet kitap bölümü 1 makaleye denk',
                            'kaynak' => ['SU-B1'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                            'azami' => 2, 'kota_grubu' => 'ikame-a'],
                        ['aciklama' => 'Yüksek etki değerli konferans yayını 1 makale sayılır',
                            'kaynak' => ['SU-K2'], 'kaynak_adet' => 1, 'hedef_adet' => 1,
                            'azami' => 2, 'kota_grubu' => 'ikame-b'],
                    ],
                ],
                [
                    'tip' => 'adet',
                    'aciklama' => 'Bu makalelerin en az 3\'ü doktora tezinden üretilmemiş olmalı',
                    'maddeler' => ['SU-M1'], 'min_adet' => 3, 'haric' => ['doktora_tezinden'],
                ],
                [
                    'tip' => 'metrik',
                    'aciklama' => 'Lisans ve lisansüstü seviyede ders vermiş olmak',
                    'metrik' => 'ders_yariyil', 'min' => 1,
                ],
                [
                    'tip' => 'metrik',
                    'aciklama' => 'En az 1 yıl öğrenci desteği olan 2 TÜBİTAK/AB/ÜSİ projesinde yürütücülük',
                    'metrik' => 'proje_yurutuculuk', 'min' => 2,
                    'donusumler' => [
                        ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk',
                            'kaynak' => ['proje_arastirmaci'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                            'azami' => 2, 'kota_grubu' => null],
                        ['aciklama' => '4 projede danışmanlık 1 yürütücülüğe denk',
                            'kaynak' => ['proje_danisman'], 'kaynak_adet' => 4, 'hedef_adet' => 1,
                            'azami' => 2, 'kota_grubu' => null],
                        ['aciklama' => '1 AB Çerçeve/ERC projesi tüm proje koşulunu karşılar',
                            'kaynak' => ['proje_ab_erc'], 'kaynak_adet' => 1, 'hedef_adet' => 2,
                            'azami' => 2, 'kota_grubu' => null],
                    ],
                ],
                ['tip' => 'beyan', 'aciklama' => 'Projelerden en az biri tamamlanmış olmalı'],
                [
                    'tip' => 'metrik',
                    'aciklama' => 'Bitmiş en az 3 lisansüstü tezde baş danışmanlık',
                    'metrik' => 'tez_danismanlik', 'min' => 3,
                    'donusumler' => [
                        ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk',
                            'kaynak' => ['tez_es_danismanlik'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                            'azami' => 1, 'kota_grubu' => null],
                    ],
                ],
            ],
        ],
    ],

    [
        'anahtar' => 'sabanci-profesor-mdbf-cs',
        'universite' => 'Sabancı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => null,
        'birim' => 'MDBF — Bilgisayar Bilimleri ve Mühendisliği Programı',
        'cetvel' => null,
        'gecerlilik' => ['baslangic' => null, 'bitis' => null],
        'notlar' => 'EK-1 MDBF / PROFESÖR. Muafiyet: "Doçent unvanını 1.1.2016 tarihinden önce alan '
            .'öğretim üyeleri için, doktora tezi baş danışmanlığı şartı aranmaz."',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Profesör asgari şartları',
            'cocuklar' => [
                [
                    'tip' => 'adet',
                    'aciklama' => 'Q1/Q2 (veya SNIP ≥ 1.0) dergilerde en az 16 makale',
                    'maddeler' => ['SU-M1'], 'min_adet' => 16,
                    'donusumler' => [
                        ['aciklama' => '2 adet Q3/Q4 yayın 1 makaleye denk',
                            'kaynak' => ['SU-M2'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                            'azami' => 3, 'kota_grubu' => 'ikame-a'],
                        ['aciklama' => 'Yüksek etki değerli konferans yayını 1 makale sayılır',
                            'kaynak' => ['SU-K2'], 'kaynak_adet' => 1, 'hedef_adet' => 1,
                            'azami' => 3, 'kota_grubu' => 'ikame-b'],
                    ],
                ],
                ['tip' => 'adet', 'aciklama' => 'Bunların en az 8\'i doçentlik sonrası üretilmiş olmalı',
                    'maddeler' => ['SU-M1'], 'min_adet' => 8, 'donem' => $docentlikSonrasi],
                ['tip' => 'metrik', 'aciklama' => 'Lisans ve lisansüstü seviyede ders vermiş olmak',
                    'metrik' => 'ders_yariyil', 'min' => 1],
                [
                    'tip' => 'metrik',
                    'aciklama' => 'En az 4 TÜBİTAK/AB/ÜSİ projesinde yürütücülük',
                    'metrik' => 'proje_yurutuculuk', 'min' => 4,
                    'donusumler' => [
                        ['aciklama' => '1 AB Çerçeve Programı projesi 2 proje yerine sayılır',
                            'kaynak' => ['proje_ab'], 'kaynak_adet' => 1, 'hedef_adet' => 2,
                            'azami' => 4, 'kota_grubu' => null],
                        ['aciklama' => '2 projede araştırmacılık 1 yürütücülüğe denk',
                            'kaynak' => ['proje_arastirmaci'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                            'azami' => 4, 'kota_grubu' => null],
                    ],
                ],
                ['tip' => 'beyan', 'aciklama' => 'Projelerden en az üçü tamamlanmış olmalı'],
                [
                    'tip' => 'metrik', 'aciklama' => 'Bitmiş en az 5 lisansüstü tezde baş danışmanlık',
                    'metrik' => 'tez_danismanlik', 'min' => 5,
                    'donusumler' => [
                        ['aciklama' => '2 eş danışmanlık 1 baş danışmanlığa denk (doktoraya uygulanamaz)',
                            'kaynak' => ['tez_es_danismanlik'], 'kaynak_adet' => 2, 'hedef_adet' => 1,
                            'azami' => 2, 'kota_grubu' => null],
                    ],
                ],
                [
                    'tip' => 'metrik',
                    'aciklama' => 'Bunlardan en az 1\'i doktora tezi baş danışmanlığı olmalı',
                    'metrik' => 'doktora_tez_danismanlik', 'min' => 1,
                    // 1.1.2016 öncesi doçent olanlar için bu şart aranmaz.
                    'telafi' => [
                        'tip' => 'beyan',
                        'aciklama' => 'Doçent unvanı 1.1.2016 tarihinden önce alınmışsa bu şart aranmaz',
                    ],
                ],
            ],
        ],
    ],

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  4) BURSA ULUDAĞ ÜNİVERSİTESİ — ÜAK cetveline devir + [A]+[B]/[C] telafi
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Kaynak: pdf/1766060294419.bursa-uludag-kriter-18122025.pdf, Tablo-1/Tablo-2.
    | Yazılan dilim: Dr. Öğr. Üyesi (Sosyal + Fen), Doçent (Sosyal), Profesör.
    | Kod uzayı YÖK 2024 Mart Dönemi Doçentlik Başvuru Şartları'nın kendi maddeleri:
    |   1 uluslararası makale · 2a ulusal makale · 7a bilimsel araştırma projesi ...
    |   Bu yüzden 'cetvel' => 'uak-2024-mart' — cetvel üniversiteye değil ÜAK'a ait.
    |
    | ŞEMAYI ZORLADIĞI YER: tablo sütunları doğrudan ağaç düğümü ([A] ve [B] birer
    | çocuk, [C] sütunu [B]'nin `telafi`si); "en az 50 puanı şu maddelerden olmak
    | üzere toplam 90 puan" iki `puan` yaprağı; profesörlük şartı doçentlik
    | şartının `referans`la yeniden çağrılması; dil eşiği kademeli ve ileri
    | tarihli yürürlüğe sahip.
    */

    [
        'anahtar' => 'uludag-dr-sosyal',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'birim' => null,
        'cetvel' => 'uak-2024-mart',
        'gecerlilik' => ['baslangic' => '2024-03-01', 'bitis' => null],
        'notlar' => 'Tablo-1, Sosyal-Beşeri-İdari Bilimler. [A] sütunu asıl koşul, [C] sütunu '
            .'onun alternatifi: "[A] koşulunun sağlanamaması durumunda YÖK-2024 Mart Dönemi '
            .'Doçentlik Başvuru Şartlarına göre en az 50 puanı 1, 2a kapsamındaki dergilerden* '
            .'ve/veya 7a\'dan olmak üzere diğer faaliyetlerle birlikte en az 90 puan." '
            .'Dipnot *: "Aday bu kapsamdaki en az bir yayında birinci isim veya başlıca yazar olmalıdır."',
        'sart' => [
            'tip' => 'adet',
            'aciklama' => '[A] SCIE/SSCI Q1, Q2 veya Q3 dergilerde en az 1 makale (birinci isim veya başlıca yazar)',
            'maddeler' => ['1'],
            'min_adet' => 1,
            'yazar' => 'baslica',
            'telafi' => [
                'tip' => 've',
                'aciklama' => '[C] Sağlanamazsa puan yoluyla',
                'cocuklar' => [
                    ['tip' => 'puan', 'aciklama' => '1, 2a ve/veya 7a maddelerinden en az 50 puan',
                        'maddeler' => ['1', '2a', '7a'], 'min_puan' => 50],
                    ['tip' => 'puan', 'aciklama' => 'Diğer faaliyetlerle birlikte toplam en az 90 puan',
                        'maddeler' => ['*'], 'min_puan' => 90],
                ],
            ],
        ],
    ],

    [
        'anahtar' => 'uludag-dr-fen',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'birim' => null,
        'cetvel' => 'uak-2024-mart',
        'gecerlilik' => ['baslangic' => '2024-03-01', 'bitis' => null],
        'notlar' => 'Tablo-1: "YÖK-2024 Mart Dönemi Doçentlik Başvuru Şartlarına göre en az 50 '
            .'puanı SCIE/SSCI Q1 veya Q2 dergilerinden* veya 7a\'dan** olmak üzere diğer '
            .'faaliyetlerle birlikte en az 90 puan." Bu alanlarda [C] sütunu boş (---). '
            .'Dipnot ** : "Aday bu kapsamdaki en az bir projede yürütücü/koordinatör olmalıdır." '
            .'Yıldızlı koşullar hangi yoldan puan alındığına bağlı olduğu için `veya` altında.',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Dr. Öğr. Üyesi atanma koşulu',
            'cocuklar' => [
                ['tip' => 'puan', 'aciklama' => 'Q1/Q2 dergiler veya 7a projelerinden en az 50 puan',
                    'maddeler' => ['1', '7a'], 'min_puan' => 50],
                ['tip' => 'puan', 'aciklama' => 'Diğer faaliyetlerle birlikte toplam en az 90 puan',
                    'maddeler' => ['*'], 'min_puan' => 90],
                [
                    'tip' => 'veya',
                    'aciklama' => 'Kullanılan yola göre yazarlık/yürütücülük şartı',
                    'cocuklar' => [
                        ['tip' => 'adet', 'aciklama' => 'Q1/Q2 yayınlardan en az birinde birinci isim veya başlıca yazar',
                            'maddeler' => ['1'], 'min_adet' => 1, 'yazar' => 'baslica'],
                        ['tip' => 'metrik', 'aciklama' => '7a projelerinden en az birinde yürütücü/koordinatör',
                            'metrik' => 'proje_yurutuculuk', 'min' => 1],
                    ],
                ],
            ],
        ],
    ],

    [
        'anahtar' => 'uludag-docent-sosyal',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'birim' => null,
        'cetvel' => 'uak-2024-mart',
        'gecerlilik' => ['baslangic' => '2024-03-01', 'bitis' => null],
        'notlar' => 'Tablo-2, Sosyal-Beşeri-İdari Bilimler. Atanma koşulu sütunu birebir "[A] + [B]". '
            .'[C]: "[B] koşulunun sağlanamaması durumunda YÖK-2024 Mart Dönemi Doçentlik Başvuru '
            .'Şartlarına göre en az 60 puanı 1, 2a kapsamındaki dergilerden* ve/veya 7a\'dan '
            .'karşılanmak üzere diğer faaliyetlerle birlikte en az 90 puan."',
        'sart' => [
            'tip' => 've',
            'aciklama' => '[A] + [B]',
            'cocuklar' => [
                [
                    'tip' => 'puan',
                    'aciklama' => '[A] YÖK 2024 Mart Doçentlik Başvuru Şartlarına göre en az 100 puan',
                    'maddeler' => ['*'], 'min_puan' => 100,
                ],
                [
                    'tip' => 'veya',
                    'aciklama' => '[B] Q1-Q3 makale ya da 7a yürütücülüğü',
                    'cocuklar' => [
                        ['tip' => 'adet', 'aciklama' => 'SCIE/SSCI Q1, Q2 veya Q3 dergilerde en az 1 makale (birinci isim/başlıca yazar)',
                            'maddeler' => ['1'], 'min_adet' => 1, 'yazar' => 'baslica'],
                        ['tip' => 'metrik', 'aciklama' => '7a projelerinden en az 1 koordinatörlük-yürütücülük',
                            'metrik' => 'proje_yurutuculuk', 'min' => 1],
                    ],
                    'telafi' => [
                        'tip' => 've',
                        'aciklama' => '[C] [B] sağlanamazsa puan yoluyla',
                        'cocuklar' => [
                            ['tip' => 'puan', 'aciklama' => '1, 2a ve/veya 7a maddelerinden en az 60 puan',
                                'maddeler' => ['1', '2a', '7a'], 'min_puan' => 60],
                            ['tip' => 'puan', 'aciklama' => 'Diğer faaliyetlerle birlikte toplam en az 90 puan',
                                'maddeler' => ['*'], 'min_puan' => 90],
                        ],
                    ],
                ],
                [
                    'tip' => 'metrik',
                    'aciklama' => 'Yabancı dil sınavı asgari puanı (birimin öğretim diline göre)',
                    'metrik' => 'yds',
                    'kademeler' => [
                        'turkce' => 65,
                        'yabanci_dil_30' => 65,
                        'yabanci_dil_100' => 85,
                        'yabanci_dil_egitimi' => 90,
                    ],
                ],
            ],
        ],
    ],

    [
        'anahtar' => 'uludag-profesor',
        'universite' => 'Bursa Uludağ Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => null,
        'birim' => null,
        'cetvel' => 'uak-2024-mart',
        'gecerlilik' => ['baslangic' => '2024-03-01', 'bitis' => null],
        'notlar' => '(C)/2: "Profesörlüğe yükseltilme ve atanmada; ... (B) başlığında ve Tablo-2\'de '
            .'belirtilen Bursa Uludağ Üniversitesi doçentliğe atanma asgari koşullarını, '
            .'lisansüstü tezlerde yayın yapma şartı hariç olmak üzere, doçent unvanı alındıktan '
            .'sonra bir defa daha sağlaması gerekir."',
        'sart' => [
            'tip' => 'referans',
            'aciklama' => 'Doçentliğe atanma koşullarını doçentlik sonrası bir kez daha sağlamak',
            'esik' => 'uludag-docent-{alan}',
            'donem' => $docentlikSonrasi,
            'haric' => ['lisansustu_tez_yayini'],
        ],
    ],

    /*
    ╔══════════════════════════════════════════════════════════════════════════╗
    ║  EK) Şemanın yukarıdaki dörtlüde zorlanmayan iki düğümü
    ╚══════════════════════════════════════════════════════════════════════════╝
    | Dört arketip `k_ile` ve `min_oran`ı kullanmıyor. Bu ikisi korpusta sırasıyla
    | %10 ve %53 sıklıkta olduğu için şemada duruyor; kanıtsız alan kalmasın diye
    | birer gerçek örnekle burada karşılanıyor.
    */

    // ── k_ile: "dört şarttan toplamda ikisi" ──
    [
        'anahtar' => 'medeniyet-dr',
        'universite' => 'İstanbul Medeniyet Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => null,
        'birim' => null,
        'cetvel' => 'medeniyet-ek',
        'gecerlilik' => ['baslangic' => null, 'bitis' => null],
        'notlar' => 'Madde 8/1: "Aday, başvuruda bulunacağı bilim alanı ile ilgili aşağıdaki '
            .'\'akademik eser\' şartlarından toplamda ikisini sağlamış olmalıdır. ... Yeniden '
            .'atamalarda ilk atama şartı aranır." Madde 7/2: Türkçe programlarda en az 65.',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Dr. Öğr. Üyesi atanma şartları',
            'cocuklar' => [
                [
                    'tip' => 'k_ile',
                    'k' => 2,
                    'aciklama' => 'Aşağıdaki dört akademik eser şartından toplamda ikisi',
                    'cocuklar' => [
                        ['tip' => 'adet', 'aciklama' => '(a) SCI/SCIE/SSCI/AHCI dergide en az 1 özgün makale',
                            'maddeler' => ['1a'], 'min_adet' => 1],
                        ['tip' => 'adet', 'aciklama' => '(b) Uluslararası hakemli dergide en az 1 makale',
                            'maddeler' => ['1b'], 'min_adet' => 1],
                        ['tip' => 'adet', 'aciklama' => '(c) Tanınmış yayınevinden en az 1 kitap veya kitap bölümü',
                            'maddeler' => ['4a', '4c', '4d', '4f'], 'min_adet' => 1],
                        ['tip' => 'adet', 'aciklama' => '(d) ULAKBİM taranan ulusal hakemli dergide en az 1 tam makale',
                            'maddeler' => ['2a'], 'min_adet' => 1],
                    ],
                ],
                [
                    'tip' => 'metrik',
                    'aciklama' => 'Yabancı dil sınavı asgari puanı',
                    'metrik' => 'yds',
                    'kademeler' => ['turkce' => 65, 'yabanci_dil' => 65],
                ],
                ['tip' => 'beyan', 'aciklama' => 'Doktora/uzmanlık/sanatta yeterlik üzerinden en az 1 yıl geçmiş olmalı'],
            ],
        ],
    ],

    // ── min_oran + telafi_carpani: oransal dağılım ve "eksiğin iki katı" cezası ──
    [
        'anahtar' => 'trabzon-docent-itbf',
        'universite' => 'Trabzon Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => null,
        'birim' => 'İnsan ve Toplum Bilimleri Fakültesi',
        'cetvel' => 'trabzon-tablo2',
        'gecerlilik' => ['baslangic' => null, 'bitis' => null],
        'notlar' => 'Tablo 1: İnsan ve Toplum Bilimleri Fakültesi / tüm bölümler için doçentliğe '
            .'atanmada Tablo 2\'den 40 puan. Eşik temel alana değil FAKÜLTEYE bağlı. '
            .'"Öngörülen puanın en az yüzde 30\'u puanlandırma tablosundaki 1.1.1 - 1.3.4.1. arası '
            .'kodlu faaliyetlerden, en az yüzde 30\'u 2.1.1. - 2.4.4. arasında sıralanan '
            .'faaliyetlerden alınmalıdır. Geriye kalan yüzde 40\'lık puan tablodaki tüm '
            .'faaliyetlerden sağlanabilir. İkinci yüzde 30\'luk puanı 2.1.1. - 2.4.4. arasındaki '
            .'kodlarda sıralanan faaliyetlerden toplayamaması durumunda aday, her eksik puanın iki '
            .'katı fazla puanı puanlandırma tablosundaki 1.1.1 - 1.3.4.1. arası kodlu '
            .'faaliyetlerden sağlamalıdır."',
        'sart' => [
            'tip' => 've',
            'aciklama' => 'Doçent kadrosuna atanma koşulları',
            'cocuklar' => [
                [
                    'tip' => 'puan',
                    'aciklama' => 'Tablo 2\'den toplam en az 40 puan (doktora sonrası)',
                    'maddeler' => ['*'], 'min_puan' => 40, 'donem' => $doktoraSonrasi,
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'Toplam puanın en az %30\'u 1.1.1-1.3.4.1 kodlu faaliyetlerden',
                    'maddeler' => ['1.1.1..1.3.4.1'],
                    'min_oran' => 0.30,
                    'oran_payda' => ['*'],
                    'donem' => $doktoraSonrasi,
                ],
                [
                    'tip' => 'puan',
                    'aciklama' => 'Toplam puanın en az %30\'u 2.1.1-2.4.4 kodlu faaliyetlerden',
                    'maddeler' => ['2.1.1..2.4.4'],
                    'min_oran' => 0.30,
                    'oran_payda' => ['*'],
                    'donem' => $doktoraSonrasi,
                    // Eksik kalan her puanın İKİ KATI 1.1.1-1.3.4.1'den karşılanmalı.
                    'telafi' => [
                        'tip' => 'puan',
                        'aciklama' => 'Eksik kalan her puanın iki katı 1.1.1-1.3.4.1 kodlarından',
                        'maddeler' => ['1.1.1..1.3.4.1'],
                        'min_puan' => 0,          // taban yok; gereken miktar eksikten türetilir
                        'telafi_carpani' => 2,    // gereken = eksik_puan * 2
                        'donem' => $doktoraSonrasi,
                    ],
                ],
                [
                    'tip' => 'metrik',
                    'aciklama' => 'Yabancı dil sınavı asgari puanı',
                    'metrik' => 'yds',
                    'kademeler' => ['turkce' => 65, 'yabanci_dil' => 85],
                ],
                ['tip' => 'beyan', 'aciklama' => 'Doçentlik unvanına sahip olmak ve ÜAK sözlü sınavında başarılı olmak'],
            ],
        ],
    ],

];

/*
|--------------------------------------------------------------------------
| CETVEL TARAFI — ağaca girmeyen, puanlamaya ait kurallar
|--------------------------------------------------------------------------
|
| Çarpanlar, ek puanlar ve madde tavanları şart ağacının değil PUAN CETVELİNİN
| parçası: ağaç "kaç puan gerekli"yi, cetvel "bu faaliyet kaç puan"ı söyler.
| Bursa Uludağ bu ayrımı zorlayan örnek (Değerlendirmeye İlişkin Esaslar 22-28):
|
|   'carpanlar' => [
|       ['aciklama' => 'TÜBİTAK 1004 projeleri', 'maddeler' => ['7a'], 'carpan' => 1.5],
|       ['aciklama' => 'Yurtdışı üniversitelerden araştırmacılarla ortak faaliyet',
|        'kosul' => 'ortak_yurtdisi', 'carpan' => 1.5],
|       ['aciklama' => 'Yurtiçi diğer üniversitelerden araştırmacılarla ortak faaliyet',
|        'kosul' => 'ortak_yurtici', 'carpan' => 1.25],
|       ['aciklama' => 'Açık erişimdeki WoS Q1/Q2/Q3 makale', 'kosul' => 'acik_erisim',
|        'carpan' => 1.25],
|   ],
|   'carpan_kurali' => 'en_yuksek_bir_kez',   // md. 28
|   'carpan_kapsami' => ['dr_ogr_uyesi', 'docent:B', 'profesor:B'],  // md. 33
|
|   'ek_puanlar' => [
|       ['aciklama' => 'Yan dal veya ikinci doktora', 'puan' => 5],
|       ['aciklama' => 'Reddedilen kamu kurumu projesinde yürütücülük', 'puan' => 2, 'azami_adet' => 5],
|       ['aciklama' => 'Ulusal patent (ilave)', 'puan' => 5],
|       ['aciklama' => 'Uluslararası patent (ilave)', 'puan' => 10],
|       ['aciklama' => 'Patentin ticarileştirilmesi (ilave)', 'puan' => 10],
|   ],
|
|   'yazar_payi' => [   // Tıp Fakültesi Q1/Q2/Q3 yayınları, md. 35
|       'kapsam' => ['birim' => 'Tıp Fakültesi', 'maddeler' => ['1']],
|       'paylar' => ['1' => 0.8, '2-6' => 0.5, '7+' => 0.3],
|       'gecerlilik' => ['bitis' => '2025-12-31'],
|   ],
|
| Not: 'yazar_payi' cetvel düzeyinde tutulmalı çünkü aynı üniversitede birime ve
| tarihe göre değişebiliyor — Faaliyet.puan'ı sabit saklamak bu yüzden yanlış.
*/
