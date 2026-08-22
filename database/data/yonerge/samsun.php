<?php

/**
 * SAMSUN ÜNİVERSİTESİ — şart ağaçları.
 *
 * Kaynak: pdf/17537007522.samsununiverstesi.pdf · MADDE 5 + MADDE 10
 * Cetvel: database/data/cetvel/samsun-turler.php (puansız tür sözlüğü)
 *
 * ARKETİP: tamamen adet/tür tabanlı — yönergede puan tablosu YOK. Bu yüzden
 * hiçbir ağaçta `toplam` rolünde düğüm bulunmaz; arayüz barajı 0 gösterir.
 * Kadro şartları "a, b, c... şartlarından herhangi biri" biçiminde, her seçenek
 * kendi içinde iç içe adet kısıtı taşıyor ("en az 2 tanesi A1 olmak koşuluyla
 * toplamda en az 6 adet").
 *
 * Yazılan dilim: MADDE 10/2 — Sosyal ve Beşerî Bilimler alanları, dört kadro.
 * Fen/Mühendislik (10/3) ve Mimarlık (10/4) henüz girilmedi.
 *
 * KAPSAM DIŞI: Güzel Sanatlar ve Spor Bilimleri. Yönergede bu alanlara ait
 * madde bloğu YOKTUR — belgede kelimeler hiç geçmiyor. Uydurulmadı; o iki
 * alan Samsun listesinde görünmez.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · şema: sart-agaci-taslak.php
 */

use App\Services\Scoring\Sart\Kalip;

$alanlar = ['sosyal', 'filoloji', 'ilahiyat', 'hukuk', 'egitim'];

