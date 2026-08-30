<?php

/**
 * ABDULLAH GÜL ÜNİVERSİTESİ — Akademik Yükseltilme ve Atanma Yönergesi
 * Kaynak: pdf/177867736535.abdullah-gul-kriter-13052026.pdf (17 sayfa)
 *
 * ── YAPI: TEK PUAN TABLOSU, DÖRT BİRİM ──
 * Bölüm 3'teki AGÜ Akademik Değerlendirme Puan Tablosu üniversitenin tamamı
 * için ortak (cetvel dosyasında tek gövde). Bölüm 4 dört birim için ayrı
 * ARAŞTIRMA/EĞİTİM/KATKI taban puanları ve bir TOPLAM barajı veriyor:
 *
 *   4.1 Mühendislik Fakültesi - Yaşam ve Doğa Bilimleri Fakültesi - Fen
 *       Bilimleri Enstitüsü        → alan: mühendislik, fen
 *   4.2 Yönetim Bilimleri Fakültesi - İnsan ve Toplum Bilimleri Fakültesi -
 *       Sosyal Bilimler Enstitüsü  → alan: sosyal
 *   4.3 Mimarlık Fakültesi         → alan: mimarlık
 *   4.4 Ortak Dersler Bölümü - Yabancı Diller Yüksekokulu → alan: filoloji
 *       (yaklaşık: bu birim dil ve ortak ders okutmanlarını kapsıyor, on iki
 *       temel alandan hiçbiri tam karşılık gelmiyor; en yakını filoloji.)
 *
 * TOPLAM bir ÜST barajı; alt taban puanlar (Yayın, Proje, Eğitim, Katkı)
 * TOPLAM'ın İÇİNDE ayrılması gereken asgari miktarlar. Örnek: Mühendislik
 * doçentliğinde Yayın≥125 + Proje≥30 + Eğitim≥10 + Katkı≥25 = 190, ama
 * TOPLAM 300; kalan 110 puan herhangi bir kalemden gelebilir.
 *
 * ── YAZAR FORMÜLÜ VE Q1 DERLEME BONUSU CETVELE GÖMÜLDÜ ──
 * Gerekçe ve kademeler cetvel dosyasında (`yazar_katsayisi`, `M-Q1-DERLEME`).
 *
 * ── SCI/SSCI SAYI ŞARTI HER BİRİMDE FARKLI KADRODA BAŞLIYOR ──
 * Mühendislik: Dr. Öğr. Üyesi'nde bile en az 1 SCI/SSCI/SCI-E/SSCI-E/ESCI/AHCI
 * dergide makale şartı var (dipnot 3). Sosyal, Mimarlık ve Ortak Dersler
 * birimlerinde bu şart yalnızca Doçentlik ve Profesörlükte geçerli, Dr. Öğr.
 * Üyesi'nde YOK — dipnotların kendi metni farkı doğruluyor.
 *
 * ── PROJE TABANI + TELAFİ (motorun `telafi_carpani` alanı) ──
 * Doçentlik ve profesörlükte "en az 1 proje yürütücülüğü" + puan tabanı
 * birlikte isteniyor; sağlanamazsa açığın MÜHENDİSLİK'te 2 KATI, diğer üç
 * birimde AÇIK KADARI Q1/Q2 makalelerden telafi edilebiliyor. "En az 1 proje
 * yürütücülüğü" koşulu ile puan tabanının telafisi kaynakta TEK cümlede
 * birleşik ("koşul VE puanlardan eksik kalan kısım"); motor tek düğümde ikisi
 * birden ifade edilemediği için adet koşulu HER DURUMDA (telafiden bağımsız)
 * arandı — az sayıda adayı (telafiyle karşılayıp hiç proje yürütücüsü
 * olmayan) olduğundan ZOR gösterebilir, "eksik say" yönünde bir sapma.
 *
 * "Devam eden/tamamlanmış" (doçentlik) ile "tamamlanmış" (profesörlük) ayrımı
 * faaliyet kaydında yok; ikisi de aynı adet koşuluyla karşılandı.
 *
 * ── "EN AZ YARISI DOKTORA/DOÇENTLİK SONRASI" ──
 * Doçentlikte yayın tabanının yarısı doktora sonrası, profesörlükte yarısı
 * doçentlik sonrası olmalı. Kesirli taban YUKARI yuvarlandı (Mühendislik
 * 125/2=62,5→63; diğerleri tam bölünüyor).
 *
 * ── TEZ DANIŞMANLIĞI ŞARTI ──
 * "Doçentlik için en az bir tezin YAPILIYOR OLMASI, profesörlük için en az
 * bir tezin BİTİRİLMİŞ OLMASI" — faaliyet kaydı devam eden/tamamlanmış
 * ayrımını tutmuyor, ikisi de aynı adet(1) koşuluyla karşılandı. "Adayın
 * uzmanlık alanında kadrosunun bulunduğu üniversitede lisansüstü program
 * olmaması durumunda aranmaz" istisnası uygulanamadı — program varlığı
 * profilde yok.
 *
 * ── İLK ATAMADA "TANINMIŞ ÜNİVERSİTE" KOŞULU BEYAN ──
 * Bölüm 1: AGÜ'den veya THE/QS ilk 800 dışındaki bir üniversiteden doktora
 * alan adayların, doktora sonrası tanınmış bir üniversitede/araştırma
 * kurumunda en az 1 yıl bilfiil bulunmuş olması gerekiyor. Adayın doktora
 * aldığı kurum ve bu kurumun sıralaması profilde yok; beyan olarak yalnızca
 * Dr. Öğr. Üyesi (ilk atama) eşiklerine eklendi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Geçici Madde 1: yeniden atanma koşullarının sağlanamadığı durumda
 *       "en az yarısını sağlama + rektör onayı" ile bir defaya mahsus
 *       istisna — tamamen takdire bağlı, eşik yazılmadı.
 *   Mimarlık biriminin "Yayımlanmış Proje/Uygulama/Fikir Projesinden Alınan
 *       Puan" alt tabanı (doçentlik 15, profesörlük 30) hiç yazılmadı: bu
 *       kalemin dayandığı BM madde kodu kaynak sözlüğünde karşılıksız
 *       olduğu için cetvele hiç girilmedi (KONVANSIYONLAR'daki "koşulun
 *       tamamı girilemeyen bir bölüme dayanıyorsa o eşiği hiç yazma"
 *       istisnası). Kaynağın kendi dipnotu zaten bu tabanın TAMAMININ
 *       yayın puanıyla telafi edilebileceğini söylüyor; TOPLAM barajı
 *       (200/400) hâlâ geçerli olduğu için adayın toplam yükü fiilen
 *       değişmiyor.
 *   Ortak Dersler biriminin (4.4) h-index satırı YOK; bu birimde h-index
 *       koşulu hiç yazılmadı (diğer üç birimde var).
 *   Dr. Öğr. Üyesi yeniden atanmasındaki "A grubu proje BAŞVURUSUNA 2 puan"
 *       bonusu (dipnot 1) — başvuru (ret/bekleyen dahil) faaliyet kaydında
 *       yok, girilmedi.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/abdullah-gul-2026.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'abdullah-gul-2026';
$UNIVERSITE = 'Abdullah Gül Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$tanınmisUniversiteBeyani = Kalip::beyan(
    'AGÜ\'den veya THE/QS dünya sıralamasında ilk 800 içinde yer almayan bir üniversiteden '
    .'doktora aldıysanız: doktora sonrasında tanınmış bir üniversitenin (THE/QS ilk 800) veya '
    .'tanınmış bağımsız bir araştırma kurumunun akademik üretim sürecinde en az 1 yıl bilfiil '
    .'bulunmuş olmak',
    'Bölüm 1',
);

/**
 * Bir birimin dört kadro eşiğini üretir.
 *
 * @param  list<string>  $alan
 * @param  array{
 *     dr_yayin: int, dr_yeniden_yayin: int, dr_yeniden_egitim: int, dr_yeniden_katki: int,
 *     doc_yayin: int, doc_proje: int, doc_egitim: int, doc_katki: int, doc_toplam: int, doc_sci: int, doc_hindex: int|null,
 *     prof_yayin: int, prof_proje: int, prof_egitim: int, prof_katki: int, prof_toplam: int, prof_sci: int, prof_hindex: int|null,
 *     telafi_carpani: int,
 * }  $p
 * @return list<array<string, mixed>>
 */
