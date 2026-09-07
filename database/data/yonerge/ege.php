<?php

/**
 * EGE ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Kriterleri
 * Kaynak: pdf/1768554344259.ege-kriter-16012026.pdf (01.01.2026'dan itibaren)
 *
 * Yönerge alanları ALTI GRUBA ayırıyor ve her grubun yayın koşulu farklı:
 *
 *   Fen, Mühendislik, Sağlık   1(a)'dan yayın; çeyreklik şartı Q1/Q2
 *   Sosyal Bilimler            1(a,b,c,d) + 3(a1,a2,b1); çeyreklik şartı yok
 *   İlahiyat, Hukuk            aynı küme + kitap kalemleri geniş
 *   Spor Bilimleri             1(a)'dan; çeyreklik şartı Q1/Q2/Q3
 *   Güzel Sanatlar, Mimarlık   1(a,b,d,e,g1,g2) + 3(a1,b1,d,e) + 10.4(k,l)
 *
 * EĞİTİM, FİLOLOJİ ve ZİRAAT alanları yönergede HİÇ ANILMIYOR. Bu alanlarda
 * eşik girilmedi: hangi gruba tabi olduklarını yönerge söylemiyor, tahmin
 * etmek adayı yanlış kriterle ölçmek olurdu.
 *
 * YURT DIŞI KOŞULU TELAFİLİ: "Gereken en az puanın %50 fazlasının sağlanması
 * durumunda yurt dışında bulunma koşulu aranmaz." Motorun `telafi` dalı tam
 * bunun için: koşul sağlanmazsa alternatif puan barajı denenir.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ege-2026.php
 */

use App\Services\Scoring\Sart\Kalip;

/** Yönergenin adlandırdığı alan grupları. */
$fenMuhSaglik = ['fen', 'muhendislik', 'saglik'];
$ilahiyatHukuk = ['ilahiyat', 'hukuk'];
$sanatMimarlik = ['guzel_sanatlar', 'mimarlik'];

/**
 * Yurt dışı deneyimi koşulu ve puanla telafisi.
 *
 * @return array<string, mixed>
 */
$yurtDisi = fn (int $ay, int $telafiPuani): array => Kalip::metrik(
    "Lisans sonrası en az {$ay} ay yurt dışı eğitim/araştırma çalışması", 'yurtdisi_ay', $ay,
) + ['telafi' => Kalip::toplam($telafiPuani, null, ['*'], 'Tüm')];

/**
 * "N yayını olmak, en az M'sinde başlıca yazar olmak" ikilisi.
 *
 * Yönerge sayıyı ve başlıca yazarlığı AYRI cümlelerde, çoğu zaman farklı
 * madde kümeleri üzerinden istiyor: sayı geniş kümeden, başlıca yazarlık
 * dar kümeden. Bu yüzden iki ayrı düğüm.
 *
 * @param  list<string>  $sayiKumesi
 * @param  list<string>  $baslicaKumesi
 * @param  array<string, mixed>|null  $donem
 * @return list<array<string, mixed>>
 */
$yayinKosulu = function (
    int $sayi,
    array $sayiKumesi,
    int $baslica,
    array $baslicaKumesi,
    ?array $donem = null,
    string $sayiMetni = 'yayın',
): array {
    return [
        Kalip::adet("Belirtilen kalemlerden en az {$sayi} {$sayiMetni}", array_values($sayiKumesi), $sayi, donem: $donem),
        Kalip::adet("Bunların en az {$baslica}'inde başlıca yazar olmalısınız", array_values($baslicaKumesi), $baslica, 'baslica', donem: $donem),
    ];
};

