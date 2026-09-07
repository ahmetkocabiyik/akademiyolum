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
        // Siirt 13.c (10) ile 13.d (4) aynı etiketlere düşüyor; etiketler en
        // düşük kademeye taşındı, bu satır belgelemek için duruyor.
        // Selçuk 11e/12e: koordinatörlük etiketi bir alt kademeye (koordinatör
        // yardımcılığı, 10) indi; üst satır belgelemek için duruyor.
        '11e · Rektörlüğe bağlı ofis/koordinatörlükte koordinatör',
        '12e · Rektörlüğe bağlı ofis/koordinatörlükte koordinatör',
        '13.c · Meslek odaları ya da bilimsel amaçlı vakıflar tarafından verilen ödül',
        // Trakya'nın altı eki bu kodu şart ağacında anıyor; satır belgelemek
        // için duruyor ama etiketsiz: senato/yönetim kurulu üyeliği 07.09.2026'da
        // kapsam dışına alındı.
        '13d-yk · Yönetim kurulu üyeliği',
        '14d-yk · Yönetim kurulu üyeliği',
        '15d-yk · Yönetim kurulu üyeliği',
        '19d-yk · Yönetim kurulu üyeliği',
        '1c · Diğer uluslararası alan indekslerinde taranan dergide makale',
        '4d-yk · Yönetim kurulu üyeliği',
        '5d-yk · Yönetim kurulu üyeliği',
        'A.16a · Millî takımlarda görev almak ya da antrenör ve hakem eğitim kurslarında eğitici olarak görev almak',
        // Muş Alparslan E bölümü: "Sadece Devlet Konservatuarı için
        // geçerlidir" — o üniversitede güzel sanatlar eşiği hiç yok.
        'E1.1 · Sahne yapıtı ya da senfonik yapıt',
        'E1.3 · Sanat etkinliklerinde bireysel icracı olarak yer almak (solo konser, dinleti, resital)',
        'E1.4 · Sanat etkinliklerinde karma ya da eşlikçi olarak yer almak',
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

/**
 * C SINIFI: HİÇBİR BARAJIN SAYMADIĞI SATIRLAR.
 *
 * Bir madde ölmenin üçüncü biçimi, kayda uymamak değil KOŞULA GİRMEMEKTİR:
 * cetvelde durur, faaliyet listesinde puanı da görünür, ama hiçbir eşiğin
 * şart ağacı onu içeren bir grup anmaz. Aday o kalemi girer, sonuç değişmez.
 *
 * Bu çoğu zaman kaynağın kendi tercihidir — baraj "1-14 kategorilerinden"
 * ya da "A-L bölümlerinden" der ve kalan bölümler barajın dışındadır. Ama
 * SESSİZ bir hata biçimi de aynı desene düşüyor: grup deseni eksik yazılınca
 * ya da yeni bir bölüm girilip gruba eklenmeyince satır kimseye görünmeden
 * kapsam dışı kalır. İkisini ayıran şey listenin kendisi; bu yüzden liste
 * teste bağlandı.
 *
 * İki ayrı liste var, çünkü iki ayrı sebep var:
 *   BARAJSIZ CETVEL — eşiklerinde HİÇ `puan` düğümü yok, barajlar `adet` ve
 *       `metrik` üzerinden kurulu. O cetvelin bütün satırları tanımı gereği
 *       dışarıda; sayı vermek anlamsız.
 *   BARAJ VAR, SATIR DIŞARIDA — sayı veriliyor. Değişince kaynağa dönüp
 *       hangi bölümün barajın dışında olduğunu doğrula.
 *
 * Tarama 04.09.2026'da yapıldı; listedeki her satırın gerekçesi ya kaynak
 * metinden ya da cetvelin kendi grup adından doğrulandı. Gruplar kaynağın
 * ifadesini birebir taşıyor: OMÜ'de `1-14` ve `1-15`, İTÜ'de `ESER-PUANI`,
 * Giresun'da `A-L`, İKÇÜ'de "1., 2., 3., 4. ve 7. maddeler", Yalova'da
 * `1-2-3-4-5-8`, Rumeli'de 1.5 ve 1.7 hariç bölüm toplamı.
 *
 * Testi kırdıran iki değişiklik türü var ve ikisi de gözden geçirilmeli:
 * bir grup deseni daraltılmış (satırlar sessizce barajın dışına düşer) ya da
 * yeni bir bölüm girilip hiçbir gruba eklenmemiş. Enjeksiyonla doğrulandı:
 * Rumeli'nin TOPLAM grubundan `8.*` desenini düşürmek testi kırıyor.
 */
