<?php

use App\Enums\Kategori;
use App\Services\Scoring\Sart\SartDeposu;

/**
 * CETVEL SATIRLARININ KAYNAK ETİKETLERİNİ SÖZLÜĞE KARŞI DOĞRULAR.
 *
 * Bir cetvel satırı `kategori` + `kaynaklar` çiftiyle faaliyet kaydına
 * bağlanır. Etiket o kategorinin sözlüğünde YOKSA satır hiçbir faaliyetle
 * eşleşmez: aday puanı hak ettiği hâlde sıfır görür, üstelik hiçbir yerde
 * hata çıkmaz. En sinsi hata sınıfı — sessizce yanlış cevap verir.
 *
 * 31.08.2026'da yapılan ilk taramada 63 eşleşmeyen etiket bulundu. Otuzu
 * satırın TEK kaynağıydı, yani o satırlar tamamen ölüydü:
 *
 *   "Kitap Editörlüğü" `kitap` kategorisinde   → etiket `editorluk`e ait,
 *                                                 satırın kategorisi düzeltildi
 *   "Kongre Düzenleme (Uluslararası)"          → sözlükte hiç yok, uydurulmuş;
 *                                                 satır kaldırıldı
 *   "Diğer Hakemli Dergi" `makale`de           → `Diğer Uluslararası İndeks`
 *
 * Kalan 33'ü satırda doğru etiketin YANINDA duruyordu (ör. ['BKCI Kitap',
 * 'BKCI / Scopus Kitap']) — satır çalışıyordu ama fazlalık yanıltıcıydı,
 * temizlendi.
 *
 * Yeni bir kaynak etiketi gerekiyorsa yol sözlüğü GENİŞLETMEK
 * (App\Enums\Kategori), cetvelde uydurmak değil. Genişletemiyorsan satırı
 * hiç yazma ve cetvelin `kapsam_notu`na sebebini yaz — §0 gereği eksik
 * saymak fazla saymaktan iyidir.
 */
test('cetvel kaynakları kategori sözlüğünde var', function () {
    $sozluk = [];

    foreach (Kategori::cases() as $kategori) {
        foreach ($kategori->kaynaklar() as $kaynak) {
            $sozluk[$kategori->value][$kaynak] = true;
        }
    }

    $sizinti = [];

    foreach (app(SartDeposu::class)->cetveller() as $ad => $katalog) {
        foreach ($katalog->maddeler as $kod => $madde) {
            $kategori = $madde['kategori'] ?? null;

            if ($kategori === null) {
                continue;
            }

            foreach ($madde['kaynaklar'] ?? [] as $kaynak) {
                if (isset($sozluk[$kategori][$kaynak])) {
                    continue;
                }

                // Etiket başka bir kategoride varsa satırın `kategori`si
                // yanlış; hiçbirinde yoksa etiket uydurulmuş.
                $baska = array_keys(array_filter(
                    $sozluk,
                    fn (array $liste): bool => isset($liste[$kaynak]),
                ));

                $sizinti[] = "{$ad} · {$kod} ({$kategori}): \"{$kaynak}\" — "
                    .($baska === [] ? 'sözlükte hiç yok' : 'aslında '.implode(', ', $baska));
            }
        }
    }

    expect($sizinti)->toBe([]);
});

/**
 * GRUP DESENLERİNİN GERÇEKTEN BİR ŞEYE UYDUĞUNU DOĞRULAR.
 *
 * Gruplar üyelerini üç biçimde yazabiliyor: tam kod ('A.1'), önek deseni
 * ('A.1*') ve aralık ('A.1..A.4'). Önek deseni hiçbir koda uymuyorsa grup
 * SESSİZCE BOŞ kalır; ona bağlı baraj ya hiç sağlanamaz ya da sıfır puanla
 * sağlanmış sayılır. Yazım hatası tam bu yolla kaybolur ('A1.*' yazılıp
 * kodlar 'A.1.*' iken).
 *
 * TAM KOD üyeleri bu testin dışında: Yalova gibi cetveller ortak bir grup
 * tanımını birden çok varyantta kullanıyor ve varyantlar bazı kodları
 * siliyor. Orada eksik kod TASARIM GEREĞİ — motor bulamadığını saymıyor.
 * Desen ise başka: hiçbir koda uymayan desen her zaman hatadır.
 *
 * İlk taramada tek bulgu Fırat'ın 'B1-B3' grubuydu; B3 (ulusal bilimsel
 * toplantılar) bölümü hiç girilmemişti.
 */
