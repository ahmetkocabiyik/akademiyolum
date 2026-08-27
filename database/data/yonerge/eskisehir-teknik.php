<?php

/**
 * ESKİŞEHİR TEKNİK ÜNİVERSİTESİ — Öğretim Üyeliği Kadrolarına Yükseltilme
 * ve Atanma Yönergesi
 * Kaynak: pdf/17536994022.eskisehirteknikuniversitesi.pdf (16 sayfa;
 * MADDE 13 uyarınca 2/1/2026'da yürürlüğe girer)
 *
 * ── YAPI: EK-5'İN DÖRT ASGARİ KOŞUL TABLOSU ──
 * MADDE 7-10 koşulları doğrudan EK-5'e devrediyor: Tablo 1 (Dr. ilk
 * atanma), Tablo 2 (Dr. yeniden atanma), Tablo 3 (doçent), Tablo 4
 * (profesör). Her tablonun satırları temel alan gruplarına, sütunları da
 * ayrı barajlara karşılık geliyor: tez yayını sayısı · makale sayısı ·
 * makale puanı · yayın puanı · eğitim faaliyetleri puanı · proje/
 * danışmanlık/yayın seçeneği · toplam puan.
 *
 * Temel alan grupları ve eşleme:
 *   Mühendislik Temel Alanı ile Biyoloji, Fizik ve Kimya Bilim Alanları
 *       → muhendislik + fen (birim "Biyoloji, Fizik ve Kimya")
 *   Matematik ve İstatistik Bilim Alanları
 *       → fen (birim "Matematik ve İstatistik")
 *   Sosyal, Beşeri ve İdari Bilimler Temel Alanı → sosyal
 *   Spor Bilimleri Temel Alanı → spor
 *   Mimarlık, Planlama ve Tasarım Temel Alanı → mimarlik
 *   Güzel Sanatlar Temel Alanı → guzel_sanatlar
 *
 * `fen` temel alanı iki gruba bölündüğü için o iki eşik `birim` taşıyor;
 * kalan dört grup kendi temel alanında tek başına.
 *
 * Yönergenin anmadığı temel alanlar (saglik, egitim, hukuk, ilahiyat,
 * filoloji, ziraat) kapsam dışı bırakıldı — EK-5 tablolarında satırları
 * yok.
 *
 * ── "YAYIN PUANI" SÜTUNU İKİ FARKLI KÜME ──
 * Mühendislik, Matematik, Sosyal ve Spor gruplarında "1-2 maddelerinden"
 * (makale + kitap); Mimarlık ve Güzel Sanatlar gruplarında "1, 2, 7 ve 8
 * maddelerinden" (makale + kitap + planlama-tasarım-sanat + fikri haklar).
 *
 * ── "1f KAPSAMINDA EN FAZLA N PUAN" ALT SINIRLARI ──
 * Makale puanı sütunu sosyal, spor, mimarlık ve güzel sanatlar
 * gruplarında "1a-f kapsamında X puan (1f kapsamında en fazla Y puan
 * alınabilir)" diyor. Bu, kadro başına değişen bir grup tavanı; motorun
 * `grup_tavanlari` alanı cetvel geneline uygulandığı için YAZILAMADI.
 * TR Dizin yayını çok olan aday makale puanı barajını olduğundan kolay
 * geçiyor görünebilir; aday notunda uyarıldı.
 *
 * ── TEZ YAYINI SÜTUNU İÇİN AYNA SATIR ──
 * Tablo 1'in "Lisansüstü Tezlerden Üretilmiş Yayın Sayısı" sütunu 1a-g
 * kod aralığına atıf yapıyor ama motorda tez yayını ayrı bir kategori;
 * cetvele aynı basamaklar `tez_yayini` kategorisinde de açıldı
 * (bkz. cetvel başlığı). Aday tezinden ürettiği yayını o kategoride
 * kaydetmezse bu koşul sağlanmış görünmez.
 *
 * ── PROJE, DERS VE EDİTÖRLÜK PUANI SÜRE ÇARPANLI ──
 * Cetvel başlığında ayrıntısı var: 4. maddenin puanları ay, 6a'nınki
 * haftalık ders saati, 10a-10c'ninki görev yılı ile çarpılıyor ve bu
 * çarpanlar motorda yok. EK-5'in proje ve eğitim barajları (doçentlikte
 * 4. maddeden 150, profesörlükte 240; eğitimde 120) bu yüzden olduğundan
 * ÇOK ZOR görünür. Her eşiğin aday notu bunu söylüyor.
 *
 * ── GİRİLMEYEN KOŞULLAR ──
 *   MADDE 5 (yabancı dil): yalnızca "öğretim müfredatının tamamının
 *       yabancı dilde verildiği alt birimlerde" aranıyor ve birimin
 *       eğitim dili profilde yok; genel bir dil şartı olmadığı için
 *       hiçbir eşiğe `yds` düğümü yazılmadı.
 *   MADDE 8/1-a: "ÜAK tarafından doçent unvanı verilen doktor öğretim
 *       üyesinden yeniden atanma için dosya istenmez" — muafiyet,
 *       profilden okunamıyor; aday notunda hatırlatıldı.
 *   MADDE 10/1: doçentlikten sonra beş yıl çalışmış olmak — beyan.
 *   Tablo 3'ün girişi: "1. ve 2. maddeler kapsamındaki yayınlardan en
 *       fazla 1 adet lisansüstü tezlerden üretilmiş yayın kullanmak
 *       kaydıyla" — bir üst sınır, motorda karşılığı yok.
 *   Tablo 4'ün "gerçekleştirilmiş kişisel mimarlık, planlama, sanat ve
 *       tasarım etkinliği" alternatifi başlıca eser koşuluna eklendi.
 *   EK-4/II (ORCID ve ARBİS kaydı), MADDE 4/5 (etik soruşturma askısı) —
 *       süreç kuralları.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: cetvel/eskisehir-teknik-2026.php
 */