return [

    // ── Dr. Öğr. Üyesi · İLK ATANMA ──
    [
        'anahtar' => 'samsun-dr',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => 'samsun-turler',
        'notlar' => 'MADDE 10/2: "Doktor Öğretim Üyesi kadrosuna ilk kez atanmak üzere başvuran '
            .'adayların en az 2 tanesi A1/A2/A3 türü olmak koşuluyla en az 3 adet başlıca '
            .'çalışmaya sahip olmaları gerekir."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma', [
            Kalip::adet('İndeksli veya TR Dizin dergilerinde başlıca yazar olduğunuz en az 2 çalışma', ['A1-A3'], 2, madde: 'Tür A1/A2/A3'),
            Kalip::adet('Başlıca yazar olduğunuz toplam en az 3 çalışma', ['HEPSI'], 3),
        ]),
    ],

    // ── Dr. Öğr. Üyesi · YENİDEN ATANMA ──
    [
        'anahtar' => 'samsun-dr-yeniden',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'cetvel' => 'samsun-turler',
        'notlar' => 'MADDE 10/2: "...bir önceki atama tarihinden sonraki çalışmaları kapsamak '
            .'üzere aşağıdaki a, b, c şartlarından birini yerine getirmesi gerekir." '
            .'(b) şıkkı birebir şöyle: "En az 1 tanesi A1 veya A2 olmak kaydıyla A3/B1/B2/B3/C1 '
            .'türü en az 4 adet başlıca çalışma sahibi olmak." — A1/A2 sayılan kümede yer '
            .'almadığı için cümle kendi içinde tutarsız; burada 4 adedin A1-A2 dâhil birleşik '
            .'kümeden sayıldığı yorumu uygulandı.',
        'sart' => Kalip::veya('Aşağıdaki üç yoldan birini sağlamalısınız (son atamanızdan sonraki çalışmalarla)', [
            Kalip::adet('1. yol: İndeksli dergilerde başlıca yazar olduğunuz 2 çalışma', ['A1-A2'], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür A1/A2'),
            Kalip::ve('2. yol: En az 1\'i indeksli dergide olmak üzere 4 çalışma', [
                Kalip::adet('Bunlardan en az 1 tanesi indeksli dergide makale', ['A1-A2'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür A1/A2'),
                Kalip::adet('Makale, kitap veya tam metin bildiriden toplam en az 4 çalışma', ['A1', 'A2', 'A3', 'B1', 'B2', 'B3', 'C1'], 4, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür A1-A3, B1-B3, C1'),
            ]),
            Kalip::adet('3. yol: AB, TÜBİTAK ARDEB veya TÜSEB projesinde 1 çalışma', ['D1-D3-D5'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür D1/D3/D5'),
        ]),
    ],

    // ── Doçent ──
    [
        'anahtar' => 'samsun-docent',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => 'samsun-turler',
        'notlar' => 'MADDE 10/2: "Doçent kadrosuna atama yapılırken adayların aşağıda belirtilen '
            .'a, b, c, d, e şartlarından herhangi birini karşılamaları gerekir."',
        'sart' => Kalip::veya('Aşağıdaki beş yoldan herhangi birini sağlamalısınız', [
            Kalip::adet('1. yol: SCIE/SSCI veya AHCI dergilerinde en az 4 makale', ['A1'], 4, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür A1'),
            Kalip::ve('2. yol: En az 2\'si SCIE/SSCI-AHCI olmak üzere toplam 6 çalışma', [
                Kalip::adet('Bunların en az 2\'si SCIE/SSCI veya AHCI dergisinde makale', ['A1'], 2, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür A1'),
                Kalip::adet('Toplamda en az 6', ['HEPSI'], 6, donem: Kalip::DOKTORA_SONRASI),
            ]),
            Kalip::ve('3. yol: En az 4\'ü indeksli dergide olmak üzere toplam 8 çalışma', [
                Kalip::adet('Bunların en az 4\'ü indeksli dergide makale', ['A1-A2'], 4, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür A1/A2'),
                Kalip::adet('Toplamda en az 8', ['HEPSI'], 8, donem: Kalip::DOKTORA_SONRASI),
            ]),
            Kalip::ve('4. yol: En az 6\'sı makale/kitap/proje olmak üzere toplam 10 çalışma', [
                Kalip::adet('Bunların en az 6\'sı makale, kitap ya da desteklenmiş proje olmalı',
                    ['A1', 'A2', 'A3', 'A4', 'B1', 'B3', 'D1', 'D3', 'D5'], 6, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür A1-A4, B1, B3, D1/D3/D5'),
                Kalip::adet('Toplamda en az 10', ['HEPSI'], 10, donem: Kalip::DOKTORA_SONRASI),
            ]),
            Kalip::ve('5. yol: AB, TÜBİTAK ARDEB veya TÜSEB projesinden 2 çalışma', [
                Kalip::adet('Desteklenmiş projelerden en az 2 çalışma', ['D1-D3-D5'], 2, madde: 'Tür D1/D3/D5'),
                Kalip::adet('Bunlardan en az 1\'i doçentliğinizden sonra olmalı', ['D1-D3-D5'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür D1/D3/D5'),
            ]),
        ]),
    ],

    // ── Profesör ──
    [
        'anahtar' => 'samsun-profesor',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => 'samsun-turler',
        'notlar' => 'MADDE 10/2: "Profesör kadrosuna atama yapılırken adaylarda doçentlik sonrası '
            .'en az 4 yarıyıl bir yükseköğretim kurumunda ders vermiş olma şartı aranır. Bunun '
            .'yanı sıra adayların aşağıda belirtilen a, b, c, d, e şartlarından herhangi birini '
            .'karşılamaları gerekir."',
        'sart' => Kalip::ve('Profesör asgari şartları', [
            Kalip::metrik('Doçentlik sonrası en az 4 yarıyıl ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOCENTLIK_SONRASI),
            Kalip::veya('Aşağıdaki beş yoldan herhangi birini sağlamalısınız', [
                Kalip::adet('1. yol: SCIE/SSCI veya AHCI dergilerinde en az 4 makale', ['A1'], 4, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür A1'),
                Kalip::ve('2. yol: En az 2\'si SCIE/SSCI-AHCI olmak üzere toplam 6 çalışma', [
                    Kalip::adet('Bunların en az 2\'si SCIE/SSCI veya AHCI dergisinde makale', ['A1'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür A1'),
                    Kalip::adet('Toplamda en az 6', ['HEPSI'], 6, donem: Kalip::DOCENTLIK_SONRASI),
                ]),
                Kalip::ve('3. yol: En az 4\'ü indeksli dergide olmak üzere toplam 8 çalışma', [
                    Kalip::adet('Bunların en az 4\'ü indeksli dergide makale', ['A1-A2'], 4, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür A1/A2'),
                    Kalip::adet('Toplamda en az 8', ['HEPSI'], 8, donem: Kalip::DOCENTLIK_SONRASI),
                ]),
                Kalip::ve('4. yol: En az 6\'sı makale/kitap/proje olmak üzere toplam 10 çalışma', [
                    Kalip::adet('Bunların en az 6\'sı makale, kitap ya da desteklenmiş proje olmalı',
                        ['A1', 'A2', 'A3', 'A4', 'B1', 'B3', 'D1', 'D3', 'D5'], 6, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür A1-A4, B1, B3, D1/D3/D5'),
                    Kalip::adet('Toplamda en az 10', ['HEPSI'], 10, donem: Kalip::DOCENTLIK_SONRASI),
                ]),
                Kalip::adet('5. yol: AB, TÜBİTAK ARDEB veya TÜSEB projesinden en az 2 çalışma', ['D1-D3-D5'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür D1/D3/D5'),
            ]),
        ]),
    ],

    // ══════════ (3) FEN ve MÜHENDİSLİK ══════════

    [
        'anahtar' => 'samsun-dr-fen',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(3) Fen ve Mühendislik. "…en az 1 adet A1 türü başlıca çalışmak '
            .'koşuluyla en az 3 adet başlıca çalışmaya sahip olmaları gerekir."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma', [
            Kalip::adet('SCIE/SSCI veya AHCI dergisinde başlıca yazar olduğunuz en az 1 çalışma', ['A1'], 1, madde: 'Tür A1'),
            Kalip::adet('Başlıca yazar olduğunuz toplam en az 3 çalışma', ['HEPSI'], 3),
        ]),
    ],
    [
        'anahtar' => 'samsun-dr-yeniden-fen',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(3), yeniden atama a/b/c şıkları. a ve b şıkkında "Bunların en az 1 '
            .'tanesinde, aday ilk yazar olmalıdır." koşulu var.',
        'sart' => Kalip::veya('Aşağıdaki üç yoldan birini sağlamalısınız (son atamanızdan sonraki çalışmalarla)', [
            Kalip::ve('1. yol: İndeksli veya TR Dizin dergilerinde 2 çalışma', [
                Kalip::adet('Başlıca yazar olduğunuz en az 2 çalışma', ['A1-A3'], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür A1/A2/A3'),
                Kalip::adet('Bunların en az 1\'inde ilk yazar olmalısınız', ['A1-A3'], 1, 'ilk', donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür A1/A2/A3'),
            ]),
            Kalip::ve('2. yol: En az 1\'i indeksli olmak üzere 3 çalışma', [
                Kalip::adet('Bunlardan en az 1 tanesi indeksli veya TR Dizin dergisinde', ['A1-A3'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür A1/A2/A3'),
                Kalip::adet('Başlıca yazar olduğunuz toplam en az 3 çalışma', ['HEPSI'], 3, donem: Kalip::SON_ATAMA_SONRASI),
                Kalip::adet('Bunların en az 1\'inde ilk yazar olmalısınız', ['HEPSI'], 1, 'ilk', donem: Kalip::SON_ATAMA_SONRASI),
            ]),
            Kalip::adet('3. yol: Desteklenmiş bir araştırma projesinde 1 çalışma', ['D1-D3-D4-D5'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür D1/D3/D4/D5'),
        ]),
    ],
    [
        'anahtar' => 'samsun-docent-fen',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(3), Doçent a veya b. a) "…en az 4 tanesi A1 türü başlıca çalışma '
            .'(bunların en az 1 tanesinde aday birinci yazar olmalı) olmak koşuluyla toplamda en az '
            .'8 adet başlıca çalışma." b) "En az 1 tanesi doktora sonrası olmak şartıyla D1/D3/D4/D5 '
            .'türü en az 2 adet başlıca çalışma."',
        'sart' => Kalip::veya('Aşağıdaki iki yoldan birini sağlamalısınız', [
            Kalip::ve('1. yol: En az 4\'ü SCIE/SSCI-AHCI olmak üzere toplam 8 çalışma', [
                Kalip::adet('SCIE/SSCI veya AHCI dergilerinde en az 4 çalışma', ['A1'], 4, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür A1'),
                Kalip::adet('Bunların en az 1\'inde birinci yazar olmalısınız', ['A1'], 1, 'ilk', donem: Kalip::DOKTORA_SONRASI, madde: 'Tür A1'),
                Kalip::adet('Başlıca yazar olduğunuz toplam en az 8 çalışma', ['HEPSI'], 8, donem: Kalip::DOKTORA_SONRASI),
            ]),
            Kalip::ve('2. yol: Desteklenmiş projelerden 2 çalışma', [
                Kalip::adet('Desteklenmiş projelerden en az 2 çalışma', ['D1-D3-D4-D5'], 2, madde: 'Tür D1/D3/D4/D5'),
                Kalip::adet('Bunlardan en az 1\'i doktoranızdan sonra olmalı', ['D1-D3-D4-D5'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür D1/D3/D4/D5'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'samsun-profesor-fen',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'muhendislik', 'ziraat'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(3), Profesör. Ders şartı: "doçentlik sonrası en az 4 yarıyıl bir '
            .'yükseköğretim kurumunda ders vermiş olma." Ardından a veya b.',
        'sart' => Kalip::ve('Profesör asgari şartları', [
            Kalip::metrik('Doçentlik sonrası en az 4 yarıyıl ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOCENTLIK_SONRASI),
            Kalip::veya('Aşağıdaki iki yoldan birini sağlamalısınız', [
                Kalip::ve('1. yol: En az 4\'ü SCIE/SSCI-AHCI olmak üzere toplam 8 çalışma', [
                    Kalip::adet('SCIE/SSCI veya AHCI dergilerinde en az 4 çalışma', ['A1'], 4, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür A1'),
                    Kalip::adet('Bunların en az 1\'inde birinci yazar olmalısınız', ['A1'], 1, 'ilk', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür A1'),
                    Kalip::adet('Başlıca yazar olduğunuz toplam en az 8 çalışma', ['HEPSI'], 8, donem: Kalip::DOCENTLIK_SONRASI),
                ]),
                Kalip::ve('2. yol: Desteklenmiş projelerden 2 çalışma', [
                    Kalip::adet('Desteklenmiş projelerden en az 2 çalışma', ['D1-D3-D4-D5'], 2, madde: 'Tür D1/D3/D4/D5'),
                    Kalip::adet('Bunlardan en az 1\'i doçentliğinizden sonra olmalı', ['D1-D3-D4-D5'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür D1/D3/D4/D5'),
                ]),
            ]),
        ]),
    ],

    // ══════════ (4) MİMARLIK, PLANLAMA ve TASARIM ══════════

    [
        'anahtar' => 'samsun-dr-mimarlik',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(4). "…en az 1 tane A türü olmak koşuluyla en az 3 adet başlıca çalışma."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi ilk atanma', [
            Kalip::adet('Makale türünde en az 1 çalışma', ['A'], 1, madde: 'Tür A'),
            Kalip::adet('Başlıca yazar olduğunuz toplam en az 3 çalışma', ['HEPSI'], 3),
        ]),
    ],
    [
        'anahtar' => 'samsun-dr-yeniden-mimarlik',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => ['mimarlik'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(4), yeniden atama: "en az 2 tanesi A1/A2/A3/A4/B1/B2/B3/B4/D1/D3/D5/'
            .'E1/E2/E4/G1/G2/G3/G4/G5 türü olmak koşuluyla en az 4 adet başlıca çalışma. (Bunların en '
            .'az 1 tanesinde, aday ilk yazar olmalıdır.)" PROJEKSİYON: G4 ve G5 cetvelde tanımlı değil.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi yeniden atanma', [
            Kalip::adet('Makale, kitap, proje veya patent türünde en az 2 çalışma', ['MIMARLIK-YENIDEN'], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür A1-A4, B1-B4, D, E, G'),
            Kalip::adet('Başlıca yazar olduğunuz toplam en az 4 çalışma', ['HEPSI'], 4, donem: Kalip::SON_ATAMA_SONRASI),
            Kalip::adet('Bunların en az 1\'inde ilk yazar olmalısınız', ['HEPSI'], 1, 'ilk', donem: Kalip::SON_ATAMA_SONRASI),
        ]),
    ],
    [
        'anahtar' => 'samsun-docent-mimarlik',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(4), Doçent a veya b. a) "…en az 4 tanesi A1/A2/A3/A4 türü olmak '
            .'koşuluyla toplamda en az 10 adet başlıca çalışma." b) "En az 1 tanesi doktora sonrası '
            .'olmak şartıyla D1/D3/D4 türü en az 2 adet başlıca çalışma."',
        'sart' => Kalip::veya('Aşağıdaki iki yoldan birini sağlamalısınız', [
            Kalip::ve('1. yol: En az 4\'ü makale olmak üzere toplam 10 çalışma', [
                Kalip::adet('Makale türünde en az 4 çalışma', ['A1-A4'], 4, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür A1-A4'),
                Kalip::adet('Başlıca yazar olduğunuz toplam en az 10 çalışma', ['HEPSI'], 10, donem: Kalip::DOKTORA_SONRASI),
            ]),
            Kalip::ve('2. yol: Desteklenmiş projelerden 2 çalışma', [
                Kalip::adet('Desteklenmiş projelerden en az 2 çalışma', ['D1-D3-D4'], 2, madde: 'Tür D1/D3/D4'),
                Kalip::adet('Bunlardan en az 1\'i doktoranızdan sonra olmalı', ['D1-D3-D4'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür D1/D3/D4'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'samsun-profesor-mimarlik',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(4), Profesör. Ders şartı + a veya b.',
        'sart' => Kalip::ve('Profesör asgari şartları', [
            Kalip::metrik('Doçentlik sonrası en az 4 yarıyıl ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOCENTLIK_SONRASI),
            Kalip::veya('Aşağıdaki iki yoldan birini sağlamalısınız', [
                Kalip::ve('1. yol: En az 4\'ü makale olmak üzere toplam 10 çalışma', [
                    Kalip::adet('Makale türünde en az 4 çalışma', ['A1-A4'], 4, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür A1-A4'),
                    Kalip::adet('Başlıca yazar olduğunuz toplam en az 10 çalışma', ['HEPSI'], 10, donem: Kalip::DOCENTLIK_SONRASI),
                ]),
                Kalip::ve('2. yol: Desteklenmiş projelerden 2 çalışma', [
                    Kalip::adet('Desteklenmiş projelerden en az 2 çalışma', ['D1-D3-D4'], 2, madde: 'Tür D1/D3/D4'),
                    Kalip::adet('Bunlardan en az 1\'i doçentliğinizden sonra olmalı', ['D1-D3-D4'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür D1/D3/D4'),
                ]),
            ]),
        ]),
    ],

    // ══════════ (5) SAĞLIK BİLİMLERİ ══════════

    [
        'anahtar' => 'samsun-dr-saglik',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['saglik'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(5). a) "En az 1 tanesi A1 türü olmak koşuluyla en az 3 adet başlıca '
            .'çalışma." b) "En az 2 tanesi A2/A3 türü olmak koşuluyla en az 4 adet başlıca çalışma."',
        'sart' => Kalip::veya('Aşağıdaki iki yoldan birini sağlamalısınız', [
            Kalip::ve('1. yol: 1 SCIE/SSCI-AHCI + toplam 3 çalışma', [
                Kalip::adet('SCIE/SSCI veya AHCI dergisinde en az 1 çalışma', ['A1'], 1, madde: 'Tür A1'),
                Kalip::adet('Başlıca yazar olduğunuz toplam en az 3 çalışma', ['HEPSI'], 3),
            ]),
            Kalip::ve('2. yol: 2 ESCI/Scopus-TR Dizin + toplam 4 çalışma', [
                Kalip::adet('ESCI/Scopus veya TR Dizin dergilerinde en az 2 çalışma', ['A2', 'A3'], 2, madde: 'Tür A2/A3'),
                Kalip::adet('Başlıca yazar olduğunuz toplam en az 4 çalışma', ['HEPSI'], 4),
            ]),
        ]),
    ],
    [
        'anahtar' => 'samsun-dr-yeniden-saglik',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => ['saglik'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(5), yeniden atama: ilk atanmayla AYNI a/b şartları, yalnız bir önceki '
            .'atama tarihinden sonraki çalışmalar sayılıyor.',
        'sart' => Kalip::veya('Aşağıdaki iki yoldan birini sağlamalısınız (son atamanızdan sonraki çalışmalarla)', [
            Kalip::ve('1. yol: 1 SCIE/SSCI-AHCI + toplam 3 çalışma', [
                Kalip::adet('SCIE/SSCI veya AHCI dergisinde en az 1 çalışma', ['A1'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür A1'),
                Kalip::adet('Başlıca yazar olduğunuz toplam en az 3 çalışma', ['HEPSI'], 3, donem: Kalip::SON_ATAMA_SONRASI),
            ]),
            Kalip::ve('2. yol: 2 ESCI/Scopus-TR Dizin + toplam 4 çalışma', [
                Kalip::adet('ESCI/Scopus veya TR Dizin dergilerinde en az 2 çalışma', ['A2', 'A3'], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Tür A2/A3'),
                Kalip::adet('Başlıca yazar olduğunuz toplam en az 4 çalışma', ['HEPSI'], 4, donem: Kalip::SON_ATAMA_SONRASI),
            ]),
        ]),
    ],
    [
        'anahtar' => 'samsun-docent-saglik',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['saglik'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(5), Doçent a veya b. a) "Doktora/tıpta uzmanlık sonrası … en az 4 '
            .'tanesi A1 türü (bunların en az 1 tanesinde aday birinci yazar olmalı) … toplamda en az '
            .'8 adet başlıca çalışma."',
        'sart' => Kalip::veya('Aşağıdaki iki yoldan birini sağlamalısınız', [
            Kalip::ve('1. yol: En az 4\'ü SCIE/SSCI-AHCI olmak üzere toplam 8 çalışma', [
                Kalip::adet('SCIE/SSCI veya AHCI dergilerinde en az 4 çalışma', ['A1'], 4, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür A1'),
                Kalip::adet('Bunların en az 1\'inde birinci yazar olmalısınız', ['A1'], 1, 'ilk', donem: Kalip::DOKTORA_SONRASI, madde: 'Tür A1'),
                Kalip::adet('Başlıca yazar olduğunuz toplam en az 8 çalışma', ['HEPSI'], 8, donem: Kalip::DOKTORA_SONRASI),
            ]),
            Kalip::ve('2. yol: Desteklenmiş projelerden 2 çalışma', [
                Kalip::adet('Desteklenmiş projelerden en az 2 çalışma', ['D1-D3-D4-D5'], 2, madde: 'Tür D1/D3/D4/D5'),
                Kalip::adet('Bunlardan en az 1\'i doktoranızdan sonra olmalı', ['D1-D3-D4-D5'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Tür D1/D3/D4/D5'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'samsun-profesor-saglik',
        'aday_notu' => 'Bu yönergede puan barajı yok; şartlar çalışma sayısıyla tanımlı. Listelenen yollardan yalnızca birini sağlamanız yeterli.',
        'universite' => 'Samsun Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['saglik'],
        'cetvel' => 'samsun-turler',
        'notlar' => 'Madde 10/(5), Profesör. Ders şartı + a veya b.',
        'sart' => Kalip::ve('Profesör asgari şartları', [
            Kalip::metrik('Doçentlik sonrası en az 4 yarıyıl ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOCENTLIK_SONRASI),
            Kalip::veya('Aşağıdaki iki yoldan birini sağlamalısınız', [
                Kalip::ve('1. yol: En az 4\'ü SCIE/SSCI-AHCI olmak üzere toplam 8 çalışma', [
                    Kalip::adet('SCIE/SSCI veya AHCI dergilerinde en az 4 çalışma', ['A1'], 4, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür A1'),
                    Kalip::adet('Bunların en az 1\'inde birinci yazar olmalısınız', ['A1'], 1, 'ilk', donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür A1'),
                    Kalip::adet('Başlıca yazar olduğunuz toplam en az 8 çalışma', ['HEPSI'], 8, donem: Kalip::DOCENTLIK_SONRASI),
                ]),
                Kalip::ve('2. yol: Desteklenmiş projelerden 2 çalışma', [
                    Kalip::adet('Desteklenmiş projelerden en az 2 çalışma', ['D1-D3-D4-D5'], 2, madde: 'Tür D1/D3/D4/D5'),
                    Kalip::adet('Bunlardan en az 1\'i doçentliğinizden sonra olmalı', ['D1-D3-D4-D5'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Tür D1/D3/D4/D5'),
                ]),
            ]),
        ]),
    ],
];
