<?php

/**
 * İSTANBUL ÜNİVERSİTESİ-CERRAHPAŞA — Akademik Atanma Kriterlerine Dair Yönerge
 * Kaynak: pdf/17536997582.istanbuluniverstesi-cerrahpasa.pdf (Senato 06.07.2023)
 *
 * ÜÇ AYRI KOŞUL KATMANI, her kadroda birlikte sağlanmalı:
 *   I.   Girişimci ve Yenilikçi Üniversite Faaliyetleri — proje veya patent
 *   II.  Yayın / Etkinlik Koşulu — makale SAYISI
 *   III. Puan Koşulu — zorunlu puan türünden asgari + toplam
 *
 * I. KOŞUL TELAFİLİDİR ve telafisi alan başına farklı: sağlıkta makale
 * sayısını 3'ten 5'e çıkarmak, sosyalde bir ilave SCIE makalesi, güzel
 * sanatlarda etkinlik sayısını 2'den 3'e çıkarmak. Motor `telafi` dalıyla
 * kuruldu; proje/patent kalemleri cetvele girilmediği için ana dal `beyan`.
 *
 * ÜÇ ALAN GRUBU: Sağlık/Mühendislik/Fen · Sosyal Bilimler · Güzel Sanatlar.
 * Yönerge başka temel alan tanımlamıyor; ilahiyat, hukuk, ziraat gibi alanlarda
 * eşik üretilmiyor.
 *
 * "HORIZON EUROPE PROJE YÜRÜTÜCÜ KOORDİNATÖRLÜĞÜ" yapan adaylarda özel
 * koşulların HİÇBİRİ aranmıyor — her kadroda bu bir üst düzey muafiyet.
 * Motor bunu ayrı bir beyan düğümü olarak gösteriyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/cerrahpasa-2023.php
 */

use App\Services\Scoring\Sart\Kalip;

$fenSaglik = ['saglik', 'fen', 'muhendislik'];

/**
 * "Girişimci ve Yenilikçi Üniversite Faaliyetleri" koşulu ve alan başına
 * değişen telafisi.
 *
 * @param  array<string, mixed>  $telafi
 * @return array<string, mixed>
 */
$girisimciKosulu = fn (array $telafi): array => Kalip::beyan(
    'Uluslararası projede görev, dış kaynaklı ulusal projede görev ya da patent başvurusu',
    'Özel Koşul I',
) + ['telafi' => $telafi];

/** Her kadroda geçerli, koşulların tamamını kaldıran muafiyet. */
$horizonMuafiyeti = fn (): array => Kalip::beyan(
    'Horizon Europe projesinde Üniversite adresli Proje Yürütücü Koordinatörlüğü yapmış olmak — '
    .'bu durumda özel koşulların hiçbiri aranmaz',
    'Genel Koşullar',
);