$birim = function (
    string $anahtarOnek,
    string $adSoyad,
    array $alan,
    array $p,
    string $maddeBaslangic,
) use ($CETVEL, $UNIVERSITE, $DOKTORA, $DOCENTLIK, $tanınmisUniversiteBeyani): array {
    $projeTelafisi = fn (int $taban, ?array $donem, string $madde): array => Kalip::puanDan(
        "Araştırma projesi kalemlerinizden en az {$taban} puan",
        ['PROJE'], $taban, $donem, madde: $madde,
    ) + [
        'telafi' => [
            'tip' => 'puan',
            'aciklama' => 'Proje puanınız yetmiyorsa: eksik kalan '
                .($p['telafi_carpani'] === 2 ? 'her puanın iki katını' : 'puan kadarını')
                .' fazladan Q1 veya Q2 dergi makalelerinizden sağlamalısınız',
            'madde' => $madde,
            'maddeler' => ['M-Q1Q2'],
            'min_puan' => $taban,
            'telafi_carpani' => $p['telafi_carpani'],
            'donem' => $donem,
        ],
    ];

    return [
        [
            'anahtar' => "{$anahtarOnek}-dr",
            'aday_notu' => "AGÜ Akademik Değerlendirme Puan Tablosundan {$p['dr_yayin']} puanlık ".
                'yayın tabanı ve toplamda 30 puan isteniyor (kalan puan herhangi bir kalemden '
                .'gelebilir). '
                .(str_contains($maddeBaslangic, 'Mühendislik') ? 'Ayrıca yayınlarınızdan en az '
                    .'birinin SCI, SCI-Expanded, SSCI, SSCI-Expanded, ESCI veya AHCI kapsamındaki '
                    .'bir dergide olması gerekiyor. ' : '')
                .'AGÜ\'den veya dünya sıralamasında ilk 800 dışındaki bir üniversiteden doktora '
                .'aldıysanız, doktora sonrası tanınmış bir kurumda en az 1 yıl bilfiil bulunmuş '
                .'olmanız da isteniyor (bu koşul beyan edilir, faaliyet kaydınızdan hesaplanmaz).',
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alan,
            'cetvel' => $CETVEL,
            'notlar' => "{$maddeBaslangic}: Dr. Öğr. Üyesi için minimum yayın puanı {$p['dr_yayin']}, "
                .'toplam 30 puan.',
            'sart' => Kalip::ve('Dr. Öğretim Üyesi kadrosuna atanma', array_values(array_filter([
                Kalip::beyan('İlgili alanda doktora derecesine sahip olmak', 'Bölüm 1'),
                $tanınmisUniversiteBeyani,
                str_contains($maddeBaslangic, 'Mühendislik') ? Kalip::adet(
                    'Yayınlarınızdan en az 1 tanesi SCI, SCI-Expanded, SSCI, SSCI-Expanded, ESCI veya AHCI kapsamındaki bir dergide olmalı',
                    ['SCI-DERGI'], 1, madde: $maddeBaslangic,
                ) : null,
                Kalip::puanDan("Yayın kalemlerinizden en az {$p['dr_yayin']} puan", ['YAYIN'], $p['dr_yayin'], madde: $maddeBaslangic),
                Kalip::toplam(30),
            ]))),
        ],
        [
            'anahtar' => "{$anahtarOnek}-dr-yeniden",
            'aday_notu' => 'Yeniden atanmada dört ayrı taban var: yayın kalemlerinden en az '
                ."{$p['dr_yeniden_yayin']} puan, eğitim kalemlerinden en az {$p['dr_yeniden_egitim']} puan, "
                ."katkı kalemlerinden en az {$p['dr_yeniden_katki']} puan ve toplamda en az 30 puan. "
                .'Yönerge ayrıca yürütücü olarak yaptığınız bir dış kaynaklı proje BAŞVURUSUNA (kabul '
                .'edilmese de) 2 puan tanıyor; bu bonus faaliyet kaydında proje başvurusu '
                .'tutulmadığı için hesaba katılamadı.',
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi_yeniden',
            'alan' => $alan,
            'cetvel' => $CETVEL,
            'notlar' => "{$maddeBaslangic}: Dr. Öğr. Üyesi yeniden atanma tabanları "
                ."(Yayın {$p['dr_yeniden_yayin']}, Eğitim {$p['dr_yeniden_egitim']}, "
                ."Katkı {$p['dr_yeniden_katki']}), toplam 30 puan.",
            'sart' => Kalip::ve('Doktor Öğretim Üyeliğine yeniden atanma', [
                Kalip::puanDan("Yayın kalemlerinizden en az {$p['dr_yeniden_yayin']} puan", ['YAYIN'], $p['dr_yeniden_yayin'], madde: $maddeBaslangic),
                Kalip::puanDan("Eğitim kalemlerinizden en az {$p['dr_yeniden_egitim']} puan", ['EGITIM'], $p['dr_yeniden_egitim'], madde: $maddeBaslangic),
                Kalip::puanDan("Katkı kalemlerinizden en az {$p['dr_yeniden_katki']} puan", ['KATKI'], $p['dr_yeniden_katki'], madde: $maddeBaslangic),
                Kalip::toplam(30),
            ]),
        ],
        [
            'anahtar' => "{$anahtarOnek}-docent",
            'aday_notu' => 'Dört taban ve bir toplam birlikte aranıyor: yayın kalemlerinden en az '
                ."{$p['doc_yayin']} puan (bunun yarısı doktora unvanınızdan sonra olmalı), "
                ."araştırma projesi kalemlerinden en az {$p['doc_proje']} puan, eğitim kalemlerinden "
                ."en az {$p['doc_egitim']} puan, katkı kalemlerinden en az {$p['doc_katki']} puan ve "
                ."toplamda en az {$p['doc_toplam']} puan (kalan puan herhangi bir kalemden gelebilir). "
                ."Ayrıca yayınlarınızdan en az {$p['doc_sci']} tanesi SCI, SCI-Expanded, SSCI, "
                .'SSCI-Expanded, ESCI veya AHCI kapsamındaki bir dergide olmalı; en az bir devam '
                .'eden veya tamamlanmış dış kaynaklı proje yürütücülüğünüz ve danışmanlığını '
                .'sürdürdüğünüz en az bir yüksek lisans veya doktora teziniz bulunmalı.'
                .($p['doc_hindex'] !== null ? " h-indeksiniz en az {$p['doc_hindex']} olmalı." : ''),
            'universite' => $UNIVERSITE,
            'kadro' => 'docentlik',
            'alan' => $alan,
            'cetvel' => $CETVEL,
            'notlar' => "{$maddeBaslangic}: Doçentlik tabanları (Yayın {$p['doc_yayin']}, "
                ."Proje {$p['doc_proje']}, Eğitim {$p['doc_egitim']}, Katkı {$p['doc_katki']}), "
                ."toplam {$p['doc_toplam']} puan. Yayın tabanının yarısı doktora sonrası olmalı.",
            'sart' => Kalip::ve('Doçent kadrosuna atanma', array_values(array_filter([
                Kalip::beyan('Kadronun ilan edildiği alanda doçentlik unvanına sahip olmak', $maddeBaslangic),
                Kalip::adet(
                    "Yayınlarınızdan en az {$p['doc_sci']} tanesi SCI, SCI-Expanded, SSCI, SSCI-Expanded, ESCI veya AHCI kapsamındaki bir dergide olmalı",
                    ['SCI-DERGI'], $p['doc_sci'], madde: $maddeBaslangic,
                ),
                Kalip::puanDan("Yayın kalemlerinizden en az {$p['doc_yayin']} puan", ['YAYIN'], $p['doc_yayin'], madde: $maddeBaslangic),
                Kalip::puanDan(
                    "Bu puanın en az yarısı ({$p['doc_yayin']} puanın yarısı) doktora unvanınızdan sonra olmalı",
                    ['YAYIN'], (int) ceil($p['doc_yayin'] / 2), $DOKTORA, madde: $maddeBaslangic,
                ),
                Kalip::adet(
                    'En az 1 devam eden veya tamamlanmış dış kaynaklı proje yürütücülüğünüz olmalı',
                    ['PROJE-YURUTUCU'], 1, madde: $maddeBaslangic,
                ),
                $projeTelafisi($p['doc_proje'], null, $maddeBaslangic),
                Kalip::puanDan("Eğitim kalemlerinizden en az {$p['doc_egitim']} puan", ['EGITIM'], $p['doc_egitim'], madde: $maddeBaslangic),
                Kalip::adet(
                    'Danışmanlığını sürdürdüğünüz en az 1 yüksek lisans veya doktora teziniz olmalı',
                    ['TEZ-DANISMANLIK'], 1, madde: $maddeBaslangic,
                ),
                Kalip::puanDan("Katkı kalemlerinizden en az {$p['doc_katki']} puan", ['KATKI'], $p['doc_katki'], madde: $maddeBaslangic),
                $p['doc_hindex'] !== null ? Kalip::metrik("h-indeksiniz en az {$p['doc_hindex']} olmalı", 'h_indeksi', $p['doc_hindex']) : null,
                Kalip::toplam($p['doc_toplam']),
            ]))),
        ],
        [
            'anahtar' => "{$anahtarOnek}-profesor",
            'aday_notu' => 'Dört taban ve bir toplam birlikte aranıyor: yayın kalemlerinden en az '
                ."{$p['prof_yayin']} puan (bunun yarısı doçentlik unvanınızdan sonra olmalı), "
                ."araştırma projesi kalemlerinden en az {$p['prof_proje']} puan, eğitim kalemlerinden "
                ."en az {$p['prof_egitim']} puan, katkı kalemlerinden en az {$p['prof_katki']} puan ve "
                ."toplamda en az {$p['prof_toplam']} puan. Ayrıca yayınlarınızdan en az "
                ."{$p['prof_sci']} tanesi SCI, SCI-Expanded, SSCI, SSCI-Expanded, ESCI veya AHCI "
                .'kapsamındaki bir dergide olmalı; yürütücü olarak tamamladığınız en az bir dış '
                .'kaynaklı '
                .'projeniz ve bitirdiğiniz en az bir yüksek lisans veya doktora tez danışmanlığınız '
                .'bulunmalı.'
                .($p['prof_hindex'] !== null ? " h-indeksiniz en az {$p['prof_hindex']} olmalı." : ''),
            'universite' => $UNIVERSITE,
            'kadro' => 'profesorluk',
            'alan' => $alan,
            'cetvel' => $CETVEL,
            'notlar' => "{$maddeBaslangic}: Profesörlük tabanları (Yayın {$p['prof_yayin']}, "
                ."Proje {$p['prof_proje']}, Eğitim {$p['prof_egitim']}, Katkı {$p['prof_katki']}), "
                ."toplam {$p['prof_toplam']} puan. Yayın tabanının yarısı doçentlik sonrası olmalı.",
            'sart' => Kalip::ve('Profesör kadrosuna atanma', array_values(array_filter([
                Kalip::beyan('Doçentlik unvanına sahip olmak', $maddeBaslangic),
                Kalip::adet(
                    "Yayınlarınızdan en az {$p['prof_sci']} tanesi SCI, SCI-Expanded, SSCI, SSCI-Expanded, ESCI veya AHCI kapsamındaki bir dergide olmalı",
                    ['SCI-DERGI'], $p['prof_sci'], madde: $maddeBaslangic,
                ),
                Kalip::puanDan("Yayın kalemlerinizden en az {$p['prof_yayin']} puan", ['YAYIN'], $p['prof_yayin'], madde: $maddeBaslangic),
                Kalip::puanDan(
                    "Bu puanın en az yarısı ({$p['prof_yayin']} puanın yarısı) doçentlik unvanınızdan sonra olmalı",
                    ['YAYIN'], (int) ceil($p['prof_yayin'] / 2), $DOCENTLIK, madde: $maddeBaslangic,
                ),
                Kalip::adet(
                    'Yürütücü olarak tamamladığınız en az 1 dış kaynaklı projeniz olmalı',
                    ['PROJE-YURUTUCU'], 1, madde: $maddeBaslangic,
                ),
                $projeTelafisi($p['prof_proje'], null, $maddeBaslangic),
                Kalip::puanDan("Eğitim kalemlerinizden en az {$p['prof_egitim']} puan", ['EGITIM'], $p['prof_egitim'], madde: $maddeBaslangic),
                Kalip::adet(
                    'Bitirdiğiniz en az 1 yüksek lisans veya doktora tez danışmanlığınız olmalı',
                    ['TEZ-DANISMANLIK'], 1, madde: $maddeBaslangic,
                ),
                Kalip::puanDan("Katkı kalemlerinizden en az {$p['prof_katki']} puan", ['KATKI'], $p['prof_katki'], madde: $maddeBaslangic),
                $p['prof_hindex'] !== null ? Kalip::metrik("h-indeksiniz en az {$p['prof_hindex']} olmalı", 'h_indeksi', $p['prof_hindex']) : null,
                Kalip::toplam($p['prof_toplam']),
            ]))),
        ],
    ];
};

