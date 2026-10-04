<?php

namespace App\Services\Cikti;

use App\Enums\JuriAdimi;
use App\Enums\Kadro;
use App\Enums\Kategori;
use App\Enums\TemelAlan;
use App\Models\BeyanOnayi;
use App\Models\Faaliyet;
use App\Models\JuriRaporu;
use App\Models\User;
use App\Services\Scoring\Sart\Durum;
use App\Services\Scoring\Sart\MaddeKatalogu;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Scoring\Sart\SartSonucu;
use Carbon\CarbonImmutable;
use Collator;
use Illuminate\Support\Collection;

/**
 * Akademik faaliyet raporunun verisini derler.
 *
 * Rapordaki her sayı Yönerge Analizi ve Dashboard'la AYNI motordan gelir
 * ({@see SartDeposu::degerlendir()}); rapor kendi puanını hesaplamaz. Aksi
 * hâlde aday jüriye, ekranda gördüğünden başka bir puan taşıyan bir dosya
 * verebilirdi.
 *
 * Tarih aralığı yalnızca LİSTELERİ daraltır. Puan, koşullar ve başvurulabilir
 * üniversiteler daima onaylı faaliyetlerin tamamıyla hesaplanır: "son 3 yıl"
 * raporu, yönergenin ölçtüğünden düşük bir puanı resmî sonuç gibi basardı.
 *
 * @phpstan-import-type Esik from SartDeposu
 *
 * @phpstan-type FaaliyetSatiri array{baslik: string, kategori: string, tur: string, yazarlar: string, kaynak: string, yil: string, puan: int|null}
 * @phpstan-type KosulSatiri array{aciklama: string, durum: Durum, mevcut: int|null, gerekli: int|null, oran: int, not: string|null}
 * @phpstan-type UniversiteSatiri array{ad: string, toplam: int|null, baraj: int|null, durum: Durum}
 * @phpstan-type Rapor array{
 *     hedef: array{universite: string, kadro: string}|null,
 *     ozet: array{faaliyet: int, toplam: int|null, baraj: int|null, oran: int, durum: Durum|null, uygunKurum: int, kurum: int},
 *     dagilim: list<array{kategori: string, puan: int, adet: int}>,
 *     kosullar: list<KosulSatiri>,
 *     universiteler: list<UniversiteSatiri>,
 *     universiteFazlasi: int,
 *     faaliyetler: array<string, list<FaaliyetSatiri>>,
 *     tezDanismanligi: list<FaaliyetSatiri>,
 *     toplumsalKatki: list<FaaliyetSatiri>,
 *     juri: array{karar: string, ozet: string, plan: string|null, tarih: string}|null
 * }
 */
class RaporDerleyici
{
    /** Hedef analizi tablosunda gösterilecek en fazla üniversite. */
    public const UNIVERSITE_SINIRI = 15;

    /** Tarih aralığı seçenekleri. */
    public const ARALIKLAR = [
        'tum' => 'Tüm dönem',
        'son1' => 'Son 1 yıl',
        'son3' => 'Son 3 yıl',
        'son5' => 'Son 5 yıl',
        'doktora' => 'Doktora sonrası',
    ];

    public function __construct(private readonly SartDeposu $depo) {}

    /**
     * Adayın kadro + temel alan (+ birim) bileşimi için doğrulanmış eşiği olan
     * kurumlar, Türkçe alfabe sırasında. Eşiği olmayan kurum için rapor
     * tahmini bir baraj basmaz.
     *
     * @return list<string>
     */
    public function kurumlar(User $user, string $kadro): array
    {
        $alan = $this->alan($user);
        $birim = $user->birim ?: null;

        $kurumlar = array_values(array_filter(
            $this->depo->universiteler(),
            fn (string $ad) => $this->depo->bul($ad, $kadro, $alan, $birim) !== null,
        ));

        if (class_exists(Collator::class)) {
            (new Collator('tr_TR'))->sort($kurumlar);
        } else {
            sort($kurumlar);
        }

        return $kurumlar;
    }

