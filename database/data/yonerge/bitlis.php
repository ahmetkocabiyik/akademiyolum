<?php

/**
 * BİTLİS EREN ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri
 * Kaynak: pdf/17536932232.bitliserenuniverstesi.pdf (Madde 8)
 *
 * İKİ ALAN GRUBU, HER KADRODA AYRI TABLO:
 *   Fen Bilimleri, Mühendislik, Mimarlık, Sağlık Bilimleri
 *   Sosyal Bilimler, Eğitim Bilimleri, Güzel Sanatlar
 *
 * YÖNERGENİN ANMADIĞI ALANLAR GİRİLMEDİ: hukuk, ilahiyat, filoloji, spor ve
 * ziraat yönergenin iki grubunda da adı geçmiyor. Bu alanları "sosyal"a ya da
 * "fen"e katmak, adaya yönergede yazmayan bir baraj göstermek olurdu; bu yüzden
 * Bitlis Eren o alanlarda kapsam dışı görünür.
 *
 * KOŞULLAR YÜZDE OLARAK YAZILMIŞ, SABİT SAYIYA ÇEVRİLDİ. Yönerge "tabloda
 * belirtilen toplam puanın en az yüzde 50'sini A.1-A.8 kategorilerinden almış
 * olmak" diyor; tablodaki toplam bilindiği için yüzdeler doğrudan puana
 * dönüştürüldü (ör. doçentlik fen: toplam 400 → A.1-A.8'den 200).
 *
 * GÜZEL SANATLAR GİRİLMEDİ: bu alanda yüzde 50'lik "A" koşulu ikiye bölünüyor —
 * puanın %25'i "A", %25'i "I" (sanatsal etkinlikler) kategorilerinden. I bölümü
 * kaynak sözlüğünde karşılıksız olduğu için cetvele girmedi; yalnızca "A"
 * yarısını yazmak adaya sağlaması gerekenin yarısını göstermek olurdu.
 *
 * PROFESÖRLÜKTEKİ ATIF KOŞULU (8.1/d) BEYANA BIRAKILDI: koşul "en az 2 eserine
 * SCI-E/AHCI/ESCI/SSCI dergilerinde 30 atıf, yoksa tüm eserlerine 40 atıf,
 * o da yoksa c bendine ilaveten 2 yayın" biçiminde üç kademeli. "Kaç ESERİNE
 * atıf yapıldığı" faaliyet kaydından türetilemiyor (kayıt atıf sayısını tutuyor,
 * atıf alan eser sayısını değil), bu yüzden beyan olarak duruyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/bitlis-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$DR = Kalip::DOKTORA_SONRASI;
$DOC = Kalip::DOCENTLIK_SONRASI;

/** Yönergenin adıyla saydığı iki grup. */
$fenGrubu = ['fen', 'muhendislik', 'mimarlik', 'saglik'];
$sosyalGrubu = ['sosyal', 'egitim'];

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (ilk atama, Madde 8.3) ══════════
    [
        'anahtar' => 'bitlis-dr-fen',
        'aday_notu' => 'Yeniden atanmada ayrı bir puan tablosu yok; yönerge yalnızca '
            .'"yeniden atanma puanının en az yüzde 50\'sini makale ve kitap kalemlerinden almak", '
            .'SCI-Expanded, SSCI ya da AHCI dergisinden 1 yayın veya alan indeksli ve TR Dizin '
        .'dergilerinden toplam 2 yayın, ve 2 eserinize en az 10 atıf '
            .'şartlarını arıyor. Burada gördükleriniz ilk atama koşullarıdır.',
        'universite' => 'Bitlis Eren Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $fenGrubu,
        'cetvel' => 'bitlis-2024',
        'notlar' => 'Madde 8.3: ilk atanma puanı 150; bunun en az %50\'si (75 puan) A.1-A.10 '
            .'kategorilerinden; A.1, A.2 veya A.5\'ten en az 1 yayın.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Fen, Mühendislik, Mimarlık ve Sağlık Bilimleri', [
            Kalip::toplam(150),
            Kalip::puanDan('Makale, kitap ve atıf kalemlerinizden en az 75 puan (ilk atanma puanının yarısı)',
                ['A.1-A.10'], 75, madde: 'Madde 8.3/c'),
            Kalip::adet('SCI-E/SSCI/AHCI, uluslararası alan indeksli veya TR Dizin dergide en az 1 yayın',
                ['A.1', 'A.2', 'A.5'], 1, madde: 'Madde 8.3/d'),
            Kalip::beyan('Doktora, uzmanlık veya sanatta yeterlik unvanına sahip olmak', 'Madde 8.3/a'),
        ]),
    ],
    [
        'anahtar' => 'bitlis-dr-sosyal',
        'aday_notu' => 'Yeniden atanmada ayrı bir puan tablosu yok; yönerge yalnızca '
            .'"yeniden atanma puanının en az yüzde 50\'sini makale ve kitap kalemlerinden almak", '
            .'SCI-Expanded, SSCI ya da AHCI dergisinden 1 yayın veya alan indeksli, TR Dizin ve '
        .'diğer hakemli dergilerden toplam 2 yayın, ve 2 eserinize en az 10 '
            .'atıf şartlarını arıyor. Burada gördükleriniz ilk atama koşullarıdır.',
        'universite' => 'Bitlis Eren Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $sosyalGrubu,
        'cetvel' => 'bitlis-2024',
        'notlar' => 'Madde 8.3: ilk atanma puanı 120; bunun en az %50\'si (60 puan) A.1-A.10 '
            .'kategorilerinden; A.1, A.2 veya A.5\'ten en az 1 yayın.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal Bilimler ve Eğitim Bilimleri', [
            Kalip::toplam(120),
            Kalip::puanDan('Makale, kitap ve atıf kalemlerinizden en az 60 puan (ilk atanma puanının yarısı)',
                ['A.1-A.10'], 60, madde: 'Madde 8.3/c'),
            Kalip::adet('SCI-E/SSCI/AHCI, uluslararası alan indeksli veya TR Dizin dergide en az 1 yayın',
                ['A.1', 'A.2', 'A.5'], 1, madde: 'Madde 8.3/d'),
            Kalip::beyan('Doktora, uzmanlık veya sanatta yeterlik unvanına sahip olmak', 'Madde 8.3/a'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 8.2) ══════════
    [
        'anahtar' => 'bitlis-docent-fen',
        'aday_notu' => 'Toplam 400 puanın 200\'ü doktora unvanınızı aldıktan sonraki '
            .'çalışmalarınızdan gelmeli; ayrıca toplamın yarısı makale ve kitap kalemlerinden '
            .'(makale ve kitap kalemlerinden) olmalı.',
        'universite' => 'Bitlis Eren Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $fenGrubu,
        'cetvel' => 'bitlis-2024',
        'notlar' => 'Madde 8.2: toplam 400, doktora sonrası en az 200; toplamın %50\'si '
            .'(200 puan) A.1-A.8 kategorilerinden.',
        'sart' => Kalip::ve('Doçent — Fen, Mühendislik, Mimarlık ve Sağlık Bilimleri', [
            Kalip::toplam(400),
            Kalip::toplam(200, $DR),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 200 puan (toplamın yarısı)',
                ['A.1-A.8'], 200, madde: 'Madde 8.2/c'),
            Kalip::beyan('Üniversitelerarası Kurul Başkanlığınca verilen doçentlik belgesine sahip '
                .'olmak ve doktora/uzmanlık/sanatta yeterlik sonrası alanınızla ilgili çalışma '
                .'yapmış olmak', 'Madde 8.2/a-b'),
        ]),
    ],
    [
        'anahtar' => 'bitlis-docent-sosyal',
        'aday_notu' => 'Toplam 300 puanın 150\'si doktora unvanınızı aldıktan sonraki '
            .'çalışmalarınızdan gelmeli; ayrıca toplamın yarısı makale ve kitap kalemlerinden '
            .'(makale ve kitap kalemlerinden) olmalı.',
        'universite' => 'Bitlis Eren Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $sosyalGrubu,
        'cetvel' => 'bitlis-2024',
        'notlar' => 'Madde 8.2: toplam 300, doktora sonrası en az 150; toplamın %50\'si '
            .'(150 puan) A.1-A.8 kategorilerinden.',
        'sart' => Kalip::ve('Doçent — Sosyal Bilimler ve Eğitim Bilimleri', [
            Kalip::toplam(300),
            Kalip::toplam(150, $DR),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 150 puan (toplamın yarısı)',
                ['A.1-A.8'], 150, madde: 'Madde 8.2/c'),
            Kalip::beyan('Üniversitelerarası Kurul Başkanlığınca verilen doçentlik belgesine sahip '
                .'olmak ve doktora/uzmanlık/sanatta yeterlik sonrası alanınızla ilgili çalışma '
                .'yapmış olmak', 'Madde 8.2/a-b'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 8.1) ══════════
    [
        'anahtar' => 'bitlis-profesor-fen',
        'aday_notu' => 'Atıf koşulu burada beyan olarak duruyor: en az 2 eserinize '
            .'SCI-E/AHCI/ESCI/SSCI dergilerinde toplam 30 atıf, bu yoksa tüm eserlerinize '
            .'(tezler hariç) en az 40 atıf gerekiyor. Hiçbirini sağlamıyorsanız dizinli '
            .'dergilerden 2 yayın daha yapmanız zorunlu.',
        'universite' => 'Bitlis Eren Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $fenGrubu,
        'cetvel' => 'bitlis-2024',
        'notlar' => 'Madde 8.1: toplam 500, doçentlik sonrası en az 250; toplamın %50\'si (250) '
            .'ve doçentlik sonrası puanın %50\'si (125) A.1-A.8\'den; doçentlik sonrası A.1\'den '
            .'en az 2 yayın.',
        'sart' => Kalip::ve('Profesör — Fen, Mühendislik, Mimarlık ve Sağlık Bilimleri', [
            Kalip::toplam(500),
            Kalip::toplam(250, $DOC),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 250 puan (toplamın yarısı)',
                ['A.1-A.8'], 250, madde: 'Madde 8.1/e'),
            Kalip::puanDan('Doçentliğinizden sonraki makale ve kitap kalemlerinizden en az 125 puan',
                ['A.1-A.8'], 125, $DOC, madde: 'Madde 8.1/e'),
            Kalip::adet('Doçentliğinizden sonra SCI-E, SSCI veya AHCI dergide en az 2 yayın',
                ['A.1'], 2, donem: $DOC, madde: 'Madde 8.1/c'),
            Kalip::beyan('En az 2 eserinize SCI-E, AHCI, ESCI veya SSCI dergilerinde toplam 30 atıf '
                .'yapılmış olmak; atıfı bulunmayanların tüm eserlerine (tezler hariç) en az 40 '
                .'uluslararası veya ulusal atıf yapılmış olması', 'Madde 8.1/d'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az 5 yıl süreyle ilgili bilim '
                .'alanında çalışmış olmak', 'Madde 8.1/a'),
        ]),
    ],
    [
        'anahtar' => 'bitlis-profesor-sosyal',
        'aday_notu' => 'Yayın koşulunun üç alternatifi var; herhangi birini sağlamanız '
            .'yeterli. Atıf koşulu beyan olarak duruyor: en az 2 eserinize '
            .'SCI-E/AHCI/ESCI/SSCI dergilerinde 30 atıf, bu yoksa tüm eserlerinize en az 40 atıf. '
            .'Hiçbirini sağlamıyorsanız dizinli dergilerden 2 yayın daha yapmanız zorunlu.',
        'universite' => 'Bitlis Eren Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $sosyalGrubu,
        'cetvel' => 'bitlis-2024',
        'notlar' => 'Madde 8.1: toplam 400, doçentlik sonrası en az 200; toplamın %50\'si (200) '
            .'ve doçentlik sonrası puanın %50\'si (100) yayın kalemlerinden; ayrıca yayın koşulunun üç '
            .'yayın alternatifinden biri.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler ve Eğitim Bilimleri', [
            Kalip::toplam(400),
            Kalip::toplam(200, $DOC),
            Kalip::puanDan('Makale ve kitap kalemlerinizden en az 200 puan (toplamın yarısı)',
                ['A.1-A.8'], 200, madde: 'Madde 8.1/e'),
            Kalip::puanDan('Doçentliğinizden sonraki makale ve kitap kalemlerinizden en az 100 puan',
                ['A.1-A.8'], 100, $DOC, madde: 'Madde 8.1/e'),
            Kalip::veya('Doçentliğinizden sonra aşağıdaki yayın seçeneklerinden birini sağlamak', [
                Kalip::ve('SCI-E/SSCI/AHCI dergide 1 ve TR Dizin dergide 1 yayın', [
                    Kalip::adet('SCI-E, SSCI veya AHCI dergide en az 1 yayın',
                        ['A.1'], 1, donem: $DOC, madde: 'Madde 8.1/c'),
                    Kalip::adet('TR Dizin dergide en az 1 yayın',
                        ['A.5'], 1, donem: $DOC, madde: 'Madde 8.1/c'),
                ]),
                Kalip::adet('Uluslararası alan indeksli ve/veya TR Dizin dergilerde toplam en az 3 yayın',
                    ['A.2', 'A.5'], 3, donem: $DOC, madde: 'Madde 8.1/c'),
                Kalip::ve('TR Dizin dergide 2 yayın ve uluslararası yayınevinden 1 kitap', [
                    Kalip::adet('TR Dizin dergide en az 2 yayın',
                        ['A.5'], 2, donem: $DOC, madde: 'Madde 8.1/c'),
                    Kalip::adet('Uluslararası yayınevince basılmış en az 1 kitap',
                        ['A.7.1'], 1, donem: $DOC, madde: 'Madde 8.1/c'),
                ]),
            ]),
            Kalip::beyan('En az 2 eserinize SCI-E, AHCI, ESCI veya SSCI dergilerinde toplam 30 atıf '
                .'yapılmış olmak; atıfı bulunmayanların tüm eserlerine (tezler hariç) en az 40 '
                .'uluslararası veya ulusal atıf yapılmış olması', 'Madde 8.1/d'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az 5 yıl süreyle ilgili bilim '
                .'alanında çalışmış olmak', 'Madde 8.1/a'),
        ]),
    ],
];
