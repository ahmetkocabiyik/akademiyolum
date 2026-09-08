<?php

namespace App\Services\Scoring\Sart;

use App\Models\Faaliyet;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Şart ağacını adayın faaliyetlerine ve profiline karşı gezerek değerlendirir.
 *
 * Üç değerli mantık kullanır: bir koşul veri eksikliği yüzünden karara
 * bağlanamıyorsa {@see Durum::Belirsiz} döner. Faaliyetin tarihi yoksa dönem
 * kapsamlı bir koşul "sağlanmadı" değil "belirsiz"dir; böylece motor eksik
 * veriyle yanlış sonuç üretmek yerine neyin eksik olduğunu söyler.
 *
 * @phpstan-type Dugum array<string, mixed>
 */
class SartDegerlendirici
{
    /**
     * @param  (callable(string): ?array<string, mixed>)|null  $esikCozucu
     *                                                                      `referans` düğümünün hedef eşiği bulması için.
     */
    public function __construct(
        private readonly MaddeKatalogu $katalog,
        private $esikCozucu = null,
        /** Adayın "belgem var" diye işaretlediği beyan düğümlerinin anahtarları.
         * @var list<string> */
        private readonly array $beyanOnaylari = [],
    ) {}

    /**
     * @param  Dugum  $dugum
     * @param  iterable<Faaliyet>  $faaliyetler
     */
    public function degerlendir(array $dugum, iterable $faaliyetler, Profil $profil): SartSonucu
    {
        return $this->dugum($dugum, collect($faaliyetler), $profil, null);
    }

    /**
     * @param  Dugum  $dugum
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @param  int|null  $devirEksik  Telafi düğümünde: ana koşulun açığı (telafi_carpani için)
     */
    private function dugum(array $dugum, Collection $faaliyetler, Profil $profil, ?int $devirEksik): SartSonucu
    {
        $sonuc = match ($dugum['tip']) {
            've', 'veya', 'k_ile' => $this->birlestirici($dugum, $faaliyetler, $profil),
            'puan' => $this->puan($dugum, $faaliyetler, $profil, $devirEksik),
            'adet' => $this->adet($dugum, $faaliyetler, $profil),
            'metrik' => $this->metrik($dugum, $faaliyetler, $profil),
            'referans' => $this->referans($dugum, $faaliyetler, $profil),
            'beyan' => $this->beyan($dugum),
            default => throw new InvalidArgumentException("Bilinmeyen düğüm tipi: {$dugum['tip']}"),
        };

        return $this->telafiUygula($sonuc, $dugum, $faaliyetler, $profil);
    }

    /**
     * Ana koşul sağlanmadıysa `telafi` dalını dener. Telafi geçerse düğüm
     * sağlanmış sayılır; telafinin sonucu kayıtta kalır (arayüz "telafi ile
     * sağlandı" diyebilsin).
     *
     * @param  Dugum  $dugum
     * @param  Collection<int, Faaliyet>  $faaliyetler
     */
    private function telafiUygula(
        SartSonucu $sonuc,
        array $dugum,
        Collection $faaliyetler,
        Profil $profil,
    ): SartSonucu {
        if (! isset($dugum['telafi']) || $sonuc->saglandi()) {
            return $sonuc;
        }

        $telafi = $this->dugum($dugum['telafi'], $faaliyetler, $profil, $sonuc->eksik());

        // Telafi ilişkisi "ana VEYA telafi"dir. Kleene `veya` şart: ana koşul
        // kesin olumsuz ama telafi belirsizse sonuç BELİRSİZ olmalı — telafinin
        // sağlanıp sağlanmadığını bilmiyoruz, kesin ret veremeyiz.
        $durum = Durum::veya([$sonuc->durum, $telafi->durum]);

        return new SartSonucu(
            tip: $sonuc->tip,
            aciklama: $sonuc->aciklama,
            durum: $durum,
            gerekli: $sonuc->gerekli,
            mevcut: $sonuc->mevcut,
            cocuklar: $sonuc->cocuklar,
            telafi: $telafi,
            beyan: $sonuc->beyan,
            kaynakEksik: $sonuc->kaynakEksik,
            belirsizlikNedeni: $sonuc->belirsizlikNedeni,
            madde: $sonuc->madde,
            kapsam: $sonuc->kapsam,
            donusumler: $sonuc->donusumler,
            rol: $sonuc->rol,
            beyanOnaylandi: $sonuc->beyanOnaylandi,
        );
    }