test('grup desenleri en az bir maddeye uyuyor', function () {
    $sizinti = [];

    foreach (app(SartDeposu::class)->cetveller() as $ad => $katalog) {
        $kodlar = array_map(strval(...), array_keys($katalog->maddeler));

        foreach ($katalog->gruplar as $grup => $uyeler) {
            foreach ((array) $uyeler as $uye) {
                $uye = (string) $uye;

                if ($uye !== '*' && str_ends_with($uye, '*')) {
                    $onek = rtrim($uye, '*');

                    if (array_filter($kodlar, fn (string $k): bool => str_starts_with($k, $onek)) === []) {
                        $sizinti[] = "{$ad} · {$grup}: \"{$uye}\" hiçbir madde koduna uymuyor";
                    }
                }

                if (str_contains($uye, '..')) {
                    [$bas, $son] = explode('..', $uye, 2);

                    if (! in_array($bas, $kodlar, true) || ! in_array($son, $kodlar, true)) {
                        $sizinti[] = "{$ad} · {$grup}: \"{$uye}\" aralığının ucu cetvelde yok";
                    }
                }
            }
        }
    }

    expect(array_values(array_unique($sizinti)))->toBe([]);
});

/**
 * `turler` ve `roller` değerlerinin sözlükte olduğunu doğrular.
 *
 * Kaynak etiketiyle aynı sessiz hata: cetvel satırı 'turler' => ['derleme']
 * yazıyorsa ve kategori o türü tanımıyorsa satır hiçbir faaliyetle eşleşmez.
 * Tanınan değerler Kategori::yayinTurleri() ve Kategori::roller()'da.
 */
test('cetvel tür ve rol değerleri sözlükte var', function () {
    $turler = [];
    $roller = [];

    foreach (Kategori::cases() as $kategori) {
        $turler[$kategori->value] = array_keys($kategori->yayinTurleri());
        $roller[$kategori->value] = array_keys($kategori->roller());
    }

    $sizinti = [];

    foreach (app(SartDeposu::class)->cetveller() as $ad => $katalog) {
        foreach ($katalog->maddeler as $kod => $madde) {
            $kategori = $madde['kategori'] ?? null;

            if ($kategori === null) {
                continue;
            }

            foreach ($madde['turler'] ?? [] as $tur) {
                if (! in_array($tur, $turler[$kategori] ?? [], true)) {
                    $sizinti[] = "{$ad} · {$kod} ({$kategori}): tür \"{$tur}\" tanınmıyor";
                }
            }

            foreach ($madde['roller'] ?? [] as $rol) {
                if (! in_array($rol, $roller[$kategori] ?? [], true)) {
                    $sizinti[] = "{$ad} · {$kod} ({$kategori}): rol \"{$rol}\" tanınmıyor";
                }
            }
        }
    }

    expect(array_values(array_unique($sizinti)))->toBe([]);
});

