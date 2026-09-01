<?php

/**
 * BAYBURT ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri
 * Kaynak: pdf/17536973432.bayburtuniverstesi.pdf (Madde 10)
 *
 * ÜÇ KATMANLI ALT BARAJ — korpusta ender bir yapı. Her kadroda üç alt baraj
 * üst üste biniyor ve hepsi aynı puanları farklı kümelerden sayıyor:
 *   4. madde (yalnızca projeler)   →  Dr. yeniden atama 20 · doçent 40 · profesör 50
 *   1. ve 4. madde (makale+proje)  →  60 · 150 · 250
 *   1-6. maddeler (bütün yayınlar) →  100 · 200 · 350
 *   genel toplam                   →  200 · 350 · 700
 * Yani proje üretmeyen aday, makale puanı ne olursa olsun geçemiyor: en içteki
 * baraj yalnızca 4. maddeyi (bilimsel araştırma projesi) sayıyor.
 *
 * DR. ÖĞR. ÜYESİ İLK ATAMADA PROJE ŞARTI YOK: ilk atamada yalnızca iki katman
 * var (1-6'dan 80, toplam 100). Proje barajı yeniden atamada devreye giriyor.
 *
 * TEMEL ALAN AYRIMI YOK — tek istisna Güzel Sanatlar. O alanda alt küme
 * "1., 2., 3., 4., 5., 6. ve 11(2)" oluyor, yani sanat ve tasarım etkinlikleri
 * de sayılıyor.
 *
 * GÜZEL SANATLAR 01.09.2026'DA AÇILDI. Alanın alt kümesi 11(2) bölümünü (Sanat
 * ve Tasarım Etkinlikleri) de sayıyor; o bölüm "puan sütunu ayrıştırılamadı"
 * diye kayıtlıydı ve alan hiç girilmemişti. Bölüm `pdftotext -layout` ile
 * eksiksiz okundu ve cetvele girildi, eşikler yazıldı.
 *
 * GÜZEL SANATLAR'IN SAYILARI ÖTEKİLERLE AYNI; YALNIZCA KÜME GENİŞ. Madde
 * 10 a.3, b.2, c.3 ve ç.2 aynı barajları tekrar ediyor, tek fark alt kümenin
 * "1-6" yerine "1-6 ve 11(2)" olması. Yani alan ötekilerden bir tık kolay:
 * sanat etkinlikleri de aynı barajı doldurabiliyor.
 *
 * DR. YENİDEN ATANMA GİRİLDİ AMA SÜRE KURALI GİRİLMEDİ: Madde 10/b.4 alınan
 * puana göre atama süresini belirliyor (asgari puanın 2 katından fazlası 3 yıl,
 * arası 2 yıl). Bu süre hesabı eşik değil sonuç olduğu için aday notunda anıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/bayburt-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DR = Kalip::DOKTORA_SONRASI;
$DOC = Kalip::DOCENTLIK_SONRASI;

/** Güzel Sanatlar hariç bütün temel alanlar (bkz. dosya başlığı). */
$alanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'ziraat'];