$esikler = [];

// 4.1 Mühendislik Fakültesi - Yaşam ve Doğa Bilimleri Fakültesi - Fen Bilimleri Enstitüsü
$esikler = array_merge($esikler, $birim('abdullah-gul-muhendislik', 'Mühendislik', ['muhendislik', 'fen'], [
    'dr_yayin' => 20, 'dr_yeniden_yayin' => 10, 'dr_yeniden_egitim' => 5, 'dr_yeniden_katki' => 5,
    'doc_yayin' => 125, 'doc_proje' => 30, 'doc_egitim' => 10, 'doc_katki' => 25, 'doc_toplam' => 300, 'doc_sci' => 2, 'doc_hindex' => 6,
    'prof_yayin' => 250, 'prof_proje' => 50, 'prof_egitim' => 20, 'prof_katki' => 50, 'prof_toplam' => 700, 'prof_sci' => 3, 'prof_hindex' => 10,
    'telafi_carpani' => 2,
], 'Bölüm 4.1, Mühendislik'));

// 4.2 Yönetim Bilimleri Fakültesi - İnsan ve Toplum Bilimleri Fakültesi - Sosyal Bilimler Enstitüsü
$esikler = array_merge($esikler, $birim('abdullah-gul-sosyal', 'Sosyal', ['sosyal'], [
    'dr_yayin' => 15, 'dr_yeniden_yayin' => 10, 'dr_yeniden_egitim' => 2, 'dr_yeniden_katki' => 5,
    'doc_yayin' => 80, 'doc_proje' => 20, 'doc_egitim' => 10, 'doc_katki' => 25, 'doc_toplam' => 200, 'doc_sci' => 1, 'doc_hindex' => 4,
    'prof_yayin' => 160, 'prof_proje' => 40, 'prof_egitim' => 20, 'prof_katki' => 50, 'prof_toplam' => 400, 'prof_sci' => 2, 'prof_hindex' => 6,
    'telafi_carpani' => 1,
], 'Bölüm 4.2, Sosyal'));

