<?php

/**
 * İSTANBUL TİCARET ÜNİVERSİTESİ — Öğretim Elemanlarının Yükseltilmesi ve
 * Atanması Yönergesi
 * Kaynak: pdf/17537101122.istanbulticaretuniversitesi.pdf
 *
 * TEMEL ALAN AYRIMI YOK. Üç kadroda da aynı yapı: bir genel toplam ve bir
 * "I no'lu faaliyetler" (yayınlar) alt barajı; alt barajın bir bölümü de bir
 * önceki unvandan sonraki döneme ait olmalı.
 *
 *   Dr. Öğr. Üyesi   toplam  80 · yayınlardan  50
 *   Doçent           toplam 250 · yayınlardan 150 (100'ü Dr. Öğr. Üyeliği sonrası)
 *   Profesör         toplam 500 · yayınlardan 250 (150'si doçentlik sonrası)
 *
 * YÖNERGE "YARDIMCI DOÇENTLİK" TERİMİNİ KULLANIYOR. 2018 değişikliğinden önceki
 * adlandırma; korpusta `dr_ogr_uyesi` olarak girildi. Doçentlik koşulundaki
 * "yardımcı doçentlik sonrası" penceresi bu yüzden `SON_ATAMA_SONRASI` değil
 * `DOKTORA_SONRASI` ile karşılandı — Dr. Öğr. Üyeliğine atanma doktora
 * unvanını gerektirdiği için pencere fiilen aynı yere düşüyor, ama bu bir
 * yaklaşıklık: doktorasını alıp yıllarca Dr. Öğr. Üyesi olmayan adayda
 * pencere olduğundan GENİŞ açılır, yani baraj kolay görünür.
 *
 * YABANCI DİL KOŞULUNUN İKİ AYRI EŞİĞİ VAR (Madde 7/a-b): merkezî sınavdan 60
 * ya da üniversitenin kendi yeterlik sınavından 65. Motorun `yds` düğümü tek
 * eşik aldığı için merkezî sınav eşiği (60) yazıldı; üniversite sınavı
 * alternatifi aday notunda anıldı. Yabancı dilde lisans ya da doktora
 * yapanlardan dil puanı hiç aranmıyor, o da beyan.
 *
 * DENEME DERSİ KOŞULU BEYAN (Madde 7/d): bölüm başkanı ve bir öğretim üyesinden
 * oluşan jüri önünde deneme dersi vermek ve olumlu rapor almak.
 *
 * YENİDEN ATANMA GİRİLMEDİ (Madde 8-10): koşullar 30 Haziran-29 Haziran
 * dönemine ve performans değerlendirmesine bağlı; bu takvim profilde
 * tutulmuyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/istanbul-ticaret-2019.php
 */

use App\Services\Scoring\Sart\Kalip;

$DR = Kalip::DOKTORA_SONRASI;
$DOC = Kalip::DOCENTLIK_SONRASI;

$tumAlanlar = ['fen', 'muhendislik', 'mimarlik', 'saglik', 'spor', 'hukuk', 'ilahiyat',
    'filoloji', 'sosyal', 'egitim', 'guzel_sanatlar', 'ziraat'];

$yayinAd = 'Makale, bildiri, kitap, çeviri, editörlük ve atıf kalemlerinizden';

$dilNotu = 'Yabancı dil koşulunun iki eşiği var: merkezî sınavdan (YDS, KPDS, ÜDS) en az 60 ya '
    .'da üniversitenin kendi yeterlik sınavından en az 65. Burada merkezî sınav eşiği '
    .'gösteriliyor. Yabancı dilde lisans ya da doktora yaptıysanız dil puanı hiç aranmıyor.';

$yenidenAtamaNotu = 'Yeniden atanma değerlendirmesi 30 Haziran-29 Haziran dönemindeki '
    .'faaliyetlere ve performans değerlendirmesine bağlı; bu takvim burada tutulmadığı için '
    .'yeniden atanma eşiği girilmedi.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 7) ══════════
    [
        'anahtar' => 'istanbul-ticaret-dr',
        'aday_notu' => 'Yönerge bu kadroyu 2018 öncesi adlandırmayla "yardımcı doçentlik" diye '
            .'anıyor. '.$dilNotu.' '.$yenidenAtamaNotu,
        'universite' => 'İstanbul Ticaret Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'istanbul-ticaret-2019',
        'notlar' => 'Madde 7/c: Değerlendirme Kriterlerinden toplam 80 puan, bunun 50 puanı '
            .'I no\'lu (yayın) faaliyetlerden.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — İstanbul Ticaret Üniversitesi', [
            Kalip::yds(60),
            Kalip::toplam(80),
            Kalip::puanDan("{$yayinAd} en az 50 puan", ['I'], 50, madde: 'Madde 7/c'),
            Kalip::beyan('Bölüm ve anabilim dalı başkanı ile bir öğretim üyesinden oluşan jüri '
                .'önünde deneme dersi verip olumlu rapor almak', 'Madde 7/d'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 6) ══════════
    [
        'anahtar' => 'istanbul-ticaret-docent',
        'aday_notu' => 'Yayın barajının 100 puanı Dr. Öğr. Üyeliği (yönergedeki adıyla yardımcı '
            .'doçentlik) sonrasındaki çalışmalarınızdan gelmeli. Bu pencere burada doktora '
            .'tarihinizden başlatılıyor; doktoranızı alıp yıllar sonra Dr. Öğr. Üyesi olduysanız '
            .'baraj olduğundan kolay görünür.',
        'universite' => 'İstanbul Ticaret Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'istanbul-ticaret-2019',
        'notlar' => 'Madde 6: Değerlendirme Kriterlerinden toplam 250 puan; I no\'lu '
            .'faaliyetlerden 150 puan, bunun 100\'ü yardımcı doçentlik sonrası.',
        'sart' => Kalip::ve('Doçent — İstanbul Ticaret Üniversitesi', [
            Kalip::toplam(250),
            Kalip::puanDan("{$yayinAd} en az 150 puan", ['I'], 150, madde: 'Madde 6/b'),
            Kalip::puanDan("Doktoranızdan sonra {$yayinAd} en az 100 puan", ['I'], 100, $DR,
                madde: 'Madde 6/b'),
            Kalip::beyan('Üniversitelerarası Kurulca açılan doçentlik sınavında başarı '
                .'göstererek doçentlik unvanını almış olmak', 'Madde 3'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 5) ══════════
    [
        'anahtar' => 'istanbul-ticaret-profesor',
        'aday_notu' => 'Yayın barajının 150 puanı doçentlik unvanınızı aldıktan sonraki '
            .'çalışmalarınızdan gelmeli.',
        'universite' => 'İstanbul Ticaret Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'istanbul-ticaret-2019',
        'notlar' => 'Madde 5: Değerlendirme Kriterlerinden toplam 500 puan; I no\'lu '
            .'faaliyetlerden 250 puan, bunun 150\'si doçentlik sonrası.',
        'sart' => Kalip::ve('Profesör — İstanbul Ticaret Üniversitesi', [
            Kalip::toplam(500),
            Kalip::puanDan("{$yayinAd} en az 250 puan", ['I'], 250, madde: 'Madde 5/b'),
            Kalip::puanDan("Doçentliğinizden sonra {$yayinAd} en az 150 puan", ['I'], 150, $DOC,
                madde: 'Madde 5/b'),
            Kalip::beyan('Doçentlik unvanını aldıktan sonra açık bulunan profesörlük kadrosuyla '
                .'ilgili bilim alanında en az beş yıl çalışmış olmak', 'Madde 2'),
        ]),
    ],
];
