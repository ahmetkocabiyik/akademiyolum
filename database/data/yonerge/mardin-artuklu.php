<?php

/**
 * MARDİN ARTUKLU ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma
 * Yönergesi
 * Kaynak: pdf/1773235152586.mardin-artuklu-kriter-11032026.pdf
 * (11 sayfa; M5.YNG.005, yayın 05.12.2025)
 *
 * ── KENDİ PUAN CETVELİ YOK: TÜMÜYLE ÜAK'A DEVREDİYOR ──
 * Madde 7(c): "Doçent ve Profesör kadrolarına yapılacak atamalarda
 * eserlerin tanımlanmasında, eser sınırlandırmalarında ve puanlandırmada
 * yürürlükteki ÜAK Doçentlik başvuru koşullarında ilgili çalışma alanı
 * için belirlenmiş puan ölçütleri ve puan cetveli esas alınır." EK-1 de
 * boş bir puanlama formu; kendi satırı yok. Bu yüzden cetvel
 * `uak-2024-mart-{alan}` (Batman ve Atılım ile aynı).
 *
 * ── KOŞULLAR PUAN DEĞİL, İNDEKS BAŞINA MAKALE SAYISI ──
 * Yönergenin kendi koşulları puan barajı değil, "SCIE/SSCI/AHCI'da
 * taranan en az 2 makale" gibi SAYI şartları. Bu sayılar ÜAK cetvelinin
 * madde kodlarına doğrudan bağlandı:
 *   SCIE/SSCI/AHCI → 1a-Q1, 1a-Q2, 1a-Q3, 1a-Q4, 1b
 *   ESCI / Scopus  → 1c
 *   TR Dizin       → 2a
 *   BKCI / Scopus kitap ve kitap bölümü → 4a, 4b
 *   AB Çerçeve / TÜBİTAK projesi → 7a grubu
 *
 * ── AHCI Q2 SAYILIYOR ──
 * Madde 7(l): "AHCI'da taranan dergiler için WoS tarafından çeyreklik
 * dilim belirleninceye kadar yapılan yayınlar Q2 olarak değerlendirilir."
 * Bu yüzden Q1-Q2 ve Q1-Q3 koşullarına AHCI satırı (1b) DAHİL edildi —
 * yönergenin kendi kuralı.
 *
 * ── BİLİMSEL ALAN GRUPLARI (madde 6) ──
 *   Fen, Mühendislik ve Sağlık Bilimleri → `fen`, `ziraat`,
 *       `muhendislik`, `saglik`
 *   Sosyal Bilimler, Spor Bilimleri, Mimarlık ve Tasarım → `egitim`,
 *       `filoloji`, `hukuk`, `ilahiyat`, `sosyal`, `spor`, `mimarlik`
 *   Güzel Sanatlar → `guzel_sanatlar`
 *
 * ── YENİDEN ATANMADA MERDİVEN, TABANI YAZILDI ──
 * Madde 12(2) yeniden atanmayı SÜREYE bağlıyor: (a) bir indeksli makale
 * → 1 yıl; (b) alan bazlı daha ağır koşullar → 2 yıl; (c) ilk atanma
 * koşullarını yeniden sağlamak → 3 yıl, yedi ek şarttan biri de varsa
 * 4 yıl. Eşiğe (a) yazıldı: bunun ALTINDA yeniden atanma yok. Merdivenin
 * tamamı aday notunda.
 *
 * ── HESAPLANAMAYAN KOŞULLAR ──
 *   "ÜAK Doçentlik asgari başvuru koşullarını yeniden sağlamak" (madde
 *       14-a): ÜAK'ın kendi asgari başvuru şartları puan cetvelinden
 *       ayrı bir kural kümesi ve başvuru dönemine göre değişiyor.
 *   Güzel Sanatlarda istenen "ÜAK sanatsal faaliyetlerinden en az 25 /
 *       30 / 60 puan": ÜAK cetvelinin bu korpustaki sürümünde sanatsal
 *       faaliyet satırı yok.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   657 sayılı Kanun'un 48. maddesi — `beyan`.
 *   Madde 13(c)/(d) ve 14(b)/(c)'nin "toplam proje süresinin 12 aydan
 *       az olmaması" koşulu: proje kaydı süre taşımıyor.
 *   Aynı bentlerin "Bakanlık projesi" kolu: ÜAK cetvelinde bakanlık
 *       projeleri özel sektör Ar-Ge projeleriyle aynı satırda (7c);
 *       ayrılamadığı için yalnız AB Çerçeve/TÜBİTAK satırı (7a)
 *       sayıldı, koşul OLDUĞUNDAN ZOR görünür.
 *   Madde 12(2)-c-6'nın "ESCI (Q1)" koşulu: ÜAK cetveli ESCI'ye çeyrek
 *       vermiyor.
 *   Madde 7(o): yayınlarda kurum adının "Mardin Artuklu University"
 *       biçiminde yer alması.
 *   Madde 12(5): koşulların yarısını sağlayanlara bir defaya mahsus
 *       yeniden atama; madde 12(6): mücbir sebeplerle ek süre.
 *   Madde 7(k): yabancı dille öğretim yapılan programlarda dil puanı —
 *       yönerge sayı vermiyor, ilgili yönetmeliğe atıf yapıyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/uak-2024-mart.php
 */

