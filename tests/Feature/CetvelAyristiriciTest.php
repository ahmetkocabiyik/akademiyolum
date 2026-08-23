<?php

use App\Services\Yonerge\CetvelAyristirici;

/**
 * Ayrıştırıcı gerçek PDF'lere karşı geliştirildi ama testler düz metinle
 * çalışır: `pdf/` sürüm denetiminde değil, test onlara bağlı olamaz.
 *
 * Buradaki metin parçaları korpustaki gerçek yönergelerin `pdftotext -layout`
 * çıktısından birebir alındı; hangi üniversiteden geldikleri yazılı.
 */
beforeEach(function () {
    $this->ayristirici = new CetvelAyristirici;
});

test('A düzeni — kod, açıklama ve puan tek satırda (Akdeniz)', function () {
    $satirlar = $this->ayristirici->satirlar(
        '       1.6      ESCI tarafından indekslenmiş dergilerde yayımlanmış özgün makalesi                 50'."\n".
        '       1.7      SCOPUS tarafından indekslenmiş dergilerde yayımlanmış özgün makalesi               30'
    );

    expect($satirlar)->toHaveCount(2)
        ->and($satirlar[0]['kod'])->toBe('1.6')
        ->and($satirlar[0]['puan'])->toBe(50)
        ->and($satirlar[0]['baslik'])->toContain('ESCI')
        ->and($satirlar[1]['puan'])->toBe(30);
});

test('B düzeni — açıklama kodun üstünde ve altında, satırda yalnız puan (Akdeniz proje bölümü)', function () {
    // Bu düzen kaçırıldığında Akdeniz'in 6.1-6.6 kalemleri sessizce düşüyordu.
    $satirlar = $this->ayristirici->satirlar(
        '               Uluslararası fonlayıcı kuruluşlar tarafından desteklenen projelerde yürütücü veya'."\n".
        '    6.1                                                                                      200'."\n".
        '               koordinatör olarak görev almak'
    );

    expect($satirlar)->toHaveCount(1)
        ->and($satirlar[0]['kod'])->toBe('6.1')
        ->and($satirlar[0]['puan'])->toBe(200)
        ->and($satirlar[0]['baslik'])->toContain('yürütücü')
        ->and($satirlar[0]['baslik'])->toContain('koordinatör');
});

test('C düzeni — puan kendi satırında, açıklama alttan devam ediyor (Akdeniz makale bölümü)', function () {
    $satirlar = $this->ayristirici->satirlar(
        '       1.1      SCI-Expanded, SSCI ve AHCI kapsamındaki ilk %10\'luk kategorideki dergilerde özgün'."\n".
        '                                                                                             450'."\n".
        '                araştırma/derleme makalesi'
    );

    expect($satirlar)->toHaveCount(1)
        ->and($satirlar[0]['kod'])->toBe('1.1')
        ->and($satirlar[0]['puan'])->toBe(450);
});

test('kod öncesi sıra numarası yutulur (Atatürk)', function () {
    $satirlar = $this->ayristirici->satirlar(
        '   492         07.02.04   TÜBA GEBİP, TÜBİTAK TWAS Teşvik Ödülleri                              30'
    );

    expect($satirlar[0]['kod'])->toBe('07.02.04')
        ->and($satirlar[0]['puan'])->toBe(30);
});

test('alt bent üst kodla birleşir — iki bölümün a) bendi birbirini ezmez (Gümüşhane)', function () {
    $satirlar = $this->ayristirici->satirlar(
        'B4. Uluslararası bilimsel etkinliklerde sunulan bildiri'."\n".
        '    a) Sözlü olarak sunulan ve tam metin olarak yayımlanan bildiri                              6'."\n".
        'B8. Ulusal bilimsel etkinliklerde sunulan bildiri'."\n".
        '    a) Sözlü olarak sunulan ve tam metin olarak yayımlanan bildiri                              5'
    );

    $kodlar = array_column($satirlar, 'kod');

    expect($kodlar)->toContain('B4a')
        ->and($kodlar)->toContain('B8a')
        ->and($satirlar[array_search('B4a', $kodlar, true)]['puan'])->toBe(6)
        ->and($satirlar[array_search('B8a', $kodlar, true)]['puan'])->toBe(5);
});

