<?php

/**
 * TED ÜNİVERSİTESİ — Öğretim Üyeliğine Yükseltilme ve Atanma Esasları
 * Kaynak: pdf/17634009071.TED Üniversitesi Kriter.pdf
 *         (KYS-YN-38, Rev. 8 / 19.12.2024)
 *
 * KENDİ PUAN TABLOSU YOK, PUAN DA İSTEMİYOR. Koşullar makale sayısı ve
 * çeyreklik üzerine kurulu. Cetvel olarak ÜAK doçentlik tablosu
 * (`uak-2024-mart-{alan}`) kullanıldı.
 *
 * KORPUSTA ÖĞRETİM PERFORMANSINI KOŞUL YAPAN İLK YÖNERGE. Her kadroda yayın
 * koşullarının yanında öğretim tarafı da aranıyor:
 *   Üniversite içinden başvuruda öğrenci değerlendirmesinde son 2 dönem üst
 *   %50'lik dilimde olmak (profesörlükte %40), yıllık Öğretim Ürün ve
 *   Değerlendirme Dosyası (portfolyo) hazırlamak; dışarıdan başvuruda eğitim
 *   raporu sunmak.
 * Bunların hiçbiri faaliyet kaydından hesaplanamıyor, hepsi beyan olarak
 * duruyor — ama eşikte görünmeleri önemli, çünkü TED'de yayın koşulunu
 * sağlayan aday öğretim koşulunu sağlamadan geçemiyor.
 *
 * DR. ÖĞR. ÜYELİĞİNDE KOŞUL DOKTORA YAŞINA GÖRE DEĞİŞİYOR — korpusta ender:
 *   Doktorasını SON 5 YILDA almış aday   Q1-Q2 dergide 1 makale
 *   Doktorasını 5 YILDAN ÖNCE almış aday Q1-Q2 dergide 2 makale
 * Bu ayrım motorun `sonYil` penceresiyle karşılanamıyor (pencere faaliyete
 * bakıyor, doktora tarihine değil), bu yüzden YÜKSEK olan 2 makale yazıldı ve
 * indirimli hâl aday notunda anlatıldı. Ayrıca "ilanda belirtilmek şartıyla
 * eğitim ağırlıklı bir pozisyona başvuran adaylarda yayın koşulu
 * aranmayabilir" istisnası da beyan olarak duruyor.
 *
 * İKİ FAKÜLTE GRUBU:
 *   Eğitim, Fen-Edebiyat, İktisadi ve İdari Bilimler, Mühendislik
 *   Mimarlık ve Tasarım
 * Mimarlık grubunda çeyreklik eşiği daha geniş (Q1-Q2 yerine herhangi bir Q
 * kategorisi). `birim` alanıyla ayrıldı.
 *
 * İNGİLİZ DİLİ VE SİYASET BÖLÜMLERİ İÇİN KİTAP ALTERNATİFİ: bu iki bölümde
 * makalelerden biri yerine Scopus/WOS taranan ya da SENSE listesindeki bir
 * yayınevinden kitap bölümü sayılabiliyor. Bölüm ayrımı `birim` ile yapılmadı;
 * alternatif bütün grup için `veya` seçeneği olarak duruyor, yani o iki bölüm
 * dışındaki adaylar da bu yoldan geçmiş görünebilir. Bölüm bazında ayırmak
 * yönergenin kendi listesini gerektiriyor ve o liste dosyada tam değil.
 *
 * YENİDEN ATANMA (MADDE 7) GİRİLDİ AMA AYRI EŞİK OLARAK DEĞİL: koşul "son
 * sözleşme dönemi içinde" penceresine bağlı; sözleşme tarihi profilde
 * tutulmuyor. Aday notunda anıldı.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

/** SSCI, SCI-E ve AHCI Q1-Q2. */
$q1q2 = ['1a-Q1', '1a-Q2'];
/** SSCI, SCI-E ve AHCI, bütün çeyreklikler. */
$qHepsi = ['1a-*', '1b'];
/** Scopus veya WOS taranan yayınevi kitap bölümü. */
$kitapBolum = ['4a', '4b'];
$bildiri = ['8'];
// Kaynak bildiri koşullarını "en az 2'si uluslararası …" diye kuruyor
// (MADDE 8/1-e, 9/1-e). ÜAK'ın 8b satırı ulusal ile uluslararasıyı birden
// topladığı için uluslararası alt koşulu ayrı grup istiyor.
$bildiriUluslararasi = ['8-ULUSLARARASI'];
$atif = ['5a', '5b'];
$proje = ['7a-y', '7a-a', '7b', '7d'];