    /**
     * @param  Dugum  $dugum
     * @param  Collection<int, Faaliyet>  $faaliyetler
     */
    private function birlestirici(array $dugum, Collection $faaliyetler, Profil $profil): SartSonucu
    {
        $cocuklar = array_map(
            fn (array $c): SartSonucu => $this->dugum($c, $faaliyetler, $profil, null),
            array_values($dugum['cocuklar']),
        );

        $durumlar = array_map(fn (SartSonucu $s) => $s->durum, $cocuklar);

        $durum = match ($dugum['tip']) {
            've' => Durum::ve($durumlar),
            'veya' => Durum::veya($durumlar),
            'k_ile' => Durum::kIle($durumlar, (int) $dugum['k']),
            default => throw new InvalidArgumentException("Birleştirici olmayan düğüm tipi: {$dugum['tip']}"),
        };

        return new SartSonucu(
            tip: $dugum['tip'],
            aciklama: $dugum['aciklama'],
            durum: $durum,
            gerekli: $dugum['tip'] === 'k_ile' ? (int) $dugum['k'] : null,
            mevcut: $dugum['tip'] === 'k_ile'
                ? count(array_filter($durumlar, fn (Durum $d) => $d === Durum::Saglandi))
                : null,
            cocuklar: $cocuklar,
            madde: $dugum['madde'] ?? null,
            rol: $dugum['rol'] ?? null,
        );
    }

    /**
     * @param  Dugum  $dugum
     * @param  Collection<int, Faaliyet>  $faaliyetler
     */
    private function puan(array $dugum, Collection $faaliyetler, Profil $profil, ?int $devirEksik): SartSonucu
    {
        $kodlar = $this->katalog->coz($dugum['maddeler']);
        [$kesin, $muhtemel] = $this->ayikla($this->uyanlar($faaliyetler, $kodlar), $dugum, $profil);

        $mevcut = $this->puanTopla($kesin, $kodlar);
        $iyimser = $mevcut + $this->puanTopla($muhtemel, $kodlar);

        // Telafi düğümünde gereken miktar ana koşulun açığından türeyebilir
        // (Trabzon: "her eksik puanın iki katı FAZLA puan"). `min_puan` bu
        // durumda taban olarak kalır ve türetilen miktar ONUN ÜSTÜNE biner:
        // Trabzon'da telafiye giren aday, yayınlardan istenen ilk barajdan
        // muaf olmuyor, açığın iki katını ona ek olarak sağlıyor.
        if (isset($dugum['telafi_carpani']) && $devirEksik !== null) {
            $gerekli = (int) ($dugum['min_puan'] ?? 0) + $devirEksik * (int) $dugum['telafi_carpani'];
        } elseif (isset($dugum['min_oran'])) {
            $paydaKodlar = $this->katalog->coz($dugum['oran_payda'] ?? ['*']);
            [$paydaKesin] = $this->ayikla($this->uyanlar($faaliyetler, $paydaKodlar), $dugum, $profil);
            $gerekli = (int) ceil($this->puanTopla($paydaKesin, $paydaKodlar) * (float) $dugum['min_oran']);
        } else {
            $gerekli = (int) ($dugum['min_puan'] ?? 0);
        }

        return new SartSonucu(
            tip: 'puan',
            aciklama: $dugum['aciklama'],
            durum: $this->karar($mevcut, $iyimser, $gerekli),
            gerekli: $gerekli,
            mevcut: $mevcut,
            belirsizlikNedeni: $muhtemel->isNotEmpty() ? $this->neden($dugum, $muhtemel, $profil) : null,
            madde: $dugum['madde'] ?? null,
            kapsam: $this->kapsam($dugum, $kodlar),
            rol: $dugum['rol'] ?? null,
        );
    }