return [
    // ══════════════════ MADDE 12 · DR. ÖĞRETİM ÜYESİ (ilk atanma) ══════════════════
    //
    // Ortak: deneme dersi, 2 ay yurt dışı (225 puanla telafi), 1 projede görev,
    // en az 150 puan. Değişen: yayın sayısı ve hangi kalemlerden sayıldığı.
    [
        'anahtar' => 'ege-dr-fen-muh-saglik',
        'aday_notu' => 'Yurt dışı koşulu zorunlu değil: 225 puana ulaşırsanız aranmıyor. Dört yayının tamamı SCIE/SSCI/AHCI dergilerinden olmalı.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $fenMuhSaglik,
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 12.5) "Sağlık Bilimleri, Mühendislik ve Fen Bilimleri alanlarında, birinde başlıca yazar olmak koşulu ile 1 (a) maddesinden dört yayını olmak." Madde 12.10) en az 150 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen / Mühendislik / Sağlık', [
            ...$yayinKosulu(4, ['1a'], 1, ['1a'], sayiMetni: 'SCIE/SSCI/AHCI makalesi'),
            Kalip::adet('En az 1 araştırma projesinde bursiyer, araştırmacı veya yürütücü olarak görev almak', ['PROJE'], 1),
            $yurtDisi(2, 225),
            Kalip::beyan('Birim yönetim kurulunun belirlediği jüri önünde deneme dersi vermek ve başarılı olmak', 'Madde 12.1'),
            Kalip::toplam(150),
        ]),
    ],
    [
        'anahtar' => 'ege-dr-sosyal',
        'aday_notu' => 'Sosyal Bilimlerde çeyreklik şartı yok: dört yayın makale ile kitap kalemlerinden birlikte sayılabiliyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal'],
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 12.6) "Sosyal Bilimler alanında 1 (a), 3 (a1, a2, b1) maddelerinden birinde başlıca yazar olmak koşulu ile 1 (a, b, c, d), 3 (a1, a2, b1) maddelerinden dört yayını olmak."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal Bilimler', [
            ...$yayinKosulu(4, ['1-abcd', '3-a1a2b1'], 1, ['1a', '3-a1a2b1']),
            Kalip::adet('En az 1 araştırma projesinde bursiyer, araştırmacı veya yürütücü olarak görev almak', ['PROJE'], 1),
            $yurtDisi(2, 225),
            Kalip::beyan('Birim yönetim kurulunun belirlediği jüri önünde deneme dersi vermek ve başarılı olmak', 'Madde 12.1'),
            Kalip::toplam(150),
        ]),
    ],
    [
        'anahtar' => 'ege-dr-ilahiyat-hukuk',
        'aday_notu' => 'İlahiyat ve Hukukta kitap kalemleri yayın sayısına dâhil ediliyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $ilahiyatHukuk,
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 12.7) "İlahiyat ve Hukuk alanlarında 1 (a), 3 (a1, a2, b1, b2, d) maddelerinden en az birinde başlıca yazar olmak koşulu ile … dört yayını olmak."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — İlahiyat / Hukuk', [
            ...$yayinKosulu(4, ['1-abcd', '3-ilahiyat'], 1, ['1a', '3-ilahiyat']),
            Kalip::adet('En az 1 araştırma projesinde bursiyer, araştırmacı veya yürütücü olarak görev almak', ['PROJE'], 1),
            $yurtDisi(2, 225),
            Kalip::beyan('Birim yönetim kurulunun belirlediği jüri önünde deneme dersi vermek ve başarılı olmak', 'Madde 12.1'),
            Kalip::toplam(150),
        ]),
    ],
    [
        'anahtar' => 'ege-dr-spor',
        'aday_notu' => 'Spor Bilimlerinde yayın sayısı diğer alanlardan bir eksik (üç).',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['spor'],
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 12.8) "Spor Bilimleri alanında 1 (a) maddesinden birinde başlıca yazar olmak koşulu ile üç yayını olmak."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Spor Bilimleri', [
            ...$yayinKosulu(3, ['1a'], 1, ['1a'], sayiMetni: 'SCIE/SSCI/AHCI makalesi'),
            Kalip::adet('En az 1 araştırma projesinde bursiyer, araştırmacı veya yürütücü olarak görev almak', ['PROJE'], 1),
            $yurtDisi(2, 225),
            Kalip::beyan('Birim yönetim kurulunun belirlediği jüri önünde deneme dersi vermek ve başarılı olmak', 'Madde 12.1'),
            Kalip::toplam(150),
        ]),
    ],
    [
        'anahtar' => 'ege-dr-sanat-mimarlik',
        'aday_notu' => 'Güzel Sanatlar ve Mimarlıkta sanatsal/tasarım kalemleri de yayın sayısına giriyor; yayımlanmış müzik ya da dans metodu da sayılıyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $sanatMimarlik,
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 12.9) "Güzel Sanatlar, Mimarlık, Planlama ve Tasarım alanlarında 1 (a, b, d, e, g1, g2), 3 (a1, b1, d, e), 10.4 (k, l) maddelerinden birinde başlıca yazar olmak koşulu ile dört yayını olmak."',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Güzel Sanatlar / Mimarlık', [
            ...$yayinKosulu(4, ['1-abcd', '3-a1a2b1', '10.4-kl'], 1, ['1a', '3-a1a2b1', '10.4-kl']),
            Kalip::adet('En az 1 araştırma projesinde bursiyer, araştırmacı veya yürütücü olarak görev almak', ['PROJE'], 1),
            $yurtDisi(2, 225),
            Kalip::beyan('Birim yönetim kurulunun belirlediği jüri önünde deneme dersi vermek ve başarılı olmak', 'Madde 12.1'),
            Kalip::toplam(150),
        ]),
    ],

    // ══════════════════ MADDE 11 · DOÇENT ══════════════════
    //
    // Doktora/uzmanlık tezinden üretilmiş yayınlar bu koşullara SAYILMAZ.
    [
        'anahtar' => 'ege-docent-fen-muh-saglik',
        'aday_notu' => 'Beş yayının en az birinde Q1 veya Q2 dergide başlıca yazar olmalısınız. Yurt dışı koşulu 450 puana ulaşınca aranmıyor. Tezden üretilmiş yayınlar bu sayıya girmez.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $fenMuhSaglik,
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 11.8) "Sağlık Bilimleri, Mühendislik ve Fen Bilimleri alanlarında 1 (a) maddesinden Q1 veya Q2 kategorisinden en az birinde başlıca yazar olmak koşulu ile beş yayını olmak." Madde 11.13) en az 300 puan.',
        'sart' => Kalip::ve('Doçent — Fen / Mühendislik / Sağlık', [
            Kalip::adet('SCIE/SSCI/AHCI dergilerde en az 5 yayın', ['1a'], 5) + ['haric' => ['lisansustu_tezden']],
            Kalip::adet('En az 1 Q1 veya Q2 dergide başlıca yazar olmalısınız', ['1a-Q1Q2'], 1, 'baslica'),
            Kalip::adet('Dış kaynaklı en az 1 araştırma projesini yürütücü/araştırmacı olarak tamamlamış olmak', ['5a1', '5a3', '5b1', '5b2'], 1),
            Kalip::veya('En az 1 tez yönetmiş olmak ya da ilave bir araştırma projesi yürütmek', [
                Kalip::metrik('Bitmiş en az 1 lisansüstü tez danışmanlığı', 'tez_danismanlik', 1),
                Kalip::adet('İlave bir araştırma projesinde yürütücülük', ['PROJE_YURUTUCU'], 1),
            ]),
            Kalip::metrik('En az 2 yarıyıl ders vermiş olmak', 'ders_yariyil', 2),
            $yurtDisi(4, 450),
            Kalip::beyan('Doktora sonrası en az 2 yılı yükseköğretim kurumlarında olmak üzere alanında 4 yıl çalışmış olmak', 'Madde 11.1'),
            Kalip::toplam(300),
        ]),
    ],
    [
        'anahtar' => 'ege-docent-sosyal',
        'aday_notu' => 'Sosyal Bilimlerde beş yayın makale ve kitap kalemlerinden birlikte sayılıyor; ikisinde başlıca yazar olmanız gerekiyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 11.9) "Sosyal Bilimler alanında 1 (a), 3 (a1, a2, b1) maddelerinden en az ikisinde başlıca yazar olmak koşulu ile 1 (a, b, c, d), 3 (a1, a2, b1) maddelerinden beş yayını olmak."',
        'sart' => Kalip::ve('Doçent — Sosyal Bilimler', [
            Kalip::adet('Belirtilen kalemlerden en az 5 yayın', ['1-abcd', '3-a1a2b1'], 5) + ['haric' => ['lisansustu_tezden']],
            Kalip::adet('Bunların en az 2\'sinde başlıca yazar olmalısınız', ['1a', '3-a1a2b1'], 2, 'baslica'),
            Kalip::adet('En az 1 araştırma projesini yürütücü olarak tamamlamış olmak', ['PROJE_YURUTUCU'], 1),
            Kalip::veya('En az 1 tez yönetmiş olmak ya da ilave bir araştırma projesi yürütmek', [
                Kalip::metrik('Bitmiş en az 1 lisansüstü tez danışmanlığı', 'tez_danismanlik', 1),
                Kalip::adet('İlave bir araştırma projesinde yürütücülük', ['PROJE_YURUTUCU'], 1),
            ]),
            Kalip::metrik('En az 2 yarıyıl ders vermiş olmak', 'ders_yariyil', 2),
            $yurtDisi(4, 450),
            Kalip::beyan('Doktora sonrası en az 2 yılı yükseköğretim kurumlarında olmak üzere alanında 4 yıl çalışmış olmak', 'Madde 11.1'),
            Kalip::toplam(300),
        ]),
    ],
    [
        'anahtar' => 'ege-docent-ilahiyat-hukuk',
        'aday_notu' => 'İlahiyat ve Hukukta kitap kalemleri yayın sayısına dâhil; ikisinde başlıca yazar olmanız gerekiyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $ilahiyatHukuk,
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 11.10) "İlahiyat ve Hukuk alanlarında 1 (a), 3 (a1, a2, b1, b2, d) maddelerinden en az ikisinde başlıca yazar olmak koşulu ile … beş yayını olmak."',
        'sart' => Kalip::ve('Doçent — İlahiyat / Hukuk', [
            Kalip::adet('Belirtilen kalemlerden en az 5 yayın', ['1-abcd', '3-ilahiyat'], 5) + ['haric' => ['lisansustu_tezden']],
            Kalip::adet('Bunların en az 2\'sinde başlıca yazar olmalısınız', ['1a', '3-ilahiyat'], 2, 'baslica'),
            Kalip::adet('En az 1 araştırma projesini yürütücü olarak tamamlamış olmak', ['PROJE_YURUTUCU'], 1),
            Kalip::metrik('En az 2 yarıyıl ders vermiş olmak', 'ders_yariyil', 2),
            $yurtDisi(4, 450),
            Kalip::beyan('Doktora sonrası en az 2 yılı yükseköğretim kurumlarında olmak üzere alanında 4 yıl çalışmış olmak', 'Madde 11.1'),
            Kalip::toplam(300),
        ]),
    ],
    [
        'anahtar' => 'ege-docent-spor',
        'aday_notu' => 'Spor Bilimlerinde dört yayın yeterli ve çeyreklik şartı Q3\'e kadar genişliyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['spor'],
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 11.11) "Spor Bilimleri alanında 1 (a) maddesinden Q1, Q2 veya Q3 kategorilerinden en az birinde başlıca yazar olmak koşulu ile dört yayını olmak."',
        'sart' => Kalip::ve('Doçent — Spor Bilimleri', [
            Kalip::adet('SCIE/SSCI/AHCI dergilerde en az 4 yayın', ['1a'], 4) + ['haric' => ['lisansustu_tezden']],
            Kalip::adet('En az 1 Q1, Q2 veya Q3 dergide başlıca yazar olmalısınız', ['1a-Q1Q3'], 1, 'baslica'),
            Kalip::adet('En az 1 araştırma projesini yürütücü olarak tamamlamış olmak', ['PROJE_YURUTUCU'], 1),
            Kalip::metrik('En az 2 yarıyıl ders vermiş olmak', 'ders_yariyil', 2),
            $yurtDisi(4, 450),
            Kalip::beyan('Doktora sonrası en az 2 yılı yükseköğretim kurumlarında olmak üzere alanında 4 yıl çalışmış olmak', 'Madde 11.1'),
            Kalip::toplam(300),
        ]),
    ],
    [
        'anahtar' => 'ege-docent-sanat-mimarlik',
        'aday_notu' => 'Müzik/dans eğitimi metodu ve etüt kitapları da yayın sayısına giriyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $sanatMimarlik,
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 11.12) "Güzel Sanatlar, Mimarlık, Planlama ve Tasarım alanlarında 1 (a, b, d, e, g1, g2), 3 (a1, b1, d, e), 10.4 (k, l) maddelerinden en az ikisinde başlıca yazar olmak koşulu ile beş yayını olmak."',
        'sart' => Kalip::ve('Doçent — Güzel Sanatlar / Mimarlık', [
            Kalip::adet('Belirtilen kalemlerden en az 5 yayın', ['1-abcd', '3-a1a2b1', '10.4-kl'], 5) + ['haric' => ['lisansustu_tezden']],
            Kalip::adet('Bunların en az 2\'sinde başlıca yazar olmalısınız', ['1a', '3-a1a2b1', '10.4-kl'], 2, 'baslica'),
            Kalip::adet('En az 1 araştırma projesini yürütücü olarak tamamlamış olmak', ['PROJE_YURUTUCU'], 1),
            Kalip::metrik('En az 2 yarıyıl ders vermiş olmak', 'ders_yariyil', 2),
            $yurtDisi(4, 450),
            Kalip::beyan('Doktora sonrası en az 2 yılı yükseköğretim kurumlarında olmak üzere alanında 4 yıl çalışmış olmak', 'Madde 11.1'),
            Kalip::toplam(300),
        ]),
    ],

    // ══════════════════ MADDE 10 · PROFESÖR ══════════════════
    //
    // Yayın koşulları DOÇENTLİK SONRASI dönemle sınırlı; toplam puanın en az
    // yarısı da doçentlik sonrası olmalı.
    [
        'anahtar' => 'ege-profesor-fen-muh-saglik',
        'aday_notu' => 'Altı yayının tamamı doçentlik sonrası olmalı ve en az ikisinde Q1/Q2 dergide başlıca yazar olmalısınız. 600 puanın en az yarısı doçentlik sonrasından gelmeli; yurt dışı koşulu 900 puanla telafi edilebiliyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $fenMuhSaglik,
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 10.9) "…doçent ünvanını aldıktan sonra 1 (a) maddesinden Q1 veya Q2 kategorisinden en az ikisinde başlıca yazar olmak koşulu ile altı yayını olmak." Madde 10.14) en az 600 puan.',
        'sart' => Kalip::ve('Profesör — Fen / Mühendislik / Sağlık', [
            Kalip::adet('Doçentlik sonrası SCIE/SSCI/AHCI dergilerde en az 6 yayın', ['1a'], 6, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 2\'sinde Q1 veya Q2 dergide başlıca yazar olmalısınız', ['1a-Q1Q2'], 2, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Biri dış kaynaklı olmak üzere en az 2 araştırma projesini yürütücü olarak tamamlamak', ['PROJE_YURUTUCU'], 2),
            Kalip::veya('En az 2 lisansüstü tez tamamlamış olmak', [
                Kalip::metrik('Bitmiş en az 2 lisansüstü tez danışmanlığı', 'tez_danismanlik', 2),
                // Md. 10.4: tez koşulunu sağlayamayan adaydan Q1/Q2'de başlıca
                // yazar olduğu doçentlik sonrası İLAVE bir yayın isteniyor.
                Kalip::adet('Tez koşulu yoksa: Q1/Q2 dergide başlıca yazar olduğunuz ilave 1 yayın', ['1a-Q1Q2'], 1, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            ]),
            Kalip::metrik('En az 4 yarıyıl (iki yıl) ders vermiş olmak', 'ders_yariyil', 4),
            $yurtDisi(6, 900),
            Kalip::beyan('Doçentlik sonrası yayınlarınızdan birini başlıca araştırma eseri olarak göstermek', 'Madde 10.1'),
            Kalip::beyan('Doçent ünvanından sonra en az dördü yükseköğretim kurumlarında olmak üzere 5 yıl çalışmış olmak', 'Madde 10.2'),
            Kalip::toplam(600),
            Kalip::toplam(300, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],
    [
        'anahtar' => 'ege-profesor-sosyal',
        'aday_notu' => 'Altı yayının tamamı doçentlik sonrası; üçünde başlıca yazar olmalısınız. 600 puanın en az yarısı doçentlik sonrasından gelmeli.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 10.10) "Sosyal Bilimler alanında doçent ünvanını aldıktan sonra 1 (a), 3 (a1, a2, b1) maddelerinden en az üçünde başlıca yazar olmak koşulu ile … altı yayını olmak."',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler', [
            Kalip::adet('Doçentlik sonrası belirtilen kalemlerden en az 6 yayın', ['1-abcd', '3-a1a2b1'], 6, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 3\'ünde başlıca yazar olmalısınız', ['1a', '3-a1a2b1'], 3, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('En az 2 araştırma projesini yürütücü olarak tamamlamış olmak', ['PROJE_YURUTUCU'], 2),
            Kalip::veya('En az 2 lisansüstü tez tamamlamış olmak', [
                Kalip::metrik('Bitmiş en az 2 lisansüstü tez danışmanlığı', 'tez_danismanlik', 2),
                Kalip::adet('Tez koşulu yoksa: başlıca yazar olduğunuz ilave 1 yayın', ['1a'], 1, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            ]),
            Kalip::metrik('En az 4 yarıyıl (iki yıl) ders vermiş olmak', 'ders_yariyil', 4),
            $yurtDisi(6, 900),
            Kalip::beyan('Doçentlik sonrası yayınlarınızdan birini başlıca araştırma eseri olarak göstermek', 'Madde 10.1'),
            Kalip::beyan('Doçent ünvanından sonra en az dördü yükseköğretim kurumlarında olmak üzere 5 yıl çalışmış olmak', 'Madde 10.2'),
            Kalip::toplam(600),
            Kalip::toplam(300, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],
    [
        'anahtar' => 'ege-profesor-ilahiyat-hukuk',
        'aday_notu' => 'İlahiyat ve Hukukta ek proje koşulu (md. 10.7) aranmıyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $ilahiyatHukuk,
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 10.11) "İlahiyat ve Hukuk alanlarında doçent ünvanını aldıktan sonra … en az üçünde başlıca yazar olmak koşulu ile … altı yayını olmak."',
        'sart' => Kalip::ve('Profesör — İlahiyat / Hukuk', [
            Kalip::adet('Doçentlik sonrası belirtilen kalemlerden en az 6 yayın', ['1-abcd', '3-ilahiyat'], 6, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 3\'ünde başlıca yazar olmalısınız', ['1a', '3-ilahiyat'], 3, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('En az 2 araştırma projesini yürütücü olarak tamamlamış olmak', ['PROJE_YURUTUCU'], 2),
            Kalip::metrik('En az 4 yarıyıl (iki yıl) ders vermiş olmak', 'ders_yariyil', 4),
            $yurtDisi(6, 900),
            Kalip::beyan('Doçentlik sonrası yayınlarınızdan birini başlıca araştırma eseri olarak göstermek', 'Madde 10.1'),
            Kalip::beyan('Doçent ünvanından sonra en az dördü yükseköğretim kurumlarında olmak üzere 5 yıl çalışmış olmak', 'Madde 10.2'),
            Kalip::toplam(600),
            Kalip::toplam(300, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],
    [
        'anahtar' => 'ege-profesor-spor',
        'aday_notu' => 'Spor Bilimlerinde beş yayın yeterli ve çeyreklik şartı Q3\'e kadar genişliyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['spor'],
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 10.12) "Spor Bilimleri alanında doçent ünvanını aldıktan sonra 1 (a) maddesinden Q1, Q2 veya Q3 kategorilerinden en az ikisinde başlıca yazar olmak koşulu ile beş yayını olmak."',
        'sart' => Kalip::ve('Profesör — Spor Bilimleri', [
            Kalip::adet('Doçentlik sonrası SCIE/SSCI/AHCI dergilerde en az 5 yayın', ['1a'], 5, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 2\'sinde Q1, Q2 veya Q3 dergide başlıca yazar olmalısınız', ['1a-Q1Q3'], 2, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('En az 2 araştırma projesini yürütücü olarak tamamlamış olmak', ['PROJE_YURUTUCU'], 2),
            Kalip::metrik('En az 4 yarıyıl (iki yıl) ders vermiş olmak', 'ders_yariyil', 4),
            $yurtDisi(6, 900),
            Kalip::beyan('Doçentlik sonrası yayınlarınızdan birini başlıca araştırma eseri olarak göstermek', 'Madde 10.1'),
            Kalip::beyan('Doçent ünvanından sonra en az dördü yükseköğretim kurumlarında olmak üzere 5 yıl çalışmış olmak', 'Madde 10.2'),
            Kalip::toplam(600),
            Kalip::toplam(300, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],
    [
        'anahtar' => 'ege-profesor-sanat-mimarlik',
        'aday_notu' => 'Bu alanlarda ek proje koşulu (md. 10.7) aranmıyor.',
        'universite' => 'Ege Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $sanatMimarlik,
        'cetvel' => 'ege-2026',
        'notlar' => 'Madde 10.13) "Güzel Sanatlar, Mimarlık, Planlama ve Tasarım alanlarında doçent ünvanını aldıktan sonra … en az üçünde başlıca yazar olmak koşulu ile altı yayını olmak."',
        'sart' => Kalip::ve('Profesör — Güzel Sanatlar / Mimarlık', [
            Kalip::adet('Doçentlik sonrası belirtilen kalemlerden en az 6 yayın', ['1-abcd', '3-a1a2b1', '10.4-kl'], 6, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 3\'ünde başlıca yazar olmalısınız', ['1a', '3-a1a2b1', '10.4-kl'], 3, 'baslica', donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('En az 2 araştırma projesini yürütücü olarak tamamlamış olmak', ['PROJE_YURUTUCU'], 2),
            Kalip::metrik('En az 4 yarıyıl (iki yıl) ders vermiş olmak', 'ders_yariyil', 4),
            $yurtDisi(6, 900),
            Kalip::beyan('Doçentlik sonrası yayınlarınızdan birini başlıca araştırma eseri olarak göstermek', 'Madde 10.1'),
            Kalip::beyan('Doçent ünvanından sonra en az dördü yükseköğretim kurumlarında olmak üzere 5 yıl çalışmış olmak', 'Madde 10.2'),
            Kalip::toplam(600),
            Kalip::toplam(300, Kalip::DOCENTLIK_SONRASI),
        ]),
    ],
];
