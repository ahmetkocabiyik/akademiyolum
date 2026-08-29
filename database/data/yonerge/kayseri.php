<?php

/**
 * KAYSERİ ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Ölçütleri
 * Kaynak: pdf/17536999912.kayseriuniverstesi.pdf (23 sayfa; Senato
 * 03.04.2024-10, YÖK Genel Kurulu 24.10.2024; Bilgisayar ve Bilişim
 * Bilimleri Fakültesi ölçütleri Senato 27.12.2024 ve YÖK 30.01.2025)
 *
 * ── YAPI: KADRO × BİRİM TÜRÜ × ALAN ──
 * Her kadro önce "Ortak Şartlar (Tüm Birimler)" veriyor, sonra meslek
 * yüksekokulları (B1-B4) ve fakülteler (C1a, C1b, C2, C3, C4) için ayrı
 * ölçüt blokları sıralıyor. Blokların metni normalleştirilip
 * karşılaştırıldığında meslek yüksekokulu ile fakülte ölçütlerinin ÜÇ
 * alanda birebir aynı olduğu görüldü:
 *   B1 = C1a = C4 → mühendislik, fen, ziraat (teknik bilimler)
 *   B2 = C2       → sosyal, beşeri ve idari bilimler (ilahiyat dâhil)
 *   B3 = C3       → sağlık bilimleri
 * Yalnızca mimarlık ve tasarım alanında meslek yüksekokulu (B4) ile
 * fakülte (C1b) profesörlükte ayrışıyor: C1b profesörlüğe altı seçenekli
 * bir ek koşul daha ekliyor. Bu ayrım `birim` ile kuruldu ve tutarlılık
 * için üç kadroda da uygulandı.
 *
 * Alan eşlemesi: teknik bilimler → `muhendislik`, `fen`, `ziraat`;
 * sosyal, beşeri ve idari bilimler → `sosyal`, `ilahiyat` (Develi İslami
 * İlimler Fakültesi); sağlık bilimleri → `saglik`; mimarlık, planlama,
 * tasarım ve güzel sanatlar → `mimarlik`, `guzel_sanatlar`.
 * Yönerge eğitim, hukuk, filoloji ve spor alanlarını anmıyor; kapsam dışı.
 *
 * ── KAYNAKTAKİ NUMARALANDIRMA HATASI ──
 * Doçentlik bloklarının çoğu "Madde 3'teki puan şartını %20 fazlasıyla
 * sağlamış olmak" diyor; oysa puan şartı Madde 1'de, Madde 3 ise koşul
 * listesinin kendisi. Aynı hata "Madde 3'teki puana ilaveten … 250 puan"
 * ifadesinde de var. Düzeltilmedi, MADDE 1'in puanı esas alındı ve
 * çelişki `notlar` ile aday notunda söylendi.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   V/1: WOS etki faktörü 5 üzeri dergide başlıca yazar olanlardan ya da
 *       h-indeksi eşiğini (Dr. 5, doçent 10, profesör 15) aşanlardan
 *       "herhangi bir ölçüt aranmaz" muafiyeti — `beyan` olarak anıldı;
 *       h-indeksi eşiği `metrik` ile yazılabilirdi ama muafiyetin
 *       BÜTÜN koşulları kaldırması motorun `veya` ağacına sığmıyor.
 *   Doçentlikte ve profesörlükte ÜAK sözlü sınavı, profesörlükte ÜAK
 *       doçentlik başvuru şartlarının tekrarı ve başlıca araştırma eseri
 *       gösterimi — `beyan`.
 *   Profesörlükte "yasal sürenin en az yarısı kadar fiilen çalışmış
 *       olmak" — `beyan`.
 *   Doktor öğretim üyeliğinde süre uzatma (yeniden atanma): V/5 yalnızca
 *       süreç anlatıyor ("dosyayı bir ay önceden teslim eder, tekrar aynı
 *       usulle atanabilir"), SAYISAL bir ölçüt vermiyor. Yeniden atanma
 *       kadrosu bu yüzden hiç açılmadı.
 *   IV. madde: birimlerin Senato onayıyla ilave ölçüt belirleyebilmesi.
 *   V/9: "asgari puanların tamamı aynı maddeden olamaz" — kayıt bazlı
 *       dağılım kuralı.
 *   Proje koşullarındaki "proje BAŞVURUSUNDA bulunmuş ve panelde bilimsel
 *       değerlendirmeye alınmış olmak" dalı — başvuru kaydı yok; aynı
 *       bendin "en az 1 devam eden veya tamamlanmış projede araştırmacı
 *       olmak" dalı yazıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/kayseri-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Kayseri Üniversitesi';
$CETVEL = 'kayseri-2024';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;

$T1A2 = ['T1A-T2'];
// Adaya gösterilen küme adı: T1A (makale, kitap, bildiri, proje, patent,
// editörlük) + T2 (atıf, ödül, idari görev, ders, tez danışmanlığı, toplumsal
// katkı). Güzel sanatlar kalemleri (T1B) bu kümenin dışında (§2 kod yasağı).
$LISTE = 'Bilimsel yayın ve akademik faaliyet';

$MUAFIYET_NOTU = ' DİKKAT: yönergenin V/1 açıklaması, WOS etki faktörü 5 ve üzeri dergilerde '
    .'başlıca yazar olarak yayın yapanlardan ya da WOS h-indeksi Dr. Öğretim Üyeliğinde 5, '
    .'doçentlikte 10, profesörlükte 15 ve üzerinde olanlardan "herhangi bir ölçüt aranmaz" diyor; '
    .'bu muafiyet burada uygulanmıyor.';

$HATA_NOTU = ' Yönergenin doçentlik bloklarında bir numaralandırma hatası var: puan şartı için '
    .'yanlış maddeye atıf yapılıyor. Kaynak düzeltilmeden, doğru maddedeki puan esas alındı.';

$dil = Kalip::yds(65);

$doktora = Kalip::beyan(
    'Doktora; tıp, eczacılık, veterinerlik ya da diş hekimliğinde uzmanlık veya sanatta yeterlik '
    .'unvanını ilgili alanda almış olmak',
    'I/A-1',
);

$docentUnvani = Kalip::beyan('Doçent unvanını almış olmak', 'II/A-1');
$docentSozlu = Kalip::beyan('ÜAK tarafından oluşturulan jürilerce yapılan sözlü sınavda başarılı olmak', 'II/A-4');

$profesorOn = [
    Kalip::yds(65),
    Kalip::beyan('ÜAK tarafından oluşturulan jürilerce yapılan doçentlik sözlü sınavında başarılı olmak', 'III/A-3'),
    Kalip::beyan(
        'İlgili alanda YÖK tarafından belirlenmiş (başvurduğunuz dönemdeki) doçentlik başvuru '
        .'şartlarını tekrar sağlamış olmak; lisansüstü tezlerden üretilmiş yayın şartını '
        .'sağlayamayanlar bunun yerine uluslararası indeksli bir dergide en az bir araştırma '
        .'makalesi yayımlamak zorundadır',
        'III/A-4',
    ),
    Kalip::beyan(
        'Doçent unvanını aldıktan sonraki döneme ait yayınlarınızdan birini başlıca araştırma '
        .'eseri olarak sunmak',
        'III/A-6',
    ),
    Kalip::beyan(
        'Doçent unvanını aldıktan sonra profesörlüğe atanabilmek için gerekli yasal sürenin en az '
        .'yarısı kadar üniversitelerde ya da alanınızla ilgili bilimsel bir araştırma kuruluşunda '
        .'fiilen çalışmış olmak',
        'III/A-7',
    ),
];

$yurtdisi = Kalip::metrik(
    'Yurt dışında bir yükseköğretim ya da araştırma kurumunda en az 3 ay akademik amaçlı '
    .'çalışmış veya araştırmalarda bulunmuş olmak',
    'yurtdisi_ay', 3,
);

$projeKosulu = fn (string $md): array => Kalip::veya('Proje koşulu', [
    Kalip::adet('En az 1 projede yürütücü olmak', ['PROJE-Y'], 1, madde: $md),
    Kalip::adet('Ya da en az 2 projede araştırmacı olmak', ['PROJE-A'], 2, madde: $md),
]);

$tezKosulu = fn (int $yl, int $dr, ?array $donem, string $md): array => Kalip::veya(
    'Lisansüstü tez danışmanlığı koşulu', [
        Kalip::adet("Yönetiminizde tamamlanmış en az {$dr} doktora tezi", ['TEZ-DOKTORA'], $dr, donem: $donem, madde: $md),
        Kalip::adet("Ya da yönetiminizde tamamlanmış en az {$yl} yüksek lisans tezi", ['TEZ-YL'], $yl, donem: $donem, madde: $md),
    ],
);

$tekYazarliKitap = fn (?array $donem, string $md): array => Kalip::veya(
    'Tek yazarlı kitap ya da editörlük koşulu', [
        Kalip::adet('Tek yazarlı ulusal ya da uluslararası bilimsel bir kitap yayımlamış olmak', ['KITAP-TEK'], 1, yazar: 'tek', donem: $donem, madde: $md),
        Kalip::adet('Ya da bir kitabın editörlüğünü yapmış olmak', ['KITAP-EDITOR'], 1, donem: $donem, madde: $md),
    ],
);

$esikler = [];

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $kosullar
 * @return array<string, mixed>
 */
