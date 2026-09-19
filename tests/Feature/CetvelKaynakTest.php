<?php

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Services\Scoring\Sart\MaddeKatalogu;
use App\Services\Scoring\Sart\SartDeposu;

/**
 * Cetvel anahtarı → onu üreten dosyanın adı.
 *
 * Bir dosya normalde tek cetvel üretir ve adını dosyadan alır; ÜAK'ın temel
 * alan tabloları gibi yerlerde bir dosya `cetveller` anahtarıyla onlarca
 * cetvel döndürür. Korpus değişmezlerini dosya adıyla dondurmak listeyi
 * okunur tutuyor: Erzurum Teknik'in 36 kadro cetveli tek satıra iniyor.
 *
 * @return array<string, string>
 */
function cetvelDosyaHaritasi(): array
{
    $harita = [];

    foreach (glob(database_path('data/cetvel/*.php')) ?: [] as $dosya) {
        /** @var array{cetveller?: array<string, mixed>} $icerik */
        $icerik = require $dosya;
        $temel = basename($dosya, '.php');

        foreach (array_keys($icerik['cetveller'] ?? [$temel => null]) as $anahtar) {
            $harita[(string) $anahtar] = $temel;
        }
    }

    return $harita;
}

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
        // Ankara 7. bölüm ("bilimsel/sanatsal toplantıda sunulmuş bildiri",
        // 15) ile 1E/ç ("SCOPUS dergide yayımlanmış kongre bildirisi", 5)
        // aynı esere iki farklı yönden bakıyor; CPCI'da basılan bir bildiri
        // ikisine de girer ve motorun yükseği alması doğrudur.
        'ankara-2023: 7b-7c-tam > 1Eç',
        // Gazi'nin toplantı bölümü ("hakemli toplantıda sunulan sözlü/poster
        // bildiri", 10/5 ve 5/3) ile 6/e-8/e ("dergide yayımlanmış kongre
        // bildirisi tam metni/özeti", 5/3 ve 4/2) aynı esere iki farklı
        // yönden bakıyor; dergide de basılan bir bildiri ikisine birden
        // girer ve motorun yükseği alması doğrudur.
        'gazi-2024: Tf-nat > 8e-tam',
        'gazi-2024: Tf-ulus > 6e-tam',
        'gazi-2024: Tg-nat > 8e-ozet',
        'gazi-2024: Tg-ulus > 6e-ozet',
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
        'ankara-2023: 24/76',

        // Yalnız EG5 (yarıyıl başına 1 puanlık ders) dışarıda; `PUAN` grubu
        // ders satırlarını kapsamıyor.
        'erzincan-2021: 1/112',

        // Toplam baraj A-L; M (ödüller, idari görevler) ile N (patent)
        // kaynağın kendi ifadesiyle barajın dışında.
        'giresun-2019: 11/62',

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
        'omu-2025-a-doc: 17/101',
        'omu-2025-a-dr: 17/101',
        'omu-2025-a-prof: 17/101',
        'omu-2025-b-doc: 17/105',
        'omu-2025-b-dr: 17/105',
        'omu-2025-b-prof: 17/105',
        'omu-2025-bx-doc: 17/101',
        'omu-2025-bx-dr: 17/101',
        'omu-2025-bx-prof: 17/101',

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
 * İKİ EKSEN BİRDEN: ROL ve KAPSAM. Bitlis'in F bölümü dört blok — F.1
 * uluslararası kongre · F.2 uluslararası çalıştay · F.3 ulusal kongre ·
 * F.4 ulusal çalıştay — ve her blokta üç rol ayrı puanlı. Altı etiketin
 * her biri KENDİ KAPSAMININ iki bloğunun en düşüğünü alır.
 *
 * Önce altısı da F.4'e (ULUSAL ÇALIŞTAY, en düşük blok) yazılmıştı: rol
 * kademesi korunuyordu ama KAPSAM kademesi çökmüştü.
 */
