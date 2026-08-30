<?php

/**
 * ÜSKÜDAR ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Ölçütleri
 * Yönergesi
 * Kaynak: pdf/17537104342.uskudaruniversitesi.pdf
 *
 * BELGEDE TARİH YOK: MADDE 19 yürürlüğü YÖK Genel Kurulu onayına bağlıyor ama
 * tarih vermiyor. MADDE 18, 20.04.2017 tarihli önceki esasları yürürlükten
 * kaldırıyor; cetvel dosyasının adındaki 2024 PDF'in oluşturma tarihinden.
 *
 * ── HER KADRODA İKİ KATMANLI PUAN, ÜSTÜNE DÖRT SAYI KOŞULU ──
 * Alan ayrımı ve birim ayrımı yok. Barajlar iç içe: bir toplam ve onun içinden
 * bilimsel yayınlara düşen pay.
 *
 *   Dr. Öğr. Üyesi  toplam 150, en az 100'ü bilimsel yayınlardan
 *   Doçent          toplam 300, en az 150'si bilimsel yayınlardan
 *   Profesör        toplam 500, en az 300'ü bilimsel yayınlardan
 *                   (doçentlik unvanı alındıktan SONRA)
 *   Dr. görev uzatma  son atamadan sonraki üç yılda 80 puan
 *
 * ── "BİLİMSEL YAYIN" KÜMESİ YORUMLANDI ──
 * Koşullar "bunun asgari N puanının ilgili alanda üretilen BİLİMSEL
 * YAYINLARDAN sağlanmış olması" diyor ama kümeyi tanımlamıyor. Puanlama
 * tablosunun MADDE 1'i "YAYIN/ESER/EDİTÖRLÜK/HAKEMLİK/ATIF" başlığını taşıyor,
 * yani başlığın kendisi yayın ve eseri editörlük, hakemlik ve atıftan
 * ayırıyor. Küme buna göre MADDE 1'in 1-6. bölümleriyle (dergi yayınları,
 * kitaplar, yaratıcı eserler) sınırlandı; editörlük-hakemlik (7), bildiri
 * sunumu (8) ve atıf (9) dışarıda kaldı.
 *
 * Bu dar okuma bilinçli: iki okumadan adayı daha hazır göstermeyeni bu.
 * Bildirilerin kümeye girip girmediği tartışmalı olduğu için aday notunda
 * söylendi.
 *
 * ── PROFESÖRLÜKTE BÜTÜN KOŞULLAR DOÇENTLİK SONRASI ──
 * MADDE 15'te (b) bendinden sonra ayrı bir satır olarak "Doçentlik unvanı
 * aldıktan sonra;" yazıyor ve ardından (c), (d), (f), (e) bentleri geliyor.
 * Dönem nitelemesi bu dört bendin tamamına bağlı; puan barajı da yayın sayısı
 * koşulları da doçentlik sonrasına uygulandı.
 *
 * KAYNAKTA BENT SIRASI BOZUK: maddede bentler c, d, f, e sırasıyla basılmış.
 * Düzeltilmedi, kodlarda kaynağın harfleri korundu.
 *
 * ── TEZDEN ÜRETİLMİŞ YAYIN KOŞULU AYNA SATIRLARLA ÇÖZÜLDÜ ──
 * MADDE 13/d "doktora tezinden üretilmiş en az bir yayın" istiyor ama puanlama
 * tablosunda tezden üretilmiş yayın için ayrı satır yok. Cetvele altı ayna
 * satır (TZ.1-TZ.6) eklendi; puanları karşılık geldikleri satırlarla aynı,
 * tek işlevleri bu koşulu değerlendirilebilir kılmak. Aday çalışmayı "tez
 * yayını" olarak kaydetmezse koşul sağlanmamış görünür; aday notunda söylendi.
 *
 * ── DOÇENTLİK VE PROFESÖRLÜKTE "TEK YA DA İLK İSİM" KİTAP KOŞULU ──
 * MADDE 14/d ve 15/f kitabın tek ya da ilk isimli olmasını istiyor; motorun
 * `yazar: 'ilk'` süzgeci tam bunu tanıyor (tek yazar ve birinci isim).
 *
 * ── PROJE KOŞULLARI KADRODAN KADROYA DARALIYOR ──
 *   Dr.       başvuru süreci tamamlanmış projede YÜRÜTÜCÜ YA DA ARAŞTIRMACI
 *   Doçent    dış kaynaklı projede yürütücü ya da araştırmacı YA DA patent
 *             başvurusu
 *   Profesör  dış kaynaklı projede YALNIZCA YÜRÜTÜCÜ ya da patent sahibi
 * Doçentlikteki "patent başvurusu" ile profesörlükteki "patent sahibi"
 * arasındaki fark kayıtta yok; ikisi de patent satırlarına bağlandı ve
 * doçentlik dalı olduğundan ZOR görünebilir (başvurusu süren patent
 * kaydedilemiyor).
 *
 * "DIŞ KAYNAKLI OLMAK" KAYDI UYGULANAMADI: doçentlik ve profesörlükte proje
 * koşulu "dış kaynaklı olmak koşuluyla" diyor, yani üniversitenin kendi BAP
 * projeleri sayılmamalı. Faaliyet kaydı BAP'ı ayrı bir kaynak olarak tutuyor
 * ama proje satırları tür bazında toplandığı için ayrım koşula
 * yansıtılamadı; koşul o yönde KOLAY görünür.
 *
 * ── GÖREV UZATMADA ÜÇ YIL DEĞİL SON ATAMA KULLANILDI ──
 * MADDE 17 "son atanma tarihinden itibaren geçen üç yıllık süre içerisinde"
 * diyor. Doktor öğretim üyeliğinin görev süresi zaten en çok üç yıl (MADDE
 * 17 giriş cümlesi), yani iki ifade örtüşüyor; `SON_ATAMA_SONRASI` kullanıldı
 * ve böylece atama tarihini girmiş adayda pencere birebir doğru çalışıyor.
 *
 * ── ALAN KAPSAMI ──
 * Yönerge hiçbir temel alanı ayırmıyor, hiçbirini dışlamıyor; MADDE 2
 * ölçütlerin "fakülte, enstitü, meslek yüksekokulu ve diğer akademik
 * birimler" için geçerli olduğunu söylüyor. On iki alanın hepsine yazıldı.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 9'un yabancı dil hükmü: "Türkçe veya İngilizce eğitim yapılan
 *       bölüm/program başvurularında yabancı dil…" — asgari puan vermiyor,
 *       programa bağlı. Uydurulmadı.
 *   MADDE 11 ve 12'nin jüri ve değerlendirme usulü, MADDE 6-8'in kadro ilanı
 *       ve başvuru süreci.
 *   MADDE 15/b'nin yurt dışında doçentlik unvanı alanlar için denklik
 *       hükmü — adayın durumuna bağlı bir usul kuralı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/uskudar-2024.php
 */

