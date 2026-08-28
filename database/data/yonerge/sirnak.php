<?php

/**
 * ŞIRNAK ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/17634009071.Şırnak Üniversitesi Kriter.pdf (11 sayfa;
 * belge 31.12.2024 tarihli, Senato kabulü ve YÖK onayıyla yürürlüğe
 * girer.)
 *
 * ── YAPI ──
 * Yönerge temel alanları ÜAK ayrımına göre değil, ADEK komisyonlarının
 * ayrımına göre kümeliyor: "Fen Bilimleri, Sosyal Bilimler ve Sağlık
 * Bilimleri" için tek eşik veriyor. Bu ayrım yalnız iki yerde fark
 * yaratıyor: yeniden atanmadaki proje koşulu (Sosyal Bilimler hariç) ve
 * Güzel Sanatlar ile Müzik alanlarının kendi puan kalemleri.
 *
 * ── DOÇENTLİKTE EK KOŞUL YOK ──
 * MADDE 7.1 doçentlik için yalnız "YÖK tarafından doçentlik için
 * belirlenen başvuru koşullarını sağlayarak doçent unvanını almış
 * olmak" diyor; üniversitenin ek puan barajı yok.
 *
 * ── GÜZEL SANATLAR VE MÜZİK ──
 * MADDE 6.2.1.2 ve 6.2.1.3, Güzel Sanatların UYGULAMALI alanlarına ve
 * Müzik alanlarına ayrı ve daha düşük eşikler veriyor (çizelgenin 9-12
 * ya da 13-16 numaralı maddelerinden 30 puan + toplam 50 puan). Profil
 * adayın bilim/sanat dalını tutmadığı için §0 uyarınca Güzel Sanatlar
 * temel alanına KURAMSAL alan eşiği (Sosyal Bilimler esasları: makale
 * 40 + toplam 100) uygulandı; uygulamalı ve müzik alanlarının düşük
 * eşikleri aday notunda. Ayrıca çizelgenin 10. (koleksiyon) ve 11.
 * (müzik teknolojisi) maddeleri sözlükte karşılıksız olduğu için
 * cetvele girmedi.
 *
 * ── YENİDEN ATANMADA SÜRE ORANI ──
 * MADDE 6.2.2.1 puanları ÜÇ YILLIK atama süresi için veriyor: "Atama
 * süresinin daha az veya fazla olması durumunda puanlar atama süresine
 * göre oranlanarak hesaplanır." Eşiğe üç yıllık değerler yazıldı;
 * oranlama aday notunda.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 6.1: bilim/sanat alanı bir yabancı dille ilgili olan doktor
 *       öğretim üyesi kadrolarında 80 puanlık dil şartı — profil
 *       adayın bilim dalını tutmuyor, 55 uygulandı.
 *   MADDE 4.1: kriterleri sağlamanın atanma için yeterlilik anlamına
 *       gelmemesi.
 *   MADDE 4.3: DOI ve indeks belgeleme koşulları.
 *   MADDE 4.4: aynı çalışmanın birden fazla yerde yayımlanması hâlinde
 *       en yüksek puanın esas alınması — motorun zaten yaptığı şey.
 *   MADDE 6.2.2.5'in "en az bir tamamlanmış ve/veya devam eden proje"
 *       koşulunda "devam eden" ayrımı; kayıt projenin durumunu
 *       taşımıyor, bütün projeler sayılıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/sirnak-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Şırnak Üniversitesi';
$CETVEL = 'sirnak-2024';
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$SOSYAL = ['egitim', 'filoloji', 'hukuk', 'ilahiyat', 'sosyal', 'guzel_sanatlar', 'spor'];
$FEN = ['fen', 'muhendislik', 'saglik', 'ziraat', 'mimarlik'];
$TUM = [...$SOSYAL, ...$FEN];

$NOT_GS = ' Güzel Sanatların UYGULAMALI alanlarında ve Müzik alanlarında yönerge daha düşük '
    .'eşikler tanıyor (çizelgenin sergi, koleksiyon, müzik teknolojisi ve müzik kompozisyonu '
    .'maddelerinden 30 puan almak kaydıyla toplam 50 puan; yeniden atanmada 20-25 puan kaydıyla '
    .'toplam 35-40 puan). Motor adayın bilim/sanat dalını bilmediği için kuramsal alan eşiğini '
    .'uyguluyor; uygulamalı alandan başvuruyorsanız koşullar burada göründüğünden hafiftir.';
$NOT_DIL = ' Yabancı dil koşulu 55 puandan uygulanıyor; bilim ya da sanat alanınız bir yabancı '
    .'dille ilgiliyse doktor öğretim üyeliğine ilk atanmada 80 puan gerekiyor.';
$NOT_DERS = ' Ders puanı haftalık ders saati başına 1 puan olarak veriliyor; kayıt ders başına '
    .'tutulduğu için her ders 1 puan sayılıyor ve ders puanınız düşük görünür (bölümün tavanı '
    .'30 puan). H indeksi puanı (5 × H indeksi) da hesaplanmıyor.';

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK ATANMA (MADDE 6)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'sirnak-dr',
    'aday_notu' => 'Doktor öğretim üyesi kadrosuna İLK ATANMA koşulları: merkezi yabancı dil '
        .'sınavından en az 55 puan, puan çizelgesinin Makaleler başlığından en az 40 puan ve '
        .'bütün faaliyetlerden toplam en az 100 puan.'.$NOT_DIL.$NOT_GS.$NOT_DERS,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 6.1 ve 6.2.1.1: yabancı dil 55; Makaleler başlığından 40 puan; toplam '
        .'100 puan. Güzel Sanatların uygulamalı alanları ve Müzik alanları için 6.2.1.2 ve '
        .'6.2.1.3\'teki düşük eşikler uygulanmadı.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma', [
        Kalip::yds(55),
        Kalip::puanDan(
            'Makaleler başlığındaki yayınlardan en az 40 puan almış olmak',
            ['MAKALELER'], 40, madde: '6.2.1.1',
        ),
        Kalip::toplam(100),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (MADDE 6.2.2)
// ══════════════════════════════════════════════════════════════════════════

$yenidenOrtak = [
    Kalip::puanDan(
        'Son atanma tarihinizden sonra Makaleler başlığındaki yayınlardan en az 30 puan almış olmak',
        ['MAKALELER'], 30, $SON_ATAMA, madde: '6.2.2.1',
    ),
    Kalip::toplam(100, $SON_ATAMA),
];

$esikler[] = [
    'anahtar' => 'sirnak-sosyal-dr-yeniden',
    'aday_notu' => 'Sosyal Bilimler alanlarında doktor öğretim üyesi kadrosuna YENİDEN ATANMA '
        .'koşulları. Puanlar ÜÇ YILLIK atama süresi için verilmiştir; atama süreniz daha kısa ya '
        .'da uzunsa puanlar süreye göre oranlanır. Atamalar en az bir, en çok dört yıl süreyle '
        .'yapılıyor. Sosyal Bilimler alanlarında yeniden atanmada proje koşulu aranmıyor.'
        .$NOT_GS.$NOT_DERS,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $SOSYAL,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 6.2.2.1: son atanma sonrası Makaleler başlığından 30 puan, toplam 100 '
        .'puan (üç yıllık atama). 6.2.2.5\'in proje koşulu Sosyal Bilimler alanlarında aranmıyor.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma — Sosyal Bilimler',
        $yenidenOrtak),
];

$esikler[] = [
    'anahtar' => 'sirnak-fen-dr-yeniden',
    'aday_notu' => 'Fen Bilimleri ve Sağlık Bilimleri alanlarında doktor öğretim üyesi kadrosuna '
        .'YENİDEN ATANMA koşulları. Puanlar ÜÇ YILLIK atama süresi için verilmiştir; atama '
        .'süreniz daha kısa ya da uzunsa puanlar süreye göre oranlanır. Üç yıllık yeniden '
        .'atamalarda ayrıca en az bir tamamlanmış ya da devam eden projede görev almış olmanız '
        .'gerekiyor.'.$NOT_DERS,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => $FEN,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 6.2.2.1 ve 6.2.2.5: son atanma sonrası Makaleler başlığından 30 puan, '
        .'toplam 100 puan ve en az bir projede görev almak.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma — Fen ve Sağlık Bilimleri', [
        ...$yenidenOrtak,
        Kalip::adet(
            'Son atanma tarihinizden sonra en az bir tamamlanmış ya da devam eden araştırma '
            .'projesinde görev almış olmak',
            ['PROJE'], 1, donem: $SON_ATAMA, madde: '6.2.2.5',
        ),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (MADDE 7)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'sirnak-docentlik',
    'aday_notu' => 'Doçent kadrosuna atanmada Şırnak Üniversitesi kendi puan barajını '
        .'istemiyor: Yükseköğretim Kurulunun doçentlik için belirlediği başvuru koşullarını '
        .'sağlayarak doçent unvanını almış olmak yeterli.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 7.1: yalnız ÜAK doçentlik koşullarını sağlayarak doçent unvanı almış '
        .'olmak; üniversitenin ek puan barajı yok.',
    'sart' => Kalip::ve('Doçent kadrosuna atanma', [
        Kalip::beyan(
            'Yükseköğretim Kurulu tarafından doçentlik için belirlenen başvuru koşullarını '
            .'sağlayarak doçent unvanını almış olmak',
            '7.1',
        ),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (MADDE 8)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'sirnak-profesorluk',
    'aday_notu' => 'Profesör kadrosuna yükseltilerek atanma koşulları: puan çizelgesinden toplam '
        .'400 puan; bu puanın en az yarısının (200) doçent unvanınızı aldıktan sonraki '
        .'çalışmalardan gelmesi; doçentlik sonrası çalışmalarınızın en az 100 puanının Makaleler '
        .'ve Kitaplar tablolarındaki faaliyetlerden olması. Ayrıca doçent unvanını aldıktan sonra '
        .'en az 3 yılı yükseköğretim kurumlarında olmak üzere ilgili bilim alanında en az 5 yıl '
        .'çalışmış olmanız ve bir Başlıca Araştırma Eserinizin bulunması gerekiyor.'.$NOT_DERS,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $TUM,
    'cetvel' => $CETVEL,
    'notlar' => 'MADDE 8.1-8.3: 5 yıl çalışma ve Başlıca Araştırma Eseri beyan; toplam 400 puan, '
        .'en az %50\'si (200) doçentlik sonrası, doçentlik sonrasının 100 puanı Makaleler ve '
        .'Kitaplar tablolarından.',
    'sart' => Kalip::ve('Profesör kadrosuna yükseltilerek atanma', [
        Kalip::beyan(
            'Doçent unvanını aldığınız tarihten sonra en az 3 yılı yükseköğretim kurumlarında '
            .'olmak üzere, açık bulunan profesör kadrosuyla ilgili bilim alanında en az 5 yıl '
            .'çalışmış olmak',
            '8.1',
        ),
        Kalip::beyan('Başlıca Araştırma Eserine sahip olmak', '8.2'),
        Kalip::toplam(400),
        Kalip::toplam(200, $DOCENTLIK),
        Kalip::puanDan(
            'Doçent unvanınızı aldıktan sonraki çalışmalarınızın en az 100 puanının makale ve '
            .'kitap faaliyetlerinden gelmesi',
            ['MAKALE-KITAP'], 100, $DOCENTLIK, madde: '8.3',
        ),
    ]),
];

return $esikler;