    /**
     * @param  Dugum  $dugum
     * @param  Collection<int, Faaliyet>  $faaliyetler
     */
    private function adet(array $dugum, Collection $faaliyetler, Profil $profil): SartSonucu
    {
        $kodlar = $this->katalog->coz($dugum['maddeler']);
        [$kesin, $muhtemel] = $this->ayikla($this->uyanlar($faaliyetler, $kodlar), $dugum, $profil);

        $gerekli = (int) $dugum['min_adet'];
        $mevcut = $kesin->count();
        $iyimser = $mevcut + $muhtemel->count();

        // Eşdeğerlik: açığı dönüşüm kurallarıyla kapatmayı dene.
        $uygulananDonusumler = [];

        if ($mevcut < $gerekli && ! empty($dugum['donusumler'])) {
            $mevcut += $this->donusumUret(
                $dugum['donusumler'],
                $faaliyetler->reject(fn (Faaliyet $f) => $kesin->contains($f)),
                $profil,
                $gerekli - $mevcut,
                $uygulananDonusumler,
            );
            $iyimser = max($iyimser, $mevcut);
        }

        return new SartSonucu(
            tip: 'adet',
            aciklama: $dugum['aciklama'],
            durum: $this->karar($mevcut, $iyimser, $gerekli),
            gerekli: $gerekli,
            mevcut: $mevcut,
            belirsizlikNedeni: $muhtemel->isNotEmpty() ? $this->neden($dugum, $muhtemel, $profil) : null,
            madde: $dugum['madde'] ?? null,
            kapsam: $this->kapsam($dugum, $kodlar),
            rol: $dugum['rol'] ?? null,
        );
    }

    /**
     * Koşula sayılan kaynak etiketleri — arayüzde "hangi dergiler / hangi tür
     * çalışmalar sayılıyor?" sorusunun cevabı olarak rozetlenir.
     *
     * Toplam puan barajında liste bilgi taşımaz, boş döner: baraj ya cetvelin
     * tamamını ya da koca bir listeyi kapsar (Mersin TABLO C tek başına 68
     * kalem), rozete dökülünce okunmaz bir yığın olur. Kapsamı düğümün kendi
     * açıklaması zaten söylüyor ("TABLO B + C kalemlerinden…").
     *
     * @param  Dugum  $dugum
     * @param  list<string>  $kodlar
     * @return list<string>
     */
    private function kapsam(array $dugum, array $kodlar): array
    {
        if (($dugum['rol'] ?? null) === 'toplam' || in_array('*', $dugum['maddeler'], true)) {
            return [];
        }

        return $this->katalog->kapsam($kodlar);
    }

    /**
     * @param  Dugum  $dugum
     * @param  Collection<int, Faaliyet>  $faaliyetler
     */
    private function metrik(array $dugum, Collection $faaliyetler, Profil $profil): SartSonucu
    {
        $ad = $dugum['metrik'];

        if (isset($dugum['kademeler'])) {
            if ($profil->programDili === null || ! isset($dugum['kademeler'][$profil->programDili])) {
                return new SartSonucu(
                    tip: 'metrik', aciklama: $dugum['aciklama'], durum: Durum::Belirsiz,
                    belirsizlikNedeni: 'Birimin öğretim dili bilinmiyor',
                );
            }

            $gerekli = (int) $dugum['kademeler'][$profil->programDili];
        } else {
            $gerekli = (int) $dugum['min'];
        }

        $mevcut = $profil->metrik($ad);

        if ($mevcut === null) {
            return new SartSonucu(
                tip: 'metrik', aciklama: $dugum['aciklama'], durum: Durum::Belirsiz,
                gerekli: $gerekli,
                belirsizlikNedeni: $profil->eksikNedeni($ad),
            );
        }

        $uygulananDonusumler = [];

        if ($mevcut < $gerekli && ! empty($dugum['donusumler'])) {
            $mevcut += $this->donusumUret(
                $dugum['donusumler'], $faaliyetler, $profil, $gerekli - $mevcut, $uygulananDonusumler,
            );
        }

        return new SartSonucu(
            tip: 'metrik',
            aciklama: $dugum['aciklama'],
            durum: $this->karar($mevcut, $mevcut, $gerekli),
            gerekli: $gerekli,
            mevcut: $mevcut,
            madde: $dugum['madde'] ?? null,
            donusumler: $uygulananDonusumler,
            rol: $dugum['rol'] ?? null,
        );
    }