test('toplantı organizasyonunda rol ve kapsam kademeleri birlikte duruyor', function () {
    $katalog = app(SartDeposu::class)->cetveller()['bitlis-2024'] ?? null;
    expect($katalog)->not->toBeNull();

    $puan = fn (string $etiket) => $katalog->puan(
        sartFaaliyet($etiket, Kategori::Diger, null),
        $katalog->coz(['*']),
    );

    expect($puan('Toplantı Düzenleme Başkanlığı (Uluslararası)'))->toBe(15)
        ->and($puan('Toplantı Düzenleme Başkanlığı (Ulusal)'))->toBe(10)
        ->and($puan('Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'))->toBe(8)
        ->and($puan('Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'))->toBe(5)
        ->and($puan('Oturum Başkanlığı (Uluslararası)'))->toBe(3)
        ->and($puan('Oturum Başkanlığı (Ulusal)'))->toBe(2);
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

/**
 * MAKALE TÜRÜ EKSENİ (`turler`): yönergeler aynı dergideki iki çalışmayı
 * TÜRÜNE göre farklı puanlıyor — özgün araştırma makalesi, derleme, kısa
 * makale (short/brief communication), vaka takdimi-teknik not-editöre mektup.
 * `kaynak` yalnızca DERGİYİ taşıdığı için bu ayrım oradan okunamıyor;
 * cetvel maddeleri `turler` ile sınırlanıyor.
 *
 * İKİ SESSİZ HATA BİÇİMİ VAR ve ikisi de bu testle donduruldu:
 *
 *   1. Düşük satır hiç girilmemiş → editöre mektup, özgün makale puanını alır.
 *   2. Düşük satır girilmiş ama YÜKSEK satırda tür kısıtı yok → `puan()` en
 *      yükseği aldığı için düşük satır hiç kazanamaz, yani ölü doğar.
 *      (İstanbul Kültür'de tam olarak bu vardı.)
 *
 * Aşağıdaki değerler 07.09.2026'da kaynak PDF'lerinden tek tek okundu.
 */
test('makale türü kademeleri korpusta ayrışıyor', function (string $cetvel, string $etiket, array $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $kodlar = $katalog->coz(['*']);
    $gercek = [];
    foreach (['ozgun_makale', 'derleme', 'kisa_makale', 'vaka_teknik_not'] as $tur) {
        $gercek[$tur] = $katalog->puan(
            new Faaliyet([
                'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
                'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi', 'yayin_turu' => $tur,
            ]),
            $kodlar,
        );
    }

    expect($gercek)->toBe($beklenen);
})->with([
    // KTÜ: "tam makale / diğer makale" — dipnot "diğer makale"yi derleme,
    // kısa makale, vaka takdimi ve editöre mektup diye tanımlıyor.
    ['ktu-2023-fen-profesor', 'SCIE/SSCI (Q1)',
        ['ozgun_makale' => 45, 'derleme' => 35, 'kisa_makale' => 35, 'vaka_teknik_not' => 35]],
    ['ktu-2023-fen-profesor', 'TR Dizin',
        ['ozgun_makale' => 15, 'derleme' => 5, 'kisa_makale' => 5, 'vaka_teknik_not' => 5]],

    // Atatürk: her indeks kademesinde ayrı "kısa makale (editöre mektup,
    // teknik not, vaka takdimi, tartışma, kitap incelemesi)" satırı var;
    // beşi de (02.01.05/07/09, 02.02.02/04) hiç girilmemişti.
    ['ataturk-2026', 'SCIE/SSCI (Q1)',
        ['ozgun_makale' => 30, 'derleme' => 30, 'kisa_makale' => 8, 'vaka_teknik_not' => 8]],
    ['ataturk-2026', 'Diğer Ulusal Hakemli',
        ['ozgun_makale' => 4, 'derleme' => 4, 'kisa_makale' => 2, 'vaka_teknik_not' => 2]],

    // Afyon Kocatepe 1.6: editöre mektup, özet ve kitap kritiği ilgili
    // satırın YARISINI alıyor; derleme ve kısa makale listede yok.
    ['afyon-2026', 'SCIE/SSCI (Q1)',
        ['ozgun_makale' => 160, 'derleme' => 160, 'kisa_makale' => 160, 'vaka_teknik_not' => 80]],

    // Gümüşhane A6/A7 hiç girilmemişti.
    ['gumushane-2026', 'SCIE/SSCI (Q1)',
        ['ozgun_makale' => 35, 'derleme' => 35, 'kisa_makale' => 35, 'vaka_teknik_not' => 3]],
    ['gumushane-2026', 'Diğer Ulusal Hakemli',
        ['ozgun_makale' => 4, 'derleme' => 4, 'kisa_makale' => 4, 'vaka_teknik_not' => 2]],

    // Gazi 6-9: bölümlerin c ve d bentleri girilmemişti.
    ['gazi-2024', 'ESCI / Scopus',
        ['ozgun_makale' => 20, 'derleme' => 20, 'kisa_makale' => 15, 'vaka_teknik_not' => 5]],

    // Ankara E/F/G: b ve c bentleri girilmemişti; 1Gb'nin etiketi de
    // başlığıyla çelişiyordu (TR-Dizin diyor, `Diğer Ulusal Hakemli` taşıyordu).
    ['ankara-2023', 'TR Dizin',
        ['ozgun_makale' => 15, 'derleme' => 15, 'kisa_makale' => 5, 'vaka_teknik_not' => 4]],

    // Ege d/e/f ve g1/g2/g3 AYNI dergi kademesinin üç türü; önce iki ayrı
    // etikete dağıtılmıştı.
    ['ege-2026', 'ESCI / Scopus',
        ['ozgun_makale' => 20, 'derleme' => 10, 'kisa_makale' => 5, 'vaka_teknik_not' => 5]],
    ['ege-2026', 'TR Dizin',
        ['ozgun_makale' => 10, 'derleme' => 6, 'kisa_makale' => 3, 'vaka_teknik_not' => 3]],

    // Amasya: A.9 (editöre mektup 20) girilmemiş, A.2 ise "Letters (EDİTÖRE
    // MEKTUP HARİÇ)" dediği hâlde editöre mektubu taşıyordu; A.14/A.15
    // ulusal kademede hiç yoktu (7,5 → 7).
    ['amasya-2024', 'SCIE/SSCI (Q1)',
        ['ozgun_makale' => 80, 'derleme' => 25, 'kisa_makale' => 40, 'vaka_teknik_not' => 20]],
    ['amasya-2024', 'TR Dizin',
        ['ozgun_makale' => 40, 'derleme' => 25, 'kisa_makale' => 40, 'vaka_teknik_not' => 7]],

    // İstanbul Kültür: düşük satırlar (1.d, 2.c) DOĞRU girilmişti ama yüksek
    // satırlarda tür kısıtı yoktu, yani hiç kazanamıyorlardı.
    ['istanbul-kultur-2024', 'SCIE/SSCI (Q1)',
        ['ozgun_makale' => 30, 'derleme' => 30, 'kisa_makale' => 3, 'vaka_teknik_not' => 3]],

    // Selçuk: düşük satır kaynakta "a VE B bendi" diyor, yani ESCI/Scopus da
    // kapsıyordu; on iki varyantta da yalnız SCI etiketlerini taşıyordu.
    ['selcuk-2024-muhendislik', 'ESCI / Scopus',
        ['ozgun_makale' => 15, 'derleme' => 5, 'kisa_makale' => 5, 'vaka_teknik_not' => 5]],
    // Eğitim tablosunun düşük satırı "a, b VEYA C" diyor.
    ['selcuk-2024-egitim', 'Diğer Uluslararası İndeks',
        ['ozgun_makale' => 10, 'derleme' => 5, 'kisa_makale' => 5, 'vaka_teknik_not' => 5]],

    // Yalova sağlık: olgu sunumu (5/2) ile editöre mektup (3) kaynakta
    // ÇAPRAZLANIYOR ama sözlükte tek kovada; §0 uyarınca her kademede
    // düşüğü geçerli.
    ['yalova-2024-saglik', 'SCIE/SSCI (Q1)',
        ['ozgun_makale' => 20, 'derleme' => 5, 'kisa_makale' => 3, 'vaka_teknik_not' => 3]],
    ['yalova-2024-saglik', 'ESCI / Scopus',
        ['ozgun_makale' => 10, 'derleme' => 2, 'kisa_makale' => 2, 'vaka_teknik_not' => 2]],

    // Çankırı 1.8 kaynakta açıkça "(özgün araştırma makalesi ve derleme)".
    ['cankiri-2025', 'Diğer Ulusal Hakemli',
        ['ozgun_makale' => 20, 'derleme' => 20, 'kisa_makale' => 0, 'vaka_teknik_not' => 0]],

    // Abdullah Gül: editöre mektup satırları yalnız WoS Core Collection'da.
    ['abdullah-gul-2026', 'ESCI / Scopus',
        ['ozgun_makale' => 15, 'derleme' => 15, 'kisa_makale' => 2, 'vaka_teknik_not' => 2]],
]);

/**
 * "DÜŞÜK SATIR YÜKSEK SATIRIN GÖLGESİNDE" TARAMASI — kaynağa hiç bakmayan,
 * tamamen cetvel içi bir tutarlılık kontrolü: bir madde yalnız özgün-dışı
 * türlere (derleme, kısa makale, vaka/teknik not) açıksa, motor o tür için
 * o satırın puanından FAZLASINI vermemeli. Veriyorsa aynı etikete daha
 * yüksek puanlı ve tür kısıtsız bir satır düşüyor demektir ve düşük satır
 * ölü doğmuş olur.
 *
 * Ucuz ve kesin: 07.09.2026'da korpusa uygulandığında İstanbul Kültür'ün
 * (1.d/2.c) ve Yalova sağlığın (1d/1e) gerçek hatalarını buldu.
 */
test('özgün-dışı tür satırları yüksek satırın gölgesinde kalmıyor', function () {
    $depo = sartDepo();
    $cetveller = [];
    foreach ($depo->esikler() as $esik) {
        $cetveller[$esik['cetvel']] = true;
    }

    $golgede = [];
    foreach (array_keys($cetveller) as $ad) {
        $katalog = $depo->katalog($ad);
        if ($katalog === null) {
            continue;
        }

        $kodlar = $katalog->coz(['*']);
        $maddeler = (fn () => $this->maddeler)->call($katalog);

        foreach ($maddeler as $kod => $madde) {
            $turler = $madde['turler'] ?? null;
            if (($madde['kategori'] ?? '') !== 'makale' || $turler === null || in_array('ozgun_makale', $turler, true)) {
                continue;
            }

            foreach ($madde['kaynaklar'] ?? [] as $etiket) {
                foreach ($turler as $tur) {
                    $gercek = $katalog->puan(
                        new Faaliyet([
                            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
                            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi', 'yayin_turu' => $tur,
                        ]),
                        $kodlar,
                    );

                    if ($gercek > ($madde['puan'] ?? 0)) {
                        $golgede[preg_replace('/-(?:19|20)\d{2}.*$/', '', $ad).": {$kod}"] = true;
                    }
                }
            }
        }
    }

    // Isparta UBÜ tek istisna ve BİLİNÇLİ: Tablo 3'ün A4 satırı ("alanınızla
    // ilgili makale yayımlamak", 5) Tablo 1'in bütün makale satırlarıyla
    // kasten örtüşüyor — Güzel Sanatlar adayı A4'ten, Fen adayı Tablo 1'den
    // puanlanıyor. Motor her BARAJ GRUBUNUN içindeki en iyi kodu seçtiği
    // için gerçek eşiklerde gölgeleme oluşmuyor; bu tarama ise bütün
    // kodlara birden baktığı için işaret veriyor.
    $bulunan = array_keys($golgede);
    sort($bulunan);

    expect($bulunan)->toBe([
        'isparta-ubu: T1-C2',
        'isparta-ubu: T1-C3',
        'isparta-ubu: T1-D4',
    ]);
});

/**
 * BİLDİRİDE TAM METİN / ÖZET AYRIMI. Makalenin `turler` ekseninin karşılığı
 * bildiride YOK; ayrımı ETİKETİN KENDİSİ taşıyor:
 *   `Uluslararası Tam Metin (CPCI)` · `Uluslararası Tam Metin` ·
 *   `Uluslararası Özet/Poster` · `Ulusal Tam Metin` · `Ulusal Özet/Poster`
 *
 * Üç hata biçimi çıktı ve üçü de burada donduruldu:
 *
 *   1. Kaynak ayırıyor, cetvel tek satıra çöküyor (GİBTÜ) ya da satırın bir
 *      kolu hiç girilmemiş (Ankara'nın uluslararası tam metin ve bütün
 *      ulusal bildiri satırları).
 *   2. İKİ EKSEN KARIŞIYOR: kaynak hem sözlü/poster hem tam metin/özet
 *      ayrımı yapınca "poster satırı" ile "özet satırı" birbirine
 *      karışıyor (Ege'de poster satırının TAM METİN değeri özet etiketine
 *      yazılmıştı).
 *   3. `Özet/Poster` etiketi ÖZET değerini alıyor, oysa poster daha düşük
 *      (Trakya: uluslararası 3 yerine 2, ulusal 2 yerine 1).
 *
 * Değerler 07.09.2026'da kaynak PDF'lerinden okundu.
 */
test('bildiride tam metin ile özet ayrışıyor', function (string $cetvel, array $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $kodlar = $katalog->coz(['*']);
    $gercek = [];
    foreach (array_keys($beklenen) as $etiket) {
        $gercek[$etiket] = $katalog->puan(
            new Faaliyet([
                'kategori' => Kategori::Bildiri, 'tur' => 'Test', 'baslik' => 'Test',
                'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
            ]),
            $kodlar,
        );
    }

    expect($gercek)->toBe($beklenen);
})->with([
    // Ankara 7/b-c: uluslararası sözlü 20/15, poster 15/10 → tam metin 15,
    // özet 10. 7/d-e: ulusal sözlü 12/8, poster 6/4 → 6 ve 4. Tam metin kolu
    // ile ulusal satırların TAMAMI hiç girilmemişti.
    ['ankara-2023', [
        'Uluslararası Tam Metin' => 15, 'Uluslararası Özet/Poster' => 10,
        'Ulusal Tam Metin' => 6, 'Ulusal Özet/Poster' => 4,
    ]],

    // GİBTÜ: uluslararası sözlü 15/10 · poster 10/8; ulusal sözlü 10/8 ·
    // poster 8/5. Dört kolonun tamamı tek satıra (15 ve 10) çökmüştü.
    ['gibtu-2024', [
        'Uluslararası Tam Metin' => 15, 'Uluslararası Özet/Poster' => 8,
        'Ulusal Tam Metin' => 10, 'Ulusal Özet/Poster' => 5,
        'Davetli Konuşmacı' => 2,
    ]],

    // Ege: sözlü 8/4 · poster 5/3 (uluslararası), 6/3 · 4/2 (ulusal).
    // Önce b ve c "tam metin satırı / özet satırı" sanılıp özet etiketine
    // POSTER'in TAM METİN değeri (5) yazılmıştı.
    ['ege-2026', [
        'Uluslararası Tam Metin' => 8, 'Uluslararası Özet/Poster' => 3,
        'Ulusal Tam Metin' => 6, 'Ulusal Özet/Poster' => 2,
    ]],

    // Trakya: Tam Metin/Özet/Poster üç kolon — CPCI 8/5/3, diğer 6/3/2,
    // ulusal 4/2/1. `Özet/Poster` etiketi POSTER değerini alır.
    ['trakya-2025-ek2', [
        'Uluslararası Tam Metin (CPCI)' => 8, 'Uluslararası Tam Metin' => 6,
        'Uluslararası Özet/Poster' => 2, 'Ulusal Tam Metin' => 4, 'Ulusal Özet/Poster' => 1,
    ]],

    // KTÜ 1.g-ı: dizinli dergide kongre bildirisi tam metni/özeti 20/10 …
    // 5/3. Etiket "Tam Metin (CPCI)" olduğu için tam metin kolonunun en
    // düşüğü (5); önce iki kolonun birden en düşüğü (3) yazılmıştı.
    ['ktu-2023-fen-profesor', [
        'Uluslararası Tam Metin (CPCI)' => 5, 'Uluslararası Tam Metin' => 12,
        'Uluslararası Özet/Poster' => 4, 'Ulusal Tam Metin' => 6, 'Ulusal Özet/Poster' => 2,
    ]],

    // İstanbul Aydın B/12 açıkça "ulusal TAM bildiriler"; ulusal bildiri
    // özeti için satır yok, etiket karşılıksız kalmalı.
    ['istanbul-aydin-2020', [
        'Ulusal Tam Metin' => 5, 'Ulusal Özet/Poster' => 0,
    ]],
]);

/**
 * SÖZLÜ / POSTER EKSENİ SÖZLÜKTE YOK. Etiket çifti şöyle bölüşüyor:
 *
 *   `… Tam Metin`     = SÖZLÜ sunulup tam metni basılan bildiri
 *   `… Özet/Poster`   = özeti basılanlar İLE POSTER'lerin tamamı
 *                       (poster adı ikinci etikette geçiyor)
 *
 * Bu yüzden `Özet/Poster` satırı, kaynağın ÖZET ve POSTER hücrelerinin EN
 * DÜŞÜĞÜNÜ alır. Korpusta 47 yönerge posteri sözlüden ayırıyor; çoğu doğru
 * girilmişti ama yedi üniversitede yalnız SÖZLÜ ÖZET satırı yazılmış, poster
 * satırı hiç sayılmamıştı — posteri olan aday sözlü bildiri puanı alıyordu.
 *
 * Değerler 07.09.2026'da kaynak PDF'lerinden okundu.
 */
test('bildiride poster sözlüden ayrışıyor', function (string $cetvel, array $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $kodlar = $katalog->coz(['*']);
    $gercek = [];
    foreach (array_keys($beklenen) as $etiket) {
        $gercek[$etiket] = $katalog->puan(
            new Faaliyet([
                'kategori' => Kategori::Bildiri, 'tur' => 'Test', 'baslik' => 'Test',
                'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
            ]),
            $kodlar,
        );
    }

    expect($gercek)->toBe($beklenen);
})->with([
    // Amasya C: uluslararası sözlü 25/15 · poster 10/5; ulusal sözlü 15/9 ·
    // poster 5/3. Özet etiketine POSTER TAM METİN satırı bağlanmıştı.
    // `Davetli Konuşmacı` da C1'de 25 puanla duruyordu; kaynağın davetli
    // satırları H bölümünde (uluslararası 10, ulusal 7).
    ['amasya-2024', [
        'Uluslararası Tam Metin' => 25, 'Uluslararası Özet/Poster' => 5,
        'Ulusal Tam Metin' => 15, 'Ulusal Özet/Poster' => 3,
        'Davetli Konuşmacı' => 7,
    ]],

    // Artvin B: uluslararası sözlü 13/7 · poster 5/3; ulusal sözlü 8/5 ·
    // poster 4/2. Poster satırları hiç girilmemişti.
    ['artvin-2024', [
        'Uluslararası Tam Metin' => 13, 'Uluslararası Özet/Poster' => 3,
        'Ulusal Tam Metin' => 8, 'Ulusal Özet/Poster' => 2,
    ]],

    // Bingöl 6: uluslararası sözlü 20/10 · poster 10/5; ulusal 10/5 · 5/2.
    ['bingol-2024', [
        'Uluslararası Tam Metin' => 20, 'Uluslararası Özet/Poster' => 5,
        'Ulusal Tam Metin' => 10, 'Ulusal Özet/Poster' => 2,
    ]],

    // Hakkari C: poster satırı tam/özet ayrımı taşımıyor (uluslararası 8,
    // ulusal 4) ve sözlü özet satırından düşük.
    ['hakkari-2024', [
        'Uluslararası Tam Metin' => 15, 'Uluslararası Özet/Poster' => 8,
        'Ulusal Tam Metin' => 10, 'Ulusal Özet/Poster' => 4,
    ]],

    // K.Maraş İstiklal A3: uluslararası sözlü 15/10 · poster 10/5;
    // ulusal sözlü 10/5 · poster 5/2.
    ['kahramanmaras-istiklal-2024', [
        'Uluslararası Tam Metin' => 15, 'Uluslararası Özet/Poster' => 5,
        'Ulusal Tam Metin' => 10, 'Ulusal Özet/Poster' => 2,
    ]],

    // Manisa CBÜ 7/8: c bendi "poster bildiri veya yayımlanmamış sözlü
    // sunum" (10 ve 5), özet bendinden düşük.
    ['manisa-cbu-2024', [
        'Uluslararası Tam Metin' => 30, 'Uluslararası Özet/Poster' => 10,
        'Ulusal Tam Metin' => 20, 'Ulusal Özet/Poster' => 5,
    ]],

    // Gümüşhane B4/B8: sözlü tam 6 · sözlü özet-veya-poster 4 · poster tam 3
    // · poster özet 2 (ulusal 5·3·2·1).
    ['gumushane-2026', [
        'Uluslararası Tam Metin' => 6, 'Uluslararası Özet/Poster' => 2,
        'Ulusal Tam Metin' => 5, 'Ulusal Özet/Poster' => 1,
    ]],

    // Sakarya UBÜ: KODLAR BİR SATIR KAYMIŞTI — `Uluslararası Tam Metin`
    // 2.2'nin (ULUSAL DAVETLİ) 50 puanını taşıyordu. Doğrusu 2.3 (40).
    ['sakarya-ubu-2024', [
        'Uluslararası Tam Metin' => 40, 'Uluslararası Özet/Poster' => 20,
        'Ulusal Tam Metin' => 30, 'Ulusal Özet/Poster' => 10,
        'Davetli Konuşmacı' => 50,
    ]],

    // Yıldız Teknik: 7. bölümün (Bilimsel Toplantı Faaliyetleri) TAMAMI
    // girilmemişti; bildiri etiketlerinin hiçbirinin karşılığı yoktu.
    ['yildiz-teknik-2022', [
        'Uluslararası Tam Metin' => 3, 'Uluslararası Özet/Poster' => 2,
        'Ulusal Tam Metin' => 2, 'Ulusal Özet/Poster' => 1,
    ]],

    // Cerrahpaşa: B bölümünün (ULUSAL FAALİYETLER) 8. maddesi girilmemişti.
    ['cerrahpasa-2023', [
        'Uluslararası Tam Metin' => 15, 'Uluslararası Özet/Poster' => 8,
        'Ulusal Tam Metin' => 6, 'Ulusal Özet/Poster' => 4,
        // Cerrahpaşa'nın tek davetli satırı ULUSLARARASI; 16.09.2026'da
        // kapsamlı etikete geçti, genel etiket artık oraya düşmüyor.
        'Davetli Konuşmacı' => 0,
        'Davetli Konuşmacı (Uluslararası)' => 3,
    ]],

    // Gazi: toplantı bölümünün f/g bentleri (sözlü 10/5, poster 5/3)
    // girilmemişti; bildiri etiketleri yalnız dergide yayımlanmış kongre
    // bildirisi satırlarından besleniyordu.
    ['gazi-2024', [
        'Uluslararası Tam Metin' => 10, 'Uluslararası Özet/Poster' => 5,
        'Ulusal Tam Metin' => 5, 'Ulusal Özet/Poster' => 3,
    ]],
]);

/**
 * `Davetli Konuşmacı` ETİKETİ KAPSAM TAŞIMIYOR: uluslararası ile ulusal
 * daveti ayırmıyor. Yönergelerin hemen hepsi ayırıyor (uluslararası 25 ·
 * ulusal 12 gibi), bu yüzden satır §0 uyarınca ULUSAL değere yazılır.
 *
 * İki ek hata biçimi çıktı:
 *
 *   1. Etiket, davetli satırı OLMAYAN bir bildiri satırına iliştirilmiş
 *      (Bandırma'da uluslararası özet/poster bildirisine, DPÜ'de poster
 *      satırına) — kaynağın kendi davetli satırları başka bir bölümde.
 *   2. Kaynakta davetli satırı var ama cetvelde hiç karşılığı yok
 *      (Atatürk, Mersin).
 *
 * Değerler 07.09.2026'da kaynak PDF'lerinden okundu.
 *
 * 16.09.2026: sözlüğe kapsam ekseni girdi. Satırı YALNIZ uluslararası olan
 * on dokuz cetvel `Davetli Konuşmacı (Uluslararası)` etiketine geçti; orada
 * ulusal davet artık hiç saymıyor ve bu doğrudur. Geri kalanlar hâlâ genel
 * etiketi taşıyor (kaynak ayırmıyor) ve §0 uyarınca ulusal değerde.
 */
test('davetli konuşmacı etiketi ulusal davet değerinde', function (string $cetvel, int $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $puan = $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Bildiri, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => 'Davetli Konuşmacı', 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan)->toBe($beklenen);
})->with([
    // Gazi toplantı bölümü: a) uluslararası 12, c) ulusal 6.
    ['gazi-2024', 6],
    // Bitlis B.1.5 uluslararası 10, B.2.5 ulusal 9.
    ['bitlis-2024', 9],
    // Bandırma E bölümü: E1.c 8 · E2.c 5 · E3.c 5 · E4.c 4. Etiket önce
    // A12.b'de (uluslararası özet/poster bildiri, 8) duruyordu.
    ['bandirma-2024', 4],
    // DPÜ: C114 3 · C124 2 · C213/C216 2 · C223/C226 1. Etiket önce C121'de
    // (uluslararası poster bildiri, 2) duruyordu.
    ['dpu-2024', 1],
    // Atatürk 02.12.03 uluslararası 5, 02.13.01 ulusal 3 — satır hiç yoktu.
    ['ataturk-2026', 3],
    // Mersin 3/h: uluslararası 5, ulusal 3 — 3. bölümün TAMAMI hiç yoktu.
    ['mersin-2024', 3],
    // Amasya: etiket C1'de (uluslararası sözlü tam metin, 25) duruyordu;
    // kaynağın davetli satırları H bölümünde (H.2 10, H.7 7).
    ['amasya-2024', 7],
    // Cerrahpaşa: A/10-c uluslararası 5, B/8-c ulusal 3.
    // Cerrahpaşa'nın tek davetli satırı ULUSLARARASI; kapsam ekseni
    // gelince ulusal davet hiç saymaz oldu (kaynak da saymıyor).
    ['cerrahpasa-2023', 0],
    // Sakarya UBÜ: 2.1 uluslararası 60, 2.2 ulusal 50.
    ['sakarya-ubu-2024', 50],
    // GİBTÜ: uluslararası 15, ulusal 10, STK/bakanlık etkinliği 2.
    ['gibtu-2024', 2],
]);

/**
 * Mersin'in 3. bölümü (BİLDİRİLER) ile 2/d-g bentleri hiç girilmemişti.
 * Kaynak TARANMIŞ belge; metin çıkarımı puan sütununu tamamen düşürdüğü için
 * bölüm gözden kaçmış, sayfanın GÖRÜNTÜSÜNDEN (s. 19) okundu.
 */
test('Mersin bildiri bölümü ve makale türü merdiveni', function () {
    $katalog = sartDepo()->katalog('mersin-2024');
    $kodlar = $katalog->coz(['*']);

    $bildiri = fn (string $etiket): int => $katalog->puan(
        new Faaliyet(['kategori' => Kategori::Bildiri, 'tur' => 'T', 'baslik' => 'T',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi']),
        $kodlar,
    );
    $makale = fn (string $etiket, string $tur): int => $katalog->puan(
        new Faaliyet(['kategori' => Kategori::Makale, 'tur' => 'T', 'baslik' => 'T',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi', 'yayin_turu' => $tur]),
        $kodlar,
    );

    expect($bildiri('Uluslararası Tam Metin (CPCI)'))->toBe(7)
        ->and($bildiri('Uluslararası Tam Metin'))->toBe(5)
        ->and($bildiri('Uluslararası Özet/Poster'))->toBe(2)
        ->and($bildiri('Ulusal Tam Metin'))->toBe(3)
        ->and($bildiri('Ulusal Özet/Poster'))->toBe(1)
        ->and($makale('SCIE/SSCI (Q1)', 'ozgun_makale'))->toBe(50)
        ->and($makale('SCIE/SSCI (Q1)', 'vaka_teknik_not'))->toBe(15)
        ->and($makale('SCIE/SSCI (Q4)', 'vaka_teknik_not'))->toBe(6);
});

/**
 * `Oturum Başkanlığı` ETİKET ÇİFTİ KAPSAM TAŞIYOR — davetli konuşmacının
 * tersine uluslararası ile ulusal ayrı etiket. Yönergelerin çoğu da ayırıyor
 * ama korpusta 37 cetvelin 28'inde iki etiket TEK SATIRDA duruyordu ve
 * kapsam kademesi çökmüştü.
 *
 * Çökme iki yöne birden gidiyordu: satır bazen ULUSAL değerdeydi
 * (uluslararası eksik sayılıyor: Bartın 3 yerine 10, ZBEÜ 1 yerine 10),
 * bazen ULUSLARARASI değerdeydi (ulusal fazla sayılıyor: Ardahan 5 yerine 2,
 * Sakarya 10 yerine 8, İstanbul Zaim 5 yerine... yani ulusal 10 alıyordu).
 *
 * Değerler 08.09.2026'da kaynak PDF'lerinden okundu.
 */
test('oturum başkanlığında kapsam kademesi ayrışıyor', function (string $cetvel, int $ulus, int $ulusal) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $puan = fn (string $etiket): int => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Diger, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => null, 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect([$puan('Oturum Başkanlığı (Uluslararası)'), $puan('Oturum Başkanlığı (Ulusal)')])
        ->toBe([$ulus, $ulusal]);
})->with([
    // Ulusal kademe FAZLA sayıyordu:
    ['ardahan-2026', 5, 2],
    ['sakarya-2026', 10, 8],
    ['istanbul-zaim-2019', 10, 5],
    ['adu-2024', 15, 5],
    ['karamanoglu-2024', 8, 5],
    // Uluslararası kademe EKSİK sayıyordu:
    ['bartin-2022', 10, 5],
    ['bitlis-2024', 3, 2],
    ['bolu-aibu-2024', 3, 2],
    ['gazi-2024', 4, 3],
    ['hakkari-2024', 5, 3],
    ['osmaniye-2023', 5, 3],
    ['msgsu-2023', 3, 2],
    ['fsmvu-2024', 5, 3],
    ['ufuk-2025', 3, 1],
    ['siirt-2025', 5, 3],
    ['zbeu-2026', 10, 2],
    ['duzce-2024', 5, 2],
    ['erzurum-teknik-2024-muhendislik-docentlik', 20, 10],
    // Ulusal satır hiç yoktu (SBTÜ B3.8), ya da 0,5 → 0 olduğu için
    // ulusal etiket karşılıksız kalmalıydı (Ankara Bilim 6.4.18).
    ['sbtu-2021', 20, 10],
    ['ankara-bilim-2023', 1, 0],
]);

/**
 * Aynı satırda hem ROL hem KAPSAM kademesi varsa ikisi birden korunmalı.
 * Erzurum Teknik'in B bölümü buna örnek: B1/B6 kongre başkanlığı 30/20,
 * B2/B7 oturum başkanlığı ve düzenleme kurulu üyeliği 20/10. Altı etiketin
 * tamamı önce tek satırda ULUSAL değerde (10) duruyordu.
 */
test('Erzurum Teknik toplantı ailesinde rol ve kapsam birlikte duruyor', function () {
    $katalog = sartDepo()->katalog('erzurum-teknik-2024-muhendislik-docentlik');
    $kodlar = $katalog->coz(['*']);

    $puan = fn (string $etiket): int => $katalog->puan(
        new Faaliyet(['kategori' => Kategori::Diger, 'tur' => 'T', 'baslik' => 'T',
            'kaynak' => $etiket, 'rol' => null, 'durum' => 'onaylandi']),
        $kodlar,
    );

    expect($puan('Toplantı Düzenleme Başkanlığı (Uluslararası)'))->toBe(30)
        ->and($puan('Toplantı Düzenleme Başkanlığı (Ulusal)'))->toBe(20)
        ->and($puan('Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)'))->toBe(20)
        ->and($puan('Düzenleme/Bilim Kurulu Üyeliği (Ulusal)'))->toBe(10);
});

/**
 * TOPLANTI ORGANİZASYONU AİLESİNİN ÜÇ RUNGU ile İKİ KAPSAMI — altı etiket.
 * Oturum başkanlığı turunun (08.09.2026) devamı: aynı çökme başkanlık ve
 * kurul üyeliği etiketlerinde de vardı. 96 cetvelin 83'ünde iki kapsam
 * etiketi tek satırdaydı; kaynağa karşı okununca on birinde gerçek hata
 * çıktı.
 *
 * Değerler 08.09.2026'da kaynak PDF'lerinden okundu.
 */
test('toplantı düzenleme ailesinde kapsam kademesi ayrışıyor', function (string $cetvel, array $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $kodlar = $katalog->coz(['*']);
    $gercek = [];
    foreach (array_keys($beklenen) as $etiket) {
        $gercek[$etiket] = $katalog->puan(
            new Faaliyet([
                'kategori' => Kategori::Diger, 'tur' => 'Test', 'baslik' => 'Test',
                'kaynak' => $etiket, 'rol' => null, 'durum' => 'onaylandi',
            ]),
            $kodlar,
        );
    }

    expect($gercek)->toBe($beklenen);
})->with([
    // Dört rung da tek satırda birleşmişti:
    ['acibadem-2025-atif6', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 10, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 8,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 5, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 3,
    ]],
    ['esogu-2023', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 6, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 3,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 4, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 2,
    ]],
    ['konya-gida-tarim-2024', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 20, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 10,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 10, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 5,
    ]],
    ['ufuk-2025', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 5, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 3,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 4, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 2,
    ]],
    ['ksu-2023', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 12, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 3,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 3, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 1,
    ]],
    // Atatürk: dört blok (uluslararası/ulusal × kongre/çalıştay); başkanlık
    // 15/6, kurul üyeliği 2/2. Önce 15/15 ve 5/5 yazılmıştı.
    ['ataturk-2026', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 15, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 6,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 2, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 2,
    ]],
    // Yalnız kurul üyeliği çifti birleşmişti:
    ['sbtu-2021', [
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 5, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 3,
    ]],
    ['zbeu-2026', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 50, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 20,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 10, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 2,
    ]],
    // Giresun: tek satır vardı ve ULUSAL değeri (10) uluslararası etikete
    // yazılmıştı; başkanlık ile ulusal kurul etiketinin karşılığı yoktu.
    ['giresun-2019', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 40, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 20,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 30, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 10,
    ]],
    // OMÜ 13.12 (uluslararası kurul üyeliği 15) hiç girilmemişti; yalnız
    // 13.13'ün ulusal 10'u vardı.
    ['omu-2025-a-doc', [
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 15, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 10,
    ]],
    // Kafkas: kaynak yalnız uluslararası satırları yazıp "ulusal
    // organizasyonlarda ilgili puanın YARISI alınır" diyor (15→7, 5→2);
    // ulusal etiketlerin karşılığı hiç yoktu.
    ['kafkas-2025-fen', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 15, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 7,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 5, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 2,
    ]],
]);

