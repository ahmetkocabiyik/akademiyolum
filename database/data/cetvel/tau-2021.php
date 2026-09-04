<?php

/**
 * TÜRK-ALMAN ÜNİVERSİTESİ — EK-1 Bilimsel Faaliyet Türleri Tablosu
 * Kaynak: pdf/17537009962.turk-almannuniverstesi.pdf (10 sayfa; Senato
 * 24/06/2020-2020/59, değişiklikler 08/09/2021, 15/12/2021,
 * 06/07/2022, 22.11.2023 ve 20/08/2024; MADDE 24 uyarınca YÖK onayını
 * takiben 01.01.2021'de yürürlüğe girdi.)
 *
 * ── PUAN DEĞİL FAALİYET TÜRÜ TABLOSU ──
 * EK-1 puan vermiyor; A'dan H'ye sekiz bilimsel faaliyet TÜRÜ
 * tanımlıyor. Puan yalnız MADDE 11'de (yeniden atanma) ortaya çıkıyor
 * ve türlere ağırlık veriyor. Ağırlıklar fakülteye göre değiştiği için
 * cetvelin iki varyantı üretildi:
 *   `tau-2021-sosyal`  Hukuk, İktisadi ve İdari Bilimler, Kültür ve
 *                      Sosyal Bilimler fakülteleri ile Sosyal Bilimler
 *                      Enstitüsü:  A, F, G, H = 3 · B, C = 2 · D, E = 1
 *   `tau-2021-fen`     Fen ve Mühendislik fakülteleri ile Fen Bilimleri
 *                      Enstitüsü:  A, G, H = 3 · B, C, F = 2 · D, E = 1
 * Madde kodları EK-1'in harfleri. Yalnız A'nın SCI ile AHCI ayrımı için
 * açılan `A-sci` / `A-ahci` alt kodları ve tez yayını ayna satırları
 * (`T…`) bize ait.
 *
 * ── A TÜRÜNÜN İKİYE BÖLÜNMESİ ──
 * MADDE 14(b)(bb) doçentlikte "SCI/SCI-Exp. kapsamındaki dergilerde 3
 * veya daha fazla yayın" istiyor; EK-1'in A türü ise SSCI ve AHCI'yi de
 * kapsıyor. Koşulun bağlanabilmesi için A satırı ikiye bölündü;
 * puanları aynı olduğu için toplam puan değişmiyor. Sözlük SCI ile
 * SSCI'yi tek etikette tuttuğundan `A-sci` SSCI'yi de kapsıyor.
 *
 * ── TEZ YAYINI AYNA SATIRLARI ──
 * MADDE 10(b) "doktora tezini yayımlamış olmak veya doktora tezinden
 * üretilmiş en az bir yayının bulunması" diyor; EK-1'de bu nitelik için
 * ayrı tür yok. Koşul değerlendirilebilsin diye `tez_yayini`
 * kategorisinde ayna satırlar açıldı; puanları karşılık geldikleri
 * türlerle aynı. Adayın tezinden üretilmiş çalışmayı "tez yayını"
 * olarak kaydetmesi gerekir.
 *
 * ── GİRİLMEYEN SATIRLAR ──
 *   E türü "poster hariç" diyor; sözlükteki 'Uluslararası Özet/Poster'
 *       ve 'Ulusal Özet/Poster' etiketleri sözlü özet bildiriyi
 *       posterden ayırmadığı için §0 uyarınca hiç sayılmadı. Yalnız tam
 *       metin ve davetli konuşmacı satırları E türüne bağlandı.
 *   G türü "üniversite dışı kurum ve kuruluşlar tarafından
 *       desteklenen" ya da "uluslararası" proje diyor; üniversitenin
 *       kendi BAP projeleri bu türe girmiyor ve cetvele alınmadı.
 *   Atıf, tez danışmanlığı, eğitim-öğretim, editörlük, idari görev ve
 *       sanatsal etkinlik kalemlerinin EK-1'de karşılığı yok; bu
 *       yönerge onları hiç saymıyor.
 *
 * Yönerge: yonerge/tau.php
 *
 * ── İİBF'NİN DAR İNDEKS TANIMI UYGULANMIYOR ──
 * EK-1'in yıldız dipnotu: "İktisadi ve İdari Bilimler Fakültesinde yapılan
 * atanmalarda YALNIZCA Web of Science ya da SCOPUS tarafından taranan
 * dergiler uluslararası alan indeksli dergi olarak değerlendirilir." Yani
 * B türü o fakültede daralıyor ve 'Diğer Uluslararası İndeks' sayılmıyor.
 *
 * Uygulanamadı çünkü kısıt FAKÜLTEYE bağlı, eşikler ise temel alana:
 * `tau-2021-sosyal` varyantı İİBF'nin yanında Hukuk ile Kültür ve Sosyal
 * Bilimler fakültelerini de taşıyor. 'Diğer Uluslararası İndeks'i B'den
 * çıkarmak öteki iki fakültenin adayını eksik sayardı. Acıbadem ve
 * Ardahan'daki karar kalıbı uygulandı: çoğunluğu yöneten okuma yazıldı,
 * sapma burada söylendi. İİBF adayının B türünden puanı, yalnızca WoS ya
 * da Scopus dışında bir indekste yayını varsa OLDUĞUNDAN YÜKSEK görünür.
 */
