<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * TRAKYA ÜNİVERSİTESİ — Öğretim Üyesi Atama ve Yükseltme Kriterleri
 * Kaynak: pdf/17537009772.trakyauniverstesi.pdf
 * (Senato 12 Şubat 2025 tarih ve 02 sayılı toplantı, KARAR 01)
 *
 * Cetvel: cetvel/trakya-2025.php (yedi ek, yedi ayrı cetvel)
 *
 * ── EŞİKLERİN YAPISI ──
 * Kriterler yedi temel alan ekine bölünmüş; her ekin hem kendi puanlama
 * tablosu hem kendi ek koşulları var. Her ekte üç birim türü ayrı
 * değerlendiriliyor:
 *   • Fakülte
 *   • Yüksekokul ve enstitüler — MADDE 4(4) ile fakülte kriterlerinin
 *     aynısına bağlı, aynı eşik kaydında toplandı
 *   • Meslek yüksekokulları — doktor öğretim üyeliğinde ÇOK DAHA DÜŞÜK
 *     bir eşik (40 puan), doçentlik ve profesörlükte fakülte kriteri
 * Bu yüzden her eşik kaydında `birim` dolu; adayın hangi birim türüne
 * başvurduğunu seçmesi gerekiyor.
 *
 * ── YORUM KARARLARI (§0) ──
 *   MATEMATİK ALANI AYRILMADI. EK-2 Matematik için daha düşük eşik
 *       (doktor öğretim üyeliğinde 50, doçentlik ve profesörlükte 120,
 *       doçentlikte iki makale) istiyor; kayıt "fen" temel alanının
 *       içinde matematiği ayırt edemediği için Fen ve Mühendislik
 *       değerleri yazıldı. Matematikçi adaya GEREKENDEN FAZLASI soruluyor.
 *   ZİRAAT ve HUKUK temel alanları yönergenin yedi ekinde adıyla
 *       geçmiyor. Ziraat EK-2'ye (Fen Bilimleri), hukuk EK-4'e (Sosyal ve
 *       Beşeri Bilimler) bağlandı; en yakın karşılıklar bunlar.
 *   EK-2 doktor öğretim üyeliği ilk atamada yönerge üç kollu bir merdiven
 *       kuruyor: doktora tezinden üretilmiş yayın 1.a-1 ya da 1.a-2'de
 *       (Q1/Q2) ise ek yayın istenmiyor, 1.a-3/1.a-4'te ise bir, alt
 *       kategorilerde ise iki ek 1.a makalesi isteniyor. Kayıt
 *       `tez_yayini` kategorisinde ÇEYREK BİLGİSİ taşımadığı için hangi
 *       kolda olduğunuz bilinemiyor; §0 uyarınca EN SIKI kol yazıldı
 *       (tez yayını + iki ek SCIE/SSCI makalesi). Tezinizden üretilmiş
 *       makaleniz Q1 ya da Q2'deyse aracın istediği iki ek makale
 *       gerçekte aranmıyor.
 *   EK-4 doçentlikte aranan "ÜAK doçentlik puanının %20 fazlası"
 *       `hesaplanamiyor` düğümü; hesap ÜAK'ın dönemsel bilim alanı puan
 *       listesine göre yapılıyor, o cetvel projede yok.
 *   EK-4 doçentlikteki dört koşuldan üçü ("dört yarıyıl iki farklı lisans
 *       dersi" ile "iki yarıyıl bir lisansüstü ders") kayıtta tek bir
 *       ders-yarıyıl ölçüsüne düşüyor; ders sayısı ve düzeyi ayrılamadığı
 *       için ikisi aynı ölçünün iki eşiği olarak yazıldı.
 *   YABANCI DİL: MADDE 4 doktor öğretim üyeliğinde 55, doçentlik ve
 *       profesörlükte 65 puan istiyor. Tamamen yabancı dilde eğitim veren
 *       programlar için 85, yabancı uyruklular için 75 puanlık ayrı eşik
 *       var; programa bağlı olduğu için genel eşik yazıldı.
 *   Yeniden atamalarda yönergenin "bir önceki atamada kullanılan yayın ve
 *       faaliyetler dışında olmak" kaydı UYGULANMIYOR; kayıt bir eserin
 *       hangi atamada kullanıldığını tutmuyor. Puanınız bu yüzden
 *       olduğundan yüksek görünebilir.
 *   Profesörlük ve doçentlikteki "en az biri tamamlanmış" tez koşulunda
 *       devam eden tezler kayıtta tutulmadığı için sayı tamamlanmış tezler
 *       üzerinden aranıyor; koşul gerçeğinden SIKI çalışıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5(1) Tıp Fakültesi istisnası ve MADDE 5(2) disiplinlerarası
 *       (hibrit) anabilim dallarına ilişkin özel durumlar.
 *   EK-2, EK-3 ve EK-4'ün tez danışmanlığı muafiyetleri ("kadronun
 *       bulunduğu birimde lisansüstü program yoksa bu şart aranmaz") —
 *       birime bağlı belge koşulları.
 *   MADDE 4(2) ile MADDE 5(3): doktor öğretim üyeliği puanları DÖRT
 *       YILLIK atama içindir; daha kısa süreli atamalarda puan süreyle
 *       orantılı olarak düşüyor (dört yıl için 40 puan isteniyorsa bir yıl
 *       için 10). Araç daima dört yıllık eşiği arıyor.
 *   EK-4 Balkan Araştırma Enstitüsü ile Roman Dili ve Kültürü
 *       Araştırmaları Enstitüsü için ayrı eşik yazıldı; "araştırma
 *       enstitüsü" birimini seçin.
 */
$YDS_DR = Kalip::yds(55);

$GENEL_DOCENT = [
    Kalip::yds(65),
    Kalip::beyan('Üniversitelerarası Kuruldan doçent unvanını almış ve doçentlik sözlü sınavında başarılı olmuş olmak', 'MADDE 4'),
    Kalip::beyan('Doktora ya da uzmanlık unvanını aldıktan sonra en az üç yıl (tıpta yandal uzmanlığında iki yıl) açık bulunan bilim alanında eğitim-araştırma çalışması yapmış olmak', 'MADDE 4'),
];

$GENEL_PROF = [
    Kalip::yds(65),
    Kalip::beyan('Doçent unvanını aldıktan sonra en az üç yıl açık bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak', 'MADDE 4'),
    Kalip::beyan('Başlıca araştırma eseri olarak, başlıca yazar olduğunuz bir yayını göstermiş olmak', 'MADDE 4'),
    Kalip::beyan('Profesörlük sözlü sınavında başarılı olmak', 'MADDE 4'),
];

/**
 * Meslek yüksekokulu doktor öğretim üyeliği. EK-1'de 30, öteki eklerde 40
 * puan; yeniden atamada her ekte 40 puan ve yarısının uluslararası
 * faaliyetlerden gelmesi isteniyor.
 *
 * @return array{dr_ogr_uyesi: array<string, mixed>, dr_ogr_uyesi_yeniden: array<string, mixed>}
 */
$myo = function (string $ek, int $ilkPuan) use ($YDS_DR): array {
    return [
        'dr_ogr_uyesi' => Kalip::ve('Meslek yüksekokulu doktor öğretim üyesi ilk atama koşulları', [
            $YDS_DR,
            Kalip::adet('Uluslararası indekslerde taranan hakemli dergilerde yayımlanmış en az iki uluslararası yayın', ['M1'], 2, madde: $ek.' MYO ilk atama 1)'),
            Kalip::toplam($ilkPuan, maddeler: ['TUM']),
        ]),
        'dr_ogr_uyesi_yeniden' => Kalip::ve('Meslek yüksekokulu doktor öğretim üyesi yeniden atama koşulları', [
            $YDS_DR,
            Kalip::toplam(40, maddeler: ['TUM']),
            Kalip::oran('Puanınızın en az yarısı uluslararası faaliyetlerden gelmeli', ['ULUS'], 0.5, ['TUM'], madde: $ek.' MYO yeniden atama 1)'),
        ]),
    ];
};

// ══════════════════════════════════════════════════════════════════════
// EK-1 — SAĞLIK BİLİMLERİ
// ══════════════════════════════════════════════════════════════════════
$ek1 = [
    'dr_ogr_uyesi' => Kalip::ve('Doktor öğretim üyesi ilk atama koşulları', [
        $YDS_DR,
        Kalip::toplam(30, maddeler: ['TUM']),
        Kalip::oran('Toplam puanınızın en az üçte biri makale, kitap, atıf, proje ve uluslararası bildiri kalemlerinizden gelmeli', ['OZEL'], 1 / 3, ['TUM'], madde: 'EK-1 Fakülte Dr. Öğr. Üyesi ilk atama'),
    ]),
    'dr_ogr_uyesi_yeniden' => Kalip::ve('Doktor öğretim üyesi yeniden atama koşulları', [
        $YDS_DR,
        Kalip::toplam(40, maddeler: ['TUM']),
        Kalip::oran('Toplam puanınızın en az dörtte biri makale, kitap, atıf, proje ve uluslararası bildiri kalemlerinizden gelmeli', ['OZEL'], 0.25, ['TUM'], madde: 'EK-1 Fakülte Dr. Öğr. Üyesi yeniden atama'),
    ]),
    'docentlik' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
        ...$GENEL_DOCENT,
        Kalip::adet('Birinci danışman olarak en az bir lisansüstü ya da uzmanlık tezi yönetmiş olmak', ['5a', '5b'], 1, madde: 'EK-1 Fakülte Doçent 1)'),
    ]),
    'profesorluk' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
        ...$GENEL_PROF,
        Kalip::adet('Birinci danışman olarak en az iki lisansüstü ya da uzmanlık tezi yönetmiş olmak', ['5a', '5b'], 2, madde: 'EK-1 Fakülte Profesör 1)'),
        Kalip::toplam(300, maddeler: ['TUM']),
        Kalip::oran('Toplam puanınızın en az yarısı makale, kitap, atıf, proje ve uluslararası bildiri kalemlerinizden gelmeli', ['OZEL'], 0.5, ['TUM'], madde: 'EK-1 Fakülte Profesör 2)'),
        Kalip::adet('Doçentlik sonrası SCIE ya da SSCI kapsamında en az iki makale', ['M1A'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 Fakülte Profesör 3)'),
        Kalip::adet('Bu makalelerden birinde birinci isim olmak', ['M1A'], 1, yazar: 'ilk', donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 Fakülte Profesör 3)'),
        Kalip::adet('Bu makalelerden birinde başlıca yazar olmak', ['M1A'], 1, yazar: 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-1 Fakülte Profesör 3)'),
    ]),
];