    /**
     * @return Rapor
     */
    public function derle(User $user, string $hedefKurum, string $hedefKadro, string $aralik): array
    {
        $onayli = $user->faaliyetler()->onaylanmis()->get();
        $profil = $user->sartProfili($onayli);
        $alan = $this->alan($user);
        $birim = $user->birim ?: null;

        $esik = $hedefKurum !== '' ? $this->depo->bul($hedefKurum, $hedefKadro, $alan, $birim) : null;
        $katalog = $esik !== null ? $this->depo->katalog($esik['cetvel']) : null;
        $sonuc = $esik !== null
            ? $this->depo->degerlendir($esik, $onayli, $profil, $this->beyanOnaylari($user, $esik['anahtar']))
            : null;

        $universiteler = $this->universiteler($user, $hedefKadro, $onayli);

        // Tez danışmanlığı ve toplumsal katkı kendi bölümlerinde; geri kalan
        // her şey kategorisine göre gruplanmış ana listede.
        $faaliyetler = [];
        $tezDanismanligi = [];
        $toplumsalKatki = [];

        foreach ($this->aralikta($onayli, $aralik, $user) as $faaliyet) {
            $satir = $this->faaliyetSatiri($faaliyet, $katalog);

            if ($faaliyet->kategori === Kategori::TezDanismanligi) {
                $tezDanismanligi[] = $satir;
            } elseif ($faaliyet->kategori === Kategori::ToplumsalKatki) {
                $toplumsalKatki[] = $satir;
            } else {
                $faaliyetler[$satir['kategori']][] = $satir;
            }
        }

        $toplamDugum = $sonuc?->rolile('toplam');

        return [
            'hedef' => $esik !== null ? ['universite' => $hedefKurum, 'kadro' => Kadro::etiketi($hedefKadro)] : null,
            'ozet' => [
                'faaliyet' => $onayli->count(),
                'toplam' => $toplamDugum?->mevcut,
                'baraj' => $toplamDugum?->gerekli,
                'oran' => $sonuc !== null ? $this->oran($sonuc) : 0,
                'durum' => $sonuc?->durum,
                'uygunKurum' => count(array_filter($universiteler, fn (array $u) => $u['durum'] === Durum::Saglandi)),
                'kurum' => count($universiteler),
            ],
            'dagilim' => $this->dagilim($onayli, $katalog),
            'kosullar' => $sonuc !== null ? $this->kosullar($sonuc) : [],
            'universiteler' => array_slice($universiteler, 0, self::UNIVERSITE_SINIRI),
            'universiteFazlasi' => max(0, count($universiteler) - self::UNIVERSITE_SINIRI),
            'faaliyetler' => $faaliyetler,
            'tezDanismanligi' => $tezDanismanligi,
            'toplumsalKatki' => $toplumsalKatki,
            'juri' => $esik !== null ? $this->juri($user, $hedefKurum, $hedefKadro) : null,
        ];
    }

    /**
     * Excel'e (CSV) aktarılacak faaliyet satırları — rapordaki listelerin aynısı.
     *
     * @return list<FaaliyetSatiri>
     */
    public function faaliyetSatirlari(User $user, string $hedefKurum, string $hedefKadro, string $aralik): array
    {
        $esik = $hedefKurum !== '' ? $this->depo->bul($hedefKurum, $hedefKadro, $this->alan($user), $user->birim ?: null) : null;
        $katalog = $esik !== null ? $this->depo->katalog($esik['cetvel']) : null;

        $satirlar = [];

        foreach ($this->aralikta($user->faaliyetler()->onaylanmis()->get(), $aralik, $user) as $faaliyet) {
            $satirlar[] = $this->faaliyetSatiri($faaliyet, $katalog);
        }

        return $satirlar;
    }