$esik = function (string $anahtar, string $kadro, array $alanlar, ?string $birim, string $setAdi,
    array $on, array $kosullar, string $not, string $notlar,
) use ($UNIVERSITE, $CETVEL, $MUAFIYET_NOTU): array {
    $ad = match ($kadro) {
        'dr_ogr_uyesi' => 'Doktor Öğretim Üyesi kadrosuna atanma',
        'docentlik' => 'Doçent kadrosuna atanma',
        default => 'Profesör kadrosuna atanma',
    };

    return [
        'anahtar' => "kayseri-{$anahtar}-".str_replace('_', '-', $kadro),
        'aday_notu' => "{$setAdi} ölçütleri uygulanıyor. {$not}".$MUAFIYET_NOTU,
        'universite' => $UNIVERSITE,
        'kadro' => $kadro,
        'alan' => $alanlar,
        'birim' => $birim,
        'cetvel' => $CETVEL,
        'notlar' => $notlar,
        'sart' => Kalip::ve("{$ad} — {$setAdi}", array_values(array_merge($on, $kosullar))),
    ];
};

$TEKNIK = ['muhendislik', 'fen', 'ziraat'];
$SOSYAL = ['sosyal', 'ilahiyat'];
$SAGLIK = ['saglik'];
$SANAT = ['mimarlik', 'guzel_sanatlar'];

