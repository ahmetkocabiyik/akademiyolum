<?php

/**
 * İSTANBUL OKAN ÜNİVERSİTESİ — Akademik Personel Yönergesi (YG.OKN.025)
 * Kaynak: pdf/17537100352.istanbulokanuniversitesi.pdf
 *         Senato Kararı Sayı 10, 17.07.2024 (Revizyon 19)
 *
 * BU BİR PUAN YÖNERGESİ DEĞİL, PERSONEL YÖNERGESİ. Otuz beş maddenin tamamı
 * atama usulü, jüri oluşturma, izin, ücret ve mesai düzenliyor; hiçbir yerinde
 * puan cetveli ya da puan barajı yok. Yönergenin akademik ölçüt olarak
 * söylediği tek şey, kadro başına BİR YAYIN şartı.
 *
 * ASIL ÖLÇÜT BELGESİ BU DOSYADA DEĞİL. Üç kadronun da başvuru maddesi
 * (MADDE 7/e, 8/c, 9/d) değerlendirmeyi ayrı bir belgeye devrediyor:
 * "Adayın, AKADEMİK YÜKSELTME VE ATAMA ÖLÇÜTLERİNİ sağlayıp sağlamadığı …
 * Atama ve Yükseltme Komisyonu tarafından değerlendirilir. Ölçütleri
 * sağlamadığı tespit edilen adayların başvuruları kabul edilmez." O belge
 * korpusta yok; her eşiğe `Kalip::hesaplanamiyor` düğümü olarak yazıldı.
 * §0 gereği bu şart: yalnız yayın şartını gösterip eşiği "sağlandı" saymak,
 * adayı hiç görmediğimiz bir ölçüt listesine karşı hazır göstermek olurdu.
 *
 * KENDİ PUAN TABLOSU OLMADIĞI İÇİN cetvel olarak `uak-2024-mart-{alan}`
 * kullanıldı; yayın şartının andığı kalemleri (endeksli dergi makalesi,
 * hakemli dergi makalesi) o cetvel tanımlıyor. `Kalip::toplam` HİÇ
 * KULLANILMADI — yönergede puan barajı yok, yazmak olmayan bir baraj
 * uydurmak olurdu.
 *
 * KOŞUL FAKÜLTEYE GÖRE ÜÇE AYRILIYOR, kadroya göre değil:
 *   Genel        — "ulusal veya uluslararası ENDEKSLERDE TARANAN hakemli
 *                   dergilerde en az bir yayın" (MADDE 7/1/d, 9/1/e)
 *   Hukuk        — "ulusal veya uluslararası HAKEMLİ dergilerde en az bir (1)
 *                   yayın" (MADDE 7/1/f-1, 9/1/f-1) — endeks şartı yok, bu
 *                   yüzden endekssiz hakemli dergi (2b) de sayılıyor
 *   Sanat/Tasarım/Mimarlık — endeksli dergide yayın YA DA uluslararası
 *                   kişisel/karma etkinlik (MADDE 7/1/f-2, 9/1/f-2)
 *
 * DOÇENTLİKTE YAYIN ŞARTI YOK. MADDE 8 yalnızca "Üniversitelerarası Kurul
 * tarafından doçentlik unvanı verilmiş olmak" diyor; Dr. Öğr. Üyesi ve
 * profesörlükteki bir yayın şartının doçentlik karşılığı yönergede YAZMIYOR.
 * Uydurulmadı; doçentlik eşiği yalnız unvan beyanı ile ayrı belgeye devreden
 * ölçüt düğümünden ibaret.
 *
 * SANAT ETKİNLİĞİ DALI BEYAN: "özgün sanat eserleri, tasarımlar, projeler ya
 * da yorum çalışmalarıyla uluslararası kişisel/karma etkinlikte (sergi,
 * bienal, performans, gösterim, festival, film, yarışma vb.) bulunmak" —
 * ÜAK doçentlik cetvelinde sanatsal etkinlik kalemi yok, bu dal hesaplanamıyor.
 *
 * YABANCI DİL EŞİĞİ YAZILMADI: MADDE 28'in YDS/YÖKDİL 85 puanı bir ATAMA
 * ŞARTI değil, yabancı dil TAZMİNATI ödeme ölçütü. Atama koşuluna çevirmek
 * yönergenin demediği bir baraj kurardı.
 *
 * YENİDEN ATANMA GİRİLMEDİ: yönerge sözleşme yenilemeyi MADDE 11'de Rektör
 * önerisi ve Mütevelli Heyet onayına bağlıyor, sayısal ölçüt vermiyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

/** "Ulusal veya uluslararası endekslerde taranan hakemli dergiler" — TR Dizin dâhil. */
$endeksliDergi = ['1a-*', '1b', '1c', '1d', '2a'];

