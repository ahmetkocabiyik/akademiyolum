<?php

/**
 * İSTANBUL TOPKAPI ÜNİVERSİTESİ — Akademik Yükseltme ve Atama Yönergesi
 * Kaynak: pdf/17537101282.istanbultopkapiuniversitesi.pdf
 *
 * KENDİ PUAN TABLOSU YOK, PUAN DA İSTEMİYOR. Koşulların tamamı makale ve bildiri
 * SAYISI üzerine kurulu. Cetvel olarak ÜAK doçentlik tablosu
 * (`uak-2024-mart-{alan}`) kullanıldı.
 *
 * KOŞULLAR FAKÜLTEYE GÖRE, ALTI EK İLE VERİLİYOR:
 *   EK.1  İktisadi, İdari ve Sosyal Bilimler; İnsan ve Toplum Bilimleri
 *   EK.2  Güzel Sanatlar, Tasarım ve Mimarlık; İletişim   → GİRİLEMEDİ, aşağıda
 *   EK.3  Mühendislik
 *   EK.4  Spor Bilimleri
 *   EK.5  Sağlık Bilimleri
 *   EK.6  Plato Meslek Yüksekokulu → kendi kriteri yok, ilgili alanda EK.1-EK.5
 *         hangisi geçerliyse o uygulanıyor; ayrı eşik yazılmadı.
 * Bu yüzden eşikler `birim` alanıyla ayrıldı.
 *
 * EK.2 GİRİLEMEDİ: Güzel Sanatlar ve İletişim Fakültesinin koşulları sanat alt
 * alanlarına (Plastik Sanatlar, Müzik, Sahne Sanatları) bölünüyor ve kişisel
 * sergi, oda müziği konseri, opera solistliği, tiyatro/dizi oyunculuğu gibi
 * sanatsal etkinlikler istiyor. ÜAK doçentlik cetvelinde sanatsal etkinlik
 * kalemi bulunmadığı için bu koşullar hesaplanamıyor; eksik kalemlerle eşik
 * yazmak adaya sağlayamayacağı bir hedef gösterirdi. Doçentlikte ise yönerge
 * zaten "ÜAK tarafından konulan şartlar aranır" diyor.
 *
 * "TERCİH SEBEBİ" LİSTESİ GİRİLMEDİ: her EK'in sonunda "aşağıdaki
 * çalışmalardan en az ikisinin yerine getirilmesi TERCİH SEBEBİDİR" diyen bir
 * liste var (yüksek atıflı makale, patent, ödül, laboratuvar kurma…). Tercih
 * sebebi bağlayıcı bir koşul değil, bu yüzden eşiğe girmedi. Tek istisna:
 * listedeki "ders vermiş olmak" maddesi doçent ve profesör için "zorunludur"
 * diyor; o beyan olarak duruyor.
 *
 * Ortak kalıplar: App\Services\Scoring\Sart\Kalip · cetvel: uak-2024-mart-{alan}
 */

use App\Services\Scoring\Sart\Kalip;

$DOC = Kalip::DOCENTLIK_SONRASI;

/** ÜAK cetvelinde geniş makale kümesi (SCI, AHCI, ESCI/Scopus, TR Dizin). */
$genisMakale = ['1a-*', '1b', '1c', '2a'];
/** Yalnızca SCI-Expanded ve Scopus. */
$sciScopus = ['1a-*', '1b', '1c'];
/** Bildiriler. */
$bildiri = ['8'];
// Doçentlik/profesörlük ölçütleri bildiriyi "ULUSLARARASI bilimsel
// toplantılarda sunulan (POSTER HARİÇ)" diye istiyor. ÜAK'ın 8b satırı hem
// ulusalı hem posteri topladığı için o koşullara bağlanamaz. Tam metni
// yayımlanmış uluslararası bildiriler kalıyor; özeti yayımlanmış bildiri
// sözlükte poster ile aynı etikette olduğu için §0 uyarınca dışarıda
// (aday eksik sayılır, poster fazladan sayılmaz).
$bildiriUluslararasi = ['8-ULUSLARARASI-TAM'];

$birimSosyal = 'İktisadi, İdari ve Sosyal Bilimler Fakültesi; İnsan ve Toplum Bilimleri Fakültesi';
$birimMuhendislik = 'Mühendislik Fakültesi';
$birimSpor = 'Spor Bilimleri Fakültesi';
$birimSaglik = 'Sağlık Bilimleri Fakültesi';

$mykNotu = 'Plato Meslek Yüksekokulu için ayrı kriter yok; ilgili alanda hangi fakültenin '
    .'kriterleri geçerliyse o uygulanıyor (EK.6).';