// ══════════════════════════════════════════════════════════════════════════
// TEKNİK BİLİMLER (B1 = C1a = C4)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = $esik('teknik', 'dr_ogr_uyesi', $TEKNIK, null,
    'Mühendislik, fen ve ziraat gibi teknik bilimler alanı',
    [$doktora, $dil],
    [
        Kalip::adet('SCI veya SCI-Expanded kapsamındaki dergilerde en az 1 araştırma makaleniz olmalı', ['SCI-MAKALE'], 1, madde: 'I/B1-1'),
        Kalip::adet('Toplam en az 2 araştırma makaleniz olmalı', ['TUM-MAKALE'], 2, madde: 'I/B1-1'),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            $yurtdisi,
            Kalip::adet('En az 1 devam eden ya da tamamlanmış projede araştırmacı olmak', ['PROJE-A'], 1, madde: 'I/B1-2b'),
            Kalip::toplam(75, null, $T1A2, $LISTE),
        ]),
    ],
    'Bir tanesi SCI veya SCI-Expanded kapsamında olmak üzere en az 2 araştırma makalesi ve üç '
    .'seçenekten biri isteniyor.',
    'I/A ve I/B1 (=C1a=C4): doktora, YDS 65; SCI/SCI-E\'de 1 olmak üzere 2 araştırma makalesi; '
    .'yurt dışı deneyimi, proje araştırmacılığı ya da bilimsel yayın ve akademik '
    .'faaliyet kalemlerinden 75 puan.');

$esikler[] = $esik('teknik', 'docentlik', $TEKNIK, null,
    'Mühendislik, fen ve ziraat gibi teknik bilimler alanı',
    [$docentUnvani, $dil, $docentSozlu],
    [
        Kalip::veya('Tez danışmanlığı ya da ek puan koşulu', [
            $tezKosulu(2, 1, null, 'II/B1-2a'),
            Kalip::toplam(300, null, $T1A2, $LISTE),
        ]),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            $yurtdisi,
            $projeKosulu('II/B1-3b'),
            Kalip::toplam(500, null, $T1A2, $LISTE),
        ]),
        Kalip::toplam(250, null, $T1A2, $LISTE),
    ],
    'Bilimsel yayın ve akademik faaliyet kalemlerinizden toplam en az 250 puan, tez '
    .'danışmanlığı ya da %20 fazla puan, '
    .'ayrıca yurt dışı deneyimi, proje ya da ek 250 puan isteniyor.'.$HATA_NOTU,
    'II/A ve II/B1 (=C1a=C4): doçent unvanı, YDS 65, ÜAK sözlü sınavı; Tablo 1a+2\'den 250 puan; '
    .'2 yüksek lisans veya 1 doktora tezi ya da %20 fazla puan; yurt dışı deneyimi, proje ya da '
    .'ilave 250 puan. Kaynakta "Madde 3\'teki puan şartı" yazıyor, Madde 1\'in puanı esas alındı.');