test('hiçbir barajın saymadığı satırlar bilinçli', function () {
    $depo = app(SartDeposu::class);
    $cetveller = $depo->cetveller();

    /** @var array<string, array{kodlar: array<string, true>, puanDugumu: bool}> $kapsam */
    $kapsam = [];

    $gez = function (array $dugum, $katalog, array &$kodlar, bool &$puanDugumu) use (&$gez): void {
        if (($dugum['tip'] ?? null) === 'puan') {
            $puanDugumu = true;
        }

        foreach (['maddeler', 'oran_payda'] as $alan) {
            if (isset($dugum[$alan])) {
                foreach ($katalog->coz($dugum[$alan]) as $kod) {
                    $kodlar[$kod] = true;
                }
            }
        }

        foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
            $gez($cocuk, $katalog, $kodlar, $puanDugumu);
        }
    };

    foreach ($depo->esikler() as $esik) {
        $katalog = $cetveller[$esik['cetvel']] ?? null;

        if ($katalog === null) {
            continue;
        }

        $kapsam[$esik['cetvel']] ??= ['kodlar' => [], 'puanDugumu' => false];
        $gez($esik['sart'], $katalog, $kapsam[$esik['cetvel']]['kodlar'], $kapsam[$esik['cetvel']]['puanDugumu']);
    }

    $barajsiz = [];
    $disarida = [];

    foreach ($kapsam as $ad => $bilgi) {
        $tumu = array_keys($cetveller[$ad]->maddeler);
        $disi = array_values(array_filter($tumu, fn (string $kod): bool => ! isset($bilgi['kodlar'][$kod])));

        if ($disi === []) {
            continue;
        }

        if (! $bilgi['puanDugumu']) {
            $barajsiz[] = $ad;

            continue;
        }

        $disarida[] = "{$ad}: ".count($disi).'/'.count($tumu);
    }

    sort($barajsiz);
    sort($disarida);

    // Eşiklerinde hiç puan barajı olmayan cetveller: koşullar `adet` ve
    // `metrik` üzerinden kurulu, dolayısıyla hiçbir satır barajı beslemiyor.
    expect($barajsiz)->toBe([
        'adiyaman-2024',            // doçentlik yalnız ÜAK unvanını istiyor
        'bartin-2022',
        'ikcu-2023-sosyal-docent',
        'kadir-has-turler',
        'manisa-cbu-2024',
        'mef-2024-egitim-dr',
        'mef-2024-hukuk-dr',
        'mef-2024-mimarlik-dr',
        'mef-2024-muhendislik-dr',
        'mef-2024-sosyal-dr',
        'sakarya-ubu-2024',
        'vanyyu-2019',
        'yeditepe-2024',
    ]);

    // Sayı DEĞİŞİRSE kaynağa dön: hangi bölümün barajın dışında olduğunu
    // doğrula, sonra listeyi güncelle. Aşağıdakilerin hepsi 04.09.2026'da
    // kaynağa karşı okundu.
    expect($disarida)->toBe([
        // "1. maddeden" barajları; 4-7. bölümler (ödül, idari görev, hizmet)
        // hiçbir koşulun kümesinde değil.
        'ankara-2023: 21/68',

        // Yalnız EG5 (yarıyıl başına 1 puanlık ders) dışarıda; `PUAN` grubu
        // ders satırlarını kapsamıyor.
        'erzincan-2021: 1/112',

        // Toplam baraj A-L; M (ödüller, idari görevler) ile N (patent)
        // kaynağın kendi ifadesiyle barajın dışında.
        'giresun-2019: 8/59',

        // EK-A/3: "1., 2., 3., 4. ve 7. maddelerden en az 50 puan." Proje,
        // tez danışmanlığı ve ders bölümleri barajın dışında; 40/80/120/160
        // puanlık YENİDEN ATANMA merdiveni ise `aday_notu`'nda.
        'ikcu-2023-sosyal-dr: 24/59',

        'istanbul-aydin-2020: 17/54',

        // İTÜ'nün BÜTÜN koşulları ESER-PUANI grubuna bağlı ve grubun içeriği
        // birime göre değişiyor. Dosya başlığındaki "uygulanamayan sınırlar"
        // notu da buna dayanıyor: idari görev tavanının yazılamaması barajı
        // şişirmiyor, çünkü o satırlar zaten hiçbir koşulda yok.
        'itu-2022-hs: 18/44',
        'itu-2022-mf: 22/48',
        'itu-2022-moda: 26/51',
        'itu-2022-tmdk: 20/52',
        'itu-2022: 32/44',

        // OMÜ Madde 11-13: A grubu 1-14, B grubu 1-15 kategorilerinden
        // toplanıyor; 16. bölüm (sanatsal etkinlik) ikisinde de barajın
        // dışında, yalnız güzel sanatlar (C) 1-16'yı sayıyor ve orada
        // dışarıda satır kalmıyor. 15. bölüm (görsel etkinlikler) kaynakta
        // İletişim Fakültesine özgü olduğu için yalnız `b` (sosyal)
        // varyantında var; `a`, `bx` ve `c` varyantlarında satırları hiç
        // yazılmıyor, o yüzden onların toplamı 101 değil 97.
        'omu-2025-a-doc: 17/99',
        'omu-2025-a-dr: 17/99',
        'omu-2025-a-prof: 17/99',
        'omu-2025-b-doc: 17/103',
        'omu-2025-b-dr: 17/103',
        'omu-2025-b-prof: 17/103',
        'omu-2025-bx-doc: 17/99',
        'omu-2025-bx-dr: 17/99',
        'omu-2025-bx-prof: 17/99',

        // Bölüm toplamı "1.1; 1.2; 1.3; 1.4; 1.6" diye sınırlı; 1.5
        // (hakemlik) ve 1.7 (atıf) ayrı raporlanıyor.
        'rumeli-2024: 5/50',

        // EK-3 YBF'nin tek puan koşulu danışmanlık ağırlıklarına bağlı.
        'sabanci-turler: 13/21',

        // Baraj "1, 2, 3, 4, 5 ve 8. maddeler" kümesine bağlı.
        'yalova-2024-mimarlik-a50: 26/61',
        'yalova-2024-sosyal-a50: 21/56',
    ]);
});

