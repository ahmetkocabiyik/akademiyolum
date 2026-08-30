<?php

/**
 * ANKARA SOSYAL BİLİMLER ÜNİVERSİTESİ — Öğretim Üyeliğine Atama ve
 * Yükseltme Esasları
 * Kaynak: pdf/17634002431.Ankara Sosyal Bilimler Üniversitesi Kriter.pdf
 * Cetvel: cetvel/asbu-2024.php
 *
 * ── DÖRT TEMEL ALAN ──
 * Esaslar dört temel alan sayıyor: Sosyal, Beşeri ve İdari Bilimler
 * (eğitim dili İngilizce ve Türkçe programlar için ayrı satırlarla),
 * Hukuk, İlahiyat ve Filoloji. ASBÜ bir sosyal bilimler üniversitesi;
 * Fen, Mühendislik, Sağlık, Eğitim, Spor, Mimarlık, Güzel Sanatlar ve
 * Ziraat temel alanları esaslarda HİÇ geçmiyor, §0 uyarınca eşik
 * yazılmadı.
 *
 * ── EĞİTİM DİLİ AYRIMI BİRİMLE ÇÖZÜLDÜ ──
 * Sosyal, Beşeri ve İdari Bilimler temel alanı iki satıra bölünmüş:
 * eğitim dili İNGİLİZCE olan programlarda yayın şartının tek yolu var
 * (A1, B1 veya B2 kalemleri), TÜRKÇE olan programlarda ise alternatif
 * bir yol daha açılıyor (A2, A3, B3-B6'dan daha çok sayıda yayın).
 * İki satır aynı temel alana düştüğü için `birim` ayrımı kullanıldı.
 * Hukuk, İlahiyat ve Filoloji Türkçe satırıyla aynı koşullara tabi.
 *
 * ── YABANCI DİL ──
 * Esaslar beş ayrı dil yolu sayıyor: eğitim dilinde yurt dışında ya da
 * yurt içinde doktora yapmış olmak; yabancı dilde eğitim yapan birimlerde
 * 85; ilanda özel olarak belirtilecek puan; %30 yabancı dilli ya da %100
 * Türkçe birimlerde 70; %100 İngilizce olması planlanan birimlerde 85.
 * Sayısal eşik olarak en yaygın hâl olan 70 uygulandı, öbür yollar beyan
 * koşulu olarak duruyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   "İlan edilen kadro unvanından daha üst unvanda bulunanların
 *       başvuruları işleme alınmaz" (Temel Şartlar 2) — süreç hükmü.
 *   Yayınevi tanımlarındaki "en az dört yıl düzenli faaliyet", "dünyada
 *       ilk 500 üniversite kütüphanesinde kataloglanmış" ve "aynı alanda
 *       en az 20 kitap yayımlamış" şartları — kayıt yayınevinin
 *       niteliğini taşımıyor.
 *   "Bu şartların sağlanması atama ve yükseltme için yeterli
 *       bulunmayabilir; atamalarda aslolan jüri değerlendirmeleridir."
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Ankara Sosyal Bilimler Üniversitesi';
$CETVEL = 'asbu-2024';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$DIL = Kalip::yds(70);
$DIL_NOT = Kalip::beyan(
    'Yabancı dilde eğitim yapan ya da %100 İngilizce olması planlanan birimlerde en az 85 puan; başvurulacak anabilim dalı için ilanda özel olarak belirtilen puan; ya da başvurulan birimin eğitim dilinde doktora yapmış olmak',
    'Yabancı Dil Şartı'
);
$UNVAN = Kalip::beyan(
    'Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak',
    '2547 s.K. m.24'
);

$NOT_CETVEL = ' Çok yazarlı yayınlarda puan yazar sayısına eşit bölünüyor. Verilen derslerden '
    .'en fazla 15, çevirilerden 15, atıflardan 25 puan alınabiliyor. Tabloda patent, sanatsal '
    .'etkinlik ve toplumsal katkı satırı yok; ders kitapları da B ve C bölümlerinin dipnotuyla '
    .'açıkça dışlanmış, bu kayıtlarınız toplam puanınıza katkı vermiyor. Ödül satırlarına, '
    .'kayıt ödülün derecesini taşımadığı için üçüncülük değeri (%70) uygulanıyor.';

/** A1, B1 veya B2 kalemlerinden yayın koşulu. */
$a1b1b2 = fn (string $ad, int $n, ?array $donem = null): array => Kalip::adet(
    $ad, ['A1-B1-B2'], $n, donem: $donem, madde: 'Yayın Şartı'
);
/** A2, A3, B3-B6 kalemlerinden yayın koşulu. */
$digerYayin = fn (string $ad, int $n, ?array $donem = null): array => Kalip::adet(
    $ad, ['A2-A3-B3-B4-B5-B6'], $n, donem: $donem, madde: 'Yayın Şartı'
);