$esikler[] = $esik('teknik', 'profesorluk', $TEKNIK, null,
    'Mühendislik, fen ve ziraat gibi teknik bilimler alanı',
    $profesorOn,
    [
        $projeKosulu('III/B1-1'),
        Kalip::veya('Tez danışmanlığı ya da ek puan koşulu', [
            $tezKosulu(3, 1, $DOCENTLIK, 'III/B1-3'),
            Kalip::toplam(420, $DOCENTLIK, $T1A2, $LISTE),
        ]),
        Kalip::toplam(350, $DOCENTLIK, $T1A2, $LISTE),
    ],
    'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. Bilimsel yayın ve '
    .'2\'den toplam en az 350 puan, en az bir projede yürütücülük (ya da iki projede '
    .'araştırmacılık) ve tez danışmanlığı ya da %20 fazla puan isteniyor.',
    'III/A ve III/B1 (=C1a=C4): 2 projede araştırmacılık ya da 1 projede yürütücülük; doçentlik '
    .'sonrası Tablo 1a+2\'den 350 puan; 3 yüksek lisans veya 1 doktora tezi ya da %20 fazla puan.');

// ══════════════════════════════════════════════════════════════════════════
// SOSYAL, BEŞERİ VE İDARİ BİLİMLER (B2 = C2)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = $esik('sosyal', 'dr_ogr_uyesi', $SOSYAL, null,
    'Sosyal, beşeri ve idari bilimler alanı',
    [$doktora, $dil],
    [
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            Kalip::ve('En az biri uluslararası indeksli olmak üzere 2 makale', [
                Kalip::adet('Uluslararası indekslerde taranan dergilerde en az 1 makale', ['ULUSLARARASI-MAKALE'], 1, madde: 'I/B2-a'),
                Kalip::adet('Toplam en az 2 makale', ['TUM-MAKALE'], 2, madde: 'I/B2-a'),
            ]),
            Kalip::ve('Ya da yurt dışı deneyimi ve 50 puan', [
                $yurtdisi,
                Kalip::toplam(50, null, $T1A2, $LISTE),
            ]),
            Kalip::ve('Ya da alan indeksli 2 makale ve 50 puan', [
                Kalip::adet('Alan indekslerinde taranan dergilerde en az 2 makale', ['ALAN-INDEKS-MAKALE'], 2, madde: 'I/B2-c'),
                Kalip::toplam(50, null, $T1A2, $LISTE),
            ]),
        ]),
    ],
    'Üç seçenekten biri isteniyor: iki makale (biri uluslararası indeksli), yurt dışı deneyimi + '
    .'50 puan ya da alan indeksli iki makale + 50 puan.',
    'I/A ve I/B2 (=C2): doktora, YDS 65; a, b veya c şıklarından biri.');

$esikler[] = $esik('sosyal', 'docentlik', $SOSYAL, null,
    'Sosyal, beşeri ve idari bilimler alanı',
    [$docentUnvani, $dil, $docentSozlu],
    [
        Kalip::veya('Yurt dışı deneyimi ya da ek puan koşulu', [
            $yurtdisi,
            Kalip::toplam(50, null, $T1A2, $LISTE),
        ]),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            $projeKosulu('II/B2-3a'),
            $tekYazarliKitap(null, 'II/B2-3b'),
            Kalip::toplam(225, null, $T1A2, $LISTE),
        ]),
        Kalip::toplam(150, null, $T1A2, $LISTE),
    ],
    'Bilimsel yayın ve akademik faaliyet kalemlerinizden toplam en az 150 puan, yurt dışı '
    .'deneyimi ya da 50 puan, ayrıca '
    .'proje, tek yazarlı kitap ya da ilave 75 puan isteniyor.',
    'II/A ve II/B2 (=C2): doçent unvanı, YDS 65, ÜAK sözlü sınavı; Tablo 1a+2\'den 150 puan; yurt '
    .'dışı deneyimi ya da 50 puan; proje, tek yazarlı kitap ya da ilave 75 puan.');

