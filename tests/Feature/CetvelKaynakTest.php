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
