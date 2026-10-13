<?php

namespace App\Services\Kurum;

use App\Enums\TemelAlan;
use App\Models\UniversiteBirimi;
use Collator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Kurulum ve profil ekranlarındaki fakülte ve bölüm seçenekleri.
 *
 * Üniversitenin YÖK Atlas verisi varsa yalnızca o üniversitenin fakülte ve
 * yüksekokulları sunulur, temel alana bakılmaz: "Uluslararası Tıp Fakültesi"
 * gibi adlar genel listeyle eşleşmiyor, süzmek gerçek fakülteleri saklardı.
 * Verisi yoksa (listede olmayan üniversite yazılmışsa) temel alanın genel
 * listesine düşülür. Seçenekler öneridir; ekranlar serbest metne izin verir.
 */
class BirimKatalogu
{
    public static function veriDosyasi(): string
    {
        return database_path('data/universite-birimleri.json');
    }

    /**
     * @return list<string>
     */
    public function fakulteler(string $universite, TemelAlan $alan): array
    {
        $fakulteler = $this->sorgu($universite)->distinct()->get(['fakulte'])->map(fn (UniversiteBirimi $birim): string => $birim->fakulte)->all();

        return $fakulteler === [] ? $alan->fakulteler() : self::sirala($fakulteler);
    }

    /**
     * Üniversitenin o fakültede açtığı programlar ve genel bölüm listesi.
     * İkisi birlikte: atlas lisans PROGRAMINI veriyor (Tıp Fakültesi → "Tıp"),
     * akademisyenin kadrosu ise çoğu zaman BÖLÜMDE ("Cerrahi Tıp Bilimleri").
     *
     * @return list<string>
     */
    public function bolumler(string $universite, string $fakulte): array
    {
        if ($fakulte === '') {
            return [];
        }

        /** @var array<string, list<string>> $genel */
        $genel = require database_path('data/bolumler.php');

        $programlar = $this->sorgu($universite)->where('fakulte', $fakulte)->get(['bolum'])->map(fn (UniversiteBirimi $birim): string => $birim->bolum)->all();

        return self::sirala(array_unique([...$programlar, ...($genel[$fakulte] ?? [])]));
    }

    /**
     * Türkçe alfabe sırası ("Çevre" C'den sonra, "İlahiyat" I'dan sonra).
     *
     * @param  array<string>  $liste
     * @return list<string>
     */
    public static function sirala(array $liste): array
    {
        if (class_exists(Collator::class)) {
            (new Collator('tr_TR'))->sort($liste);
        } else {
            sort($liste);
        }

        return array_values($liste);
    }

    /**
     * @return Builder<UniversiteBirimi>
     */
    private function sorgu(string $universite): Builder
    {
        return UniversiteBirimi::query()->whereHas('universite', fn ($q) => $q->where('ad', $universite));
    }
}