$esikler[] = $esik('sosyal', 'profesorluk', $SOSYAL, null,
    'Sosyal, beşeri ve idari bilimler alanı',
    $profesorOn,
    [
        Kalip::beyan(
            'Özgün makale ya da kitap aranmayan alanlarda, başlıca yazar olduğunuz özgün bir '
            .'araştırma makalesini veya bir kitabı başlıca eser olarak sunmak',
            'III/B2-1',
        ),
        Kalip::veya('Tez danışmanlığı ya da ek puan koşulu', [
            $tezKosulu(3, 1, $DOCENTLIK, 'III/B2-3a'),
            Kalip::toplam(240, $DOCENTLIK, $T1A2, $LISTE),
        ]),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            $yurtdisi,
            $projeKosulu('III/B2-4b'),
            $tekYazarliKitap($DOCENTLIK, 'III/B2-4c'),
            Kalip::toplam(250, $DOCENTLIK, $T1A2, $LISTE),
        ]),
        Kalip::toplam(200, $DOCENTLIK, $T1A2, $LISTE),
    ],
    'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. Bilimsel yayın ve '
    .'2\'den toplam en az 200 puan, tez danışmanlığı ya da %20 fazla puan ve dört seçenekten biri '
    .'isteniyor.',
    'III/A ve III/B2 (=C2): başlıca eser sunumu; doçentlik sonrası Tablo 1a+2\'den 200 puan; '
    .'3 yüksek lisans veya 1 doktora tezi ya da %20 fazla puan; yurt dışı, proje, tek yazarlı '
    .'kitap ya da ilave 50 puan.');

// ══════════════════════════════════════════════════════════════════════════
// SAĞLIK BİLİMLERİ (B3 = C3)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = $esik('saglik', 'dr_ogr_uyesi', $SAGLIK, null, 'Sağlık bilimleri alanı',
    [$doktora, $dil],
    [
        Kalip::adet('SSCI, SCI veya SCI-Expanded kapsamındaki dergilerde en az 1 araştırma makaleniz olmalı', ['SCI-MAKALE'], 1, madde: 'I/B3-1'),
        Kalip::adet('Toplam en az 3 araştırma makaleniz olmalı', ['TUM-MAKALE'], 3, madde: 'I/B3-1'),
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            $yurtdisi,
            Kalip::adet('En az 1 projede yürütücü ya da yardımcı araştırmacı olmak', ['PROJE-Y', 'PROJE-A'], 1, madde: 'I/B3-2b'),
            Kalip::adet('Ya da SSCI, SCI veya SCI-Expanded dergilerinde başlıca yazar olduğunuz 1 araştırma makalesi daha', ['SCI-MAKALE'], 2, yazar: 'baslica', madde: 'I/B3-2c'),
            Kalip::toplam(75, null, $T1A2, $LISTE),
        ]),
    ],
    'Bir tanesi SSCI, SCI veya SCI-Expanded kapsamında olmak üzere en az 3 araştırma makalesi ve '
    .'dört seçenekten biri isteniyor.',
    'I/A ve I/B3 (=C3): doktora, YDS 65; SCI\'de 1 olmak üzere 3 araştırma makalesi; yurt dışı, '
    .'proje, ilave SCI makalesi ya da bilimsel yayın ve akademik faaliyet kalemlerinden '
    .'75 puan.');

$esikler[] = $esik('saglik', 'docentlik', $SAGLIK, null, 'Sağlık bilimleri alanı',
    [$docentUnvani, $dil, $docentSozlu],
    [
        Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
            $yurtdisi,
            $projeKosulu('II/B3-2b'),
            $tekYazarliKitap(null, 'II/B3-2c'),
            Kalip::toplam(500, null, $T1A2, $LISTE),
        ]),
        Kalip::toplam(250, null, $T1A2, $LISTE),
    ],
    'Bilimsel yayın ve akademik faaliyet kalemlerinizden toplam en az 250 puan ve dört '
    .'seçenekten biri isteniyor.'.$HATA_NOTU,
    'II/A ve II/B3 (=C3): doçent unvanı, YDS 65, ÜAK sözlü sınavı; Tablo 1a+2\'den 250 puan; yurt '
    .'dışı, proje, tek yazarlı kitap ya da ilave 250 puan.');