/**
 * DIŞ KURULUŞ VE SPOR FEDERASYONU ETİKETLERİ ÖLÜ KALMASIN.
 *
 * Etiketler 06.09.2026'da eklendi ve korpusa yayıldı. Bir etiketi sözlüğe
 * ekleyip hiçbir cetvele yazmamak, adayın o kaydı girip sıfır almasıyla
 * sonuçlanır — sessiz ve ölçülmeyen bir kayıp. Bu test etiketlerin gerçekten
 * kullanıldığını ve iki ailenin ayrı kaldığını koruyor.
 */
test('yeni kurul etiketleri korpusta karşılık buluyor', function () {
    $depo = app(SartDeposu::class);
    $sayim = [
        'Dış Kuruluş Kurul Üyeliği (Uluslararası)' => 0,
        'Dış Kuruluş Kurul Üyeliği (Ulusal)' => 0,
        'Spor Federasyonu Kurul Üyeliği (Uluslararası)' => 0,
        'Spor Federasyonu Kurul Üyeliği (Ulusal)' => 0,
    ];

    foreach ($depo->cetveller() as $katalog) {
        foreach ($katalog->maddeler as $madde) {
            foreach ($madde['kaynaklar'] ?? [] as $kaynak) {
                if (isset($sayim[$kaynak])) {
                    $sayim[$kaynak]++;
                }
            }
        }
    }

    // Dördü de birden çok üniversitede karşılık bulmalı. Sayı satır başına
    // (varyantlı cetveller aynı satırı birden çok kez taşıyor).
    foreach ($sayim as $etiket => $adet) {
        expect($adet)->toBeGreaterThanOrEqual(8, "{$etiket} korpusta karşılıksız kalmış");
    }
});