use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

/** Yönerge alan ayrımı yapmıyor. */
$tumAlanlar = array_column(TemelAlan::cases(), 'value');

$yayinListesi = 'Makale, kitap ve yaratıcı eser';

$yayinKumesiNotu = 'Yönerge "bilimsel yayın" kümesini tanımlamıyor; puanlama tablosunun ilgili '
    .'maddesi başlığında yayın ve eseri editörlük, hakemlik ve atıftan ayırdığı için küme '
    .'burada dergi yayınları, kitaplar ve yaratıcı eserlerle sınırlandı. Bildirileriniz genel '
    .'toplama girer ama bu alt kapıya girmez; üniversiteye teyit ettirin.';

$tezNotu = 'Doktora tezinizden ürettiğiniz yayını "tez yayını" olarak kaydedin: koşul ancak '
    .'öyle değerlendirilebiliyor. Puanı değişmez, kendi yayın türünüzle aynı puanı alır.';

$carpanNotu = 'Yazar çarpanı yalnızca sıranıza bağlı: tek yazarlı tam puan, birinci isimde '
    .'%80, ikincide %60, üçüncüde %40, dördüncü ve sonrasında %20. Yazar sayısı hesaba '
    .'girmiyor.';

$projeNotu = 'Yönerge projenin "dış kaynaklı" olmasını istiyor, yani üniversitenin kendi BAP '
    .'projeleri sayılmamalı; bu ayrım burada uygulanamadığı için koşul olduğundan kolay '
    .'görünebilir.';