    /**
     * Otomatik doğrulanamayan koşul.
     *
     * Normalde BELİRSİZ döner — motor adayın belgesini göremez. Aday panelden
     * "bu belgem var" kutusunu işaretlemişse koşul SAĞLANDI sayılır: beyan
     * zaten adayın kendi belgesi hakkındaki ifadesidir, motorun tahmini değil.
     *
     * `kaynak_eksik` beyanları BUNUN DIŞINDA: onlar adayın belgesiyle değil
     * bizim eksiğimizle ilgili (cetvel henüz girilmemiş). İşaretlenebilir
     * olsalardı aday kendi lehine bizim boşluğumuzu kapatmış olurdu — §0'ın
     * yasakladığı fazla sayma.
     *
     * @param  Dugum  $dugum
     */
    private function beyan(array $dugum): SartSonucu
    {
        $kaynakEksik = (bool) ($dugum['kaynak_eksik'] ?? false);
        $madde = $dugum['madde'] ?? null;

        $onaylandi = ! $kaynakEksik && in_array(
            SartSonucu::beyanAnahtariUret($dugum['aciklama'], $madde),
            $this->beyanOnaylari,
            true,
        );

        return new SartSonucu(
            tip: 'beyan',
            aciklama: $dugum['aciklama'],
            durum: $onaylandi ? Durum::Saglandi : Durum::Belirsiz,
            beyan: true,
            belirsizlikNedeni: match (true) {
                $onaylandi => null,
                $kaynakEksik => 'Bu koşulun dayandığı puan cetveli henüz sisteme eklenmedi',
                default => 'Belge ile beyan edilmeli',
            },
            madde: $madde,
            kaynakEksik: $kaynakEksik,
            rol: $dugum['rol'] ?? null,
            beyanOnaylandi: $onaylandi,
        );
    }

    /**
     * Başka bir eşiğin şartını yeniden çağırır; kendi `donem`ini alt düğümlere
     * (kendi dönemi olmayanlara) geçirir.
     *
     * @param  Dugum  $dugum
     * @param  Collection<int, Faaliyet>  $faaliyetler
     */
    private function referans(array $dugum, Collection $faaliyetler, Profil $profil): SartSonucu
    {
        $hedef = $this->esikCozucu !== null ? ($this->esikCozucu)($dugum['esik']) : null;

        if ($hedef === null || ! isset($hedef['sart'])) {
            return new SartSonucu(
                tip: 'referans', aciklama: $dugum['aciklama'], durum: Durum::Belirsiz,
                belirsizlikNedeni: "Referans verilen eşik bulunamadı: {$dugum['esik']}",
            );
        }

        $agac = $this->donemGecir($hedef['sart'], $dugum['donem'] ?? null, $dugum['haric'] ?? null);
        $ic = $this->dugum($agac, $faaliyetler, $profil, null);

        return new SartSonucu(
            tip: 'referans',
            aciklama: $dugum['aciklama'],
            durum: $ic->durum,
            cocuklar: [$ic],
        );
    }

    /**
     * Dönem/hariç bilgisini, kendi tanımı olmayan alt düğümlere yayar.
     *
     * @param  Dugum  $dugum
     * @param  array<string, mixed>|null  $donem
     * @param  list<string>|null  $haric
     * @return Dugum
     */
    private function donemGecir(array $dugum, ?array $donem, ?array $haric): array
    {
        if ($donem !== null && ! isset($dugum['donem'])) {
            $dugum['donem'] = $donem;
        }

        if ($haric !== null) {
            $dugum['haric'] = array_merge($dugum['haric'] ?? [], $haric);
        }

        foreach (['cocuklar'] as $dal) {
            if (isset($dugum[$dal])) {
                $dugum[$dal] = array_map(
                    fn (array $c) => $this->donemGecir($c, $donem, $haric),
                    $dugum[$dal],
                );
            }
        }

        if (isset($dugum['telafi'])) {
            $dugum['telafi'] = $this->donemGecir($dugum['telafi'], $donem, $haric);
        }

        return $dugum;
    }