/** Hukuk Fakültesinde endeks şartı yok: endekssiz hakemli dergi de sayılıyor. */
$hakemliDergi = ['1a-*', '1b', '1c', '1d', '2a', '2b'];

$genelAlanlar = ['fen', 'muhendislik', 'saglik', 'sosyal', 'egitim',
    'ilahiyat', 'filoloji', 'spor', 'ziraat'];

$olcutNotu = 'İstanbul Okan\'ın yönergesi puan cetveli ya da puan barajı İÇERMİYOR; '
    .'yönergenin verdiği tek akademik ölçüt bir yayın şartı. Başvurunun asıl '
    .'değerlendirmesi yönergede adı geçen ama metnine ulaşılamayan ayrı bir '
    .'"Akademik Yükseltme ve Atama Ölçütleri" belgesine göre Atama ve Yükseltme '
    .'Komisyonunca yapılıyor. Burada gördüğünüz sonuç bu yüzden EKSİKTİR: yayın '
    .'şartını sağlamanız başvurunuzun kabul edileceği anlamına gelmez. '
    .'Başvurmadan önce güncel ölçüt belgesini üniversiteden isteyin.';

/** Üç kadronun da başvuru maddesinde tekrarlanan devir. */
$olcutBelgesi = fn (string $madde): array => Kalip::hesaplanamiyor(
    'Üniversitenin "Akademik Yükseltme ve Atama Ölçütleri" belgesindeki koşulları sağlamak '
    .'(Atama ve Yükseltme Komisyonu değerlendirir)', $madde);

/**
 * @param  list<string>  $alanlar
 * @param  list<array<string, mixed>>  $cocuklar
 * @return array<string, mixed>
 */
$esik = function (string $anahtar, string $kadro, string $kadroAd, array $alanlar,
    string $notlar, array $cocuklar, string $adayNotu = '') use ($olcutNotu): array {
    return [
        'anahtar' => "istanbul-okan-{$anahtar}",
        'aday_notu' => trim($adayNotu.' '.$olcutNotu),
        'universite' => 'İstanbul Okan Üniversitesi',
        'kadro' => $kadro,
        'alan' => array_values($alanlar),
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => $notlar,
        'sart' => Kalip::ve($kadroAd, array_values($cocuklar)),
    ];
};

$sanatNotu = 'Sanat, Tasarım ve Mimarlık alanında yayın şartının bir sanat etkinliği '
    .'alternatifi var: özgün sanat eseri, tasarım, proje ya da yorum çalışmasıyla '
    .'uluslararası kişisel veya karma bir etkinlikte (sergi, bienal, performans, gösterim, '
    .'festival, film, yarışma) yer almak. Kullanılan cetvelde sanatsal etkinlik kalemi '
    .'olmadığı için bu dal beyan olarak duruyor.';

$sanatDali = fn (string $madde): array => Kalip::veya('Yayın veya sanat etkinliği şartı', [
    Kalip::adet('Ulusal veya uluslararası endekslerde taranan dergilerde en az 1 yayın',
        ['1a-*', '1b', '1c', '1d', '2a'], 1, madde: $madde),
    Kalip::beyan('Özgün sanat eseri, tasarım, proje ya da yorum çalışmanızla uluslararası '
        .'kişisel veya karma bir etkinlikte (sergi, bienal, performans, gösterim, festival, '
        .'film, yarışma) yer almış olmak', $madde),
]);

$docentlikBeyani = Kalip::beyan('Üniversitelerarası Kurul tarafından doçentlik unvanı verilmiş '
    .'olmak veya yurt dışında alınan doçentliğin denkliğinin kabul edilmiş olması', 'Madde 8/1/a');

$profesorlukBeyani = Kalip::beyan('İstanbul Okan Üniversitesince profesörlüğe yükseltilmiş bir '
    .'doçent olmak ya da başka bir üniversitede en az 2 yıl profesör olarak hizmet etmiş olmak',
    'Madde 9/1/a');