/**
 * TOPLANTI DÜZENLEME BAŞKANLIĞI — ikinci geçiş. Bir önceki tur kaynak
 * süzgecini "düzenleme kurulu" sözcüğüyle BİRLİKTE bir etkinlik sözcüğü
 * (kongre/sempozyum/toplantı) arayacak biçimde kurmuştu; oysa bu altı
 * yönergede satır çıplak yazılıyor ("Düzenleme kurulu başkanlığı   10") ve
 * KAPSAM BÖLÜM BAŞLIĞINDA duruyor. Süzgeç gevşetilip kapsam en yakın
 * başlıktan okununca altı hata daha çıktı.
 *
 * Değerler 08.09.2026'da kaynak PDF'lerinden okundu.
 */
test('toplantı düzenleme başkanlığında kapsam kademesi ayrışıyor', function (string $cetvel, array $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $kodlar = $katalog->coz(['*']);
    $gercek = [];
    foreach (array_keys($beklenen) as $etiket) {
        $gercek[$etiket] = $katalog->puan(
            new Faaliyet([
                'kategori' => Kategori::Diger, 'tur' => 'Test', 'baslik' => 'Test',
                'kaynak' => $etiket, 'rol' => null, 'durum' => 'onaylandi',
            ]),
            $kodlar,
        );
    }

    expect($gercek)->toBe($beklenen);
})->with([
    // Osmaniye 11.9: a) uluslararası başkan 20 · üyelik 10, b) ULUSAL 15 · 5.
    ['osmaniye-2023', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 20, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 15,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 10, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 5,
    ]],
    // Bandırma E1-E4: başkanlık 15/10/10/8 → 10 ve 8. Kurul üyeliği kaynakta
    // iki bende dağılmış (E*.c düzenleme 8/5/5/4, E*.ç bilim 3/2/2/2) → 2/2.
    ['bandirma-2024', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 10, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 8,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 2, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 2,
    ]],
    // Siirt 10 (uluslararası) ve 11 (ulusal): başkanlık 10/8, kurul 3/1.
    // Dördü de tek satırda 1 puanla duruyordu.
    ['siirt-2025', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 10, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 8,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 3, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 1,
    ]],
    // Erciyes 5/d: kaynak "Uluslararası: 10, Ulusal: 5" diye SATIR İÇİNDE
    // yazıyor; iki kapsam 5'te birleşmişti.
    ['erciyes-2024', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 10, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 5,
    ]],
    // Düzce 3.3/a uluslararası 20, 3.4/a ULUSAL 15; ikisi 6'da birleşmişti.
    ['duzce-2024', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 20, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 15,
    ]],
    // Işık F.1.1 (uluslararası) / F.1.2 (ulusal): başkanlık 10/6. Kurul
    // üyeliği etiketi hem düzenleme (5/3) hem bilim-danışma (1/1) kurulunu
    // taşıdığı için her kapsamda 1 — önce 3/3 ile fazla sayıyordu.
    ['isik-2019', [
        'Toplantı Düzenleme Başkanlığı (Uluslararası)' => 10, 'Toplantı Düzenleme Başkanlığı (Ulusal)' => 6,
        'Düzenleme/Bilim Kurulu Üyeliği (Uluslararası)' => 1, 'Düzenleme/Bilim Kurulu Üyeliği (Ulusal)' => 1,
    ]],
]);

/**
 * JÜRİ HİZMETİ ETİKETLERİ — dört etiket, iki eksen: rol (başkanlık/üyelik)
 * ve kapsam (uluslararası/ulusal).
 *
 * ROL EKSENİ KORPUSTA NEREDEYSE HİÇ AYRIŞMIYOR ve bu DOĞRU: 91 cetvelin
 * 89'unda başkanlık ile üyelik aynı puanda, çünkü yönergelerin yalnız BİRİ
 * (Mersin) jüri başkanı ile üyesini ayırıyor (10/7). Geri kalanı tek satır
 * yazıyor ("yarışmalarda jüri üyeliği"), etiket çifti o satırı paylaşıyor.
 *
 * KAPSAM EKSENİ ayrışıyor ve beş cetvelde çökmüştü.
 *
 * Değerler 08.09.2026'da kaynak PDF'lerinden okundu.
 */
test('jüri hizmetinde kapsam kademesi ayrışıyor', function (string $cetvel, array $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $kodlar = $katalog->coz(['*']);
    $gercek = [];
    foreach (array_keys($beklenen) as $etiket) {
        $gercek[$etiket] = $katalog->puan(
            new Faaliyet([
                'kategori' => Kategori::SanatselEtkinlik, 'tur' => 'Test', 'baslik' => 'Test',
                'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
            ]),
            $kodlar,
        );
    }

    expect($gercek)->toBe($beklenen);
})->with([
    // MSGSÜ 3.4.1 uluslararası 15 · 3.4.2 ULUSAL 10.
    ['msgsu-2023', ['Jüri Üyeliği (Uluslararası)' => 15, 'Jüri Üyeliği (Ulusal)' => 10]],
    // Muş Alparslan F3.3 uluslararası 30 · F3.4 ULUSAL 15.
    ['mus-alparslan-2025', ['Jüri Üyeliği (Uluslararası)' => 30, 'Jüri Üyeliği (Ulusal)' => 15]],
    // KTÜN O-1.3 uluslararası 5 · O-7.2 ULUSAL 2.
    ['ktun-2024', ['Jüri Üyeliği (Uluslararası)' => 5, 'Jüri Üyeliği (Ulusal)' => 2]],
    // İstanbul e) uluslararası 15 · i) ULUSAL 10.
    ['istanbul-2026-mimarlik', ['Jüri Üyeliği (Uluslararası)' => 15, 'Jüri Üyeliği (Ulusal)' => 10]],
    // DPÜ I16 uluslararası 1 · I202 ULUSAL 0,5 → aşağı yuvarlanınca 0,
    // yani ulusal etiket karşılıksız kalmalı.
    ['dpu-2024', ['Jüri Üyeliği (Uluslararası)' => 1, 'Jüri Üyeliği (Ulusal)' => 0]],
    // KOCAELİ EŞİTLİĞİ DOĞRU: H.29 kaynağın kendi ifadesiyle kapsamsız
    // ("Ulusal VEYA uluslararası düzeyde gerçekleştirilen jürili
    // yarışmalarda … jüri üyesi olarak görev yapmak", 25).
    ['kocaeli-2023', ['Jüri Üyeliği (Uluslararası)' => 25, 'Jüri Üyeliği (Ulusal)' => 25]],
    // MERSİN korpusta rol ekseni ayrışan TEK cetvel: başkan 10/5, üye 7/3.
    ['mersin-2024', [
        'Jüri Başkanlığı (Uluslararası)' => 10, 'Jüri Başkanlığı (Ulusal)' => 5,
        'Jüri Üyeliği (Uluslararası)' => 7, 'Jüri Üyeliği (Ulusal)' => 3,
    ]],
]);

/**
 * DIŞ KURULUŞ ve SPOR FEDERASYONU KURUL ÜYELİĞİ — iki kapsam çifti.
 *
 * Bu ailede baskın hata biçimi ötekilerden FARKLI çıktı: kapsam çökmesi değil,
 * KAPSAMSIZ KAYNAK SATIRINA TEK ETİKET bağlanması. Üç yönergede satır açıkça
 * kapsamsız ("Olimpik spor federasyonlarının kurullarında görev") ama yalnız
 * uluslararası etiket bağlıydı; ulusal federasyon kurulunda görev alan aday
 * hiç puan almıyordu.
 *
 * Değerler 08.09.2026'da kaynak PDF'lerinden okundu.
 */
