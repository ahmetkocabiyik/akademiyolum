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

/**
 * AYNI CETVELDE AYNI ETİKETE DÜŞEN İKİ SATIRIN PUANI AYRIYSA BİLİNÇLİDİR.
 *
 * `MaddeKatalogu::puan()` eşleşen kodların EN YÜKSEĞİNİ alıyor. İki satır
 * aynı (kategori, kaynak, rol, tür) imzasını paylaşıp farklı puan taşıyorsa
 * düşük satır ÖLÜDÜR ve o etiketi taşıyan her kayıt yüksek satırın puanını
 * alır. Yüksek satır, etiketin taşıyamadığı bir kısıt taşıyorsa (program
 * kodu, ödülün türü, indeks listesi) bu doğrudan fazla saymadır (§0).
 *
 * 04.09.2026'da korpus taranıp altı cetvel düzeltildi:
 *   yalova-2024      1c (alan indeksi 8) ↔ 1ç (diğer indeks 5) — dipnottaki
 *                    ÜAK alan indeksi listesi kayıtta yok, etiket 1ç'de kaldı.
 *   sakarya-2026     TÜBİTAK program kodları: 2.3 ailesi 2.4'ün 80/20
 *                    kademesine indirildi (öbür fon aileleri zaten öyleydi).
 *   kafkas-2025      YU-c "yazılım üreticisi veya patent sahibi" satırı bütün
 *                    sınai hak etiketlerini taşıyordu; patent ve yazılıma
 *                    daraltıldı.
 *   istanbul-2026    "meslek başarı ödülü" satırları genel bilim/sanat ödülü
 *                    etiketini taşıyordu.
 *   pau-2023         torba `Diğer` etiketi iki satırdaydı.
 *   akdeniz-2026     `sosyal` varyantı 11.3 ile 11.4'ü birleştirdiği için üç
 *                    etiket çakışıyordu.
 *
 * Aşağıdaki liste ELDEN GEÇİRİLMİŞ çakışmalar: her birinde iki satır da
 * adayın aynı kaydına meşru biçimde uyuyor ve kaynağın kendi kuralı da "en
 * yükseği al" diyor. Isparta ÜBÜ'nün yirmi bir satırı özel bir durum: üç
 * tablosu farklı aday gruplarına ait ve barajlar `T1`/`T2`/`T3` gruplarına
 * bağlı, cetvelin tamamına değil.
 */
