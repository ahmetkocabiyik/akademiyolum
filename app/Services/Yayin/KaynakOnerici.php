<?php

namespace App\Services\Yayin;

use App\Models\Faaliyet;

/**
 * Bir faaliyet için dergi indeksi (kaynak) önerir.
 *
 * ÖNERİ, KARAR DEĞİL. Kaynak puanı belirleyen tek alan; yanlış bir kademe
 * adayın hiç hak etmediği bir yönergeyi "uygun" gösterir. Bu yüzden:
 *   - Öneri asla kendiliğinden uygulanmıyor, aday onaylıyor.
 *   - Çeyreklik (Q1–Q4) ASLA tahmin edilmiyor. SCIE/SSCI ve Scopus
 *     kademeleri sözlükte yalnız çeyrekli var; dergi o dizinlerde görünse
 *     bile öneri üretilmiyor, yerine uyarı yazılıyor.
 *   - Uzun kuyruk dizinler (EBSCO, SOBİAD…) "Diğer Uluslararası İndeks" mi
 *     "Diğer Ulusal Hakemli" mi sayılır — yönergeden yönergeye değişiyor,
 *     tahmin edilmiyor; liste gösterilip karar adaya bırakılıyor.
 *
 * @phpstan-type Oneri array{
 *     kaynak: string|null,
 *     gerekce: string|null,
 *     uyari: string|null,
 *     atif: list<string>,
 *     diger: list<string>,
 *     slug: string|null,
 * }
 */
class KaynakOnerici
{
    /**
     * Dizin adı → sözlükteki kademe. Sıra ÖNEMLİ: ilk eşleşen kazanıyor,
     * liste en üst kademeden aşağı doğru.
     *
     * `kaynak` null olan satırlar "dergi bu dizinde ama sözlükte çeyreksiz
     * karşılığı yok" demek; öneri yerine uyarı üretiyorlar.
     *
     * @var list<array{desen: string, kaynak: string|null, ad: string}>
     */
    private const KADEMELER = [
        ['desen' => '/science citation index|sci-?expanded|\bscie\b/iu', 'kaynak' => null, 'ad' => 'SCIE'],
        ['desen' => '/social sciences citation index|\bssci\b/iu', 'kaynak' => null, 'ad' => 'SSCI'],
        ['desen' => '/arts\s*(and|&)\s*humanities|\bahci\b/iu', 'kaynak' => 'AHCI', 'ad' => 'AHCI'],
        ['desen' => '/emerging sources|\besci\b/iu', 'kaynak' => 'ESCI', 'ad' => 'ESCI'],
        ['desen' => '/scopus/iu', 'kaynak' => null, 'ad' => 'Scopus'],
        ['desen' => '/tr\s*dizin|ulakb[iı]m/iu', 'kaynak' => 'TR Dizin', 'ad' => 'TR Dizin'],
    ];

    public function __construct(private readonly DergiParkDizinleri $dizinler) {}

    /**
     * @return Oneri
     */
    public function oner(Faaliyet $faaliyet): array
    {
        $bos = ['kaynak' => null, 'gerekce' => null, 'uyari' => null, 'atif' => [], 'diger' => [], 'slug' => null];

        $gecerli = $faaliyet->kategori->adayKaynaklari();

        // 1) ADAYIN KENDİ GEÇMİŞİ — en güvenilir kaynak, çünkü kademeyi
        //    kendisi seçmiş. Ağa da çıkmıyor.
        $gecmis = $this->gecmisten($faaliyet);

        if ($gecmis !== null && in_array($gecmis, $gecerli, true)) {
            return [...$bos, 'kaynak' => $gecmis, 'gerekce' => 'Bu dergideki başka yayınınızda bu kademeyi seçmiştiniz.'];
        }

        // 2) DERGİPARK'IN DİZİN LİSTESİ
        $slug = $this->slug($faaliyet);

        if ($slug === null) {
            return $bos;
        }

        $dergi = $this->dizinler->dergi($slug);

        if ($dergi === null) {
            return [...$bos, 'slug' => $slug];
        }

        $atif = $dergi->atif_dizinleri ?? [];
        $diger = $dergi->diger_dizinler ?? [];
        $sonuc = [...$bos, 'slug' => $slug, 'atif' => $atif, 'diger' => $diger];

        foreach (self::KADEMELER as $kademe) {
            $eslesen = $this->eslesen($atif, $kademe['desen']);

            if ($eslesen === null) {
                continue;
            }

            if ($kademe['kaynak'] !== null && in_array($kademe['kaynak'], $gecerli, true)) {
                return [...$sonuc, 'kaynak' => $kademe['kaynak'], 'gerekce' => "DergiPark bu dergiyi {$eslesen} altında listeliyor."];
            }

            return [...$sonuc, 'uyari' => "Bu dergi {$kademe['ad']} kapsamında görünüyor; çeyreklik (Q1–Q4) künyeden çıkarılamadığı için kademeyi siz seçmelisiniz."];
        }

        return $sonuc;
    }

    /**
     * Aynı dergideki ONAYLANMIŞ başka yayının kademesi.
     */
    private function gecmisten(Faaliyet $faaliyet): ?string
    {
        $dergi = $faaliyet->meta['dergi'] ?? null;

        if (! is_string($dergi) || $dergi === '') {
            return null;
        }

        return Faaliyet::query()
            ->where('user_id', $faaliyet->user_id)
            ->whereKeyNot($faaliyet->getKey())
            ->where('kategori', $faaliyet->kategori->value)
            ->where('meta->dergi', $dergi)
            ->whereNotNull('kaynak')
            ->onaylanmis()
            ->latest('id')
            ->value('kaynak');
    }

    /**
     * DergiPark kısaltması. Bir kez çözülüp faaliyetin künyesine yazılıyor:
     * DergiPark'ta olmayan dergi için de (false) yazılıyor ki her açılışta
     * boşa DOI çözülmesin.
     */
    private function slug(Faaliyet $faaliyet): ?string
    {
        $kayitli = $faaliyet->meta['dergipark'] ?? null;

        if ($kayitli === false) {
            return null;
        }

        if (is_string($kayitli) && $kayitli !== '') {
            return $kayitli;
        }

        $doi = $faaliyet->meta['doi'] ?? null;

        if (! is_string($doi) || $doi === '') {
            return null;
        }

        $slug = $this->dizinler->slugBul($doi);

        $faaliyet->forceFill(['meta' => [...$faaliyet->meta ?? [], 'dergipark' => $slug ?? false]])->save();

        return $slug;
    }

    /**
     * @param  list<string>  $dizinler
     */
    private function eslesen(array $dizinler, string $desen): ?string
    {
        foreach ($dizinler as $dizin) {
            if (preg_match($desen, $dizin) === 1) {
                return $dizin;
            }
        }

        return null;
    }
}