/**
 * İKİ AİLE AYRI KALSIN: kurum DIŞI kurul üyeliği, üniversite İÇİ komisyon
 * üyeliğinden ayrı puanlansın diye açıldı. Aynı satırda ikisi birden
 * bulunuyorsa ayrım çökmüş demektir.
 */
test('dış kuruluş etiketi üniversite içi komisyon etiketiyle aynı satırda değil', function () {
    $depo = app(SartDeposu::class);
    $dis = ['Dış Kuruluş Kurul Üyeliği (Uluslararası)', 'Dış Kuruluş Kurul Üyeliği (Ulusal)',
        'Spor Federasyonu Kurul Üyeliği (Uluslararası)', 'Spor Federasyonu Kurul Üyeliği (Ulusal)'];
    $sizinti = [];

    foreach ($depo->cetveller() as $ad => $katalog) {
        foreach ($katalog->maddeler as $kod => $madde) {
            $kaynaklar = $madde['kaynaklar'] ?? [];

            if (array_intersect($dis, $kaynaklar) !== [] && in_array('Kurul / Komisyon Üyeliği', $kaynaklar, true)) {
                $sizinti[] = "{$ad} {$kod}";
            }
        }
    }

    expect(array_values(array_unique($sizinti)))->toBe([]);
});

/**
 * "VE/VEYA" TARAMASINDAN GEÇEN İKİ KOLLU SATIRLAR (06.09.2026).
 *
 * Kaynaklar bazen iki AYRI faaliyeti tek bende sığdırıyor: "…etkinliklere
 * katılmak ve/veya yarışmalarda derece almak". Korpusta 49 böyle puanlama
 * satırı var (tarama kuralları `KaynakTaramaTest`'te); dördü ikinci kolu
 * için ayrı satır ya da ayrı etiket gerektiriyordu. Bu test o dördünü
 * donduruyor — biri geri alınırsa ikinci kol sessizce kaybolur.
 */
test('iki kollu satırların ikinci kolu korpusta duruyor', function (string $cetvel, string $kod, string $etiket) {
    $katalog = app(SartDeposu::class)->cetveller()[$cetvel] ?? null;

    expect($katalog)->not->toBeNull("cetvel yok: {$cetvel}")
        ->and($katalog->maddeler)->toHaveKey($kod)
        ->and($katalog->maddeler[$kod]['kaynaklar'] ?? [])->toContain($etiket);
})->with([
    // İTÜ M.5/M.6'nın yarışma kolu: M bölümünde ayrı satır, çünkü moda
    // varyantının eser barajı G.7d'yi değil yalnız `M.*`ı görüyor.
    ['itu-2022-moda', 'M.6y', 'Yarışma Derecesi / Mansiyon'],
    // Iğdır 26.a/26.b "ödül veya patent almak": patent ayrı kategoride
    // olduğu için aynı kodda duramıyordu.
    ['igdir-2023', '26.a.p', 'Uluslararası Patent'],
    ['igdir-2023', '26.b.p', 'Ulusal Patent'],
    // İstanbul Aydın 7/8 "editörlük ve/veya hakemlik": hakemlik etiketi iki
    // satıra da düşüyordu, §0 uyarınca düşük olanda (B08, 15) bırakıldı.
    ['istanbul-aydin-2020', 'B08', 'Hakemlik'],
    // İstanbul Atlas 3.1'in ikinci kolu ("kamusal alanda sergilenmesi,
    // satın alınması") ulusal satırda; sözlük satın almada yurt dışını
    // ayırmadığı için uluslararası satıra yazılamaz.
    ['istanbul-atlas-2026', '3.1.e', 'Eserin Satın Alınması (Yurt İçi)'],
]);