$gsNotu = 'GÜZEL SANATLAR ALANINDA ALT BARAJ AYNI SAYILARI İSTİYOR ama sanat ve tasarım '
    .'etkinliklerini (11(2) bölümü) de sayıyor; o alandaysanız aşağıdaki Güzel Sanatlar '
    .'eşiğine bakın.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Madde 10/a) ══════════
    [
        'anahtar' => 'bayburt-dr',
        'aday_notu' => 'İlk atamada proje şartı YOK; yalnızca yayın kalemlerinden 80 ve toplamda '
            .'100 puan isteniyor. Proje barajı yeniden atamada devreye giriyor: o aşamada '
            .'projelerden en az 20, makale ve projelerden 60, yayınlardan 100 ve toplamda 200 '
            .'puan gerekiyor. İlk atama en fazla 2 yıl süreyle yapılıyor. '.$gsNotu,
        'universite' => 'Bayburt Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => 'bayburt-2024',
        'notlar' => 'Madde 10/a.2: puan tablosunun 1-6. maddelerinden en az 80, toplamda en az '
            .'100 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Bayburt Üniversitesi', [
            Kalip::toplam(100),
            Kalip::puanDan('Makale, kitap, bildiri, proje, patent ve atıf kalemlerinizden en az 80 puan',
                ['1-6'], 80, madde: 'Madde 10/a.2'),
            Kalip::beyan('Doktora, tıpta uzmanlık veya sanatta yeterlik unvanına sahip olmak',
                'Madde 10/a.1'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 10/c) ══════════
    [
        'anahtar' => 'bayburt-docent',
        'aday_notu' => 'ÜÇ ALT BARAJ ÜST ÜSTE: en içteki baraj yalnızca BİLİMSEL ARAŞTIRMA '
            .'PROJESİ kalemini sayıyor (40 puan), yani projesi olmayan aday makale puanı ne '
            .'olursa olsun geçemiyor. Puanların tamamı doktora unvanınızı aldıktan sonraki '
            .'çalışmalarınızdan gelmeli. '.$gsNotu,
        'universite' => 'Bayburt Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => 'bayburt-2024',
        'notlar' => 'Madde 10/c.2: doktora sonrası 4. maddeden en az 40, 1. ve 4. maddelerden '
            .'en az 150, 1-6. maddelerden en az 200, genel toplamda en az 350 puan.',
        'sart' => Kalip::ve('Doçent — Bayburt Üniversitesi', [
            Kalip::toplam(350, $DR),
            Kalip::puanDan('Makale, kitap, bildiri, proje, patent ve atıf kalemlerinizden en az 200 puan',
                ['1-6'], 200, $DR, madde: 'Madde 10/c.2'),
            Kalip::puanDan('Makale ve proje kalemlerinizden en az 150 puan',
                ['1 ve 4'], 150, $DR, madde: 'Madde 10/c.2'),
            Kalip::puanDan('Bilimsel araştırma projelerinizden en az 40 puan',
                ['4'], 40, $DR, madde: 'Madde 10/c.2'),
            Kalip::beyan('ÜAK tarafından doçentlik için belirlenen asgari başvuru koşullarını '
                .'yerine getirmiş ve doçent unvanını almış olmak', 'Madde 10/c.1'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 10/ç) ══════════
    [
        'anahtar' => 'bayburt-profesor',
        'aday_notu' => 'ÜÇ ALT BARAJ ÜST ÜSTE: en içteki baraj yalnızca BİLİMSEL ARAŞTIRMA '
            .'PROJESİ kalemini sayıyor (50 puan). Puanların tamamı doçentlik unvanınızı '
            .'aldıktan sonraki çalışmalarınızdan gelmeli ve en az bir makalenizde başlıca yazar '
            .'olmanız gerekiyor. '.$gsNotu,
        'universite' => 'Bayburt Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => 'bayburt-2024',
        'notlar' => 'Madde 10/ç.1: doçentlik sonrası 4. maddeden en az 50, 1. ve 4. maddelerden '
            .'en az 250, 1-6. maddelerden en az 350, genel toplamda en az 700 puan. '
            .'Madde 10/ç.3: en az bir makalede başlıca yazar olmak.',
        'sart' => Kalip::ve('Profesör — Bayburt Üniversitesi', [
            Kalip::toplam(700, $DOC),
            Kalip::puanDan('Makale, kitap, bildiri, proje, patent ve atıf kalemlerinizden en az 350 puan',
                ['1-6'], 350, $DOC, madde: 'Madde 10/ç.1'),
            Kalip::puanDan('Makale ve proje kalemlerinizden en az 250 puan',
                ['1 ve 4'], 250, $DOC, madde: 'Madde 10/ç.1'),
            Kalip::puanDan('Bilimsel araştırma projelerinizden en az 50 puan',
                ['4'], 50, $DOC, madde: 'Madde 10/ç.1'),
            Kalip::adet('Başlıca yazar olduğunuz en az 1 makale',
                ['MAKALE'], 1, 'baslica', madde: 'Madde 10/ç.3'),
        ]),
    ],

    // ══════════ GÜZEL SANATLAR (Madde 10 a.3 · c.3 · ç.2) ══════════
    // Barajların sayıları ötekilerle birebir aynı; tek fark alt kümenin
    // "1-6" yerine "1-6 ve 11(2)" olması.
    [
        'anahtar' => 'bayburt-gs-dr',
        'aday_notu' => 'Güzel Sanatlar alanında alt baraj sanat ve tasarım etkinliklerinizi '
            .'(cetvelin 11.2 bölümü) de sayıyor; sayılar öteki alanlarla aynı olduğu için bu '
            .'alan bir tık kolay. İlk atamada proje şartı YOK; yayın ve sanat kalemlerinden 80, '
            .'toplamda 100 puan isteniyor. Yeniden atamada projelerden en az 20, makale ve '
            .'projelerden 60, sayılan bölümlerden 100 ve toplamda 200 puan gerekiyor. İlk atama '
            .'en fazla 2 yıl süreyle yapılıyor.',
        'universite' => 'Bayburt Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'bayburt-2024',
        'notlar' => 'Madde 10/a.3: puan tablosunun 1., 2., 3., 4., 5., 6. ve 11(2). '
            .'maddelerinden en az 80, toplamda en az 100 puan.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Bayburt Üniversitesi (Güzel Sanatlar)', [
            Kalip::toplam(100),
            Kalip::puanDan('Makale, kitap, bildiri, proje, patent, atıf ve sanat etkinliği '
                .'kalemlerinizden en az 80 puan', ['1-6 ve 11.2'], 80, madde: 'Madde 10/a.3'),
            Kalip::beyan('Doktora, tıpta uzmanlık veya sanatta yeterlik unvanına sahip olmak',
                'Madde 10/a.1'),
        ]),
    ],

    [
        'anahtar' => 'bayburt-gs-docent',
        'aday_notu' => 'ÜÇ ALT BARAJ ÜST ÜSTE: en içteki baraj yalnızca BİLİMSEL ARAŞTIRMA '
            .'PROJESİ kalemini sayıyor (40 puan), yani projesi olmayan aday puanı ne olursa '
            .'olsun geçemiyor. Güzel Sanatlar alanında en dıştaki alt baraj sanat ve tasarım '
            .'etkinliklerinizi (cetvelin 11.2 bölümü) de sayıyor. Puanların tamamı doktora '
            .'unvanınızı aldıktan sonraki çalışmalarınızdan gelmeli.',
        'universite' => 'Bayburt Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'bayburt-2024',
        'notlar' => 'Madde 10/c.3: doktora sonrası 4. maddeden en az 40, 1. ve 4. maddelerden '
            .'en az 150, 1., 2., 3., 4., 5., 6. ve 11(2). maddelerden en az 200, genel toplamda '
            .'en az 350 puan.',
        'sart' => Kalip::ve('Doçent — Bayburt Üniversitesi (Güzel Sanatlar)', [
            Kalip::toplam(350, $DR),
            Kalip::puanDan('Makale, kitap, bildiri, proje, patent, atıf ve sanat etkinliği '
                .'kalemlerinizden en az 200 puan', ['1-6 ve 11.2'], 200, $DR, madde: 'Madde 10/c.3'),
            Kalip::puanDan('Makale ve proje kalemlerinizden en az 150 puan',
                ['1 ve 4'], 150, $DR, madde: 'Madde 10/c.3'),
            Kalip::puanDan('Bilimsel araştırma projelerinizden en az 40 puan',
                ['4'], 40, $DR, madde: 'Madde 10/c.3'),
            Kalip::beyan('ÜAK tarafından doçentlik için belirlenen asgari başvuru koşullarını '
                .'yerine getirmiş ve doçent unvanını almış olmak', 'Madde 10/c.1'),
        ]),
    ],

    [
        'anahtar' => 'bayburt-gs-profesor',
        'aday_notu' => 'ÜÇ ALT BARAJ ÜST ÜSTE: en içteki baraj yalnızca BİLİMSEL ARAŞTIRMA '
            .'PROJESİ kalemini sayıyor (50 puan). Güzel Sanatlar alanında en dıştaki alt baraj '
            .'sanat ve tasarım etkinliklerinizi (cetvelin 11.2 bölümü) de sayıyor. Puanların '
            .'tamamı doçentlik unvanınızı aldıktan sonraki çalışmalarınızdan gelmeli ve en az '
            .'bir makalenizde başlıca yazar olmanız gerekiyor.',
        'universite' => 'Bayburt Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'bayburt-2024',
        'notlar' => 'Madde 10/ç.2: doçentlik sonrası 4. maddeden en az 50, 1. ve 4. maddelerden '
            .'en az 250, 1., 2., 3., 4., 5., 6. ve 11(2). maddelerden en az 350, genel toplamda '
            .'en az 700 puan. Madde 10/ç.3: en az bir makalede başlıca yazar olmak.',
        'sart' => Kalip::ve('Profesör — Bayburt Üniversitesi (Güzel Sanatlar)', [
            Kalip::toplam(700, $DOC),
            Kalip::puanDan('Makale, kitap, bildiri, proje, patent, atıf ve sanat etkinliği '
                .'kalemlerinizden en az 350 puan', ['1-6 ve 11.2'], 350, $DOC, madde: 'Madde 10/ç.2'),
            Kalip::puanDan('Makale ve proje kalemlerinizden en az 250 puan',
                ['1 ve 4'], 250, $DOC, madde: 'Madde 10/ç.2'),
            Kalip::puanDan('Bilimsel araştırma projelerinizden en az 50 puan',
                ['4'], 50, $DOC, madde: 'Madde 10/ç.2'),
            Kalip::adet('Başlıca yazar olduğunuz en az 1 makale',
                ['MAKALE'], 1, 'baslica', madde: 'Madde 10/ç.3'),
        ]),
    ],
];