/**
 * AKREDİTASYON FAALİYETİ DERS SATIRINDA DURMAZ.
 *
 * `Akreditasyon Faaliyeti`, `egitim_ogretim` kategorisinin ders DIŞI
 * etiketi: kurumsal akreditasyon kurullarında görev almak, eğitim-öğretim
 * danışmanlığı, eğitici eğitimi. Ders vermek değil.
 *
 * 02.09.2026'ya kadar korpusun 59 cetvelinde ders satırlarının etiket
 * listesine sızmıştı — kaynaklarının ellisi "akredit" sözcüğünü hiç
 * geçirmiyordu, yani okunan bir şey değil kopyalanan bir liste parçasıydı.
 * Zarar puanda küçük ama SAYIDA tam: `SartDegerlendirici::adet()` puana
 * bakmadan faaliyet saydığı için akreditasyon kaydı olan aday "bir dönem
 * ders vermiş olmak" koşulunu sağlamış görünüyordu.
 *
 * Kural: bir satır ders etiketlerinden birini taşıyorsa akreditasyon
 * etiketleriyle aynı listede olamaz. Kaynak akreditasyonu puanlıyorsa
 * KENDİ SATIRI açılır (14 cetvelde öyle duruyor).
 *
 * 04.09.2026'da eklenen dar etiket `Akreditasyon Kurulu Görevi` de aynı
 * kurala tabi: o da bir ders değil, kurulda görev.
 */
test('akreditasyon etiketi ders satırlarında değil', function () {
    $depo = app(SartDeposu::class);
    $ders = ['Lisansüstü Ders', 'Lisans/Önlisans Ders', 'Yabancı Dilde Ders', 'Değişim Programı Dersi'];
    $akreditasyon = ['Akreditasyon Faaliyeti', 'Akreditasyon Kurulu Görevi'];
    $sizinti = [];

    foreach ($depo->cetveller() as $ad => $katalog) {
        foreach ($katalog->maddeler as $kod => $madde) {
            $kaynaklar = $madde['kaynaklar'] ?? [];

            if (array_intersect($akreditasyon, $kaynaklar) === []) {
                continue;
            }

            $cakisan = array_intersect($ders, $kaynaklar);

            if ($cakisan !== []) {
                $sizinti[] = "{$ad} {$kod}: ".implode(', ', $cakisan);
            }
        }
    }

    expect(array_values(array_unique($sizinti)))->toBe([]);
});

/**
 * ÖLÜ TAVAN: HİÇBİR MADDEYE DÜŞMEYEN `grup_tavanlari` ANAHTARI.
 *
 * `grup_tavanlari` anahtarı `coz()` ile çözülüyor; anahtar bir grup adı,
 * bir madde kodu ya da bir desen olabilir. Üçü de değilse tavan HİÇBİR
 * maddeye düşmez ve sessizce yok sayılır: motor patlamaz, test kırılmaz,
 * yalnız bölüm tavansız kalır ve fazla sayar (§0 ihlali).
 *
 * Aynı sınıfın ikinci hâli daha sinsi: anahtar bir GRUP değil TEK MADDE
 * olduğunda tavan yazılmış görünür ama yalnız o satırı keser. Ege'de
 * "Bu kategoride en çok 75 puan alınır" tavanı `'7a-Q1' => 75` diye
 * duruyordu; Q2, Q3 ve Q4 editörlükleri sınırsız sayılıyordu. Testin
 * ikinci beklentisi bu yüzden tek maddeye düşen tavanları RAPORLUYOR —
 * hata saymıyor, çünkü kaynak gerçekten tek satırı sınırlıyor olabilir
 * (Ardahan'ın "* Azami N puan" notları, MSGSÜ'nün adet tavanları); yeni
 * bir tanesi eklendiğinde listeye yazılması, kapsamının bilerek
 * seçildiğini gösterir. Tavanı `gruplar` içinde AÇIKÇA tanımlanmış tek
 * maddelik kümeler (AYBÜ'nün AO.g-AO.s satırları gibi) listeye girmez:
 * grubun kendisi kapsamın bilinçli olduğunu zaten söylüyor, tercih edilen
 * biçim budur.
 */
