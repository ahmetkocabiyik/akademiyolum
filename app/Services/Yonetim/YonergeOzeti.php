<?php

namespace App\Services\Yonetim;

use App\Enums\Kadro;
use App\Enums\TemelAlan;
use App\Models\GizliYonerge;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
use Collator;
use Illuminate\Support\Collection;

/**
 * Yönetim panelinin yönerge görünümü: hangi üniversitenin yönergesi var,
 * ne kadarı girilmiş, hangisi taslak, hangisi gizli.
 *
 * Adaya gösterilenden FARKLI olarak verinin tamamını okur (taslaklar ve
 * gizlenenler dahil): yönetici neyin eksik ya da kapalı olduğunu görmeli.
 *
 * @phpstan-type Satir array{ad: string, sehir: string|null, tur: string|null, yonerge_url: string|null, durum: string, kapsam: int, cetveller: list<string>, kaynak_pdf: bool, kullanici: int, gizli: GizliYonerge|null, kunye: bool}
 * @phpstan-type Hucre array{durum: string, birimler: list<string>, cetvel: string|null}
 */
class YonergeOzeti
{
    /** Kadro × temel alan bileşimi sayısı (tam kapsam). */
    public const TAM_KAPSAM = 36;

    public function __construct(private readonly SartDeposu $depo) {}

    /**
     * Yönergesi olan ve olmayan bütün üniversiteler, Türkçe alfabe sırasında.
     *
     * Durum: `gizli` (panelden kaldırılmış) · `dogrulandi` · `taslak` (yalnız
     * makineyle çıkarılmış, okunmamış eşik) · `yok` (hiç eşik yok).
     *
     * @return list<Satir>
     */
    public function satirlar(): array
    {
        $esikler = collect($this->depo->esikler())->groupBy('universite');
        $kunyeler = Universite::query()->get()->keyBy('ad');
        $gizliler = GizliYonerge::query()->get()->keyBy('universite');
        $kullanicilar = User::query()->whereNotNull('universite')
            ->selectRaw('universite, count(*) as adet')->groupBy('universite')->pluck('adet', 'universite');

        $adlar = $esikler->keys()->merge($kunyeler->keys())->unique()->values()->all();

        if (class_exists(Collator::class)) {
            (new Collator('tr_TR'))->sort($adlar);
        } else {
            sort($adlar);
        }

        $satirlar = [];

        foreach ($adlar as $ad) {
            /** @var Collection<int, array<string, mixed>> $uniEsikleri */
            $uniEsikleri = $esikler->get($ad, collect());
            $dogrulanmis = $uniEsikleri->where('durum', SartDeposu::DOGRULANDI);
            $kunye = $kunyeler->get($ad);

            $satirlar[] = [
                'ad' => (string) $ad,
                'sehir' => $kunye?->sehir,
                'tur' => $kunye?->tur,
                'yonerge_url' => $kunye?->yonerge_url,
                'durum' => match (true) {
                    $gizliler->has($ad) => 'gizli',
                    $dogrulanmis->isNotEmpty() => 'dogrulandi',
                    $uniEsikleri->isNotEmpty() => 'taslak',
                    default => 'yok',
                },
                // Yalnız matristeki üç kadro sayılıyor; bazı yönergelerin ek
                // kadroları (ör. dr_ogr_uyesi_yeniden) 36'yı aşırıyordu.
                'kapsam' => $dogrulanmis
                    ->filter(fn (array $e): bool => Kadro::tryFrom($e['kadro']) !== null && TemelAlan::tryFrom($e['alan']) !== null)
                    ->map(fn (array $e): string => $e['kadro'].'|'.$e['alan'])->unique()->count(),
                'cetveller' => self::tekilListe($uniEsikleri->all(), 'cetvel'),
                'kaynak_pdf' => $this->depo->kaynakPdf((string) $ad) !== null,
                'kullanici' => (int) ($kullanicilar[$ad] ?? 0),
                'gizli' => $gizliler->get($ad),
                'kunye' => $kunye !== null,
            ];
        }

        return $satirlar;
    }

    /**
     * Tek üniversitenin satırı; yoksa null.
     *
     * @return Satir|null
     */
    public function satir(string $universite): ?array
    {
        foreach ($this->satirlar() as $satir) {
            if ($satir['ad'] === $universite) {
                return $satir;
            }
        }

        return null;
    }

    /**
     * Eşiklerin bir alanındaki boş olmayan değerler, tekil ve sıralı.
     *
     * @param  array<int|string, array<string, mixed>>  $esikler
     * @return list<string>
     */
    private static function tekilListe(array $esikler, string $alan): array
    {
        $degerler = [];

        foreach ($esikler as $esik) {
            $deger = $esik[$alan] ?? null;

            if (is_string($deger) && $deger !== '') {
                $degerler[$deger] = true;
            }
        }

        $liste = array_keys($degerler);
        sort($liste);

        return $liste;
    }

    /**
     * Kadro × temel alan matrisi: her hücrede o bileşimin durumu.
     * `birimler` doluysa yönerge o alanı birime (programa) göre ayırıyor.
     *
     * @return array<string, array<string, Hucre>>
     */
    public function matris(string $universite): array
    {
        $esikler = collect($this->depo->esikler())->where('universite', $universite);
        $matris = [];

        foreach (Kadro::cases() as $kadro) {
            foreach (TemelAlan::cases() as $alan) {
                $hucre = $esikler->where('kadro', $kadro->value)->where('alan', $alan->value);
                $dogrulanmis = $hucre->where('durum', SartDeposu::DOGRULANDI);

                $matris[$kadro->value][$alan->value] = [
                    'durum' => match (true) {
                        $dogrulanmis->isNotEmpty() => 'dogrulandi',
                        $hucre->isNotEmpty() => 'taslak',
                        default => 'yok',
                    },
                    'birimler' => self::tekilListe($hucre->all(), 'birim'),
                    'cetvel' => $hucre->first()['cetvel'] ?? null,
                ];
            }
        }

        return $matris;
    }
}