// ══════════════════════════════════════════════════════════════════════
// EK-2 — MÜHENDİSLİK, FEN BİLİMLERİ VE MATEMATİK (ZİRAAT DÂHİL)
// ══════════════════════════════════════════════════════════════════════
$PROJE_YURUTUCU_2 = ['6a-y', '6b-y', '6d-y', '6f-y'];

$ek2 = [
    'dr_ogr_uyesi' => Kalip::ve('Doktor öğretim üyesi ilk atama koşulları', [
        $YDS_DR,
        Kalip::adet('Doktora tezinizden üretilmiş en az bir araştırma makalesi ya da tam metin araştırma bildirisi', ['TEZY'], 1, madde: 'EK-2 Fakülte Dr. Öğr. Üyesi ilk atama 1)'),
        Kalip::adet('Alanınızda SCIE ya da SSCI kapsamında en az iki makale daha', ['M1A'], 2, madde: 'EK-2 Fakülte Dr. Öğr. Üyesi ilk atama 2.a)'),
        Kalip::toplam(60, maddeler: ['TUM']),
    ]),
    'dr_ogr_uyesi_yeniden' => Kalip::ve('Doktor öğretim üyesi yeniden atama koşulları', [
        $YDS_DR,
        Kalip::adet(
            'SCIE/SSCI, ESCI-Scopus-PubMed, diğer uluslararası indeksler ya da TR Dizin kapsamında en az iki araştırma makalesi',
            ['M-ARS'],
            2,
            telafi: Kalip::adet('Tescil edilmiş uluslararası ya da ulusal patentiniz varsa iki makale koşulu aranmaz', ['9a', '9b'], 1, madde: 'EK-2 Fakülte Dr. Öğr. Üyesi yeniden atama 1.b)'),
            madde: 'EK-2 Fakülte Dr. Öğr. Üyesi yeniden atama 1)',
        ),
        Kalip::toplam(60, maddeler: ['TUM']),
    ]),
    'docentlik' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
        ...$GENEL_DOCENT,
        Kalip::veya('Tez danışmanlığı ya da proje yürütücülüğü koşullarından biri', [
            Kalip::adet('Alanınızda tamamlanmış en az bir lisansüstü tezde birinci danışman olmak', ['5a', '5b'], 1, madde: 'EK-2 Fakülte Doçent 1.a)'),
            Kalip::adet('6.a-6.f kategorilerinde en az bir projede koordinatör ya da yürütücü olmak', $PROJE_YURUTUCU_2, 1, madde: 'EK-2 Fakülte Doçent 1.b)'),
        ]),
        Kalip::adet('SCIE ya da SSCI kapsamında en az beş araştırma makalesi', ['M1A'], 5, madde: 'EK-2 Fakülte Doçent 2)'),
        Kalip::adet('Bu makalelerden en az birinde başlıca yazar olmak', ['M1A'], 1, yazar: 'baslica', madde: 'EK-2 Fakülte Doçent 2)'),
        Kalip::toplam(160, maddeler: ['TUM']),
    ]),
    'profesorluk' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
        ...$GENEL_PROF,
        Kalip::adet('Alanınızda en az iki lisansüstü tezde birinci danışman olmak', ['5a', '5b'], 2, madde: 'EK-2 Fakülte Profesör 1)'),
        Kalip::adet('Doçentlik sonrası başlayan, 6.a-6.f kategorilerinde en az bir projede koordinatör ya da yürütücü olmak', $PROJE_YURUTUCU_2, 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 Fakülte Profesör 2)'),
        Kalip::adet('Doçentlik sonrası SCIE ya da SSCI kapsamında en az üç araştırma makalesi', ['M1A'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 Fakülte Profesör 3)'),
        Kalip::adet('Bu makalelerden en az birinde başlıca yazar olmak', ['M1A'], 1, yazar: 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-2 Fakülte Profesör 3)'),
        Kalip::toplam(160, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM']),
    ]),
];

