<?php

/**
 * ÜAK DOÇENTLİK BAŞVURU ŞARTLARI — 2024 Mart puan cetvelleri (12 temel alan)
 *
 * Kaynak PDF'leri: uak/2024/ · Ayrıntı: cetvel/_uak-NOTLAR.md
 * Dönem: PDF üstverisi 26-27/02/2024 — başvuru döneminden hemen önce.
 *
 * ÜAK her temel alan için AYRI tablo yayımlıyor, ama tablolar birbirinin
 * neredeyse aynısı: 44 kalemin 43'ü on iki tabloda da birebir aynı. Ayrışma
 * sekiz kalemin puanında ve alan başına puan tavanlarında.
 *
 * Bu yüzden burada ortak gövde bir kez yazılı, her tablo ondan türetiliyor.
 * Alan başına ayrı dosya tutulduğunda ortak bir kalem bir dosyada düzeltilip
 * diğer on birinde unutulabiliyordu; `$farklar` tablosu ayrışmanın tamamını
 * tek yerde görünür kılıyor.
 *
 * Dosya on iki cetveli birden döndürür (`cetveller` anahtarı); eşikler bunlara
 * `uak-2024-mart-{alan}` yer tutucusuyla bağlanır ({@see SartDeposu}).
 *
 * MADDE KODLARI ÜAK'ın kendi numaralandırmasıdır; yönergeler doğrudan bu koda
 * atıf yapıyor (ör. Bursa Uludağ "1, 2a kapsamındaki dergiler", "7a").
 *
 * GİRİLMEYEN BÖLÜMLER (bilinçli, on iki tabloda da aynı):
 *   · 9. Eğitim-Öğretim — "dört farklı yarıyılda ders vermiş olmak" bir
 *     metriktir, faaliyet satırı başına puan değildir; cetvelde ifade edilemez.
 *   · 13. Diğer — h-indeksi / yurtdışı araştırma birer metrik.
 *   · 1e, 2c (editöre mektup), 10d (patent başvurusu) — karşılık gelen kaynak
 *     etiketi yok.
 *   Hesaplanan toplam bu bölümlerin tavanı kadar EKSİK kalabilir (fazla değil).
 *   Tavan alana göre değişir — aşağıdaki tabloda "açık" sütunu.
 */

/**
 * Temel alan => [ÜAK tablo adı, kaynak PDF, kapsam açığı (puan)].
 *
 * @var array<string, array{string, string, int}>
 */
$alanlar = [
    'fen' => ['TABLO 2. FEN BİLİMLERİ VE MATEMATİK', '6883416452252.pdf', 16],
    'sosyal' => ['TABLO 11. SOSYAL, BEŞERİ VE İDARİ BİLİMLER', '688341f28b62c.pdf', 26],
    'muhendislik' => ['TABLO 9. MÜHENDİSLİK', '688341d547383.pdf', 16],
    'saglik' => ['TABLO 10. SAĞLIK BİLİMLERİ', '688341e4c96e9.pdf', 16],
    'egitim' => ['TABLO 1. EĞİTİM BİLİMLERİ', '688341526ebc3.pdf', 16],
    'filoloji' => ['TABLO 3. FİLOLOJİ', '6883417d950d0.pdf', 16],
    'hukuk' => ['TABLO 5. HUKUK', '6883419a05ca2.pdf', 16],
    'ilahiyat' => ['TABLO 6. İLAHİYAT', '688341b8ef8c7.pdf', 26],
    'mimarlik' => ['TABLO 8. MİMARLIK, PLANLAMA VE TASARIM', '688341c9a6135.pdf', 16],
    'spor' => ['TABLO 13. SPOR BİLİMLERİ', '68834200a70ac.pdf', 21],
    'ziraat' => ['TABLO 12. ZİRAAT, ORMAN VE SU ÜRÜNLERİ', '6883421feb6f0.pdf', 16],
    'guzel_sanatlar' => ['TABLO 4. GÜZEL SANATLAR', '6883418c44883.pdf', 16],
];

