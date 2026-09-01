<?php

/**
 * ERZURUM TEKNİK ÜNİVERSİTESİ — Öğretim Üyeliğine Atama ve Yükseltme
 * Kriterleri
 * Kaynak: pdf/17536993662.erzurumteknikuniversitesi.pdf (20 sayfa,
 * yürürlük 01.01.2024)
 *
 * ── YAPI: FAKÜLTE BAŞINA DÖRT SÜTUNLU ZORUNLU KOŞUL TABLOSU ──
 * Yedi akademik birimin her biri için "Zorunlu Başvuru Koşulları" tablosu
 * var; sütunlar Profesör · Doçent · Dr. Öğr. Üyesi · Dr. Öğr. Üyesi
 * (Yeniden Atama). Koşullar EK'teki HARF GRUPLARINA atıf yapıyor
 * ("A grubu etkinlik türünden toplamda en az 40 puan", "G grubu
 * etkinliklerinden en fazla 10 puan alınabilir"), bu yüzden cetvelde harf
 * grupları birebir tanımlandı.
 *
 * Birimler ve temel alan eşlemesi:
 *   Edebiyat Fakültesi                 → sosyal, filoloji
 *   Fen Fakültesi                      → fen (Matematik ↔ diğer alanlar)
 *   İktisadi ve İdari Bilimler Fak.    → sosyal
 *   Mühendislik ve Mimarlık Fakültesi  → muhendislik, mimarlik
 *   Sağlık Bilimleri Fakültesi         → saglik
 *   Spor Bilimleri Fakültesi           → spor
 *   Yabancı Diller Yüksekokulu         → filoloji
 *
 * `sosyal` ve `filoloji` temel alanlarında ikişer birim buluştuğu için HER
 * eşik `birim` taşıyor; Fen ile Mühendislik-Mimarlık tabloları ayrıca kendi
 * içinde ikiye ayrıldığından (Matematik ↔ diğer; Mimarlık-İç Mimarlık-ŞBP ↔
 * diğer mühendislikler) o ayrım da birim adına yazıldı.
 *
 * ── PUAN BARAJLARI BİRİME GÖRE DEĞİŞİYOR ──
 *   Profesör: Edebiyat 400 · Fen (Matematik 400, diğer 500) · İİBF 400 ·
 *       Müh-Mim (mimarlık 350, diğer 500) · Sağlık 500 · Spor 450 ·
 *       Yabancı Diller 300
 *   Doçent: Fen (Matematik 250, diğer 300) ve Müh-Mim (mimarlık 200, diğer
 *       300) dışında hepsinde 250
 *   Dr. ilk atanma: Fen (Matematik 75, diğer 100) ve Müh-Mim (mimarlık 75,
 *       diğer 100) dışında hepsinde 100
 *   Dr. yeniden atanma: Fen (Matematik 100, diğer 125), Müh-Mim 125,
 *       Sağlık 125; kalanlarda 100
 *
 * ── "EN FAZLA N PUAN ALINABİLİR" SINIRLARI KOŞUL DEĞİL, TAVAN ──
 * Tabloların çoğu bir grubun hem alt barajını hem üst sınırını yazıyor
 * ("G grubu etkinliklerinden en az 10 puan almış olmak. Bu gruptan en fazla
 * 20 puan alınabilir."). Alt baraj `Kalip::puanDan` ile yazıldı. ÜST SINIR
 * kadroya göre değişiyor ve `grup_tavanlari` cetvel geneline uygulanıyor;
 * Tavanlar (BİRİM × KADRO) matrisi olarak cetvele yazıldı; cetvel bu yüzden
 * otuz altı varyant üretiyor. Eğitim (H) ve kurumsal katkı (K) tavanı yedi
 * fakültede de aynı, yalnız kadroya göre değişiyor (H: profesörlükte 150,
 * doçentlikte 40, yeniden atanmada 30); atıf (G) hem birime hem kadroya bağlı
 * (20 ile 100 arasında).
 *
 * İLK DENEMEDE "EN SIKI DEĞERİ YAZ" KISAYOLU KULLANILDI VE YANLIŞTI: G'ye
 * genel 20 yazılınca profesörlük eşikleri sağlanamaz hâle geldi, çünkü Fen ve
 * Sağlık profesörlüğünde G barajının KENDİSİ 50. `CetvelKaynakTest`'in
 * tavan-baraj kontrolü yakaladı. Doğru yol matrisi okumaktı; `pdftotext`
 * sütunları iç içe verdiği ve parantez içindeki tavanları atladığı için yedi
 * fakülte sayfası 170 dpi görüntüye çevrilip gözle okundu.
 *
 * Dr. Öğr. Üyesi ilk atanmada bazı birimlerde G grubu için YALNIZCA üst
 * sınır var ("G grubu etkinliklerinden en fazla 10/20 puan alınabilir"),
 * alt baraj yok; o kadrolarda G için hiç düğüm yazılmadı.
 *
 * ── H (EĞİTİM) KOŞULUNUN KENDİ İSTİSNASI ──
 * Genel ilkeler: "Eğitim Etkinlikleri şartı, öğretim üyesinin bulunduğu ana
 * bilim dalında yüksek lisans programları için en az 3 yıl, doktora
 * programları için en az 5 yıl bulunmuş olmak kaydıyla aranır." Ayrıca
 * profesörlükte "lisansüstü programı bulunmayan birimlerdeki adaylar için H
 * grubundan 60 puan" gibi istisnalar var. Programın açık olup olmadığı ve
 * adayın anabilim dalındaki süresi profilde yok; H barajları İSTİSNASIZ
 * yazıldı ve aday notunda uyarıldı — lisansüstü programı olmayan birimin
 * adayı olduğundan zor bir eşik görür.
 *
 * ── KURUMSAL KATKI (K) ŞARTI HERKESE UYGULANMIYOR ──
 * Genel ilkeler: "Atamalarda puanlamaya esas olan Kurumsal Katkı
 * Etkinlikleri, Erzurum Teknik Üniversitesi personeli olmayan başvuru
 * sahipleri için zorunlu şart olarak aranmaz." Adayın ETÜ personeli olup
 * olmadığı profilde yok; K barajları yazıldı ve aday notunda dışarıdan
 * başvuranlar için aranmadığı söylendi.
 *
 * ── YABANCI DİLLER YÜKSEKOKULUNUN AYRI DİL BARAJI ──
 * Genel ilkeler bu yüksekokul için ayrı bir eşik veriyor: doktor öğretim
 * üyeliğinde 85, doçentlik ve profesörlükte 90. Yüksekokulun kendi eşikleri
 * bu değerlerle yazıldı; kalan altı birimde genel şart (Dr. 60, doçent 65)
 * geçerli.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   Profesörlükte YDS şartı genel ilkelerde ANILMIYOR (yalnızca doktor
 *       öğretim üyeliği 60 ve doçentlik 65 için); kaynağa sadık kalınarak
 *       profesörlüğe dil düğümü yazılmadı.
 *   "Öğretim üyesi temininde güçlük çekilen alanlarda Üniversite Yönetim
 *       Kurulu kararıyla atama" istisnası — idari takdir.
 *   Yeniden atanma kriterlerini sağlayamayana verilen iki yıllık ek süre —
 *       süreç kuralı.
 *   Öğretim üyesi dışındaki öğretim elemanlarının yeniden atanması
 *       (araştırma görevlisi ve öğretim görevlisi) — bu korpus yalnızca
 *       öğretim üyesi kadrolarını kapsıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/erzurum-teknik-2024.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'erzurum-teknik-2024';
$UNIVERSITE = 'Erzurum Teknik Üniversitesi';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$UYARI = ' Yönergenin "bu gruptan en fazla N puan alınabilir" üst sınırları uygulanıyor: '
    .'eğitim, kurumsal katkı ve atıf tavanları birim ve kadronuza göre ayrı ayrı yazıldı. Eğitim (H) barajı yönergede lisansüstü programı olmayan '
    .'birimler için hafifletiliyor, kurumsal katkı (K) barajı ise üniversite dışından '
    .'başvuranlarda hiç aranmıyor; ikisi de profilden okunamadığı için burada istisnasız '
    .'uygulanıyor.';

$esikler = [];

/**
 * Bir birimin dört kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  array<string, list<array<string, mixed>>>  $kosullar  kadro → düğümler
 * @param  array<string, int>  $toplamlar  kadro → toplam puan barajı
 */