test('aynı kod farklı puanla okunduğunda çatışma bildirilir', function () {
    // Yönergeler puan tablosunu ekte tekrar basabiliyor; PHP dizisinde aynı
    // anahtar iki kez yazılırsa dil sessizce sonuncuyu tutardı.
    [$tekil, $catisan] = $this->ayristirici->tekille([
        ['kod' => '1.1', 'baslik' => 'A', 'puan' => 30],
        ['kod' => '1.1', 'baslik' => 'A', 'puan' => 30],
        ['kod' => '2.1', 'baslik' => 'B', 'puan' => 20],
        ['kod' => '2.1', 'baslik' => 'B', 'puan' => 25],
    ]);

    expect($tekil)->toHaveCount(2)
        ->and($catisan)->toHaveCount(1)
        ->and($catisan[0])->toContain('2.1');
});

test('kaynak etiketi tahmin edilir, edilemeyince null döner', function () {
    expect($this->ayristirici->esle('Q1 kategorisindeki dergilerde yayınlanmış özgün makale'))
        ->toBe(['kategori' => 'makale', 'kaynaklar' => ['SCIE/SSCI (Q1)']])
        ->and($this->ayristirici->esle('TR Dizin kapsamındaki dergide makale')['kaynaklar'])
        ->toBe(['TR Dizin']);

    // Sözlüğümüzde karşılığı olmayan kalem: sessizce bir etikete yapıştırılmaz.
    expect($this->ayristirici->esle('Uluslararası ıslahçı hakkı'))->toBeNull()
        ->and($this->ayristirici->esle('Çeşit tescili'))->toBeNull();
});

test('dipnot işaretleri başlıktan temizlenir', function () {
    expect($this->ayristirici->temizle('SENSE kategorisi (B) kitap editörlüğü/yazarlığı 4'))
        ->toBe('SENSE kategorisi (B) kitap editörlüğü/yazarlığı')
        ->and($this->ayristirici->temizle('Kitaplardan alınacak puanlar 1, 2, 3'))
        ->toBe('Kitaplardan alınacak puanlar');
});

test('tek hücrede birden çok değer taşıyan satır tahmin edilmez, bildirilir', function () {
    // Gümüşhane: "G3. Ulusal tescillenmiş patent/faydalı model/telif  40/20/5"
    // Üç kalem tek satırda. Birini seçmek sessiz tahmin olurdu; hangisinin
    // hangi değere ait olduğu ancak metin okunarak anlaşılır.
    $metin = 'G2. Uluslararası tescillenmiş patent / faydalı model ve tasarım                    60/30'."\n".
             'G3. Ulusal tescillenmiş patent/faydalı model ve tasarım/telif hakkı              40/20/5'."\n".
             'G10. Başvurusu yapılan patent/faydalı model                                            5';

    $satirlar = $this->ayristirici->satirlar($metin);
    $coklular = $this->ayristirici->coklular($metin);

    // Yalnızca tek değerli satır puan üretir.
    expect(array_column($satirlar, 'kod'))->toBe(['G10'])
        ->and($satirlar[0]['puan'])->toBe(5);

    // Çok değerliler kaybolmaz, listelenir.
    expect(array_column($coklular, 'kod'))->toBe(['G2', 'G3'])
        ->and($coklular[1]['baslik'])->toContain('40/20/5');
});

test('bölüm başlığı alt bentlerin hangi bölüme ait olduğunu belirler (Ege)', function () {
    // Ege'de "2. BİLİMSEL TOPLANTI" ve "4. ATIF" bölümlerinin ikisinde de b)
    // bendi var. Bölüm başlığı tanınmazsa atıf bendi bildirinin koduna düşer
    // ve biri diğerini sessizce ezer — denetim yanlış alarm verirdi.
    $satirlar = $this->ayristirici->satirlar(
        '2. BİLİMSEL TOPLANTI (BİLDİRİLER)'."\n".
        'b) Uluslararası bilimsel toplantıda sözlü olarak sunulan bildiri                     8'."\n".
        '4. ATIF'."\n".
        'b) Diğer uluslararası alan indekslerince taranan dergilerde yapılan atıflar          1'
    );

    $kodlar = array_column($satirlar, 'kod');

    expect($kodlar)->toBe(['2b', '4b'])
        ->and($satirlar[0]['puan'])->toBe(8)
        ->and($satirlar[1]['puan'])->toBe(1);
});