test('kurul üyeliğinde kapsam kademesi ayrışıyor', function (string $cetvel, array $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $kodlar = $katalog->coz(['*']);
    $gercek = [];
    foreach (array_keys($beklenen) as $etiket) {
        $gercek[$etiket] = $katalog->puan(
            new Faaliyet([
                'kategori' => Kategori::IdariGorev, 'tur' => 'Test', 'baslik' => 'Test',
                'kaynak' => $etiket, 'rol' => null, 'durum' => 'onaylandi',
            ]),
            $kodlar,
        );
    }

    expect($gercek)->toBe($beklenen);
})->with([
    // Ege 10.3/d satırı "(Uluslararası/Ulusal)" diyor ve değeri "40 / 20"
    // biçiminde veriyor; iki kapsam da 20'de duruyordu.
    ['ege-2026', [
        'Spor Federasyonu Kurul Üyeliği (Uluslararası)' => 40,
        'Spor Federasyonu Kurul Üyeliği (Ulusal)' => 20,
    ]],
    // Kaynak satırı kapsamsız → iki etiket de aynı satırdan sayılır.
    // Önce yalnız uluslararası etiket bağlıydı.
    ['bartin-2022', [
        'Spor Federasyonu Kurul Üyeliği (Uluslararası)' => 60,
        'Spor Federasyonu Kurul Üyeliği (Ulusal)' => 60,
    ]],
    // Sinop'ta satır ayrıca YANLIŞ TABLODAYDI: B ailesinde (sosyal, filoloji,
    // hukuk, ilahiyat, mimarlık) duruyordu, oysa kaynakta TABLO 11 (SPOR
    // BİLİMLERİ) satırı. Spor adayı hiç puan almazken sosyal adayı almaması
    // gereken puanı alıyordu.
    ['sinop-2025-spor', [
        'Spor Federasyonu Kurul Üyeliği (Uluslararası)' => 2,
        'Spor Federasyonu Kurul Üyeliği (Ulusal)' => 2,
    ]],
    ['sinop-2025-sosyal', [
        'Spor Federasyonu Kurul Üyeliği (Uluslararası)' => 0,
        'Spor Federasyonu Kurul Üyeliği (Ulusal)' => 0,
    ]],
    ['suleyman-demirel-2027', [
        'Spor Federasyonu Kurul Üyeliği (Uluslararası)' => 4,
        'Spor Federasyonu Kurul Üyeliği (Ulusal)' => 4,
    ]],
    // ULUSLARARASI ETİKETİN BOŞ KALMASI DOĞRU olabilir: bu yönergelerin dış
    // kuruluş satırları yalnız YURT İÇİ organları anıyor (kamu kurumu
    // komisyonu, meslek odası, bakanlık kurulu), uluslararası karşılığı yok.
    ['gazi-2024', [
        'Dış Kuruluş Kurul Üyeliği (Uluslararası)' => 0,
        'Dış Kuruluş Kurul Üyeliği (Ulusal)' => 2,
    ]],
    ['bitlis-2024', [
        'Dış Kuruluş Kurul Üyeliği (Uluslararası)' => 0,
        'Dış Kuruluş Kurul Üyeliği (Ulusal)' => 8,
    ]],
    // Tersi de doğru olabilir: Alanya'nın satırı yalnız "uluslararası
    // nitelikli bilimsel/mesleki kuruluş" diyor, ulusal karşılığı yok.
    ['alanya-2024', [
        'Dış Kuruluş Kurul Üyeliği (Uluslararası)' => 10,
        'Dış Kuruluş Kurul Üyeliği (Ulusal)' => 0,
    ]],
]);

/**
 * `Yayın Kurulu Üyeliği` KAPSAMSIZ VE KADEMESİZ tek etiket: ne uluslararası/
 * ulusal ne de dergi indeksi ayrımı taşıyor. Kaynak birden çok kademede
 * yayın kurulu üyeliği yazıyorsa satır EN DÜŞÜĞÜNDE durmalı (Ataşehir
 * Adıgüzel 50/40/30/25 → 25, Iğdır 40/25 → 25).
 *
 * Bu turun asıl bulgusu farklı bir biçimdi: **kaynakta yayın kurulu satırı
 * hiç yokken etiketin HAKEMLİK satırına iliştirilmesi.** Hakemlik makale
 * başına verilen bir görev, yayın kurulu üyeliği ise süreklilik taşıyan bir
 * görev; ikisi ayrı satır. Etiket hakemlik satırında kalınca kaynağın
 * vermediği puanı veriyor ve hakemlik SAYISI koşullarını da besliyordu.
 *
 * Değerler 08.09.2026'da kaynak PDF'lerinden okundu.
 */
test('yayın kurulu üyeliği kaynağın kendi satırından sayılıyor', function (string $cetvel, int $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $puan = $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Editorluk, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => 'Yayın Kurulu Üyeliği', 'rol' => null, 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan)->toBe($beklenen);
})->with([
    // Kaynakta yayın kurulu satırı YOK → etiket karşılıksız kalmalı.
    // Dördünde de hakemlik satırına iliştirilmişti.
    ['dpu-2024', 0],
    ['erzurum-teknik-2024-muhendislik-docentlik', 0],
    ['istanbul-29-mayis-2017', 0],
    ['suleyman-demirel-2027', 0],
    // Kırıkkale'de de yayın kurulu satırı yok ama kaynağın 4.7/4 bendi
    // "yardımcı editörlük (ilgili puanların YARISI)" diyor; en düşük
    // editörlük satırı ulusal hakemli dergide 50 → 25. Etiket önce
    // hakemlik satırında (puanların 1/4'ü) duruyordu; sayı aynı, dayanak
    // doğru satır.
    ['kirikkale-2022', 25],
    // Kademeli kaynaklarda EN DÜŞÜK değer: Ataşehir 50/40/30/25, Iğdır 40/25.
    ['atasehir-adiguzel-2018', 25],
    ['igdir-2023', 25],
]);

test('Acıbadem: uluslararası kitap isteyen koşullara ULUSAL kitap satırı bağlı değil', function () {
    // Kaynağın üç sosyal alan kuralı da kitap tarafını "4A.1, 4A.3, 4B.1 ve
    // 4B.3" diye yazıyor; dördü de ULUSLARARASI kitap/bölüm yazarlığı.
    // 4.B bloğu sözlükte uluslararası/ulusal ayrımı olmadığı için ulusal
    // kademeye çökmüş (4.B.7 = kitap, 4.B.9 = bölüm) ve o satırlar İKİSİNİ
    // BİRDEN topluyor. Koşula bağlanırlarsa ulusal bir kitap uluslararası
    // şartın yerine geçer — §0'ın yasakladığı fazla sayma.
    $cetvel = require database_path('data/cetvel/acibadem-2025.php');
    $gruplar = $cetvel['cetveller']['acibadem-2025-atif6']['gruplar'];

    foreach (['SOSYAL-A', 'SOSYAL-DOC-B', 'SOSYAL-PROF-B'] as $grup) {
        expect($gruplar[$grup])
            ->not->toContain('4.B.7')
            ->not->toContain('4.B.9')
            // 4.A.1/4.A.3 tanımı gereği uluslararası (WoS/SCOPUS/SENSE); onlar kalmalı.
            ->toContain('4.A.1')
            ->toContain('4.A.3');
    }
});

/**
 * Yalnız ULUSLARARASI çalışma isteyen koşulların kümesinde ulusal ya da
 * kapsam taşımayan satır olmamalı.
 *
 * Kaynaklar uluslararası ile ulusalı ayrı bölüm olarak yazıyor ve ikisini
 * birden kastettiği yerde bunu söylüyor ("uluslararası ya da ulusal"). Yalnız
 * uluslararası isteyen bir barajın kümesine ulusal bir satır girerse aday o
 * barajı ulusal çalışmayla doldurur — §0'ın yasakladığı fazla sayma.
 *
 * Detektör koşul METNİNDEN çalışıyor: 'uluslararas' geçiyor ama alternatif
 * olarak 'ulusal' geçmiyorsa koşul uluslararası-özeldir. Türkçe tuzağı:
 * 'ulusal' 'uluslararası'nın içinde de var, negatif lookbehind şart.
 *
 * ALLOWLIST: koşul metninde 'uluslararası' KİTABI değil dergiyi/bildiriyi
 * nitelediği hâller (Bursa Teknik "uluslararası konferans tam metin
 * bildirisi ya da kitap/kitap bölümü", İzmir Demokrasi "kitap ya da
 * uluslararası indeksli dergide makale"). Orada kitap kapsamsızdır ve
 * kapsamsız satır DOĞRUDUR.
 */
test('yalnız uluslararası isteyen koşulların kümesinde ulusal satır yok', function () {
    $izinli = [
        // "uluslararası" dergiyi/bildiriyi niteliyor, kitabı değil.
        'bursa-teknik-2024', 'izmir-demokrasi-turler', 'izmir-bakircay-2026',
        'karamanoglu-2024', 'duzce-2024', 'tau-2021-fen',
        // Tersi: "uluslararası" KİTABI niteliyor, dergileri değil. Kaynağın
        // kuralı "1A, 2A, 3A … ya da 4B.1/4B.3" — 3A TR Dizin'dir ve kümede
        // olması doğru. Kitap tarafı ayrıca daraltıldı.
        'acibadem-2025-atif6', 'acibadem-2025-atif12', 'acibadem-2025-atif20',
        // Satırın KENDİSİ uluslararası; sözlük etiketi kapsam taşımıyor.
        // Ayrı bir sorun (etiket kapsamsız), bu testin konusu değil.
        'cerrahpasa-2023', 'isik-2019-carpanli', 'ibn-haldun-2024',
        'ibn-haldun-2024-sanat', 'selcuk-2024-egitim', 'selcuk-2024-hukuk',
        // Sıfat KİTABI/ATFI değil BİLDİRİYİ niteliyor ("… ve uluslararası
        // bildiri kalemlerinizden"); kitap ve atıf kapsamsızdır, doğrudur.
        'trakya-2025-ek1',

        // Sıfat MAKALEYİ/PROJEYİ değil ikinci seçeneği niteliyor: İTÜ
        // "araştırma projesinde yürütücülük ya da ULUSLARARASI projede
        // araştırmacılık", Tokat GOP "Uluslararası kuruluşlar, COST, AB,
        // TÜBİTAK, TÜBA … projelerinden" (TÜBİTAK ulusaldır), KTÜN'ün 11-c
        // kümesi kaynağın kendisinde D-1'i (TR Dizin) sayıyor.
        'itu-2022', 'itu-2022-hs', 'itu-2022-mf', 'itu-2022-moda', 'itu-2022-tmdk',
        'tokat-gaziosmanpasa-2026', 'ktun-2024-mps',
    ];

    $depo = sartDepo();
    $bulgular = [];

    foreach ($depo->dogrulanmisEsikler() as $esik) {
        if (in_array($esik['cetvel'], $izinli, true)) {
            continue;
        }

        $katalog = $depo->katalog($esik['cetvel']);

        if ($katalog === null) {
            continue;
        }

        $gez = function (array $dugum) use (&$gez, $katalog, $esik, &$bulgular) {
            $aciklama = (string) ($dugum['aciklama'] ?? '');

            // Koşul ulusal bir indeksi ADIYLA anıyorsa (TR Dizin, ULAKBİM)
            // kapsamı zaten karışıktır; 'ulusal' sözcüğünü aramak yetmiyor.
            $yalnizUluslararasi = preg_match('/uluslararas/iu', $aciklama) === 1
                && preg_match('/(?<!uluslar)\bulusal\b|TR Dizin|ULAKB/iu', $aciklama) !== 1;

            if (isset($dugum['maddeler']) && $yalnizUluslararasi) {
                foreach ($katalog->coz($dugum['maddeler']) as $kod) {
                    $baslik = $katalog->maddeler[$kod]['baslik'] ?? '';

                    if (preg_match('/(?<!uluslar)\bulusal\b|TR Dizin/iu', $baslik) === 1) {
                        $bulgular[] = "{$esik['cetvel']} · {$kod}: {$baslik} ← {$aciklama}";
                    }
                }
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }

            if (isset($dugum['telafi'])) {
                $gez($dugum['telafi']);
            }
        };

        $gez($esik['sart']);
    }

    expect(array_values(array_unique($bulgular)))->toBe([]);
});

test('"uluslararası" barajlarına ulusal satır sayılmıyor', function (string $cetvel, string $grup) {
    // Kaynaklar uluslararası ile ulusalı AYRI bölüm olarak yazıyor ve ikisini
    // birden kastettiği yerde bunu söylüyor ("uluslararası ya da ulusal").
    // Yalnız uluslararası isteyen bir barajın kümesinde ulusal ya da kapsam
    // taşımayan bir satır varsa aday o barajı ulusal çalışmayla doldurur.
    $katalog = sartDepo()->katalog($cetvel);

    $ulusal = [];

    foreach ($katalog->coz([$grup]) as $kod) {
        $baslik = $katalog->maddeler[$kod]['baslik'];

        // Türkçe tuzağı: 'ulusal' 'uluslararası'nın İÇİNDE de geçiyor.
        if (preg_match('/(?<!uluslar)\bulusal\b|TR Dizin|diğer yayın/iu', $baslik) === 1) {
            $ulusal[] = "{$kod}: {$baslik}";
        }
    }

    expect($ulusal)->toBe([]);
})->with([
    // Beykent MADDE 6/2-b: "toplam 2 adet ULUSLARARASI yayın". Ulusal
    // bölümleri (D, E, F) kapsayan grup 6/2-ç'nindi, buraya da bağlanmıştı.
    ['beykent-2025', 'A-B-C'],
    // Trakya: "en az yarısı uluslararası faaliyetlerden". Tez yayını bölümü
    // TR Dizin makalesini ve çökmüş "uluslararası ya da ulusal kitap"
    // satırlarını da taşıdığı için toptan alınamaz.
    ['trakya-2025-ek1', 'ULUS'],
    ['trakya-2025-ek2', 'ULUS'],
    ['trakya-2025-ek3', 'ULUS'],
    ['trakya-2025-ek4', 'ULUS'],
    ['trakya-2025-ek5', 'ULUS'],
    ['trakya-2025-ek6', 'ULUS'],
    ['trakya-2025-ek7', 'ULUS'],
]);

test('bölüm joker\'i üst bölümlere sızmıyor', function () {
    // `MaddeKatalogu::coz()` joker'i ÖNEK eşleştiriyor: '1*' deseni '10a',
    // '11b', '12c' kodlarını da topluyor. Bölüm numarası RAKAMLA bittiğinde
    // (1, 2, … ve ayrıca 10, 11, 12 bölümleri varsa) desen sessizce yayılıyor.
    // Selçuk'ta "Uluslararası dergilerdeki makalelerinizden en az 40 puan"
    // koşulu ödül, editörlük ve İDARİ GÖREV satırlarını sayıyordu; dekanlık
    // makale barajını dolduruyordu.
    //
    // Çare joker'i yasaklamak değil: '1.A.*' gibi önekler nokta ile bittiği
    // için güvenli. Yalnız RAKAMLA biten önekler sınanıyor.
    $depo = sartDepo();
    $bulgular = [];

    $sinama = function (MaddeKatalogu $katalog, array $desenler, string $nereden) use (&$bulgular) {
        foreach ($desenler as $desen) {
            if (! is_string($desen) || ! str_ends_with($desen, '*')) {
                continue;
            }

            $onek = rtrim($desen, '*');

            if ($onek === '' || ctype_digit(substr($onek, -1)) === false) {
                continue;
            }

            foreach ($katalog->coz([$desen]) as $kod) {
                $kalan = substr($kod, strlen($onek));

                if ($kalan !== '' && ctype_digit($kalan[0])) {
                    $bulgular[] = "{$katalog->anahtar} · {$desen} ({$nereden}) → {$kod}";
                }
            }
        }
    };

    foreach ($depo->cetveller() as $katalog) {
        foreach ($katalog->gruplar as $ad => $uyeler) {
            $sinama($katalog, $uyeler, "grup {$ad}");
        }
    }

    foreach ($depo->dogrulanmisEsikler() as $esik) {
        $katalog = $depo->katalog($esik['cetvel']);

        if ($katalog === null) {
            continue;
        }

        $gez = function (array $dugum) use (&$gez, $katalog, $sinama) {
            foreach (['maddeler', 'oran_payda'] as $alan) {
                if (isset($dugum[$alan])) {
                    $sinama($katalog, $dugum[$alan], 'koşul');
                }
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }

            if (isset($dugum['telafi'])) {
                $gez($dugum['telafi']);
            }
        };

        $gez($esik['sart']);
    }

    expect(array_values(array_unique($bulgular)))->toBe([]);
});

