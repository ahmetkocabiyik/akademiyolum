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
test('kategori bazlı yazar çarpanı haric listesiyle çakışmıyor', function () {
    $sizinti = [];

    foreach (app(SartDeposu::class)->cetveller() as $ad => $katalog) {
        $katsayi = $katalog->yazarKatsayisi;

        if ($katsayi === null) {
            continue;
        }

        $haric = $katsayi['haric'] ?? [];

        foreach (array_keys($katsayi['kategoriler'] ?? []) as $kategori) {
            if (in_array($kategori, $haric, true)) {
                $sizinti[] = "{$ad}: \"{$kategori}\" hem `kategoriler`de hem `haric`te";
            }
        }
    }

    expect(array_values(array_unique($sizinti)))->toBe([]);
});