/**
 * BİLİMSEL TOPLANTI ORGANİZASYONU AİLESİ (06.09.2026).
 *
 * Altı etiket korpusun 85 kaynağında karşılığı olan bir aile için açıldı;
 * açmak tek başına işe yaramaz, satırlara YAYILMASI gerekir (KONVANSIYONLAR
 * §1 "ETİKETİ AÇTIKTAN SONRA KORPUSA YAY"). Bu test yayılmanın geri
 * alınmadığını koruyor: her etiket birden çok üniversitede puan almalı.
 */
test('toplantı organizasyonu etiketleri korpusta puan alıyor', function (string $etiket, int $enAz) {
    $depo = app(SartDeposu::class);
    $faaliyet = sartFaaliyet($etiket, Kategori::Diger, null);

    $universite = [];

    foreach ($depo->cetveller() as $ad => $katalog) {
        if ($katalog->puan($faaliyet, $katalog->coz(['*'])) > 0) {
            // İlk tireye kadar kesmek `ankara-mgu`yu `ankara`ya katıyordu;
            // ayrım YIL ekinde: `ankara-2023` ile `ankara-mgu-2026` ayrı.
            $universite[preg_replace('/-(?:19|20)\d{2}.*$/', '', $ad)] = true;
        }
    }

    expect(count($universite))->toBeGreaterThanOrEqual($enAz, "{$etiket} yeterince yayılmamış");
})->with([
    ['Toplantı Düzenleme Başkanlığı (Uluslararası)', 50],
    ['Toplantı Düzenleme Başkanlığı (Ulusal)', 47],
    ['Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)', 85],
    ['Düzenleme/Bilim Kurulu Üyeliği (Ulusal)', 83],
    ['Oturum Başkanlığı (Uluslararası)', 32],
    ['Oturum Başkanlığı (Ulusal)', 31],
]);

/**
 * ROL KADEMESİ KORUNUYOR MU: aile tek etikete toplansaydı §0 hepsini oturum
 * başkanlığının kademesine indirirdi. Bitlis'in F.4 bloğu üç rungu da tek
 * kaynakta taşıyor (başkanlık 10 · üyelik 5 · oturum 2); üçünün de kendi
 * değerini alması ayrımın çökmediğinin kanıtı.
 */
test('toplantı organizasyonunda rol kademesi çökmüyor', function () {
    $katalog = app(SartDeposu::class)->cetveller()['bitlis-2024'] ?? null;
    expect($katalog)->not->toBeNull();

    $puan = fn (string $etiket) => $katalog->puan(
        sartFaaliyet($etiket, Kategori::Diger, null),
        $katalog->coz(['*']),
    );

    expect($puan('Toplantı Düzenleme Başkanlığı (Uluslararası)'))->toBe(10)
        ->and($puan('Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'))->toBe(5)
        ->and($puan('Oturum Başkanlığı (Uluslararası)'))->toBe(2);
});

/**
 * KADEMEYİ BİRLEŞTİREN SATIR EN DÜŞÜĞÜNÜ ALIR (06.09.2026).
 *
 * `Davetli Konuşmacı` etiketi kapsam (uluslararası/ulusal) taşımıyor; her
 * iki kademeyi de temsil ettiği için satır ULUSAL değerde durmalı. Sekiz
 * üniversitede uluslararası kademeye yazılmıştı — kaynak metinden okunan
 * ulusal karşılıklarla düzeltildi.
 */