$tercihNotu = 'Yönergenin her ekinde bir "tercih sebebi" listesi var (yüksek atıflı makale, '
    .'patent, ödül, laboratuvar kurma, proje). Tercih sebebi bağlayıcı bir koşul olmadığı için '
    .'burada gösterilmiyor; yalnızca ders verme koşulu doçent ve profesör için zorunlu.';

$dersBeyani = Kalip::beyan('Üniversitelerde veya eğitim kurumlarında alanınızla ilgili ders '
    .'vermiş olmak', 'EK — akademik çalışmalar');

$kitapAlternatifNotu = 'Makale sayısının bir kitap alternatifi var: makalelerden biri yerine '
    .'Senato tarafından kabul edilen uluslararası yayınevlerince yayımlanmış iki kitap bölümü ya '
    .'da bir kitap sayılabiliyor. Bu alternatif aşağıda ayrı bir seçenek olarak duruyor.';

return [
    // ══════════ EK.1 — İKTİSADİ, İDARİ VE SOSYAL BİLİMLER ══════════
    [
        'anahtar' => 'topkapi-dr-sosyal',
        'aday_notu' => 'İstanbul Topkapı PUAN İSTEMİYOR; koşullar makale ve bildiri sayısı '
            .'üzerine kurulu. '.$kitapAlternatifNotu.' '.$mykNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['sosyal', 'egitim', 'hukuk', 'ilahiyat', 'filoloji'],
        'birim' => $birimSosyal,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.1 — Dr. Öğr. Üyesi: indeksli veya ULAKBİM dergilerde en az 2 makale; '
            .'birinin yerine iki kitap bölümü ya da bir kitap sayılabilir.',
        'sart' => Kalip::veya("Dr. Öğr. Üyesi — {$birimSosyal}", [
            Kalip::adet('İndeksli veya ULAKBİM TR Dizin dergilerde en az 2 makale',
                $genisMakale, 2, madde: 'EK.1'),
            Kalip::ve('Bir makale ve kitap alternatifi', [
                Kalip::adet('İndeksli veya ULAKBİM TR Dizin dergilerde en az 1 makale',
                    $genisMakale, 1, madde: 'EK.1'),
                Kalip::adet('Uluslararası yayınevince yayımlanmış 1 kitap ya da 2 kitap bölümü',
                    ['4a', '4b'], 1, madde: 'EK.1'),
            ]),
        ]),
    ],
    [
        'anahtar' => 'topkapi-docent-sosyal',
        'aday_notu' => $kitapAlternatifNotu.' '.$tercihNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['sosyal', 'egitim', 'hukuk', 'ilahiyat', 'filoloji'],
        'birim' => $birimSosyal,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.1 — Doçent: indeksli veya ULAKBİM dergilerde 3 makale ve ders vermiş '
            .'olmak.',
        'sart' => Kalip::ve("Doçent — {$birimSosyal}", [
            Kalip::adet('İndeksli veya ULAKBİM TR Dizin dergilerde en az 3 makale',
                $genisMakale, 3, madde: 'EK.1'),
            $dersBeyani,
        ]),
    ],
    [
        'anahtar' => 'topkapi-profesor-sosyal',
        'aday_notu' => 'Dört makalenin en az ikisi doçentlik atamanızdan SONRA olmalı. '
            .$tercihNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['sosyal', 'egitim', 'hukuk', 'ilahiyat', 'filoloji'],
        'birim' => $birimSosyal,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.1 — Profesör: indeksli dergilerde en az 4 makale (en az 2\'si doçentlik '
            .'sonrası), ulusal yayınevinde 1 kitap ve ders vermiş olmak.',
        'sart' => Kalip::ve("Profesör — {$birimSosyal}", [
            Kalip::adet('İndeksli dergilerde toplam en az 4 makale', $sciScopus, 4, madde: 'EK.1'),
            Kalip::adet('Bunlardan en az 2\'si doçentlik atamanızdan sonra', $sciScopus, 2,
                donem: $DOC, madde: 'EK.1'),
            Kalip::adet('Ulusal yayınevinde yayımlanmış en az 1 kitap', ['4c'], 1, madde: 'EK.1'),
            $dersBeyani,
        ]),
    ],

    // ══════════ EK.3 — MÜHENDİSLİK ══════════
    [
        'anahtar' => 'topkapi-dr-muhendislik',
        'aday_notu' => 'Mühendislik Fakültesinde kitap alternatifi YOK; koşul doğrudan '
            .'SCI-Expanded veya Scopus makalesi. '.$mykNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['muhendislik', 'fen'],
        'birim' => $birimMuhendislik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.3 — Dr. Öğr. Üyesi: SCI-Expanded veya Scopus dergilerde en az 2 makale.',
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$birimMuhendislik}", [
            Kalip::adet('SCI-Expanded veya Scopus dergilerde en az 2 makale', $sciScopus, 2,
                madde: 'EK.3'),
        ]),
    ],
    [
        'anahtar' => 'topkapi-docent-muhendislik',
        'aday_notu' => 'Mühendislikte doçentlik sayısı korpustaki Topkapı birimlerinin en '
            .'yükseği: 5 makale. '.$tercihNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['muhendislik', 'fen'],
        'birim' => $birimMuhendislik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.3 — Doçent: SCI-Expanded veya Scopus dergilerde en az 5 makale ve ders '
            .'vermiş olmak.',
        'sart' => Kalip::ve("Doçent — {$birimMuhendislik}", [
            Kalip::adet('SCI-Expanded veya Scopus dergilerde en az 5 makale', $sciScopus, 5,
                madde: 'EK.3'),
            $dersBeyani,
        ]),
    ],
    [
        'anahtar' => 'topkapi-profesor-muhendislik',
        'aday_notu' => 'Yedi makalenin en az ikisi doçentlik atamanızdan SONRA olmalı. '
            .$tercihNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['muhendislik', 'fen'],
        'birim' => $birimMuhendislik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.3 — Profesör: SCI-Expanded veya Scopus dergilerde en az 7 makale '
            .'(en az 2\'si doçentlik sonrası) ve ders vermiş olmak.',
        'sart' => Kalip::ve("Profesör — {$birimMuhendislik}", [
            Kalip::adet('SCI-Expanded veya Scopus dergilerde toplam en az 7 makale',
                $sciScopus, 7, madde: 'EK.3'),
            Kalip::adet('Bunlardan en az 2\'si doçentlik atamanızdan sonra', $sciScopus, 2,
                donem: $DOC, madde: 'EK.3'),
            $dersBeyani,
        ]),
    ],

    // ══════════ EK.4 — SPOR BİLİMLERİ ══════════
    [
        'anahtar' => 'topkapi-dr-spor',
        'aday_notu' => 'Spor Bilimlerinde makale ve bildiri koşuluna ek olarak, üç öğretim '
            .'üyesinden oluşan bir jüri önünde 40 dakikalık Türkçe sunum yapıp başarılı olmanız '
            .'gerekiyor; bu koşul beyan olarak duruyor. '.$mykNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['spor'],
        'birim' => $birimSpor,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.4 — Dr. Öğr. Üyesi: indeksli dergilerde en az 2 makale, en az 1 bildiri '
            .'ve jüri önünde 40 dakikalık sunum.',
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$birimSpor}", [
            Kalip::adet('İndeksli veya alan indeksli dergilerde en az 2 makale', $sciScopus, 2,
                madde: 'EK.4'),
            Kalip::adet('Bilimsel toplantıda sunulmuş ve yayımlanmış en az 1 bildiri (poster hariç)',
                $bildiri, 1, madde: 'EK.4'),
            Kalip::beyan('Fakülte dekanlığınca belirlenecek üç öğretim üyesinden oluşan bir jüri '
                .'önünde alanınızla ilgili bir konuyu 40 dakika Türkçe sunup başarılı olmak',
                'EK.4'),
        ]),
    ],
    [
        'anahtar' => 'topkapi-docent-spor',
        'aday_notu' => 'Makale ve bildiri koşullarına ek olarak Dr. Öğr. Üyesi olarak en az dört '
            .'yarıyıl tam zamanlı çalışmış olmanız gerekiyor. '.$tercihNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['spor'],
        'birim' => $birimSpor,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.4 — Doçent: indeksli dergilerde en az 4 makale, 3 bildiri, ders vermiş '
            .'olmak ve Dr. Öğr. Üyesi olarak 4 yarıyıl tam zamanlı çalışma.',
        'sart' => Kalip::ve("Doçent — {$birimSpor}", [
            Kalip::adet('İndeksli veya alan indeksli dergilerde en az 4 makale', $sciScopus, 4,
                madde: 'EK.4'),
            Kalip::adet('Bilimsel toplantılarda sunulmuş ve yayımlanmış en az 3 bildiri',
                $bildiri, 3, madde: 'EK.4'),
            Kalip::beyan('Doktor Öğretim Üyesi olarak en az dört yarıyıl üniversitede tam zamanlı '
                .'çalışmış olmak', 'EK.4'),
            $dersBeyani,
        ]),
    ],
    [
        'anahtar' => 'topkapi-profesor-spor',
        'aday_notu' => 'Spor Bilimlerinde profesörlük makale sayısı düşük (2) çünkü tamamı '
            .'doçentlik sonrası isteniyor; buna karşılık kitap ve bildiri koşulu ekleniyor. '
            .$tercihNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['spor'],
        'birim' => $birimSpor,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.4 — Profesör: doçentlik sonrası indeksli dergilerde 2 makale, 1 kitap ya '
            .'da 2 kitap bölümü, 2 bildiri ve doçentlik sonrası beş yıl çalışma.',
        'sart' => Kalip::ve("Profesör — {$birimSpor}", [
            Kalip::adet('Doçentliğinizden sonra indeksli veya alan indeksli dergilerde en az '
                .'2 makale', $sciScopus, 2, donem: $DOC, madde: 'EK.4'),
            Kalip::adet('Ulusal veya uluslararası yayınevinde yayımlanmış en az 1 kitap ya da '
                .'2 kitap bölümü', ['4a', '4b', '4c', '4d'], 1, madde: 'EK.4'),
            Kalip::adet('Bilimsel toplantılarda sunulmuş ve yayımlanmış en az 2 bildiri',
                $bildiri, 2, madde: 'EK.4'),
            Kalip::beyan('Doçent unvanının alındığı tarihten sonra en az 6 yarıyılı üniversitede '
                .'olmak üzere alanınızda beş yıl çalışmış olmak', 'EK.4'),
            $dersBeyani,
        ]),
    ],

    // ══════════ EK.5 — SAĞLIK BİLİMLERİ ══════════
    [
        'anahtar' => 'topkapi-dr-saglik',
        'aday_notu' => 'Sağlık Bilimlerinde makale koşuluna ek olarak bildiri sayısı da '
            .'aranıyor; korpustaki Topkapı birimleri arasında bildiri şartı en ağır olan birim. '
            .$mykNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'dr_ogr_uyesi',
        'alan' => ['saglik'],
        'birim' => $birimSaglik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.5 — Dr. Öğr. Üyesi: indeksli veya ULAKBİM dergilerde en az 2 makale ve '
            .'uluslararası toplantılarda en az 2 bildiri.',
        'sart' => Kalip::ve("Dr. Öğr. Üyesi — {$birimSaglik}", [
            Kalip::adet('İndeksli veya ULAKBİM TR Dizin dergilerde en az 2 makale',
                $genisMakale, 2, madde: 'EK.5'),
            Kalip::adet('Uluslararası bilimsel toplantılarda sunulmuş ve yayımlanmış en az '
                .'2 bildiri (poster hariç)', $bildiriUluslararasi, 2, madde: 'EK.5'),
        ]),
    ],
    [
        'anahtar' => 'topkapi-docent-saglik',
        'aday_notu' => 'Bildiri şartı doçentlikte altıya çıkıyor — korpusta bildiriden bu kadar '
            .'çok isteyen az sayıda koşuldan biri. '.$tercihNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'docentlik',
        'alan' => ['saglik'],
        'birim' => $birimSaglik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.5 — Doçent: indeksli veya ULAKBİM dergilerde en az 4 makale, 6 bildiri '
            .'ve ders vermiş olmak.',
        'sart' => Kalip::ve("Doçent — {$birimSaglik}", [
            Kalip::adet('İndeksli veya ULAKBİM TR Dizin dergilerde en az 4 makale',
                $genisMakale, 4, madde: 'EK.5'),
            Kalip::adet('Uluslararası bilimsel toplantılarda sunulmuş ve yayımlanmış en az '
                .'6 bildiri (poster hariç)', $bildiriUluslararasi, 6, madde: 'EK.5'),
            $dersBeyani,
        ]),
    ],
    [
        'anahtar' => 'topkapi-profesor-saglik',
        'aday_notu' => 'Altı makalenin en az ikisi doçentlik atamanızdan SONRA olmalı; bildiri '
            .'şartı ise ona çıkıyor. '.$tercihNotu,
        'universite' => 'İstanbul Topkapı Üniversitesi',
        'kadro' => 'profesorluk',
        'alan' => ['saglik'],
        'birim' => $birimSaglik,
        'cetvel' => 'uak-2024-mart-{alan}',
        'notlar' => 'EK.5 — Profesör: indeksli dergilerde en az 6 makale (en az 2\'si doçentlik '
            .'sonrası) ve 10 bildiri.',
        'sart' => Kalip::ve("Profesör — {$birimSaglik}", [
            Kalip::adet('İndeksli dergilerde toplam en az 6 makale', $sciScopus, 6, madde: 'EK.5'),
            Kalip::adet('Bunlardan en az 2\'si doçentlik atamanızdan sonra', $sciScopus, 2,
                donem: $DOC, madde: 'EK.5'),
            Kalip::adet('Uluslararası bilimsel toplantılarda sunulmuş ve yayımlanmış en az '
                .'10 bildiri (poster hariç)', $bildiriUluslararasi, 10, madde: 'EK.5'),
            $dersBeyani,
        ]),
    ],
];