use App\Services\Scoring\Sart\Kalip;

$UNIVERSITE = 'Mardin Artuklu Üniversitesi';
$CETVEL = 'uak-2024-mart-{alan}';
$DOKTORA = Kalip::DOKTORA_SONRASI;
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$FMS = ['fen', 'ziraat', 'muhendislik', 'saglik'];
$SSM = ['egitim', 'filoloji', 'hukuk', 'ilahiyat', 'sosyal', 'spor', 'mimarlik'];

// ÜAK cetvelinin madde kodları (uak-2024-mart-*).
$WOS = ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b'];
$ESCI = ['1c'];
$TRDIZIN = ['2a'];
$INDEKSLI = ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '2a'];
$KITAP = ['4a', '4b'];
$Q1Q2 = ['1a-Q1', '1a-Q2', '1b'];
$Q1Q3 = ['1a-Q1', '1a-Q2', '1a-Q3', '1b'];

$genelSartlar = Kalip::beyan(
    '657 sayılı Devlet Memurları Kanunu\'nun 48. maddesindeki genel şartlara sahip olmak', '7-a',
);

$doktora = Kalip::beyan(
    'Doktora, sanatta yeterlik ya da tıpta uzmanlık unvanı kazanmış olmak', '11-1-b',
);

$docentUnvani = Kalip::beyan(
    'Doçent unvanını almış olmak; yurt dışından doçentlik belgesi olanların ÜAK\'tan denklik '
    .'almış olması',
    '13-1',
);

$besYil = Kalip::beyan(
    'Doçent unvanını aldıktan sonra ilana başvuru tarihi itibarıyla en az beş yıl süreyle açık '
    .'bulunan profesörlük kadrosuyla ilgili bilim alanında çalışmış olmak',
    '14-1-d',
);

$baslicaEser = Kalip::beyan(
    'Uygun niteliğe sahip eserlerinizden birini başlıca eser olarak beyan etmek (doçent unvanını '
    .'aldıktan sonra yayımlanmış tek yazarlı makale, tek yazarlı kitap, danışmanlığını yaptığınız '
    .'lisansüstü öğrenciyle yazılmış makale ya da birinci yazar olduğunuz özgün araştırma makalesi)',
    '14-1-e',
);

$uakKosullari = Kalip::hesaplanamiyor(
    'Doçent unvanını aldıktan sonra gerçekleştirdiğiniz bilimsel faaliyetlerle ÜAK doçentlik '
    .'asgari başvuru koşullarını YENİDEN sağlamak — ÜAK\'ın asgari başvuru şartları puan '
    .'cetvelinden ayrı bir kural kümesi ve başvuru dönemine göre değiştiği için motor '
    .'hesaplayamıyor',
    '14-1-a',
);

