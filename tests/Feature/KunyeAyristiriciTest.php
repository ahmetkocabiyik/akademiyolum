<?php

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Services\Yayin\KunyeAyristirici;

/**
 * İçe aktarılan ham künyeden künye alanları. Örnekler gerçek APBS/AVESİS
 * çıktılarından; temkinli ayrıştırma: emin olunmayan parça boş kalır.
 */
dataset('ham künyeler', [
    'APBS makale' => [Kategori::Makale, 'Kilis 7 Aralık Üniversitesi İlahiyat Fakültesi Dergisi, vol. 13, no. 1, pp. 313–343 · Uluslararası',
        ['dergi' => 'Kilis 7 Aralık Üniversitesi İlahiyat Fakültesi Dergisi', 'cilt' => '13', 'sayi' => '1', 'sayfa' => '313–343']],
    'parantezli dergi adı korunur' => [Kategori::Makale, 'Çukurova Üniversitesi İlahiyat Fakültesi Dergisi (ÇÜİFD), vol. 2025, no. 2, pp. 193–211 · Ulusal',
        ['dergi' => 'Çukurova Üniversitesi İlahiyat Fakültesi Dergisi (ÇÜİFD)', 'cilt' => '2025', 'sayi' => '2', 'sayfa' => '193–211']],
    'AVESİS makale, dizin parantezi atılır' => [Kategori::Makale, 'Dergi Adı, cilt.23, sa.1, ss.12-30, 2026 (ESCI, Scopus)',
        ['dergi' => 'Dergi Adı', 'cilt' => '23', 'sayi' => '1', 'sayfa' => '12-30']],
    'APBS bildiri, tarih atılır' => [Kategori::Bildiri, 'I. Uluslararası Türk-İslam Araştırmaları Sempozyumu (25.04.2025 - 30.04.2025) · 1 Uluslararası',
        ['toplanti' => 'I. Uluslararası Türk-İslam Araştırmaları Sempozyumu']],
    'AVESİS bildiri: yer ve sayfa' => [Kategori::Bildiri, 'Uluslararası Kelam Kongresi, Mersin, Türkiye, 25 - 27 Nisan 2025, ss.12-20',
        ['toplanti' => 'Uluslararası Kelam Kongresi', 'yer' => 'Mersin, Türkiye', 'sayfa' => '12-20']],
    'APBS kitap, sistem dipnotu taşmaz' => [Kategori::Kitap, 'Yayın Evi: Akademisyen Yayınevi, Basım Sayısı: 1, ISBN: 9786052581568, Sayfa Sayısı: 160 · ŞAHİN EŞREF · Mersin Üniversitesi · --> · Bu sistemdeki veriler Yöksis, Doi.org, Web of Science, TRDizin den alınmaktadır. · Kitap',
        ['yayinevi' => 'Akademisyen Yayınevi', 'isbn' => '9786052581568', 'sayfa' => '160']],
    'kitap bölümü' => [Kategori::Kitap, 'Bölüm Adı: Erken Sufilik, Kitap Adı: Handbook of Sufism, Editör: J. Smith · Yayın Evi: Routledge, Sayfalar: 45-70',
        ['kitap_adi' => 'Handbook of Sufism', 'editor' => 'J. Smith', 'yayinevi' => 'Routledge', 'sayfa' => '45-70']],
    'gerçek AVESİS bildirisi: virgüllü kongre adı bölünmez' => [Kategori::Bildiri, 'International Learning, Teaching and Educational Research Congress, Türkiye, 6 - 08 Eylül 2018, (Özet Bildiri)',
        ['toplanti' => 'International Learning, Teaching and Educational Research Congress', 'yer' => 'Türkiye']],
    'gerçek AVESİS bildirisi: şehir ve ülke' => [Kategori::Bildiri, 'EJERCongress 2019, Ankara, Türkiye, 19 - 22 Haziran 2019, (Özet Bildiri)',
        ['toplanti' => 'EJERCongress 2019', 'yer' => 'Ankara, Türkiye']],
    'iki kelimelik parça şehir sanılmaz' => [Kategori::Bildiri, 'Education, Society, Reform Researc, Türkiye, 6 - 07 Nisan 2018, (Özet Bildiri)',
        ['toplanti' => 'Education, Society, Reform Researc', 'yer' => 'Türkiye']],
    'yersiz bildiri' => [Kategori::Bildiri, 'International Higher Education Studies, 12 - 14 Ekim 2017, (Özet Bildiri)',
        ['toplanti' => 'International Higher Education Studies']],
    'gerçek AVESİS makalesi (virgülden önce boşluk)' => [Kategori::Makale, 'Trakya Eğitim Dergisi , cilt.10, sa.1, ss.221-237, 2020 (TRDizin)',
        ['dergi' => 'Trakya Eğitim Dergisi', 'cilt' => '10', 'sayi' => '1', 'sayfa' => '221-237']],
    'gerçek AVESİS tezi: öğrenci (Öğrenci) işaretinden' => [Kategori::TezDanismanligi, 'Yönetilen Tezler · CAN G. (Danışman) H.Hakan(Öğrenci), Doktora, 2020',
        ['ogrenci' => 'H.Hakan']],
    'büyük harfli baş harfli ad: noktadan sonra da büyük' => [Kategori::TezDanismanligi, 'Yönetilen Tezler · CAN G. (Danışman) A.GÜL(Öğrenci), Yüksek Lisans, 2019',
        ['ogrenci' => 'A.Gül']],
    'APBS tez, büyük harf başlık harfine' => [Kategori::TezDanismanligi, 'FATMA SAV · MERSİN ÜNİVERSİTESİ - SOSYAL BİLİMLER ENSTİTÜSÜ - TEMEL İSLAM BİLİMLERİ ANABİLİM DALI · Yüksek Lisans',
        ['ogrenci' => 'Fatma Sav', 'universite' => 'Mersin Üniversitesi - Sosyal Bilimler Enstitüsü - Temel İslam Bilimleri Anabilim Dalı']],
    'APBS idari görev' => [Kategori::IdariGorev, 'İdari Görev · İlahiyat Fakültesi', ['kurum' => 'İlahiyat Fakültesi']],
    'boş künye' => [Kategori::Makale, '', []],
    'künye alanı olmayan kategori' => [Kategori::Atif, 'Dergi, vol. 1', []],
]);