test('davetli konuşmacı etiketi ulusal kademede', function (string $cetvel, int $beklenen) {
    $katalog = app(SartDeposu::class)->cetveller()[$cetvel] ?? null;
    expect($katalog)->not->toBeNull("cetvel yok: {$cetvel}");

    $faaliyet = sartFaaliyet('Davetli Konuşmacı', Kategori::Bildiri, null);

    expect($katalog->puan($faaliyet, $katalog->coz(['*'])))->toBe($beklenen);
})->with([
    // Ankara ç) 12 · a) 25 idi.
    ['ankara-2023', 12],
    // Artvin B6 12 · B1 15 idi.
    ['artvin-2024', 12],
    // Ege d) 10 · a) 15 idi.
    ['ege-2026', 10],
    // Gümüşhane B6 5 · B2 8 idi.
    ['gumushane-2026', 5],
    // Kocaeli 10) 6 · 9) 8 idi (cetvelde 7).
    ['kocaeli-2023', 6],
    // Marmara 39 15 · 38 30 idi.
    ['marmara-egitim', 15],
    ['marmara-fen-saglik', 15],
    // Ordu N.6 3 · N.4 10 idi.
    ['ordu-2024-dr-yeniden-c60', 3],
    // Bayburt 3.2.ç 15 · 3.1.d'nin 70'iyle karışmıştı.
    ['bayburt-2024', 15],
    // Ağrı 2.2.1 15 · 2.1.1'in 20'si yazılıydı.
    ['agri-2024', 15],
]);

/**
 * KAPSAMSIZ ETİKETLERİN ÜÇÜNCÜ TURU: `Kurul / Komisyon Üyeliği`.
 *
 * Etiket kurulun HANGİSİ olduğunu taşımıyor (senato, fakülte kurulu, birim
 * komisyonu, sınav komisyonu hepsi aynı etikete düşüyor); kaynak bunları
 * kademelendiriyorsa satır en düşüğünde durmalı.
 */
test('kurul komisyon üyeliği en düşük kademede', function (string $cetvel, int $beklenen) {
    $katalog = app(SartDeposu::class)->cetveller()[$cetvel] ?? null;
    expect($katalog)->not->toBeNull("cetvel yok: {$cetvel}");

    $faaliyet = sartFaaliyet('Kurul / Komisyon Üyeliği', Kategori::IdariGorev, null);

    expect($katalog->puan($faaliyet, $katalog->coz(['*'])))->toBe($beklenen);
})->with([
    // Ardahan 1.1.29 birim komisyonu 1 · 1.1.14'ün 2'si yazılıydı.
    ['ardahan-2026', 1],
    // Kütahya DPÜ P12 birim/merkez kurulu 3 · P9'un 4'ü yazılıydı.
    ['dpu-2024', 3],
    // K.Maraş İstiklal B11.5 diğer kurul görevleri 5 · B11.4'ün 8'i
    // yazılıydı (satır senato etiketini de taşıdığı için bölündü).
    ['kahramanmaras-istiklal-2024', 5],
    // Karabük sınav komisyonu 2 · 4.15.2'nin 10'u yazılıydı.
    ['karabuk-2024', 2],
    // Sakarya 14.35/14.41 kurul görevi 10 · 14.40'ın 20'si yazılıydı
    // (üstelik o satır koordinatör YARDIMCILIĞI, kurul üyeliği değil).
    ['sakarya-2026', 10],
    // Selçuk h) Rektörlüğe bağlı komisyon üyesi 5 · 12f'nin 10'u yazılıydı.
    ['selcuk-2024-egitim', 5],
]);

/**
 * KAPSAMSIZ ETİKETLERİN İKİNCİ TURU: `Kitap Editörlüğü` ve `Hakemlik`.
 *
 * İkisi de sözlükte kademe taşımıyor. `Kitap Editörlüğü` çeviri kitabın
 * editörlüğünü de temsil etmek zorunda (sözlükte ayrı etiketi yok;
 * `Çeviri Kitap` Kitap kategorisinde ve YAZARLIĞI anlatıyor), `Hakemlik`
 * ise derginin indeksini taşımıyor. İkisi de kaynağın EN DÜŞÜK kademesine
 * yazılmalı.
 */