/** Madde 13(c)/(d) ve 14(b)/(c): proje ya da yurt dışı burs koşulu. */
$projeKosulu = fn (array $donem, string $md): array => Kalip::veya('Proje ya da yurt dışı araştırma koşulu', [
    Kalip::adet(
        'AB Çerçeve Programı ya da TÜBİTAK kapsamında yürütülen, başarıyla tamamlanmış en az '
        .'bir bilimsel araştırma projesinde yürütücü veya araştırmacı olarak görev yapmış olmak '
        .'(toplam proje süresi 12 aydan az olmamalı)',
        ['7a'], 1, donem: $donem, madde: $md,
    ),
    Kalip::metrik(
        'Ya da TÜBİTAK araştırma bursu programları kapsamında yurt dışında en az bir yıl '
        .'araştırmacı olarak bulunmuş olmak',
        'yurtdisi_ay', 12, $donem,
    ),
]);

$esikler = [];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — İLK DEFA ATANMA (Madde 11)
// ══════════════════════════════════════════════════════════════════════════

$YENIDEN_NOTU = ' Yeniden atanma SÜREYE bağlı bir merdiven: indeksli en az 1 makale bir yıl, '
    .'alan bazlı daha ağır koşullar iki yıl, ilk atanma koşullarını yeniden sağlamak üç yıl, '
    .'buna ek olarak yedi şarttan birini (iki Q1-Q2 makale, AB/TÜBİTAK projesi, iki yurt dışı '
    .'ortak yazarlı yayın, iki doktora tez danışmanlığı, BKCI/Scopus kitap, iki ESCI Q1 makale '
    .'ya da bunlardan ikisinin yarısı) sağlamak dört yıllık yeniden atama getiriyor.';

$esikler[] = [
    'anahtar' => 'mardin-artuklu-fms-dr',
    'aday_notu' => 'Fen, Mühendislik ve Sağlık Bilimleri alanlarında ilk atanma için '
        .'SCIE, SSCI, AHCI, ESCI, Scopus ya da TR Dizinde taranan en az 3 makaleniz olmalı ve '
        .'bunların en az 2\'si SCIE, SSCI veya AHCI kapsamındaki dergilerde yer almalı. İlk '
        .'atama bir yıl süreyle yapılıyor.'.$YENIDEN_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $FMS,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11(2)-a: indeksli 3 makale, 2\'si SCIE/SSCI/AHCI.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — Fen, Mühendislik ve Sağlık Bilimleri', [
        $genelSartlar,
        $doktora,
        Kalip::adet(
            'SCIE, SSCI, AHCI, ESCI, Scopus ya da TR Dizinde taranan en az 3 makaleniz olmak',
            $INDEKSLI, 3, madde: '11-2-a-1',
        ),
        Kalip::adet(
            'Bu makalelerin en az 2\'sinin SCIE, SSCI veya AHCI kapsamındaki dergilerde yer alması',
            $WOS, 2, madde: '11-2-a-1',
        ),
    ]),
];

$esikler[] = [
    'anahtar' => 'mardin-artuklu-ssm-dr',
    'aday_notu' => 'Sosyal Bilimler, Spor Bilimleri ile Mimarlık ve Tasarım alanlarında ilk '
        .'atanma için dört koşuldan EN AZ BİRİ yeterli: SCIE/SSCI/AHCI\'da taranan en az 1 '
        .'makale; ESCI veya Scopus\'ta taranan en az 2 makale; ESCI/Scopus\'ta en az 1 ve TR '
        .'Dizinde en az 2 makale; ya da TR Dizinde en az 4 makale. İlk atama bir yıl süreyle '
        .'yapılıyor.'.$YENIDEN_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => $SSM,
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11(2)-b: dört seçenekten biri.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — Sosyal, Spor, Mimarlık ve Tasarım', [
        $genelSartlar,
        $doktora,
        Kalip::veya('Dört yayın koşulundan en az biri', [
            Kalip::adet('SCIE, SSCI ya da AHCI\'da taranan en az 1 makaleniz olmak', $WOS, 1, madde: '11-2-b-1'),
            Kalip::adet('Ya da ESCI veya Scopus\'ta taranan en az 2 makaleniz olmak', $ESCI, 2, madde: '11-2-b-2'),
            Kalip::ve('Ya da ESCI/Scopus ile TR Dizin birlikte', [
                Kalip::adet('ESCI veya Scopus\'ta taranan en az 1 makale', $ESCI, 1, madde: '11-2-b-3'),
                Kalip::adet('TR Dizinde taranan en az 2 makale', $TRDIZIN, 2, madde: '11-2-b-3'),
            ]),
            Kalip::adet('Ya da TR Dizinde taranan en az 4 makaleniz olmak', $TRDIZIN, 4, madde: '11-2-b-4'),
        ]),
    ]),
];

