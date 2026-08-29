<?php

/**
 * KIRKLARELİ ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Kriterleri
 * Kaynak: pdf/1770040975746.kirklareli-kriter-02022026.pdf (18 sayfa)
 *         08/11/2018 tarih, 91 sayılı Senato toplantısının 1 no'lu karar eki;
 *         02 Ocak 2019 itibarıyla yürürlükte (MADDE 15).
 *
 * ÜÇ KADRO, ÜÇ AYRI AĞIRLIK. Kırklareli'nin ayırt edici yanı barajların
 * kadrolar arasındaki uçurumu: Dr. Öğr. Üyesi 200 puan, profesörlük 800 puan
 * (doçentlik sonrası), doçentlikte ise SAYISAL HİÇBİR KOŞUL YOK.
 *
 * DOÇENTLİKTE PUAN BARAJI DA YAYIN KOŞULU DA YOK (MADDE 7). Üç bendin üçü de
 * beyan: 657 sayılı Kanunun 48. maddesindeki genel şartlar, ÜAK doçentlik
 * unvanı ve yurt dışı denkliği. Puan tablosu var ama doçentlik onu hiç
 * kullanmıyor; `Kalip::toplam` bu kadroda kullanılmadı — kullanmak yönergede
 * olmayan bir baraj uydurmak olurdu.
 *
 * ALAN LİSTESİ SPOR VE ZİRAAT'I ANMIYOR. Hem MADDE 6/1-c hem MADDE 8/1-ç aynı
 * on bir alanı sayıyor (Mühendislik, Mesleki ve Teknik Eğitim, Fen Bilimleri
 * ve Matematik, Sağlık Bilimleri, Mimarlık-Planlama-Tasarım, Eğitim Bilimleri
 * ve Öğretmen Yetiştirme, Sosyal-Beşeri-İdari Bilimler, Filoloji, Hukuk,
 * İlahiyat, Sanat Alanları) — Spor Bilimleri ile Ziraat listede YOK. Bu iki
 * alan için Dr. Öğr. Üyesi ve profesörlük eşiği YAZILMADI; kapsam dışı
 * kalmaları doğrusu. Doçentlik MADDE 7 alan ayrımı yapmadığı için on iki
 * alanın hepsinde geçerli.
 *
 * PROFESÖRLÜKTE SANAT ALANLARININ KOŞULU DAHA GENİŞ (MADDE 6/1-c-2): öteki
 * alanlar "A bendi kapsamında en az iki yayın" isterken Sanat Alanları
 * "A, B, C, Ç, D ve E bendi kapsamında en az iki ÇALIŞMA" diyor — yani sanat
 * ve tasarım etkinlikleri de sayılıyor. Puan barajı ikisinde de 800.
 *
 * DR. ÖĞR. ÜYELİĞİNİN YAYIN KOŞULU ÜÇ KOLLU (MADDE 8/1-c): (i) A bendi,
 * B bendinin sözlü bildirileri ve C bendinin 1-6. maddeleri kapsamında en az
 * 2 yayın, (ii) kabul edilmiş DIŞ KAYNAKLI bir projede görev almış olmak,
 * (iii) en az altı ay yurt dışında araştırma. Üçüncü kol beyan: süre ve yer
 * bilgisi faaliyet kaydında yok.
 *
 * SÖZLÜ BİLDİRİ AYRIMI DARALTILDI (§0): koşul "B bendi (sadece sözlü
 * bildiriler)" diyor ama kayıtta özet ve poster tek etikete düşüyor
 * (uluslararası ve ulusal ikisi de). Sözlü olduğu kesin olan yalnız tam metin
 * satırları; küme onlarla sınırlandı. Sözlü sunulmuş özet bildirisi olan aday
 * gerçekte olduğundan bir yayın eksik görünür.
 *
 * YABANCI DİL: Dr. Öğr. Üyeliğinde ÜDS/KPDS/YDS/YÖKDİL 55 puan isteniyor,
 * "Sanat Alanları ve Meslek Yüksekokulları için bu koşul aranmaz" (MADDE
 * 8/1-d). Güzel Sanatlar eşiğine dil düğümü konmadı. MYO ayrımı yapılamadı:
 * temel alan meslek yüksekokulunu ayırmıyor, bu yüzden MYO adayı da alanının
 * dil koşulunu görüyor.
 *
 * KADRO EKSİĞİ İSTİSNASI BEYAN (MADDE 8/1-e): bir programdaki öğretim üyesi
 * sayısı YÖK'ün asgarisinin altındaysa yayın, puan ve dil koşulları hiç
 * aranmıyor. Program kadro durumu profilde yok; aday notunda anlatıldı.
 *
 * YENİDEN ATANMA GİRİLMEDİ (MADDE 8/2): baraj atama süresine bağlı (2 yıl
 * 200, 3 yıl 300, 4 yıl 400 puan) ve önceki atama tarihini istiyor; ikisi de
 * profilde tutulmuyor.
 *
 * PUANLAMA BAĞLAYICI DEĞİL (MADDE 12/1): yönerge "bu kriterlerde belirtilen
 * tanımlı puanlama sistemi, tek başına bir değerlendirme unsuru olarak
 * kullanılamaz; puanlamaya dayalı ön değerlendirme ve yayın koşulunun
 * sağlanmış olması adaylar için bağlayıcı bir hak oluşturmaz" diyor. Aday
 * notu bunu birebir aktarıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: kirklareli-2018
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;
$CETVEL = 'kirklareli-2018';
$UNI = 'Kırklareli Üniversitesi';

/** MADDE 6/1-c ile 8/1-ç'nin saydığı alanlar; Spor ve Ziraat listede yok. */
$bilimAlanlari = ['muhendislik', 'fen', 'saglik', 'mimarlik', 'egitim',
    'sosyal', 'filoloji', 'hukuk', 'ilahiyat'];