$birimEsikleri = function (
    string $anahtar, array $alanlar, string $birim, array $kosullar, array $toplamlar,
    int $ydsDr, int $ydsDocent, string $notOn,
) use ($UNIVERSITE, $CETVEL, $DOKTORA, $DOCENTLIK, $SON_ATAMA, $UYARI): array {
    $cerceve = [
        'dr_ogr_uyesi' => [
            'ad' => 'Doktor Öğretim Üyesi kadrosuna atanma',
            'donem' => null,
            'on' => [
                Kalip::yds($ydsDr),
                Kalip::beyan('Doktora derecesine sahip olmak', 'Genel İlkeler'),
            ],
        ],
        'dr_ogr_uyesi_yeniden' => [
            'ad' => 'Doktor Öğretim Üyeliğine yeniden atanma',
            'donem' => $SON_ATAMA,
            'on' => [],
        ],
        'docentlik' => [
            'ad' => 'Doçent kadrosuna atanma',
            'donem' => $DOKTORA,
            'on' => [
                Kalip::yds($ydsDocent),
                Kalip::beyan('Üniversitelerarası Kurul tarafından verilen doçentlik unvanına sahip olmak', 'Genel İlkeler'),
            ],
        ],
        'profesorluk' => [
            'ad' => 'Profesör kadrosuna atanma',
            'donem' => $DOCENTLIK,
            'on' => [
                Kalip::beyan('Doçentlik unvanına sahip olmak', 'Genel İlkeler'),
            ],
        ],
    ];

    $uretilen = [];

    foreach ($cerceve as $kadro => $c) {
        $donemMetni = match ($kadro) {
            'dr_ogr_uyesi_yeniden' => 'Bir önceki atama tarihinizden itibaren yaptığınız çalışmalar sayılıyor. ',
            'docentlik' => 'Doktora eğitiminizi tamamladığınız tarihten doçent kadrosuna başvurduğunuz tarihe kadar geçen süredeki çalışmalarınız sayılıyor. ',
            'profesorluk' => 'Doçent unvanınızı aldığınız tarihten profesör kadrosuna başvurduğunuz tarihe kadar geçen süredeki çalışmalarınız sayılıyor. ',
            default => '',
        };

        $uretilen[] = [
            'anahtar' => "erzurum-teknik-{$anahtar}-".str_replace('_', '-', $kadro),
            'aday_notu' => $donemMetni."{$birim} için toplamda en az {$toplamlar[$kadro]} puan "
                .'ve aşağıdaki grup barajlarının tamamı gerekiyor.'.$UYARI,
            'universite' => $UNIVERSITE,
            'kadro' => $kadro,
            'alan' => $alanlar,
            'birim' => $birim,
            // Tavanlar (birim × kadro) değiştiği için cetvel varyantlanıyor.
            // Edebiyat iki eşik grubuna bölünmüş (sosyal ve filoloji) ama
            // kaynakta tek fakülte sayfası; ikisi de aynı varyanta bağlanıyor.
            'cetvel' => $CETVEL.'-'
                .(str_starts_with($anahtar, 'edebiyat') ? 'edebiyat' : $anahtar)
                ."-{$kadro}",
            'notlar' => "{$notOn} ({$birim}): toplam {$toplamlar[$kadro]} puan.",
            'sart' => Kalip::ve("{$c['ad']} — {$birim}", array_values(array_merge(
                $c['on'],
                $kosullar[$kadro],
                [Kalip::toplam($toplamlar[$kadro], $c['donem'])],
            ))),
        ];
    }

    return $uretilen;
};

