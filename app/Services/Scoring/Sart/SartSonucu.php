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
        /** Koşul doğası gereği değil, dayandığı cetvel projeye girilmediği için
         * beyan. Adaya farklı anlatılır ve kapsam raporunda ayrı sayılır. */
        public bool $kaynakEksik = false,
        public ?string $belirsizlikNedeni = null,
        /** Yönergenin kendi atfı (ör. "Liste A · 2.a-ç/h,ı") — izlenebilirlik için. */
        public ?string $madde = null,
        /** Bu koşula sayılan kaynak etiketleri; cetvelden türetilir.
         * @var list<string> */
        public array $kapsam = [],
        /** Sayacı yükseltmek için fiilen uygulanan eşdeğerlikler (ör. "2 eş
         * danışmanlık 1 baş danışmanlığa denk"). Uygulanmayanlar listelenmez.
         *
         * @var list<string> */
        public array $donusumler = [],
        /** Veri dosyasından taşınan serbest etiket (ör. 'toplam') — arayüz belirli
         * bir düğümü açıklama metnine bakmadan bulabilsin diye. */
        public ?string $rol = null,
        /** Adayın "bu belgem var" kutusunu işaretlediği beyan düğümü. Durumu
         * zaten Sağlandı'dır; bayrak arayüzün kutuyu işaretli çizmesi ve
         * sonucun motordan değil BEYANDAN geldiğini söylemesi için. */
        public bool $beyanOnaylandi = false,
    ) {}

    /**
     * Beyan düğümünün kalıcı kimliği — adayın işaretini bu anahtara yazıyoruz.
     *
     * Ağaçtaki KONUM kullanılamaz: yönerge dosyası düzenlenince düğümler yer
     * değiştirir ve eski işaret sessizce BAŞKA bir koşula yapışırdı. Anahtar
     * koşulun kendi metninden türetiliyor; cümle değişirse işaret düşer ve
     * kutu işaretsize döner — yanlış tarafa düşmeyen tek davranış bu.
     */
    public static function beyanAnahtariUret(string $aciklama, ?string $madde): string
    {
        return substr(sha1($aciklama.'|'.($madde ?? '')), 0, 16);
    }

    public function beyanAnahtari(): string
    {
        return self::beyanAnahtariUret($this->aciklama, $this->madde);
    }

    /**
     * Arayüzde listelenecek asgari koşullar.
     *
     * Yönergenin tek koşulu varsa ağacın kökü birleştirici değil yaprak olur
     * (ör. Sabancı Dr. Öğr. Üyesi: yalnızca "en az 3 makale"). O durumda kökün
     * kendisi koşuldur; `cocuklar` üzerinden listelemek onu görünmez yapardı.
     *
     * @return list<self>
     */
    public function kosullar(): array
    {
        return $this->cocuklar !== [] ? $this->cocuklar : [$this];
    }

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
     * Bu düğümün doluluk oranı (0-100).
     *
     * Birleştiricilerde ağacın MANTIĞINA uyar; yaprakları düz toplamak yanlış
     * sonuç veriyordu:
     *   ve     → çocukların ortalaması (hepsi gerekli)
     *   veya   → çocukların en iyisi (biri yeterli — sağlanmayan alternatifler
     *            eksiklik sayılmaz; aksi hâlde beş yoldan birini tam sağlayan
     *            aday %0 görünüyordu)
     *   k_ile  → en iyi k çocuğun ortalaması
     *
     * Koşul telafi dalıyla karşılandıysa düğümün kendi sayacı ("0 / 1") ana
     * yolu anlatır; ilerleme yine de tamdır. O yüzden karar sayaçtan önce
     * gelir — aksi hâlde sağlanmış bir koşul %0 dolulukla çizilir.
     */
    public function oran(): int
    {
        if ($this->saglandi()) {
            return 100;
        }

        if ($this->cocuklar !== []) {
            $oranlar = array_map(fn (self $c) => $c->oran(), $this->cocuklar);

            if ($this->tip === 'veya') {
                return max($oranlar);
            }

            if ($this->tip === 'k_ile' && $this->gerekli !== null && $this->gerekli > 0) {
                rsort($oranlar);
                $enIyi = array_slice($oranlar, 0, $this->gerekli);

                return (int) round(array_sum($enIyi) / count($enIyi));
            }

            return (int) round(array_sum($oranlar) / count($oranlar));
        }

        // Yaprak: telafi dalı da bir yoldur, ikisinden iyisi alınır.
        $kendi = $this->gerekli === null || $this->mevcut === null
            ? 0
            : ($this->gerekli <= 0 ? 100 : (int) min(100, round($this->mevcut / $this->gerekli * 100)));

        return $this->telafi === null ? $kendi : max($kendi, $this->telafi->oran());
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
     * Beyan düğümleri HARİÇ: onlarda eksik bir veri yoktur, koşul doğası gereği
     * otomatik doğrulanamaz. İkisini aynı sayıda toplamak adaya "bir şey girmeyi
     * unuttun" dedirtir; oysa girilecek bir şey yoktur.
     *
     * @return list<self>
     */
    public function belirsizler(): array
    {
        return $this->topla(
            fn (self $d) => $d->cocuklar === [] && $d->durum === Durum::Belirsiz && ! $d->beyan,
        );
    }

    /**
     * Cetveli girilmediği için hesaplanamayan koşullar — bizim veri açığımız,
     * adayın değil. {@see beyanlar()} bunları da kapsar.
     *
     * @return list<self>
     */
    public function hesaplanamayanlar(): array
    {
        return $this->topla(fn (self $d) => $d->kaynakEksik);
    }

    /**
     * Kullanıcı beyanı BEKLEYEN maddeler.
     *
     * Aday kutusunu işaretlemişse beyan alınmıştır; adaya "şu kadar koşul
     * belge bekliyor" derken onları saymak, yaptığı işi görmezden gelirdi.
     *
     * @return list<self>
     */
    public function beyanlar(): array
    {
        return $this->topla(fn (self $d) => $d->beyan && ! $d->beyanOnaylandi);
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