test('hiçbir grup tavanı ölü değil ve tek maddeye düşenler bilinçli', function () {
    $depo = app(SartDeposu::class);
    $olu = [];
    $tekMadde = [];

    foreach ($depo->cetveller() as $ad => $katalog) {
        foreach ($katalog->grupTavanlari as $grup => $tavan) {
            $kodlar = $katalog->coz([(string) $grup]);

            if ($kodlar === []) {
                $olu[] = "{$ad}: '{$grup}' => {$tavan} hiçbir maddeye düşmüyor";

                continue;
            }

            if (! isset($katalog->gruplar[$grup]) && count($kodlar) === 1) {
                $tekMadde[] = "{$ad}: {$grup}";
            }
        }
    }

    expect($olu)->toBe([]);

    // Tek maddeye düşen tavanların bilinen listesi; hepsinde kaynak
    // gerçekten TEK SATIRI sınırlıyor ve gerekçesi cetvel dosyasında yazılı.
    expect($tekMadde)->toBe([
        'aksaray-2024: H-DERS',
        'ardahan-2026: 3.3.12',
        'ardahan-2026: 3.3.13',
        'ardahan-2026: 3.3.15',
        'ardahan-2026: 3.11.6',
        'ardahan-2026: 3.13.11',
        'ardahan-2026: 3.13.12',
        'ardahan-2026: 4.1.13',
        'ardahan-2026: 4.1.14',
        'ardahan-2026: 4.1.16',
        'ardahan-2026: 4.9.5',
        'gazi-2024: Ta',
        'igdir-2023: 10.b',
        'igdir-2023: 11.b',
        'igdir-2023: 12.b',
        'mef-2024-mimarlik-dr: 2.b',
        'mef-2024-mimarlik-dr: 2.c',
        'mef-2024-mimarlik-docent: 2.b',
        'mef-2024-mimarlik-docent: 2.c',
        'mef-2024-mimarlik-profesor: 2.b',
        'mef-2024-mimarlik-profesor: 2.c',
        'mersin-2024: 2g',
        'mersin-2024: 2h',
        'tokat-gaziosmanpasa-2026: 1.5.c',
        'tokat-gaziosmanpasa-2026: 1.6.b',
        'tokat-gaziosmanpasa-2026: 1.6.ç',
        'tokat-gaziosmanpasa-2026: 1.6.d',
        'tokat-gaziosmanpasa-2026: 1.6.e',
        'tokat-gaziosmanpasa-2026: 2.1.a',
        'tokat-gaziosmanpasa-2026: 2.1.b',
    ]);
});

/**
 * GRUP TAVANININ ÜSTÜNDE BARAJ = SAĞLANAMAZ EŞİK.
 *
 * Motor grup tavanını `topla()` içinde uyguluyor, yani bir koşulu ÖLÇERKEN
 * de: tavanı 100 olan bir gruptan 300 puan isteyen koşul hiçbir zaman
 * sağlanamaz. Aday "asla yeterli değilsiniz" cevabı alır ve sebebini göremez.
 *
 * Bu genelde kaynaktaki çelişkiden doğuyor: yönergenin gövdesi tablonun kendi
 * tavanından yüksek bir baraj istiyor (ESOGÜ atıflardan 300/500 isterken atıf
 * bölümü "en fazla 100" diyor; İzmir Kâtip Çelebi EK-B eğitim öğretimden 12
 * isterken aynı dipnot "en fazla 10" diyor). KONVANSIYONLAR "Sağlanamaz eşik
 * yazma" uyarınca ulaşılabilir en sıkı değer — tavanın kendisi — yazılır ve
 * çelişki `notlar` ile `aday_notu`'na birebir aktarılır.
 *
 * Test yalnız TEK gruba bağlı puan koşullarını sınıyor; birden çok grubu
 * toplayan koşulda tavanlar birbirini tamamlayabilir.
 */
