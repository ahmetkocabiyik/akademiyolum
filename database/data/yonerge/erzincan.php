<?php

use App\Services\Scoring\Sart\Kalip;

/**
 * ERZİNCAN BİNALİ YILDIRIM ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına
 * Atanma ve Yükseltilme Uygulama Esasları (2021; 28.08.2025 tarihli YÖK
 * Genel Kurul kararıyla değişik)
 * Kaynak: pdf/1769428294367.erzincan-binali-yildirim-kriter-16102025gk-26012026.pdf
 *
 * Cetvel: cetvel/erzincan-2021.php
 *
 * ── EŞİKLERİN YAPISI ──
 * Yönerge yedi temel alan grubu tanımlıyor (Madde 5, 6 ve 8'in a-f
 * bentleri) ve her grup için doktor öğretim üyeliğinde ilk atama, doktor
 * öğretim üyeliğinde yeniden atama ve profesörlük koşullarını ayrı ayrı
 * yazıyor. Doçentlikte (Madde 7) tek koşul ÜAK doçentlik unvanı.
 *
 * ── YORUM KARARLARI (§0) ──
 *   Madde 6'nın "her bir yıl için ortalama en az 15 puan" koşulu
 *       hesaplanamıyor: araç atama tarihleri arasındaki yıl sayısını
 *       bilmiyor ve tek bir yılın barajını uygulamak koşulu olduğundan
 *       kolay gösterirdi. Koşul `hesaplanamiyor` düğümü olarak duruyor
 *       (Beykent'te de bu yol seçilmişti); yeniden atama sonucu bu yüzden
 *       "belirsiz" döner. Güzel Sanatlar alanının yıllık 15 puanlık sanat
 *       etkinliği ortalaması da aynı biçimde işaretlendi.
 *   Madde 4/l gereği yeniden atamada faaliyetlerin önceki atama tarihinden
 *       sonra yapılmış olması aranıyor; makale koşulları bu döneme bağlandı.
 *       Madde 6'nın "(hangi yıl gerçekleştirildiğine bakılmaksızın)"
 *       parantezi yalnızca puan ortalamasına ait okundu.
 *   Madde 8'in "sorumlu yazar" koşulu araçta BAŞLICA YAZAR rolüyle
 *       karşılanıyor; sorumlu yazarlığı işaretlemediğiniz yayınlar bu
 *       koşulu sağlamaz.
 *   Madde 5 ile 6 "özgün makale" derken cetvelin tam araştırma makalesi
 *       satırları sayıldı, derleme ve kısa makale satırları sayılmadı.
 *       Madde 8 "yayın" dediği için orada üç satır türü de sayılıyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 4/ö'nün SHT-147 kapsamında eğitim veren hava aracı bakım
 *       bölümleri için istediği modül sertifikaları — bölüme özgü ve
 *       kadroya göre değişen bir koşul; kayıt bu sertifikaları taşımıyor.
 *   Madde 4/o'nun Tıp ve Diş Hekimliği fakültelerinde aday çıkmaması
 *       hâlinde asgari koşullarla atama yapılabilmesine izin veren istisnası
 *       — koşulu gevşeten bir yol olduğu için §0 gereği yazılmadı.
 *   Madde 4'ün belgeleme, ISBN-ISSN ve "aynı kitapta en fazla 3 bölüm"
 *       gibi biçim kuralları.
 */
$FEN = ['fen', 'muhendislik', 'ziraat'];
$MIMARLIK = ['mimarlik'];
$SAGLIK = ['saglik'];
$SOSYAL = ['ilahiyat', 'filoloji', 'sosyal', 'egitim'];
$HUKUK = ['hukuk'];
$GUZEL_SANATLAR = ['guzel_sanatlar'];
$SPOR = ['spor'];

/**
 * Puan barajı kümelerinin ADAYA gösterilen adları (KONVANSIYONLAR §2).
 * PUAN: makale, kitap, bildiri, atıf ve proje. PUAN-MESLEKI aynı küme,
 * mesleki uygulama kalemleri de dahil.
 */
$PUAN_ADI = 'Makale, kitap, bildiri, atıf ve proje';
$PUAN_GRUP_ADI = [
    'PUAN' => $PUAN_ADI,
    'PUAN-MESLEKI' => 'Makale, kitap, bildiri, atıf, proje, sanatsal etkinlik ve ödül',
];

