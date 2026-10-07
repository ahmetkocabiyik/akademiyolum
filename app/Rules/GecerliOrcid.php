<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Geçerli bir ORCID kimliği: `0000-0000-0000-000X`.
 *
 * Son hane ISO 7064 Mod 11-2 kontrol hanesi (rakam ya da X). Yalnızca biçim
 * sınansa bir rakamı yanlış yazılmış kimlik kabul edilir, CV'de jürinin
 * açamayacağı bir ORCID basılırdı. Küçük x kabul ediliyor; saklarken
 * {@see self::kimlik()} büyütür. Boş değeri `nullable` kuralına bırakır.
 */
class GecerliOrcid implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $kimlik = is_string($value) ? strtoupper(trim($value)) : '';

        if (preg_match('/^\d{4}-\d{4}-\d{4}-\d{3}[\dX]$/', $kimlik) !== 1) {
            $fail('ORCID kimliğini 0000-0000-0000-0000 biçiminde girin.');

            return;
        }

        if (! self::kontrolHanesiDogru($kimlik)) {
            $fail('Bu ORCID kimliği geçerli değil; rakamları kontrol edin.');
        }
    }

    /**
     * Herhangi bir ORCID yazımını (orcid.org adresi, küçük x) çıplak kimliğe
     * indirir; geçerli bir ORCID değilse null.
     */
    public static function kimlik(?string $deger): ?string
    {
        $kimlik = strtoupper((string) preg_replace('#^(https?://)?(www\.)?orcid\.org/#i', '', trim((string) $deger)));

        if (preg_match('/^\d{4}-\d{4}-\d{4}-\d{3}[\dX]$/', $kimlik) !== 1 || ! self::kontrolHanesiDogru($kimlik)) {
            return null;
        }

        return $kimlik;
    }

    /**
     * ISO 7064 Mod 11-2: ilk 15 hane üzerinden hesaplanan hane sonuncuya eşit mi?
     */
    public static function kontrolHanesiDogru(string $kimlik): bool
    {
        $haneler = str_replace('-', '', $kimlik);
        $toplam = 0;

        for ($i = 0; $i < 15; $i++) {
            $toplam = ($toplam + (int) $haneler[$i]) * 2;
        }

        $sonuc = (12 - $toplam % 11) % 11;

        return $haneler[15] === ($sonuc === 10 ? 'X' : (string) $sonuc);
    }
}