test('cetvel içi etiket çakışmaları elden geçirilmiş', function () {
    $depo = app(SartDeposu::class);
    $bulgu = [];

    foreach ($depo->cetveller() as $ad => $katalog) {
        $grup = [];

        foreach ($katalog->maddeler as $kod => $madde) {
            if (($madde['kaynaklar'] ?? []) === []) {
                continue;
            }

            $imza = implode('|', [
                $madde['kategori'] ?? '',
                implode(',', $madde['roller'] ?? []),
                implode(',', $madde['turler'] ?? []),
            ]);

            foreach ($madde['kaynaklar'] as $kaynak) {
                $grup["{$imza}|{$kaynak}"][] = [(string) $kod, $madde['puan'] ?? 0];
            }
        }

        foreach ($grup as $satirlar) {
            if (count(array_unique(array_column($satirlar, 1))) < 2) {
                continue;
            }

            usort($satirlar, fn (array $a, array $b): int => $b[1] <=> $a[1]);
            $dusuk = end($satirlar);
            $bulgu["{$ad}: {$satirlar[0][0]} > {$dusuk[0]}"] = true;
        }
    }

    $bulunan = array_keys($bulgu);
    sort($bulunan);

    expect($bulunan)->toBe([
        // Kaynağın 9. bölüm dipnotu: "Disipline özgü etkinlik ve faaliyetler
        // alanında aynı ödül alınmış ise YÜKSEK PUANI olan kategori dikkate
        // alınır." Motor zaten öyle davranıyor.
        'akdeniz-2026-mimarlik-docent: 9.3 > 11.2.3',
        'akdeniz-2026-mimarlik-dr: 9.3 > 11.2.3',
        'akdeniz-2026-mimarlik-profesor: 9.3 > 11.2.3',

        // Üç tablo, üç ayrı aday grubu; barajlar tablo gruplarına bağlı.
        'isparta-ubu-2022: A4-bolum > T1-K5',
        'isparta-ubu-2022: A4-kitap > T1-K3',
        'isparta-ubu-2022: A4-tez > T1-TEZ-B1',
        'isparta-ubu-2022: A5 > T1-B1',
        'isparta-ubu-2022: A5 > T1-B2',
        'isparta-ubu-2022: A5 > T1-B3',
        'isparta-ubu-2022: A5 > T1-B4',
        'isparta-ubu-2022: A5 > T1-B5',
        'isparta-ubu-2022: T1-K1 > A4-kitap',
        'isparta-ubu-2022: T1-K2 > A4-kitap',
        'isparta-ubu-2022: T1-K8 > A4-ceviri-kitap',
        'isparta-ubu-2022: T1-K9 > A4-ceviri-makale',
        'isparta-ubu-2022: T1-TEZ-A1 > A4-tez',
        'isparta-ubu-2022: T1-TEZ-A2 > A4-tez',
        'isparta-ubu-2022: T1-TEZ-A4 > A4-tez',
        'isparta-ubu-2022: T1-TEZ-A5 > A4-tez',
        'isparta-ubu-2022: T1-TEZ-K1 > A4-tez',
        'isparta-ubu-2022: T1-TEZ-K2 > A4-tez',
        'isparta-ubu-2022: T1-TEZ-K4 > A4-tez',
        'isparta-ubu-2022: T1-TEZ-K5 > A4-tez',
        'isparta-ubu-2022: T3-TEZ > T2-DA5',

        // Konservatuvar ekinin satırları etiketin birebir karşılığı
        // ("uluslararası SANAT ödülü" ↔ `Uluslararası Bilim/Sanat Ödülü`,
        // "yarışma ödülü" ↔ `Yarışma Derecesi / Mansiyon`); ortak tablonun
        // 9.i torba satırı da aynı etiketleri taşıyor ve düşük kalıyor.
        'istanbul-2026-konservatuvar: T2.7.a > 9.i',
        'istanbul-2026-konservatuvar: T2.7.d > 9.i',
        'istanbul-2026-konservatuvar: T2.7.e > 9.i',
        'istanbul-2026-mimarlik: T4.1.h > 9.i',

        // Mimarlık varyantında yarışma derecesi zaten mimarlık yarışmasıdır.
        'izmir-kavram-2025-mim: 16a > 7c',

        // Patent sahibi olan aday YU-c'yi de sağlıyor; kaynağın kendi kuralı
        // en yükseği almak. `Yazılım` kaydı da hem YU-c hem PT-c'ye uyuyor.
        'kafkas-2025-mimarlik: PT-a > YU-c',
        'kafkas-2025-mimarlik: PT-b > YU-c',
        'kafkas-2025-mimarlik: YU-c > PT-c',

        // Yüksek satır DAHA GENEL olan: "alanıyla ilgili etkinliklerde jüri
        // üyeliği" sanat yarışması jüriliğini de kapsıyor. Yüksek satırda
        // etiketin taşıyamadığı bir kısıt yok, dolayısıyla fazla sayma yok.
        'trakya-2025-ek6: 17m-n > 14ab-u',
        'trakya-2025-ek6: 17o > 14ab-n',
        'trakya-2025-ek7: 7f-sos > 17a2',
    ]);
});