    /**
     * Tarih aralığına giren faaliyetler, en yeni önce. Tarihsiz kayıt yalnızca
     * "tüm dönem"de listelenir (en sonda): hangi aralığa düştüğü bilinmiyor,
     * rastgele birine koymak raporu yanlış tarihlemek olurdu.
     *
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @return Collection<int, Faaliyet>
     */
    private function aralikta(Collection $faaliyetler, string $aralik, User $user): Collection
    {
        $baslangic = match ($aralik) {
            'son1' => CarbonImmutable::today()->subYear(),
            'son3' => CarbonImmutable::today()->subYears(3),
            'son5' => CarbonImmutable::today()->subYears(5),
            'doktora' => $user->doktora_tarihi !== null ? CarbonImmutable::parse($user->doktora_tarihi) : null,
            default => null,
        };

        if ($baslangic !== null) {
            $faaliyetler = $faaliyetler->filter(
                fn (Faaliyet $f) => $f->tarih !== null && $f->tarih->greaterThanOrEqualTo($baslangic),
            );
        }

        return $faaliyetler
            ->sortByDesc(fn (Faaliyet $f) => $f->tarih?->getTimestamp() ?? 0)
            ->values();
    }

    /**
     * @return FaaliyetSatiri
     */
    private function faaliyetSatiri(Faaliyet $faaliyet, ?MaddeKatalogu $katalog): array
    {
        return [
            'baslik' => $faaliyet->baslik,
            'kategori' => $faaliyet->kategori->label(),
            'tur' => (string) ($faaliyet->tur ?: $faaliyet->kategori->label()),
            'yazarlar' => (string) $faaliyet->yazarlar,
            'kaynak' => (string) $faaliyet->kaynak,
            'yil' => $faaliyet->tarih?->format('Y') ?? '',
            // Puan daima hedefin cetvelinden; hedef yoksa puan basılmaz.
            'puan' => $katalog?->puan($faaliyet, $katalog->coz(['*'])),
        ];
    }

    /**
     * Kategori başına ham puan (tavan uygulanmadan) ve adet; en yüksek puan önce.
     *
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @return list<array{kategori: string, puan: int, adet: int}>
     */
    private function dagilim(Collection $faaliyetler, ?MaddeKatalogu $katalog): array
    {
        $ham = $katalog?->kategoriDagilimi($faaliyetler) ?? [];
        $satirlar = [];

        foreach ($faaliyetler->groupBy(fn (Faaliyet $f) => $f->kategori->value) as $deger => $grup) {
            $satirlar[] = [
                'kategori' => Kategori::from((string) $deger)->label(),
                'puan' => $ham[$deger]['puan'] ?? 0,
                'adet' => $grup->count(),
            ];
        }

        usort($satirlar, fn (array $a, array $b) => $b['puan'] <=> $a['puan'] ?: $b['adet'] <=> $a['adet']);

        return $satirlar;
    }

    /**
     * Yönergenin asgari koşulları, toplam puan koşulu en üstte.
     *
     * @return list<KosulSatiri>
     */
    private function kosullar(SartSonucu $sonuc): array
    {
        $toplam = $sonuc->rolile('toplam');
        $kosullar = $sonuc->kosullar();

        usort($kosullar, fn (SartSonucu $a, SartSonucu $b) => ($b === $toplam) <=> ($a === $toplam));

        return array_map(fn (SartSonucu $kosul) => [
            'aciklama' => $kosul->aciklama,
            'durum' => $kosul->durum,
            'mevcut' => $kosul->mevcut,
            'gerekli' => $kosul->gerekli,
            'oran' => $kosul->oran(),
            'not' => $this->kosulNotu($kosul),
        ], $kosullar);
    }

    /**
     * Sayaçla anlatılamayan sonuçlar — Yönerge Analizi kartıyla aynı sözlük.
     * Telafi ile geçilen koşulda sayaç ANA yolu gösteriyor; "0 / 1 · Uygun"
     * diye basılsa jüri çelişki okurdu.
     */
    private function kosulNotu(SartSonucu $kosul): ?string
    {
        return match (true) {
            $kosul->kaynakEksik => 'Cetveli girilmedi; beyana bağlı',
            $kosul->beyanOnaylandi => 'Belgeyle onaylandı',
            $kosul->beyan => 'Belgeyle teyit edilecek',
            $kosul->telafiIleSaglandi() => 'Telafi ile sağlandı',
            default => null,
        };
    }