test('aday metninde madde kodu yok', function () {
    // KONVANSIYONLAR §2: "Aday metninde kod YASAK, `notlar` ve düğümlerin
    // `madde` alanında ZORUNLU." Aday 1A'nın SCI-Expanded, 3A-B'nin TR Dizin
    // demek olduğunu bilmek zorunda değil; kod izlenebilirlik kanalıdır,
    // arayüz metni değil.
    $kodlu = [];

    foreach (sartDepo()->dogrulanmisEsikler() as $esik) {
        $bak = function (string $metin, string $nereden) use ($esik, &$kodlu) {
            // '1A', '3A-B', '4.A.1' gibi kodlar. 'Q1', 'EK-1' ve yıl sayıları
            // kod değil; desen RAKAM + BÜYÜK HARF sırasını arıyor.
            if (preg_match('/\b\d+\.?[A-Z]\b/u', $metin) === 1) {
                $kodlu[] = "{$esik['anahtar']} · {$nereden}: ".mb_substr($metin, 0, 90);
            }
        };

        $gez = function (array $dugum) use (&$gez, $bak) {
            $bak((string) ($dugum['aciklama'] ?? ''), 'koşul');

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }

            if (isset($dugum['telafi'])) {
                $gez($dugum['telafi']);
            }
        };

        $gez($esik['sart']);
        $bak((string) ($esik['aday_notu'] ?? ''), 'aday_notu');
    }

    expect(array_values(array_unique($kodlu)))->toBe([]);
});

test('uluslararası koşullarda kapsamsız etiket LİSTELİ kalıyor', function () {
    // Bir satır başlığıyla uluslararası olabilir ("Diğer uluslararası kitapta
    // bölüm yazarlığı") ama bağlandığı sözlük etiketi kapsam taşımıyorsa
    // (`Kitap Bölümü`) ULUSAL bir kayıt da o satıra düşer: hem satırın
    // puanını alır hem de "uluslararası faaliyetlerden N puan" barajını
    // doldurur.
    //
    // Kökü tek: sözlükte bu kalemlerin uluslararası/ulusal ekseni YOK. Veri
    // tarafında çözülemez — etiketi satırdan atmak uluslararası kaydı da
    // sıfırlar. Bu yüzden test düzeltme değil BÜYÜME koruması: bilinen
    // etiketler listede, listeye girmemiş yeni bir etiket çıkarsa kırılır.
    $kapsamsizEtiketler = [
        // Kapsam ekseni gerektirmeyen kalemler. Fon etiketleri satırın
        // kapsamını zaten belirliyor (AB uluslararası, TÜBİTAK ulusal); ders
        // etiketleri de dersin TÜRÜNÜ taşıyor, satır kapsamı söylüyor.
        // Kitap, bölüm, çeviri, editörlük, davetli konuşmacı, ders/metot
        // kitabı, diğer hakemli dergi, atıf-diğer ve patent 16.09.2026'da
        // eksene kavuştu; artık burada yer almıyorlar.
        // Fon kaynağı etiketleri: satırın kapsamını FONUN kendisi belirliyor
        // (AB uluslararası, TÜBİTAK ulusal), etiketin ayrıca söylemesi gerekmiyor.
        'AB Çerçeve / Ufuk', 'TÜBİTAK', 'TÜSEB', 'Diğer Kamu Kurumu',
        // Ders kalemleri: satır "uluslararası programda verilen ders" diyor,
        // etiket dersin türünü taşıyor.
        'Yabancı Dilde Ders', 'Değişim Programı Dersi',
    ];

    $depo = sartDepo();
    $ilgili = [];

    foreach ($depo->dogrulanmisEsikler() as $esik) {
        $katalog = $depo->katalog($esik['cetvel']);

        if ($katalog === null) {
            continue;
        }

        $gez = function (array $dugum) use (&$gez, $katalog, $esik, &$ilgili) {
            $aciklama = (string) ($dugum['aciklama'] ?? '');

            $yalnizUluslararasi = preg_match('/uluslararas/iu', $aciklama) === 1
                && preg_match('/(?<!uluslar)\bulusal\b|TR Dizin|ULAKB/iu', $aciklama) !== 1;

            if (isset($dugum['maddeler']) && $yalnizUluslararasi) {
                foreach ($katalog->coz($dugum['maddeler']) as $kod) {
                    $ilgili[$esik['cetvel']][$kod] = true;
                }
            }

            foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
                $gez($cocuk);
            }

            if (isset($dugum['telafi'])) {
                $gez($dugum['telafi']);
            }
        };

        $gez($esik['sart']);
    }

    $yeni = [];

    foreach ($depo->cetveller() as $ad => $katalog) {
        foreach ($katalog->maddeler as $kod => $madde) {
            if (! isset($ilgili[$ad][$kod])) {
                continue;
            }

            $baslik = (string) ($madde['baslik'] ?? '');

            $satirUluslararasi = preg_match('/uluslararas/iu', $baslik) === 1
                && preg_match('/(?<!uluslar)\bulusal\b|TR Dizin|yurt ?içi/iu', $baslik) !== 1;

            if (! $satirUluslararasi) {
                continue;
            }

            foreach ($madde['kaynaklar'] ?? [] as $etiket) {
                $kapsamli = preg_match(
                    '/uluslararas|(?<!uluslar)\bulusal\b|yurt ?(dışı|içi)|SCIE|SSCI|AHCI|ESCI|Scopus|BKCI|CPCI|WoS|TR Dizin|ULAKB|SENSE|SRAP|PubMed|ERIC/iu',
                    $etiket,
                ) === 1;

                if (! $kapsamli && ! in_array($etiket, $kapsamsizEtiketler, true)) {
                    $yeni[] = "{$ad} · {$kod}: {$etiket}";
                }
            }
        }
    }

    expect(array_values(array_unique($yeni)))->toBe([]);
});

test('genel etiket kapsamlı kaydı karşılar, tersi olmaz', function () {
    // Ayrım YAPMAYAN kaynağın satırı genel etiketi listeler; aday ister
    // uluslararası ister ulusal kitabını girsin o satıra düşer. Ayrım YAPAN
    // kaynağın satırı kapsamlı etiketi listeler; öteki kapsam düşmez.
    $katalog = new MaddeKatalogu(
        anahtar: 'test',
        maddeler: [
            'GENEL' => ['baslik' => 'Kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Kitap Bölümü'], 'puan' => 10],
            'DAR' => ['baslik' => 'Uluslararası kitapta bölüm', 'kategori' => 'kitap', 'kaynaklar' => ['Uluslararası Kitap Bölümü'], 'puan' => 20],
        ],
    );

    $kayit = fn (string $kaynak) => new Faaliyet([
        'kategori' => Kategori::Kitap, 'tur' => 'Test', 'baslik' => 'Test',
        'kaynak' => $kaynak, 'rol' => 'tek', 'durum' => 'onaylandi',
    ]);

    // Uluslararası kayıt HER İKİ satıra da düşer; `puan()` yükseğini alır.
    expect($katalog->puan($kayit('Uluslararası Kitap Bölümü'), ['GENEL', 'DAR']))->toBe(20)
        ->and($katalog->puan($kayit('Uluslararası Kitap Bölümü'), ['GENEL']))->toBe(10)
        // Ulusal kayıt yalnız genel satıra düşer — dar satır uluslararası istiyor.
        ->and($katalog->puan($kayit('Ulusal Kitap Bölümü'), ['GENEL', 'DAR']))->toBe(10)
        ->and($katalog->puan($kayit('Ulusal Kitap Bölümü'), ['DAR']))->toBe(0);
});

test('her genel etiketin kapsamlı çifti ve geri eşlemesi var', function () {
    // Üç yer birlikte yaşamak zorunda: sözlükte kapsamlı etiketler
    // (`kaynaklar()`), adaya gösterilmeyenler (`GENEL_KAYNAKLAR`) ve motorun
    // geri eşlemesi (`MaddeKatalogu::GENEL_ETIKET`). Biri unutulursa hata
    // SESSİZ olur: kapsamlı kayıt genel satıra düşmez, aday puanını kaybeder.
    $geri = (new ReflectionClass(MaddeKatalogu::class))->getConstant('GENEL_ETIKET');

    foreach (Kategori::GENEL_KAYNAKLAR as $kategoriDegeri => $genelEtiketler) {
        $kategori = Kategori::from($kategoriDegeri);
        $sozluk = $kategori->kaynaklar();

        foreach ($genelEtiketler as $genel) {
            // Genel etiket sözlükte DURUYOR (cetveller onu kullanıyor)…
            expect($sozluk)->toContain($genel)
                // …ama adaya sorulmuyor.
                ->and($kategori->adayKaynaklari())->not->toContain($genel);

            // En az bir kapsamlı çifti var ve geri eşlemesi bu genele çıkıyor.
            $cocuklar = array_keys(array_filter($geri, fn (string $ust) => $ust === $genel));

            expect($cocuklar)->not->toBe([]);

            foreach ($cocuklar as $cocuk) {
                expect($sozluk)->toContain($cocuk);
            }
        }
    }

    // TERS YÖN: bir kategoride hem genel etiket hem kapsamlı çocuğu varsa,
    // genel MUTLAKA gizlenenler listesinde olmalı. Yoksa aday genel etiketi
    // seçebilir ve kaydı ayrım yapan satırlara hiç düşmez.
    foreach (Kategori::cases() as $kategori) {
        $sozluk = $kategori->kaynaklar();
        $gizli = Kategori::GENEL_KAYNAKLAR[$kategori->value] ?? [];

        foreach ($geri as $cocuk => $genel) {
            // Daraltılabilir ebeveyn KENDİSİ de geçerli bir kademe (Q1'de olup
            // ilk %10'a girmeyen dergi); adaya sorulmaya devam eder.
            if (in_array($genel, Kategori::DARALTILABILIR_KAYNAKLAR, true)) {
                continue;
            }

            if (in_array($cocuk, $sozluk, true) && in_array($genel, $sozluk, true)) {
                expect($gizli)->toContain($genel);
            }
        }
    }
});

test('genel etiketler adaya sorulmuyor, cetvelde yaşıyor', function () {
    // Aday "Kitap Bölümü" diye bir seçenek görürse ayrım hiç toplanmaz;
    // cetvel tarafında ise genel etiket 3.000'den fazla satırda duruyor ve
    // orada kalması gerekiyor (kaynak ayrım yapmıyorsa doğrusu o).
    foreach (Kategori::cases() as $kategori) {
        foreach (Kategori::GENEL_KAYNAKLAR as $genel) {
            expect($kategori->adayKaynaklari())->not->toContain($genel);
        }
    }

    expect(Kategori::Kitap->kaynaklar())->toContain('Kitap Bölümü')
        ->and(Kategori::Kitap->adayKaynaklari())->toContain('Uluslararası Kitap Bölümü')
        ->and(Kategori::Kitap->adayKaynaklari())->toContain('Ulusal Kitap Bölümü');
});

test('Cerrahpaşa atıf bloğu kaynağın iki bölümünü de taşıyor', function () {
    // Kaynak atıfı İKİ bölüme ayırıyor: A/11 uluslararası (SCIE-SSCI-AHCI 10 ·
    // ESCI 7 · diğer uluslararası hakemli 5 · yurt dışı kitap 4) ve B/9 ulusal
    // (TR Dizin yurt içi 2 · diğer 1). B/9 hiç girilmemişti; `TR Dizin`
    // etiketi bu yüzden A/11-b'nin (ESCI, 7) üstünde duruyor ve bir TR Dizin
    // atfı 2 yerine 7 puan alıyordu.
    $katalog = sartDepo()->katalog('cerrahpasa-2023');

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Atif, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan('TR Dizin'))->toBe(2)
        ->and($puan('Diğer (Uluslararası)'))->toBe(5)
        ->and($puan('Diğer (Ulusal)'))->toBe(1)
        ->and($puan('BKCI Kitap'))->toBe(4)
        // Sözlük 16.09.2026'da atıfta ESCI'yi ayırdı; iki satır da kendi
        // değerinde. Genel etiketle girilmiş eski bir kayıt ise DÜŞÜK satıra
        // düşer — genel, kapsamlıyı karşılamaz.
        ->and($puan('SCIE/SSCI/AHCI'))->toBe(10)
        ->and($puan('ESCI'))->toBe(7)
        // Kaynak atıf bloğunda Scopus'u ANMIYOR; 18.09.2026'da ESCI satırından
        // düşürülüp "diğer uluslararası hakemli dergi" satırına bağlandı.
        ->and($puan('Scopus (Q1)'))->toBe(5)
        ->and($puan('ESCI / Scopus'))->toBe(0)
        ->and($puan('WoS / Scopus'))->toBe(0)
        // Patent atfı kaynakta anılmıyor; en düşük toplayıcıya bağlı.
        ->and($puan('Patent (Ulusal)'))->toBe(1);
});

/**
 * ATIFTA ESCI AYRIMI: kaynak çekirdek indeksi (SCI/SCIE/SSCI/AHCI) ESCI ile
 * Scopus'tan AYRI puanlıyorsa iki satır da kendi değerinde olmalı.
 *
 * 16.09.2026'da 175 kaynağın atıf bölümü tarandı; dokuzunda ayrım bulundu.
 * Değerler kaynak PDF'lerinden okundu.
 */
test('atıfta çekirdek indeks ile ESCI ayrı puanlanıyor', function (string $cetvel, int $cekirdek, int $esci) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Atif, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    // Aday kaydı 17.09.2026'dan beri KAPSAMLI etiketle giriliyor; genel
    // `ESCI / Scopus` yalnız cetvel tarafında. Ayrım yapmayan satırlarda
    // zincir üzerinden, yapanlarda doğrudan eşleşir.
    expect($puan('SCIE/SSCI/AHCI'))->toBe($cekirdek)
        ->and($puan('ESCI'))->toBe($esci);
})->with([
    ['ankara-mgu-2026', 30, 20],       // K.4 30 · K.6 uluslararası 20
    ['asbu-2024', 3, 2],               // I.1 3 · I.3 2
    ['cerrahpasa-2023', 10, 7],        // A/11-a 10 · A/11-b 7
    ['gumushane-2026', 5, 3],          // D1 5 · D4 3
    ['hitit-2026', 3, 2],              // 1 → 3 · 2 → 2
    ['istanbul-2026', 4, 3],           // 3.a 4 · 3.b 3
    // KTÜ bu testte YOK: kaynağı çekirdek indeksi (a, 3) ile WoS all
    // databases'i (b, 3) AYNI değerde tutuyor, ayrım ESCI ile Scopus
    // arasında (3 ↔ 2). Onu "ESCI ile Scopus ayrı puanlanıyor" donduruyor.
    ['omu-2025-c-doc', 6, 4],          // 11.1 6 · 11.3 4
    ['rte-2025', 4, 3],                // 4b 4 · 4c 3
    ['zbeu-2026', 3, 2],               // 6.a 3 · 6.b 2
]);

/**
 * ESCI ile SCOPUS'u AYRI puanlayan kaynaklar.
 *
 * 17.09.2026'da 175 kaynak tarandı; altısında ayrım bulundu. AYBÜ ayrımı
 * yapıyor ama iki kademe de aynı değere denk geliyor (ESCI çeyreklik
 * merdiveninin Q4'üne, Scopus da 10'a), o yüzden listede yok. NEÜ'de Scopus
 * ÇEKİRDEK kademeyle birlikte fiyatlanıyor (A1), ayrı bir tur konusu.
 */
test('ESCI ile Scopus ayrı puanlanıyor', function (string $cetvel, Kategori $kategori, int $esci, int $scopus) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => $kategori, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan('ESCI'))->toBe($esci)
        ->and($puan('Scopus'))->toBe($scopus);
})->with([
    ['akdeniz-2026-edebiyat-profesor', Kategori::Makale, 50, 30],  // 1.6 ↔ 1.7
    ['aksaray-2024', Kategori::Makale, 18, 20],                    // A.3 ↔ A.2
    // Hitit bu testte YOK: Scopus tarafı 17.09.2026'da çeyreklik
    // merdivenine geçti, genel `Scopus` etiketi orada artık hiçbir satırda
    // durmuyor. Aşağıdaki "Scopus çeyrekliği" testi donduruyor.
    ['kocaeli-2023', Kategori::Makale, 25, 20],                    // 5) ↔ 6)
    ['ktu-2023-fen-docent', Kategori::Atif, 3, 2],                 // b) "3/2" → WoS all databases 3, Scopus 2
    // NEÜ'de Scopus ESCI'den YÜKSEK: kaynak Scopus'u çekirdek merdiveniyle
    // birlikte fiyatlıyor (A1: "…AHCI VEYA SCOPUS"), ESCI'yi ayrı (A2: 50).
    // Kayıt Scopus için çeyrek taşımadığından merdivenin en altı (Q4, 60).
    ['necmettin-erbakan-2026', Kategori::Makale, 50, 60],
]);