use App\Services\Scoring\Sart\Kalip;

$CETVEL = 'eskisehir-teknik-2026';
$UNIVERSITE = 'Eskişehir Teknik Üniversitesi';
$DOCENTLIK = Kalip::DOCENTLIK_SONRASI;
$SON_ATAMA = Kalip::SON_ATAMA_SONRASI;

$SURE_UYARISI = ' DİKKAT: yönerge proje puanını ay, ders puanını haftalık ders saati, '
    .'editörlük puanını görev yılı ile çarpıyor; bu çarpanlar faaliyet kaydından '
    .'hesaplanamadığı için proje, ders ve editörlük barajlarınız olduğundan ÇOK ZOR görünür. '
    .'Ayrıca makale puanı barajındaki "TR Dizin yayınlarından en fazla şu kadar puan" alt '
    .'sınırı uygulanmıyor.';

/**
 * Bir temel alan grubunun dört kadrosunu üretir.
 *
 * @param  list<string>  $alanlar
 * @param  array<string, mixed>  $c  Grup verisi
 * @return list<array<string, mixed>>
 */
$grupEsikleri = function (string $anahtar, string $ad, array $alanlar, ?string $birim, array $c) use ($UNIVERSITE, $CETVEL, $DOCENTLIK, $SON_ATAMA, $SURE_UYARISI): array {
    /** @var list<string> $yayinKume */
    $yayinKume = $c['yayin_kume'];
    $yayinKumeAd = $c['yayin_kume_ad'];

    /**
     * "Makale sayısı" hücresi: tek koşul ya da "N adet A kümesinden VEYA
     * M adet B kümesinden".
     *
     * @param  list<array{0: string, 1: int, 2: string}>  $secenekler
     * @param  array<string, mixed>|null  $donem
     */
    $makaleSayisi = function (array $secenekler, ?array $donem, string $madde): array {
        $dugumler = array_map(
            fn (array $s): array => Kalip::adet(
                "{$s[2]} en az {$s[1]} makaleniz olmalı", [$s[0]], $s[1], donem: $donem, madde: $madde,
            ),
            $secenekler,
        );

        return count($dugumler) === 1 ? $dugumler[0] : Kalip::veya('Makale sayısı koşulu', array_values($dugumler));
    };

    return [
        // ── Dr. Öğr. Üyesi ilk atanma (EK-5 Tablo 1) ──
        [
            'anahtar' => "eskisehir-teknik-{$anahtar}-dr",
            'aday_notu' => "İlk atanmada ({$ad}) lisansüstü tezinizden üretilmiş en az 1 yayın, "
                .'makale sayısı ve makale puanı barajları, makale-kitap kalemlerinizden 400 puan '
                .'ve toplamda 600 puan gerekiyor. Tezinizden ürettiğiniz yayınları faaliyet '
                .'kaydında "Tezden Üretilmiş Yayın" olarak işaretleyin, yoksa tez yayını koşulu '
                .'sağlanmış görünmez.'.$SURE_UYARISI,
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "EK-5 Tablo 1 ({$ad}): tez yayını 1 adet; makale puanı {$c['dr_makale_puan']}; "
                ."yayın puanı {$yayinKumeAd} 400; toplam 600.",
            'sart' => Kalip::ve("Doktor Öğretim Üyesi kadrosuna ilk kez atanma — {$ad}", array_merge(
                [
                    Kalip::beyan('Doktora ya da sanatta yeterlik eğitimini tamamlamış olmak (yurt dışından alınmışsa ÜAK denkliği)', 'Madde 7'),
                    Kalip::adet('Lisansüstü tezinizden üretilmiş en az 1 yayınınız olmalı', ['TEZ-YAYINI'], 1, madde: 'EK-5 Tablo 1'),
                ],
                $c['dr_makale_sayisi'] === [] ? [] : [$makaleSayisi($c['dr_makale_sayisi'], null, 'EK-5 Tablo 1')],
                [
                    Kalip::puanDan($c['dr_makale_puan_metin'], [$c['dr_makale_puan_kume']], $c['dr_makale_puan'], madde: 'EK-5 Tablo 1'),
                    Kalip::puanDan("{$yayinKumeAd} kalemlerinizden en az 400 puan", $yayinKume, 400, madde: 'EK-5 Tablo 1'),
                    Kalip::toplam(600),
                ],
            )),
        ],
        // ── Dr. Öğr. Üyesi yeniden atanma (EK-5 Tablo 2) ──
        [
            'anahtar' => "eskisehir-teknik-{$anahtar}-dr-yeniden",
            'aday_notu' => 'Yeniden atanmada bir önceki atama tarihinizden sonraki çalışmalarınız '
                ."sayılıyor ({$ad}). Makale puanı, makale-kitap kalemlerinden 240 puan, eğitim "
                .'faaliyetlerinden 80 puan, toplamda 360 puan ve ayrıca proje, tez danışmanlığı '
                .'ya da 360 puanlık yayın seçeneklerinden en az biri gerekiyor. '
                .'ÖNEMLİ MUAFİYET: ÜAK\'tan doçent unvanı aldıysanız yönerge yeniden atanmada '
                .'dosya istemiyor; bu muafiyet burada hesaplanamıyor.'.$SURE_UYARISI,
            'universite' => $UNIVERSITE,
            'kadro' => 'dr_ogr_uyesi_yeniden',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "EK-5 Tablo 2 ({$ad}): makale puanı {$c['yeniden_makale_puan']}; yayın "
                ."puanı {$yayinKumeAd} 240; eğitim 80; seçenek listesi; toplam 360.",
            'sart' => Kalip::ve("Doktor Öğretim Üyeliğine yeniden atanma — {$ad}", [
                Kalip::puanDan($c['yeniden_makale_puan_metin'], [$c['yeniden_makale_puan_kume']], $c['yeniden_makale_puan'], $SON_ATAMA, madde: 'EK-5 Tablo 2'),
                Kalip::puanDan("{$yayinKumeAd} kalemlerinizden en az 240 puan", $yayinKume, 240, $SON_ATAMA, madde: 'EK-5 Tablo 2'),
                Kalip::puanDan('Eğitim faaliyetleri kalemlerinizden en az 80 puan', ['6'], 80, $SON_ATAMA, madde: 'EK-5 Tablo 2'),
                Kalip::veya('Aşağıdakilerden en az birini sağlamalısınız', [
                    Kalip::puanDan('Proje kalemlerinizden en az 40 puan', ['4'], 40, $SON_ATAMA, madde: 'EK-5 Tablo 2'),
                    Kalip::puanDan('Tez danışmanlığı kalemlerinizden en az 75 puan', ['5'], 75, $SON_ATAMA, madde: 'EK-5 Tablo 2'),
                    Kalip::puanDan("{$yayinKumeAd} kalemlerinizden en az 360 puan", $yayinKume, 360, $SON_ATAMA, madde: 'EK-5 Tablo 2'),
                ]),
                Kalip::toplam(360, $SON_ATAMA),
            ]),
        ],
        // ── Doçent (EK-5 Tablo 3) ──
        [
            'anahtar' => "eskisehir-teknik-{$anahtar}-docent",
            'aday_notu' => "Doçentlikte ({$ad}) makale sayısı ve makale puanı barajları, "
                .'makale-kitap kalemlerinden 1000 puan, eğitim faaliyetlerinden 120 puan, '
                .'toplamda 2200 puan ve ayrıca proje, tez danışmanlığı ya da 1000 puanlık '
                .'Q1-Q4 makale seçeneklerinden en az biri gerekiyor. Doçentlik unvanına sahip '
                .'olmalısınız.'.$SURE_UYARISI,
            'universite' => $UNIVERSITE,
            'kadro' => 'docentlik',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "EK-5 Tablo 3 ({$ad}): makale puanı {$c['docent_makale_puan']}; yayın "
                ."puanı {$yayinKumeAd} 1000; eğitim 120; seçenek listesi; toplam 2200.",
            'sart' => Kalip::ve("Doçent kadrosuna atanma — {$ad}", [
                Kalip::beyan('2547 sayılı Kanunun 24. maddesi uyarınca doçent unvanı almış olmak (yurt dışından alınmışsa ÜAK geçerliliği)', 'Madde 9'),
                $makaleSayisi($c['docent_makale_sayisi'], null, 'EK-5 Tablo 3'),
                Kalip::puanDan($c['docent_makale_puan_metin'], [$c['docent_makale_puan_kume']], $c['docent_makale_puan'], madde: 'EK-5 Tablo 3'),
                Kalip::puanDan("{$yayinKumeAd} kalemlerinizden en az 1000 puan", $yayinKume, 1000, madde: 'EK-5 Tablo 3'),
                Kalip::puanDan('Eğitim faaliyetleri kalemlerinizden en az 120 puan', ['6'], 120, madde: 'EK-5 Tablo 3'),
                Kalip::veya('Aşağıdakilerden en az birini sağlamalısınız', [
                    Kalip::puanDan('Proje kalemlerinizden en az 150 puan', ['4'], 150, madde: 'EK-5 Tablo 3'),
                    Kalip::ve('Tez danışmanlığı koşulu', [
                        Kalip::puanDan('Tez danışmanlığı kalemlerinizden en az 150 puan', ['5'], 150, madde: 'EK-5 Tablo 3'),
                        Kalip::adet('İlk danışman olarak tamamlanmış en az 1 lisansüstü tez danışmanlığınız olmalı', ['5-ILK-DANISMAN'], 1, madde: 'EK-5 Tablo 3'),
                    ]),
                    Kalip::puanDan('Web of Science Q1-Q4 makalelerinizden en az 1000 puan', ['1a-ç'], 1000, madde: 'EK-5 Tablo 3'),
                ]),
                Kalip::toplam(2200),
            ]),
        ],
        // ── Profesör (EK-5 Tablo 4) — doçentlik sonrası ──
        [
            'anahtar' => "eskisehir-teknik-{$anahtar}-profesor",
            'aday_notu' => "Profesörlükte ({$ad}) DOÇENTLİK UNVANINIZDAN SONRAKİ çalışmalarınız "
                .'sayılıyor: en az 1 başlıca eser, makale sayısı ve makale puanı barajları, '
                .'makale-kitap kalemlerinden 1000 puan, eğitim faaliyetlerinden 120 puan, '
                .'toplamda 2500 puan ve ayrıca proje, tez danışmanlığı ya da 1200 puanlık '
                .'Q1-Q4 makale seçeneklerinden en az biri gerekiyor. Doçentlik unvanınızı '
                .'aldıktan sonra en az beş yıl ilgili bilim alanında çalışmış olmalısınız.'
                .$SURE_UYARISI,
            'universite' => $UNIVERSITE,
            'kadro' => 'profesorluk',
            'alan' => $alanlar,
            'birim' => $birim,
            'cetvel' => $CETVEL,
            'notlar' => "EK-5 Tablo 4 ({$ad}): başlıca eser 1 adet; makale puanı "
                ."{$c['docent_makale_puan']}; yayın puanı {$yayinKumeAd} 1000; eğitim 120; "
                .'seçenek listesi; toplam 2500.',
            'sart' => Kalip::ve("Profesör kadrosuna atanma — {$ad}", [
                Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl ilan edilen profesör kadrosuyla ilgili bilim alanında çalışmış olmak', 'Madde 10'),
                Kalip::veya('Başlıca eser koşulu', [
                    Kalip::adet('Doçentlik unvanınızdan sonra en az 1 başlıca eseriniz (Web of Science Q1-Q4 ya da AHCI dergisinde araştırma makalesi veya kitap) olmalı', ['BASLICA-ESER'], 1, donem: $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                    Kalip::adet('Doçentlik unvanınızdan sonra gerçekleştirilmiş en az 1 kişisel mimarlık, planlama, sanat ya da tasarım etkinliğiniz olmalı', ['7a-uluslararasi', '7a-ulusal'], 1, donem: $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                ]),
                $makaleSayisi($c['docent_makale_sayisi'], $DOCENTLIK, 'EK-5 Tablo 4'),
                Kalip::puanDan($c['docent_makale_puan_metin'], [$c['docent_makale_puan_kume']], $c['docent_makale_puan'], $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                Kalip::puanDan("{$yayinKumeAd} kalemlerinizden en az 1000 puan", $yayinKume, 1000, $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                Kalip::puanDan('Eğitim faaliyetleri kalemlerinizden en az 120 puan', ['6'], 120, $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                Kalip::veya('Aşağıdakilerden en az birini sağlamalısınız', [
                    Kalip::ve('Proje koşulu', [
                        Kalip::puanDan('Proje kalemlerinizden en az 240 puan', ['4'], 240, $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                        Kalip::adet('Yürütücü ya da koordinatör olarak tamamlanmış en az 1 projeniz olmalı', ['4-YURUTUCU'], 1, donem: $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                    ]),
                    Kalip::ve('Tez danışmanlığı koşulu', [
                        Kalip::puanDan('Tez danışmanlığı kalemlerinizden en az 300 puan', ['5'], 300, $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                        Kalip::adet('İlk danışman olarak tamamlanmış en az 1 lisansüstü tez danışmanlığınız olmalı', ['5-ILK-DANISMAN'], 1, donem: $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                    ]),
                    Kalip::puanDan('Web of Science Q1-Q4 makalelerinizden en az 1200 puan', ['1a-ç'], 1200, $DOCENTLIK, madde: 'EK-5 Tablo 4'),
                ]),
                Kalip::toplam(2500, $DOCENTLIK),
            ]),
        ],
    ];
};

$Q = 'Web of Science Q1-Q4 dergilerinde';
$QD = 'Web of Science Q1-Q4 ya da AHCI dergilerinde';
$QE = 'Web of Science, AHCI, ESCI ya da Scopus dergilerinde';

$esikler = [];

// Mühendislik ile Biyoloji, Fizik ve Kimya
$muh = [
    'yayin_kume' => ['1-2'], 'yayin_kume_ad' => 'Makale ve kitap',
    'dr_makale_sayisi' => [['1a-ç', 2, $Q]],
    'dr_makale_puan_kume' => '1a-ç', 'dr_makale_puan' => 240,
    'dr_makale_puan_metin' => 'Web of Science Q1-Q4 makalelerinizden en az 240 puan',
    'yeniden_makale_puan_kume' => '1a-ç', 'yeniden_makale_puan' => 144,
    'yeniden_makale_puan_metin' => 'Web of Science Q1-Q4 makalelerinizden en az 144 puan',
    'docent_makale_sayisi' => [['1a-ç', 4, $Q]],
    'docent_makale_puan_kume' => '1a-ç', 'docent_makale_puan' => 600,
    'docent_makale_puan_metin' => 'Web of Science Q1-Q4 makalelerinizden en az 600 puan',
];
$esikler = array_merge($esikler, $grupEsikleri('muhendislik', 'Mühendislik Temel Alanı', ['muhendislik'], null, $muh));
$esikler = array_merge($esikler, $grupEsikleri('fen-bfk', 'Biyoloji, Fizik ve Kimya Bilim Alanları', ['fen'], 'Biyoloji, Fizik ve Kimya', $muh));

// Matematik ve İstatistik
$esikler = array_merge($esikler, $grupEsikleri('fen-matematik', 'Matematik ve İstatistik Bilim Alanları', ['fen'], 'Matematik ve İstatistik', [
    'yayin_kume' => ['1-2'], 'yayin_kume_ad' => 'Makale ve kitap',
    'dr_makale_sayisi' => [['1a-ç', 1, $Q]],
    'dr_makale_puan_kume' => '1a-e', 'dr_makale_puan' => 240,
    'dr_makale_puan_metin' => 'Web of Science, AHCI, ESCI ya da Scopus makalelerinizden en az 240 puan',
    'yeniden_makale_puan_kume' => '1a-e', 'yeniden_makale_puan' => 144,
    'yeniden_makale_puan_metin' => 'Web of Science, AHCI, ESCI ya da Scopus makalelerinizden en az 144 puan',
    'docent_makale_sayisi' => [['1a-ç', 2, $Q]],
    'docent_makale_puan_kume' => '1a-e', 'docent_makale_puan' => 600,
    'docent_makale_puan_metin' => 'Web of Science, AHCI, ESCI ya da Scopus makalelerinizden en az 600 puan',
]));

// Sosyal, Beşeri ve İdari Bilimler
$sosyal = [
    'yayin_kume' => ['1-2'], 'yayin_kume_ad' => 'Makale ve kitap',
    'dr_makale_sayisi' => [['1a-d', 1, $QD], ['1a-e', 2, $QE]],
    'dr_makale_puan_kume' => '1a-f', 'dr_makale_puan' => 240,
    'dr_makale_puan_metin' => 'Makale kalemlerinizden en az 240 puan',
    'yeniden_makale_puan_kume' => '1a-f', 'yeniden_makale_puan' => 144,
    'yeniden_makale_puan_metin' => 'Makale kalemlerinizden en az 144 puan',
    'docent_makale_sayisi' => [['1a-d', 2, $QD], ['1a-e', 4, $QE]],
    'docent_makale_puan_kume' => '1a-f', 'docent_makale_puan' => 600,
    'docent_makale_puan_metin' => 'Makale kalemlerinizden en az 600 puan',
];
$esikler = array_merge($esikler, $grupEsikleri('sosyal', 'Sosyal, Beşeri ve İdari Bilimler Temel Alanı', ['sosyal'], null, $sosyal));

// Spor Bilimleri — Dr. ilk atanmada makale sayısı 1a-d'den 1 adet
$spor = $sosyal;
$spor['dr_makale_sayisi'] = [['1a-d', 1, $QD]];
$esikler = array_merge($esikler, $grupEsikleri('spor', 'Spor Bilimleri Temel Alanı', ['spor'], null, $spor));

// Mimarlık, Planlama ve Tasarım — yayın puanı kümesi 1, 2, 7 ve 8
$mimarlik = $sosyal;
$mimarlik['yayin_kume'] = ['1-2-7-8'];
$mimarlik['yayin_kume_ad'] = 'Makale, kitap, planlama-tasarım-sanat ve fikri hak';
$esikler = array_merge($esikler, $grupEsikleri('mimarlik', 'Mimarlık, Planlama ve Tasarım Temel Alanı', ['mimarlik'], null, $mimarlik));

// Güzel Sanatlar — Dr. ilk atanmada makale sayısı koşulu YOK
$esikler = array_merge($esikler, $grupEsikleri('guzel-sanatlar', 'Güzel Sanatlar Temel Alanı', ['guzel_sanatlar'], null, [
    'yayin_kume' => ['1-2-7-8'],
    'yayin_kume_ad' => 'Makale, kitap, planlama-tasarım-sanat ve fikri hak',
    'dr_makale_sayisi' => [],
    'dr_makale_puan_kume' => '1a-f', 'dr_makale_puan' => 125,
    'dr_makale_puan_metin' => 'Makale kalemlerinizden en az 125 puan',
    'yeniden_makale_puan_kume' => '1a-f', 'yeniden_makale_puan' => 75,
    'yeniden_makale_puan_metin' => 'Makale kalemlerinizden en az 75 puan',
    'docent_makale_sayisi' => [['1a-d', 1, $QD], ['1a-e', 3, $QE]],
    'docent_makale_puan_kume' => '1a-f', 'docent_makale_puan' => 300,
    'docent_makale_puan_metin' => 'Makale kalemlerinizden en az 300 puan',
]));

return $esikler;
