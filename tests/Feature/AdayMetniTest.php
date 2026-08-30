<?php

use App\Services\Scoring\Sart\SartDeposu;

/**
 * ADAY METİNLERİNDE YÖNERGE KODU ARAR (KONVANSIYONLAR §2, "Aday metinleri:
 * KOD YASAK").
 *
 * Adaya iki metin gösteriliyor: koşul ağacındaki her düğümün `aciklama`'sı ve
 * eşiğin `aday_notu`'su. Bu metinlerde "MADDE 5/1-b", "Tablo 2", "EK-1",
 * "A.1-A.5" gibi yönerge kodları geçmemeli — aday o kodun ne olduğunu bilmiyor
 * ve motorun onun yerine ne saydığını göremiyor. Kod, düğümün `madde` alanına
 * ve `notlar`a yazılır; ikisi de adaya gösterilmiyor.
 *
 * Kural korpusa SONRADAN eklendi ve o an 111 üniversite kirliydi; süpürme on
 * dokuz partide tamamlandı ve geçici borç listesi kaldırıldı. Test artık
 * BÜTÜN korpusu koşulsuz tarıyor: yeni bir yönerge girildiğinde aday metnine
 * kod sızarsa doğrudan kırılır.
 */
$KOD_DESENI = '/('
    .'\bMADDE\s'          // MADDE 5/1-b
    .'|\bMadde\s?\d'       // Madde 12(5)
    .'|\bTablo[-\s]?\d'    // Tablo 2, Tablo-3
    .'|\bTABLO[-\s]?\d'
    .'|\bEK[-\s]?\d'       // EK-1, EK 3
    .'|\bEk[-\s]?\d'
    .'|\bÇizelge[-\s]?\d'
    .'|\b[A-Z]\.\d'        // A.1, B.7
    .'|\b[A-Z]\d\.\d'      // A1.1
    // Noktasız kod aralıkları: A1-A4, C1-C7, D1-D4. Dergi çeyrekleri (Q1-Q3)
    // KOD DEĞİL, adayın tanıdığı bir ad — desenden dışlanıyor.
    .'|\b(?!Q)[A-Z]\d{1,2}-(?!Q)[A-Z]?\d{1,2}\b'
    // Tireli harf-rakam kodları (A-1, A-1.1, D-5, F-3) ve yönergenin madde
    // numarasını sözle anan biçimler ("01-06 numaralı maddeler", "1/a bendi").
    .'|\b[A-Z]-\d(\.\d)?\b'
    .'|\b\d{1,2}(-\d{1,2})? numaralı madde'
    .'|\b\d[.\/][a-zçğıöşü] bend'
    .'|\bTABLO [A-Z]\b'
    .')/u';

/**
 * Adaya gösterilen bütün metinleri toplar: düğüm açıklamaları ve aday notu.
 *
 * @param  array<string, mixed>  $dugum
 * @return list<string>
 */
function adayMetinleri(array $dugum): array
{
    $metinler = [];

    if (isset($dugum['aciklama'])) {
        $metinler[] = $dugum['aciklama'];
    }

    foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
        $metinler = [...$metinler, ...adayMetinleri($cocuk)];
    }

    return $metinler;
}

test('aday metinlerinde yönerge kodu yok', function () use ($KOD_DESENI) {
    $depo = app(SartDeposu::class);
    $sizinti = [];

    foreach ($depo->esikler() as $esik) {
        $metinler = adayMetinleri($esik['sart']);

        if ($esik['aday_notu'] !== null) {
            $metinler[] = $esik['aday_notu'];
        }

        foreach ($metinler as $metin) {
            if (preg_match($KOD_DESENI, $metin, $eslesme)) {
                $sizinti[] = "{$esik['universite']} ({$esik['anahtar']}): \"{$eslesme[1]}\" — ".mb_substr($metin, 0, 110);
            }
        }
    }

    expect(array_values(array_unique($sizinti)))->toBe([]);
});