test('ayrım yapmayan cetvelde ESCI ve Scopus aynı satıra düşer', function () {
    // Korpusun büyük çoğunluğu ayrım yapmıyor; o satırlar GENEL etiketi
    // taşımayı sürdürüyor ve zincir iki kademe: 'ESCI' → 'ESCI / Scopus' →
    // 'WoS / Scopus'. Tek adım atan bir eşleştirici bu satırları kapsamlı
    // kayda kapatır, aday puanını SESSİZCE kaybederdi.
    $katalog = sartDepo()->katalog('ankara-2023');

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Atif, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan('ESCI'))->toBe($puan('Scopus'))
        ->and($puan('ESCI'))->toBe($puan('SCIE/SSCI/AHCI'))
        ->and($puan('ESCI'))->toBeGreaterThan(0);
});

/**
 * SCOPUS ÇEYREKLİĞİ: kaynak Scopus dergilerini çeyrekliğe göre puanlıyorsa
 * dört basamak da kendi değerinde olmalı.
 *
 * 17.09.2026'da 175 kaynak tarandı. Değerler kaynaktan okundu.
 */
test('Scopus çeyrekliği ayrı puanlanıyor', function (string $cetvel, array $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    $gercek = [];

    foreach ([1, 2, 3, 4] as $q) {
        $gercek["Q{$q}"] = $puan("Scopus (Q{$q})");
    }

    expect($gercek)->toBe($beklenen);
})->with([
    // Çukurova'nın AYRI Scopus merdiveni hiç girilmemişti.
    ['cukurova-2024', ['Q1' => 75, 'Q2' => 45, 'Q3' => 15, 'Q4' => 10]],
    // Haliç'in merdiveni zaten Scopus çeyrekliği; WoS etiketine bağlıydı.
    ['halic-2026', ['Q1' => 50, 'Q2' => 40, 'Q3' => 30, 'Q4' => 20]],
    ['hitit-2026', ['Q1' => 20, 'Q2' => 18, 'Q3' => 16, 'Q4' => 10]],
    // Gümüşhane ÇAPRAZ eşliyor: Scopus çeyrekliği WoS'unkinden bir basamak
    // yukarı sayılıyor ("WOS Q2 VEYA SCOPUS Q1" 28). Scopus Q4 ise ESCI ile
    // birlikte A2'de (15).
    ['gumushane-2026', ['Q1' => 28, 'Q2' => 22, 'Q3' => 18, 'Q4' => 15]],
]);

test('dilim ekseni Q1\'in ALT KÜMESİ olarak çalışıyor', function () {
    // Haliç kaynağı iki satır ayırıyor: "Scopus Q1 makale (En üst %10'luk
    // dilim) 70" ve "Scopus Q1 (Diğer) makale 50". Üst dilim Q1'in yerine
    // GEÇMEZ, altına girer — Q1'de olup dilime girmeyen dergi 50'de kalır.
    $katalog = sartDepo()->katalog('halic-2026');

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan('Scopus (İlk %10)'))->toBe(70)
        ->and($puan('Scopus (Q1)'))->toBe(50);

    // Dilim etiketi hem KENDİ satırına hem Q1 satırına düşebilir; `puan()`
    // yükseği aldığı için 70 kazanır. Yalnız Q1 satırı çözüldüğünde 50.
    expect($katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => 'Scopus (İlk %10)', 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        ['EK1.A2'],
    ))->toBe(50);

    // Aday her iki kademeyi de seçebilmeli: Q1 genel etiket DEĞİL.
    expect(Kategori::Makale->adayKaynaklari())
        ->toContain('Scopus (Q1)')
        ->toContain('Scopus (İlk %10)');
});

test('WoS ilk %10 dilimi Q1\'den ayrı puanlanıyor', function (string $cetvel, int $dilim, int $q1) {
    // Beş kaynak Q1'in üstünde bir kademe daha tanıyor. Sözlükte karşılığı
    // olmadığı için satırlar ya hiç girilmemiş ya da §0 uyarınca Q1 değerine
    // düşürülmüştü; dilime giren makale Q1 puanı alıyordu.
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan('SCIE/SSCI (İlk %10)'))->toBe($dilim)
        ->and($puan('SCIE/SSCI (Q1)'))->toBe($q1)
        ->and($dilim)->toBeGreaterThan($q1);
})->with([
    ['cukurova-2024', 120, 90],
    ['harran-2026', 63, 42],                       // ham 90/60, ×0,7
    ['akdeniz-2026-edebiyat-profesor', 450, 300],  // satır ölüydü, dirildi
    ['erciyes-2024', 80, 60],
    ['ahi-evran-2024', 50, 30],
]);

test('Necmettin Erbakan üç dilim kademesini de ayırıyor', function () {
    // Kaynağın TABLO-1'i (sayfa 14, görüntüden okundu) Q1'in üstünde ÜÇ
    // kademe tanıyor. Q1'in 100'ü kaynağın kendi sözleriyle "%1-%10 dilimler
    // DIŞINDAKİ" demek — yani dilim kademeleri Q1'in yerine geçmiyor, üstüne
    // biniyor.
    $katalog = sartDepo()->katalog('necmettin-erbakan-2026');

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan('SCIE/SSCI (İlk %1)'))->toBe(200)
        ->and($puan('SCIE/SSCI (İlk %5)'))->toBe(175)
        ->and($puan('SCIE/SSCI (İlk %10)'))->toBe(150)
        ->and($puan('SCIE/SSCI (Q1)'))->toBe(100)
        ->and($puan('SCIE/SSCI (Q2)'))->toBe(85);

    // Zincir üç kademeli: %1 ⊂ %5 ⊂ %10 ⊂ Q1. Yalnız Q1 satırı çözüldüğünde
    // en dar kayıt da oraya düşer.
    expect($katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => 'SCIE/SSCI (İlk %1)', 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        ['A1.q1'],
    ))->toBe(100);
});

/**
 * SCOPUS, ESCI KADEMESİNE SIZMIYOR.
 *
 * `ESCI / Scopus` GENEL bir etiket: "ESCI ya da Scopus" demek. Bir kaynak bu
 * ikisini birlikte anıyorsa doğru araç. Anmıyorsa Scopus kaydı ESCI'nin
 * puanını alır — korpusta 27 üniversitede oluyordu (Kırklareli'nde 150'ye
 * karşı 70).
 *
 * KARAR (KONVANSIYONLAR, "SCOPUS ALAN İNDEKSİ MİDİR"): soruyu korpus değil
 * HER KAYNAK kendi cevaplar, çünkü korpusun metinleri ikiye bölünmüş — Ankara
 * Bilim "Alan indeksi: WOS, SCOPUS ve ÜAK listesi" diye Scopus'u İÇERİYOR,
 * Trakya "ESCI ve SCOPUS DIŞINDAKİ uluslararası alan indeksleri" diye
 * DIŞLIYOR. Kaynak susuyorsa §0: cevap HAYIR, Scopus bir alt kademeye düşer.
 *
 * Bu test o kararın uygulanmış hâlini donduruyor. Listedeki her satır
 * kaynağında gerekçelidir; liste BÜYÜYORSA yeni bir cetvel Scopus'u ESCI
 * kademesinde sayıyor demektir, KÜÇÜLÜYORSA bir gerekçeli satır kaybolmuştur.
 */
/**
 * MAKALE VE TEZ YAYININDA SCOPUS ÇEYREKLİĞİ.
 *
 * Sözlük 17.09.2026'da makale tarafına `Scopus (Q1..Q4)` ekledi ama beş
 * cetvelde satırlar ESKİ eşlemeyle kaldı: başlığı "Scopus Q1 dergide makale"
 * diyen satır `SCIE/SSCI (Q1)` taşıyordu, Scopus kaydı ise en alttaki genel
 * `ESCI / Scopus` satırına düşüyordu. Hepsi EKSİK sayıyordu.
 *
 * Tez yayınında ayrı bir kırık vardı: karşılık tablosu (`TEZ_KARSILIKLARI`)
 * sözlük bölünmeden önceki GENEL adlarda kalmıştı, adaya sorulan kapsamlı
 * etiketler (ESCI, Scopus çeyrekleri, uluslararası/ulusal kitap, "diğer"in
 * iki kolu) hiçbir anahtara düşmüyor ve SIFIR alıyordu.
 */
test('makale ve tez yayınında Scopus çeyrekliği kendi basamağına düşüyor', function () {
    $puan = function (string $cetvel, string $etiket, Kategori $kategori = Kategori::Makale): int {
        $katalog = sartDepo()->katalog($cetvel);

        expect($katalog)->not->toBeNull();

        $faaliyet = sartFaaliyet($etiket, $kategori);
        $faaliyet->yayin_turu = 'ozgun_makale';

        return $katalog->puan($faaliyet, $katalog->coz(['*']));
    };

    // BAÜ: satır başlıkları zaten "Scopus veri tabanında Qn olarak taranan".
    expect($puan('bau-2025', 'Scopus (Q1)'))->toBe(24)
        ->and($puan('bau-2025', 'Scopus (Q2)'))->toBe(18)
        ->and($puan('bau-2025', 'Scopus (Q3)'))->toBe(12)
        ->and($puan('bau-2025', 'Scopus (Q4)'))->toBe(8);

    // Sakarya ÇAPRAZ eşliyor: Scopus Q1 ≈ WoS Q2 basamağı. Scopus Q4'ün
    // kendi satırı var (1.2a) ve ESCI'ninki (1.2b) ondan ayrıldı.
    expect($puan('sakarya-2026', 'Scopus (Q1)'))->toBe(80)
        ->and($puan('sakarya-2026', 'Scopus (Q2)'))->toBe(55)
        ->and($puan('sakarya-2026', 'Scopus (Q3)'))->toBe(45)
        ->and($puan('sakarya-2026', 'Scopus (Q4)'))->toBe(25)
        ->and($puan('sakarya-2026', 'SCIE/SSCI (Q1)'))->toBe(90);

    // NEÜ'nün A1 merdiveni kaynağın sözleriyle "SCI-Expanded, SSCI, AHCI
    // VEYA SCOPUS". Scopus çeyreksiz sayıldığı için hepsi Q4'e düşüyordu.
    expect($puan('necmettin-erbakan-2026', 'Scopus (Q1)'))->toBe(100)
        ->and($puan('necmettin-erbakan-2026', 'Scopus (Q4)'))->toBe(60)
        // Çeyreksiz kayıt §0 uyarınca merdivenin en altında kalıyor.
        ->and($puan('necmettin-erbakan-2026', 'Scopus'))->toBe(60)
        // ESCI kaynakta AYRI bir satır (A2, 50); merdivene karışmıyor.
        ->and($puan('necmettin-erbakan-2026', 'ESCI'))->toBe(50);

    // OSTİM: başlık yalnız Scopus'un ÜST çeyreğini anıyor ("… ya da Scopus
    // (Q1) kapsamındaki"); alt çeyrekler alan indeksi satırında kalıyor.
    expect($puan('ostim-teknik-2024', 'Scopus (Q1)'))->toBe(70)
        ->and($puan('ostim-teknik-2024', 'Scopus (Q2)'))->toBe(5);

    // TEZ YAYINI: kapsamlı etiketler karşılık tablosunda yoktu, sıfır
    // alıyorlardı. İYTE EK-1'de ESCI/Scopus makale tarafında da üst kademede
    // değil, tez satırında da 2b'ye (5) ait; EK-2'de 2a (10) ikisini de sayıyor.
    expect($puan('iyte-2018-e1-dr', 'SCIE/SSCI/AHCI', Kategori::TezYayini))->toBe(10)
        ->and($puan('iyte-2018-e1-dr', 'ESCI', Kategori::TezYayini))->toBe(5)
        ->and($puan('iyte-2018-e1-dr', 'Scopus (Q1)', Kategori::TezYayini))->toBe(5)
        ->and($puan('iyte-2018-e2-dr', 'ESCI', Kategori::TezYayini))->toBe(10)
        ->and($puan('iyte-2018-e2-dr', 'Scopus (Q1)', Kategori::TezYayini))->toBe(10)
        // "Diğer"in iki kolu da karşılık buluyor.
        ->and($puan('iyte-2018-e1-dr', 'Diğer (Uluslararası)', Kategori::TezYayini))->toBe(5);

    // Adaya sorulan HER tez etiketinin karşılık tablosunda bir anahtarı var;
    // yoksa kayıt sessizce sıfır alır.
    $karsiliksiz = array_values(array_filter(
        Kategori::TezYayini->adayKaynaklari(),
        fn (string $etiket) => ! MaddeKatalogu::tezKarsiligiVar($etiket),
    ));

    expect($karsiliksiz)->toBe([]);
});

/**
 * EDİTÖRLÜKTE SCOPUS ÇEYREKLİĞİ.
 *
 * Sözlüğün editörlük tarafı Scopus dergilerini tek etiketle taşıyordu
 * (`Scopus Dergi`). Üç kaynak çeyreğe göre AYRI puanlıyor; etiket tek olduğu
 * için ya satır hiç bağlanamıyordu (Acıbadem) ya da bütün çeyrekler en düşük
 * kademeye düşüyordu (BAÜ). 18.09.2026'da `Scopus Dergi (Q1..Q4)` eklendi;
 * çeyreksiz `Scopus Dergi` artık yalnız cetvel tarafında.
 */
test('editörlükte Scopus çeyrekliği ayrı puanlanıyor', function () {
    $puan = function (string $cetvel, string $etiket): int {
        $katalog = sartDepo()->katalog($cetvel);

        expect($katalog)->not->toBeNull();

        return $katalog->puan(sartFaaliyet($etiket, Kategori::Editorluk), $katalog->coz(['*']));
    };

    // Acıbadem 2.G: "WoS All Databases ya da SCOPUS Q1-Q2 kapsamındaki
    // dergide editörlük". Q3-Q4'ün kaynakta karşılığı yok — 3. bölüm TR
    // Dizin'e ait. Satırın Scopus tarafı çeyreklik gelene kadar bağlanamıyordu.
    expect($puan('acibadem-2025-atif6', 'Scopus Dergi (Q1)'))->toBe(5)
        ->and($puan('acibadem-2025-atif6', 'Scopus Dergi (Q2)'))->toBe(5)
        ->and($puan('acibadem-2025-atif6', 'Scopus Dergi (Q3)'))->toBe(0)
        ->and($puan('acibadem-2025-atif6', 'Scopus Dergi (Q4)'))->toBe(0)
        // WoS All Databases tarafı (ESCI) çeyrekten bağımsız.
        ->and($puan('acibadem-2025-atif6', 'ESCI Dergi'))->toBe(5);

    // BAÜ A-5 bloğunun başlığı "Scopus dergi editörlüğü": Q1 50, Q2 40,
    // Q3 20. Q4 kademesi ve ayrı bir ESCI kademesi YOK, ikisi de sıfır —
    // kapsam notunda yazılı.
    expect($puan('bau-2025', 'Scopus Dergi (Q1)'))->toBe(50)
        ->and($puan('bau-2025', 'Scopus Dergi (Q2)'))->toBe(40)
        ->and($puan('bau-2025', 'Scopus Dergi (Q3)'))->toBe(20)
        ->and($puan('bau-2025', 'Scopus Dergi (Q4)'))->toBe(0)
        ->and($puan('bau-2025', 'ESCI Dergi'))->toBe(0);

    // Sakarya çeyrek ayırmıyor ama SCOPUS'u ÜST kademede anıyor: "SSCI,
    // SCI-Exp, AHCI, SCOPUS kapsamındaki dergilerde baş editörlük" 40.
    // Scopus, ESCI'nin 25'ine düşüyordu; çeyreksiz etiket üst satıra bağlandı.
    expect($puan('sakarya-2026', 'Scopus Dergi (Q1)'))->toBe(40)
        ->and($puan('sakarya-2026', 'Scopus Dergi (Q4)'))->toBe(40)
        ->and($puan('sakarya-2026', 'ESCI Dergi'))->toBe(25);

    // Çeyreksiz kayıt adaya sorulmuyor ama cetvel tarafında zinciri kuruyor:
    // her çeyreklik `Scopus Dergi`e çıkar, tersi olmaz.
    expect(Kategori::Editorluk->adayKaynaklari())->not->toContain('Scopus Dergi')
        ->and(Kategori::Editorluk->kaynaklar())->toContain('Scopus Dergi (Q1)');
});

