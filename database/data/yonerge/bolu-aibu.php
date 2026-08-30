<?php

/**
 * BOLU ABANT İZZET BAYSAL ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve
 * Atanma Yönergesi (Madde 7)
 * Kaynak: pdf/17536991342.boluabantizzetbaysaluniversitesi.pdf
 *
 * İKİ ALAN GRUBU, HER KADRODA AYRI TABLO:
 *   Fen Bilimleri, Mühendislik, Mimarlık, Sağlık Bilimleri
 *   Sosyal Bilimler, Eğitim Bilimleri, Güzel Sanatlar
 * Güzel Sanatlar puan olarak sosyal grupta, ama alt baraj kuralı farklı:
 * diğerleri puanın tamamını "A1-A8"den isterken Güzel Sanatlar'da yarısı "A",
 * yarısı "I" (sanat çalışmaları) kategorilerinden geliyor. I bölümü cetvele
 * girdiği için bu eşikler eksiksiz duruyor.
 *
 * YÖNERGENİN ANMADIĞI ALANLAR GİRİLMEDİ: hukuk, ilahiyat, filoloji, spor ve
 * ziraat yönergenin iki grubunda da adı geçmiyor. Bu alanları bir gruba katmak,
 * adaya yönergede yazmayan bir baraj göstermek olurdu.
 *
 * KOŞULLAR YÜZDE OLARAK YAZILMIŞ, SABİT PUANA ÇEVRİLDİ. Tablodaki toplamlar
 * bilindiği için yüzdeler doğrudan puana dönüştürüldü (ör. profesör fen:
 * toplam 400 → A1-A8'den %25 = 100). Kesirli çıkan değerler AŞAĞI yuvarlandı —
 * yukarı yuvarlamak adaya yönergeden ağır bir baraj gösterirdi.
 *
 * DR. ÖĞR. ÜYESİ ALT BARAJI DAHA AĞIR: Bolu diğer kadrolarda %25 isterken ilk
 * atanmada puanın %50'sini "A" kategorisinden istiyor (Madde 7.3/c). Bu
 * yönergenin kendi tercihi; genç adaya yayın ağırlıklı bir kapı koyuyor.
 *
 * YENİDEN ATANMA GİRİLMEDİ: yönerge sabit puan değil, "30 / Yıl" ve "20 / Yıl"
 * diyor. Görev süresi profilde tutulmadığı için sabit bir eşik yazmak yanlış
 * olurdu; koşul aday notunda anıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/bolu-aibu-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

$fenGrubu = ['fen', 'muhendislik', 'mimarlik', 'saglik'];
$sosyalGrubu = ['sosyal', 'egitim'];

$yenidenAtamaNotu = 'Yeniden atanmada yönerge sabit puan değil, GÖREV YILI BAŞINA puan istiyor '
    .'(fen grubunda 30/yıl, sosyal grubunda 20/yıl). Görev süreniz burada tutulmadığı için '
    .'yeniden atanma eşiği girilmedi; ilk atanmadaki kategori oranları (puanın %50\'si "A") '
    .'yeniden atanmada da geçerli.';

$gsNotu = 'Güzel Sanatlar\'da alt baraj ikiye bölünüyor: puanın %25\'i yayın ve atıf ("A"), '
    .'%25\'i sanat çalışmaları ("I") kategorilerinden gelmeli.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Madde 7.3) ══════════
    [
        'anahtar' => 'bolu-aibu-dr-fen',
        'aday_notu' => 'Bolu ilk atanmada diğer kadrolardan AĞIR bir oran istiyor: puanın '
            .'%50\'si yayın ve atıf kalemlerinden gelmeli. '.$yenidenAtamaNotu,
        'universite' => 'Bolu Abant İzzet Baysal Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $fenGrubu,
        'cetvel' => 'bolu-aibu-2024',
        'notlar' => 'Madde 7.3: ilk atanma puanı 120; bunun en az %50\'si (60 puan) "A" '
            .'kategorisinden.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen, Mühendislik, Mimarlık ve Sağlık Bilimleri', [
            Kalip::toplam(120),
            Kalip::puanDan('Yayın, kitap ve atıf kalemlerinizden en az 60 puan (ilk atanma puanının yarısı)',
                ['A'], 60, madde: 'Madde 7.3/c'),
            Kalip::beyan('Doktora, uzmanlık veya sanatta yeterlik unvanına sahip olmak', 'Madde 7.3/a'),
        ]),
    ],
    [
        'anahtar' => 'bolu-aibu-dr-sosyal',
        'aday_notu' => 'Bolu ilk atanmada diğer kadrolardan AĞIR bir oran istiyor: puanın '
            .'%50\'si yayın ve atıf kalemlerinden gelmeli. '.$yenidenAtamaNotu,
        'universite' => 'Bolu Abant İzzet Baysal Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $sosyalGrubu,
        'cetvel' => 'bolu-aibu-2024',
        'notlar' => 'Madde 7.3: ilk atanma puanı 80; bunun en az %50\'si (40 puan) "A" '
            .'kategorisinden.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal Bilimler ve Eğitim Bilimleri', [
            Kalip::toplam(80),
            Kalip::puanDan('Yayın, kitap ve atıf kalemlerinizden en az 40 puan (ilk atanma puanının yarısı)',
                ['A'], 40, madde: 'Madde 7.3/c'),
            Kalip::beyan('Doktora, uzmanlık veya sanatta yeterlik unvanına sahip olmak', 'Madde 7.3/a'),
        ]),
    ],
    [
        'anahtar' => 'bolu-aibu-dr-guzel-sanatlar',
        'aday_notu' => $gsNotu.' '.$yenidenAtamaNotu,
        'universite' => 'Bolu Abant İzzet Baysal Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'bolu-aibu-2024',
        'notlar' => 'Madde 7.3/c: ilk atanma puanı 80; %25\'i (20 puan) "A", %25\'i (20 puan) '
            .'"I" kategorilerinden.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Güzel Sanatlar', [
            Kalip::toplam(80),
            Kalip::puanDan('Yayın, kitap ve atıf kalemlerinizden en az 20 puan',
                ['A'], 20, madde: 'Madde 7.3/c'),
            Kalip::puanDan('Sanat çalışmalarınızdan en az 20 puan',
                ['I'], 20, madde: 'Madde 7.3/c'),
            Kalip::beyan('Doktora, uzmanlık veya sanatta yeterlik unvanına sahip olmak', 'Madde 7.3/a'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 7.2) ══════════
    [
        'anahtar' => 'bolu-aibu-docent-fen',
        'aday_notu' => 'Yönerge doçentlikte dönem sınırı koymuyor; bütün çalışmalarınız sayılır. '
            .'Doktora sonrası alanınızla ilgili çalışma yapmış olmanız ayrıca aranıyor.',
        'universite' => 'Bolu Abant İzzet Baysal Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $fenGrubu,
        'cetvel' => 'bolu-aibu-2024',
        'notlar' => 'Madde 7.2: toplam 300 puan; en az %25\'i (75 puan) A1-A8 kategorilerinden.',
        'sart' => Kalip::ve('Doçent — Fen, Mühendislik, Mimarlık ve Sağlık Bilimleri', [
            Kalip::toplam(300),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 75 puan (toplamın dörtte biri)',
                ['A1-A8'], 75, madde: 'Madde 7.2/c'),
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip '
                .'olmak ve doktora/uzmanlık/sanatta yeterlik sonrası alanınızla ilgili çalışma '
                .'yapmış olmak', 'Madde 7.2/a-b'),
        ]),
    ],
    [
        'anahtar' => 'bolu-aibu-docent-sosyal',
        'aday_notu' => 'Yönerge doçentlikte dönem sınırı koymuyor; bütün çalışmalarınız sayılır. '
            .'Doktora sonrası alanınızla ilgili çalışma yapmış olmanız ayrıca aranıyor.',
        'universite' => 'Bolu Abant İzzet Baysal Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $sosyalGrubu,
        'cetvel' => 'bolu-aibu-2024',
        'notlar' => 'Madde 7.2: toplam 200 puan; en az %25\'i (50 puan) A1-A8 kategorilerinden.',
        'sart' => Kalip::ve('Doçent — Sosyal Bilimler ve Eğitim Bilimleri', [
            Kalip::toplam(200),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 50 puan (toplamın dörtte biri)',
                ['A1-A8'], 50, madde: 'Madde 7.2/c'),
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip '
                .'olmak ve doktora/uzmanlık/sanatta yeterlik sonrası alanınızla ilgili çalışma '
                .'yapmış olmak', 'Madde 7.2/a-b'),
        ]),
    ],
    [
        'anahtar' => 'bolu-aibu-docent-guzel-sanatlar',
        'aday_notu' => $gsNotu,
        'universite' => 'Bolu Abant İzzet Baysal Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'bolu-aibu-2024',
        'notlar' => 'Madde 7.2/c: toplam 200 puan; %25\'i (50 puan) "A", %25\'i (50 puan) "I" '
            .'kategorilerinden.',
        'sart' => Kalip::ve('Doçent — Güzel Sanatlar', [
            Kalip::toplam(200),
            Kalip::puanDan('Yayın, kitap ve atıf kalemlerinizden en az 50 puan',
                ['A'], 50, madde: 'Madde 7.2/c'),
            Kalip::puanDan('Sanat çalışmalarınızdan en az 50 puan',
                ['I'], 50, madde: 'Madde 7.2/c'),
            Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip '
                .'olmak ve doktora/sanatta yeterlik sonrası alanınızla ilgili çalışma yapmış '
                .'olmak', 'Madde 7.2/a-b'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 7.1) ══════════
    [
        'anahtar' => 'bolu-aibu-profesor-fen',
        'aday_notu' => 'Alt baraj İKİ KEZ isteniyor: hem toplam puanın %25\'i, hem doçentlik '
            .'sonrası puanın %25\'i makale ve kitap kalemlerinizden gelmeli.',
        'universite' => 'Bolu Abant İzzet Baysal Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $fenGrubu,
        'cetvel' => 'bolu-aibu-2024',
        'notlar' => 'Madde 7.1: toplam 400, doçentlik sonrası en az 200; toplamın %25\'i (100) '
            .'ve doçentlik sonrası puanın %25\'i (50) A1-A8 kategorilerinden.',
        'sart' => Kalip::ve('Profesör — Fen, Mühendislik, Mimarlık ve Sağlık Bilimleri', [
            Kalip::toplam(400),
            Kalip::toplam(200, $DOC),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 100 puan (toplamın dörtte biri)',
                ['A1-A8'], 100, madde: 'Madde 7.1/c'),
            Kalip::puanDan('Doçentliğinizden sonraki makale ve kitap kalemlerinizden en az 50 puan',
                ['A1-A8'], 50, $DOC, madde: 'Madde 7.1/c'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az 5 yıl süreyle ilgili bilim '
                .'alanında çalışmış olmak', 'Madde 7.1/a'),
        ]),
    ],
    [
        'anahtar' => 'bolu-aibu-profesor-sosyal',
        'aday_notu' => 'Alt baraj İKİ KEZ isteniyor: hem toplam puanın %25\'i, hem doçentlik '
            .'sonrası puanın %25\'i makale ve kitap kalemlerinizden gelmeli.',
        'universite' => 'Bolu Abant İzzet Baysal Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $sosyalGrubu,
        'cetvel' => 'bolu-aibu-2024',
        'notlar' => 'Madde 7.1: toplam 300, doçentlik sonrası en az 150; toplamın %25\'i (75) '
            .'ve doçentlik sonrası puanın %25\'i (37) A1-A8 kategorilerinden.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler ve Eğitim Bilimleri', [
            Kalip::toplam(300),
            Kalip::toplam(150, $DOC),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 75 puan (toplamın dörtte biri)',
                ['A1-A8'], 75, madde: 'Madde 7.1/c'),
            Kalip::puanDan('Doçentliğinizden sonraki makale ve kitap kalemlerinizden en az 37 puan',
                ['A1-A8'], 37, $DOC, madde: 'Madde 7.1/c'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az 5 yıl süreyle ilgili bilim '
                .'alanında çalışmış olmak', 'Madde 7.1/a'),
        ]),
    ],
    [
        'anahtar' => 'bolu-aibu-profesor-guzel-sanatlar',
        'aday_notu' => $gsNotu.' Ayrıca doçentliğinizden sonra en az bir bireysel sergi veya '
            .'dinleti gerçekleştirmiş olmanız gerekiyor.',
        'universite' => 'Bolu Abant İzzet Baysal Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'bolu-aibu-2024',
        'notlar' => 'Madde 7.1/c: toplam 300, doçentlik sonrası en az 150; toplamın %25\'i (75) '
            .'"A", %25\'i (75) "I" kategorilerinden; doçentlik sonrası en az 1 bireysel '
            .'sergi/dinleti.',
        'sart' => Kalip::ve('Profesör — Güzel Sanatlar', [
            Kalip::toplam(300),
            Kalip::toplam(150, $DOC),
            Kalip::puanDan('Yayın, kitap ve atıf kalemlerinizden en az 75 puan',
                ['A'], 75, madde: 'Madde 7.1/c'),
            Kalip::puanDan('Sanat çalışmalarınızdan en az 75 puan',
                ['I'], 75, madde: 'Madde 7.1/c'),
            Kalip::adet('Doçentliğinizden sonra en az 1 bireysel sergi veya dinleti',
                ['I.1.4.5', 'I.1.4.6', 'I.2.1.1', 'I.2.1.2', 'I.2.1.7'], 1, donem: $DOC,
                madde: 'Madde 7.1/c'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az 5 yıl süreyle ilgili sanat '
                .'alanında çalışmış olmak', 'Madde 7.1/a'),
        ]),
    ],
];