    // ── Yardımcılar ──────────────────────────────────────────────────────────

    /**
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @param  list<string>  $kodlar
     * @return Collection<int, Faaliyet>
     */
    private function uyanlar(Collection $faaliyetler, array $kodlar): Collection
    {
        return $faaliyetler->filter(fn (Faaliyet $f) => $this->katalog->eslesir($f, $kodlar))->values();
    }

    /**
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @param  list<string>  $kodlar
     */
    private function puanTopla(Collection $faaliyetler, array $kodlar): int
    {
        return $this->katalog->topla($faaliyetler, $kodlar);
    }

    /**
     * Adayları kesin sayılanlar ve (veri eksikliği yüzünden) belki sayılanlar
     * diye ikiye ayırır. Yazarlık/dönem/hariç filtrelerinden geçemeyenler düşer.
     *
     * @param  Collection<int, Faaliyet>  $adaylar
     * @param  Dugum  $dugum
     * @return array{0: Collection<int, Faaliyet>, 1: Collection<int, Faaliyet>}
     */
    private function ayikla(Collection $adaylar, array $dugum, Profil $profil): array
    {
        $kesin = [];
        $muhtemel = [];

        foreach ($adaylar as $faaliyet) {
            $karar = $this->faaliyetDurumu($faaliyet, $dugum, $profil);

            if ($karar === 'kesin') {
                $kesin[] = $faaliyet;
            } elseif ($karar === 'muhtemel') {
                $muhtemel[] = $faaliyet;
            }
        }

        return [collect($kesin), collect($muhtemel)];
    }

    /**
     * @param  Dugum  $dugum
     * @return 'kesin'|'muhtemel'|'red'
     */
    private function faaliyetDurumu(Faaliyet $faaliyet, array $dugum, Profil $profil): string
    {
        $belirsiz = false;

        if (isset($dugum['yazar'])) {
            $rol = $faaliyet->rol;

            if ($rol === null) {
                $belirsiz = true;
            } elseif (! $this->yazarUyar($rol, $dugum['yazar'])) {
                return 'red';
            }
        }

        foreach ($dugum['haric'] ?? [] as $etiket) {
            $deger = $faaliyet->haricDegeri($etiket);

            if ($deger === null) {
                $belirsiz = true;
            } elseif ($deger) {
                return 'red';
            }
        }

        if (isset($dugum['donem'])) {
            $donemKarari = $this->donemDurumu($faaliyet, $dugum['donem'], $profil);

            if ($donemKarari === 'red') {
                return 'red';
            }

            $belirsiz = $belirsiz || $donemKarari === 'muhtemel';
        }

        return $belirsiz ? 'muhtemel' : 'kesin';
    }

    /**
     * @param  array<string, mixed>  $donem
     * @return 'kesin'|'muhtemel'|'red'
     */
    private function donemDurumu(Faaliyet $faaliyet, array $donem, Profil $profil): string
    {
        $tarih = $faaliyet->tarih;

        if ($tarih === null) {
            return 'muhtemel';
        }

        $sinirlar = [];

        if (($donem['baslangic'] ?? null) !== null) {
            $referans = $profil->referansTarih($donem['baslangic']);

            if ($referans === null) {
                return 'muhtemel';
            }

            $sinirlar[] = $referans;
        }

        if (($donem['son_yil'] ?? null) !== null) {
            $sinirlar[] = now()->subYears((int) $donem['son_yil']);
        }

        foreach ($sinirlar as $sinir) {
            if ($tarih->lt($sinir)) {
                return 'red';
            }
        }

        return 'kesin';
    }

    private function yazarUyar(string $rol, string $istenen): bool
    {
        return match ($istenen) {
            'tek' => $rol === 'tek',
            'ilk' => in_array($rol, ['tek', 'ilk'], true),
            'baslica' => in_array($rol, ['tek', 'ilk', 'baslica'], true),
            default => true,
        };
    }