/**
 * ATIF VE EDİTÖRLÜKTE ESCI DE KAYNAĞIN ANDIĞI KADEMEDE KALIYOR.
 *
 * Scopus turunda `WoS / Scopus` çekirdek satırdan alındığında ESCI de o
 * satırda kalmıştı — satır "SCI, SCI-Expanded, SSCI veya AHCI dergisinde
 * atıf" dediği hâlde. Aynı kural ESCI'ye de uygulandı: kademe kapalı bir
 * liste sayıyor ve ESCI listede yoksa, ESCI o değeri almaz.
 *
 * ESCI'nin indiği yer kaynağa göre değişiyor:
 *   – Altında AÇIK bir kademe varsa ("diğer hakemli dergilerde atıf")
 *     oraya iner (Akdeniz 5 → 2, İstanbul Ticaret 10 → 3).
 *   – Kaynağın tek uluslararası kademesi çekirdek indeksse ve altında yalnız
 *     ULUSAL kademe varsa SIFIR alır: yönerge o kalemi saymıyor.
 *
 * Listede kalanlar gerekçeli; büyürse yeni bir cetvel ESCI'yi hak etmediği
 * kademede sayıyordur.
 */
test('atıf ve editörlükte ESCI kaynağın saydığı kademede kalıyor', function () {
    $harita = cetvelDosyaHaritasi();
    $depo = sartDepo();

    $eksenler = [
        'atif' => [Kategori::Atif, 'ESCI', ['Diğer (Uluslararası)', 'Scopus (Q1)'],
            ['ESCI', 'ESCI / Scopus', 'WoS / Scopus']],
        'editorluk' => [Kategori::Editorluk, 'ESCI Dergi',
            ['Diğer Hakemli Dergi (Uluslararası)', 'Diğer Hakemli Dergi', 'Scopus Dergi'],
            ['ESCI Dergi', 'ESCI / Scopus Dergi']],
    ];

    $bulgular = [];

    foreach ($eksenler as $eksen => [$kategori, $esciEtiketi, $altEtiketler, $jenerikler]) {
        foreach ($depo->cetveller() as $anahtar => $katalog) {
            $kodlar = $katalog->coz(['*']);

            $puan = fn (string $etiket): int => $katalog->puan(
                sartFaaliyet($etiket, $kategori), $kodlar,
            );

            $esci = $puan($esciEtiketi);

            if ($esci === 0 || $esci <= max(array_map($puan, $altEtiketler))) {
                continue;
            }

            foreach ($katalog->maddeler as $kod => $madde) {
                if (($madde['kategori'] ?? '') !== $eksen || ($madde['puan'] ?? null) !== $esci) {
                    continue;
                }

                if (! array_intersect($madde['kaynaklar'] ?? [], $jenerikler)) {
                    continue;
                }

                if (preg_match('/e-?sci/u', mb_strtolower($madde['baslik'])) !== 1) {
                    $bulgular[$eksen][($harita[$anahtar] ?? $anahtar).':'.$kod] = true;
                }

                break;
            }
        }
    }

    $atif = array_keys($bulgular['atif'] ?? []);
    $editorluk = array_keys($bulgular['editorluk'] ?? []);
    sort($atif);
    sort($editorluk);

    expect($atif)->toBe([
        // Bingöl'ün kendi atıf barajı ESCI'yi çekirdekle birlikte anıyor:
        // "AHCI, SCI-Exp, ESCI ve SSCI kapsamında atıfı bulunmayanların…".
        'bingol-2024:3.c',
        // Satır zaten ESCI kademesi: "ISI (WoS) taranan; SCI, SCI-Expanded,
        // SSCI ve AHCI KAPSAMI DIŞINDAKİ dergilerdeki atıf".
        'bolu-aibu-2024:A.9.2',
        // "WoS All Databases" ESCI'yi kapsıyor; Scopus'un ayrı satırı var.
        'ktu-2023:3.b',
    ])->and($editorluk)->toBe([
        // "WoS All Databases ya da SCOPUS Q1-Q2" — All Databases ESCI'yi
        // kapsıyor, satırın Scopus tarafı da 18.09.2026'da çeyreklik
        // eklenince bağlandı (Q1-Q2 var, Q3-Q4 yok).
        'acibadem-2025:2.G',
        // Dicle ESCI'yi cetvelin HER YERİNDE "uluslararası alan endeksi"
        // sayıyor: makale A3 de "Diğer uluslararası alan endekslerince
        // taranan dergide araştırma makalesi" başlığıyla ESCI'ye bağlı.
        'dicle-2023:G3',
    ]);
});

/**
 * SCOPUS, ATIF VE EDİTÖRLÜK EKSENİNDE DE KAYNAĞIN ANDIĞI KADEMEDE KALIYOR.
 *
 * Makale ekseninde verilen karar (KONVANSIYONLAR, "SCOPUS ALAN İNDEKSİ
 * MİDİR") atıf ve editörlüğe de uygulandı. Buradaki iki jenerik etiket aynı
 * riski taşıyor: atıfta `WoS / Scopus` çekirdek indeks satırına konduğunda
 * Scopus atfı çekirdek değerini alıyordu (Kırklareli 150, Ataşehir 10),
 * editörlükte `ESCI / Scopus Dergi` ESCI satırına konduğunda aynısı oluyordu.
 *
 * Liste, Scopus'un alt kademeden YÜKSEK puan aldığı ve satır başlığının
 * Scopus'u anmadığı yerleri donduruyor. Hepsi kaynağında gerekçeli: satır ya
 * AÇIK yazılmış ("uluslararası indeksli hakemli dergi", "diğer endeks ve
 * özlerce taranan dergi", "yurt dışı dergide editörlük") ve Scopus oraya
 * kesin giriyor, ya da kaynak alan indeksini Scopus'u içerecek şekilde
 * tanımlıyor (Bitlis, Gebze, MSGSÜ, Dokuz Eylül, Ankara Bilim).
 *
 * Liste BÜYÜRSE yeni bir cetvel Scopus'u hak etmediği kademede sayıyordur.
 */
test('Scopus atıf ve editörlük kademelerinde de kaynağın sınırında kalıyor', function () {
    $harita = cetvelDosyaHaritasi();
    $depo = sartDepo();

    $eksenler = [
        'atif' => [Kategori::Atif, 'Scopus (Q1)', ['Diğer (Uluslararası)'],
            ['ESCI / Scopus', 'WoS / Scopus', 'Scopus', 'Scopus (Q1)']],
        'editorluk' => [Kategori::Editorluk, 'Scopus Dergi',
            ['Diğer Hakemli Dergi (Uluslararası)', 'Diğer Hakemli Dergi'],
            ['ESCI / Scopus Dergi', 'Scopus Dergi']],
    ];

    $bulgular = [];

    foreach ($eksenler as $eksen => [$kategori, $scopusEtiketi, $altEtiketler, $jenerikler]) {
        foreach ($depo->cetveller() as $anahtar => $katalog) {
            $kodlar = $katalog->coz(['*']);

            $puan = fn (string $etiket): int => $katalog->puan(
                sartFaaliyet($etiket, $kategori), $kodlar,
            );

            $scopus = $puan($scopusEtiketi);

            if ($scopus === 0 || $scopus <= max(array_map($puan, $altEtiketler))) {
                continue;
            }

            foreach ($katalog->maddeler as $kod => $madde) {
                if (($madde['kategori'] ?? '') !== $eksen || ($madde['puan'] ?? null) !== $scopus) {
                    continue;
                }

                if (! array_intersect($madde['kaynaklar'] ?? [], $jenerikler)) {
                    continue;
                }

                if (! str_contains(mb_strtolower($madde['baslik']), 'scopus')) {
                    $bulgular[$eksen][($harita[$anahtar] ?? $anahtar).':'.$kod] = true;
                }

                break;
            }
        }
    }

    $atif = array_keys($bulgular['atif'] ?? []);
    $editorluk = array_keys($bulgular['editorluk'] ?? []);
    sort($atif);
    sort($editorluk);

    expect($atif)->toBe([
        'abdullah-gul-2026:AT-A',
        'adana-alparslan-turkes-2026:K2',
        'adu-2024:A5.2.2',
        'afyon-2026:8.3',
        'afyon-saglik-2018:G.2-G.3',
        'alanya-2024:A.5',
        'alku-2024:2.4',
        'anadolu-2023:24',
        'ankara-bilim-2023:1.7.1',
        'burdur-2016:M20',
        'cag-2023:H1',
        'dogus-2022:H-1',
        'dpu-2024:D11',
        'esogu-2023:6a',
        'gebze-teknik-2023:5.1',
        'isparta-ubu-2022:T2-AT1',
        'istanbul-29-mayis-2017:D19',
        'istanbul-aydin-2020:A11',
        'istanbul-gedik-2025:D1',
        'istanbul-medeniyet-2018:7a',
        'istanbul-ticaret-2019:I.D.6.c',
        'istanbul-zaim-2019:E',
        'iyte-2018:E1-5a',
        'iyte-2018:E2-5a',
        'iyte-2018:E3-4a',
        'kahramanmaras-istiklal-2024:A4.1',
        'karabuk-2024:4.10.2',
        'karatay-2024:A.6.b',
        'kayseri-2024:T2-2a',
        'kilis-2019:4.a',
        'kirikkale-2022:411-2',
        'kocaeli-2023:D1',
        'kostu-2023:27',
        'ksbu-2023:E2',
        'ksu-2023:T1-10a',
        'ktun-2024:G-1',
        'lokman-hekim-2022:T2-atif-sci',
        'marmara-egitim:47',
        'marmara-fen-saglik:47',
        'marmara-guzel-sanatlar:47',
        'marmara-ilahiyat-hukuk-filoloji:47',
        'marmara-muhendislik:47',
        'marmara-sosyal:47',
        'marmara-spor:47',
        'msgsu-2023:1.8.1',
        'mtu-2025:D4',
        'mus-alparslan-2025:A5.2',
        'musku-2013:E-1',
        'nohu-2024:7a',
        'osmaniye-2023:5.1',
        'siirt-2025:5.a',
        'sirnak-2024:4.1',
        'toros-2024:D.1',
        'trabzon-2025:3.2.1',
        'usak-2020:6a',
        'uskudar-2024:M1.9.1',
        'yeni-yuzyil-2025:1.A.37',
        'yildiz-teknik-2022:4a',
    ])->and($editorluk)->toBe([
        'adiyaman-2024:F.2.a',
        'adu-2024:D7.2.3',
        'alku-2024:2.10',
        'ankara-bilim-2023:3.1.4',
        'atasehir-adiguzel-2018:M14.a',
        'bandirma-2024:A7.a',
        'bayburt-2024:8.1.ç',
        'bitlis-2024:C.2.1',
        'burdur-2016:M13',
        'cag-2023:M',
        'dogus-2022:M',
        'dokuz-eylul-2024:9.f',
        'dpu-2024:E15',
        'duzce-2024:2.2.a',
        'gebze-teknik-2023:10.9',
        'giresun-2019:I.3.a',
        'igdir-2023:14.a',
        'isparta-ubu-2022:T2-ED1',
        'istanbul-29-mayis-2017:D29',
        'istanbul-aydin-2020:A07',
        'istanbul-ticaret-2019:I.D.5.b',
        'istanbul-zaim-2019:N',
        'izmir-kavram-2025:11b',
        'kahramanmaras-istiklal-2024:A6.4.a',
        'karabuk-2024:4.7.2',
        'karamanoglu-2024:E-2',
        'kayseri-2024:T2-5a',
        'kilis-2019:8.a',
        'ksbu-2023:K-a2',
        'ksu-2023:T3-6a',
        'lokman-hekim-2022:T2-editor-u',
        'manisa-cbu-2024:25b',
        'marmara-egitim:41',
        'marmara-fen-saglik:41',
        'marmara-guzel-sanatlar:41',
        'marmara-ilahiyat-hukuk-filoloji:18b',
        'marmara-muhendislik:41',
        'marmara-sosyal:41',
        'marmara-spor:41',
        'mef-2024:12.a',
        'msgsu-2023:3.1.4',
        'mtu-2025:E1.2.1',
        'musku-2013:D-2',
        'osmaniye-2023:9.2',
        'piri-reis-2025:J.1.a',
        'sakarya-ubu-2024:9.1',
        'sbu-2025:A.10.a',
        'siirt-2025:8.ii.a',
        'sirnak-2024:8.1',
        'trabzon-2025:3.1.2.2',
        'trakya-2025:12b',
        'uskudar-2024:M1.7.A.4',
        'yeni-yuzyil-2025:3.C.9',
    ]);
});