$SCI = ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)'];
$TUM_TUR = ['ozgun_makale', 'derleme', 'kisa_makale', 'vaka_teknik_not'];
$KITAP_HEPSI = ['BKCI / Scopus Kitap', 'Uluslararası/Ulusal Kitap', 'Tahkik (Tenkitli Metin)',
    'BKCI / Scopus Kitap Bölümü', 'Kitap Bölümü', 'Ansiklopedi Maddesi', 'Çeviri Kitap',
    'Çeviri Kitap Bölümü', 'Ders / Metot Kitabı'];
$PROJE_DIS = ['AB Çerçeve / Ufuk', 'Diğer Uluslararası Fon', 'TÜBİTAK', 'TÜSEB',
    'Diğer Kamu Kurumu', 'Özel Sektör / STK', 'Öğrenci Projesi (2209 vb.)'];

/**
 * @param  array<string, int>  $agirlik  Faaliyet türü → puan
 * @return array<string, mixed>
 */
$govde = function (array $agirlik) use ($SCI, $TUM_TUR, $KITAP_HEPSI, $PROJE_DIS): array {
    $maddeler = [
        'A-sci' => ['baslik' => 'SCI, SCI-Expanded ya da SSCI kapsamındaki dergide yayımlanmış veya yayına kabul edilmiş makale', 'kategori' => 'makale', 'kaynaklar' => $SCI, 'turler' => $TUM_TUR, 'puan' => $agirlik['A']],
        'A-ahci' => ['baslik' => 'AHCI kapsamındaki dergide yayımlanmış veya yayına kabul edilmiş makale', 'kategori' => 'makale', 'kaynaklar' => ['AHCI'], 'turler' => $TUM_TUR, 'puan' => $agirlik['A']],
        'B' => ['baslik' => 'Uluslararası alan indeksi kapsamındaki hakemli dergide ya da uluslararası dergide yayımlanmış veya yayına kabul edilmiş makale', 'kategori' => 'makale', 'kaynaklar' => ['ESCI / Scopus', 'Diğer Uluslararası İndeks'], 'turler' => $TUM_TUR, 'puan' => $agirlik['B']],
        'C' => ['baslik' => 'ULAKBİM TR Dizin tarafından taranan ulusal hakemli dergide yayımlanmış veya yayına kabul edilmiş makale', 'kategori' => 'makale', 'kaynaklar' => ['TR Dizin'], 'turler' => $TUM_TUR, 'puan' => $agirlik['C']],
        'D' => ['baslik' => 'Diğer ulusal hakemli dergide yayımlanmış veya yayına kabul edilmiş makale', 'kategori' => 'makale', 'kaynaklar' => ['Diğer Ulusal Hakemli'], 'turler' => $TUM_TUR, 'puan' => $agirlik['D']],
        'E' => ['baslik' => 'Uluslararası ya da ulusal bilimsel toplantıda sunulan, tam metni bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'bildiri', 'kaynaklar' => ['Uluslararası Tam Metin (CPCI)', 'Uluslararası Tam Metin', 'Ulusal Tam Metin', 'Davetli Konuşmacı'], 'puan' => $agirlik['E']],
        'F' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanmış kitap veya kitapta bölüm yazarlığı', 'kategori' => 'kitap', 'kaynaklar' => $KITAP_HEPSI, 'puan' => $agirlik['F']],
        'F-ed' => ['baslik' => 'Uluslararası ya da ulusal yayınevi tarafından yayımlanmış kitapta editörlük', 'kategori' => 'editorluk', 'kaynaklar' => ['BKCI Kitap', 'Kitap Editörlüğü'], 'puan' => $agirlik['F']],
        'G' => ['baslik' => 'Üniversite dışı kurum ve kuruluşlarca desteklenen ya da uluslararası bir bilimsel araştırma projesinde görev almak', 'kategori' => 'proje', 'kaynaklar' => $PROJE_DIS, 'puan' => $agirlik['G']],
        'H' => ['baslik' => 'Yayımlanmış ya da kabul edilmiş patent, faydalı model veya telif eser', 'kategori' => 'patent', 'kaynaklar' => ['Uluslararası Patent', 'Ulusal Patent', 'Faydalı Model', 'Endüstriyel Tasarım', 'Yazılım', 'Islahçı Hakkı / Çeşit Tescili', 'Ticarileştirme'], 'puan' => $agirlik['H']],

        // ── Tez yayını ayna satırları (kodlar bize ait) ──
        'T-A' => ['baslik' => 'Doktora tezinizden üretilmiş, SCI, SCI-Expanded, SSCI ya da AHCI kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['SCIE/SSCI/AHCI'], 'puan' => $agirlik['A']],
        'T-B' => ['baslik' => 'Doktora tezinizden üretilmiş, uluslararası indeksli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['ESCI / Scopus'], 'puan' => $agirlik['B']],
        'T-C' => ['baslik' => 'Doktora tezinizden üretilmiş, TR Dizin kapsamındaki dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['TR Dizin'], 'puan' => $agirlik['C']],
        'T-D' => ['baslik' => 'Doktora tezinizden üretilmiş, diğer hakemli dergide yayımlanmış makale', 'kategori' => 'tez_yayini', 'kaynaklar' => ['Diğer'], 'puan' => $agirlik['D']],
        'T-E' => ['baslik' => 'Doktora tezinizden üretilmiş, bildiri kitapçığında yayımlanmış çalışma', 'kategori' => 'tez_yayini', 'kaynaklar' => ['CPCI Bildiri'], 'puan' => $agirlik['E']],
        'T-F' => ['baslik' => 'Doktora tezinizden üretilmiş kitap ya da kitap bölümü', 'kategori' => 'tez_yayini', 'kaynaklar' => ['BKCI / Scopus Kitap', 'BKCI / Scopus Kitap Bölümü', 'Uluslararası/Ulusal Kitap', 'Kitap Bölümü'], 'puan' => $agirlik['F']],
    ];

    $gruplar = [
        'A' => ['A-sci', 'A-ahci'],
        'A-SCI' => ['A-sci'],
        'B' => ['B'],
        'C' => ['C'],
        'F' => ['F', 'F-ed'],
        'ABC' => ['A-sci', 'A-ahci', 'B', 'C'],
        'BC' => ['B', 'C'],
        'BCF' => ['B', 'C', 'F', 'F-ed'],
        'ABCD' => ['A-sci', 'A-ahci', 'B', 'C', 'D'],
        'ABCDF' => ['A-sci', 'A-ahci', 'B', 'C', 'D', 'F', 'F-ed'],
        'AFGH' => ['A-sci', 'A-ahci', 'F', 'F-ed', 'G', 'H'],
        'AGH' => ['A-sci', 'A-ahci', 'G', 'H'],
        'TEZ-YAYINI' => ['T-A', 'T-B', 'T-C', 'T-D', 'T-E', 'T-F'],
    ];

    return ['maddeler' => $maddeler, 'gruplar' => $gruplar];
};

$kapsamNotu = 'Puanlar Türk-Alman Üniversitesi Öğretim Üyeliği Kadrolarına Atanma ve '
    .'Yükseltilme Kriterleri Yönergesinin EK-1 tablosundan (01.01.2021 yürürlük, son değişiklik '
    .'20/08/2024). Bu yönerge klasik bir puan cetveli kullanmıyor: EK-1 sekiz bilimsel faaliyet '
    .'TÜRÜ tanımlıyor ve puan yalnız doktor öğretim üyeliğine yeniden atanmada (MADDE 11) '
    .'kullanılıyor. Türlerin ağırlığı fakülteye göre değişiyor; burada gördüğünüz puanlar '
    .'başvurduğunuz alanın ağırlıklarıdır. Yönerge ortak yazarlık için puan bölmesi öngörmüyor, '
    .'bu yüzden yazar çarpanı uygulanmıyor. '
    .'Puanınız şu kalemlerde OLDUĞUNDAN DÜŞÜK görünür: E türü "poster hariç" dediği ve kaynak '
    .'sözlüğü sözlü özet bildiriyi posterden ayırmadığı için özet bildirileriniz hiç sayılmıyor; '
    .'üniversitenizin kendi BAP projeleri G türüne girmediği için sayılmıyor. Atıf, tez '
    .'danışmanlığı, ders, editörlük ve idari görev kalemlerinin bu yönergede karşılığı yok.';

return [
    'cetveller' => [
        'tau-2021-sosyal' => [
            'kapsam_notu' => $kapsamNotu,
            ...$govde(['A' => 3, 'B' => 2, 'C' => 2, 'D' => 1, 'E' => 1, 'F' => 3, 'G' => 3, 'H' => 3]),
        ],
        'tau-2021-fen' => [
            'kapsam_notu' => $kapsamNotu,
            ...$govde(['A' => 3, 'B' => 2, 'C' => 2, 'D' => 1, 'E' => 1, 'F' => 2, 'G' => 3, 'H' => 3]),
        ],
    ],
];