/** Doktor öğretim üyeliğine ilk atama: Madde 5. */
$drIlk = fn (string $grup, string $puanGrup, string $madde): array => Kalip::ve('Doktor öğretim üyeliğine ilk atama koşulları', [
    Kalip::yds(55),
    Kalip::adet('Makaleler başlığındaki ilgili maddelerde tanımlanan dergilerde en az 1 özgün makale', [$grup], 1, madde: $madde.'/1'),
    Kalip::toplam(40, maddeler: [$puanGrup], liste: $PUAN_GRUP_ADI[$puanGrup]),
]);

/** Doktor öğretim üyeliğine yeniden atama: Madde 6 (Madde 4/l ile). */
$drYeniden = fn (string $grup, int $sayi, string $madde): array => Kalip::ve('Doktor öğretim üyeliğine yeniden atama koşulları', [
    Kalip::adet('Makaleler başlığındaki ilgili maddelerde tanımlanan dergilerde en az '.$sayi.' özgün makale', [$grup], $sayi, donem: Kalip::SON_ATAMA_SONRASI, madde: $madde.'/1'),
    Kalip::hesaplanamiyor('Makaleler, Kitap-Kitap Bölümleri, Bildiriler, Atıflar ve Projeler başlığındaki faaliyetlerden her bir yıl için ortalama en az 15 puan almak', $madde.'/2'),
]);

/**
 * Profesörlük — Fen, Mühendislik, Ziraat ve Sağlık: Madde 8/a ve 8/c.
 * Madde 1 dergilerinde, en az birinde sorumlu yazar olmak üzere 2 yayın.
 */