return [
    // ══════════════════ DR. ÖĞRETİM ÜYESİ (EK-2) ══════════════════
    [
        'anahtar' => 'cerrahpasa-dr-fen-saglik',
        'aday_notu' => 'Proje veya patent koşulunu sağlayamıyorsanız makale sayısını 3\'ten 5\'e çıkararak karşılayabilirsiniz.',
        'universite' => 'İstanbul Üniversitesi-Cerrahpaşa',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $fenSaglik,
        'cetvel' => 'cerrahpasa-2023',
        'notlar' => 'EK-2. Yayın koşulu: SCIE/SSCI/AHCI 3 adet, en az biri doktora/uzmanlık tezi ile ilişkili. Puan koşulu: A1-A11\'den 100, toplam 300.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sağlık / Mühendislik / Fen', [
            Kalip::adet('SCIE/SSCI/AHCI dergilerde en az 3 makale', ['SCIE-TUM'], 3),
            Kalip::beyan('Bu makalelerden en az biri doktora/uzmanlık tezi ile ilişkili olmalı', 'EK-2 II'),
            $girisimciKosulu(Kalip::adet('Proje/patent yoksa: SCIE/SSCI/AHCI dergilerde 5 makale', ['SCIE-TUM'], 5)),
            Kalip::puanDan('A1-A11 kalemlerinden en az 100 puan', ['*'], 100, madde: 'EK-2 III'),
            Kalip::toplam(300),
            Kalip::yds(65),
            $horizonMuafiyeti(),
        ]),
    ],
    [
        'anahtar' => 'cerrahpasa-dr-sosyal',
        'aday_notu' => 'İki koşul birlikte: doktora tezi ile ilişkili 1 SCIE/SSCI/AHCI makalesi ve 2 uluslararası hakemli makale. Proje/patent yerine ilave bir SCIE makalesi de kabul ediliyor.',
        'universite' => 'İstanbul Üniversitesi-Cerrahpaşa',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim', 'filoloji'],
        'cetvel' => 'cerrahpasa-2023',
        'notlar' => 'EK-2. Sosyal Bilimler: SCIE/SSCI/AHCI 1 adet (doktora tezi ile ilişkili) + Uluslararası Hakemli 2 adet. Puan koşulu: A1-A11 ve C1-C7\'den 100, toplam 300.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Sosyal Bilimler', [
            Kalip::adet('SCIE/SSCI/AHCI dergide en az 1 makale', ['SCIE-TUM'], 1),
            Kalip::adet('Uluslararası hakemli dergilerde en az 2 makale', ['ULUSLARARASI-HAKEMLI'], 2),
            Kalip::beyan('SCIE/SSCI/AHCI makalesi doktora tezi ile ilişkili olmalı', 'EK-2 II'),
            $girisimciKosulu(Kalip::adet('Proje/patent yoksa: ilave 1 SCIE/SSCI/AHCI makalesi', ['SCIE-TUM'], 2)),
            Kalip::puanDan('A1-A11 kalemlerinden en az 100 puan', ['*'], 100, madde: 'EK-2 III'),
            Kalip::toplam(300),
            Kalip::yds(65),
            $horizonMuafiyeti(),
        ]),
    ],
    [
        'anahtar' => 'cerrahpasa-dr-guzel-sanatlar',
        'aday_notu' => 'Güzel Sanatlarda makale yerine tasarım, performans ve sergi etkinlikleri sayılıyor.',
        'universite' => 'İstanbul Üniversitesi-Cerrahpaşa',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['guzel_sanatlar', 'mimarlik'],
        'cetvel' => 'cerrahpasa-2023',
        'notlar' => 'EK-2. Güzel Sanatlar: uluslararası/ulusal hakemli dergide makale veya tasarım/performans/sergi — 2 adet. Puan koşulu: Ç bölümünden 100, toplam 300.',
        'sart' => Kalip::ve('Dr. Öğr. Üyesi — Güzel Sanatlar / Mimarlık', [
            Kalip::adet('Makale veya sanatsal etkinlik — en az 2 adet', ['ULUSLARARASI-HAKEMLI'], 2),
            $girisimciKosulu(Kalip::adet('Proje/patent yoksa: en az 3 etkinlik', ['ULUSLARARASI-HAKEMLI'], 3)),
            Kalip::toplam(300),
            Kalip::yds(65),
            $horizonMuafiyeti(),
        ]),
    ],

    // ══════════════════ DOÇENT (EK-4) ══════════════════
    [
        'anahtar' => 'cerrahpasa-docent-fen-saglik',
        'aday_notu' => 'Beş makalenin en az ikisi doktora sonrası ve tez dışı, en az biri Q1/Q2 dergide olmalı.',
        'universite' => 'İstanbul Üniversitesi-Cerrahpaşa',
        'kadro' => 'docentlik',
        'alan' => $fenSaglik,
        'cetvel' => 'cerrahpasa-2023',
        'notlar' => 'EK-4. SCIE/SSCI/AHCI 5 adet; en az ikisi doktora/uzmanlık sonrası ve tez dışı, en az biri Q1/Q2. Puan koşulu: toplam 600.',
        'sart' => Kalip::ve('Doçent — Sağlık / Mühendislik / Fen', [
            Kalip::adet('SCIE/SSCI/AHCI dergilerde en az 5 makale', ['SCIE-TUM'], 5),
            Kalip::adet('En az 2\'si doktora sonrası ve tez dışı olmalı', ['SCIE-TUM'], 2, donem: Kalip::DOKTORA_SONRASI)
                + ['haric' => ['lisansustu_tezden']],
            Kalip::adet('En az 1\'i Q1 veya Q2 dergide olmalı', ['A4a-Q1', 'A4a-Q2'], 1),
            $girisimciKosulu(Kalip::adet('Proje/patent yoksa: birinci yazar olduğunuz 2 ilave SCIE makalesi', ['SCIE-TUM'], 7, 'ilk')),
            Kalip::toplam(600),
            $horizonMuafiyeti(),
        ]),
    ],
    [
        'anahtar' => 'cerrahpasa-docent-sosyal',
        'aday_notu' => 'İki koşul birlikte: 2 SCIE/SSCI/AHCI ve 4 uluslararası hakemli makale; her ikisinde de doktora sonrası ve ilk/sorumlu yazar olduğunuz en az bir yayın olmalı.',
        'universite' => 'İstanbul Üniversitesi-Cerrahpaşa',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'egitim', 'filoloji'],
        'cetvel' => 'cerrahpasa-2023',
        'notlar' => 'EK-4. Sosyal: SCIE/SSCI/AHCI 2 adet + Uluslararası Hakemli 4 adet. Puan koşulu: toplam 600.',
        'sart' => Kalip::ve('Doçent — Sosyal Bilimler', [
            Kalip::adet('SCIE/SSCI/AHCI dergilerde en az 2 makale', ['SCIE-TUM'], 2),
            Kalip::adet('Uluslararası hakemli dergilerde en az 4 makale', ['ULUSLARARASI-HAKEMLI'], 4),
            Kalip::adet('Doktora sonrası ve tez dışı, ilk veya sorumlu yazar olduğunuz en az 1 yayın',
                ['ULUSLARARASI-HAKEMLI'], 1, 'ilk', donem: Kalip::DOKTORA_SONRASI)
                + ['haric' => ['lisansustu_tezden']],
            $girisimciKosulu(Kalip::adet('Proje/patent yoksa: 3 SCIE ve 5 uluslararası hakemli makale', ['SCIE-TUM'], 3)),
            Kalip::toplam(600),
            $horizonMuafiyeti(),
        ]),
    ],
    [
        'anahtar' => 'cerrahpasa-docent-guzel-sanatlar',
        'aday_notu' => 'Bir makale yerine üç uluslararası sanatsal etkinlik konulabiliyor; bu durumda etkinlikte küratör, yürütücü veya yönetmen olmanız ya da etkinliğin kişisel olması gerekiyor.',
        'universite' => 'İstanbul Üniversitesi-Cerrahpaşa',
        'kadro' => 'docentlik',
        'alan' => ['guzel_sanatlar', 'mimarlik'],
        'cetvel' => 'cerrahpasa-2023',
        'notlar' => 'EK-4. Güzel Sanatlar: uluslararası hakemli dergide 2 makale (doktora/sanatta yeterlik sonrası) + 5 tasarım/performans/sergi etkinliği. Puan koşulu: Ç bölümünden 250, toplam 600.',
        'sart' => Kalip::ve('Doçent — Güzel Sanatlar / Mimarlık', [
            Kalip::adet('Doktora sonrası uluslararası hakemli dergide en az 2 makale',
                ['ULUSLARARASI-HAKEMLI'], 2, donem: Kalip::DOKTORA_SONRASI),
            Kalip::beyan('En az 5 uluslararası/ulusal tasarım, performans veya sergi etkinliği', 'EK-4 II Koşul 2'),
            Kalip::beyan('Bir makale yerine 3 uluslararası etkinlik konulabilir (küratör/yürütücü/yönetmen ya da kişisel etkinlik)', 'EK-4 II'),
            $girisimciKosulu(Kalip::beyan('Proje/patent yoksa: Koşul 2 şartını 7 etkinlik olarak sağlamak', 'EK-4 I')),
            Kalip::toplam(600),
            $horizonMuafiyeti(),
        ]),
    ],

    // ══════════════════ PROFESÖR (EK-5) ══════════════════
    // Koşulların tamamı DOÇENT UNVANI SONRASI dönem için geçerli.
    [
        'anahtar' => 'cerrahpasa-profesor-fen-saglik',
        'aday_notu' => 'Yedi makalenin en az ikisi Q1/Q2 dergide olmalı ve tamamı doçentlik sonrası dönemden gelmeli. Proje/patent koşulu sağlanamıyorsa 10 makale isteniyor.',
        'universite' => 'İstanbul Üniversitesi-Cerrahpaşa',
        'kadro' => 'profesorluk',
        'alan' => $fenSaglik,
        'cetvel' => 'cerrahpasa-2023',
        'notlar' => 'EK-5. Doçentlik sonrası SCIE/SSCI/AHCI 7 makale, en az ikisi Q1/Q2. Telafi: 10 makale, en az 3\'ünde birinci yazar.',
        'sart' => Kalip::ve('Profesör — Sağlık / Mühendislik / Fen', [
            Kalip::adet('Doçentlik sonrası SCIE/SSCI/AHCI dergilerde en az 7 makale',
                ['SCIE-TUM'], 7, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Bunların en az 2\'si Q1 veya Q2 dergide olmalı',
                ['A4a-Q1', 'A4a-Q2'], 2, donem: Kalip::DOCENTLIK_SONRASI),
            $girisimciKosulu(Kalip::adet('Proje/patent yoksa: 10 makale, en az 3\'ünde birinci yazar',
                ['SCIE-TUM'], 3, 'ilk', donem: Kalip::DOCENTLIK_SONRASI)),
            $horizonMuafiyeti(),
        ]),
    ],
    [
        'anahtar' => 'cerrahpasa-profesor-sosyal',
        'aday_notu' => 'Dört SCIE/SSCI/AHCI ve altı uluslararası hakemli makale; tamamı doçentlik sonrası. Proje/patent yoksa sırasıyla 6 ve 8 makaleye çıkıyor.',
        'universite' => 'İstanbul Üniversitesi-Cerrahpaşa',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'egitim', 'filoloji'],
        'cetvel' => 'cerrahpasa-2023',
        'notlar' => 'EK-5. Sosyal: doçentlik sonrası SCIE/SSCI/AHCI 4 makale + alan indeksli uluslararası hakemli 6 makale. Telafi: 6 ve 8 makale.',
        'sart' => Kalip::ve('Profesör — Sosyal Bilimler', [
            Kalip::adet('Doçentlik sonrası SCIE/SSCI/AHCI dergilerde en az 4 makale',
                ['SCIE-TUM'], 4, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::adet('Doçentlik sonrası uluslararası hakemli dergilerde en az 6 makale',
                ['ULUSLARARASI-HAKEMLI'], 6, donem: Kalip::DOCENTLIK_SONRASI),
            $girisimciKosulu(Kalip::adet('Proje/patent yoksa: 6 SCIE ve 8 uluslararası hakemli makale',
                ['SCIE-TUM'], 6, donem: Kalip::DOCENTLIK_SONRASI)),
            $horizonMuafiyeti(),
        ]),
    ],
    [
        'anahtar' => 'cerrahpasa-profesor-guzel-sanatlar',
        'universite' => 'İstanbul Üniversitesi-Cerrahpaşa',
        'kadro' => 'profesorluk',
        'alan' => ['guzel_sanatlar', 'mimarlik'],
        'cetvel' => 'cerrahpasa-2023',
        'notlar' => 'EK-5. Güzel Sanatlar: doçentlik sonrası makale ve sanatsal etkinlik koşulları.',
        'sart' => Kalip::ve('Profesör — Güzel Sanatlar / Mimarlık', [
            Kalip::adet('Doçentlik sonrası uluslararası hakemli dergide en az 2 makale',
                ['ULUSLARARASI-HAKEMLI'], 2, donem: Kalip::DOCENTLIK_SONRASI),
            Kalip::beyan('Doçentlik sonrası tasarım, performans veya sergi etkinlikleri', 'EK-5 II'),
            $girisimciKosulu(Kalip::beyan('Proje/patent yoksa: etkinlik sayısını artırmak', 'EK-5 I')),
            $horizonMuafiyeti(),
        ]),
    ],
];