return [
    // ══════════ DOKTOR ÖĞRETİM ÜYESİ (MADDE 7) ══════════
    $esik('dr-genel', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', $genelAlanlar,
        'MADDE 7/1/d: ulusal veya uluslararası endekslerde taranan hakemli dergilerde en az '
        .'bir yayın. Puan barajı yok.',
        [
            Kalip::adet('Ulusal veya uluslararası endekslerde taranan hakemli dergilerde en az '
                .'1 yayın', $endeksliDergi, 1, madde: 'Madde 7/1/d'),
            $olcutBelgesi('Madde 7/1/e'),
        ]),
    $esik('dr-hukuk', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['hukuk'],
        'MADDE 7/1/f-1 (Hukuk Fakültesi): ulusal veya uluslararası hakemli dergilerde en az bir '
        .'yayın — endeks şartı aranmıyor.',
        [
            Kalip::adet('Ulusal veya uluslararası hakemli dergilerde en az 1 yayın',
                $hakemliDergi, 1, madde: 'Madde 7/1/f-1'),
            $olcutBelgesi('Madde 7/1/e'),
        ],
        'Hukuk Fakültesinde yayın şartı endekse bağlı değil; endekste taranmayan hakemli '
        .'dergilerdeki makaleleriniz de sayılıyor.'),
    $esik('dr-sanat', 'dr_ogr_uyesi', 'Dr. Öğr. Üyesi', ['guzel_sanatlar', 'mimarlik'],
        'MADDE 7/1/f-2 (Sanat, Tasarım ve Mimarlık): endeksli dergide yayın ya da uluslararası '
        .'kişisel/karma sanat etkinliği.',
        [
            $sanatDali('Madde 7/1/f-2'),
            $olcutBelgesi('Madde 7/1/e'),
        ],
        $sanatNotu),

    // ══════════ DOÇENT (MADDE 8) ══════════
    $esik('docentlik', 'docentlik', 'Doçent',
        [...$genelAlanlar, 'hukuk', 'guzel_sanatlar', 'mimarlik'],
        'MADDE 8: doçentlik kadrosu için yönergede YAYIN ŞARTI YOK; yalnızca ÜAK doçentlik '
        .'unvanı ve ayrı ölçüt belgesi aranıyor.',
        [
            $docentlikBeyani,
            $olcutBelgesi('Madde 8/1/c'),
        ],
        'Yönerge doçent kadrosu için Dr. Öğr. Üyesi ve profesörlükteki gibi bir yayın şartı '
        .'YAZMIYOR; koşul tamamen ÜAK doçentlik unvanına ve ayrı ölçüt belgesine bağlı.'),

    // ══════════ PROFESÖR (MADDE 9) ══════════
    $esik('prof-genel', 'profesorluk', 'Profesör', $genelAlanlar,
        'MADDE 9/1/e: ulusal veya uluslararası endekslerde taranan hakemli dergilerde en az '
        .'bir yayın. Puan barajı yok.',
        [
            Kalip::adet('Ulusal veya uluslararası endekslerde taranan hakemli dergilerde en az '
                .'1 yayın', $endeksliDergi, 1, madde: 'Madde 9/1/e'),
            $profesorlukBeyani,
            $olcutBelgesi('Madde 9/1/d'),
        ]),
    $esik('prof-hukuk', 'profesorluk', 'Profesör', ['hukuk'],
        'MADDE 9/1/f-1 (Hukuk Fakültesi): ulusal veya uluslararası hakemli dergilerde en az bir '
        .'yayın — endeks şartı aranmıyor.',
        [
            Kalip::adet('Ulusal veya uluslararası hakemli dergilerde en az 1 yayın',
                $hakemliDergi, 1, madde: 'Madde 9/1/f-1'),
            $profesorlukBeyani,
            $olcutBelgesi('Madde 9/1/d'),
        ],
        'Hukuk Fakültesinde yayın şartı endekse bağlı değil; endekste taranmayan hakemli '
        .'dergilerdeki makaleleriniz de sayılıyor.'),
    $esik('prof-sanat', 'profesorluk', 'Profesör', ['guzel_sanatlar', 'mimarlik'],
        'MADDE 9/1/f-2 (Sanat, Tasarım ve Mimarlık): endeksli dergide yayın ya da uluslararası '
        .'kişisel/karma sanat etkinliği.',
        [
            $sanatDali('Madde 9/1/f-2'),
            $profesorlukBeyani,
            $olcutBelgesi('Madde 9/1/d'),
        ],
        $sanatNotu),
];