$profFen = fn (string $madde): array => Kalip::ve('Profesörlük koşulları', [
    Kalip::adet('SSCI, SCI-Expanded ve AHCI dergilerinde en az 2 yayın', ['MAKALE-1-TUM'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: $madde.'/1'),
    Kalip::adet('Bu yayınlardan en az birinde sorumlu yazar olmak', ['MAKALE-1-TUM'], 1, yazar: 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: $madde.'/1'),
    Kalip::toplam(200, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['PUAN'], liste: $PUAN_ADI),
    Kalip::toplam(250, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM-DERS-HARIC'], liste: 'Verdiğiniz dersler dışındaki tüm faaliyet'),
]);

/**
 * Profesörlük — Mimarlık, Sosyal, Hukuk ve Spor: Madde 8/b, 8/ç, 8/d, 8/f.
 * 1-4. maddelerde 4 yayın VEYA 1. maddede 1 VEYA 2. maddede 2 yayın; en az
 * bir yayında sorumlu yazar olmak.
 */
$profSosyal = fn (int $puan, int $toplam, string $puanGrup, string $madde): array => Kalip::ve('Profesörlük koşulları', [
    Kalip::veya('Makaleler başlığında yayın koşulu', [
        Kalip::adet('SSCI-SCI-AHCI, ESCI, diğer uluslararası indeksli ve TR Dizin dergilerinde en az 4 yayın', ['MAKALE-1-4-TUM'], 4, donem: Kalip::DOCENTLIK_SONRASI, madde: $madde.'/1'),
        Kalip::adet('SSCI, SCI-Expanded ya da AHCI dergilerinde en az 1 yayın', ['MAKALE-1-TUM'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: $madde.'/1'),
        Kalip::adet('ESCI, Scopus ve TR Dizin dergilerinde en az 2 yayın', ['MAKALE-2-TUM'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: $madde.'/1'),
    ]),
    Kalip::adet('Yayınlarınızdan en az birinde sorumlu yazar olmak', ['MAKALE-1-4-TUM'], 1, yazar: 'baslica', donem: Kalip::DOCENTLIK_SONRASI, madde: $madde.'/1'),
    Kalip::toplam($puan, donem: Kalip::DOCENTLIK_SONRASI, maddeler: [$puanGrup], liste: $PUAN_GRUP_ADI[$puanGrup]),
    Kalip::toplam($toplam, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM-DERS-HARIC'], liste: 'Verdiğiniz dersler dışındaki tüm faaliyet'),
]);

$DR_NOTU = 'Doktor öğretim üyeliğine ilk atamada yabancı dil sınavından en az 55 puan '
    .'gerekiyor; atama yapılacak alanı yabancı dil olan bölümlerde bu eşik 85 puana çıkıyor, '
    .'araç 55 üzerinden değerlendiriyor.';

$YENIDEN_NOTU = 'Yeniden atamada yönerge, atama tarihleri arasındaki HER YIL için ortalama '
    .'en az 15 puan istiyor. Araç iki atama arasındaki yıl sayısını bilmediği için bu koşulu '
    .'hesaplayamıyor ve sonucu "belirsiz" bırakıyor; toplam puanınızı geçen yıl sayısına '
    .'bölerek kendiniz kontrol etmeniz gerekiyor. Yönergenin 4/l maddesi gereği yalnızca bir '
    .'önceki atama tarihinden sonraki faaliyetler sayılıyor.';

$PROF_NOTU = 'Profesörlükte tüm koşullar doçent unvanını aldıktan sonraki çalışmalardan '
    .'sayılıyor. "Sorumlu yazar" koşulu araçta BAŞLICA YAZAR rolüyle karşılanıyor; yayın '
    .'kaydınızda bu rolü işaretlemezseniz koşul sağlanmamış görünür.';

return [
    // ══════════ FEN, MÜHENDİSLİK, ZİRAAT ══════════
    [
        'anahtar' => 'erzincan-fen-dr',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $FEN,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 5/a: 1. maddede tanımlanan (SSCI, SCI-Expanded, AHCI) dergilerde en az '
            .'1 özgün makale; Makaleler, Kitaplar, Bildiriler, Atıflar ve Projeler başlıklarından '
            .'en az 40 puan.',
        'aday_notu' => 'Fen Bilimleri ve Matematik, Mühendislik ile Ziraat, Orman ve Su Ürünleri '
            .'temel alanlarında ilk atama için SSCI, SCI-Expanded ya da AHCI kapsamındaki bir '
            .'dergide en az bir özgün makale şart; diğer indeksler bu koşulu karşılamıyor. '
            .'40 puanlık baraj yalnızca makale, kitap, bildiri, atıf ve proje kalemlerinden '
            .'hesaplanıyor; ders, editörlük, hakemlik ve idari görev puanlarınız bu barajın '
            .'dışında. '.$DR_NOTU,
        'sart' => $drIlk('MAKALE-1', 'PUAN', 'Madde 5/a'),
    ],
    [
        'anahtar' => 'erzincan-fen-dr-yeniden',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $FEN,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 6/a: 1. maddede tanımlanan dergilerde en az 1 özgün makale; her bir '
            .'yıl için ortalama en az 15 puan.',
        'aday_notu' => 'Yeniden atamada da SSCI, SCI-Expanded ya da AHCI kapsamında en az bir '
            .'özgün makale aranıyor. '.$YENIDEN_NOTU,
        'sart' => $drYeniden('MAKALE-1', 1, 'Madde 6/a'),
    ],
    [
        'anahtar' => 'erzincan-fen-profesorluk',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $FEN,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 8/a: 1. maddede tanımlanan dergilerde en az birinde sorumlu yazar '
            .'olmak koşuluyla 2 yayın; Makaleler, Kitaplar, Bildiriler, Atıflar ve Projelerden '
            .'200 puan; Dersler dışındaki tüm faaliyetlerden 250 puan.',
        'aday_notu' => 'Profesörlük için SSCI, SCI-Expanded ya da AHCI kapsamındaki dergilerde '
            .'en az iki yayın gerekiyor ve bunlardan en az birinde sorumlu yazar olmalısınız. '
            .'Puan barajı iki katmanlı: makale, kitap, bildiri, atıf ve projeden 200 puan; buna '
            .'editörlük, hakemlik, patent, ödül, tez danışmanlığı ve idari görev puanlarınızın '
            .'da eklenmesiyle 250 puan. Ders puanları hiçbir barajda sayılmıyor. '.$PROF_NOTU,
        'sart' => $profFen('Madde 8/a'),
    ],

    // ══════════ MİMARLIK, PLANLAMA VE TASARIM ══════════
    [
        'anahtar' => 'erzincan-mimarlik-dr',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $MIMARLIK,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 5/b: 1, 2, 3 veya 4. maddelerde tanımlanan dergilerde en az 1 özgün '
            .'makale; ilgili başlıklardan en az 40 puan.',
        'aday_notu' => 'Mimarlık, Planlama ve Tasarım temel alanında zorunlu makale koşulu daha '
            .'geniş: SSCI-SCI-AHCI, ESCI-alan indeksleri, diğer indeksli uluslararası dergiler ve '
            .'TR-Dizin kapsamındaki dergilerin herhangi birinde bir özgün makale yeterli. '.$DR_NOTU,
        'sart' => $drIlk('MAKALE-1-4', 'PUAN', 'Madde 5/b'),
    ],
    [
        'anahtar' => 'erzincan-mimarlik-dr-yeniden',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $MIMARLIK,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 6/b: 1, 2, 3 veya 4. maddelerde en az 1 özgün makale; yılda ortalama '
            .'15 puan.',
        'aday_notu' => 'Yeniden atamada uluslararası indeksli ve TR Dizin dergilerinde en az bir özgün makale '
            .'aranıyor. '.$YENIDEN_NOTU,
        'sart' => $drYeniden('MAKALE-1-4', 1, 'Madde 6/b'),
    ],
    [
        'anahtar' => 'erzincan-mimarlik-profesorluk',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $MIMARLIK,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 8/b: en az 1 yayında sorumlu yazar olmak koşuluyla 1-4. maddelerde 4 '
            .'veya 1. maddede 1 veya 2. maddede 2 yayın; 200 ve 250 puan barajları.',
        'aday_notu' => 'Yayın koşulunu üç yoldan biriyle sağlayabilirsiniz: uluslararası indeksli '
            .'ve TR Dizin '
            .'dergilerde toplam dört yayın, ya da SSCI-SCI-AHCI kapsamında tek bir yayın, ya da '
            .'ESCI-alan indeksleri kapsamında iki yayın. Hangi yolu seçerseniz seçin en az bir '
            .'yayında sorumlu yazar olmanız gerekiyor. Puan barajları 200 (makale, kitap, '
            .'bildiri, atıf, proje) ve 250 (dersler dışındaki tüm faaliyetler). '.$PROF_NOTU,
        'sart' => $profSosyal(200, 250, 'PUAN', 'Madde 8/b'),
    ],

    // ══════════ SAĞLIK BİLİMLERİ ══════════
    [
        'anahtar' => 'erzincan-saglik-dr',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $SAGLIK,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 5/c: 1 veya 2. maddelerde tanımlanan dergilerde en az 1 özgün makale; '
            .'ilgili başlıklardan en az 40 puan.',
        'aday_notu' => 'Sağlık Bilimleri temel alanında zorunlu makalenin SSCI, SCI-Expanded, '
            .'AHCI ya da ESCI-alan indeksleri kapsamındaki bir dergide yayımlanmış olması '
            .'gerekiyor; TR-Dizin ve diğer indeksler bu koşulu karşılamıyor. '.$DR_NOTU,
        'sart' => $drIlk('MAKALE-1-2', 'PUAN', 'Madde 5/c'),
    ],
    [
        'anahtar' => 'erzincan-saglik-dr-yeniden',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $SAGLIK,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 6/c: 1 veya 2. maddelerde en az 1 özgün makale; yılda ortalama 15 puan.',
        'aday_notu' => 'Yeniden atamada da makalenin SSCI-SCI-AHCI ya da ESCI-alan indeksleri '
            .'kapsamında olması gerekiyor. '.$YENIDEN_NOTU,
        'sart' => $drYeniden('MAKALE-1-2', 1, 'Madde 6/c'),
    ],
    [
        'anahtar' => 'erzincan-saglik-profesorluk',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $SAGLIK,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 8/c: 1. maddede tanımlanan dergilerde en az birinde sorumlu yazar '
            .'olmak koşuluyla 2 yayın; 200 ve 250 puan barajları.',
        'aday_notu' => 'Sağlık Bilimlerinde profesörlük için SSCI, SCI-Expanded ya da AHCI '
            .'kapsamındaki dergilerde en az iki yayın ve bunlardan birinde sorumlu yazarlık '
            .'aranıyor. '.$PROF_NOTU,
        'sart' => $profFen('Madde 8/c'),
    ],

    // ══════════ İLAHİYAT, FİLOLOJİ, SOSYAL, EĞİTİM ══════════
    [
        'anahtar' => 'erzincan-sosyal-dr',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $SOSYAL,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 5/ç: 1, 2, 3 veya 4. maddelerde en az 1 özgün makale; ilgili '
            .'başlıklardan en az 40 puan.',
        'aday_notu' => 'İlahiyat, Filoloji, Sosyal-Beşerî-İdari Bilimler ve Eğitim Bilimleri '
            .'temel alanlarında zorunlu makale uluslararası indeksli ve TR Dizin '
            .'dergilerinin herhangi birinden '
            .'olabilir; TR-Dizin makalesi de kabul ediliyor. '.$DR_NOTU,
        'sart' => $drIlk('MAKALE-1-4', 'PUAN', 'Madde 5/ç'),
    ],
    [
        'anahtar' => 'erzincan-sosyal-dr-yeniden',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $SOSYAL,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 6/ç: 1, 2, 3 veya 4. maddelerde en az 2 özgün makale; yılda ortalama '
            .'15 puan.',
        'aday_notu' => 'Yeniden atamada bu alanlarda iki özgün makale isteniyor (ilk atamada bir '
            .'taneydi). '.$YENIDEN_NOTU,
        'sart' => $drYeniden('MAKALE-1-4', 2, 'Madde 6/ç'),
    ],
    [
        'anahtar' => 'erzincan-sosyal-profesorluk',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $SOSYAL,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 8/ç: en az 1 yayında sorumlu yazar olmak koşuluyla 1-4. maddelerde 4 '
            .'veya 1. maddede 1 veya 2. maddede 2 yayın; 200 ve 250 puan barajları.',
        'aday_notu' => 'Yayın koşulunu üç yoldan biriyle sağlayabilirsiniz: uluslararası indeksli '
            .'ve TR Dizin '
            .'dergilerde toplam dört yayın, SSCI-SCI-AHCI kapsamında tek yayın, ya da ESCI-alan '
            .'indeksleri kapsamında iki yayın. En az bir yayında sorumlu yazar olmanız '
            .'gerekiyor. '.$PROF_NOTU,
        'sart' => $profSosyal(200, 250, 'PUAN', 'Madde 8/ç'),
    ],

    // ══════════ HUKUK ══════════
    [
        'anahtar' => 'erzincan-hukuk-dr',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $HUKUK,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 5/d: 1, 2, 3 veya 4. maddelerde en az 1 özgün makale; ilgili '
            .'başlıklardan en az 40 puan.',
        'aday_notu' => 'Hukuk temel alanında ilk atama için uluslararası indeksli ve TR Dizin '
            .'dergilerinin '
            .'herhangi birinde bir özgün makale yeterli. '.$DR_NOTU,
        'sart' => $drIlk('MAKALE-1-4', 'PUAN', 'Madde 5/d'),
    ],
    [
        'anahtar' => 'erzincan-hukuk-dr-yeniden',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $HUKUK,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 6/d: 1-4. maddelerde en az 2 özgün makale VEYA lisansüstü tezlerden '
            .'üretilmemiş, ders kitabı niteliği dışında en az 1 özgün bilimsel kitap; yılda '
            .'ortalama 15 puan.',
        'aday_notu' => 'Hukukta yeniden atamanın yayın koşulunu iki yoldan sağlayabilirsiniz: '
            .'uluslararası indeksli ve TR Dizin dergilerinde iki özgün makale, ya da ders '
            .'kitabı niteliğinde '
            .'olmayan ve lisansüstü tezinizden üretilmemiş bir özgün bilimsel kitap. Araç '
            .'kitabın tezden üretilip üretilmediğini bilmediği için bu ayrımı '
            .'değerlendiremiyor; kitabınız tezinizden üretildiyse koşul sağlanmış '
            .'görünse de kabul edilmez. '.$YENIDEN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliğine yeniden atama koşulları', [
            Kalip::veya('Yayın koşulu', [
                Kalip::adet('SSCI-SCI-AHCI, ESCI, diğer uluslararası indeksli ve TR Dizin dergilerinde en az 2 özgün makale', ['MAKALE-1-4'], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Madde 6/d-1'),
                Kalip::adet('Ders kitabı niteliği dışında, lisansüstü tezlerden üretilmemiş en az 1 özgün bilimsel kitap', ['KITAP-OZGUN'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Madde 6/d-1'),
            ]),
            Kalip::hesaplanamiyor('Makaleler, Kitap-Kitap Bölümleri, Bildiriler, Atıflar ve Projeler başlığındaki faaliyetlerden her bir yıl için ortalama en az 15 puan almak', 'Madde 6/d-2'),
        ]),
    ],
    [
        'anahtar' => 'erzincan-hukuk-profesorluk',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $HUKUK,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 8/d: yayın koşulu diğer sosyal alanlarla aynı; puan barajları 150 ve '
            .'200 (diğer alanlarda 200 ve 250).',
        'aday_notu' => 'Hukuk temel alanında puan barajları diğer alanlardan düşük: makale, '
            .'kitap, bildiri, atıf ve projeden 150 puan; dersler dışındaki tüm faaliyetlerden '
            .'200 puan. Yayın koşulu ise aynı: makale kalemlerinden dört yayın, '
            .'SSCI-SCI-AHCI dergilerinde bir yayın '
            .'ya da ESCI, Scopus ve TR Dizin dergilerinde iki yayın; en az birinde sorumlu yazar. '.$PROF_NOTU,
        'sart' => $profSosyal(150, 200, 'PUAN', 'Madde 8/d'),
    ],

    // ══════════ GÜZEL SANATLAR ══════════
    [
        'anahtar' => 'erzincan-guzel-sanatlar-dr',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $GUZEL_SANATLAR,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 5/e: 1-4. maddelerde en az 1 özgün makale; ilgili başlıklardan en az '
            .'40 puan; Sanat ve Tasarım Etkinliklerinden en az 50 puan.',
        'aday_notu' => 'Güzel Sanatlar temel alanında iki ayrı puan barajı var: makale, kitap, '
            .'bildiri, atıf ve projeden 40 puan ve Sanat ve Tasarım Etkinlikleri başlığından 50 '
            .'puan. Sanat barajında küratörlük, festival çalışmaları ve arkeolojik kazı '
            .'satırları faaliyet kaydında karşılığı olmadığı için sayılmıyor; sanat puanınız '
            .'olduğundan düşük çıkabilir. '.$DR_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliğine ilk atama koşulları', [
            Kalip::yds(55),
            Kalip::adet('SSCI-SCI-AHCI, ESCI, diğer uluslararası indeksli ve TR Dizin dergilerinde en az 1 özgün makale', ['MAKALE-1-4'], 1, madde: 'Madde 5/e-1'),
            Kalip::toplam(40, maddeler: ['PUAN'], liste: $PUAN_ADI),
            Kalip::toplam(50, maddeler: ['SANAT'], liste: 'Sanatsal etkinlik ve ödül'),
        ]),
    ],
    [
        'anahtar' => 'erzincan-guzel-sanatlar-dr-yeniden',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $GUZEL_SANATLAR,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 6/e: 1-5. maddelerde en az 2 özgün makale; yılda ortalama 15 puan; '
            .'Sanat ve Tasarım Etkinliklerinden yılda ortalama 15 puan.',
        'aday_notu' => 'Yeniden atamada iki özgün makale isteniyor ve makale koşulu diğer '
            .'alanlardan geniş: diğer hakemli dergiler de sayılıyor. İki ayrı '
            .'yıllık ortalama koşulu (15 puan bilimsel, 15 puan sanatsal) araç tarafından '
            .'hesaplanamıyor. '.$YENIDEN_NOTU,
        'sart' => Kalip::ve('Doktor öğretim üyeliğine yeniden atama koşulları', [
            Kalip::adet('SSCI-SCI-AHCI, ESCI, diğer uluslararası indeksli, TR Dizin ve diğer hakemli dergilerde en az 2 özgün makale', ['MAKALE-1-5'], 2, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Madde 6/e-1'),
            Kalip::hesaplanamiyor('Makaleler, Kitap-Kitap Bölümleri, Bildiriler, Atıflar ve Projeler başlığındaki faaliyetlerden her bir yıl için ortalama en az 15 puan almak', 'Madde 6/e-2'),
            Kalip::hesaplanamiyor('Sanat ve Tasarım Etkinlikleri başlığındaki faaliyetlerden her bir yıl için ortalama en az 15 puan almak', 'Madde 6/e-3'),
        ]),
    ],
    [
        'anahtar' => 'erzincan-guzel-sanatlar-profesorluk',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $GUZEL_SANATLAR,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 8/e: 1-4. maddelerde en az 3 yayın; ilgili başlıklardan 80 puan; '
            .'Dersler dışındaki tüm faaliyetlerden 250 puan. Sorumlu yazar koşulu yok.',
        'aday_notu' => 'Güzel Sanatlarda profesörlük için uluslararası indeksli ve TR Dizin '
            .'dergilerinde üç yayın '
            .'gerekiyor; bu alanda sorumlu yazarlık koşulu aranmıyor. Puan barajları da farklı: '
            .'makale, kitap, bildiri, atıf ve projeden yalnızca 80 puan, ama dersler dışındaki '
            .'tüm faaliyetlerden 250 puan. Aradaki farkı Sanat ve Tasarım Etkinlikleri '
            .'kapatıyor. '.$PROF_NOTU,
        'sart' => Kalip::ve('Profesörlük koşulları', [
            Kalip::adet('SSCI-SCI-AHCI, ESCI, diğer uluslararası indeksli ve TR Dizin dergilerinde en az 3 yayın', ['MAKALE-1-4-TUM'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Madde 8/e-1'),
            Kalip::toplam(80, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['PUAN'], liste: $PUAN_ADI),
            Kalip::toplam(250, donem: Kalip::DOCENTLIK_SONRASI, maddeler: ['TUM-DERS-HARIC'], liste: 'Verdiğiniz dersler dışındaki tüm faaliyet'),
        ]),
    ],

    // ══════════ SPOR BİLİMLERİ ══════════
    [
        'anahtar' => 'erzincan-spor-dr',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $SPOR,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 5/f: 1-4. maddelerde en az 1 özgün makale; Makaleler, Kitaplar, '
            .'Bildiriler, Atıflar, Projeler ile Mesleki Faaliyetlerden en az 40 puan.',
        'aday_notu' => 'Spor Bilimleri temel alanında 40 puanlık barajın kaynağına Mesleki '
            .'Faaliyetler başlığı da giriyor. Ancak spor etkinlikleri bölümü '
            .'bölümü (millî takım görevi, spor hakemliği, organizasyon, federasyon kurulu, '
            .'sportif ödüller) faaliyet kaydında karşılığı olmadığı için girilemedi; sportif '
            .'kariyeri olan adayın puanı burada olduğundan belirgin biçimde düşük çıkar. '.$DR_NOTU,
        'sart' => $drIlk('MAKALE-1-4', 'PUAN-MESLEKI', 'Madde 5/f'),
    ],
    [
        'anahtar' => 'erzincan-spor-dr-yeniden',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $SPOR,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 6/f: 1-5. maddelerde en az 2 özgün makale; yılda ortalama 15 puan.',
        'aday_notu' => 'Yeniden atamada iki özgün makale isteniyor; diğer hakemli '
            .'dergiler de sayılıyor. '.$YENIDEN_NOTU,
        'sart' => $drYeniden('MAKALE-1-5', 2, 'Madde 6/f'),
    ],
    [
        'anahtar' => 'erzincan-spor-profesorluk',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => $SPOR,
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 8/f: yayın koşulu sosyal alanlarla aynı; 150 puan (Mesleki '
            .'Faaliyetler dahil) ve 200 puan barajları.',
        'aday_notu' => 'Spor Bilimlerinde profesörlük puan barajları 150 ve 200. İlk baraja '
            .'Mesleki Faaliyetler başlığı da giriyor; ancak spor etkinlikleri bölümü '
            .'girilemediği için sportif kalemleriniz sayılmıyor. '.$PROF_NOTU,
        'sart' => $profSosyal(150, 200, 'PUAN-MESLEKI', 'Madde 8/f'),
    ],

    // ══════════ DOÇENTLİK (TÜM ALANLAR) ══════════
    [
        'anahtar' => 'erzincan-docentlik',
        'universite' => 'Erzincan Binali Yıldırım Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => [...$FEN, ...$MIMARLIK, ...$SAGLIK, ...$SOSYAL, ...$HUKUK, ...$GUZEL_SANATLAR, ...$SPOR],
        'cetvel' => 'erzincan-2021',
        'notlar' => 'Madde 7: tek koşul ÜAK doçentlik asgari başvuru koşullarını sağlayıp doçent '
            .'unvanını almış olmak. Üniversite ayrıca bir puan barajı koymuyor.',
        'aday_notu' => 'Erzincan Binali Yıldırım Üniversitesinde doçent kadrosuna atanmak için '
            .'yönergenin koyduğu tek ek koşul, Üniversitelerarası Kurulun doçentlik için '
            .'belirlediği asgari başvuru koşullarını yerine getirmiş ve doçent unvanını almış '
            .'olmaktır. Üniversite bu kadroda ayrı bir performans puanı aramıyor.',
        'sart' => Kalip::beyan('Üniversitelerarası Kurul tarafından doçentlik için belirlenen asgari başvuru koşullarını yerine getirmiş ve doçent unvanını almış olmak', 'Madde 7'),
    ],
];