/** On iki tablonun tamamında birebir aynı olan kalemler. */
$maddeler = [

    '10a' => ['baslik' => 'Tescil edilmiş uluslararası patent', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent'], 'puan' => 20],
    '10b' => ['baslik' => 'Tescil edilmiş ulusal patent', 'kategori' => 'patent', 'kaynaklar' => ['Ulusal Patent'], 'puan' => 10],
    '10c' => ['baslik' => 'Tescil edilmiş faydalı model', 'kategori' => 'patent', 'kaynaklar' => ['Faydalı Model'], 'puan' => 5],

    '11' => ['baslik' => 'YÖK/TÜBİTAK/TÜBA ödülü', 'kategori' => 'odul', 'kaynaklar' => ['TÜBİTAK / TÜBA Ödülü'], 'puan' => 25],

    '12a' => ['baslik' => 'WoS/Scopus dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['WoS Dergi (Q1)', 'WoS Dergi (Q2)', 'WoS Dergi (Q3)', 'WoS Dergi (Q4)', 'ESCI / Scopus Dergi'], 'puan' => 2],
    '12b' => ['baslik' => 'BKCI/Scopus kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 1],
    '12c' => ['baslik' => 'TR Dizin dergide editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['TR Dizin Dergi'], 'puan' => 1],

    '1a-Q1' => ['baslik' => 'SCIE/SSCI Q1 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)'], 'puan' => 30],
    '1a-Q2' => ['baslik' => 'SCIE/SSCI Q2 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q2)'], 'puan' => 20],
    '1a-Q3' => ['baslik' => 'SCIE/SSCI Q3 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q3)'], 'puan' => 15],
    '1a-Q4' => ['baslik' => 'SCIE/SSCI Q4 dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q4)'], 'puan' => 10],
    '1b' => ['baslik' => 'AHCI dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'puan' => 20],
    '1c' => ['baslik' => 'ESCI veya Scopus dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 10],
    '1d' => ['baslik' => 'Diğer uluslararası indeksli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Uluslararası İndeks'], 'puan' => 5],

    '2a' => ['baslik' => 'TR Dizin dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'puan' => 10],
    '2b' => ['baslik' => 'Diğer hakemli dergide makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'puan' => 4],

    '3a' => ['baslik' => 'Tezden üretilmiş SCIE/SSCI/AHCI makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => 20],
    '3b' => ['baslik' => 'Tezden üretilmiş ESCI/Scopus makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => 10],
    '3c' => ['baslik' => 'Tezden üretilmiş diğer uluslararası indeksli makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => 5],
    '3d' => ['baslik' => 'Tezden üretilmiş TR Dizin makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => 8],
    '3e' => ['baslik' => 'Tezden üretilmiş BKCI kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    '3f' => ['baslik' => 'Tezden üretilmiş BKCI kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    '3g' => ['baslik' => 'Tezden üretilmiş diğer kitap', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
    '3h' => ['baslik' => 'Tezden üretilmiş diğer kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 3],
    '3ı' => ['baslik' => 'Tezden üretilmiş CPCI bildiri', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => 3],

    '4a' => ['baslik' => 'BKCI kapsamındaki kitap', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap'], 'puan' => 20],
    '4b' => ['baslik' => 'BKCI kapsamındaki kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['BKCI / Scopus Kitap Bölümü'], 'puan' => 10],
    '4c' => ['baslik' => 'Diğer uluslararası/ulusal kitap', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası/Ulusal Kitap'], 'puan' => 5],
    '4d' => ['baslik' => 'Diğer uluslararası/ulusal kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 3],

    '5a' => ['baslik' => 'SCIE/SSCI/AHCI/ESCI/Scopus kapsamında atıf', 'kategori' => 'atif', 'kaynaklar' => ['WoS / Scopus'], 'puan' => 3],
    '5b' => ['baslik' => 'BKCI kapsamındaki kitapta atıf', 'kategori' => 'atif', 'kaynaklar' => ['BKCI Kitap'], 'puan' => 2],
    '5c' => ['baslik' => 'TR Dizin dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['TR Dizin'], 'puan' => 2],
    '5d' => ['baslik' => 'Diğer kitap/dergide atıf', 'kategori' => 'atif', 'kaynaklar' => ['Diğer'], 'puan' => 1],

    '6a' => ['baslik' => 'Doktora tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Doktora Tezi'], 'puan' => 5],
    '6b' => ['baslik' => 'Yüksek lisans tez danışmanlığı', 'kategori' => 'tez_danismanligi', 'kaynaklar' => ['Yüksek Lisans Tezi'], 'puan' => 3],

    '7a-a' => ['baslik' => 'AB Çerçeve/TÜBİTAK projesinde araştırmacı', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['arastirmaci'], 'puan' => 10],
    '7a-d' => ['baslik' => 'AB Çerçeve/TÜBİTAK projesinde danışman', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['danisman', 'bursiyer'], 'puan' => 5],
    '7a-y' => ['baslik' => 'AB Çerçeve/TÜBİTAK projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['AB Çerçeve / Ufuk', 'TÜBİTAK'], 'roller' => ['yurutucu'], 'puan' => 15],
    '7b' => ['baslik' => 'Uluslararası destekli projede görev', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Uluslararası Fon'], 'puan' => 10],
    '7c' => ['baslik' => 'Kamu/özel kuruluş Ar-Ge projesinde görev', 'kategori' => 'proje', 'kaynaklar' => ['Diğer Kamu Kurumu', 'Özel Sektör / STK'], 'puan' => 5],
    '7d' => ['baslik' => 'BAP projesinde yürütücü', 'kategori' => 'proje', 'kaynaklar' => ['BAP (Üniversite)'], 'roller' => ['yurutucu'], 'puan' => 3],

    '8a' => ['baslik' => 'Uluslararası toplantıda CPCI bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)'], 'puan' => 5],
    '8b' => ['baslik' => 'Diğer uluslararası/ulusal toplantıda bildiri', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin', 'Uluslararası Özet/Poster', 'Ulusal Tam Metin', 'Ulusal Özet/Poster'], 'puan' => 3],
];

/** Ortak grup tanımları — eşikler bu adlarla atıf yapıyor. */
$gruplar = [
    '1' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '1d'],
    '1-2a' => ['1a-Q1', '1a-Q2', '1a-Q3', '1a-Q4', '1b', '1c', '1d', '2a'],
    '10' => ['10a', '10b', '10c'],
    '11' => ['11'],
    '12' => ['12a', '12b', '12c'],
    '2' => ['2a', '2b'],
    '3' => ['3a', '3b', '3c', '3d', '3e', '3f', '3g', '3h', '3ı'],
    '3gh' => ['3g', '3h'],
    '4' => ['4a', '4b', '4c', '4d'],
    '4cd' => ['4c', '4d'],
    '5' => ['5a', '5b', '5c', '5d'],
    '6' => ['6a', '6b'],
    '7' => ['7a-y', '7a-a', '7a-d', '7b', '7c', '7d'],
    '7a' => ['7a-y', '7a-a', '7a-d'],
    '8' => ['8a', '8b'],
    'AQ1-Q3' => ['1a-Q1', '1a-Q2', '1a-Q3', '1b'],
    'Q1-Q2' => ['1a-Q1', '1a-Q2'],
    'Q1-Q3' => ['1a-Q1', '1a-Q2', '1a-Q3'],
];

/**
 * ÜAK tablolarının ayrıştığı NOKTALAR — burada yazılmayan her alan ortak
 * gövdeyi olduğu gibi kullanır. Her satır ilgili ÜAK tablosundan okunmuştur.
 *
 * @var array<string, array{maddeler?: array<string, array<string, mixed>>, gruplar?: array<string, list<string>>, grup_sil?: list<string>}>
 */
$farklar = [
    // Fen Bilimleri ve Matematik — Ortak gövdeden yalnızca grup kırılımında ayrılıyor.
    'fen' => [
        'grup_sil' => ['3gh'],
    ],
    // Sosyal, Beşeri ve İdari Bilimler — Tezden üretilmiş kitap ve kitap bölümü daha düşük puanlı.
    'sosyal' => [
        'maddeler' => [
            '3g' => ['puan' => 3],
            '3h' => ['puan' => 2],
        ],
    ],
    // Mühendislik — Tezden üretilmiş CPCI bildirisi daha yüksek puanlı.
    'muhendislik' => [
        'maddeler' => [
            '3ı' => ['puan' => 5],
        ],
        'grup_sil' => ['3gh'],
    ],
    // Filoloji — Kitap ve kitap bölümü belirgin biçimde daha yüksek puanlı.
    'filoloji' => [
        'maddeler' => [
            '4c' => ['puan' => 20],
            '4d' => ['puan' => 5],
        ],
    ],
    // Hukuk — Kitap ve kitap bölümü belirgin biçimde daha yüksek puanlı.
    'hukuk' => [
        'maddeler' => [
            '4c' => ['puan' => 20],
            '4d' => ['puan' => 10],
        ],
    ],
    // İlahiyat — En çok ayrışan tablo: tez yayınları düşük, kitaplar yüksek puanlı;
    // ayrıca yalnız bu alanda bulunan 4e (tahkik) kalemi var.
    'ilahiyat' => [
        'maddeler' => [
            '3c' => ['puan' => 3],
            '3d' => ['puan' => 5],
            '3g' => ['puan' => 3],
            '3h' => ['puan' => 2],
            '3ı' => ['puan' => 5],
            '4c' => ['puan' => 20],
            '4d' => ['puan' => 5],
            '6a' => ['kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi']],
            '4e' => ['baslik' => 'Tahkik (tenkitli metin neşri)', 'kategori' => 'kitap', 'kaynaklar' => ['Tahkik (Tenkitli Metin)'], 'puan' => 10],
        ],
        'gruplar' => [
            '4' => ['4a', '4b', '4c', '4d', '4e'],
            '4cde' => ['4c', '4d', '4e'],
        ],
        'grup_sil' => ['4cd'],
    ],
    // Mimarlık, Planlama ve Tasarım — Ortak gövdeden yalnızca grup kırılımında ayrılıyor.
    'mimarlik' => [
        'grup_sil' => ['3gh'],
    ],
    // Spor Bilimleri — Tezden üretilmiş kitap ve kitap bölümü daha düşük puanlı.
    'spor' => [
        'maddeler' => [
            '3g' => ['puan' => 3],
            '3h' => ['puan' => 2],
        ],
    ],
    // Ziraat, Orman ve Su Ürünleri — Ortak gövdeden yalnızca grup kırılımında ayrılıyor.
    'ziraat' => [
        'grup_sil' => ['3gh'],
    ],
    // Güzel Sanatlar — Doktora tez danışmanlığına sanatta yeterlik tezi de dâhil.
    'guzel_sanatlar' => [
        'maddeler' => [
            '6a' => ['kaynaklar' => ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi']],
        ],
    ],
];

/** Alan başına puan tavanları — ÜAK her tabloda ayrı veriyor. */
$tavanlar = [
    'fen' => ['3' => 20, '4' => 20, '5' => 10, '6' => 10, '7' => 30, '8' => 10, '11' => 25, '12' => 4, '4cd' => 5],
    'sosyal' => ['3' => 20, '4' => 20, '5' => 10, '6' => 10, '7' => 20, '8' => 10, '11' => 25, '12' => 4, '3gh' => 5, '4cd' => 5],
    'muhendislik' => ['3' => 20, '4' => 20, '5' => 10, '6' => 10, '7' => 30, '8' => 10, '11' => 25, '12' => 4, '4cd' => 5],
    'saglik' => ['3' => 20, '4' => 20, '5' => 10, '6' => 10, '7' => 20, '8' => 10, '11' => 25, '12' => 4, '3gh' => 5, '4cd' => 5],
    'egitim' => ['3' => 20, '4' => 20, '5' => 10, '6' => 10, '7' => 15, '8' => 10, '11' => 25, '12' => 4, '3gh' => 5, '4cd' => 5],
    'filoloji' => ['3' => 20, '5' => 10, '6' => 10, '7' => 20, '8' => 10, '11' => 25, '12' => 4, '3gh' => 5, '4cd' => 30],
    'hukuk' => ['3' => 20, '5' => 10, '6' => 10, '7' => 20, '8' => 10, '11' => 25, '12' => 4, '3gh' => 10, '4cd' => 30],
    'ilahiyat' => ['3' => 20, '5' => 10, '6' => 10, '7' => 20, '8' => 10, '11' => 25, '12' => 4, '3gh' => 5, '4cde' => 30],
    'mimarlik' => ['3' => 20, '4' => 20, '5' => 10, '6' => 10, '7' => 30, '8' => 10, '11' => 25, '12' => 4, '4cd' => 5],
    'spor' => ['3' => 20, '4' => 20, '5' => 10, '6' => 10, '7' => 20, '8' => 10, '11' => 25, '12' => 4, '3gh' => 5, '4cd' => 5],
    'ziraat' => ['3' => 20, '4' => 20, '5' => 10, '6' => 10, '7' => 60, '8' => 10, '11' => 25, '12' => 4, '4cd' => 5],
    'guzel_sanatlar' => ['3' => 20, '4' => 20, '5' => 10, '6' => 10, '7' => 20, '8' => 10, '11' => 25, '12' => 4, '3gh' => 5, '4cd' => 5],
];

// ÜAK Tablo 1'in genel kuralı, bölüm başlıklarından hemen önce:
// "Tek yazarlı yayınlarda yazar tam puan alır. Çok yazarlı yayınlarda puan
// yazarlar arasında eşit olarak bölünür." Patent bölümünde ayrıca:
// "Patentlerde puan kişi sayısına bölünür."
//
// ÜAK BAŞLICA YAZARA AYRICALIK TANIMIYOR — kural yalnızca yazar sayısına
// bakıyor, sıraya ya da sorumlu yazarlığa değil. Bütün roller aynı 1/n
// bölmesini paylaşır.
//
// Atıf, proje, tez danışmanlığı, editörlük ve ödül kalemleri dışarıda: ÜAK
// bunlarda bölme kuralı yazmıyor, projede rol ayrımını zaten ayrı kodlarla
// (7a-y yürütücü ↔ 7a-a araştırmacı) yapıyor.
$bol = ['bol' => ['pay' => 1.0]];

$yazarKatsayisi = [
    'haric' => ['atif', 'proje', 'tez_danismanligi', 'editorluk', 'odul',
        'egitim_ogretim', 'idari_gorev', 'toplumsal_katki'],
    'roller' => [
        'tek' => ['kademeler' => [1 => 1.0]],
        'ilk' => $bol,
        'baslica' => $bol,
        'yazar_2' => $bol,
        'yazar_3' => $bol,
        'yazar_4' => $bol,
        'yazar_5' => $bol,
        'yazar_6' => $bol,
        'ortak' => $bol,
    ],
];

$cetveller = [];

foreach ($alanlar as $alan => [$tablo, $pdf, $acik]) {
    $fark = $farklar[$alan] ?? [];

    $alanMaddeleri = $maddeler;

    // Fark yalnızca DEĞİŞEN alanları taşır; gerisi ortak gövdeden gelir.
    foreach ($fark['maddeler'] ?? [] as $kod => $degisiklik) {
        $alanMaddeleri[$kod] = array_replace($alanMaddeleri[$kod] ?? [], $degisiklik);
    }

    $alanGruplari = array_replace($gruplar, $fark['gruplar'] ?? []);

    foreach ($fark['grup_sil'] ?? [] as $ad) {
        unset($alanGruplari[$ad]);
    }

    $cetveller["uak-2024-mart-{$alan}"] = [
        'kapsam_notu' => 'Bu yönerge puanlamayı ÜAK Doçentlik Başvuru Şartları\'na ('.$tablo.') '
            .'devrediyor. Çok yazarlı yayınlarda ÜAK puanı yazarlar arasında EŞİT BÖLÜYOR '
            .'("tek yazarlı yayınlarda yazar tam puan alır"); bu bölme yalnızca faaliyetinizde '
            .'yazar listesini doldurduğunuzda uygulanabiliyor. Yazar listesi boş bırakılan çok '
            .'yazarlı bir yayın burada TAM puan alır, gerçek ÜAK hesabında ise bölünür — o '
            .'kayıtlarda puanınız olduğundan yüksek görünür. Patent puanı da kişi sayısına '
            .'bölünür. Ders verme ve h-indeksi kalemleri faaliyet kaydından doğrulanamadığı '
            .'için hiç hesaba katılmadı; o kalemlerden gelecek en fazla '.$acik.' puan burada '
            .'görünmez.',
        'yazar_katsayisi' => $yazarKatsayisi,
        'maddeler' => $alanMaddeleri,
        'gruplar' => $alanGruplari,
        'grup_tavanlari' => $tavanlar[$alan],
    ];
}

return ['cetveller' => $cetveller];