$birimGenel = 'Eğitim, Fen-Edebiyat, İktisadi ve İdari Bilimler ve Mühendislik Fakültesi Bölümleri';
$birimMimarlik = 'Mimarlık ve Tasarım Fakültesi Bölümleri';

$ogretimBeyani = Kalip::beyan('Üniversite içinden başvuruyorsanız öğretim performansınızın '
    .'değerlendirildiği yıllık Öğretim Ürün ve Değerlendirme Dosyasını (portfolyo) hazırlamak '
    .'ve fakülte öğrenci değerlendirmesinde son 2 dönem üst %50\'lik dilimde olmak; dışarıdan '
    .'başvuruyorsanız kendinizle ilgili bir eğitim raporu sunmak', 'Öğretim performansı');

$ogretimBeyaniProf = Kalip::beyan('Üniversite içinden başvuruyorsanız yıllık Öğretim Ürün ve '
    .'Değerlendirme Dosyasını hazırlamak ve fakülte öğrenci değerlendirmesinde son 2 dönem '
    .'üst %40\'lık dilimde olmak; dışarıdan başvuruyorsanız eğitim raporu sunmak',
    'Öğretim performansı');

$drNotu = 'TED PUAN İSTEMİYOR; koşullar makale sayısı ve çeyreklik üzerine kurulu. DOKTORA '
    .'YAŞINA GÖRE İNDİRİM VAR: doktorasını son 5 yıl içinde almış adaylardan 2 değil 1 makale '
    .'isteniyor. Bu ayrım burada hesaplanamadığı için yüksek olan gösteriliyor. Ayrıca ilanda '
    .'belirtilmek şartıyla eğitim ağırlıklı bir pozisyona başvuruyorsanız yayın koşulu hiç '
    .'aranmayabilir.';

$yenidenAtamaNotu = 'Yeniden atanmada son sözleşme dönemi içinde Q1-Q2 dergide '
    .'1 yayın ve altı seçenekten biri isteniyor; sözleşme tarihi burada tutulmadığı için ayrı '
    .'eşik girilmedi.';

$kitapNotu = 'İngiliz Dili ve Edebiyatı ile Siyaset ve Uluslararası İlişkiler Bölümlerinde '
    .'makalelerden biri yerine Scopus/WOS taranan ya da SENSE listesindeki bir yayınevinden '
    .'kitap bölümü sayılabiliyor; bu alternatif aşağıda ayrı seçenek olarak duruyor.';