test('alt bent noktayla da yazılabiliyor (Gazi)', function () {
    // Gazi alt bentleri "a)" değil "a." yazıyor. Tanınmadığında tablonun
    // tamamı okunamıyordu — 59 satırın hiçbiri çıkmıyordu.
    $satirlar = $this->ayristirici->satirlar(
        ' 1. Web of Science tarafından taranan dergilerde yayımlanmış özgün araştırma makalesi'."\n".
        '     a. Q1 grubu dergilerde yayımlanmış özgün araştırma makalesi                       40'."\n".
        '     b. Q2 grubu dergilerde yayımlanmış özgün araştırma makalesi                       35'
    );

    expect(array_column($satirlar, 'kod'))->toBe(['1a', '1b'])
        ->and($satirlar[0]['puan'])->toBe(40)
        ->and($satirlar[1]['puan'])->toBe(35);
});

test('çok sütunlu tabloda sütunlar aynıysa okunur, farklıysa bildirilir (İTÜ)', function () {
    // İTÜ puanı birim grubuna göre veriyor (Tüm Birimler / MF / H,S,TMDK);
    // "-" o grubun kalemi saymadığı anlamına geliyor. Sütunlar farklıyken
    // birini seçmek, adayı başka bir fakültenin ölçütüyle puanlamak olurdu.
    $metin =
        'A.1 Scopus Q1 olarak taranan dergilerde yayınlanan makale            10        10        10'."\n".
        'A.5 AHCI tarafından taranan dergilerde yayınlanan makale              -         4        10';

    $satirlar = $this->ayristirici->satirlar($metin);
    $coklular = $this->ayristirici->coklular($metin);

    expect(array_column($satirlar, 'kod'))->toBe(['A.1'])
        ->and($satirlar[0]['puan'])->toBe(10);

    expect(array_column($coklular, 'kod'))->toBe(['A.5'])
        ->and($coklular[0]['baslik'])->toContain('- | 4 | 10');
});

test('harfle başlayan alt bent bölüm numarasıyla birleşir (Ege)', function () {
    // Ege'de 3. bölümün alt bentleri "a1)", "b1)" gibi. Bunlar tek başına kod
    // taşımaz; bölümle birleşmezse iki farklı bölümün a1 bendi çakışır.
    $satirlar = $this->ayristirici->satirlar(
        '3. KİTAP'."\n".
        'a1) Uluslararası yayınevinden yabancı dilde kitap yazarlığı              75'."\n".
        'b1) Uluslararası yayınevinden yabancı dilde kitap bölümü                20'
    );

    expect(array_column($satirlar, 'kod'))->toBe(['3a1', '3b1'])
        ->and($satirlar[0]['puan'])->toBe(75);
});

test('kodsuz satır okunur ama ürettiği kod ~ ile işaretlenir (Kayseri)', function () {
    // Bazı yönergeler bent numarası kullanmıyor; kalemin kimliği açıklaması.
    // Üretilen kod bizimdir, yönergenin değil — denetimde elle girilen
    // kodlarla eşleşmemesi için `~` ile işaretlenir.
    $satirlar = $this->ayristirici->satirlar(
        '5. PROJE'."\n".
        '    Ulusal veya uluslararası hakemli dergilerde yayımlanmış            20'."\n".
        '    Hakemsiz dergilerde yayımlanmış (en çok 2 adet/yıl)                 5'
    );

    expect(array_column($satirlar, 'kod'))->toBe(['~5.1', '~5.2'])
        ->and($satirlar[0]['puan'])->toBe(20)
        ->and($satirlar[1]['puan'])->toBe(5);

    // Düzyazı paragrafı kalem sanılmamalı: cümle sonu noktası eleme ölçütü.
    $duzyazi = $this->ayristirici->satirlar(
        'Madde 10. Profesörlüğe yükseltilme için gerekli koşullar bölümünde yer alır.        5'
    );

    expect($duzyazi)->toBe([]);
});
