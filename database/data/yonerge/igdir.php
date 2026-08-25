<?php

/**
 * IĞDIR ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Kriterleri Yönergesi
 * Kaynak: pdf/17536996342.igdiruniverstesi.pdf (A-D bölümleri + EK-1)
 * Senato: 05.11.2020 / 2020.42.196 · 24.11.2020 / 2020.45.208 ·
 *         25.04.2023 / 2023.20.63 (Değişik) — YÖK 18.05.2023 / 24269
 *
 * DÖRT ALAN GRUBU, HEPSİ YÖNERGENİN KENDİ ADLANDIRMASI:
 *   Fen ve Sağlık bilimleri · Sosyal bilimler · Güzel Sanatlar · Spor bilimleri
 *
 * BAŞKA ALAN İÇİN EŞİK YAZILMADI. Yönerge mühendislik, ziraat, eğitim, hukuk,
 * ilahiyat, filoloji ve mimarlıktan hiç söz etmiyor; "Fen ve Sağlık" grubuna
 * mühendislik ve ziraatı katmak Iğdır'ın en kalabalık fakültesindeki adaya
 * yönergede yazmayan bir makale barajı göstermek olurdu. Bu alanlar kapsam
 * dışı görünür; Yönerge Analizi sayfası bunu zaten listeliyor.
 *
 * PUAN BARAJLARI (EK-1 toplamı):
 *                        Dr.    Doçent   Profesör
 *   Fen ve Sağlık        500     2000      3000
 *   Sosyal               300     2000      3000
 *   Güzel Sanatlar       300     2000      3000
 *   Spor                 300     2000      3000
 * Doçent ve profesörlükte toplam baraj alandan bağımsız; alan farkı SAYI ve
 * ALT BARAJ koşullarında.
 *
 * ÜÇ KATMANLI PROFESÖRLÜK: toplam 3000 (A-5) + öğretim, tez ve proje
 * kalemlerinden 500 (A-4) + alana özgü eser koşulu (A-3). Spor ve Güzel
 * Sanatlar'da alana özgü koşulun kendisi de bir puan barajı (doçentlik
 * sonrası 1500 / 1000), bu yüzden o iki alanda iki ayrı toplam düğümü var.
 *
 * "EK OLARAK" KÜMÜLATİF OKUNDU: "Q1/Q2 dergilerinde yayımlamış 1 adet
 * makaleye ek olarak SCI… kapsamına giren dergilerde 5 adet özgün makale"
 * → aynı kümede toplam 6 makale, en az 1'i Q1/Q2. Q1/Q2 makalesi altının
 * içinde sayılıyor; iki düğüm ayrı ayrı sayıldığı için bu kendiliğinden
 * çalışıyor.
 *
 * MÜZİKOLOJİ ANABİLİM DALI: yönerge Güzel Sanatlar koşulunu "(Müzikoloji
 * Anabilim Dalı hariç)" diye yazıyor ama Müzikoloji için başka bir koşul
 * TANIMLAMIYOR. Güzel Sanatlar eşiği birim ayrımı olmadan girildi ve muafiyet
 * aday notunda söylendi; `birim` ile ayırmak, yerine geçecek koşulu
 * bilmediğimiz için Müzikoloji adayını tamamen kapsam dışına atardı.
 *
 * YENİDEN ATANMA GİRİLMEDİ (C bölümü): baraj atama döneminin UZUNLUĞUNA bağlı
 * (1 yıl 100 · 2 yıl 200 · 3 yıl 300 · 4 yıl 400 puan; %50'si 1-12,
 * %20'si 20-23 maddelerinden). Atama dönemi uzunluğu profilde tutulmuyor.
 * Güzel Sanatlar'ın "her yıl için en az bir özgün sanat üretimi", Spor'un
 * "her bir yıl için 150 puan" koşulları da aynı sebeple girilemedi.
 *
 * D BÖLÜMÜ (ÖZEL DURUMLAR) girilmedi: Üniversite Yönetim Kurulu önerisi ve
 * Rektör onayıyla bütün kriterler dikkate alınmadan atama yapılabiliyor.
 * Bu bir muafiyet yolu, adayın sağlayabileceği bir koşul değil.
 *
 * EK MADDE 2'nin bir defalık 15 puanı ("Dijital Çağda Yüksek Öğretimde
 * Öğretme ve Öğrenme" dersini tamamlamak) cetvele girmedi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/igdir-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$yenidenAtamaNotu = 'Yeniden atanma koşulu girilmedi: yönerge barajı atama döneminin '
    .'uzunluğuna bağlıyor (bir yıl için 100, dört yıl için 400 puan) ve atama dönemi '
    .'burada tutulmuyor.';

/** A-3(a) ve B-3(a): Fen ve Sağlık'ın makale kümesi, iki kadroda da aynı. */
$fenMakaleKosulu = fn (array $donem, string $madde): array => Kalip::ve(
    'SCI, SCI-Expanded, SSCI veya AHCI dergilerinde 6 özgün makale (en az 1\'i Q1-Q2)',
    [
        Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 6 özgün makale', ['SCI_MAKALE'], 6, donem: $donem, madde: $madde),
        Kalip::adet('Bunların en az 1\'i Q1 veya Q2 dergide olmalı', ['Q1_Q2'], 1, donem: $donem, madde: $madde),
    ],
);

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ ══════════════════
    [
        'anahtar' => 'igdir-dr-fen',
        'aday_notu' => 'Fen ve Sağlıkta baraj hem puan hem sayı: 500 puanın yanında '
            .'SCI kapsamındaki dergilerde dört makale ve bunların birinin Q1-Q2 olması '
            .'aranıyor. Tek bir Q1 makale 100 puan getiriyor. '.$yenidenAtamaNotu,
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['fen', 'saglik'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'C bölümü, İLK KEZ BAŞVURANLAR maddeleri 2 ve 3. "Akademik Etkinlik '
            .'Değerlendirme Tablosunda (Ek-1) belirtilen kriterlerden Fen ve Sağlık '
            .'Bilimlerinde en az 500 … puan almış olmak." + "Fen ve Sağlık bilimlerinde SCI, '
            .'SCI-Expanded, SSCI ve AHCI kapsamındaki dergilerde en az 1 (bir) adet Q1/Q2 '
            .'olmak üzere toplam 4 (Dört) adet makale yayımlamış olmak."',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma — Fen ve Sağlık Bilimleri', [
            Kalip::toplam(500),
            Kalip::adet('SCI, SCI-Expanded, SSCI veya AHCI dergilerinde en az 4 makale', ['SCI_MAKALE'], 4, madde: 'C-3'),
            Kalip::adet('Bunların en az 1\'i Q1 veya Q2 dergide olmalı', ['Q1_Q2'], 1, madde: 'C-3'),
        ]),
    ],
    [
        'anahtar' => 'igdir-dr-sosyal',
        'aday_notu' => 'Sosyal ve Spor alanlarında dergi indeksi şartı yok; dört makalenin '
            .'ulusal hakemli dergilerde olması yeterli. Kitap koşulu bir kitapla ya da iki '
            .'kitap bölümüyle karşılanabiliyor. '.$yenidenAtamaNotu,
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'spor'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'C bölümü, İLK KEZ BAŞVURANLAR maddeleri 2 ve 4. "Güzel Sanatlar, Spor ve '
            .'Sosyal bilimlerde en az 300 puan" + "Sosyal ve Spor bilimleri alanında ise ulusal '
            .'veya uluslararası hakemli dergilerde yayınlanmış en az 4 (Dört) adet makale ve '
            .'1 (bir) adet kitap/2 (iki) kitap bölümü yayınlamış olmak."',
        'sart' => Kalip::ve('Dr. Öğr. Üyeliğine ilk atanma — Sosyal ve Spor Bilimleri', [
            Kalip::toplam(300),
            Kalip::adet('Ulusal veya uluslararası hakemli dergilerde en az 4 makale', ['HAKEMLI_MAKALE'], 4, madde: 'C-4'),
            Kalip::veya('En az 1 kitap ya da 2 kitap bölümü', [
                Kalip::adet('En az 1 kitap', ['KITAP'], 1, madde: 'C-4'),
                Kalip::adet('Ya da en az 2 kitap bölümü', ['KITAP_BOLUM'], 2, madde: 'C-4'),
            ]) + ['madde' => 'C-4'],
        ]),
    ],
    [
        'anahtar' => 'igdir-dr-guzel-sanatlar',
        'aday_notu' => 'Güzel Sanatlarda ilk atanmada yalnızca puan barajı var; makale ya da '
            .'kitap sayısı aranmıyor. Sanat etkinlikleri 25-150 puan arasında değerlendiriliyor. '
            .$yenidenAtamaNotu,
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'C bölümü, İLK KEZ BAŞVURANLAR maddesi 2. Güzel Sanatlar 300 puanlık grupta; '
            .'maddeler 3 ve 4 yalnızca Fen-Sağlık ile Sosyal-Spor için sayı koşulu getiriyor, '
            .'Güzel Sanatlar için eser sayısı şartı yok.',
        'sart' => Kalip::toplam(300),
    ],

    // ══════════════════ DOÇENT ══════════════════
    // B bölümü. Madde 2 ve 3 doktora sonrası; madde 4 (toplam 2000) dönemsiz.
    [
        'anahtar' => 'igdir-docent-fen',
        'aday_notu' => 'Doçentlikte iki ayrı kapı var: proje puanı ya da kitap (madde 2) ve '
            .'makale kümesi (madde 3). Proje koşulu 200 puanla ya da iki kitap / dört kitap '
            .'bölümüyle karşılanabiliyor.',
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['fen', 'saglik'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'B bölümü maddeleri 2, 3(a), 4, 5. "Doktora sonrasında yapılmış olması '
            .'kaydıyla … 22-23 maddelerinden en az 200 puan almış olmak veya alanı ile ilgili '
            .'özgün en az 2 (iki) adet kitap / 4 (dört) adet kitap bölümü yazmış olmak." + '
            .'"Q1/Q2 dergilerinde yayınlanmış 1 (bir) adet makaleye ek olarak SCI, SCI-Expanded, '
            .'SSCI ve AHCI kapsamına giren dergilerde 5 (beş) adet özgün makale."',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Fen ve Sağlık Bilimleri', [
            Kalip::beyan('Üniversitelerarası Kurul\'un doçentlik başvuru koşullarını sağlamış ve doçent unvanını almış olmak', 'B-giriş'),
            Kalip::toplam(2000),
            Kalip::veya('Proje puanı ya da kitap koşulu', [
                Kalip::puanDan('Proje kalemlerinizden en az 200 puan', ['22-23'], 200, $DOKTORA, madde: 'B-2'),
                Kalip::adet('Ya da en az 2 kitap', ['KITAP'], 2, donem: $DOKTORA, madde: 'B-2'),
                Kalip::adet('Ya da en az 4 kitap bölümü', ['KITAP_BOLUM'], 4, donem: $DOKTORA, madde: 'B-2'),
            ]) + ['madde' => 'B-2'],
            $fenMakaleKosulu($DOKTORA, 'B-3/a'),
            Kalip::beyan('İlk defa doçent kadrosuna atanacaksanız Üniversite Yönetim Kurulu\'na 30 dakikalık alan sunumu yapıp başarılı olmak', 'B-5'),
        ]),
    ],
    [
        'anahtar' => 'igdir-docent-sosyal',
        'aday_notu' => 'Sosyal bilimlerde makale sayısı aranmıyor: iki kitap ya da tek bir '
            .'Q1-Q2 makale yeterli. Proje/kitap koşulu (madde 2) bunun üstüne ayrıca geliyor.',
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'B bölümü maddeleri 2, 3(b), 4, 5. "Sosyal bilimler alanında doktora '
            .'sonrasında yapılmış olması kaydıyla özgün araştırmadan üretilmiş ulusal ya da '
            .'uluslararası en az 2 (iki) adet kitap yayımlamış olmak veya Q1 / Q2 dergilerde '
            .'yayımlanmış en az 1 (bir) adet makaleye sahip olmak."',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Sosyal Bilimler', [
            Kalip::beyan('Üniversitelerarası Kurul\'un doçentlik başvuru koşullarını sağlamış ve doçent unvanını almış olmak', 'B-giriş'),
            Kalip::toplam(2000),
            Kalip::veya('Proje puanı ya da kitap koşulu', [
                Kalip::puanDan('Proje kalemlerinizden en az 200 puan', ['22-23'], 200, $DOKTORA, madde: 'B-2'),
                Kalip::adet('Ya da en az 2 kitap', ['KITAP'], 2, donem: $DOKTORA, madde: 'B-2'),
                Kalip::adet('Ya da en az 4 kitap bölümü', ['KITAP_BOLUM'], 4, donem: $DOKTORA, madde: 'B-2'),
            ]) + ['madde' => 'B-2'],
            Kalip::veya('Özgün araştırmadan üretilmiş 2 kitap ya da 1 Q1-Q2 makale', [
                Kalip::adet('Özgün bir araştırmadan üretilmiş en az 2 kitap', ['KITAP'], 2, donem: $DOKTORA, madde: 'B-3/b'),
                Kalip::adet('Ya da Q1 veya Q2 dergide en az 1 makale', ['Q1_Q2'], 1, donem: $DOKTORA, madde: 'B-3/b'),
            ]) + ['madde' => 'B-3/b'],
            Kalip::beyan('İlk defa doçent kadrosuna atanacaksanız Üniversite Yönetim Kurulu\'na 30 dakikalık alan sunumu yapıp başarılı olmak', 'B-5'),
        ]),
    ],
    [
        'anahtar' => 'igdir-docent-guzel-sanatlar',
        'aday_notu' => 'Güzel Sanatlarda alana özgü koşul bir alt baraj: sanat etkinliklerinden '
            .'doktora sonrası 600 puan. Yönerge bu koşulu Müzikoloji Anabilim Dalı için '
            .'aramıyor ama yerine geçecek bir koşul da tanımlamıyor.',
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'B bölümü maddeleri 2, 3(c), 4, 5. "Güzel Sanatlar alanında (Müzikoloji '
            .'Anabilim Dalı hariç) doktora sonrasında yapılmış olması kaydıyla Akademik Etkinlik '
            .'Değerlendirme Tablosunda yer alan (Ek-1) 6 ve 7. maddelerden en az 600 puan almış '
            .'olmak."',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Güzel Sanatlar', [
            Kalip::beyan('Üniversitelerarası Kurul\'un doçentlik başvuru koşullarını sağlamış ve doçent unvanını almış olmak', 'B-giriş'),
            Kalip::toplam(2000),
            Kalip::veya('Proje puanı ya da kitap koşulu', [
                Kalip::puanDan('Proje kalemlerinizden en az 200 puan', ['22-23'], 200, $DOKTORA, madde: 'B-2'),
                Kalip::adet('Ya da en az 2 kitap', ['KITAP'], 2, donem: $DOKTORA, madde: 'B-2'),
                Kalip::adet('Ya da en az 4 kitap bölümü', ['KITAP_BOLUM'], 4, donem: $DOKTORA, madde: 'B-2'),
            ]) + ['madde' => 'B-2'],
            Kalip::puanDan('Sanat etkinliklerinizden en az 600 puan', ['6-7'], 600, $DOKTORA, madde: 'B-3/c'),
            Kalip::beyan('İlk defa doçent kadrosuna atanacaksanız Üniversite Yönetim Kurulu\'na 30 dakikalık alan sunumu yapıp başarılı olmak', 'B-5'),
        ]),
    ],
    [
        'anahtar' => 'igdir-docent-spor',
        'aday_notu' => 'Spor bilimlerinde alana özgü koşul eser türüne değil puana bakıyor: '
            .'doktora sonrası üretilmiş çalışmalardan 1000 puan. Bu, 2000 puanlık genel '
            .'barajın yarısının doktora sonrasına düşmesi anlamına geliyor.',
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['spor'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'B bölümü maddeleri 2, 3(d), 4, 5. "Spor bilimleri alanında doktora '
            .'sonrasında yapılmış olması kaydıyla Akademik Etkinlik Değerlendirme Tablosundan '
            .'(Ek-1) en az 1000 puan almış olmak."',
        'sart' => Kalip::ve('Doçent kadrosuna atanma — Spor Bilimleri', [
            Kalip::beyan('Üniversitelerarası Kurul\'un doçentlik başvuru koşullarını sağlamış ve doçent unvanını almış olmak', 'B-giriş'),
            Kalip::toplam(2000),
            Kalip::toplam(1000, $DOKTORA),
            Kalip::veya('Proje puanı ya da kitap koşulu', [
                Kalip::puanDan('Proje kalemlerinizden en az 200 puan', ['22-23'], 200, $DOKTORA, madde: 'B-2'),
                Kalip::adet('Ya da en az 2 kitap', ['KITAP'], 2, donem: $DOKTORA, madde: 'B-2'),
                Kalip::adet('Ya da en az 4 kitap bölümü', ['KITAP_BOLUM'], 4, donem: $DOKTORA, madde: 'B-2'),
            ]) + ['madde' => 'B-2'],
            Kalip::beyan('İlk defa doçent kadrosuna atanacaksanız Üniversite Yönetim Kurulu\'na 30 dakikalık alan sunumu yapıp başarılı olmak', 'B-5'),
        ]),
    ],

    // ══════════════════ PROFESÖR ══════════════════
    // A bölümü. Madde 3 doçentlik sonrası; madde 4 ve 5 dönemsiz.
    [
        'anahtar' => 'igdir-profesor-fen',
        'aday_notu' => 'Profesörlükte üç katman birlikte aranıyor: 3000 puanlık genel toplam, '
            .'öğretim-tez-proje kalemlerinden 500 puan ve doçentlik sonrası altı makale. '
            .'Makalelerin üstüne ayrıca bir kitap ya da kitap bölümü isteniyor.',
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['fen', 'saglik'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'A bölümü maddeleri 2, 3(a), 4, 5, 6. "Profesörlük ana eseri olarak Fen ve '
            .'Sağlık bilimleri alanında … Q1/Q2 dergilerinde yayımlamış 1 (bir) adet makaleye ek '
            .'olarak SCI, SCI-Expanded SSCI ve AHCI kapsamına giren dergilerde 5 (beş) adet '
            .'özgün makale yayımlamış olmak ve alanı ile ilgili özgün en az 1 (bir) adet '
            .'kitap/kitap bölümü yazmış olmak."',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Fen ve Sağlık Bilimleri', [
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl, başvurduğunuz bilim alanında çalışmış olmak', 'A-2'),
            Kalip::toplam(3000),
            Kalip::puanDan('Ders, tez danışmanlığı ve proje kalemlerinizden en az 500 puan', ['20-23'], 500, madde: 'A-4'),
            $fenMakaleKosulu($DOCENTLIK, 'A-3/a'),
            Kalip::veya('En az 1 kitap ya da kitap bölümü', [
                Kalip::adet('Alanınızla ilgili özgün en az 1 kitap', ['KITAP'], 1, donem: $DOCENTLIK, madde: 'A-3/a'),
                Kalip::adet('Ya da en az 1 kitap bölümü', ['KITAP_BOLUM'], 1, donem: $DOCENTLIK, madde: 'A-3/a'),
            ]) + ['madde' => 'A-3/a'],
            Kalip::adet('Doçentlik sonrası en az 2 bilimsel toplantıda sunum yapmış olmak', ['BILDIRI'], 2, donem: $DOCENTLIK, madde: 'A-6'),
        ]),
    ],
    [
        'anahtar' => 'igdir-profesor-sosyal',
        'aday_notu' => 'Sosyal bilimlerde iki kitap zorunlu; makale tarafı esnek, üç hakemli '
            .'makale ya da tek bir Q1-Q2 makale yeterli.',
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'A bölümü maddeleri 2, 3(b), 4, 5, 6. "Sosyal bilimler alanında … özgün bir '
            .'araştırmadan üretilmiş ulusal ya da uluslararası en az 2 (iki) adet kitaba ek '
            .'olarak ulusal/uluslararası hakemli dergilerde en az 3 adet özgün makale veya '
            .'Q1/Q2 dergilerde yayımlanmış en az 1(bir) makalesi olmak."',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Sosyal Bilimler', [
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl, başvurduğunuz bilim alanında çalışmış olmak', 'A-2'),
            Kalip::toplam(3000),
            Kalip::puanDan('Ders, tez danışmanlığı ve proje kalemlerinizden en az 500 puan', ['20-23'], 500, madde: 'A-4'),
            Kalip::adet('Özgün bir araştırmadan üretilmiş en az 2 kitap', ['KITAP'], 2, donem: $DOCENTLIK, madde: 'A-3/b'),
            Kalip::veya('3 hakemli makale ya da 1 Q1-Q2 makale', [
                Kalip::adet('Ulusal veya uluslararası hakemli dergilerde en az 3 özgün makale', ['HAKEMLI_MAKALE'], 3, donem: $DOCENTLIK, madde: 'A-3/b'),
                Kalip::adet('Ya da Q1 veya Q2 dergide en az 1 makale', ['Q1_Q2'], 1, donem: $DOCENTLIK, madde: 'A-3/b'),
            ]) + ['madde' => 'A-3/b'],
            Kalip::adet('Doçentlik sonrası en az 2 bilimsel toplantıda sunum yapmış olmak', ['BILDIRI'], 2, donem: $DOCENTLIK, madde: 'A-6'),
        ]),
    ],
    [
        'anahtar' => 'igdir-profesor-guzel-sanatlar',
        'aday_notu' => 'Güzel Sanatlarda alana özgü koşul sanat etkinliklerinden doçentlik '
            .'sonrası 1000 puan. Yönerge bu koşulu Müzikoloji Anabilim Dalı için aramıyor ama '
            .'yerine geçecek bir koşul da tanımlamıyor.',
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'A bölümü maddeleri 2, 3(c), 4, 5, 6. "Güzel Sanatlar bilim alanında '
            .'(Müzikoloji Anabilim Dalı hariç) … Akademik Etkinlik Değerlendirme Tablosunda yer '
            .'alan (Ek-1) 6 ve 7. maddelerden en az 1000 puan almış olmak."',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Güzel Sanatlar', [
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl, başvurduğunuz bilim alanında çalışmış olmak', 'A-2'),
            Kalip::toplam(3000),
            Kalip::puanDan('Ders, tez danışmanlığı ve proje kalemlerinizden en az 500 puan', ['20-23'], 500, madde: 'A-4'),
            Kalip::puanDan('Sanat etkinliklerinizden en az 1000 puan', ['6-7'], 1000, $DOCENTLIK, madde: 'A-3/c'),
            Kalip::adet('Doçentlik sonrası en az 2 bilimsel toplantıda sunum yapmış olmak', ['BILDIRI'], 2, donem: $DOCENTLIK, madde: 'A-6'),
        ]),
    ],
    [
        'anahtar' => 'igdir-profesor-spor',
        'aday_notu' => 'Spor bilimlerinde 3000 puanlık genel barajın yanında doçentlik sonrası '
            .'üretilmiş çalışmalardan ayrıca 1500 puan isteniyor; yani toplamın yarısı '
            .'doçentlik sonrasına düşüyor.',
        'universite' => 'Iğdır Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['spor'],
        'cetvel' => 'igdir-2023',
        'notlar' => 'A bölümü maddeleri 2, 3(d), 4, 5, 6. "Spor bilimleri alanında Doçent '
            .'unvanının alınmasından sonraki çalışmalardan olması kaydıyla Akademik Etkinlik '
            .'Değerlendirme Tablosundan (Ek-1) en az 1500 puan almış olmak."',
        'sart' => Kalip::ve('Profesör kadrosuna atanma — Spor Bilimleri', [
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl, başvurduğunuz bilim alanında çalışmış olmak', 'A-2'),
            Kalip::toplam(3000),
            Kalip::toplam(1500, $DOCENTLIK),
            Kalip::puanDan('Ders, tez danışmanlığı ve proje kalemlerinizden en az 500 puan', ['20-23'], 500, madde: 'A-4'),
            Kalip::adet('Doçentlik sonrası en az 2 bilimsel toplantıda sunum yapmış olmak', ['BILDIRI'], 2, donem: $DOCENTLIK, madde: 'A-6'),
        ]),
    ],
];
