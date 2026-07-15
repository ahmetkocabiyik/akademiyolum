<?php

namespace App\Services\Scoring;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Models\YonergeEsik;
use Illuminate\Support\Collection;

/**
 * Kullanıcının faaliyetlerini bir yönerge eşiğine (min_toplam + yayın/indeks/YDS
 * alt-minimumları) karşı koşul koşul değerlendirir.
 */
class EsikDegerlendirici
{
    /**
     * Uluslararası indeks işaretleri (index_min için). Kaynak adı bu
     * işaretlerden birini içeriyorsa (ör. "SCIE/SSCI (Q1)", "AHCI") indeks sayılır.
     *
     * @var list<string>
     */
    private const INDEKS_ISARETLER = ['SCIE', 'SSCI', 'AHCI'];

    /**
     * Yayın sayılan kategoriler (yayin_min için).
     *
     * @var list<Kategori>
     */
    private const YAYIN_KATEGORILERI = [Kategori::Makale, Kategori::Kitap, Kategori::TezYayini];

    public function __construct(private readonly RuleSet $ruleSet) {}

    /**
     * @param  iterable<Faaliyet>  $faaliyetler
     */
    public function degerlendir(iterable $faaliyetler, YonergeEsik $esik, ?int $yds = null): EsikSonuc
    {
        $faaliyetler = collect($faaliyetler);
        $rapor = (new PuanRaporu($this->ruleSet))->olustur($faaliyetler);

        $toplam = $rapor->toplamPuan;
        $yayin = $this->yayinPuani($rapor);
        $index = $this->indexPuani($faaliyetler);

        $kosullar = [new Kosul('Toplam puan', $esik->min_toplam, $toplam)];

        if ($esik->yayin_min !== null) {
            $kosullar[] = new Kosul('Yayın puanı (makale/kitap/tez)', $esik->yayin_min, $yayin);
        }

        if ($esik->index_min !== null) {
            $kosullar[] = new Kosul('Uluslararası indeks (SCIE/SSCI/AHCI)', $esik->index_min, $index);
        }

        if ($esik->yds_min !== null) {
            $kosullar[] = new Kosul('Yabancı dil (YDS)', $esik->yds_min, $yds ?? 0, bilgi: true);
        }

        // Yapısal alt-koşullar (adet/yazarlık/veya).
        if (! empty($esik->kosullar)) {
            $kosullar = array_merge(
                $kosullar,
                (new KosulDegerlendirici)->degerlendir($faaliyetler, $esik->kosullar),
            );
        }

        $puanliKosullar = array_filter($kosullar, fn (Kosul $k) => ! $k->bilgi);
        $uygun = collect($puanliKosullar)->every(fn (Kosul $k) => $k->saglandi());
        $oran = (int) collect($puanliKosullar)->min(fn (Kosul $k) => $k->oran());

        $durum = $uygun ? 'uygun' : ($oran >= 80 ? 'yakin' : 'yetersiz');

        return new EsikSonuc(
            kosullar: array_values($kosullar),
            toplam: $toplam,
            uygun: $uygun,
            durum: $durum,
            oran: $oran,
            ydsMin: $esik->yds_min,
        );
    }

    private function yayinPuani(RaporSonucu $rapor): int
    {
        return collect(self::YAYIN_KATEGORILERI)
            ->sum(fn (Kategori $k) => $rapor->kategori($k)->puan);
    }

    /**
     * @param  Collection<int, Faaliyet>  $faaliyetler
     */
    private function indexPuani(Collection $faaliyetler): int
    {
        return (int) $faaliyetler
            ->filter(fn (Faaliyet $f) => $f->kaynak !== null && collect(self::INDEKS_ISARETLER)
                ->contains(fn (string $isaret) => str_contains($f->kaynak, $isaret)))
            ->sum('puan');
    }
}