test('Scopus yalnızca kaynağın andığı kademede ESCI ile aynı puanı alıyor', function () {
    $depo = sartDepo();

    $bulgular = [];

    foreach ($depo->cetveller() as $anahtar => $katalog) {
        $kodlar = $katalog->coz(['*']);

        foreach (['ozgun_makale', 'derleme', 'kisa_makale', 'vaka_teknik_not'] as $tur) {
            $puan = function (string $etiket) use ($katalog, $kodlar, $tur): int {
                $faaliyet = sartFaaliyet($etiket);
                $faaliyet->yayin_turu = $tur;

                return $katalog->puan($faaliyet, $kodlar);
            };

            $esci = $puan('ESCI');
            $scopus = $puan('Scopus (Q1)');

            // Scopus ESCI ile AYNI kademeye düşüyor ve altında daha dar bir
            // uluslararası indeks kademesi var: kaynak Scopus'u anmıyorsa
            // fazla sayma.
            if ($scopus === 0 || $scopus !== $esci || $scopus <= $puan('Diğer Uluslararası İndeks')) {
                continue;
            }

            foreach ($katalog->maddeler as $kod => $madde) {
                if (($madde['kategori'] ?? '') !== 'makale' || ($madde['puan'] ?? null) !== $scopus) {
                    continue;
                }

                if (! array_intersect($madde['kaynaklar'] ?? [], ['ESCI / Scopus', 'Scopus', 'Scopus (Q1)'])) {
                    continue;
                }

                if (isset($madde['turler']) && ! in_array($tur, $madde['turler'], true)) {
                    continue;
                }

                if (! str_contains(mb_strtolower($madde['baslik']), 'scopus')) {
                    $bulgular["{$anahtar}:{$kod}"] = true;
                }

                break;
            }
        }
    }

    $bulunan = array_keys($bulgular);
    sort($bulunan);

    // Başlığı Scopus demediği hâlde Scopus'u ESCI kademesinde sayan satırlar.
    // Hepsi kaynağında gerekçeli: Ankara Bilim, Bitlis, Gebze ve Niğde
    // "alan indeksi"ni Scopus'u İÇERECEK şekilde tanımlıyor; Ataşehir, Iğdır,
    // İYTE, Kilis ve Marmara kademeyi AÇIK yazıyor ("uluslararası indeksli
    // hakemli dergi", "ikincil indeksler") ve Scopus oraya kesin giriyor;
    // Bandırma, Lokman Hekim ve Atatürk koşul metninde ESCI ile Scopus'u yan
    // yana sayıyor; Aksaray ve Abdullah Gül'de satır Scopus'u adıyla anan
    // başka bir satıra ATIF yapıyor.
    expect($bulunan)->toBe([
        'abdullah-gul-2026:M-Q3Q4-KISA',
        'aksaray-2024:A.7',
        'ankara-bilim-2023:1.2.1.c',
        'ankara-bilim-2023:1.2.1.d',
        'atasehir-adiguzel-2018:M2.a',
        'atasehir-adiguzel-2018:M2.b',
        'ataturk-2026:02.01.07',
        'bandirma-2024:A4.a',
        'bandirma-2024:A4.b',
        'bitlis-2024:A.2.2',
        'dokuz-eylul-2024:1.b',
        'dokuz-eylul-2024:2.b',
        'dokuz-eylul-2024:3.b',
        'gebze-teknik-2023-mf-docent:1.2',
        'gebze-teknik-2023-mf-dr:1.2',
        'gebze-teknik-2023-mf-profesor:1.2',
        'gebze-teknik-2023-mpt-docent:1.2',
        'gebze-teknik-2023-mpt-dr:1.2',
        'gebze-teknik-2023-mpt-profesor:1.2',
        'gebze-teknik-2023-sbi-docent:1.2',
        'gebze-teknik-2023-sbi-dr:1.2',
        'gebze-teknik-2023-sbi-profesor:1.2',
        'harran-2026:A1e',
        'igdir-2023:2.a',
        'igdir-2023:2.b',
        'iyte-2018-e2-docent:E2-1a',
        'iyte-2018-e2-dr:E2-1a',
        'iyte-2018-e2-profesor:E2-1a',
        'iyte-2018-e3:E3-1b',
        'iyte-2018-e3:E3-1c',
        'kafkas-2025-ilahiyat:M-e-esci',
        'kilis-2019:1.a',
        'kilis-2019:1.b',
        'lokman-hekim-2022:T1-A-esci',
        'lokman-hekim-2022:T1-C-esci',
        'lokman-hekim-2022:T1-D-esci',
        'marmara-egitim:3',
        'marmara-fen-saglik:3',
        'marmara-fen-saglik:5',
        'marmara-guzel-sanatlar:3',
        'marmara-guzel-sanatlar:5',
        'marmara-muhendislik:3',
        'marmara-muhendislik:5',
        'marmara-sosyal:3',
        'marmara-sosyal:5',
        'marmara-spor:3',
        'nohu-2024:1b',
    ]);
});

test('Erzincan Q çarpanını yalnızca çekirdek indekse uyguluyor', function () {
    // Kaynak (s. 12): "Puanlamada makalenin yayımlandığı tarihteki derginin
    // Q değerleri dikkate alınır ve aşağıdaki katsayılarla çarpılır:
    // Q1 2,00 / Q2 1,70 / Q3 1,35 / Q4 1,00." Yazar Puanı = YKK × YP × QÇ.
    // Motorun satır bazlı çarpanı yok; QÇ satır puanına gömüldü.
    $katalog = sartDepo()->katalog('erzincan-2021');

    $puan = fn (string $etiket, string $yayinTuru) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'yayin_turu' => $yayinTuru,
            'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    // 1.a "Tam araştırma makalesi veya derleme" 40 — tek satır, iki tür.
    // Çarpım tam sayıya oturuyor, yuvarlama kaybı yok.
    foreach (['ozgun_makale', 'derleme'] as $tur) {
        expect($puan('SCIE/SSCI (Q1)', $tur))->toBe(80)
            ->and($puan('SCIE/SSCI (Q2)', $tur))->toBe(68)
            ->and($puan('SCIE/SSCI (Q3)', $tur))->toBe(54)
            ->and($puan('SCIE/SSCI (Q4)', $tur))->toBe(40);
    }

    // 1.b "Kısa makale (editöre mektup, teknik not, vaka takdimi, tartışma,
    // kitap incelemesi)" 20 — aynı çarpanlar.
    foreach (['kisa_makale', 'vaka_teknik_not'] as $tur) {
        expect($puan('SCIE/SSCI (Q1)', $tur))->toBe(40)
            ->and($puan('SCIE/SSCI (Q2)', $tur))->toBe(34)
            ->and($puan('SCIE/SSCI (Q3)', $tur))->toBe(27)
            ->and($puan('SCIE/SSCI (Q4)', $tur))->toBe(20);
    }

    // AHCI dergilerinin çeyreği çoğu zaman yayımlanmıyor; §0 gereği en düşük
    // çarpan (Q4, ×1,00) varsayıldı. Bu bir TABAN: kaynak "en yüksek Q değeri
    // alınır" dediği için adayın Scopus/SJR çeyreği varsa Q etiketini seçmesi
    // gerekir, kapsam notunda yazılı.
    expect($puan('AHCI', 'ozgun_makale'))->toBe(40)
        ->and($puan('AHCI', 'kisa_makale'))->toBe(20);

    // Q TANIMI YALNIZCA SCI-Expanded/SSCI/AHCI'yi kapsıyor (kaynak s. 12).
    // 2-5. maddelere çarpan uygulanmaz; çeyreklik taşıyan bir kayıt 30'u 60'a
    // çıkarmamalı. Scopus ise 2. maddede DEĞİL: kaynak 2. maddeyi "ESCI veya
    // Alan İndeksleri" diye tanımlayıp Scopus'u hiç anmıyor, §0 gereği 3.
    // maddeye (diğer indeksli uluslararası dergi) düşürüldü.
    expect($puan('ESCI', 'ozgun_makale'))->toBe(30)
        ->and($puan('Scopus (Q1)', 'ozgun_makale'))->toBe(12)
        ->and($puan('TR Dizin', 'ozgun_makale'))->toBe(20)
        ->and($puan('Diğer Uluslararası İndeks', 'ozgun_makale'))->toBe(12)
        ->and($puan('Diğer Ulusal Hakemli', 'ozgun_makale'))->toBe(10);
});

test('İnönü dilim çarpanını önceden çarpılmış satır olarak taşıyor', function () {
    // MADDE 7(2): "Makalenin puan değeri, yayımlandığı derginin Incites veya
    // SciVal veri tabanlarında %1'lik dilimde yer alması hâlinde 3, %10'luk
    // dilimde yer alması hâlinde 1,5 ile çarpılır." Motorun satır bazlı
    // çarpanı yok; çarpım ÖNCEDEN yapılıp ayrı satıra yazıldı.
    $katalog = sartDepo()->katalog('inonu-2026');

    $puan = fn (string $etiket, string $yayinTuru) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'yayin_turu' => $yayinTuru,
            'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    // Özgün makale: 200 × 3 = 600, 200 × 1,5 = 300.
    expect($puan('SCIE/SSCI (İlk %1)', 'ozgun_makale'))->toBe(600)
        ->and($puan('SCIE/SSCI (İlk %10)', 'ozgun_makale'))->toBe(300)
        ->and($puan('SCIE/SSCI (Q1)', 'ozgun_makale'))->toBe(200)
        // Kaynak %5 kademesi tanımıyor; zincir onu %10'a düşürüyor.
        ->and($puan('SCIE/SSCI (İlk %5)', 'ozgun_makale'))->toBe(300)
        // Çarpan "makalenin puan değeri"ne bağlı, derlemeye de işliyor.
        ->and($puan('SCIE/SSCI (İlk %1)', 'derleme'))->toBe(198)
        ->and($puan('SCIE/SSCI (İlk %10)', 'derleme'))->toBe(99)
        ->and($puan('SCIE/SSCI (Q1)', 'derleme'))->toBe(66);

    // Dilim satırı Q1'in ALT KÜMESİ: adet barajları onu hâlâ bir Q1-Q3
    // makalesi olarak saymalı. Gruba eklenmezse baraj sessizce eksik sayar.
    expect($katalog->coz(['Q1-Q3']))->toContain('A.1.a.d1')
        ->and($katalog->coz(['SCI-E']))->toContain('A.1.a.d10');

    expect($katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => 'SCIE/SSCI (İlk %1)', 'yayin_turu' => 'ozgun_makale',
            'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['Q1-Q3']),
    ))->toBe(600);
});

test('Acıbadem 2. bölüm Scopus\'un yalnız Q1-Q2\'sini sayıyor', function () {
    // Kaynağın başlığı: "WEB OF SCIENCE ALL DATABASES veya SCOPUS Q1 ve Q2
    // KATEGORİLERİ KAPSAMINDAKİ DİĞER DERGİLER". Genel `ESCI / Scopus`
    // etiketi dört çeyrekliği birden buraya topluyordu. Q3-Q4'ün kaynakta
    // karşılığı yok (3. bölüm TR Dizin'e ait), o yüzden sıfır — §0 yönünde
    // eksik sayma, dosyada yazılı.
    $katalog = sartDepo()->katalog('acibadem-2025-atif6');

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan('Scopus (Q1)'))->toBe(10)
        ->and($puan('Scopus (Q2)'))->toBe(10)
        ->and($puan('Scopus (Q3)'))->toBe(0)
        ->and($puan('Scopus (Q4)'))->toBe(0)
        // WoS All Databases tarafı (ESCI) çeyreklikten bağımsız sayılıyor.
        ->and($puan('ESCI'))->toBe(10);
});

test('Gümüşhane çapraz eşlemesi WoS tarafını kaydırmıyor', function () {
    // Çaprazın anlamı: aynı puana WoS'un BİR ALT çeyrekliği denk geliyor.
    // WoS tarafı kaymamalı — Q1 35'te kalmalı, yoksa eşleme iki yana birden
    // uygulanmış olur.
    $katalog = sartDepo()->katalog('gumushane-2026');

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Makale, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    expect($puan('SCIE/SSCI (Q1)'))->toBe(35)
        ->and($puan('SCIE/SSCI (Q2)'))->toBe($puan('Scopus (Q1)'))
        ->and($puan('SCIE/SSCI (Q3)'))->toBe($puan('Scopus (Q2)'))
        ->and($puan('SCIE/SSCI (Q4)'))->toBe($puan('Scopus (Q3)'));
});

/**
 * KİTAPTA YAYINEVİ KAPSAMI: kaynak uluslararası ile ulusal yayınevini
 * ayırıyorsa, ADAYIN İNDEKSSİZ uluslararası kitabı da uluslararası satırdan
 * sayılmalı.
 *
 * Korpusta 55 cetvelde "uluslararası yayınevi" başlıklı satır YALNIZ
 * `BKCI / Scopus Kitap` etiketini taşıyordu; ulusal satır ise genel
 * `Uluslararası/Ulusal Kitap` etiketinde kalmıştı. Sonuç sessizdi: BKCI'da
 * taranmayan uluslararası kitap zincirin sonunda ULUSAL satıra düşüyor ve
 * adayın puanı eksik çıkıyordu (Ağrı'da 80 yerine 40).
 *
 * Düzeltme SATIR SATIR yapıldı, çünkü kaynakların üst satırı üç ayrı eksende
 * kapı tutuyor ve yalnız birincisi bu etikete çevrilebiliyor:
 *   1. YAYINEVİNİN YERİ (uluslararası ↔ ulusal) — etiketin tam karşılığı.
 *   2. İNDEKS (BKCI/Scopus/ACQWEB kapsamındaki yayınevi) — kayıtta indeks
 *      bilgisi ancak BKCI etiketiyle var; satır BKCI'da kalır.
 *   3. YAYINEVİNİN NİTELİĞİ ("tanınmış", "saygın", "önde gelen") ya da
 *      KİTABIN DİLİ ("yabancı dilde") — kayıt bu niteliği taşımıyor, §0
 *      uyarınca satır yine BKCI'da kalır.
 *
 * Aşağıdaki değerler kaynak PDF'lerinden okundu; uluslararası satır ulusal
 * satırdan yüksek olduğu için bir geri dönüş burada kırılır.
 */
test('kitapta uluslararası yayınevi satırı kendi kademesinde', function (string $cetvel, array $beklenen) {
    $katalog = sartDepo()->katalog($cetvel);
    expect($katalog)->not->toBeNull();

    $puan = fn (string $etiket) => $katalog->puan(
        new Faaliyet([
            'kategori' => Kategori::Kitap, 'tur' => 'Test', 'baslik' => 'Test',
            'kaynak' => $etiket, 'rol' => 'tek', 'durum' => 'onaylandi',
        ]),
        $katalog->coz(['*']),
    );

    $gercek = [];

    foreach (array_keys($beklenen) as $etiket) {
        $gercek[$etiket] = $puan($etiket);
    }

    expect($gercek)->toBe($beklenen);
})->with([
    // Kaynak 4.1.1 ile 4.1.2'yi yayınevinin yurt içi/dışı olmasına göre
    // ayırıyor, indeks aramıyor. Bölüm satırı tek ve ulusal değerinde (20).
    ['agri-2024', [
        'Uluslararası Kitap' => 80,
        'Ulusal Kitap' => 40,
    ]],
    // A3.1 "uluslararası yayınevleri ya da kuruluşlarca basılmış", A3.2 aynı
    // cümlenin ulusal hâli. Değerler 150 sayfa altı kademesinden (§0).
    ['adu-2024', [
        'Uluslararası Kitap' => 200,
        'Ulusal Kitap' => 100,
        'Uluslararası Kitap Bölümü' => 100,
        'Ulusal Kitap Bölümü' => 50,
    ]],
    // Tanımlar maddesi (t) ve (u): ayrım yayınevinin kendisinde, indeks yok.
    // 3.1 genel etiketi taşıdığı için ULUSAL kitap da 100 alıyordu.
    ['afyon-2026', [
        'Uluslararası Kitap' => 100,
        'Ulusal Kitap' => 80,
        'Uluslararası Kitap Bölümü' => 45,
        'Ulusal Kitap Bölümü' => 40,
    ]],
    // Açıklama iii "uluslararası"yı yayınevine bağlıyor; ders kitabının da
    // iki kademesi var (50 ↔ 30).
    ['alku-2024', [
        'Uluslararası Kitap' => 120,
        'Ulusal Kitap' => 70,
        'Uluslararası Kitap Bölümü' => 30,
        'Ulusal Kitap Bölümü' => 15,
        'Uluslararası Ders / Metot Kitabı' => 50,
        'Ulusal Ders / Metot Kitabı' => 30,
    ]],
    // B.5 (uluslararası yayınevi kitabı) ile B.7 (ulusal) hiç girilmemişti;
    // ikisi de kaynağa göre açıldı. B.1'in "yabancı dilde" kaydı okunamadığı
    // için `Uluslararası Kitap` B.5'te (125), BKCI B.1'de (150).
    ['amasya-2024', [
        'Uluslararası Kitap' => 125,
        'Ulusal Kitap' => 100,
        'BKCI / Scopus Kitap' => 150,
        'Uluslararası Kitap Bölümü' => 25,
        'Ulusal Kitap Bölümü' => 20,
    ]],
    // Ataşehir Adıgüzel 10 ("yurtdışında uluslararası yayınevlerinde basılı
    // olması şartıyla") ↔ 11 ("ulusal nitelikte bir kitap").
    ['atasehir-adiguzel-2018', [
        'Uluslararası Kitap' => 150,
        'Ulusal Kitap' => 100,
        'Uluslararası Kitap Bölümü' => 100,
        'Ulusal Kitap Bölümü' => 25,
    ]],
    // Bartın C bölümü dört kalemi de iki kademede veriyor; ölçüt sayan bir
    // yönerge olduğu için yanlış kademe yanlış KOŞULU sağlıyordu.
    ['bartin-2022', [
        'Uluslararası Kitap' => 200,
        'Ulusal Kitap' => 180,
        'Uluslararası Kitap Bölümü' => 100,
        'Ulusal Kitap Bölümü' => 60,
        'Uluslararası Ders / Metot Kitabı' => 100,
        'Ulusal Ders / Metot Kitabı' => 80,
    ]],
]);