$esikler[] = $esik('saglik', 'profesorluk', $SAGLIK, null, 'Sağlık bilimleri alanı',
    $profesorOn,
    [
        Kalip::kIle('Aşağıdaki şartlardan en az 3 tanesini sağlamalısınız', 3, [
            $yurtdisi,
            $tekYazarliKitap($DOCENTLIK, 'III/B3-2b'),
            Kalip::ve('En az birinde başlıca yazar olmak üzere 2 SCI makalesi', [
                Kalip::adet('SSCI, AHCI, SCI veya SCI-Expanded dergilerinde en az 2 araştırma makalesi', ['SCI-MAKALE'], 2, donem: $DOCENTLIK, madde: 'III/B3-2c'),
                Kalip::adet('Bunlardan en az 1 tanesinde başlıca yazar olmalısınız', ['SCI-MAKALE'], 1, yazar: 'baslica', donem: $DOCENTLIK, madde: 'III/B3-2c'),
            ]),
            $projeKosulu('III/B3-2d'),
            Kalip::toplam(600, $DOCENTLIK, $T1A2, $LISTE),
        ]),
        Kalip::toplam(300, $DOCENTLIK, $T1A2, $LISTE),
    ],
    'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. Bilimsel yayın ve '
    .'2\'den toplam en az 300 puan ve beş şarttan en az üçü isteniyor.',
    'III/A ve III/B3 (=C3): doçentlik sonrası Tablo 1a+2\'den 300 puan ve a-e şıklarından en az üçü.');

// ══════════════════════════════════════════════════════════════════════════
// MİMARLIK, PLANLAMA, TASARIM VE GÜZEL SANATLAR (B4 ↔ C1b)
// ══════════════════════════════════════════════════════════════════════════

$sanatDrKosulu = Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
    Kalip::adet('AHCI, SSCI, SCI veya SCI-Expanded kapsamındaki dergilerde en az 1 araştırma makalesi', ['SCI-MAKALE'], 1, madde: 'I/B4-a'),
    Kalip::adet('Ya da diğer indekslerce taranan dergilerde en az 2 araştırma makalesi', ['ALAN-INDEKS-MAKALE'], 2, madde: 'I/B4-b'),
    Kalip::adet('Ya da hakemli dergilerde en az 3 araştırma makalesi', ['TUM-MAKALE'], 3, madde: 'I/B4-c'),
]);

$sanatDocentEk = Kalip::veya('Aşağıdaki şartlardan en az birini sağlamalısınız', [
    $projeKosulu('II/B4-3a'),
    Kalip::adet('Tek yazarlı ulusal ya da uluslararası bilimsel bir kitap yayımlamış olmak', ['KITAP-TEK'], 1, yazar: 'tek', madde: 'II/B4-3b'),
    Kalip::adet('Başlıca yazar olarak SSCI, AHCI, SCI veya SCI-Expanded dergilerinde 1 araştırma makalesi', ['SCI-MAKALE'], 1, yazar: 'baslica', madde: 'II/B4-3c'),
    Kalip::adet('Ya da diğer indekslere giren dergilerde başlıca yazar olarak 2 araştırma makalesi', ['ALAN-INDEKS-MAKALE'], 2, yazar: 'baslica', madde: 'II/B4-3c'),
    $yurtdisi,
    Kalip::adet('Resmî kurumdan onaylı mimari, planlama ya da restorasyon projesinde yürütücü veya ekip üyesi olmak', ['MIMARI-PROJE'], 1, madde: 'II/B4-3e'),
    Kalip::adet('Ulusal ya da uluslararası proje yarışmasında ilk üç dereceye giren bir ödül almış olmak', ['YARISMA-ODUL'], 1, madde: 'II/B4-3f'),
]);