// 4.3 Mimarlık Fakültesi
$esikler = array_merge($esikler, $birim('abdullah-gul-mimarlik', 'Mimarlık', ['mimarlik'], [
    'dr_yayin' => 20, 'dr_yeniden_yayin' => 10, 'dr_yeniden_egitim' => 5, 'dr_yeniden_katki' => 5,
    'doc_yayin' => 80, 'doc_proje' => 20, 'doc_egitim' => 10, 'doc_katki' => 25, 'doc_toplam' => 200, 'doc_sci' => 1, 'doc_hindex' => 2,
    'prof_yayin' => 160, 'prof_proje' => 40, 'prof_egitim' => 20, 'prof_katki' => 50, 'prof_toplam' => 400, 'prof_sci' => 2, 'prof_hindex' => 4,
    'telafi_carpani' => 1,
], 'Bölüm 4.3, Mimarlık'));

// 4.4 Ortak Dersler Bölümü - Yabancı Diller Yüksekokulu (h-index satırı yok)
$esikler = array_merge($esikler, $birim('abdullah-gul-ortak-dersler', 'Ortak Dersler', ['filoloji'], [
    'dr_yayin' => 15, 'dr_yeniden_yayin' => 10, 'dr_yeniden_egitim' => 2, 'dr_yeniden_katki' => 5,
    'doc_yayin' => 70, 'doc_proje' => 20, 'doc_egitim' => 10, 'doc_katki' => 25, 'doc_toplam' => 200, 'doc_sci' => 1, 'doc_hindex' => null,
    'prof_yayin' => 140, 'prof_proje' => 40, 'prof_egitim' => 20, 'prof_katki' => 50, 'prof_toplam' => 400, 'prof_sci' => 2, 'prof_hindex' => null,
    'telafi_carpani' => 1,
], 'Bölüm 4.4, Ortak Dersler Bölümü - Yabancı Diller Yüksekokulu'));

return $esikler;