    /**
     * Başvurulabilirlik tablosu: eşiği olan her kurum, önce sağlananlar, sonra
     * barajına en yakın olanlar.
     *
     * @param  Collection<int, Faaliyet>  $onayli
     * @return list<UniversiteSatiri>
     */
    private function universiteler(User $user, string $kadro, Collection $onayli): array
    {
        $alan = $this->alan($user);
        $birim = $user->birim ?: null;
        $profil = $user->sartProfili($onayli);
        $onaylar = $this->tumBeyanOnaylari($user);
        $satirlar = [];

        foreach ($this->depo->universiteler() as $ad) {
            $esik = $this->depo->bul($ad, $kadro, $alan, $birim);

            if ($esik === null) {
                continue;
            }

            $sonuc = $this->depo->degerlendir($esik, $onayli, $profil, $onaylar[$esik['anahtar']] ?? []);
            $toplam = $sonuc->rolile('toplam');

            $satirlar[] = [
                'ad' => $ad,
                'toplam' => $toplam?->mevcut,
                'baraj' => $toplam?->gerekli,
                'durum' => $sonuc->durum,
                'oran' => $this->oran($sonuc),
            ];
        }

        $sira = [Durum::Saglandi->value => 0, Durum::Belirsiz->value => 1, Durum::Saglanmadi->value => 2];

        usort($satirlar, fn (array $a, array $b) => $sira[$a['durum']->value] <=> $sira[$b['durum']->value]
            ?: $b['oran'] <=> $a['oran']
            ?: strcmp($a['ad'], $b['ad']));

        return array_map(fn (array $s) => [
            'ad' => $s['ad'],
            'toplam' => $s['toplam'],
            'baraj' => $s['baraj'],
            'durum' => $s['durum'],
        ], $satirlar);
    }

    /**
     * Hedefe ilerleme: puan barajı varsa puandan, yoksa (adetle yazılmış
     * yönergeler) koşul doluluğundan.
     */
    private function oran(SartSonucu $sonuc): int
    {
        $toplam = $sonuc->rolile('toplam');

        if ($toplam !== null && $toplam->gerekli !== null && $toplam->gerekli > 0) {
            return (int) min(100, round(($toplam->mevcut ?? 0) / $toplam->gerekli * 100));
        }

        return $sonuc->oran();
    }

    /**
     * Bu hedef için üretilmiş en yeni jüri raporunun özeti ve tamamlama planı.
     * Rapor YZ'ye burada YENİDEN yazdırılmıyor; aday YZ Jüri Analizi'nde ne
     * gördüyse o basılıyor.
     *
     * @return array{karar: string, ozet: string, plan: string|null, tarih: string}|null
     */
    private function juri(User $user, string $kurum, string $kadro): ?array
    {
        /** @var JuriRaporu|null $rapor */
        $rapor = $user->juriRaporlari()
            ->where('universite', $kurum)
            ->where('hedef_kadro', $kadro)
            ->latest('id')
            ->first();

        if ($rapor === null) {
            return null;
        }

        $plan = collect($rapor->adimSatirlari())->firstWhere('adim', JuriAdimi::Plan);

        return [
            'karar' => $rapor->karar->etiket(),
            'ozet' => $rapor->ozet,
            'plan' => $plan['icerik'] ?? null,
            'tarih' => $rapor->created_at?->translatedFormat('j F Y') ?? '',
        ];
    }

    /**
     * @return list<string>
     */
    private function beyanOnaylari(User $user, string $esikAnahtari): array
    {
        return $this->tumBeyanOnaylari($user)[$esikAnahtari] ?? [];
    }

    /**
     * Adayın Yönerge Analizi'nde işaretlediği "belgem var" beyanları, eşiğe göre.
     *
     * @return array<string, list<string>>
     */
    private function tumBeyanOnaylari(User $user): array
    {
        $onaylar = [];

        foreach (BeyanOnayi::query()->where('user_id', $user->id)->get() as $onay) {
            $onaylar[$onay->esik_anahtari][] = $onay->kosul_anahtari;
        }

        return $onaylar;
    }

    private function alan(User $user): string
    {
        return ($user->temel_alan ?? TemelAlan::Sosyal)->value;
    }
}