foreach ([
    ['sanat-myo', 'Meslek yüksekokulları', 'B4'],
    ['sanat-fak', 'Mühendislik, Mimarlık ve Tasarım Fakültesi', 'C1b'],
] as [$anahtar, $birim, $kod]) {
    $setAdi = "Mimarlık, planlama, tasarım ve güzel sanatlar alanı ({$birim})";

    $esikler[] = $esik($anahtar, 'dr_ogr_uyesi', $SANAT, $birim, $setAdi,
        [$doktora, $dil], [$sanatDrKosulu],
        'Üç seçenekten biri isteniyor: SCI kapsamında 1, diğer indekslerde 2 ya da hakemli '
        .'dergilerde 3 araştırma makalesi.',
        "I/A ve I/{$kod}: doktora, YDS 65; a, b veya c şıklarından biri.");

    $esikler[] = $esik($anahtar, 'docentlik', $SANAT, $birim, $setAdi,
        [$docentUnvani, $dil, $docentSozlu],
        [
            Kalip::puanDan('Bilimsel yayın ve sanatsal etkinlik kalemlerinizden en az 100 puan', ['T1A-T1B'], 100, madde: "II/{$kod}-1"),
            Kalip::puanDan('Akademik faaliyet kalemlerinizden en az 50 puan', ['T2'], 50, madde: "II/{$kod}-1"),
            Kalip::veya('Tez danışmanlığı ya da ek puan koşulu', [
                $tezKosulu(2, 1, null, "II/{$kod}-2a"),
                Kalip::toplam(180, null, ['T1A', 'T1B', 'T2'], 'Bilimsel yayın, sanatsal etkinlik ve akademik faaliyet'),
            ]),
            $sanatDocentEk,
            Kalip::toplam(150, null, ['T1A', 'T1B', 'T2'], 'Bilimsel yayın, sanatsal etkinlik ve akademik faaliyet'),
        ],
        'Bilimsel yayın ve sanatsal etkinlik kalemlerinizden en az 100, akademik faaliyet '
        .'kalemlerinizden en az 50 olmak üzere toplam 150 puan; tez '
        .'danışmanlığı ya da %20 fazla puan; ayrıca altı seçenekten biri isteniyor.',
        "II/A ve II/{$kod}: doçent unvanı, YDS 65, ÜAK sözlü sınavı; Tablo 1a+1b'den 100, Tablo "
        ."2'den 50, toplam 150 puan; tez danışmanlığı ya da %20 fazla; a-f şıklarından biri.");

    $profesorKosullari = [
        Kalip::puanDan('Doçentlik sonrası bilimsel yayın ve sanatsal etkinlik kalemlerinizden en az 200 puan', ['T1A-T1B'], 200, $DOCENTLIK, madde: "III/{$kod}-1"),
        Kalip::puanDan('Doçentlik sonrası akademik faaliyet kalemlerinizden en az 50 puan', ['T2'], 50, $DOCENTLIK, madde: "III/{$kod}-1"),
        Kalip::veya('Tez danışmanlığı ya da ek puan koşulu', [
            $tezKosulu(3, 1, $DOCENTLIK, "III/{$kod}-2a"),
            Kalip::toplam(300, $DOCENTLIK, ['T1A', 'T1B', 'T2'], 'Bilimsel yayın, sanatsal etkinlik ve akademik faaliyet'),
        ]),
    ];

    if ($kod === 'C1b') {
        $profesorKosullari[] = $sanatDocentEk;
    }

    $profesorKosullari[] = Kalip::toplam(250, $DOCENTLIK, ['T1A', 'T1B', 'T2'], 'Bilimsel yayın, sanatsal etkinlik ve akademik faaliyet');

    $esikler[] = $esik($anahtar, 'profesorluk', $SANAT, $birim, $setAdi, $profesorOn,
        $profesorKosullari,
        'Doçent unvanınızı aldığınız tarihten sonraki çalışmalarınız sayılıyor. Bilimsel '
        .'yayın ve sanatsal etkinlik kalemlerinizden en az 200, akademik faaliyet '
        .'kalemlerinizden en az 50 olmak üzere toplam 250 puan ve tez danışmanlığı '
        .'ya da %20 fazla puan isteniyor.'
        .($kod === 'C1b' ? ' Fakülte adaylarında ayrıca altı seçenekten biri aranıyor.' : ''),
        "III/A ve III/{$kod}: doçentlik sonrası Tablo 1a+1b'den 200, Tablo 2'den 50, toplam 250 "
        .'puan; 3 yüksek lisans veya 1 doktora tezi ya da %20 fazla puan'
        .($kod === 'C1b' ? '; ayrıca a-f şıklarından biri.' : '.'));
}

return $esikler;