test('hiçbir puan barajı grup tavanının üstünde değil', function () {
    $depo = app(SartDeposu::class);
    $cetveller = $depo->cetveller();
    $sizinti = [];

    $gez = function (array $dugum, callable $bak) use (&$gez): void {
        $bak($dugum);

        foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
            $gez($cocuk, $bak);
        }
    };

    foreach ($depo->esikler() as $esik) {
        $katalog = $cetveller[$esik['cetvel']] ?? null;

        if ($katalog === null || $katalog->grupTavanlari === []) {
            continue;
        }

        $gez($esik['sart'], function (array $dugum) use (&$sizinti, $esik, $katalog): void {
            if (($dugum['tip'] ?? null) !== 'puan' || ! isset($dugum['min_puan'])) {
                return;
            }

            $maddeler = $dugum['maddeler'] ?? [];

            if (count($maddeler) !== 1) {
                return;
            }

            $grup = (string) $maddeler[0];
            $tavan = $katalog->grupTavanlari[$grup] ?? null;

            if ($tavan !== null && $tavan < $dugum['min_puan']) {
                $sizinti[] = "{$esik['anahtar']} [{$esik['cetvel']}] {$grup}: "
                    ."baraj {$dugum['min_puan']} > tavan {$tavan}";
            }
        });
    }

    expect(array_values(array_unique($sizinti)))->toBe([]);
});

/**
 * `yazar_katsayisi.kategoriler` yazılmışsa o kategori `haric`te OLMAMALI.
 *
 * İkisi birden yazılırsa `haric` kazanır ve kategori kuralı sessizce
 * yok sayılır — çok yazarlı esere tam puan verilir, yani FAZLA SAYILIR (§0).
 * Bu çelişki gözle fark edilmiyor çünkü iki liste dosyanın ayrı yerlerinde.
 */
test('yazar katsayısı yapılandırması tutarlı', function () {
    $gecerli = array_map(fn (Kategori $k): string => $k->value, Kategori::cases());
    $sizinti = [];

    foreach (app(SartDeposu::class)->cetveller() as $ad => $katalog) {
        $katsayi = $katalog->yazarKatsayisi;

        if ($katsayi === null) {
            continue;
        }

        // `haric` düz bir kategori listesi olmalı. Bir alt dizi buraya
        // düşerse (ör. `kategoriler` bloğu yanlış girintiyle içeri kayarsa)
        // o blok SESSİZCE yok sayılır: `$katsayi['kategoriler']` tanımsız
        // kalır, çarpan uygulanmaz ve çok yazarlı esere tam puan verilir.
        // Bu tam olarak bir kez oldu (Bolu AİBÜ ve Bitlis).
        foreach ($katsayi['haric'] ?? [] as $anahtar => $uye) {
            if (! is_string($uye) || ! in_array($uye, $gecerli, true)) {
                $sizinti[] = "{$ad}: `haric` içinde kategori olmayan üye (".var_export($anahtar, true).')';

                continue;
            }
        }

        foreach (array_keys($katsayi['kategoriler'] ?? []) as $kategori) {
            if (! in_array($kategori, $gecerli, true)) {
                $sizinti[] = "{$ad}: `kategoriler` içinde tanınmayan kategori \"{$kategori}\"";
            }

            if (in_array($kategori, $katsayi['haric'] ?? [], true)) {
                $sizinti[] = "{$ad}: \"{$kategori}\" hem `kategoriler`de hem `haric`te";
            }
        }
    }

    expect(array_values(array_unique($sizinti)))->toBe([]);
});

test('dosya başlıklarındaki kaynak PDF adları gerçekten var', function () {
    // Yanlış bir kaynak adı sessiz: motor okumaz, test kırılmaz, ama bir
    // değeri doğrulamak isteyen "dosya yok" alır ve satırı "okunamadı" diye
    // bırakır. Bayburt, Kilis, Hatay ve Osmaniye'de tam bu olmuştu.
    $kok = dirname(__DIR__, 2);
    $eksik = [];

    foreach (glob("{$kok}/database/data/{cetvel,yonerge}/*.php", GLOB_BRACE) as $dosya) {
        $basi = substr((string) file_get_contents($dosya), 0, 4000);
        preg_match_all('#pdf/([^\s)\'"]+\.pdf)#u', $basi, $eslesme);

        foreach (array_unique($eslesme[1]) as $ad) {
            if (! is_file("{$kok}/pdf/{$ad}")) {
                $eksik[] = basename($dosya).' → pdf/'.$ad;
            }
        }
    }

    expect($eksik)->toBe([]);
});