return [
    // ══════════ DR. ÖĞRETİM ÜYESİ (Madde 6) ══════════
    [
        'anahtar' => 'ted-dr-genel',
        'aday_notu' => $drNotu.' '.$kitapNotu.' '.$yenidenAtamaNotu,
        'universite' => 'TED Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['egitim', 'fen', 'sosyal', 'muhendislik', 'filoloji'],
        'birim' => $birimGenel,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6/1: SSCI, SCI-E veya AHCI Q1-Q2 dergilerde 2 İngilizce makale '
            .'(doktorasını son 5 yılda almış adaylar için 1).',
        'sart' => Kalip::veya("Dr. Öğr. Üyesi — {$birimGenel}", [
            Kalip::adet('SSCI, SCI-E veya AHCI Q1-Q2 kategori dergilerde en az 2 İngilizce '
                .'bilimsel makale', $q1q2, 2, madde: 'Madde 6/1-b'),
            Kalip::adet('İngiliz Dili ve Siyaset Bölümleri için: Scopus veya WOS taranan '
                .'yayınevlerinden en az 2 kitap bölümü', $kitapBolum, 2, madde: 'Madde 6/1-b'),
        ]),
    ],
    [
        'anahtar' => 'ted-dr-mimarlik',
        'aday_notu' => $drNotu.' '.$yenidenAtamaNotu,
        'universite' => 'TED Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['mimarlik', 'guzel_sanatlar'],
        'birim' => $birimMimarlik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 6/2: SSCI, SCI-E veya AHCI Q kategori dergilerde makale koşulu.',
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$birimMimarlik}", [
            Kalip::adet('SSCI, SCI-E veya AHCI dergilerde en az 2 makale', $qHepsi, 2,
                madde: 'Madde 6/2'),
        ]),
    ],

    // ══════════ DOÇENT (Madde 8) ══════════
    [
        'anahtar' => 'ted-docent-genel',
        'aday_notu' => 'Yayın koşullarının yanında ÖĞRETİM PERFORMANSI da aranıyor; TED bunu '
            .'koşul yapan korpustaki ilk yönerge. Dört yayının en az ikisi Q1-Q2 dergide olmalı '
            .'ve hiçbiri doğrudan doktora tezinizden üretilmemiş olmalı. '.$kitapNotu,
        'universite' => 'TED Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['egitim', 'fen', 'sosyal', 'muhendislik', 'filoloji'],
        'birim' => $birimGenel,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 8/1: Dr. koşullarına ek olarak 4 uluslararası yayın (en az 2\'si '
            .'Q1-Q2), 3 bildiri (en az 2\'si uluslararası), 5 atıf ve bir araştırma projesinde '
            .'görev.',
        'sart' => Kalip::ve("Doçent — {$birimGenel}", [
            Kalip::adet('Uluslararası dergilerde en az 4 yayın (makale ya da derleme)',
                [...$qHepsi, '1c'], 4, madde: 'Madde 8/1-d'),
            Kalip::adet('Bunlardan en az 2\'si SSCI, SCI-E veya AHCI Q1-Q2 dergilerde',
                $q1q2, 2, madde: 'Madde 8/1-d'),
            // Kaynak "En az 2'si ULUSLARARASI bilimsel kongrelerde 3 bildiri"
            // diyor; uluslararası alt koşulu ayrı düğüm olmadan sağlanmış
            // sayılıyordu, yani üç ulusal bildiri koşulu dolduruyordu.
            Kalip::adet('Bilimsel kongrelerde sunulmuş en az 3 bildiri',
                $bildiri, 3, madde: 'Madde 8/1-e'),
            Kalip::adet('Bu bildirilerden en az 2\'si uluslararası kongrelerde sunulmuş olmalı',
                $bildiriUluslararasi, 2, madde: 'Madde 8/1-e'),
            Kalip::adet('Yayınlarınıza en az 5 atıf', $atif, 5, madde: 'Madde 8/1-f'),
            Kalip::adet('Bir ulusal ya da uluslararası araştırma projesinde araştırmacı veya '
                .'yürütücü olmak', $proje, 1, madde: 'Madde 8/1-g-h'),
            Kalip::beyan('Bu yayınların doğrudan doktora tezinizden üretilmemiş olması',
                'Madde 8/1-d'),
            $ogretimBeyani,
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanını almış olmak; yurt '
                .'dışında doçentliğe denk bir görevde bulunulmuşsa ÜAK\'tan denklik belgesi almak',
                'Madde 8/a-b'),
        ]),
    ],
    [
        'anahtar' => 'ted-docent-mimarlik',
        'aday_notu' => 'Yayın koşullarının yanında ÖĞRETİM PERFORMANSI da aranıyor. Mimarlık ve '
            .'Tasarım grubunda çeyreklik eşiği daha geniş: Q1-Q2 yerine herhangi bir Q '
            .'kategorisi yeterli.',
        'universite' => 'TED Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['mimarlik', 'guzel_sanatlar'],
        'birim' => $birimMimarlik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 8/2: Dr. koşullarına ek olarak uluslararası yayın, bildiri, atıf ve '
            .'araştırma projesi koşulu.',
        'sart' => Kalip::ve("Doçent — {$birimMimarlik}", [
            Kalip::adet('Uluslararası dergilerde en az 4 yayın (makale ya da derleme)',
                [...$qHepsi, '1c'], 4, madde: 'Madde 8/2'),
            Kalip::adet('Bunlardan en az 2\'si SSCI, SCI-E veya AHCI dergilerde', $qHepsi, 2,
                madde: 'Madde 8/2'),
            Kalip::adet('Bilimsel kongrelerde sunulmuş en az 3 bildiri', $bildiri, 3,
                madde: 'Madde 8/2'),
            Kalip::adet('Yayınlarınıza en az 5 atıf', $atif, 5, madde: 'Madde 8/2'),
            Kalip::adet('Bir ulusal ya da uluslararası araştırma projesinde araştırmacı veya '
                .'yürütücü olmak', $proje, 1, madde: 'Madde 8/2'),
            $ogretimBeyani,
            Kalip::beyan('Üniversitelerarası Kuruldan doçentlik unvanını almış olmak',
                'Madde 8/a-b'),
        ]),
    ],

    // ══════════ PROFESÖR (Madde 9) ══════════
    [
        'anahtar' => 'ted-profesor-genel',
        'aday_notu' => 'Koşullar doçentlik koşullarına EKLENİYOR: doçentlikte istenen 4 yayının '
            .'üzerine 5 yayın daha, 3 bildirinin üzerine 3 bildiri daha, 5 atıfın üzerine 10 '
            .'atıf daha. Öğretim performansı eşiği de yükseliyor (üst %50 yerine üst %40). '
            .$kitapNotu,
        'universite' => 'TED Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['egitim', 'fen', 'sosyal', 'muhendislik', 'filoloji'],
        'birim' => $birimGenel,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 9/1: doçentlik koşullarına ek olarak 5 yayın (en az 3\'ü Q1-Q2), '
            .'3 bildiri (en az 2\'si uluslararası), 10 atıf ve bir araştırma projesinde '
            .'yürütücülük.',
        'sart' => Kalip::ve("Profesör — {$birimGenel}", [
            Kalip::adet('Doçentliğinizden sonra uluslararası dergilerde en az 5 yayın',
                [...$qHepsi, '1c'], 5, donem: $DOC, madde: 'Madde 9/1-d'),
            Kalip::adet('Bunlardan en az 3\'ü SSCI, SCI-E veya AHCI Q1-Q2 dergilerde',
                $q1q2, 3, donem: $DOC, madde: 'Madde 9/1-d'),
            Kalip::adet('Doçentliğinizden sonra en az 3 bildiri',
                $bildiri, 3, donem: $DOC, madde: 'Madde 9/1-e'),
            Kalip::adet('Bu bildirilerden en az 2\'si uluslararası kongrelerde sunulmuş olmalı',
                $bildiriUluslararasi, 2, donem: $DOC, madde: 'Madde 9/1-e'),
            Kalip::adet('Yayınlarınıza doçentlik sonrası en az 10 ek atıf', $atif, 10,
                donem: $DOC, madde: 'Madde 9/1-f'),
            Kalip::adet('Bir TÜBİTAK, ulusal ya da uluslararası araştırma projesinde yürütücü '
                .'olmak', ['7a-y', '7d'], 1, donem: $DOC, madde: 'Madde 9/1-g'),
            $ogretimBeyaniProf,
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan '
                .'profesörlük kadrosuyla ilgili bilim veya sanat alanında çalışmış olmak',
                'Madde 9/a'),
        ]),
    ],
    [
        'anahtar' => 'ted-profesor-mimarlik',
        'aday_notu' => 'Koşullar doçentlik koşullarına EKLENİYOR. Mimarlık ve Tasarım grubunda '
            .'çeyreklik eşiği daha geniş. Öğretim performansı eşiği yükseliyor (üst %40).',
        'universite' => 'TED Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['mimarlik', 'guzel_sanatlar'],
        'birim' => $birimMimarlik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'Madde 9/2: doçentlik koşullarına ek olarak uluslararası yayın, bildiri, '
            .'atıf ve araştırma projesi koşulu.',
        'sart' => Kalip::ve("Profesör — {$birimMimarlik}", [
            Kalip::adet('Doçentliğinizden sonra uluslararası dergilerde en az 5 yayın',
                [...$qHepsi, '1c'], 5, donem: $DOC, madde: 'Madde 9/2'),
            Kalip::adet('Bunlardan en az 3\'ü SSCI, SCI-E veya AHCI dergilerde', $qHepsi, 3,
                donem: $DOC, madde: 'Madde 9/2'),
            Kalip::adet('Doçentliğinizden sonra en az 3 bildiri', $bildiri, 3, donem: $DOC,
                madde: 'Madde 9/2'),
            Kalip::adet('Yayınlarınıza doçentlik sonrası en az 10 ek atıf', $atif, 10,
                donem: $DOC, madde: 'Madde 9/2'),
            Kalip::adet('Bir araştırma projesinde yürütücü olmak', ['7a-y', '7d'], 1,
                donem: $DOC, madde: 'Madde 9/2'),
            $ogretimBeyaniProf,
            Kalip::beyan('Doçentlik unvanını aldıktan sonra en az beş yıl açık bulunan '
                .'profesörlük kadrosuyla ilgili alanda çalışmış olmak', 'Madde 9/a'),
        ]),
    ],
];