$esikler = [];

/**
 * Bir alan grubunun dört kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 */
$grup = function (string $kod, array $alanlar, ?string $birim, string $ad, bool $ingilizce) use (&$esikler, $UNIVERSITE, $CETVEL, $DIL, $DIL_NOT, $UNVAN, $DOKTORA, $DOCENTLIK,
    $SON_ATAMA, $NOT_CETVEL, $a1b1b2, $digerYayin): void {
    $ingilizceNotu = $ingilizce
        ? ' Eğitim dili İNGİLİZCE olan programlarda yayın şartının tek yolu var: A1, B1 ya da '
            .'kitap kalemlerinden yayın. Türkçe programların alternatif yolu (alan indeksli '
            .'dergiler ve kitap kalemlerinden '
            .'daha çok sayıda yayın) burada geçerli değil.'
        : '';

    $drYayin = $ingilizce
        ? $a1b1b2('A1, B1 ya da B2 kalemlerinden en az bir yayın yapmış olmak', 1)
        : Kalip::veya('Yayın şartını sağlamak', [
            $a1b1b2('A1, B1 ya da B2 kalemlerinden en az bir yayın yapmış olmak', 1),
            $digerYayin('A2, A3, B3, B4, B5 ya da B6 kalemlerinden en az dört yayın yapmış olmak', 4),
        ]);

    $docYayin = $ingilizce
        ? Kalip::ve('A1, B1 ya da B2 kalemlerinden dört yayın (en az ikisi doktora sonrası)', [
            $a1b1b2('A1, B1 ya da B2 kalemlerinden en az dört yayın yapmış olmak', 4),
            $a1b1b2('Bu yayınlardan en az ikisini doktora derecenizi aldıktan sonra yapmış olmak', 2, $DOKTORA),
        ])
        : Kalip::veya('Yayın şartını sağlamak', [
            Kalip::ve('A1, B1 ya da B2 kalemlerinden dört yayın (en az ikisi doktora sonrası)', [
                $a1b1b2('A1, B1 ya da B2 kalemlerinden en az dört yayın yapmış olmak', 4),
                $a1b1b2('Bu yayınlardan en az ikisini doktora derecenizi aldıktan sonra yapmış olmak', 2, $DOKTORA),
            ]),
            $digerYayin('A2, A3, B3, B4, B5 ya da B6 kalemlerinden en az altı yayın yapmış olmak', 6),
        ]);

    $profYayin = $ingilizce
        ? Kalip::ve('A1, B1 ya da B2 kalemlerinden dört yayın (en az ikisi doçentlik sonrası)', [
            $a1b1b2('A1, B1 ya da B2 kalemlerinden en az dört yayın yapmış olmak', 4),
            $a1b1b2('Bu yayınlardan en az ikisini doçentlik unvanını aldıktan sonra yapmış olmak', 2, $DOCENTLIK),
        ])
        : Kalip::veya('Yayın şartını sağlamak', [
            Kalip::ve('A1, B1 ya da B2 kalemlerinden dört yayın (en az ikisi doçentlik sonrası)', [
                $a1b1b2('A1, B1 ya da B2 kalemlerinden en az dört yayın yapmış olmak', 4),
                $a1b1b2('Bu yayınlardan en az ikisini doçentlik unvanını aldıktan sonra yapmış olmak', 2, $DOCENTLIK),
            ]),
            $digerYayin('A2, A3, B3, B4, B5 ya da B6 kalemlerinden en az altı yayın yapmış olmak', 6),
        ]);

    $esikler[] = [
        'anahtar' => "asbu-{$kod}-dr",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doktor öğretim üyeliği ilk atama: en az 60 puan ve yayın şartı.',
        'aday_notu' => $ad.' için doktor öğretim üyesi kadrosuna İLK ATANMA. Esaslar ilk '
            .'atamada dönem sınırı koymuyor, bütün akademik geçmişiniz sayılıyor. Doktor '
            .'öğretim üyeliğine atama süresi iki yıl.'.$ingilizceNotu.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna ilk atanma — '.$ad, [
            $DIL, $DIL_NOT, $drYayin, Kalip::toplam(60),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "asbu-{$kod}-dr-yeniden",
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi_yeniden',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doktor öğretim üyeliği yeniden atama: bir önceki atamadan itibaren '
            .'en az 40 puan ve yayın şartı. Yeniden atamada eğitim dili ayrımı yok.',
        'aday_notu' => $ad.' için doktor öğretim üyesi kadrosuna YENİDEN ATANMA. Şartların BİR '
            .'ÖNCEKİ ATAMADAN İTİBAREN sağlanması gerekiyor. Yeniden atamada eğitim dili ayrımı '
            .'yok: İngilizce programlarda da alternatif yayın yolu açık. Asgari yayın '
            .'şartlarını karşılayan çalışmaların lisansüstü tezlerinizden ÜRETİLMEMİŞ olması '
            .'gerekiyor; kayıt bunu taşımadığı için o koşul beyan olarak duruyor.'.$NOT_CETVEL,
        'sart' => Kalip::ve('Doktor öğretim üyesi kadrosuna yeniden atanma — '.$ad, [
            $DIL, $DIL_NOT,
            Kalip::veya('Yayın şartını sağlamak', [
                $a1b1b2('A1, B1 ya da B2 kalemlerinden en az bir yayın yapmış olmak', 1, $SON_ATAMA),
                $digerYayin('A2, A3, B3, B4, B5 ya da B6 kalemlerinden en az iki yayın yapmış olmak', 2, $SON_ATAMA),
            ]),
            Kalip::beyan('Asgari yayın şartını karşılayan çalışmaların lisansüstü tezlerinizden üretilmemiş olması', 'Doktor Öğretim Üyeliği Yeniden Atama Şartları'),
            Kalip::toplam(40, $SON_ATAMA),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "asbu-{$kod}-docentlik",
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' doçentlik: en az 100 puan ve yayın şartı.',
        'aday_notu' => $ad.' için doçent kadrosuna atanma. Puan barajında dönem sınırı yok; '
            .'yayın şartındaki dört yayının en az ikisinin DOKTORA SONRASI olması '
            .'gerekiyor.'.$ingilizceNotu.$NOT_CETVEL,
        'sart' => Kalip::ve('Doçent kadrosuna atanma — '.$ad, [
            $UNVAN, $DIL, $DIL_NOT, $docYayin, Kalip::toplam(100),
        ]),
    ];

    $esikler[] = [
        'anahtar' => "asbu-{$kod}-profesorluk",
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $ad.' profesörlük: en az 150 puan, yayın şartı ve doçentlik sürecinde dört '
            .'yarıyıl lisans dersi verme tecrübesi.',
        'aday_notu' => $ad.' için profesör kadrosuna atanma. Puan barajında dönem sınırı yok; '
            .'yayın şartındaki dört yayının en az ikisinin DOÇENTLİK UNVANI ALINDIKTAN SONRA '
            .'olması gerekiyor. Ayrıca doçentlik sürecinde en az iki yıl (dört yarıyıl) lisans '
            .'düzeyinde ders verme tecrübeniz olmalı.'.$ingilizceNotu.$NOT_CETVEL,
        'sart' => Kalip::ve('Profesör kadrosuna atanma — '.$ad, [
            $UNVAN, $DIL, $DIL_NOT,
            Kalip::metrik('Doçentlik sürecinde en az iki yıl (dört yarıyıl) lisans düzeyinde ders vermiş olmak', 'ders_yariyil', 4, $DOCENTLIK),
            $profYayin, Kalip::toplam(150),
        ]),
    ];
};

$grup('sosyal-ing', ['sosyal'], 'Eğitim Dili İngilizce Olan Programlar',
    'Sosyal, Beşeri ve İdari Bilimler (eğitim dili İngilizce)', true);
$grup('sosyal-tr', ['sosyal'], 'Eğitim Dili Türkçe Olan Programlar',
    'Sosyal, Beşeri ve İdari Bilimler (eğitim dili Türkçe)', false);
$grup('hukuk', ['hukuk'], null, 'Hukuk', false);
$grup('ilahiyat', ['ilahiyat'], null, 'İlahiyat', false);
$grup('filoloji', ['filoloji'], null, 'Filoloji', false);

return $esikler;
