<?php

namespace App\Services\Yayin;

use App\Models\Faaliyet;
use App\Models\User;

/**
 * Aynı yayının iki ayrı yoldan iki kez eklenmesini engeller.
 *
 * NEDEN GEREKTİ: üç içe aktarma yolunun üçü de kendi anahtarına bakıyordu —
 * Crossref `meta.doi`'ye, DergiPark arşivi `meta.dergipark_makale`'ye, AVESİS
 * `meta.avesis_id`'ye. Kümeler kesişmediği için aynı makaleyi hem Crossref'ten
 * hem AVESİS'ten alan aday iki satır ekliyordu ve adet koşulları ("en az 3
 * SCIE makale") onu İKİ SAYIYORDU. Tek kaynak varken önemsizdi, üç olunca
 * gerçek bir fazla sayma kapısı.
 *
 * ÜÇ İZ, ÜÇ AYRI KESİNLİK:
 *   doi    — aynı DOI aynı yayın. Tartışmasız.
 *   kayit  — aynı kaynak sisteminin aynı kaydı. Tartışmasız.
 *   baslik — aynı kategoride aynı başlık. Tahmin; yalnız ayırt edici
 *            başlıklarda kullanılıyor (aşağıya bak).
 *
 * BAŞLIK EŞLEŞMESİ NEDEN KATEGORİYE BAĞLI: aynı çalışmanın önce bildirisi
 * sonra makalesi yayımlanıyor ve ikisi ayrı ayrı sayılıyor. Kategori
 * ayrımı olmasaydı biri diğerini bastırırdı.
 *
 * KISA BAŞLIKTA İZ ÜRETİLMİYOR: kitap bölümlerinde "Giriş", "Anhang" gibi
 * adlar var; farklı kitapların bölümleri aynı ada sahip olabiliyor.
 *
 * GÖREVLERDE BAŞLIK İZİNE YIL DA GİRİYOR: bir yayının adı onu tek başına
 * tanımlar, bir görevin adı tanımlamaz — aynı kişi "Bölüm Başkanı"nı iki
 * ayrı dönem yapmış olabilir ve ikisi ayrı ayrı sayılır. Yıl olmasaydı
 * ikinci dönem mükerrer sanılıp elenirdi.
 */
class MukerrerDenetimi
{
    /** Başlık izinin üretilmesi için gereken en az karakter ve kelime. */
    private const EN_AZ_HARF = 25;

    private const EN_AZ_KELIME = 3;

    /** Başlığı tek başına ayırt edici sayılan kategoriler (yayınlar). */
    private const YAYIN_KATEGORILERI = ['makale', 'bildiri', 'kitap', 'tez_yayini'];

    /**
     * Adayın listesindeki kayıtların izleri.
     *
     * @return array<string, string> iz => sebep
     */
    public function harita(User $kullanici): array
    {
        $harita = [];

        $kullanici->faaliyetler()
            ->select(['id', 'kategori', 'baslik', 'meta'])
            ->get()
            ->each(function (Faaliyet $faaliyet) use (&$harita): void {
                $yil = $faaliyet->tarih?->year;

                foreach ($this->izler($faaliyet->kategori->value, $faaliyet->baslik, $faaliyet->meta ?? [], $yil) as $iz => $sebep) {
                    $harita[$iz] = $sebep;
                }
            });

        return $harita;
    }

    /**
     * Aday kayıt listede var mı; varsa hangi izden.
     *
     * @param  array<string, string>  $harita
     * @param  array<string, mixed>  $meta
     */
    public function eslesme(array $harita, string $kategori, string $baslik, array $meta, ?int $yil = null): ?string
    {
        foreach (array_keys($this->izler($kategori, $baslik, $meta, $yil)) as $iz) {
            if (isset($harita[$iz])) {
                return $harita[$iz];
            }
        }

        return null;
    }

    /**
     * Bir kaydın izleri.
     *
     * Künye (`meta`) hem kayıtlı faaliyetten hem de içe aktarma adayından
     * AYNI biçimde geliyor: içe aktarıcılar kaydedecekleri künyeyi zaten
     * kuruyor, denetim de onu alıyor. Böylece "bu kaydı ne tanımlar"
     * sorusunun tek bir cevabı oluyor.
     *
     * @param  array<string, mixed>  $meta
     * @return array<string, string> iz => sebep
     */
    public function izler(string $kategori, string $baslik, array $meta, ?int $yil = null): array
    {
        $izler = [];

        $doi = $this->doi($meta['doi'] ?? null);

        if ($doi !== null) {
            $izler['doi:'.$doi] = 'doi';
        }

        if (is_string($meta['avesis_id'] ?? null) && $meta['avesis_id'] !== '') {
            $izler['kayit:avesis:'.$meta['avesis_id']] = 'kayit';
        }

        if (is_string($meta['dergipark_makale'] ?? null) && $meta['dergipark_makale'] !== '') {
            $izler['kayit:dergipark:'.((string) ($meta['dergipark'] ?? '')).':'.$meta['dergipark_makale']] = 'kayit';
        }

        $anahtar = $this->baslikAnahtari($baslik);

        if ($anahtar !== null) {
            $donem = in_array($kategori, self::YAYIN_KATEGORILERI, true) ? '' : ':'.($yil ?? '-');
            $izler['baslik:'.$kategori.':'.$anahtar.$donem] = 'baslik';
        }

        return $izler;
    }

    private function doi(mixed $ham): ?string
    {
        if (! is_string($ham)) {
            return null;
        }

        // "https://doi.org/10.x/y", "doi:10.x/y" ve "10.x/y" aynı şey.
        $sade = mb_strtolower(trim($ham));
        $sade = (string) preg_replace('~^(https?://)?(dx\.)?doi\.org/|^doi:\s*~', '', $sade);

        return str_starts_with($sade, '10.') ? rtrim($sade, '.') : null;
    }

    /**
     * Karşılaştırılabilir başlık. Ayırt edici değilse null.
     */
    private function baslikAnahtari(string $baslik): ?string
    {
        // Türkçe harfler elle iniyor: mb_strtolower "İ"yi i + birleşen nokta
        // yapıyor ve iki yazım eşleşmiyor.
        $metin = strtr($baslik, [
            'İ' => 'i', 'I' => 'i', 'ı' => 'i', 'Ş' => 's', 'ş' => 's',
            'Ğ' => 'g', 'ğ' => 'g', 'Ü' => 'u', 'ü' => 'u', 'Ö' => 'o',
            'ö' => 'o', 'Ç' => 'c', 'ç' => 'c', 'Â' => 'a', 'â' => 'a',
            'Î' => 'i', 'î' => 'i', 'Û' => 'u', 'û' => 'u',
        ]);

        $metin = mb_strtolower($metin, 'UTF-8');
        $metin = trim((string) preg_replace('/\s+/', ' ', (string) preg_replace('/[^a-z0-9]+/u', ' ', $metin)));

        if (mb_strlen($metin) < self::EN_AZ_HARF || count(explode(' ', $metin)) < self::EN_AZ_KELIME) {
            return null;
        }

        return $metin;
    }
}