// ══════════════════════════════════════════════════════════════════════
// EK-3 — MİMARLIK, PLANLAMA VE TASARIM
// ══════════════════════════════════════════════════════════════════════
$ek3 = [
    'dr_ogr_uyesi' => Kalip::ve('Doktor öğretim üyesi ilk atama koşulları', [
        $YDS_DR,
        Kalip::adet('1 ve 2. maddelerden (lisansüstü tezlerden üretilenler dâhil) en az iki yayın', ['M12'], 2, madde: 'EK-3 Fakülte Dr. Öğr. Üyesi ilk atama 1)'),
        Kalip::adet('Bu yayınlardan en az biri 1.a, 1.b ya da 1.c kategorisinde olmalı', ['M1ABC'], 1, madde: 'EK-3 Fakülte Dr. Öğr. Üyesi ilk atama 1)'),
        Kalip::adet('1 ve 2. maddelerden en az bir çalışmada başlıca yazar olmak', ['M12'], 1, yazar: 'baslica', madde: 'EK-3 Fakülte Dr. Öğr. Üyesi ilk atama 2)'),
        Kalip::toplam(50, maddeler: ['TUM']),
    ]),
    'dr_ogr_uyesi_yeniden' => Kalip::ve('Doktor öğretim üyesi yeniden atama koşulları', [
        $YDS_DR,
        Kalip::adet('1.a-1.d ve 2.a kategorilerinde en az iki yayın', ['M1ABCD2A'], 2, madde: 'EK-3 Fakülte Dr. Öğr. Üyesi yeniden atama 1)'),
        Kalip::toplam(50, maddeler: ['TUM']),
    ]),
    'docentlik' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
        ...$GENEL_DOCENT,
        Kalip::adet('Alanınızda tamamlanmış en az bir lisansüstü tezde birinci danışman olmak', ['5a', '5b'], 1, madde: 'EK-3 Fakülte Doçent 1)'),
        Kalip::adet('1.a-1.d ve 2.a kapsamındaki dergilerde en az beş araştırma makalesi', ['M1ABCD2A'], 5, madde: 'EK-3 Fakülte Doçent 2)'),
        Kalip::toplam(200, maddeler: ['TUM']),
    ]),
    'profesorluk' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
        ...$GENEL_PROF,
        Kalip::adet('Doçentlik sonrası 1.a, 1.b, 1.c ya da 2.a kategorilerinde başlıca yazar olduğunuz en az iki yayın', ['M1ABC', '2a'], 2, yazar: 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-3 Fakülte Profesör 1)'),
        Kalip::toplam(200, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM']),
        Kalip::adet('Doçentlik sonrası alanınızda en az iki lisansüstü tez danışmanlığı', ['5a', '5b'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-3 Fakülte Profesör 3)'),
        Kalip::adet('6. maddede tamamlanmış ya da devam eden en az bir araştırma projesinde yürütücü olmak', ['6a-y', '6b-y', '6c-y', '6d-y'], 1, madde: 'EK-3 Fakülte Profesör 4)'),
    ]),
];

// ══════════════════════════════════════════════════════════════════════
// EK-4 — SOSYAL VE BEŞERİ BİLİMLER, EĞİTİM, FİLOLOJİ, İLAHİYAT, HUKUK
// ══════════════════════════════════════════════════════════════════════
$IDARI_4 = ['19a', '19a-y', '19c', '19c-y', '19d', '19d-yk', '19e', '19f'];

$DOCENT_4_ORTAK = [
    Kalip::hesaplanamiyor('Doçent unvanını aldığınız bilim ya da sanat alanı için doçentlik başvurunuzun yapıldığı dönemde aranan ÜAK puanının en az %20 fazlasına sahip olmak', 'EK-4 Fakülte Doçent 1)'),
    Kalip::kIle('Aşağıdaki dört koşuldan en az üçünü sağlamak', 3, [
        Kalip::metrik('En az dört yarıyıl süreyle ön lisans ya da lisans düzeyinde en az iki farklı ders vermiş olmak', 'ders_yariyil', 4),
        Kalip::metrik('En az iki yarıyıl süreyle lisansüstü düzeyde en az bir ders vermiş olmak', 'ders_yariyil', 2),
        Kalip::adet('Tamamlanmış bilimsel araştırma projelerinde görev almış olmak', ['PROJE7'], 1),
        Kalip::adet('Üniversite ya da birim yönetiminde, bölüm ve anabilim dalı başkanlıklarında, kurul ve komisyonlarda görev almış olmak', $IDARI_4, 1),
    ]),
];