$tumAlanlar = [...$bilimAlanlari, 'guzel_sanatlar', 'spor', 'ziraat'];

$genelSartBeyani = Kalip::beyan('657 sayılı Devlet Memurları Kanununun 48. maddesindeki genel '
    .'şartlara sahip olmak', 'Madde 6/1-a, 7/1-a, 8/1-a');

$baglayiciDegil = 'Kırklareli yönergesi MADDE 12/1\'de puanlamanın tek başına bir '
    .'değerlendirme unsuru olmadığını, puan ve yayın koşulunu sağlamanın adaya bağlayıcı bir '
    .'hak vermediğini açıkça yazıyor. Buradaki sonuç ön değerlendirmedir; jüri raporu ayrıca '
    .'yayınlarınızın sürekliliğini, aldığınız atıfları ve eğitime katkınızı da değerlendiriyor.';

$kadroEksigi = 'Başvurduğunuz programdaki öğretim üyesi ve öğretim görevlisi sayısı YÖK\'ün o '
    .'program için gerekli gördüğü asgarinin altındaysa yayın, puan ve yabancı dil koşullarının '
    .'hiçbiri aranmıyor (MADDE 8/1-e). Bu durum program kadrosuna bağlı olduğu için burada '
    .'hesaplanamıyor.';

$yenidenAtanma = 'Yeniden atanmada baraj atama sürenize bağlı (2 yıl için 200, 3 yıl için 300, '
    .'4 yıl için 400 puan) ve önceki atama tarihinizden sonrasını sayıyor; ikisi de burada '
    .'tutulmadığı için yeniden atanma eşiği girilmedi.';

/** Dr. Öğr. Üyeliğinin üç kollu yayın koşulu (MADDE 8/1-c). */
$drYayinKosulu = Kalip::veya('Yayın, proje ya da yurt dışı araştırma koşulu', [
    Kalip::adet('Makale, sözlü bildiri ve kitap kalemlerinizden en az 2 yayın',
        ['DR-YAYIN'], 2, madde: 'Madde 8/1-c'),
    Kalip::adet('Kabul edilmiş dış kaynaklı bir projede görev almış olmak',
        ['DIS-PROJE'], 1, madde: 'Madde 8/1-c'),
    Kalip::beyan('TÜBİTAK, YÖK, üniversite ya da başka bir kurum destekli bir proje kapsamında '
        .'en az altı ay süreyle yurt dışında bir üniversitede araştırma amacıyla bulunmuş olmak',
        'Madde 8/1-c'),
]);

$docentlikSarti = Kalip::ve('Doçent', [
    $genelSartBeyani,
    Kalip::beyan('Doçentlik unvanını almış olmak', 'Madde 7/1-b'),
    Kalip::beyan('Doçentlik unvanı yurt dışında alınmışsa eşdeğerliliğinin Üniversitelerarası '
        .'Kurul kararıyla kabul edilmiş olması', 'Madde 7/1-c'),
]);