$A = 'Makale kalemlerinizden';
$B = 'Kongre kalemlerinizden';
$C = 'Kitap kalemlerinizden';
$E = 'Araştırma projesi kalemlerinizden';
$EM = 'Araştırma projesi ve girişimcilik kalemlerinizden';
$G = 'Atıf kalemlerinizden';
$H = 'Eğitim kalemlerinizden';
$H1 = 'Doktora tez danışmanlığı kalemlerinizden';
$K = 'Kurumsal katkı kalemlerinizden';

// ══════════════════════════════════════════════════════════════════════════
// EDEBİYAT FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

$edebiyatKosullar = [
    'dr_ogr_uyesi' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 yayınınız olmalı', ['A1-A3'], 1, madde: 'Edebiyat Fak. / Dr'),
        Kalip::puanDan('Makale kalemlerinizden en az 40 puan', ['A'], 40, madde: 'Edebiyat Fak. / Dr'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        Kalip::adet('Son atamanızdan sonra SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Edebiyat Fak. / Dr yeniden'),
        Kalip::puanDan('Makale kalemlerinizden en az 20 puan', ['A'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Edebiyat Fak. / Dr yeniden'),
        Kalip::puanDan('Kongre kalemlerinizden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Edebiyat Fak. / Dr yeniden'),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 10 puan', ['E'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Edebiyat Fak. / Dr yeniden'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 20 puan', ['H'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Edebiyat Fak. / Dr yeniden'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 10 puan', ['K'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Edebiyat Fak. / Dr yeniden'),
    ],
    'docentlik' => [
        Kalip::veya('Makale ya da kitap koşulu', [
            Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Edebiyat Fak. / Doçent'),
            Kalip::puanDan('Kitap kalemlerinizden en az 70 puan', ['C'], 70, Kalip::DOKTORA_SONRASI, madde: 'Edebiyat Fak. / Doçent'),
        ]),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 20 puan', ['E'], 20, Kalip::DOKTORA_SONRASI, madde: 'Edebiyat Fak. / Doçent'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::DOKTORA_SONRASI, madde: 'Edebiyat Fak. / Doçent'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 30 puan', ['H'], 30, Kalip::DOKTORA_SONRASI, madde: 'Edebiyat Fak. / Doçent'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 20 puan', ['K'], 20, Kalip::DOKTORA_SONRASI, madde: 'Edebiyat Fak. / Doçent'),
    ],
    'profesorluk' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 2 makaleniz olmalı', ['A1-A3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
        Kalip::puanDan('Makale kalemlerinizden en az 50 puan', ['A'], 50, Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
        Kalip::puanDan('Kongre kalemlerinizden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
        Kalip::veya('Kitap ya da makale koşulu', [
            Kalip::puanDan('Kitap kalemlerinizden en az 100 puan', ['C'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
            Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 2 makaleniz olmalı', ['A1-A3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
        ]),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 10 puan', ['E'], 10, Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
        Kalip::puanDan('Doktora ve yüksek lisans tez danışmanlığı kalemlerinizden en az 30 puan', ['H1-H2'], 30, Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 100 puan', ['H'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 40 puan', ['K'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'Edebiyat Fak. / Profesör'),
    ],
];

foreach ([['edebiyat-sosyal', ['sosyal']], ['edebiyat-filoloji', ['filoloji']]] as [$ek, $alanlar]) {
    $esikler = array_merge($esikler, $birimEsikleri(
        $ek, $alanlar, 'Edebiyat Fakültesi', $edebiyatKosullar,
        ['dr_ogr_uyesi' => 100, 'dr_ogr_uyesi_yeniden' => 100, 'docentlik' => 250, 'profesorluk' => 400],
        60, 65, 'Edebiyat Fakültesi zorunlu başvuru koşulları',
    ));
}

// ══════════════════════════════════════════════════════════════════════════
// İKTİSADİ VE İDARİ BİLİMLER FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

$iibfKosullar = [
    'dr_ogr_uyesi' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 yayınınız olmalı', ['A1-A3'], 1, madde: 'İİBF / Dr'),
        Kalip::puanDan('Makale kalemlerinizden en az 40 puan', ['A'], 40, madde: 'İİBF / Dr'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        Kalip::adet('Son atamanızdan sonra SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'İİBF / Dr yeniden'),
        Kalip::puanDan('Makale kalemlerinizden en az 20 puan', ['A'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'İİBF / Dr yeniden'),
        Kalip::puanDan('Kongre kalemlerinizden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'İİBF / Dr yeniden'),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 10 puan', ['E'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'İİBF / Dr yeniden'),
        Kalip::puanDan('Atıf kalemlerinizden en az 5 puan', ['G'], 5, Kalip::SON_ATAMA_SONRASI, madde: 'İİBF / Dr yeniden'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 20 puan', ['H'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'İİBF / Dr yeniden'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 10 puan', ['K'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'İİBF / Dr yeniden'),
    ],
    'docentlik' => [
        Kalip::veya('Makale ya da kitap koşulu', [
            Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'İİBF / Doçent'),
            Kalip::puanDan('Kitap kalemlerinizden en az 70 puan', ['C'], 70, Kalip::DOKTORA_SONRASI, madde: 'İİBF / Doçent'),
        ]),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 20 puan', ['E'], 20, Kalip::DOKTORA_SONRASI, madde: 'İİBF / Doçent'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::DOKTORA_SONRASI, madde: 'İİBF / Doçent'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 30 puan', ['H'], 30, Kalip::DOKTORA_SONRASI, madde: 'İİBF / Doçent'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 20 puan', ['K'], 20, Kalip::DOKTORA_SONRASI, madde: 'İİBF / Doçent'),
    ],
    'profesorluk' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 2 makaleniz olmalı', ['A1-A3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
        Kalip::puanDan('Makale kalemlerinizden en az 50 puan', ['A'], 50, Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
        Kalip::puanDan('Kongre kalemlerinizden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
        Kalip::veya('Kitap ya da makale koşulu', [
            Kalip::puanDan('Kitap kalemlerinizden en az 100 puan', ['C'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
            Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 2 makaleniz olmalı', ['A1-A3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
        ]),
        Kalip::puanDan('Araştırma projesi ve girişimcilik kalemlerinizden en az 10 puan', ['E-M'], 10, Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
        Kalip::puanDan('Doktora tez danışmanlığı kalemlerinizden en az 30 puan', ['H1'], 30, Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 100 puan', ['H'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 40 puan', ['K'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'İİBF / Profesör'),
    ],
];

$esikler = array_merge($esikler, $birimEsikleri(
    'iibf', ['sosyal'], 'İktisadi ve İdari Bilimler Fakültesi', $iibfKosullar,
    ['dr_ogr_uyesi' => 100, 'dr_ogr_uyesi_yeniden' => 100, 'docentlik' => 250, 'profesorluk' => 400],
    60, 65, 'İİBF zorunlu başvuru koşulları',
));

// ══════════════════════════════════════════════════════════════════════════
// FEN FAKÜLTESİ (Matematik ve diğer alanlar ayrı)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @return array<string, list<array<string, mixed>>>
 */
$fenKosullar = function (bool $matematik): array {
    $M = $matematik;

    return [
        'dr_ogr_uyesi' => [
            Kalip::adet('SCI-AHCI dergilerinde en az '.($M ? 1 : 2).' yayınınız olmalı', ['A1'], $M ? 1 : 2, madde: 'Fen Fak. / Dr'),
            Kalip::puanDan('Makale kalemlerinizden en az '.($M ? 30 : 50).' puan', [$M ? 'A1-A3' : 'A'], $M ? 30 : 50, madde: 'Fen Fak. / Dr'),
        ],
        'dr_ogr_uyesi_yeniden' => array_values(array_filter([
            Kalip::adet('Son atamanızdan sonra SCI-AHCI dergilerinde en az 1 yayınınız olmalı', ['A1'.($M ? '-A3' : '')], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Fen Fak. / Dr yeniden'),
            Kalip::puanDan('Makale kalemlerinizden en az '.($M ? 30 : 50).' puan', ['A'], $M ? 30 : 50, Kalip::SON_ATAMA_SONRASI, madde: 'Fen Fak. / Dr yeniden'),
            $M
                ? Kalip::veya('Araştırma projesi ya da makale koşulu', [
                    Kalip::puanDan('Araştırma projesi kalemlerinizden en az 20 puan', ['E'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Fen Fak. / Dr yeniden'),
                    Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Fen Fak. / Dr yeniden'),
                ])
                : Kalip::puanDan('Araştırma projesi kalemlerinizden en az 20 puan', ['E'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Fen Fak. / Dr yeniden'),
            Kalip::puanDan('Kongre kalemlerinizden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Fen Fak. / Dr yeniden'),
            Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Fen Fak. / Dr yeniden'),
            Kalip::puanDan('Eğitim kalemlerinizden en az 20 puan', ['H'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Fen Fak. / Dr yeniden'),
            Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 10 puan', ['K'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Fen Fak. / Dr yeniden'),
        ])),
        'docentlik' => [
            Kalip::adet('SCI-AHCI dergilerinde en az 1 makaleniz olmalı', ['A1'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Fen Fak. / Doçent'),
            Kalip::puanDan('Makale kalemlerinizden en az '.($M ? 60 : 100).' puan', ['A'], $M ? 60 : 100, Kalip::DOKTORA_SONRASI, madde: 'Fen Fak. / Doçent'),
            $M
                ? Kalip::veya('Araştırma projesi ya da makale koşulu', [
                    Kalip::puanDan('Araştırma projesi kalemlerinizden en az 30 puan', ['E'], 30, Kalip::DOKTORA_SONRASI, madde: 'Fen Fak. / Doçent'),
                    Kalip::adet('SCI-AHCI dergilerinde en az 1 makaleniz olmalı', ['A1'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Fen Fak. / Doçent'),
                ])
                : Kalip::puanDan('Araştırma projesi ve girişimcilik kalemlerinizden en az 30 puan', ['E-M'], 30, Kalip::DOKTORA_SONRASI, madde: 'Fen Fak. / Doçent'),
            Kalip::puanDan('Atıf kalemlerinizden en az 20 puan', ['G'], 20, Kalip::DOKTORA_SONRASI, madde: 'Fen Fak. / Doçent'),
            Kalip::puanDan('Eğitim kalemlerinizden en az 30 puan', ['H'], 30, Kalip::DOKTORA_SONRASI, madde: 'Fen Fak. / Doçent'),
            Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 20 puan', ['K'], 20, Kalip::DOKTORA_SONRASI, madde: 'Fen Fak. / Doçent'),
        ],
        'profesorluk' => [
            $M
                ? Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 2 makaleniz olmalı (en az biri SCI-AHCI grubunda)', ['A1-A3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör')
                : Kalip::adet('SCI-AHCI dergilerinde en az 3 makaleniz olmalı', ['A1'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
            Kalip::puanDan('Makale kalemlerinizden en az '.($M ? 60 : 100).' puan', ['A'], $M ? 60 : 100, Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
            Kalip::puanDan('Kongre kalemlerinizden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
            $M
                ? Kalip::veya('Araştırma projesi ya da makale koşulu', [
                    Kalip::puanDan('Araştırma projesi kalemlerinizden en az 20 puan', ['E'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
                    Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 2 makaleniz olmalı', ['A1-A3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
                ])
                : Kalip::puanDan('Araştırma projesi ve girişimcilik kalemlerinizden en az 70 puan', ['E-M'], 70, Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
            Kalip::puanDan('Atıf kalemlerinizden en az '.($M ? 20 : 50).' puan', ['G'], $M ? 20 : 50, Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
            Kalip::puanDan('Doktora tez danışmanlığı kalemlerinizden en az 30 puan', ['H1'], 30, Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
            Kalip::puanDan('Eğitim kalemlerinizden en az 100 puan', ['H'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
            Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 40 puan', ['K'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'Fen Fak. / Profesör'),
        ],
    ];
};

$esikler = array_merge($esikler, $birimEsikleri(
    'fen-matematik', ['fen'], 'Fen Fakültesi — Matematik', $fenKosullar(true),
    ['dr_ogr_uyesi' => 75, 'dr_ogr_uyesi_yeniden' => 100, 'docentlik' => 250, 'profesorluk' => 400],
    60, 65, 'Fen Fakültesi zorunlu başvuru koşulları — Matematik alanı',
));

$esikler = array_merge($esikler, $birimEsikleri(
    'fen-diger', ['fen'], 'Fen Fakültesi — diğer alanlar', $fenKosullar(false),
    ['dr_ogr_uyesi' => 100, 'dr_ogr_uyesi_yeniden' => 125, 'docentlik' => 300, 'profesorluk' => 500],
    60, 65, 'Fen Fakültesi zorunlu başvuru koşulları — diğer alanlar',
));

// ══════════════════════════════════════════════════════════════════════════
// MÜHENDİSLİK VE MİMARLIK FAKÜLTESİ (mimarlık grubu ve diğer mühendislikler)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @return array<string, list<array<string, mixed>>>
 */
$muhKosullar = function (bool $mimarlik): array {
    $M = $mimarlik;

    return [
        'dr_ogr_uyesi' => array_values(array_filter([
            $M ? null : Kalip::adet('SCI-AHCI dergilerinde en az 2 yayınınız olmalı', ['A1'], 2, madde: 'Müh-Mim Fak. / Dr'),
            Kalip::puanDan('Makale kalemlerinizden en az '.($M ? 20 : 50).' puan', ['A'], $M ? 20 : 50, madde: 'Müh-Mim Fak. / Dr'),
        ])),
        'dr_ogr_uyesi_yeniden' => array_values(array_filter([
            $M ? null : Kalip::adet('Son atamanızdan sonra SCI-AHCI dergilerinde en az 1 yayınınız olmalı', ['A1'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Müh-Mim Fak. / Dr yeniden'),
            Kalip::puanDan('Makale kalemlerinizden en az '.($M ? 20 : 50).' puan', ['A'], $M ? 20 : 50, Kalip::SON_ATAMA_SONRASI, madde: 'Müh-Mim Fak. / Dr yeniden'),
            Kalip::puanDan('Kongre kalemlerinizden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Müh-Mim Fak. / Dr yeniden'),
            Kalip::puanDan('Araştırma projesi kalemlerinizden en az 20 puan', ['E'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Müh-Mim Fak. / Dr yeniden'),
            $M ? null : Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Müh-Mim Fak. / Dr yeniden'),
            Kalip::puanDan('Eğitim kalemlerinizden en az 20 puan', ['H'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Müh-Mim Fak. / Dr yeniden'),
            Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 10 puan', ['K'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Müh-Mim Fak. / Dr yeniden'),
        ])),
        'docentlik' => array_values(array_filter([
            $M
                ? Kalip::puanDan('Makale kalemlerinizden en az 40 puan', ['A'], 40, Kalip::DOKTORA_SONRASI, madde: 'Müh-Mim Fak. / Doçent')
                : Kalip::adet('SCI-AHCI dergilerinde en az 1 yayınınız olmalı', ['A1'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Müh-Mim Fak. / Doçent'),
            $M ? null : Kalip::puanDan('Makale kalemlerinizden en az 100 puan', ['A'], 100, Kalip::DOKTORA_SONRASI, madde: 'Müh-Mim Fak. / Doçent'),
            Kalip::puanDan('Araştırma projesi ve girişimcilik kalemlerinizden en az 30 puan', ['E-M'], 30, Kalip::DOKTORA_SONRASI, madde: 'Müh-Mim Fak. / Doçent'),
            Kalip::puanDan('Atıf kalemlerinizden en az 20 puan', ['G'], 20, Kalip::DOKTORA_SONRASI, madde: 'Müh-Mim Fak. / Doçent'),
            Kalip::puanDan('Eğitim kalemlerinizden en az 30 puan', ['H'], 30, Kalip::DOKTORA_SONRASI, madde: 'Müh-Mim Fak. / Doçent'),
            Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 20 puan', ['K'], 20, Kalip::DOKTORA_SONRASI, madde: 'Müh-Mim Fak. / Doçent'),
        ])),
        'profesorluk' => array_values(array_filter([
            $M
                ? Kalip::puanDan('Makale kalemlerinizden en az 40 puan', ['A'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör')
                : Kalip::adet('SCI-AHCI dergilerinde en az 3 makaleniz olmalı', ['A1'], 3, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör'),
            $M
                ? Kalip::puanDan('Tasarım ve sanat kalemlerinizden en az 50 puan', ['D'], 50, Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör')
                : Kalip::puanDan('Makale kalemlerinizden en az 100 puan', ['A'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör'),
            Kalip::puanDan('Kongre kalemlerinizden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör'),
            $M ? null : Kalip::puanDan('Araştırma projesi ve girişimcilik kalemlerinizden en az 70 puan', ['E-M'], 70, Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör'),
            $M ? null : Kalip::puanDan('Atıf kalemlerinizden en az 50 puan', ['G'], 50, Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör'),
            Kalip::puanDan('Doktora tez danışmanlığı kalemlerinizden en az 30 puan', ['H1'], 30, Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör'),
            Kalip::puanDan('Eğitim kalemlerinizden en az 100 puan', ['H'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör'),
            Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 40 puan', ['K'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'Müh-Mim Fak. / Profesör'),
        ])),
    ];
};

$esikler = array_merge($esikler, $birimEsikleri(
    'mimarlik', ['mimarlik'], 'Mimarlık, İç Mimarlık ile Şehir ve Bölge Planlama', $muhKosullar(true),
    ['dr_ogr_uyesi' => 75, 'dr_ogr_uyesi_yeniden' => 125, 'docentlik' => 200, 'profesorluk' => 350],
    60, 65, 'Mühendislik ve Mimarlık Fakültesi zorunlu başvuru koşulları — mimarlık grubu',
));

$esikler = array_merge($esikler, $birimEsikleri(
    'muhendislik', ['muhendislik'], 'Mühendislik ve Mimarlık Fakültesi — mühendislik alanları', $muhKosullar(false),
    ['dr_ogr_uyesi' => 100, 'dr_ogr_uyesi_yeniden' => 125, 'docentlik' => 300, 'profesorluk' => 500],
    60, 65, 'Mühendislik ve Mimarlık Fakültesi zorunlu başvuru koşulları — mühendislik alanları',
));

// ══════════════════════════════════════════════════════════════════════════
// SAĞLIK BİLİMLERİ FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

$saglikKosullar = [
    'dr_ogr_uyesi' => [
        Kalip::adet('SCI-AHCI dergilerinde en az 1 yayınınız olmalı', ['A1'], 1, madde: 'Sağlık Bil. Fak. / Dr'),
        Kalip::puanDan('SCI-AHCI ve alan indeksli dergi kalemlerinizden en az 40 puan', ['A1-A3'], 40, madde: 'Sağlık Bil. Fak. / Dr'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        Kalip::adet('Son atamanızdan sonra SCI-AHCI dergilerinde en az 1 yayınınız olmalı', ['A1'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Sağlık Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Makale kalemlerinizden en az 30 puan', ['A'], 30, Kalip::SON_ATAMA_SONRASI, madde: 'Sağlık Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Kongre kalemlerinizden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Sağlık Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 20 puan', ['E'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Sağlık Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Sağlık Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 10 puan', ['K'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Sağlık Bil. Fak. / Dr yeniden'),
    ],
    'docentlik' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Sağlık Bil. Fak. / Doçent'),
        Kalip::puanDan('Makale kalemlerinizden en az 60 puan', ['A'], 60, Kalip::DOKTORA_SONRASI, madde: 'Sağlık Bil. Fak. / Doçent'),
        Kalip::puanDan('Araştırma projesi ve girişimcilik kalemlerinizden en az 20 puan', ['E-M'], 20, Kalip::DOKTORA_SONRASI, madde: 'Sağlık Bil. Fak. / Doçent'),
        Kalip::puanDan('Atıf kalemlerinizden en az 20 puan', ['G'], 20, Kalip::DOKTORA_SONRASI, madde: 'Sağlık Bil. Fak. / Doçent'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 30 puan', ['H'], 30, Kalip::DOKTORA_SONRASI, madde: 'Sağlık Bil. Fak. / Doçent'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 20 puan', ['K'], 20, Kalip::DOKTORA_SONRASI, madde: 'Sağlık Bil. Fak. / Doçent'),
    ],
    'profesorluk' => [
        Kalip::adet('SCI-AHCI dergilerinde en az 2 makaleniz olmalı', ['A1'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
        Kalip::puanDan('Makale kalemlerinizden en az 80 puan', ['A'], 80, Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
        Kalip::puanDan('Kongre kalemlerinizden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
        Kalip::veya('Kitap ya da makale koşulu', [
            Kalip::puanDan('Kitap kalemlerinizden en az 50 puan', ['C'], 50, Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
            Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
        ]),
        Kalip::puanDan('Araştırma projesi ve girişimcilik kalemlerinizden en az 20 puan', ['E-M'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
        Kalip::puanDan('Atıf kalemlerinizden en az 50 puan', ['G'], 50, Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
        Kalip::puanDan('Doktora tez danışmanlığı kalemlerinizden en az 30 puan', ['H1'], 30, Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 100 puan', ['H'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 40 puan', ['K'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'Sağlık Bil. Fak. / Profesör'),
    ],
];

$esikler = array_merge($esikler, $birimEsikleri(
    'saglik', ['saglik'], 'Sağlık Bilimleri Fakültesi', $saglikKosullar,
    ['dr_ogr_uyesi' => 100, 'dr_ogr_uyesi_yeniden' => 125, 'docentlik' => 250, 'profesorluk' => 500],
    60, 65, 'Sağlık Bilimleri Fakültesi zorunlu başvuru koşulları',
));

// ══════════════════════════════════════════════════════════════════════════
// SPOR BİLİMLERİ FAKÜLTESİ
// ══════════════════════════════════════════════════════════════════════════

$sporKosullar = [
    'dr_ogr_uyesi' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 yayınınız olmalı', ['A1-A3'], 1, madde: 'Spor Bil. Fak. / Dr'),
        Kalip::puanDan('Makale kalemlerinizden en az 40 puan', ['A'], 40, madde: 'Spor Bil. Fak. / Dr'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        Kalip::adet('Son atamanızdan sonra SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Spor Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Makale kalemlerinizden en az 20 puan', ['A'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Spor Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Kongre kalemlerinizden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Spor Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 10 puan', ['E'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Spor Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Atıf kalemlerinizden en az 5 puan', ['G'], 5, Kalip::SON_ATAMA_SONRASI, madde: 'Spor Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 20 puan', ['H'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Spor Bil. Fak. / Dr yeniden'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 10 puan', ['K'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Spor Bil. Fak. / Dr yeniden'),
    ],
    'docentlik' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Spor Bil. Fak. / Doçent'),
        Kalip::puanDan('Makale kalemlerinizden en az 40 puan', ['A'], 40, Kalip::DOKTORA_SONRASI, madde: 'Spor Bil. Fak. / Doçent'),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 20 puan', ['E'], 20, Kalip::DOKTORA_SONRASI, madde: 'Spor Bil. Fak. / Doçent'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::DOKTORA_SONRASI, madde: 'Spor Bil. Fak. / Doçent'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 30 puan', ['H'], 30, Kalip::DOKTORA_SONRASI, madde: 'Spor Bil. Fak. / Doçent'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 20 puan', ['K'], 20, Kalip::DOKTORA_SONRASI, madde: 'Spor Bil. Fak. / Doçent'),
    ],
    'profesorluk' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 2 makaleniz olmalı', ['A1-A3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
        Kalip::puanDan('Makale kalemlerinizden en az 50 puan', ['A'], 50, Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
        Kalip::puanDan('Kongre kalemlerinizden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
        Kalip::veya('Kitap ya da makale koşulu', [
            Kalip::puanDan('Kitap kalemlerinizden en az 100 puan', ['C'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
            Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 2 makaleniz olmalı', ['A1-A3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
        ]),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 10 puan', ['E'], 10, Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
        Kalip::puanDan('Doktora tez danışmanlığı kalemlerinizden en az 30 puan', ['H1'], 30, Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 100 puan', ['H'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 40 puan', ['K'], 40, Kalip::DOCENTLIK_SONRASI, madde: 'Spor Bil. Fak. / Profesör'),
    ],
];

$esikler = array_merge($esikler, $birimEsikleri(
    'spor', ['spor'], 'Spor Bilimleri Fakültesi', $sporKosullar,
    ['dr_ogr_uyesi' => 100, 'dr_ogr_uyesi_yeniden' => 100, 'docentlik' => 250, 'profesorluk' => 450],
    60, 65, 'Spor Bilimleri Fakültesi zorunlu başvuru koşulları',
));

// ══════════════════════════════════════════════════════════════════════════
// YABANCI DİLLER YÜKSEKOKULU (dil şartı Dr. 85, doçent ve profesör 90)
// ══════════════════════════════════════════════════════════════════════════

$yabanciKosullar = [
    'dr_ogr_uyesi' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 yayınınız olmalı', ['A1-A3'], 1, madde: 'Yabancı Diller YO / Dr'),
        Kalip::puanDan('Makale kalemlerinizden en az 40 puan', ['A'], 40, madde: 'Yabancı Diller YO / Dr'),
    ],
    'dr_ogr_uyesi_yeniden' => [
        Kalip::adet('Son atamanızdan sonra SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::SON_ATAMA_SONRASI, madde: 'Yabancı Diller YO / Dr yeniden'),
        Kalip::puanDan('Makale kalemlerinizden en az 20 puan', ['A'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Yabancı Diller YO / Dr yeniden'),
        Kalip::puanDan('Kongre kalemlerinizden en az 10 puan', ['B'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Yabancı Diller YO / Dr yeniden'),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 10 puan', ['E'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Yabancı Diller YO / Dr yeniden'),
        Kalip::puanDan('Atıf kalemlerinizden en az 5 puan', ['G'], 5, Kalip::SON_ATAMA_SONRASI, madde: 'Yabancı Diller YO / Dr yeniden'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 20 puan', ['H'], 20, Kalip::SON_ATAMA_SONRASI, madde: 'Yabancı Diller YO / Dr yeniden'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 10 puan', ['K'], 10, Kalip::SON_ATAMA_SONRASI, madde: 'Yabancı Diller YO / Dr yeniden'),
    ],
    'docentlik' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::DOKTORA_SONRASI, madde: 'Yabancı Diller YO / Doçent'),
        Kalip::puanDan('Makale kalemlerinizden en az 40 puan', ['A'], 40, Kalip::DOKTORA_SONRASI, madde: 'Yabancı Diller YO / Doçent'),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 20 puan', ['E'], 20, Kalip::DOKTORA_SONRASI, madde: 'Yabancı Diller YO / Doçent'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::DOKTORA_SONRASI, madde: 'Yabancı Diller YO / Doçent'),
        Kalip::puanDan('Eğitim kalemlerinizden en az 30 puan', ['H'], 30, Kalip::DOKTORA_SONRASI, madde: 'Yabancı Diller YO / Doçent'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 10 puan', ['K'], 10, Kalip::DOKTORA_SONRASI, madde: 'Yabancı Diller YO / Doçent'),
    ],
    'profesorluk' => [
        Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 2 makaleniz olmalı', ['A1-A3'], 2, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Yabancı Diller YO / Profesör'),
        Kalip::puanDan('Makale kalemlerinizden en az 50 puan', ['A'], 50, Kalip::DOCENTLIK_SONRASI, madde: 'Yabancı Diller YO / Profesör'),
        Kalip::puanDan('Kongre kalemlerinizden en az 20 puan', ['B'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Yabancı Diller YO / Profesör'),
        Kalip::veya('Kitap ya da makale koşulu', [
            Kalip::puanDan('Kitap kalemlerinizden en az 100 puan', ['C'], 100, Kalip::DOCENTLIK_SONRASI, madde: 'Yabancı Diller YO / Profesör'),
            Kalip::adet('SCI-AHCI ya da alan indeksli dergilerde en az 1 makaleniz olmalı', ['A1-A3'], 1, donem: Kalip::DOCENTLIK_SONRASI, madde: 'Yabancı Diller YO / Profesör'),
        ]),
        Kalip::puanDan('Araştırma projesi kalemlerinizden en az 10 puan', ['E'], 10, Kalip::DOCENTLIK_SONRASI, madde: 'Yabancı Diller YO / Profesör'),
        Kalip::puanDan('Atıf kalemlerinizden en az 10 puan', ['G'], 10, Kalip::DOCENTLIK_SONRASI, madde: 'Yabancı Diller YO / Profesör'),
        Kalip::puanDan('Kurumsal katkı kalemlerinizden en az 20 puan', ['K'], 20, Kalip::DOCENTLIK_SONRASI, madde: 'Yabancı Diller YO / Profesör'),
    ],
];

$esikler = array_merge($esikler, $birimEsikleri(
    'yabanci-diller', ['filoloji'], 'Yabancı Diller Yüksekokulu', $yabanciKosullar,
    ['dr_ogr_uyesi' => 100, 'dr_ogr_uyesi_yeniden' => 100, 'docentlik' => 250, 'profesorluk' => 300],
    85, 90, 'Yabancı Diller Yüksekokulu zorunlu başvuru koşulları',
));

return $esikler;