$PROF_4_ORTAK = [
    Kalip::toplam(150, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM']),
    Kalip::toplam(100, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['K1248'], liste: 'Makale, kitap, bildiri ve sanatsal etkinlik'),
    Kalip::toplam(60, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['ULUS'], liste: 'Uluslararası makale, kitap ve bildiri'),
    Kalip::puanDan('5. kategori kapsamında en az 15 puan atıf almış olmak', ['ATIF'], 15, madde: 'EK-4 Fakülte Profesör 3)'),
    Kalip::adet('7.a-7.d kategorilerinde tamamlanmış ya da devam eden bir bilimsel araştırma projesinde yürütücü veya araştırmacı olarak yer almış olmak', ['PROJE7'], 1, madde: 'EK-4 Fakülte Profesör 4)'),
    Kalip::metrik('Doçentlik sonrası en az dört yarıyıl lisans düzeyinde en az iki farklı ders ya da en az iki yarıyıl lisansüstü düzeyde en az bir ders vermiş olmak', 'ders_yariyil', 4, Kalip::DOCENTLIK_SONRASI),
];

$ek4 = [
    'dr_ogr_uyesi' => Kalip::ve('Doktor öğretim üyesi ilk atama koşulları', [
        $YDS_DR,
        Kalip::toplam(50, maddeler: ['TUM']),
        Kalip::toplam(30, maddeler: ['OZEL'], liste: 'Makale, kitap ve bildiri'),
        Kalip::adet('Lisansüstü tezinizden üretilmiş en az bir yayın (3. kategori)', ['TEZY'], 1, madde: 'EK-4 Fakülte Dr. Öğr. Üyesi ilk atama 1.b)'),
    ]),
    'dr_ogr_uyesi_yeniden' => Kalip::ve('Doktor öğretim üyesi yeniden atama koşulları', [
        $YDS_DR,
        Kalip::toplam(50, maddeler: ['TUM']),
        Kalip::oran('Toplam puanınızın en az yarısı makale, kitap ve bildiri kalemlerinizden gelmeli', ['OZEL'], 0.5, ['TUM'], madde: 'EK-4 Fakülte Dr. Öğr. Üyesi yeniden atama 1)'),
    ]),
    'docentlik' => Kalip::ve('Doçent kadrosuna atanma koşulları', [...$GENEL_DOCENT, ...$DOCENT_4_ORTAK]),
    'profesorluk' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
        ...$GENEL_PROF,
        ...$PROF_4_ORTAK,
        Kalip::veya('Aşağıdaki dört koşuldan en az birini sağlamak', [
            Kalip::adet('Tek yazarlı en az bir bilimsel kitap (tezden üretilmemiş) yazmış olmak', ['4a', '4cd'], 1, yazar: 'tek', donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-4 Fakülte Profesör 2.a)'),
            Kalip::adet('1.a, 1.b ve 1.c kategorilerinde tek ya da ilk isimli en az iki makale yayımlamış olmak', ['M1ABC'], 2, yazar: 'ilk', donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-4 Fakülte Profesör 2.b)'),
            Kalip::adet('1. kategoriden en az beş yayın yapmış olmak', ['M1'], 5, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-4 Fakülte Profesör 2.c)'),
            Kalip::adet('1.c ve 1.d kategorilerinde tek ya da ilk isimli en az üç makale yayımlamış olmak', ['1c', '1d'], 3, yazar: 'ilk', donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-4 Fakülte Profesör 2.d)'),
        ]),
    ]),
];

// Araştırma enstitüleri (Balkan Araştırma Enstitüsü, Roman Dili ve Kültürü
// Araştırmaları Enstitüsü) için EK-4'ün ayrı yazılmış koşulları.
$ek4Enstitu = [
    'dr_ogr_uyesi' => Kalip::ve('Araştırma enstitüsü doktor öğretim üyesi ilk atama koşulları', [
        $YDS_DR,
        Kalip::toplam(60, maddeler: ['TUM']),
        Kalip::toplam(30, maddeler: ['OZELENS'], liste: 'Makale, kitap ve bildiri'),
        Kalip::adet('Bu yayınların en az ikisi 1.a, 1.b, 1.c, 4.a ya da 4.b\'de tanımlı, tek ya da ilk isimli olmalı', ['M1ABC', '4a', '4b'], 2, yazar: 'ilk', madde: 'EK-4 Araştırma Enstitüleri ilk atama 1.a)'),
        Kalip::adet('Lisansüstü tezinizden üretilmiş en az bir yayın (3. kategori)', ['TEZY'], 1, madde: 'EK-4 Araştırma Enstitüleri ilk atama 1.b)'),
    ]),
    'dr_ogr_uyesi_yeniden' => Kalip::ve('Araştırma enstitüsü doktor öğretim üyesi yeniden atama koşulları', [
        $YDS_DR,
        Kalip::toplam(75, maddeler: ['TUM']),
        Kalip::oran('Toplam puanınızın en az yarısı makale, kitap ve bildiri kalemlerinizden gelmeli', ['OZELENS'], 0.5, ['TUM'], madde: 'EK-4 Araştırma Enstitüleri yeniden atama 1)'),
        Kalip::adet('Bu yayınların en az biri 1.a, 1.b, 1.c, 4.a ya da 4.b\'de tanımlı, tek ya da ilk isimli olmalı', ['M1ABC', '4a', '4b'], 1, yazar: 'ilk', madde: 'EK-4 Araştırma Enstitüleri yeniden atama 1)'),
    ]),
    'docentlik' => Kalip::ve('Araştırma enstitüsü doçent kadrosuna atanma koşulları', [
        ...$GENEL_DOCENT,
        ...$DOCENT_4_ORTAK,
        Kalip::adet('Doktora sonrası 1.a, 1.b ve 1.c kategorilerinde tek ya da ilk isimli en az iki makale yayımlamış olmak', ['M1ABC'], 2, yazar: 'ilk', donem: Kalip::DOKTORA_SONRASI, madde: 'EK-4 Araştırma Enstitüleri Doçent'),
    ]),
    'profesorluk' => Kalip::ve('Araştırma enstitüsü profesör kadrosuna atanma koşulları', [
        ...$GENEL_PROF,
        ...$PROF_4_ORTAK,
        Kalip::adet('Doçentlik sonrası 1.a, 1.b ve 1.c kategorilerinde tek ya da ilk isimli en az üç makale yayımlamış olmak', ['M1ABC'], 3, yazar: 'ilk', donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-4 Araştırma Enstitüleri Profesör'),
    ]),
];

// ══════════════════════════════════════════════════════════════════════
// EK-5 — DEVLET KONSERVATUVARI
// ══════════════════════════════════════════════════════════════════════
$ek5 = [
    'dr_ogr_uyesi' => Kalip::ve('Doktor öğretim üyesi ilk atama koşulları', [
        $YDS_DR,
        Kalip::toplam(15, maddeler: ['K1234'], liste: 'Makale ve kitap'),
        Kalip::toplam(100, maddeler: ['TUM']),
    ]),
    'dr_ogr_uyesi_yeniden' => Kalip::ve('Doktor öğretim üyesi yeniden atama koşulları', [
        $YDS_DR,
        Kalip::toplam(15, maddeler: ['K1234'], liste: 'Makale ve kitap'),
        Kalip::toplam(60, maddeler: ['TUM']),
    ]),
    'docentlik' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
        ...$GENEL_DOCENT,
        Kalip::toplam(30, donem: Kalip::DOKTORA_SONRASI, maddeler: ['K12'], liste: 'Makale'),
        Kalip::toplam(200, donem: Kalip::DOKTORA_SONRASI, maddeler: ['TUM']),
    ]),
    'profesorluk' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
        ...$GENEL_PROF,
        Kalip::toplam(30, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['K12'], liste: 'Makale'),
        Kalip::toplam(300, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM']),
    ]),
];