return [
    [
        'anahtar' => 'uskudar-dr',
        'aday_notu' => 'Beş koşul var: toplam 150 puan, bunun en az 100\'ü bilimsel '
            .'yayınlardan; TR Dizin\'de en az bir makale; doktora tezinizden üretilmiş en az '
            .'bir yayın; ve başvuru süreci tamamlanmış bir projede yürütücü ya da araştırmacı '
            .'olarak görev almış olmak. '.$yayinKumesiNotu.' '.$tezNotu.' '.$carpanNotu,
        'universite' => 'Üsküdar Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $tumAlanlar,
        'cetvel' => 'uskudar-2024',
        'notlar' => 'MADDE 13: "b) Ek 1\'de belirtilen akademik ve bilimsel faaliyetlerden '
            .'toplamda en az 150 puan almış olup, bunun asgari 100 puanın ilgili alanda '
            .'üretilen bilimsel yayınlardan sağlanmış olması, c) Ulusal dizinli dergide en az '
            .'bir makale yayımlamış olmak, d) Doktora tezinden üretilmiş en az bir yayını '
            .'bulunmak, e) Başvuru süreci tamamlanmış ulusal ya da uluslararası bir projede '
            .'yürütücü ya da araştırmacı olarak görev almış olmak." Dönem kısıtı yok.',
        'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna atanma', [
            Kalip::beyan(
                'İlgili alanda tıpta uzmanlık, doktora ya da sanatta yeterlik derecesini almış olmak',
                'Madde 13/a',
            ),
            Kalip::toplam(150),
            Kalip::puanDan(
                $yayinListesi.' kalemlerinizden en az 100 puan',
                ['BILIMSEL-YAYIN'], 100, madde: 'Madde 13/b',
            ),
            Kalip::adet(
                'Ulusal dizinli (TR Dizin) dergide en az 1 makale',
                ['ULUSAL-DIZIN'], 1, madde: 'Madde 13/c',
            ),
            Kalip::adet(
                'Doktora tezinizden üretilmiş en az 1 yayın (kitap, kitap bölümü, makale ya '
                .'da tam metni basılmış bildiri)',
                ['TEZDEN-URETILMIS'], 1, madde: 'Madde 13/d',
            ),
            Kalip::adet(
                'Ulusal ya da uluslararası bir projede yürütücü veya araştırmacı olarak görev almak',
                ['PROJE-YURUTUCU-ARASTIRMACI'], 1, madde: 'Madde 13/e',
            ),
        ]),
    ],
    [
        'anahtar' => 'uskudar-dr-yeniden',
        'aday_notu' => 'Doktor öğretim üyeliğinin görev süresi en çok üç yıl; uzatma için üç '
            .'koşul da SON ATAMANIZDAN SONRAKİ çalışmalarınıza bakıyor: tablodan 80 puan, '
            .'Scopus ya da WoS dergilerinde en az bir özgün makale ya da onun yerine '
            .'TR Dizin dergilerinde en az iki makale, ve bir proje ya da patent başvurusu. '
            .'Son atama tarihinizi profilinize girmezseniz bu eşik hesaplanamaz. '.$carpanNotu,
        'universite' => 'Üsküdar Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $tumAlanlar,
        'cetvel' => 'uskudar-2024',
        'notlar' => 'MADDE 17: "a) Son atanma tarihinden itibaren geçen üç yıllık süre '
            .'içerisinde … en az 80 puan sağlamış olmak, b) … A grubu uluslararası dergilerde '
            .'en az bir özgün makale/derleme ya da ulusal dizinli hakemli bilimsel dergide en '
            .'az iki özgün makale yayımlamış olmak, c) Son atanma tarihinden itibaren ulusal '
            .'ya da uluslararası düzeyde bir proje ya da patent başvurusunda bulunmuş olmak." '
            .'Görev süresi zaten en çok üç yıl olduğu için dönem son atama sonrası okundu.',
        'sart' => Kalip::ve('Doktor Öğretim Üyeliğinde görev uzatma', [
            Kalip::toplam(80, $SON_ATAMA),
            Kalip::veya('Son atamanızdan sonra yayın koşulu', [
                Kalip::adet(
                    'Scopus ya da WoS dergilerinde en az 1 makale ya da derleme',
                    ['A-GRUBU-DERGI'], 1, donem: $SON_ATAMA, madde: 'Madde 17/b',
                ),
                Kalip::adet(
                    'Ulusal dizinli (TR Dizin) dergilerde en az 2 özgün makale',
                    ['ULUSAL-DIZIN'], 2, donem: $SON_ATAMA, madde: 'Madde 17/b',
                ),
            ]),
            Kalip::veya('Son atamanızdan sonra proje ya da patent', [
                Kalip::adet(
                    'Ulusal ya da uluslararası düzeyde en az 1 proje',
                    ['PROJE'], 1, donem: $SON_ATAMA, madde: 'Madde 17/c',
                ),
                Kalip::adet(
                    'En az 1 patent ya da faydalı model başvurusu',
                    ['PATENT'], 1, donem: $SON_ATAMA, madde: 'Madde 17/c',
                ),
            ]),
        ]),
    ],
    [
        'anahtar' => 'uskudar-docent',
        'aday_notu' => 'Beş koşul var: ÜAK doçentlik unvanı, toplam 300 puan (en az 150\'si '
            .'bilimsel yayınlardan), Scopus ya da WoS taranan dergilerde en az iki makale, '
            .'tek ya da ilk isim olduğunuz en az bir kitap veya kitap bölümü, ve bir projede '
            .'yürütücü/araştırmacı olmak ya da patent başvurusu yapmış olmak. Yönerge dönem '
            .'kısıtı koymuyor; doktoradan önceki çalışmalarınız da sayılıyor. '
            .$yayinKumesiNotu.' '.$projeNotu.' '.$carpanNotu,
        'universite' => 'Üsküdar Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => 'uskudar-2024',
        'notlar' => 'MADDE 14: "b) … en az 300 puan almış olup, bunun asgari 150 puanının '
            .'ilgili alanda üretilen bilimsel yayınlardan sağlanmış olması, c) SCOPUS veya '
            .'WoS kapsamında taranan dergilerde en az iki makale yayımlamış olmak, d) Tek ya '
            .'da ilk isim olarak yer alınan, telif ya da derleme niteliğinde olmak üzere '
            .'ilgili alanda en az bir kitap/kitap bölümü yayımlamış bulunmak, e) Dış kaynaklı '
            .'olmak koşuluyla … en az bir uluslararası/ulusal projede yürütücü ya da '
            .'araştırmacı olarak yer almak ya da patent başvurusu yapmış olmak." Dönem kısıtı '
            .'yok. "Dış kaynaklı" kaydı uygulanamadı.',
        'sart' => Kalip::ve('Doçent kadrosuna atanma', [
            Kalip::beyan(
                'Üniversitelerarası Kurul bünyesinde yapılan doçentlik sınavından başarılı '
                .'olmuş ve doçent unvanını almış olmak',
                'Madde 14/a',
            ),
            Kalip::toplam(300),
            Kalip::puanDan(
                $yayinListesi.' kalemlerinizden en az 150 puan',
                ['BILIMSEL-YAYIN'], 150, madde: 'Madde 14/b',
            ),
            Kalip::adet(
                'Scopus ya da WoS taranan dergilerde en az 2 makale',
                ['A-GRUBU-DERGI'], 2, madde: 'Madde 14/c',
            ),
            Kalip::adet(
                'Tek ya da ilk isim olduğunuz en az 1 kitap veya kitap bölümü',
                ['KITAP'], 1, 'ilk', madde: 'Madde 14/d',
            ),
            Kalip::veya('Proje ya da patent koşulu', [
                Kalip::adet(
                    'En az 1 projede yürütücü ya da araştırmacı olarak yer almak',
                    ['PROJE-YURUTUCU-ARASTIRMACI'], 1, madde: 'Madde 14/e',
                ),
                Kalip::adet(
                    'En az 1 patent ya da faydalı model başvurusu',
                    ['PATENT'], 1, madde: 'Madde 14/e',
                ),
            ]),
        ]),
    ],
    [
        'anahtar' => 'uskudar-profesor',
        'aday_notu' => 'Bütün sayısal koşullar DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınıza '
            .'bakıyor: toplam 500 puan (en az 300\'ü bilimsel yayınlardan), Scopus ya da WoS '
            .'taranan dergilerde en az üç makale (en az birinde ilk isim), tek ya da ilk isim '
            .'olduğunuz en az bir bilimsel telif kitap veya kitap bölümü, ve bir projede '
            .'YÜRÜTÜCÜ olarak yer almak ya da patent sahibi olmak. Ayrıca doçentliğinizden '
            .'sonra en az beş yıl ilgili alanda görev yapmış olmanız gerekiyor. '
            .$yayinKumesiNotu.' '.$projeNotu.' '.$carpanNotu,
        'universite' => 'Üsküdar Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $tumAlanlar,
        'cetvel' => 'uskudar-2024',
        'notlar' => 'MADDE 15: "Doçentlik unvanı aldıktan sonra; c) … en az 500 puan almış '
            .'olup, bunun asgari 300 puanının ilgili alanda üretilen bilimsel yayınlardan '
            .'sağlanmış olması, d) SCOPUS veya WoS kapsamında taranan dergilerde, en az bir '
            .'tanesinde ilk isim olarak yer almak üzere, asgari üç makale yayımlamış olmak, '
            .'f) İlgili alanda, tek ya da ilk isim olarak yer alınan, en az bir bilimsel telif '
            .'kitap/kitap bölümü yayımlamış bulunmak, e) Dış kaynaklı olmak koşuluyla … en az '
            .'bir uluslararası/ulusal projede yürütücü olarak yer almak ya da patent sahibi '
            .'olmak." Kaynakta bent sırası c, d, f, e biçiminde basılmış; dönem nitelemesi '
            .'dört bendin tamamını kapsıyor.',
        'sart' => Kalip::ve('Profesör kadrosuna atanma', [
            Kalip::beyan(
                'Doçent unvanını aldıktan sonra ilgili bilim alanında bir üniversitede ya da '
                .'bilimsel nitelikteki bir kuruluşta en az beş yıl görev yapmış olmak',
                'Madde 15/a',
            ),
            Kalip::toplam(500, $DOC),
            Kalip::puanDan(
                $yayinListesi.' kalemlerinizden doçentlik unvanınızdan sonra en az 300 puan',
                ['BILIMSEL-YAYIN'], 300, $DOC, madde: 'Madde 15/c',
            ),
            Kalip::adet(
                'Doçentliğinizden sonra Scopus ya da WoS taranan dergilerde en az 3 makale',
                ['A-GRUBU-DERGI'], 3, donem: $DOC, madde: 'Madde 15/d',
            ),
            Kalip::adet(
                'Bunların en az 1 tanesinde ilk isim olmak',
                ['A-GRUBU-DERGI'], 1, 'ilk', $DOC, madde: 'Madde 15/d',
            ),
            Kalip::adet(
                'Doçentliğinizden sonra tek ya da ilk isim olduğunuz en az 1 bilimsel telif '
                .'kitap veya kitap bölümü',
                ['KITAP'], 1, 'ilk', $DOC, madde: 'Madde 15/f',
            ),
            Kalip::veya('Proje ya da patent koşulu', [
                Kalip::adet(
                    'Doçentliğinizden sonra en az 1 projede yürütücü olarak yer almak',
                    ['PROJE-YURUTUCU'], 1, donem: $DOC, madde: 'Madde 15/e',
                ),
                Kalip::adet(
                    'Doçentliğinizden sonra en az 1 patent ya da faydalı model sahibi olmak',
                    ['PATENT'], 1, donem: $DOC, madde: 'Madde 15/e',
                ),
            ]),
        ]),
    ],
];