test('kapsamsız editörlük etiketleri en düşük kademede', function (string $cetvel, string $etiket, int $beklenen) {
    $depo = app(SartDeposu::class);
    $katalog = $depo->cetveller()[$cetvel] ?? null;
    expect($katalog)->not->toBeNull("cetvel yok: {$cetvel}");

    $faaliyet = sartFaaliyet($etiket, Kategori::Editorluk, null);

    expect($katalog->puan($faaliyet, $katalog->coz(['*'])))->toBe($beklenen);
})->with([
    // Adıyaman F.5.b çeviri editörlük 40 · F.5.a 50 yazılıydı.
    ['adiyaman-2024', 'Kitap Editörlüğü', 40],
    // Bingöl 15.b çeviri 5 · 15.a 10 yazılıydı (BKCI satırdan ayrıldı).
    ['bingol-2024', 'Kitap Editörlüğü', 5],
    // Fırat B1.3 diğer ulusal 10 · A1.6 40 yazılıydı.
    ['firat-2026', 'Kitap Editörlüğü', 10],
    // İbn Haldun 1.2.4.2 → 5 · 8 yazılıydı.
    ['ibn-haldun-2024', 'Kitap Editörlüğü', 5],
    // İzmir Kavram f) çeviri 5 · 10 yazılıydı.
    ['izmir-kavram-2025', 'Kitap Editörlüğü', 5],
    // Osmaniye 3.2 çeviri kitap editörlüğü 15 · 2.2.2'nin 20'si yazılıydı.
    ['osmaniye-2023', 'Kitap Editörlüğü', 15],
    // Yalova j) ulusal çeviri 4 · 4e'nin 8'i yazılıydı.
    ['yalova-2024-sosyal', 'Kitap Editörlüğü', 4],
    // Artvin F6 (A3 dergisi) 1 · F3'ün 5'i yazılıydı.
    ['artvin-2024', 'Hakemlik', 1],
    // Gaziantep 7b (ESCI/ULAKBİM/ulusal) 1 · 7a'nın 2'si yazılıydı.
    ['gaziantep-2026', 'Hakemlik', 1],
    // Fırat B5.6 diğer ulusal hakemlik 2 · A6.6'nın 3'ü yazılıydı.
    ['firat-2026', 'Hakemlik', 2],
]);

/**
 * `Kurul / Komisyon Üyeliği` YERLEŞTİRME TARAMASI (07.09.2026).
 *
 * Etiketi taşıyan 220 satırın başlığı tarandı: yedisinde başlık kurul ya da
 * komisyondan hiç söz etmiyordu. Dördü gerçek hataydı — etiket dekan
 * yardımcılığı ya da koordinatör yardımcılığı satırında duruyordu ve
 * kaynağın kendi komisyon satırı daha düşük kademedeydi.
 */
test('kurul komisyon etiketi kendi satırında', function (string $cetvel, int $beklenen) {
    $katalog = app(SartDeposu::class)->cetveller()[$cetvel] ?? null;
    expect($katalog)->not->toBeNull("cetvel yok: {$cetvel}");

    $faaliyet = sartFaaliyet('Kurul / Komisyon Üyeliği', Kategori::IdariGorev, null);

    expect($katalog->puan($faaliyet, $katalog->coz(['*'])))->toBe($beklenen);
})->with([
    // Bayburt 10.l BAP bilimsel komisyonu 2 · etiket 10.ç'de (dekan yrd, 5) idi.
    ['bayburt-2024', 2],
    // ESOGÜ 18b fakülte komisyonu 2 · etiket 15b'de (dekan yrd, 4) idi.
    ['esogu-2023', 2],
    // Sakarya 14.35 kurul görevi 10 · etiket 14.40'ta (koordinatör yrd) idi.
    ['sakarya-2026', 10],
    // Selçuk h) Rektörlüğe bağlı komisyon üyesi 5 · etiket f'de (koordinatör
    // yardımcılığı, 10) idi; on bir varyantın hepsinde düzeltildi.
    ['selcuk-2024-egitim', 5],
]);