/**
 * ÖLÜ SATIR TARAMASI: HİÇBİR KAYDIN UYAMAYACAĞI MADDELER BİLİNÇLİDİR.
 *
 * `MaddeKatalogu::maddeyeUyar()` `isset` ile bakıyor: anahtarın HİÇ OLMAMASI
 * "bu alanı filtreleme" demek, BOŞ DİZİ ise "hiçbir değere uyma" demek. Yani
 * `'kaynaklar' => []` satırı sessizce ölü — ne test kırılır ne uyarı çıkar.
 *
 * Ölü satır çoğu zaman KASITLI ve §0'ın gereği: kaynak bir kademeyi
 * sözlüğün taşıyamadığı bir eksende ayırıyorsa etiket ALT kademede bırakılır,
 * üst satır belgelemek için puanıyla durur ama etiketsiz kalır (Akdeniz'in
 * "ilk %10" ve "ESCI" satırları, Yalova'nın alan indeksi satırı). Kasıtsız
 * olduğunda ise adayın hak ettiği puanı sessizce yutar.
 *
 * 04.09.2026'da korpus üç ölüm biçimi için tarandı:
 *   A) boş `kaynaklar`/`roller`/`turler` — 53 satır, 6 farklı; hepsi kasıtlı.
 *   B) tavanı 0 olan grubun içindekiler — 15 (grup, cetvel) çifti; hepsi
 *      kasıtlı (MEF'in mimarlık satırları öbür alanlarda, İKÇÜ'nün tez
 *      yayını bölümü doçentlik ve profesörlükte, SBÜ'nün D bölümü Dr. Öğr.
 *      Üyesi kadrosunda).
 *   C) hiçbir eşiğin şart ağacında geçmeyenler — 33 cetvelde 756 satır ve
 *      hepsi tasarım gereği: dokuz cetvelin eşiklerinde PUAN DÜĞÜMÜ YOK
 *      (barajlar adet üzerinden), kalanlarda da baraj kaynağın kendi bölüm
 *      kümesine bağlı (OMÜ'de A grubu 1-14, B grubu 1-15; İTÜ'de yalnız
 *      ESER-PUANI; Giresun'da A-L; Rumeli'de 1.5 ve 1.7 hariç). C sınıfı bu
 *      yüzden teste bağlanmadı — kural değil, cetvelin şekli.
 */
test('ölü satırlar ve sıfır tavanlar bilinçli', function () {
    $depo = app(SartDeposu::class);
    $bos = [];
    $sifirTavan = [];

    foreach ($depo->cetveller() as $ad => $katalog) {
        foreach ($katalog->maddeler as $kod => $madde) {
            foreach (['kaynaklar', 'roller', 'turler'] as $alan) {
                if (array_key_exists($alan, $madde) && $madde[$alan] === []) {
                    $bos["{$kod} · ".($madde['baslik'] ?? '')] = true;
                }
            }
        }

        foreach ($katalog->grupTavanlari as $grup => $tavan) {
            if ($tavan === 0) {
                $sifirTavan["{$ad}: {$grup}"] = true;
            }
        }
    }

    $bosSatirlar = array_keys($bos);
    sort($bosSatirlar);

    // Her birinin gerekçesi kendi cetvel dosyasında yazılı.
    expect($bosSatirlar)->toBe([
        '1.1 · SCI-Expanded/SSCI/AHCI ilk %10 dergide makale',
        '1.6 · ESCI dergide makale',
        '1c · Diğer uluslararası alan indekslerinde taranan dergide makale',
        'A.16a · Millî takımlarda görev almak ya da antrenör ve hakem eğitim kurslarında eğitici olarak görev almak',
        'T4.1.a · Uluslararası meslek başarı ödülü',
        'T4.1.b · Ulusal meslek başarı ödülü',
    ]);

    $sifirlar = array_keys($sifirTavan);
    sort($sifirlar);

    expect($sifirlar)->toBe([
        // İKÇÜ: tez yayını bölümü yalnız Dr. Öğr. Üyesi kadrosunda sayılıyor.
        'ikcu-2023-sosyal-docent: A2',
        'ikcu-2023-sosyal-profesor: A2',

        // MEF: 13. bölüm (mimarlık yarışması ve kamu yararı projesi) yalnız
        // mimarlık alanında sayılıyor.
        'mef-2024-egitim-docent: 13',
        'mef-2024-egitim-dr: 13',
        'mef-2024-egitim-profesor: 13',
        'mef-2024-hukuk-docent: 13',
        'mef-2024-hukuk-dr: 13',
        'mef-2024-hukuk-profesor: 13',
        'mef-2024-muhendislik-docent: 13',
        'mef-2024-muhendislik-dr: 13',
        'mef-2024-muhendislik-profesor: 13',
        'mef-2024-sosyal-docent: 13',
        'mef-2024-sosyal-dr: 13',
        'mef-2024-sosyal-profesor: 13',

        // SBÜ: YÖK'ün 27/11/2025 kararı D bölümünü profesör ve doçentle
        // sınırladı.
        'sbu-2025-dr: D',
    ]);
});
