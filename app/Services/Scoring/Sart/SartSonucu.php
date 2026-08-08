<?php

namespace App\Services\Scoring\Sart;

/**
 * Şart ağacının değerlendirme sonucu — girdiyle aynı şekle sahip bir ağaç.
 * Arayüz bu ağacı olduğu gibi gezerek yönergenin kendi yapısını gösterebilir.
 */
readonly class SartSonucu
{
    /**
     * @param  list<self>  $cocuklar
     * @param  self|null  $telafi  Ana koşul sağlanmadığında denenen alternatifin sonucu
     */
    public function __construct(
        public string $tip,
        public string $aciklama,
        public Durum $durum,
        public ?int $gerekli = null,
        public ?int $mevcut = null,
        public array $cocuklar = [],
        public ?self $telafi = null,
        public bool $beyan = false,
        public ?string $belirsizlikNedeni = null,
        /** Veri dosyasından taşınan serbest etiket (ör. 'toplam') — arayüz belirli
         * bir düğümü açıklama metnine bakmadan bulabilsin diye. */
        public ?string $rol = null,
    ) {}

    /**
     * Ağaçta verilen role sahip ilk düğüm.
     */
    public function rolile(string $rol): ?self
    {
        return $this->topla(fn (self $d) => $d->rol === $rol)[0] ?? null;
    }

    public function saglandi(): bool
    {
        return $this->durum === Durum::Saglandi;
    }

    /**
     * Ana koşul sağlanmadığı hâlde telafi ile geçildi mi?
     */
    public function telafiIleSaglandi(): bool
    {
        return $this->saglandi() && $this->telafi?->saglandi() === true;
    }

    public function eksik(): int
    {
        if ($this->gerekli === null || $this->mevcut === null) {
            return 0;
        }

        return max(0, $this->gerekli - $this->mevcut);
    }

    /**
     * Bu düğümün doluluk oranı (0-100). Ölçülemiyorsa duruma göre 0/100.
     */
    public function oran(): int
    {
        if ($this->gerekli === null || $this->mevcut === null) {
            return $this->saglandi() ? 100 : 0;
        }

        if ($this->gerekli <= 0) {
            return 100;
        }

        return (int) min(100, round($this->mevcut / $this->gerekli * 100));
    }

    /**
     * Kesin olarak sağlanmayan yapraklar (ağacın tamamından, düz liste).
     *
     * @return list<self>
     */
    public function eksikler(): array
    {
        return $this->topla(fn (self $d) => $d->cocuklar === [] && $d->durum === Durum::Saglanmadi);
    }

    /**
     * Veri eksikliği yüzünden karara bağlanamayan yapraklar.
     *
     * @return list<self>
     */
    public function belirsizler(): array
    {
        return $this->topla(fn (self $d) => $d->cocuklar === [] && $d->durum === Durum::Belirsiz);
    }

    /**
     * Kullanıcı beyanı bekleyen maddeler.
     *
     * @return list<self>
     */
    public function beyanlar(): array
    {
        return $this->topla(fn (self $d) => $d->beyan);
    }

    /**
     * Ağaçtaki tüm düğümleri gezip koşula uyanları toplar.
     *
     * @param  callable(self): bool  $kosul
     * @return list<self>
     */
    public function topla(callable $kosul): array
    {
        $bulunan = $kosul($this) ? [$this] : [];

        foreach ($this->cocuklar as $cocuk) {
            $bulunan = array_merge($bulunan, $cocuk->topla($kosul));
        }

        if ($this->telafi !== null) {
            $bulunan = array_merge($bulunan, $this->telafi->topla($kosul));
        }

        return $bulunan;
    }
}