$profesorlukKidem = Kalip::beyan('Doçent unvanını aldıktan sonra en az beş yıl süreyle, açık '
    .'bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'Madde 6/1-b');

return [
    // ══════════ DOKTOR ÖĞRETİM ÜYESİ (MADDE 8/1) ══════════
    [
        'anahtar' => 'kirklareli-dr',
        'aday_notu' => $baglayiciDegil.' '.$kadroEksigi.' '.$yenidenAtanma,
        'universite' => $UNI,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $bilimAlanlari,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 8/1: Aday Etkinlik Puanlama Tablosundan en az 200 puan (ç bendi); '
            .'A bendi, B bendinin sözlü bildirileri ve C bendinin 1-6. maddeleri kapsamında en '
            .'az 2 yayın ya da dış kaynaklı proje ya da altı aylık yurt dışı araştırma '
            .'(c bendi); yabancı dil sınavından en az 55 (d bendi).',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi', [
            Kalip::toplam(200),
            $drYayinKosulu,
            Kalip::yds(55),
            $genelSartBeyani,
            Kalip::beyan('Doktora, tıpta uzmanlık ya da belli sanat dallarının birinde yeterlik '
                .'kazanmış olmak', 'Madde 8/1-b'),
        ]),
    ],
    [
        'anahtar' => 'kirklareli-dr-sanat',
        'aday_notu' => 'Sanat Alanlarında (Güzel Sanatlar, Konservatuvar) yabancı dil koşulu '
            .'ARANMIYOR (MADDE 8/1-d); bu eşikte dil barajı yok. '
            .$baglayiciDegil.' '.$kadroEksigi.' '.$yenidenAtanma,
        'universite' => $UNI,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 8/1: en az 200 puan; c bendinin üç kollu yayın koşulu. Yabancı dil '
            .'koşulu Sanat Alanları için aranmıyor (d bendi).',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sanat Alanları', [
            Kalip::toplam(200),
            $drYayinKosulu,
            $genelSartBeyani,
            Kalip::beyan('Doktora, sanatta yeterlik ya da tıpta uzmanlık unvanını kazanmış olmak',
                'Madde 8/1-b'),
        ]),
    ],

    // ══════════ DOÇENT (MADDE 7) ══════════
    [
        'anahtar' => 'kirklareli-docentlik',
        'aday_notu' => 'Kırklareli doçent kadrosu için SAYISAL HİÇBİR KOŞUL KOYMUYOR: MADDE 7 '
            .'yalnızca 657 sayılı Kanunun genel şartlarını ve ÜAK doçentlik unvanını istiyor. '
            .'Puan tablosu bu kadroda hiç kullanılmıyor. '.$baglayiciDegil,
        'universite' => $UNI,
        'kadro' => 'docentlik',
        'alan' => $tumAlanlar,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 7: puan barajı ve yayın koşulu YOK; üç bendin üçü de beyan.',
        'sart' => $docentlikSarti,
    ],

    // ══════════ PROFESÖR (MADDE 6) ══════════
    [
        'anahtar' => 'kirklareli-profesorluk',
        'aday_notu' => $baglayiciDegil,
        'universite' => $UNI,
        'kadro' => 'profesorluk',
        'alan' => $bilimAlanlari,
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 6/1-c-1: doçentlik sonrası A bendi kapsamında en az 2 yayın ve Aday '
            .'Etkinlik Puanlama Tablosundan en az 800 puan.',
        'sart' => Kalip::ve('Profesör', [
            Kalip::toplam(800, $DOC),
            Kalip::adet('Doçentliğinizden sonra makale kalemlerinizden en az 2 yayın',
                ['A'], 2, donem: $DOC, madde: 'Madde 6/1-c-1'),
            $profesorlukKidem,
            $genelSartBeyani,
        ]),
    ],
    [
        'anahtar' => 'kirklareli-profesorluk-sanat',
        'aday_notu' => 'Sanat Alanlarında iki çalışma koşulu yalnız makalelerden değil; makale, '
            .'bildiri, kitap, çeviri ile sanat ve tasarım etkinliklerinin tamamından sayılıyor '
            .'(MADDE 6/1-c-2). Öteki alanlarda koşul yalnızca makalelere bakıyor. '
            .$baglayiciDegil,
        'universite' => $UNI,
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar'],
        'cetvel' => $CETVEL,
        'notlar' => 'MADDE 6/1-c-2: doçentlik sonrası A, B, C, Ç, D ve E bentleri kapsamında en '
            .'az 2 çalışma ve tablodan en az 800 puan.',
        'sart' => Kalip::ve('Profesör — Sanat Alanları', [
            Kalip::toplam(800, $DOC),
            Kalip::adet('Doçentliğinizden sonra makale, bildiri, kitap, çeviri ile sanat ve '
                .'tasarım etkinliği kalemlerinizden en az 2 çalışma',
                ['SANAT-CALISMA'], 2, donem: $DOC, madde: 'Madde 6/1-c-2'),
            $profesorlukKidem,
            $genelSartBeyani,
        ]),
    ],
];
