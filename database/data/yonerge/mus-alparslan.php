<?php

/**
 * MUŞ ALPARSLAN ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Başvuru İçin
 * Gerekli Koşullar ve Uygulama Esasları
 * Kaynak: pdf/1764679627450.mus-alparslan-kriter-02122025.pdf (15 sayfa)
 *
 * ── YAPI: TEK TABLO, İKİ KOŞUL GRUBU ──
 * Tek puan tablosu (EK-1). Koşullar iki bilim alanı grubuna ayrılıyor:
 *   FEN GRUBU — Mühendislik, Fen Bilimleri ve Matematik, Sağlık,
 *       Ziraat-Orman-Su Ürünleri → `muhendislik`, `fen`, `saglik`,
 *       `ziraat`
 *   SOSYAL GRUP — Eğitim Bilimleri, Filoloji, İlahiyat, Mimarlık, Spor,
 *       Sosyal-Beşerî-İdari Bilimler → `egitim`, `filoloji`, `ilahiyat`,
 *       `mimarlik`, `spor`, `sosyal`
 * Madde 5 güzel sanatlar temel alanını hiç anmıyor (EK-1'de sanat
 * satırları olsa da); `guzel_sanatlar` için eşik yazılmadı.
 *
 * ── TELAFİ ZİNCİRLERİ `veya` DALLARIYLA ──
 * Yönerge birçok zorunlu puanın ardına "bu şartı sağlamayan adaylar
 * eksik puanlarını A1, B1 ve B2'den tamamlamalıdır" ekliyor. Bu,
 * pratikte barajın DAHA GENİŞ bir küme üzerinden de sağlanabilmesi
 * demek; `veya` dalı olarak yazıldı.
 *
 * ── YENİDEN ATANMADA 1/3 KURALI ──
 * Madde 9: "Yeniden atanmalarda, ilgili bilim alanları için öngörülen
 * toplam asgari puanların 1/3'ünün yeniden sağlanması gerekmektedir."
 * Doktor öğretim üyeliğinin toplamı 250 olduğu için 250/3 = 83,3 → 84
 * puan (yukarı yuvarlandı, §0). Dönem `SON_ATAMA_SONRASI`.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Madde 10(2)-b.3 ve 11(3)-b.3: "İletişim Fakülteleri için D1-D4
 *       kapsamında en az 50 puan". Koşul FAKÜLTEYE bağlı, temel alana
 *       değil; iletişim fakültesi adayları için ek bir eşik yazılmadı,
 *       aday notunda uyarı var.
 *   Madde 11(1)-a: "ÜAK doçentlik başvuru şartlarını akademik
 *       faaliyetler bakımından tekrar sağlamak" — `hesaplanamiyor`.
 *   Madde 9(d.1): doktora tezinin kitap olarak ya da tezden bir
 *       makalenin TR Dizin veya yurt dışı hakemli dergide yayımlanmış
 *       olması — kayıt bir yayının tezden üretilip üretilmediğini
 *       taşımıyor; `beyan`.
 *   Madde 10(2)-a.1'in "tez kapsamı dışında olmak" koşulu — aynı neden.
 *   Madde 11(4): lisansüstü programı bulunmayan bölümlerde C1-C7
 *       barajının aranmaması — bölüm bilgisi profilde yok; aday
 *       notunda.
 *   Madde 8(ç): Diş Hekimliği Fakültesinde öğretim üyesi bulunmayan
 *       anabilim dallarına yapılan atamalarda istisna.
 *   Madde 12: doktora ya da doçentlik alanı dışında bir birime başvuran
 *       adayın kendi alanının kriterlerine tabi tutulması.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/mus-alparslan-2025.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Muş Alparslan Üniversitesi';
$CETVEL = 'mus-alparslan-2025';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$FEN = ['muhendislik', 'fen', 'saglik', 'ziraat'];
$SOSYAL = ['egitim', 'filoloji', 'ilahiyat', 'mimarlik', 'spor', 'sosyal'];

$ILETISIM_NOTU = ' İletişim Fakültesi kadrolarında ayrıca görsel '
    .'etkinliklerden en az 50 puan isteniyor; koşul fakülteye bağlı olduğu için motor bunu '
    .'uygulamıyor, kendiniz kontrol etmelisiniz.';

$dil = Kalip::yds(65);
$doktora = Kalip::beyan('Doktora, sanatta yeterlik ya da tıpta uzmanlık unvanını kazanmış olmak', '9-a');
$docentUnvani = Kalip::beyan('Doçent unvanını kazanmış olmak', '10-a');

$baslicaEser = Kalip::adet(
    'Doçent unvanınızı aldıktan sonra Web of Science (SSCI, SCI-Expanded, SCI, AHCI) tarafından '
    .'taranan bir dergide tek isimli, ilk isim ya da danışmanlığınızdaki lisansüstü öğrencinizle '
    .'birlikte yayımladığınız özgün araştırma makalesi (başlıca araştırma eseri)',
    ['WOS'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: '11-1-c',
);

$uakKosullari = Kalip::hesaplanamiyor(
    'Doçent unvanını aldıktan sonra geçen sürede, doçentlik unvanını aldığınız dönemin ÜAK '
    .'doçentlik başvuru şartlarını akademik faaliyetleriniz bakımından TEKRAR sağlamak — ÜAK '
    .'başvuru şartları puan cetvelinden ayrı bir kural kümesi olduğu için motor hesaplayamıyor',
    '11-1-a',
);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ (Madde 9)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'mus-fen-dr',
    'aday_notu' => 'Mühendislik, fen bilimleri ve matematik, sağlık ile ziraat-orman-su ürünleri '
        .'alanlarında zorunlu puanlar dâhil tüm faaliyetlerinizden toplam en az 250 puan ve SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki '
        .'numaralı yayımlanmış çalışmalardan (SCI, SCI-Expanded, SSCI, AHCI makaleleri) en az 60 '
        .'puan isteniyor. Merkezi bir yabancı dil sınavından en az 65 puan gerekiyor. DİKKAT: '
        .'bu makalelerin puanı derginin ETKİ FAKTÖRÜNE bağlı (30+20×IF ve 20+10×IF); kayıt '
        .'etki faktörünü taşımadığı için sıfır kabul edildi, bu baraj olduğundan zor görünüyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $FEN,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9(c)-(ç): toplam 250 puan; A2.1+A2.2\'den 60 puan.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — mühendislik, fen, sağlık ve ziraat', [
        $doktora,
        $dil,
        Kalip::puanDan('SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 60 puan', ['A2.1-2'], 60, madde: '9-ç'),
        Kalip::toplam(250),
    ]),
];

$esikler[] = [
    'anahtar' => 'mus-sosyal-dr',
    'aday_notu' => 'Eğitim bilimleri, filoloji, ilahiyat, mimarlık, spor ile sosyal-beşerî-idari '
        .'bilimler alanlarında zorunlu puanlar dâhil tüm faaliyetlerinizden toplam en az 250 puan isteniyor. '
        .'Ayrıca SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 60 '
        .'puan gerekiyor; bu şartı sağlamayanlar eksik puanlarını uluslararası kitap, ulusal '
        .'kitap ve ulusal makale '
        .'kalemlerinden tamamlayabiliyor. Doktora tezinizin kitap olarak ya da tezinizden bir '
        .'bölümün TR Dizin veya yurt dışı hakemli dergide yayımlanmış olması da şart. Merkezi '
        .'bir yabancı dil sınavından en az 65 puan gerekiyor.'.$ILETISIM_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $SOSYAL,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9(d): toplam 250 puan; A2.1+A2.2\'den 60 puan (telafi A1, B1, B2); '
        .'doktora tezinden yayın.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — sosyal, eğitim, filoloji, ilahiyat, mimarlık ve spor', [
        $doktora,
        $dil,
        Kalip::beyan(
            'Doktora tezinizin bir kitap olarak yayımlanmış olması ya da doktora tezinizin veya '
            .'bir bölümünün ULAKBİM TR Dizinde ya da yurt dışı hakemli bir dergide yayımlanmış '
            .'olması',
            '9-d.1',
        ),
        Kalip::veya('Makale barajı ya da telafisi', [
            Kalip::puanDan('SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 60 puan', ['A2.1-2'], 60, madde: '9-d.2'),
            Kalip::puanDan(
                'Ya da makale ve kitap kalemlerinizden toplam en az 60 puan',
                ['A2-A1-B1-B2'], 60, madde: '9-d.2',
            ),
        ]),
        Kalip::toplam(250),
    ]),
];

$esikler[] = [
    'anahtar' => 'mus-dr-yeniden',
    'aday_notu' => 'Son atanma döneminizden sonraki çalışmalarınız sayılıyor. Yönerge yeniden '
        .'atanmada "öngörülen toplam asgari puanların 1/3\'ünün yeniden sağlanmasını" istiyor; '
        .'doktor öğretim üyeliğinin toplamı 250 puan olduğu için 84 puan gerekiyor. Doktor '
        .'öğretim üyesi en fazla üç yıl süreyle atanıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => array_merge($FEN, $SOSYAL),
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 9: toplam asgari puanın 1/3\'ü (250/3 → 84 puan), son atama sonrası.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma', [
        Kalip::toplam(84, $SON_ATAMA),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 10)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'mus-fen-docentlik',
    'aday_notu' => 'Doçent unvanına ek olarak zorunlu puanlar dâhil tüm faaliyetlerinizden toplam en az 750 '
        .'puan isteniyor. Ayrıca doktora sonrasında ve tez kapsamı dışında SCI, '
        .'SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 150 puan, doktora '
        .'sonrasında proje, patent ve fikri mülkiyet kalemlerinizden en az 50 puan gerekiyor; '
        .'bu şartı sağlamayanlar eksik '
        .'puanlarını dizinli dergilerdeki makalelerinden tamamlayabiliyor. Merkezi bir '
        .'yabancı dil sınavından en '
        .'az 65 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $FEN,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 10: toplam 750 puan; doktora sonrası A2.1+A2.2\'den 150 puan; doktora '
        .'sonrası C2-C4\'ten 50 puan (telafi A2.1-A2.2).',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — mühendislik, fen, sağlık ve ziraat', [
        $docentUnvani,
        $dil,
        Kalip::puanDan('Doktora unvanınızı aldıktan sonra SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 150 puan', ['A2.1-2'], 150, $DOKTORA, madde: '10-2-a.1'),
        Kalip::veya('Proje ve fikri mülkiyet barajı ya da telafisi', [
            Kalip::puanDan('Doktora sonrasında proje ve fikri mülkiyet kalemlerinizden en az 50 puan', ['C2-C4'], 50, $DOKTORA, madde: '10-2-a.2'),
            Kalip::puanDan('Ya da SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 200 puan (150 puanlık barajın üstüne 50 puan daha)', ['A2.1-2'], 200, madde: '10-2-a.2'),
        ]),
        Kalip::toplam(750),
    ]),
];

$esikler[] = [
    'anahtar' => 'mus-sosyal-docentlik',
    'aday_notu' => 'Doçent unvanına ek olarak zorunlu puanlar dâhil tüm faaliyetlerinizden toplam en az 750 '
        .'puan isteniyor. Ayrıca SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 150 puan (sağlamayanlar '
        .'eksiği kitap ve ulusal makale kalemlerinden tamamlayabilir) ve doktora sonrasında '
        .'proje, patent ve diğer faaliyet kalemlerinizden '
        .'(tez danışmanlığı, projeler, patent, ödüller, eğitime katkı) en az 50 puan gerekiyor. '
        .'Merkezi bir yabancı dil sınavından en az 65 puan gerekiyor.'.$ILETISIM_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'docentlik',
    'alan' => $SOSYAL,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 10: toplam 750 puan; A2.1+A2.2\'den 150 puan (telafi A1, B1, B2); doktora '
        .'sonrası C1-C7\'den 50 puan (telafi A1, B1, B2, A2.1, A2.2).',
    'sart' => Kalip::ve('Doçent kadrosuna atanma — sosyal, eğitim, filoloji, ilahiyat, mimarlık ve spor', [
        $docentUnvani,
        $dil,
        Kalip::veya('Makale barajı ya da telafisi', [
            Kalip::puanDan('SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 150 puan', ['A2.1-2'], 150, madde: '10-2-b.1'),
            Kalip::puanDan('Ya da makale ve kitap kalemlerinizden toplam en az 150 puan', ['A2-A1-B1-B2'], 150, madde: '10-2-b.1'),
        ]),
        Kalip::veya('Proje, patent ve diğer faaliyet barajı ya da telafisi', [
            Kalip::puanDan('Doktora sonrasında proje, patent ve diğer faaliyet kalemlerinizden en az 50 puan', ['C1-C7'], 50, $DOKTORA, madde: '10-2-b.2'),
            Kalip::puanDan('Ya da makale ve kitap kalemlerinizden toplam en az 200 puan', ['A2-A1-B1-B2'], 200, madde: '10-2-b.2'),
        ]),
        Kalip::toplam(750),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// PROFESÖR (Madde 11)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'mus-fen-profesorluk',
    'aday_notu' => 'Tüm faaliyetlerinizden toplam en az 1200 puan isteniyor. Ayrıca doçent '
        .'unvanınızı aldıktan sonra SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 200 puan, proje ve fikri mülkiyet '
        .'kalemlerinden en az 50 puan (sağlamayanlar eksiği dizinli dergilerdeki '
        .'makalelerinden tamamlar) ve bir '
        .'başlıca araştırma eseri gerekiyor. Doçent unvanını aldığınız dönemin ÜAK doçentlik '
        .'başvuru şartlarını akademik faaliyetlerinizle yeniden sağlamanız da şart; motor bunu '
        .'hesaplayamıyor. Merkezi bir yabancı dil sınavından en az 65 puan gerekiyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $FEN,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11: toplam 1200 puan; doçentlik sonrası A2.1+A2.2\'den 200 puan; '
        .'C2-C4\'ten 50 puan; başlıca araştırma eseri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — mühendislik, fen, sağlık ve ziraat', [
        $dil,
        $uakKosullari,
        $baslicaEser,
        Kalip::puanDan('Doçent unvanınızı aldıktan sonra SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 200 puan', ['A2.1-2'], 200, $DOCENTLIK, madde: '11-3-a.1'),
        Kalip::veya('Proje ve fikri mülkiyet barajı ya da telafisi', [
            Kalip::puanDan('Doçentlik sonrasında proje ve fikri mülkiyet kalemlerinizden en az 50 puan', ['C2-C4'], 50, $DOCENTLIK, madde: '11-3-a.2'),
            Kalip::puanDan('Ya da doçentlik sonrasında SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 250 puan', ['A2.1-2'], 250, $DOCENTLIK, madde: '11-3-a.2'),
        ]),
        Kalip::toplam(1200),
    ]),
];

$esikler[] = [
    'anahtar' => 'mus-sosyal-profesorluk',
    'aday_notu' => 'Tüm faaliyetlerinizden toplam en az 1200 puan isteniyor. Ayrıca SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki '
        .'makalelerinizden en az 200 puan (sağlamayanlar eksiği kitap ve ulusal makale '
        .'kalemlerinden tamamlar), doçent unvanınızı aldıktan sonra proje, patent ve fikri '
        .'mülkiyet kalemlerinizden en az 50 puan ve bir başlıca araştırma eseri gerekiyor. '
        .'Lisansüstü programı bulunmayan bölümlerde bu baraj '
        .'aranmıyor; motor bölüm bilgisini tutmadığı için barajı yine de uyguluyor. Doçentlik '
        .'başvuru şartlarını yeniden sağlama koşulunu motor hesaplayamıyor. Merkezi bir yabancı '
        .'dil sınavından en az 65 puan gerekiyor.'.$ILETISIM_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'profesorluk',
    'alan' => $SOSYAL,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11: toplam 1200 puan; A2.1+A2.2\'den 200 puan (telafi A1, B1, B2); '
        .'doçentlik sonrası C1-C7\'den 50 puan; başlıca araştırma eseri.',
    'sart' => Kalip::ve('Profesör kadrosuna atanma — sosyal, eğitim, filoloji, ilahiyat, mimarlık ve spor', [
        $dil,
        $uakKosullari,
        $baslicaEser,
        Kalip::veya('Makale barajı ya da telafisi', [
            Kalip::puanDan('SCI, SCI-Expanded, SSCI ve AHCI dergilerindeki makalelerinizden en az 200 puan', ['A2.1-2'], 200, madde: '11-3-b.1'),
            Kalip::puanDan('Ya da makale ve kitap kalemlerinizden toplam en az 200 puan', ['A2-A1-B1-B2'], 200, madde: '11-3-b.1'),
        ]),
        Kalip::veya('Proje, patent ve diğer faaliyet barajı ya da telafisi', [
            Kalip::puanDan('Doçent unvanınızı aldıktan sonra proje, patent ve diğer faaliyet kalemlerinizden en az 50 puan', ['C1-C7'], 50, $DOCENTLIK, madde: '11-3-b.2'),
            Kalip::puanDan('Ya da makale ve kitap kalemlerinizden toplam en az 250 puan', ['A2-A1-B1-B2'], 250, madde: '11-3-b.2'),
        ]),
        Kalip::toplam(1200),
    ]),
];

return $esikler;
