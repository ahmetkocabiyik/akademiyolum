<?php

/**
 * KONYA TEKNİK ÜNİVERSİTESİ — Akademik Atama-Yükseltme Ölçütleri ve
 * Uygulama Esasları
 * Kaynak: pdf/17537002512.konyateknikuniverstesi.pdf (24 sayfa)
 *
 * ── YAPI: GENEL + İKİ TEMEL ALAN İÇİN ÖZEL DURUM ──
 * Madde 6 "Aksi belirtilmediği sürece Genel Tanım hükümleri geçerlidir"
 * diyor; madde 8/10/12 genel koşulları, madde 9/11/13 ise MİMARLIK,
 * PLANLAMA VE TASARIM ile SOSYAL, BEŞERİ VE İDARİ BİLİMLER temel
 * alanlarının koşullarını veriyor. Bu iki alan `ktun-2024-mps`
 * cetveline, kalan on temel alan `ktun-2024` cetveline bağlandı.
 * Barajların sayıları (60/130/190, 80/70/30/370/500, 50/200/550/650)
 * iki grupta AYNI; fark yalnızca hangi yayın türlerinin sayıldığında.
 *
 * ── YENİDEN ATANMA KADROSU YAZILMADI ──
 * Madde 7 yeniden atanmayı ATAMA SÜRESİNE bağlıyor: "her 1 yıllık atama
 * süresi için A-F arası faaliyetlerden en az 20 puan". Bir yıllıkta 20,
 * dört yıllıkta 80 puan demek; profil atama süresini tutmadığı için tek
 * bir eşik yazmak ya adayı hazır sanmasına (20) ya da gereksiz yere
 * hazır değil sanmasına (80) yol açardı. Merdiven diğer eşiklerin aday
 * notunda yazılı. Ayrıca doçent unvanı almış olup doktor öğretim üyesi
 * kadrosunda çalışanlarda yeniden atama koşulu hiç aranmıyor.
 *
 * ── "PUANLANMAMIŞ OLMAK KAYDIYLA" UYGULANMIYOR ──
 * Madde 10c, 11c, 12b, 13b bir faaliyetin ÖNCEKİ bentte sayılmamış
 * olmasını şart koşuyor (aynı makale hem başlıca eser hem 80 puanlık
 * baraj için kullanılamaz). Motor her koşulu bağımsız değerlendiriyor;
 * bir faaliyet birden çok bentte sayılabiliyor. Bu yüzden bu bentlerde
 * koşul OLDUĞUNDAN KOLAY görünür.
 *
 * ── BAŞLICA ESER "BAŞLICA YAZAR" DALIYLA UYGULANDI ──
 * Madde 6 başlıca eseri dört biçimde tanımlıyor: tek yazarlı makale,
 * danışmanıyla birlikte yazdığı makale, danışmanlığındaki öğrenci
 * tezinden çıkmış makale, yürütücülüğünü yaptığı projeden hazırlanmış
 * makale (ve kitap yazarlığı). Kayıt bu ilişkileri taşımadığı için koşul
 * "tek, ilk ya da sorumlu yazar olmak" dalıyla uygulandı; öğrenciyle ya
 * da danışmanla ortak yazılmış ama ilk isim olmadığınız makaleler
 * sayılmıyor, koşul OLDUĞUNDAN ZOR görünür.
 *
 * ── "K/L/M PUANI YOKSA A'DAN TAMAMLAMA" SEÇENEĞİ UYGULANMIYOR ──
 * 8e, 9e, 10e, 11e, 12c, 13c "bu kategorilerde faaliyet puanı yoksa /
 * eksikse, karşılığı kadar A türü yayınlardan puan almış olmalı" diyor.
 * Telafi, hangi A puanının önceki bentlerde kullanıldığına bağlı olduğu
 * için hesaplanamıyor; K, L, M barajı doğrudan uygulandı ve koşul
 * OLDUĞUNDAN ZOR görünür.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   8d / 9d: "en az biri doktora tezinden olmak üzere lisansüstü
 *       tezinden üretilmiş en az iki faaliyet" — kayıt bir yayının
 *       hangi tezden üretildiğini taşımıyor; `beyan`.
 *   2.9: doçentlik sözlü sınavını başarmış olmak — `beyan`.
 *   2.7: doçentlikten sonra beş yıl çalışmış olmak — `beyan`.
 *   2.8: yağmacı/şaibeli dergilerin sayılmaması.
 *   Madde 4'ün AYÖK belgesi alma şartı ve madde 5'in jüri raporları —
 *       süreç kuralları.
 *
 * ── YABANCI DİL ──
 * Madde 2.6 bütün kadrolar için 65 puan istiyor; tamamen yabancı dille
 * öğretim yapan bölümlerde 85. Profil bölümün öğretim dilini tutmadığı
 * için §0 uyarınca DÜŞÜK olan (65) uygulandı ve 85 aday notunda yazıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/ktun-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Konya Teknik Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$YENIDEN_NOTU = ' Doktor öğretim üyeliğine YENİDEN ATANMA için ayrı bir eşik yazılmadı: '
    .'madde 7 her bir yıllık atama süresi için A-F arası faaliyetlerden 20 puan istiyor '
    .'(bir yıllık atamada 20, iki yıllıkta 40, üç yıllıkta 60, dört yıllıkta 80 puan). '
    .'Doçent unvanı almış olup doktor öğretim üyesi kadrosunda görev yapanlarda yeniden atama '
    .'koşulu aranmıyor.';

$DIL_NOTU = ' Yabancı dil koşulu 65 puandan uygulanıyor; tamamen yabancı dille öğretim yapan '
    .'bölümlere başvuruyorsanız 85 puan gerekir.';

$genelSartlar = Kalip::yds(65);

$sozluSinav = Kalip::beyan('Doçentlik sözlü sınavını başarmış olmak', '2.9');

$besYil = Kalip::beyan(
    'Doçentlik unvanını aldıktan sonra en az beş yıl süreyle açık bulunan profesörlük kadrosuyla '
    .'ilgili bilim alanında çalışmış olmak',
    '2.7',
);

$tezdenUretilmis = Kalip::beyan(
    'En az biri doktora tezinizden olmak üzere yüksek lisans ve/veya doktora tezinizden '
    .'üretilmiş en az iki faaliyet (makale, bildiri, kitap ya da proje) yapmış olmak',
    '8-d',
);

$esikler = [];

foreach ([
    ['genel', ['fen', 'muhendislik', 'saglik', 'ziraat', 'egitim', 'hukuk', 'filoloji',
        'ilahiyat', 'spor', 'guzel_sanatlar'], 'ktun-2024', false,
        'A-1a, A-1b, A-2a ve A-2b türü yayınlarınızdan', ['8', '10', '12']],
    ['mps', ['mimarlik', 'sosyal'], 'ktun-2024-mps', true,
        'A-1a, A-1b, A-1g, A-2a, A-2b, A-3a, A-4a, B, C-1 ve C-2 türü yayınlarınızdan',
        ['9', '11', '13']],
] as [$anahtar, $alanlar, $cetvel, $mps, $drYayinAdi, $maddeler]) {
    [$mdDr, $mdDoc, $mdProf] = $maddeler;
    $alanAdi = $mps
        ? 'Mimarlık, Planlama ve Tasarım ile Sosyal, Beşeri ve İdari Bilimler temel alanları'
        : 'genel hükümler';

    // ── DOKTOR ÖĞRETİM ÜYELİĞİ (madde 8 / 9) ──
    $drKosullar = [
        $genelSartlar,
        Kalip::adet(
            'Başlıca eser niteliğinde en az 1 faaliyet (tek, ilk ya da sorumlu yazar olduğunuz '
            .'özgün araştırma makalesi veya kitap yazarlığı)',
            ['BASLICA-DR'], 1, yazar: 'baslica', madde: "{$mdDr}-a",
        ),
        Kalip::puanDan("{$drYayinAdi} toplam en az 60 puan", ['DR-8b'], 60, madde: "{$mdDr}-b"),
    ];

    if ($mps) {
        $drKosullar[] = Kalip::adet(
            'B-1, B-2, D veya E-1 türü en az 4 faaliyet (ulusal makale ya da bildiri)',
            ['DR-9c'], 4, madde: '9-c',
        );
    } else {
        $drKosullar[] = Kalip::adet(
            'TR Dizin kapsamında (D-1) en az 1 araştırma makalesi', ['D1'], 1, madde: '8-c',
        );
        $drKosullar[] = Kalip::adet(
            'D-1 ya da D-2 türü toplam en az 2 ulusal araştırma makalesi', ['D12'], 2, madde: '8-c',
        );
        $drKosullar[] = Kalip::adet(
            'B-1 ya da E-1 türü en az 2 tam metin bildiri', ['B1E1'], 2, madde: '8-c',
        );
    }

    $drKosullar[] = $tezdenUretilmis;
    $drKosullar[] = Kalip::puanDan(
        'K (Ar-Ge projeleri), L (patentler) ve M (yarışmalar, sergileme) faaliyetlerinizden '
        .'en az 15 puan',
        ['KLM'], 15, madde: "{$mdDr}-e",
    );
    $drKosullar[] = Kalip::puanDan(
        'A-G arası ve K, L, M faaliyetlerinizden en az 130 puan', ['AG-KLM'], 130, madde: "{$mdDr}-f",
    );
    $drKosullar[] = Kalip::toplam(190);

    $esikler[] = [
        'anahtar' => "ktun-{$anahtar}-dr",
        'aday_notu' => "{$alanAdi}: başlıca eser niteliğinde 1 faaliyet, "
            ."{$drYayinAdi} 60 puan, ulusal makale ve bildiri sayısı, K-L-M faaliyetlerinden 15 "
            .'puan, A-G ile K-L-M faaliyetlerinden 130 puan ve tüm faaliyetlerden 190 puan '
            .'isteniyor. Ayrıca en az biri doktora tezinizden olmak üzere lisansüstü '
            .'tezlerinizden üretilmiş iki faaliyet belgelemeniz gerekiyor.'
            .$DIL_NOTU.$YENIDEN_NOTU,
        'universite' => $UNIVERSITE,
        'kadro' => 'dr_ogr_uyesi',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => "Madde {$mdDr}: başlıca eser 1; yayın puanı 60; ulusal makale-bildiri "
            .'sayıları; K+L+M 15 puan; (A-G)+(K+L+M) 130 puan; toplam 190 puan; madde 2.6.',
        'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna atanma — {$alanAdi}", $drKosullar),
    ];

    // ── DOÇENTLİK (madde 10 / 11) ──
    $esikler[] = [
        'anahtar' => "ktun-{$anahtar}-docentlik",
        'aday_notu' => "{$alanAdi}: doktora unvanınızı aldıktan sonra başlıca "
            .'eser niteliğinde 2 faaliyet ve bunlardan ayrı en az 1 nitelikli yayın, seçili '
            .'yayın türlerinden 80 puan, B-C-D-E-F kategorilerinden 70 puan (en az yarısı '
            .'doktora sonrası), K-L-M faaliyetlerinden 30 puan (doktora sonrası), A-G ile '
            .'K-L-M faaliyetlerinden 370 puan ve tüm faaliyetlerden 500 puan isteniyor. Ayrıca '
            .'başvurduğunuz alanda ders veriyor ya da danışman olarak tez yönetmiş olmalısınız '
            .'(eş danışmanlık sayılmaz; ön lisans kadrolarında bu şart aranmıyor).'
            .$DIL_NOTU,
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => "Madde {$mdDoc}: doktora sonrası 2 başlıca eser + 1 faaliyet; 80 puan; "
            .'B-C-D-E-F 70 puan (yarısı doktora sonrası); K+L+M 30 puan (doktora sonrası); '
            .'ders ya da tez danışmanlığı; (A-G)+(K+L+M) 370 puan; toplam 500 puan.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$alanAdi}", [
            $genelSartlar,
            $sozluSinav,
            Kalip::adet(
                'Doktora unvanınızı aldıktan sonra, kendi lisansüstü çalışmalarınızdan '
                .'üretilmemiş, başlıca eser niteliğinde en az 2 faaliyet',
                ['BASLICA-DOC'], 2, yazar: 'baslica', donem: $DOKTORA, madde: "{$mdDoc}-a",
            ),
            Kalip::adet(
                'Doktora unvanınızı aldıktan sonra, başlıca eser olarak kullanmadığınız en az '
                .'1 nitelikli yayın daha',
                ['DOC-10b'], 1, donem: $DOKTORA, madde: "{$mdDoc}-b",
            ),
            Kalip::puanDan(
                'Seçili yayın türlerinden (Q dergilerde makale, ESCI makalesi, uluslararası '
                .'kitap ve kitap bölümü) en az 80 puan',
                ['DOC-10c'], 80, madde: "{$mdDoc}-c",
            ),
            Kalip::puanDan(
                'B, C, D, E ve F kategorilerinden toplam en az 70 puan',
                ['BCDEF'], 70, madde: "{$mdDoc}-d",
            ),
            Kalip::puanDan(
                'Bu 70 puanın en az yarısı doktora unvanınızı aldıktan sonra',
                ['BCDEF'], 35, $DOKTORA, madde: "{$mdDoc}-d",
            ),
            Kalip::puanDan(
                'Doktora unvanınızı aldıktan sonra K, L ve M faaliyetlerinizden en az 30 puan',
                ['KLM'], 30, $DOKTORA, madde: "{$mdDoc}-e",
            ),
            Kalip::veya('Ders verme ya da tez danışmanlığı koşulu', [
                Kalip::metrik(
                    'Başvurduğunuz alanda lisans ya da lisansüstü ders veriyor olmak',
                    'ders_yariyil', 1,
                ),
                Kalip::adet(
                    'Ya da danışman olarak yüksek lisans veya doktora tezi yönetmiş olmak '
                    .'(eş danışmanlık sayılmaz)',
                    ['TEZ-DANISMAN'], 1, madde: "{$mdDoc}-f",
                ),
            ]),
            Kalip::puanDan(
                'A-G arası ve K, L, M faaliyetlerinizden en az 370 puan',
                ['AG-KLM'], 370, madde: "{$mdDoc}-g",
            ),
            Kalip::toplam(500),
        ]),
    ];

    // ── PROFESÖRLÜK (madde 12 / 13) ──
    $esikler[] = [
        'anahtar' => "ktun-{$anahtar}-profesorluk",
        'aday_notu' => "{$alanAdi}: başlıca eser niteliğinde 3 faaliyet "
            .'(en az 1\'i doçentlik unvanınızdan sonra), doçentlik sonrası seçili yayın '
            .'türlerinden 2 faaliyet, doçentlik sonrası K-1/K-2/K-3, L ve M faaliyetlerinden '
            .'50 puan, doçentlik sonrası A-G ile K-L-M faaliyetlerinden 200 puan, aynı '
            .'kümeden toplam 550 puan ve tüm faaliyetlerden 650 puan isteniyor. Doçentlik '
            .'unvanınızı aldıktan sonra en az beş yıl ilgili bilim alanında çalışmış '
            .'olmalısınız.'.$DIL_NOTU,
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $cetvel,
        'notlar' => "Madde {$mdProf}: 3 başlıca eser (1'i doçentlik sonrası); doçentlik sonrası "
            .'2 faaliyet; K-1/K-2/K-3+L+M 50 puan (doçentlik sonrası); (A-G)+(K+L+M) doçentlik '
            .'sonrası 200, toplam 550 puan; tüm faaliyetlerden 650 puan.',
        'sart' => Kalip::ve("Profesör kadrosuna yükseltilme ve atanma — {$alanAdi}", [
            $genelSartlar,
            $besYil,
            $sozluSinav,
            Kalip::adet(
                'Başlıca eser niteliğinde en az 3 faaliyet', ['BASLICA-DOC'], 3,
                yazar: 'baslica', madde: "{$mdProf}-a",
            ),
            Kalip::adet(
                'Bu başlıca eserlerden en az 1\'i doçentlik unvanınızı aldıktan sonra',
                ['BASLICA-DOC'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: "{$mdProf}-a",
            ),
            Kalip::adet(
                'Doçentlik unvanınızı aldıktan sonra, başlıca eser olarak kullanmadığınız '
                .'seçili yayın türlerinden en az 2 faaliyet',
                ['PROF-12b'], 2, donem: $DOCENTLIK, madde: "{$mdProf}-b",
            ),
            Kalip::puanDan(
                'Doçentlik unvanınızı aldıktan sonra K-1, K-2, K-3 (Ar-Ge projeleri), L '
                .'(patentler) ve M (yarışmalar, sergileme) faaliyetlerinizden en az 50 puan',
                ['K123LM'], 50, $DOCENTLIK, madde: "{$mdProf}-c",
            ),
            Kalip::puanDan(
                'Doçentlik unvanınızı aldıktan sonra A-G arası ve K, L, M faaliyetlerinizden '
                .'en az 200 puan',
                ['AG-KLM'], 200, $DOCENTLIK, madde: "{$mdProf}-d",
            ),
            Kalip::puanDan(
                'A-G arası ve K, L, M faaliyetlerinizden toplam en az 550 puan',
                ['AG-KLM'], 550, madde: "{$mdProf}-d",
            ),
            Kalip::toplam(650),
        ]),
    ];
}

return $esikler;