test('ham künye alanlara ayrılır', function (Kategori $kategori, string $ham, array $beklenen) {
    expect(app(KunyeAyristirici::class)->ayristir($kategori, $ham))->toEqualCanonicalizing($beklenen);
})->with('ham künyeler');

test('ayrılan alanlar yalnız kategorinin künye anahtarları', function () {
    // Makale künyesi "yer" ya da "toplanti" üretmez.
    expect(array_keys(app(KunyeAyristirici::class)->ayristir(Kategori::Makale, 'Dergi, vol. 1, no. 2, pp. 3-4')))
        ->each->toBeIn(array_keys(Kategori::Makale->kunyeAlanlari()));
});

test('dergipark sayı etiketinden cilt ve sayı', function () {
    $a = app(KunyeAyristirici::class);

    expect($a->dergiParkSayisi('Yıl 2023, Cilt: 13 Sayı: 1'))->toBe(['cilt' => '13', 'sayi' => '1'])
        ->and($a->dergiParkSayisi('Cilt 5, Sayı 2/3'))->toBe(['cilt' => '5', 'sayi' => '2/3'])
        ->and($a->dergiParkSayisi('Özel Sayı'))->toBe([]);
});

test('veri migration\'ı mevcut kayıtları doldurur, elle girileni ezmez', function () {
    $makale = Faaliyet::factory()->create([
        'kategori' => Kategori::Makale,
        'meta' => ['kunye' => 'Bir Dergi, vol. 3, no. 4, pp. 5-6 · Ulusal', 'dergi' => 'Elle Düzeltilmiş Ad'],
    ]);

    $migration = require database_path('migrations/'.collect(scandir(database_path('migrations')))->first(fn ($f) => str_ends_with($f, 'ice_aktarilan_kunyeleri_ayristir.php')));
    $migration->up();

    expect($makale->refresh()->meta)->toMatchArray([
        'dergi' => 'Elle Düzeltilmiş Ad', 'cilt' => '3', 'sayi' => '4', 'sayfa' => '5-6',
    ]);
});

test('veri migration\'ı alt bilgiden alınmış yazar alanını boşaltır', function () {
    $kitap = Faaliyet::factory()->create([
        'kategori' => Kategori::Kitap,
        'yazarlar' => 'BAUM 2024 © Mersin Üniversitesi',
        'meta' => ['kunye' => 'Yayın Evi: Akademisyen Yayınevi, ISBN: 978 · Kitap'],
    ]);
    $saglam = Faaliyet::factory()->create([
        'kategori' => Kategori::Kitap, 'yazarlar' => 'Şahin, E.', 'meta' => ['kunye' => 'Yayın Evi: Fecr · Kitap'],
    ]);

    $migration = require database_path('migrations/'.collect(scandir(database_path('migrations')))->first(fn ($f) => str_ends_with($f, 'ice_aktarilan_kunyeleri_ayristir.php')));
    $migration->up();

    expect($kitap->refresh()->yazarlar)->toBeNull()
        ->and($kitap->meta['yayinevi'])->toBe('Akademisyen Yayınevi')
        ->and($saglam->refresh()->yazarlar)->toBe('Şahin, E.');
});