$esikler[] = [
    'anahtar' => 'mardin-artuklu-gs-dr',
    'aday_notu' => 'Güzel Sanatlar alanında ilk atanma için SCIE/SSCI/AHCI/ESCI/Scopus\'ta '
        .'taranan en az 1 makale ya da TR Dizinde taranan en az 2 makale isteniyor; ayrıca '
        .'ÜAK\'ın yürürlükteki doçentlik başvuru şartlarındaki sanatsal faaliyetlerden en az 25 '
        .'puan gerekiyor. Bu korpustaki ÜAK cetvelinde sanatsal faaliyet satırı bulunmadığı için '
        .'sanat puanı hesaplanamıyor; onu kendiniz kontrol etmelisiniz.'.$YENIDEN_NOTU,
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi',
    'alan' => ['guzel_sanatlar'],
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 11(2)-c: 1 indeksli makale ya da 2 TR Dizin makalesi + 25 puan sanatsal faaliyet.',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna ilk atanma — Güzel Sanatlar', [
        $genelSartlar,
        $doktora,
        Kalip::veya('Yayın koşulu', [
            Kalip::adet(
                'SCIE, SSCI, AHCI, ESCI ya da Scopus\'ta taranan en az 1 makaleniz olmak',
                array_merge($WOS, $ESCI), 1, madde: '11-2-c-1',
            ),
            Kalip::adet('Ya da TR Dizinde taranan en az 2 makaleniz olmak', $TRDIZIN, 2, madde: '11-2-c-1'),
        ]),
        Kalip::hesaplanamiyor(
            'ÜAK\'ın yürürlükteki doçentlik başvuru şartlarında yer alan sanatsal faaliyetler '
            .'kapsamında en az 25 puanlık sanatsal faaliyete sahip olmak — ÜAK cetvelinin bu '
            .'sürümünde sanatsal faaliyet satırı yok',
            '11-2-c-1',
        ),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOKTOR ÖĞRETİM ÜYESİ — YENİDEN ATANMA (Madde 12)
// ══════════════════════════════════════════════════════════════════════════

$esikler[] = [
    'anahtar' => 'mardin-artuklu-dr-yeniden',
    'aday_notu' => 'En son atanma döneminizin başlangıç tarihinden sonraki bilimsel '
        .'faaliyetleriniz sayılıyor. Yeniden atanmanın TABANI: SCIE, SSCI, AHCI, ESCI, Scopus '
        .'ya da TR Dizinde taranan en az 1 makale — bu bir yıllık yeniden atama getiriyor.'
        .$YENIDEN_NOTU
        .' Koşulları sağlayamazsanız, aranan koşulların en az yarısını sağlamanız hâlinde bir '
        .'defaya mahsus yeniden atanabiliyorsunuz. Analık, doğum, askerlik, uzun süreli sağlık '
        .'raporu ve refakat izni gibi nedenlerle fiilen çalışılamayan üç ay ve üzeri süreler '
        .'için atama sürenize ek süre tanınıyor.',
    'universite' => $UNIVERSITE,
    'kadro' => 'dr_ogr_uyesi_yeniden',
    'alan' => array_merge($FMS, $SSM, ['guzel_sanatlar']),
    'cetvel' => $CETVEL,
    'notlar' => 'Madde 12(2)-a: son atama döneminde en az 1 indeksli makale (1 yıllık yeniden atama tabanı).',
    'sart' => Kalip::ve('Doktor Öğretim Üyesi kadrosuna yeniden atanma', [
        Kalip::adet(
            'Son atanma döneminizden sonra SCIE, SSCI, AHCI, ESCI, Scopus ya da TR Dizinde '
            .'taranan en az 1 makaleniz olmak',
            $INDEKSLI, 1, donem: $SON_ATAMA, madde: '12-2-a',
        ),
    ]),
];

// ══════════════════════════════════════════════════════════════════════════
// DOÇENT (Madde 13) ve PROFESÖR (Madde 14)
// ══════════════════════════════════════════════════════════════════════════

/**
 * @param  list<string>  $alanlar
 * @param  list<string>  $telafiMaddeler
 * @return array<string, mixed>
 */
$docentEsigi = function (
    string $anahtar,
    array $alanlar,
    string $alanAdi,
    array $telafiMaddeler,
    string $telafiAd,
    bool $kitapDa,
) use ($UNIVERSITE, $CETVEL, $DOKTORA, $docentUnvani, $projeKosulu, $KITAP): array {
    $telafi = [Kalip::adet("Ya da {$telafiAd} en az 1 makale yayımlamış olmak", array_values($telafiMaddeler), 1, madde: '13-1')];

    if ($kitapDa) {
        $telafi[] = Kalip::adet(
            'Ya da BKCI veya Scopus\'ta taranan 1 kitap veya kitap bölümü yayımlamış olmak',
            $KITAP, 1, madde: '13-1-d',
        );
    }

    return [
        'anahtar' => "mardin-artuklu-{$anahtar}-docentlik",
        'aday_notu' => "{$alanAdi} için doçentlik unvanına ve ÜAK doçentlik asgari başvuru "
            .'koşullarına ek olarak: doktora unvanınızı aldıktan sonra AB Çerçeve Programı, '
            .'bakanlık ya da TÜBİTAK kapsamında yürütülen ve başarıyla tamamlanmış en az bir '
            .'projede yürütücü veya araştırmacı olarak görev yapmış (toplam süre 12 aydan az '
            .'olmamak üzere) ya da TÜBİTAK araştırma bursuyla yurt dışında en az bir yıl '
            .'bulunmuş olmalısınız. Bu koşulu sağlayamıyorsanız yerine '
            .mb_strtolower(mb_substr($telafiAd, 0, 1)).mb_substr($telafiAd, 1).' en az 1 makale'
            .($kitapDa ? ' ya da BKCI/Scopus\'ta taranan 1 kitap veya kitap bölümü' : '')
            .' yayımlamış olmanız gerekiyor. Bakanlık projeleri ÜAK cetvelinde özel sektör '
            .'Ar-Ge projeleriyle aynı satırda olduğu için yalnız AB Çerçeve ve TÜBİTAK '
            .'projeleri sayılıyor; koşul olduğundan zor görünebilir.',
        'universite' => $UNIVERSITE,
        'kadro' => 'docentlik',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 13(1) ({$alanAdi}): doktora sonrası proje ya da yurt dışı burs; "
            .'sağlanamıyorsa telafi yayını.',
        'sart' => Kalip::ve("Doçent kadrosuna atanma — {$alanAdi}", [
            $docentUnvani,
            Kalip::veya('Proje koşulu ya da telafi yayını', array_merge(
                [$projeKosulu($DOKTORA, '13-1')],
                $telafi,
            )),
        ]),
    ];
};

$esikler[] = $docentEsigi('fms', $FMS, 'Fen, Mühendislik ve Sağlık Bilimleri', $Q1Q3,
    'SCIE, SSCI, AHCI (Q1-Q3) ya da Scopus (Q1-Q3) kapsamında', false);
$esikler[] = $docentEsigi('ssmg', array_merge($SSM, ['guzel_sanatlar']),
    'Sosyal Bilimler, Spor Bilimleri, Mimarlık ve Tasarım ile Güzel Sanatlar', $INDEKSLI,
    'SCIE, SSCI, AHCI, ESCI, Scopus ya da TR Dizinde taranan', true);

/**
 * @param  list<string>  $alanlar
 * @param  list<string>  $telafiMaddeler
 * @return array<string, mixed>
 */
$profesorEsigi = function (
    string $anahtar,
    array $alanlar,
    string $alanAdi,
    array $telafiMaddeler,
    string $telafiAd,
    bool $kitapDa,
) use ($UNIVERSITE, $CETVEL, $DOCENTLIK, $besYil, $baslicaEser, $uakKosullari, $projeKosulu, $KITAP): array {
    $telafi = [Kalip::adet("Ya da {$telafiAd} en az 1 makale yayımlamış olmak", array_values($telafiMaddeler), 1, donem: $DOCENTLIK, madde: '14-1')];

    if ($kitapDa) {
        $telafi[] = Kalip::adet(
            'Ya da BKCI veya Scopus\'ta taranan 1 kitap veya kitap bölümü yayımlamış olmak',
            $KITAP, 1, donem: $DOCENTLIK, madde: '14-1-c',
        );
    }

    return [
        'anahtar' => "mardin-artuklu-{$anahtar}-profesorluk",
        'aday_notu' => 'Doçent unvanınızı aldıktan sonraki bilimsel faaliyetleriniz sayılıyor. '
            ."{$alanAdi} için ÜAK doçentlik asgari başvuru koşullarını doçentlik sonrası "
            .'YENİDEN sağlamanız (motor bunu hesaplayamıyor), doçentlik sonrası AB Çerçeve '
            .'Programı, bakanlık ya da TÜBİTAK projesinde yürütücü/araştırmacı olarak görev '
            .'yapmış (12 aydan az olmamak üzere) ya da TÜBİTAK bursuyla yurt dışında bir yıl '
            .'bulunmuş olmanız, doçentlikten sonra en az beş yıl ilgili bilim alanında çalışmış '
            .'olmanız ve bir eserinizi başlıca eser olarak beyan etmeniz gerekiyor. Proje '
            .'koşulunu sağlayamıyorsanız yerine '
            .mb_strtolower(mb_substr($telafiAd, 0, 1)).mb_substr($telafiAd, 1).' en az 1 makale'
            .($kitapDa ? ' ya da BKCI/Scopus\'ta taranan 1 kitap veya kitap bölümü' : '')
            .' yeterli.',
        'universite' => $UNIVERSITE,
        'kadro' => 'profesorluk',
        'alan' => $alanlar,
        'cetvel' => $CETVEL,
        'notlar' => "Madde 14(1) ({$alanAdi}): ÜAK doçentlik koşullarını yeniden sağlama; "
            .'doçentlik sonrası proje ya da telafi yayını; beş yıl; başlıca eser.',
        'sart' => Kalip::ve("Profesör kadrosuna atanma — {$alanAdi}", [
            $besYil,
            $uakKosullari,
            Kalip::veya('Proje koşulu ya da telafi yayını', array_merge(
                [$projeKosulu($DOCENTLIK, '14-1')],
                $telafi,
            )),
            $baslicaEser,
        ]),
    ];
};

$esikler[] = $profesorEsigi('fms', $FMS, 'Fen, Mühendislik ve Sağlık Bilimleri', $Q1Q2,
    'SCIE, SSCI, AHCI (Q1-Q2) ya da Scopus (Q1-Q2) kapsamında', false);
$esikler[] = $profesorEsigi('ssmg', array_merge($SSM, ['guzel_sanatlar']),
    'Sosyal Bilimler, Spor Bilimleri, Mimarlık ve Tasarım ile Güzel Sanatlar', $INDEKSLI,
    'SCIE, SSCI, AHCI, ESCI, Scopus ya da TR Dizinde taranan', true);

return $esikler;