// ══════════════════════════════════════════════════════════════════════
// EK-6 — GÜZEL SANATLAR
// ══════════════════════════════════════════════════════════════════════
$ek6 = [
    'dr_ogr_uyesi' => Kalip::ve('Doktor öğretim üyesi ilk atama koşulları', [
        $YDS_DR,
        Kalip::toplam(150, maddeler: ['TUM']),
    ]),
    'dr_ogr_uyesi_yeniden' => Kalip::ve('Doktor öğretim üyesi yeniden atama koşulları', [
        $YDS_DR,
        Kalip::toplam(10, maddeler: ['K1-5'], liste: 'Makale, kitap ve atıf'),
        Kalip::toplam(150, maddeler: ['TUM']),
    ]),
    'docentlik' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
        ...$GENEL_DOCENT,
        Kalip::toplam(200, donem: Kalip::DOKTORA_SONRASI, maddeler: ['TUM']),
    ]),
    'profesorluk' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
        ...$GENEL_PROF,
        Kalip::adet('Doçentlik sonrası 1 ve/veya 2. kategorilerden en az iki yayın', ['K12'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-6 Fakülte Profesör 1)'),
        Kalip::toplam(150, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['K1-16']),
        Kalip::toplam(300, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM']),
    ]),
];

// ══════════════════════════════════════════════════════════════════════
// EK-7 — SPOR BİLİMLERİ
// ══════════════════════════════════════════════════════════════════════
$ek7 = [
    'dr_ogr_uyesi' => Kalip::ve('Doktor öğretim üyesi ilk atama koşulları', [
        $YDS_DR,
        Kalip::adet('Doktora tezinizden üretilmiş en az bir yayın (3. kategori)', ['TEZY'], 1, madde: 'EK-7 Dr. Öğr. Üyesi ilk atama 1)'),
        Kalip::toplam(15, maddeler: ['K1234816'], liste: 'Makale, kitap ve bildiri'),
        Kalip::toplam(30, maddeler: ['TUM']),
    ]),
    'dr_ogr_uyesi_yeniden' => Kalip::ve('Doktor öğretim üyesi yeniden atama koşulları', [
        $YDS_DR,
        Kalip::toplam(20, maddeler: ['K1234678'], liste: 'Makale, kitap, bildiri, proje ve tez danışmanlığı'),
        Kalip::toplam(40, maddeler: ['TUM']),
    ]),
    'docentlik' => Kalip::ve('Doçent kadrosuna atanma koşulları', [
        ...$GENEL_DOCENT,
        Kalip::toplam(120, maddeler: ['TUM']),
    ]),
    'profesorluk' => Kalip::ve('Profesör kadrosuna atanma koşulları', [
        ...$GENEL_PROF,
        Kalip::adet('Doçentlik sonrası birinci danışman olarak en az bir lisansüstü tezi tamamlamış olmak', ['6a', '6b'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-7 Profesör 1)'),
        Kalip::adet('Doçentlik sonrası 1. kategoriden en az bir yayın', ['K1'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-7 Profesör 2)'),
        Kalip::adet('Doçentlik sonrası 2. kategoriden en az bir yayın', ['K2'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-7 Profesör 2)'),
        Kalip::adet('Doçentlik sonrası 4. kategoriden en az bir yayın', ['K4'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-7 Profesör 2)'),
        Kalip::adet('Doçentlik sonrası 8. kategoriden en az iki bildiri', ['K8'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'EK-7 Profesör 2)'),
        Kalip::toplam(50, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['K1234816'], liste: 'Makale, kitap ve bildiri'),
        Kalip::toplam(150, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM']),
    ]),
];

// ══════════════════════════════════════════════════════════════════════
// EŞİK KAYITLARI
// ══════════════════════════════════════════════════════════════════════
$BIRIM_FAKULTE = 'Fakülte, yüksekokul ya da enstitü';
$BIRIM_MYO = 'Meslek yüksekokulu';
$BIRIM_ENSTITU = 'Balkan Araştırma Enstitüsü ya da Roman Dili ve Kültürü Araştırmaları Enstitüsü';
$BIRIM_KONSERVATUVAR = 'Devlet Konservatuvarı';
$BIRIM_GSF = 'Güzel Sanatlar Fakültesi, yüksekokul ya da enstitü';

$ORTAK_ADAY = 'Yeniden atamalarda yönergenin aradığı "bir önceki atamada kullanılan yayın ve '
    .'faaliyetler dışında olmak" kaydı uygulanmıyor; kayıt bir eserin hangi atamada '
    .'kullanıldığını tutmuyor, bu yüzden puanınız olduğundan yüksek görünebilir. Doktor öğretim '
    .'üyeliği puanları DÖRT YILLIK atama içindir: daha kısa süreli bir atamada aranan puan '
    .'süreyle orantılı düşer (dört yıl için 40 puan isteniyorsa bir yıl için 10). Yabancı dil '
    .'koşulu doktor öğretim üyeliğinde 55, doçentlik ve profesörlükte 65 puan; tamamen yabancı '
    .'dilde eğitim veren programlarda 85, yabancı uyruklu adaylarda 75 puan aranıyor ve araç bu '
    .'iki istisnayı sormuyor. Yönergenin "atama için gerekli toplam puanın %25\'ini geçemez" '
    .'sınırları eşiğe bağlı olduğu için uygulanmıyor; atıf, ödül, editörlük, jüri ve idari görev '
    .'kalemlerinde puanınız olduğundan yüksek görünür.';

$MYO_ADAY = 'Meslek yüksekokulu doktor öğretim üyeliğinde fakülte kriterleri değil, temel '
    .'alanınızın meslek yüksekokulu koşulları aranıyor. Doçentlik ve profesörlükte ise fakülte kriterleri '
    .'geçerli; o kadrolar için "'.$BIRIM_FAKULTE.'" seçeneğiyle aynı eşik kullanılıyor. '
    .'Disiplinlerarası ve hibrit anabilim dallarına ilişkin Özel Durumlar 5.2 maddesi girilmedi.';

/** @var array<string, array<string, array{0: string, 1: string}>> */
$METIN = [
    'ek1' => [
        'dr_ogr_uyesi' => ['EK-1 Fakülte Dr. Öğr. Üyesi ilk atama: toplam en az 30 puan; puanın en az 1/3\'ü 1, 3.a-3.d, 4.a-4.c, 6.a-6.b ve 7.a-7.b1 kalemlerinden.', 'Sağlık Bilimleri temel alanında ilk atama için 30 puan yetiyor ama puanın en az üçte biri makale, kitap, atıf, AB-TÜBİTAK-uluslararası proje ve bildiri kalemlerinden gelmeli; idari görev, editörlük ve ödülle bu payı dolduramazsınız.'],
        'dr_ogr_uyesi_yeniden' => ['EK-1 Fakülte Dr. Öğr. Üyesi yeniden atama: toplam en az 40 puan; puanın en az 1/4\'ü aynı kalemlerden.', 'Yeniden atamada baraj 40 puana çıkıyor, aynı kalemlerden gelmesi gereken pay ise dörtte bire iniyor.'],
        'docentlik' => ['EK-1 Fakülte Doçent: birinci danışman olarak en az bir lisansüstü ya da uzmanlık tezi. Puan barajı yok.', 'Yönerge bu alanda doçentlikte puan barajı koymuyor; tek alan koşulu birinci danışman olarak yönettiğiniz bir lisansüstü ya da uzmanlık tezi. Devam eden tezler kayıtta tutulmadığı için araç tamamlanmış tez arıyor.'],
        'profesorluk' => ['EK-1 Fakülte Profesör: iki lisansüstü/uzmanlık tezi (en az biri tamamlanmış); toplam 300 puan, en az yarısı 1, 3.a-3.d, 4.a-4.c, 6.a-6.b ve 7.a-7.b1 kalemlerinden; doçentlik sonrası SCIE/SSCI\'de iki makale (birinde birinci isim, diğerinde başlıca yazar).', 'Profesörlükte üç ayrı katman var: 300 puanlık toplam, bunun yarısının belirli kalemlerden gelmesi ve doçentlik sonrası iki SCIE/SSCI makalesi. Yönerge "en az biri tamamlanmış" iki tez istiyor; araç devam eden tezi göremediği için iki tamamlanmış tez arıyor, koşulu gerçeğinden sıkı uyguluyor.'],
    ],
    'ek2' => [
        'dr_ogr_uyesi' => ['EK-2 Fakülte Dr. Öğr. Üyesi ilk atama: doktora tezinden üretilmiş en az bir araştırma makalesi ya da tam metin bildiri; alanında iki ek SCIE/SSCI makalesi; Fen ve Mühendislikte toplam 60, Matematikte 50 puan.', 'Yönerge ek yayın koşulunu tezden üretilmiş yayının çeyreğine bağlıyor: yayınınız Q1 ya da Q2\'deyse ek makale istenmiyor, Q3/Q4\'teyse bir, alt kategorilerdeyse iki ek SCIE/SSCI makalesi gerekiyor. Kayıt tez yayınının çeyreğini taşımadığı için araç EN SIKI kolu (iki ek makale) arıyor; Q1 ya da Q2 makaleniz varsa gerçekte bu koşul yok. Matematik alanında baraj 60 değil 50 puan; araç fen ve mühendislik değerini kullanıyor.'],
        'dr_ogr_uyesi_yeniden' => ['EK-2 Fakülte Dr. Öğr. Üyesi yeniden atama: 1.a, 1.e-1, 1.f-1 ya da 2.a-1 kategorilerinde en az iki yayın (tescilli patenti olanlarda aranmaz); Fen ve Mühendislikte 60, Matematikte 50 puan.', 'Yönerge iki muafiyet tanıyor: iki yayından biri başlıca yazar olduğunuz Q1/Q2 makalesiyse ya da tescil edilmiş patentiniz varsa iki yayın koşulu düşüyor. Araç patent muafiyetini uygulayabiliyor; Q1/Q2 muafiyetini kayıt tez ve çeyrek ayrımı taşımadığı için uygulayamıyor.'],
        'docentlik' => ['EK-2 Fakülte Doçent: bir lisansüstü tezde birinci danışmanlık ya da 6.a-6.f\'de bir proje yürütücülüğü; SCIE/SSCI\'de beş araştırma makalesi (Matematikte iki), en az birinde başlıca yazar; Fen ve Mühendislikte toplam 160, Matematikte 120 puan.', 'Doçentlikte tez danışmanlığı ile proje yürütücülüğü birbirinin alternatifi. Makale koşulu Matematikte beş değil iki, puan barajı 160 değil 120; araç fen ve mühendislik değerlerini kullandığı için matematikçi adaya gerekenden fazlası soruluyor.'],
        'profesorluk' => ['EK-2 Fakülte Profesör: iki lisansüstü tezde birinci danışmanlık (en az biri tamamlanmış); doçentlik sonrası başlayan bir proje yürütücülüğü; doçentlik sonrası SCIE/SSCI\'de üç makale (Matematikte iki), en az birinde başlıca yazar; doçentlik sonrası 160 puan (Matematikte 120).', 'Tez danışmanlığı koşulunun "birimde lisansüstü program yoksa yerine iki proje" muafiyeti girilmedi. Proje koşulunda yönerge projenin BAŞLANGIÇ tarihinin doçentlikten sonra olmasını istiyor; araç projenin kayıt tarihine bakıyor.'],
    ],
    'ek3' => [
        'dr_ogr_uyesi' => ['EK-3 Fakülte Dr. Öğr. Üyesi ilk atama: 1 ve 2. maddelerden en az iki yayın (en az biri 1.a, 1.b ya da 1.c); en az bir çalışmada başlıca yazarlık; toplam 50 puan.', 'Mimarlık, Planlama ve Tasarım alanında lisansüstü tezlerden üretilen yayınlar da bu iki yayının içinde sayılıyor.'],
        'dr_ogr_uyesi_yeniden' => ['EK-3 Fakülte Dr. Öğr. Üyesi yeniden atama: 1.a-1.d ve 2.a kategorilerinde en az iki yayın; toplam 50 puan.', 'Yeniden atamada başlıca yazarlık koşulu düşüyor, yayın kategorileri biraz genişliyor; baraj 50 puanda kalıyor.'],
        'docentlik' => ['EK-3 Fakülte Doçent: bir lisansüstü tezde birinci danışmanlık; 1.a-1.d ve 2.a kapsamındaki dergilerde beş araştırma makalesi; toplam 200 puan.', 'Tez danışmanlığı koşulunun "anabilim/anasanat dalında lisansüstü program yoksa aranmaz" muafiyeti girilmedi; programınız yoksa bu koşul size uygulanmaz.'],
        'profesorluk' => ['EK-3 Fakülte Profesör: doçentlik sonrası 1.a, 1.b, 1.c ya da 2.a\'da başlıca yazar olduğunuz iki yayın; doçentlik sonrası 200 puan; doçentlik sonrası iki tez danışmanlığı (en az biri tamamlanmış); 6. maddede bir proje yürütücülüğü.', 'Tez danışmanlığındaki program muafiyeti burada da girilmedi. Devam eden tez ve proje kayıtta tutulmadığı için araç tamamlanmışları sayıyor.'],
    ],
    'ek4' => [
        'dr_ogr_uyesi' => ['EK-4 Fakülte Dr. Öğr. Üyesi ilk atama: toplam 50 puan; 1.a-1.d, 2.a, 2.b, 4 ve 8. kategorilerden en az 30 puan; lisansüstü tezden üretilmiş en az bir yayın.', 'Güzel Sanatlar Eğitimi bölümlerinde koşul farklı: 50 puanın en az 15\'i 1, 4 ve 8. kategorilerdeki uluslararası yayınlardan olmalı ve tez yayını aranmıyor. Araç bölüm ayrımı yapmadığı için genel koşulu uyguluyor.'],
        'dr_ogr_uyesi_yeniden' => ['EK-4 Fakülte Dr. Öğr. Üyesi yeniden atama: toplam 50 puan, en az yarısı 1.a-1.d, 2.a, 2.b, 4 ve 8. kategorilerden.', 'Yeniden atamada tez yayını koşulu düşüyor; yerine puanın yarısının belirli kategorilerden gelmesi isteniyor.'],
        'docentlik' => ['EK-4 Fakülte Doçent: ÜAK doçentlik puanının en az %20 fazlası; ders verme, proje ve yönetim görevlerinden en az üçü.', 'Puan koşulu ÜAK\'ın dönemsel bilim alanı listesine bağlı olduğu için araç hesaplayamıyor, "hesaplanamıyor" olarak işaretliyor. Dört koşuldan üçünü sağlama şartında kayıt ders sayısını ve düzeyini ayıramadığı için iki ders koşulu aynı ders-yarıyıl ölçüsünün iki eşiği olarak yazıldı.'],
        'profesorluk' => ['EK-4 Fakülte Profesör: doçentlik sonrası 150 puan; en az 100 puanı 1, 2, 4, 8, 15 ve 16. kategorilerden, en az 60 puanı uluslararası yayın ve performanstan; dört yayın koşulundan biri; 5. kategoriden 15 puan atıf; 7.a-7.d\'de proje; doçentlik sonrası ders verme.', 'Yönergenin 2. maddesindeki dört alternatiften biri yeterli: tek yazarlı kitap, 1.a-1.c\'de iki tek/ilk isimli makale, 1. kategoriden beş yayın ya da 1.a-1.b\'de bir tek yazarlı makalenin yanında 1.c-1.d\'de üç tek/ilk isimli makale. Dördüncü alternatifin "tek yazarlı 1.a/1.b makalesi" ön koşulu araçta ayrıca aranmıyor.'],
    ],
    'ek5' => [
        'dr_ogr_uyesi' => ['EK-5 Dr. Öğr. Üyesi ilk atama: 1, 2, 3 ve 4. kategorilerden en az 15 puan; toplam 100 puan.', 'Devlet Konservatuvarında baraj yüksek (100 puan) ama bunun yalnız 15 puanı makale, tez yayını ve kitap kategorilerinden gelmek zorunda; kalanı sanatsal ve akademik faaliyetlerden toplanabiliyor.'],
        'dr_ogr_uyesi_yeniden' => ['EK-5 Dr. Öğr. Üyesi yeniden atama: 1, 2, 3 ve 4. kategorilerden en az 15 puan; toplam 60 puan.', 'Yeniden atamada toplam baraj 60 puana iniyor, yayın payı 15 puanda kalıyor.'],
        'docentlik' => ['EK-5 Doçent: doktora/sanatta yeterlik sonrası 1 ve 2. kategorilerden en az 30 puan; toplam 200 puan.', 'Doçentlikte sayılan bütün faaliyetlerin doktora ya da sanatta yeterlik sonrasına ait olması gerekiyor.'],
        'profesorluk' => ['EK-5 Profesör: doçentlik sonrası 1 ve 2. kategorilerden en az 30 puan; toplam 300 puan.', 'Profesörlükte sayılan bütün faaliyetlerin doçent unvanını aldıktan sonrasına ait olması gerekiyor.'],
    ],
    'ek6' => [
        'dr_ogr_uyesi' => ['EK-6 Fakülte Dr. Öğr. Üyesi ilk atama: 1-17. kategorilerden en az 150 puan.', 'Güzel Sanatlar temel alanında tek koşul 150 puan; 17. maddedeki sergi, bienal, festival ve müzeye kabul satırları bu puanın büyük bölümünü karşılayabiliyor.'],
        'dr_ogr_uyesi_yeniden' => ['EK-6 Fakülte Dr. Öğr. Üyesi yeniden atama: 1-5. kategorilerden en az 10 puan; toplam 150 puan.', 'Yeniden atamada toplam baraj aynı kalıyor; yeni olan, puanın en az 10\'unun makale, tez yayını, kitap ve atıf kategorilerinden gelme koşulu.'],
        'docentlik' => ['EK-6 Fakülte Doçent: doktora/sanatta yeterlik sonrası 1-17. kategorilerden en az 200 puan.', 'Doçentlikte sayılan faaliyetlerin doktora ya da sanatta yeterlik sonrasına ait olması gerekiyor.'],
        'profesorluk' => ['EK-6 Fakülte Profesör: doçentlik sonrası 1 ve/veya 2. kategorilerden en az iki yayın; 1-16. kategorilerden en az 150 puan; toplam 300 puan.', 'Profesörlükte sanatsal etkinlik puanı tek başına yetmiyor: 150 puanın 17. madde dışındaki kategorilerden, iki yayının da makale kategorilerinden gelmesi gerekiyor.'],
    ],
    'ek7' => [
        'dr_ogr_uyesi' => ['EK-7 Dr. Öğr. Üyesi ilk atama: doktora tezinden üretilmiş en az bir yayın; 1, 2, 3, 4, 8 ve 16. kategorilerden en az 15 puan; toplam 30 puan.', 'Sportif performans kalemleri kayıtta karşılığı olmadığı için hiç girilmedi: sporcu yetiştirme, millî takım görevi, antrenörlük ve hakemlik belgeleri sayılmıyor. Bu maddeye dayanan puanınız varsa gerçek puanınız buradakinden yüksektir.'],
        'dr_ogr_uyesi_yeniden' => ['EK-7 Dr. Öğr. Üyesi yeniden atama: 1, 2, 3, 4, 6, 7, 8 ve 16. kategorilerden en az 20 puan; toplam 40 puan.', '16. madde (sportif performans) girilmediği için kategori payı yalnız yayın, tez danışmanlığı, proje ve bildiri kalemlerinden doluyor.'],
        'docentlik' => ['EK-7 Doçent: 1-18. kategorilerden toplam en az 120 puan.', 'Doçentlikte tek koşul 120 puan; yönerge burada dönem kısıtı koymuyor. 16. madde girilmediği için sportif performansınız bu toplama girmiyor.'],
        'profesorluk' => ['EK-7 Profesör: doçentlik sonrası birinci danışman olarak tamamlanmış bir lisansüstü tez; doçentlik sonrası 1, 2 ve 4. kategorilerden birer, 8. kategoriden iki yayın ve bu kalemlerden en az 50 puan; toplam 150 puan.', 'Profesörlükte kategori dağılımı zorunlu: uluslararası makale, ulusal makale, kitap ve bildiri kalemlerinin her birinden ayrı ayrı yayın isteniyor.'],
    ],
];

$eslesmeler = [
    ['ek' => 'ek1', 'cetvel' => 'trakya-2025-ek1', 'alan' => ['saglik'], 'birim' => $BIRIM_FAKULTE, 'sart' => $ek1, 'myoPuan' => 30],
    ['ek' => 'ek2', 'cetvel' => 'trakya-2025-ek2', 'alan' => ['fen', 'muhendislik', 'ziraat'], 'birim' => $BIRIM_FAKULTE, 'sart' => $ek2, 'myoPuan' => 40],
    ['ek' => 'ek3', 'cetvel' => 'trakya-2025-ek3', 'alan' => ['mimarlik'], 'birim' => $BIRIM_FAKULTE, 'sart' => $ek3, 'myoPuan' => 40],
    ['ek' => 'ek4', 'cetvel' => 'trakya-2025-ek4', 'alan' => ['sosyal', 'egitim', 'ilahiyat', 'hukuk', 'filoloji'], 'birim' => $BIRIM_FAKULTE, 'sart' => $ek4, 'myoPuan' => 40],
    ['ek' => 'ek5', 'cetvel' => 'trakya-2025-ek5', 'alan' => ['guzel_sanatlar'], 'birim' => $BIRIM_KONSERVATUVAR, 'sart' => $ek5, 'myoPuan' => null],
    ['ek' => 'ek6', 'cetvel' => 'trakya-2025-ek6', 'alan' => ['guzel_sanatlar'], 'birim' => $BIRIM_GSF, 'sart' => $ek6, 'myoPuan' => 40],
    ['ek' => 'ek7', 'cetvel' => 'trakya-2025-ek7', 'alan' => ['spor'], 'birim' => $BIRIM_FAKULTE, 'sart' => $ek7, 'myoPuan' => 40],
];

$esikler = [];

foreach ($eslesmeler as $satir) {
    foreach ($satir['sart'] as $kadro => $sart) {
        $esikler[] = [
            'anahtar' => 'trakya-'.$satir['ek'].'-fak-'.str_replace('_', '-', $kadro),
            'universite' => 'Trakya Üniversitesi',
            'kadro' => $kadro,
            'alan' => $satir['alan'],
            'birim' => $satir['birim'],
            'cetvel' => $satir['cetvel'],
            'notlar' => $METIN[$satir['ek']][$kadro][0],
            'aday_notu' => $METIN[$satir['ek']][$kadro][1].' '.$ORTAK_ADAY,
            'sart' => $sart,
        ];
    }

    if ($satir['myoPuan'] === null) {
        continue;
    }

    $myoSartlari = $myo(strtoupper(str_replace('ek', 'EK-', $satir['ek'])), $satir['myoPuan']);

    foreach (['dr_ogr_uyesi', 'dr_ogr_uyesi_yeniden'] as $kadro) {
        $esikler[] = [
            'anahtar' => 'trakya-'.$satir['ek'].'-myo-'.str_replace('_', '-', $kadro),
            'universite' => 'Trakya Üniversitesi',
            'kadro' => $kadro,
            'alan' => $satir['alan'],
            'birim' => $BIRIM_MYO,
            'cetvel' => $satir['cetvel'],
            'notlar' => 'Meslek yüksekokulu doktor öğretim üyeliği: en az iki uluslararası indeksli yayın ve toplam '
                .$satir['myoPuan'].' puan (yeniden atamada 40 puan, en az yarısı uluslararası faaliyetlerden).',
            'aday_notu' => $MYO_ADAY.' '.$ORTAK_ADAY,
            'sart' => $myoSartlari[$kadro],
        ];
    }

    // Meslek yüksekokullarında doçentlik ve profesörlükte fakülte kriterleri
    // aranıyor; aynı şart ağacı meslek yüksekokulu birimiyle de kayıtlı.
    foreach (['docentlik', 'profesorluk'] as $kadro) {
        $esikler[] = [
            'anahtar' => 'trakya-'.$satir['ek'].'-myo-'.$kadro,
            'universite' => 'Trakya Üniversitesi',
            'kadro' => $kadro,
            'alan' => $satir['alan'],
            'birim' => $BIRIM_MYO,
            'cetvel' => $satir['cetvel'],
            'notlar' => 'Meslek yüksekokullarında doçentlik ve profesörlükte fakülte kriterleri aranıyor. '
                .$METIN[$satir['ek']][$kadro][0],
            'aday_notu' => $MYO_ADAY.' '.$METIN[$satir['ek']][$kadro][1].' '.$ORTAK_ADAY,
            'sart' => $satir['sart'][$kadro],
        ];
    }
}

// EK-4'ün araştırma enstitüleri için ayrı yazılmış koşulları.
foreach ($ek4Enstitu as $kadro => $sart) {
    $esikler[] = [
        'anahtar' => 'trakya-ek4-enstitu-'.str_replace('_', '-', $kadro),
        'universite' => 'Trakya Üniversitesi',
        'kadro' => $kadro,
        'alan' => ['sosyal', 'filoloji'],
        'birim' => $BIRIM_ENSTITU,
        'cetvel' => 'trakya-2025-ek4',
        'notlar' => 'EK-4 araştırma enstitüleri koşulları: ilk atamada toplam 60 puan (30\'u 1.a-1.d, 4.a-4.c, '
            .'4.e, 8.a-8.b kategorilerinden, en az ikisi tek ya da ilk isimli) ve tez yayını; yeniden atamada '
            .'75 puan; doçentlik ve profesörlükte fakülte koşullarına ek olarak tek/ilk isimli makale sayısı.',
        'aday_notu' => 'Bu eşik yalnız Balkan Araştırma Enstitüsü ile Roman Dili ve Kültürü Araştırmaları '
            .'Enstitüsü kadroları içindir; öteki enstitüler fakülte kriterlerine bağlı, onlar için "'
            .$BIRIM_FAKULTE.'" seçeneğini kullanın. '.$ORTAK_ADAY,
        'sart' => $sart,
    ];
}

return $esikler;