    /**
     * Eşdeğerlik kurallarıyla açığı kapatmayı dener. Her dönüşümün kendi kotası
     * vardır; `kota_grubu` aynı olan dönüşümler tek kotayı paylaşır. Bir kaynak
     * eser iki dönüşümde birden kullanılamaz.
     *
     * @param  list<array<string, mixed>>  $donusumler
     * @param  Collection<int, Faaliyet>  $havuz
     * @param  list<string>  $uygulanan  Fiilen devreye giren eşdeğerliklerin açıklaması
     */
    private function donusumUret(array $donusumler, Collection $havuz, Profil $profil, int $eksik, array &$uygulanan = []): int
    {
        $kalanKota = [];
        $kullanilabilir = $havuz->all();
        $uretilen = 0;

        foreach ($donusumler as $sira => $donusum) {
            if ($eksik <= 0) {
                break;
            }

            $anahtar = $donusum['kota_grubu'] ?? "#{$sira}";
            $kalanKota[$anahtar] ??= (int) $donusum['azami'];

            if ($kalanKota[$anahtar] <= 0) {
                continue;
            }

            $kaynakAdi = $donusum['kaynak'][0] ?? '';

            if (count($donusum['kaynak']) === 1 && $profil->metrikTanimli($kaynakAdi)) {
                $adet = $profil->metrik($kaynakAdi) ?? 0;
                $secilen = [];
            } else {
                $kodlar = $this->katalog->coz($donusum['kaynak']);
                $secilen = array_values(array_filter(
                    $kullanilabilir,
                    fn (Faaliyet $f) => $this->katalog->eslesir($f, $kodlar),
                ));
                $adet = count($secilen);
            }

            $uretilebilir = intdiv($adet, (int) $donusum['kaynak_adet']) * (int) $donusum['hedef_adet'];
            $al = min($uretilebilir, $kalanKota[$anahtar], $eksik);

            if ($al <= 0) {
                continue;
            }

            if ($secilen !== []) {
                $tuketilen = (int) ceil($al / (int) $donusum['hedef_adet']) * (int) $donusum['kaynak_adet'];
                $harcanan = array_slice($secilen, 0, $tuketilen);
                $kullanilabilir = array_values(array_filter(
                    $kullanilabilir,
                    fn (Faaliyet $f) => ! in_array($f, $harcanan, true),
                ));
            }

            $kalanKota[$anahtar] -= $al;
            $eksik -= $al;
            $uretilen += $al;

            if (isset($donusum['aciklama'])) {
                $uygulanan[] = (string) $donusum['aciklama'];
            }
        }

        return $uretilen;
    }

    /**
     * Kesin değer koşulu karşılıyorsa sağlandı; iyimser değer bile
     * karşılamıyorsa sağlanmadı; arada ise belirsiz.
     */
    private function karar(int $mevcut, int $iyimser, int $gerekli): Durum
    {
        if ($mevcut >= $gerekli) {
            return Durum::Saglandi;
        }

        return $iyimser >= $gerekli ? Durum::Belirsiz : Durum::Saglanmadi;
    }

    /**
     * Belirsizliğin adaya söylenecek gerekçesi.
     *
     * @param  Dugum  $dugum
     * @param  Collection<int, Faaliyet>  $muhtemel  Karara bağlanamayan faaliyetler
     */
    private function neden(array $dugum, Collection $muhtemel, Profil $profil): string
    {
        if (isset($dugum['donem'])) {
            // Dönem koşulu iki veriye dayanır; hangisinin eksik olduğunu
            // söylemezsek aday yanlış yeri doldurur.
            $gerekceler = array_filter([
                $profil->donemReferansEksik($dugum['donem']['baslangic'] ?? null),
                $muhtemel->contains(fn (Faaliyet $f) => $f->tarih === null)
                    ? 'bazı faaliyetlerin tarihi girilmemiş'
                    : null,
            ]);

            if ($gerekceler !== []) {
                return implode(', ', $gerekceler).' — dönem kapsamı doğrulanamıyor';
            }
        }

        if (isset($dugum['haric'])) {
            return 'Bazı faaliyetlerde dışlama bilgisi (ör. tezden üretilme) girilmemiş';
        }

        return 'Bazı faaliyetlerde yazarlık rolü girilmemiş';
    }
}
