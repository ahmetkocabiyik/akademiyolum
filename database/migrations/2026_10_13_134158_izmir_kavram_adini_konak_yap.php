<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * İzmir Kavram Meslek Yüksekokulu'nun adı 31.01.2026 tarihli Resmî Gazete'deki
 * Cumhurbaşkanı Kararı (sayı 10929) ile "İzmir Konak Meslek Yüksekokulu" oldu.
 * Kurum aynı; YÖK Atlas 2026 kılavuzu yeni adla listeliyor.
 *
 * Yönerge verisi (database/data/yonerge/izmir-kavram.php) yeni adı kullanıyor;
 * ad tutan metin sütunları da taşınıyor, yoksa eski adı seçmiş kullanıcı
 * yönergesini bulamazdı. Karşılaştırmalar Haliç düzeltmesindeki sebeple PHP'de
 * bayt bayt yapılıyor ({@see 2026_09_08_090000_halic_universite_adini_duzelt.php}).
 *
 * Yeni adlı satır zaten varsa (seeder önce çalışmışsa) eski satır silinir;
 * panelde girilmiş yönerge bağlantısı yenisinde boşsa ona aktarılır.
 */
return new class extends Migration
{
    public const ESKI = 'İzmir Kavram Meslek Yüksekokulu';

    public const YENI = 'İzmir Konak Meslek Yüksekokulu';

    /** Üniversite adını metin olarak tutan sütunlar. */
    private const AD_SUTUNLARI = [['users', 'universite'], ['juri_raporlari', 'universite']];

    public function up(): void
    {
        $this->yenidenAdlandir(self::ESKI, self::YENI);
    }

    public function down(): void
    {
        $this->yenidenAdlandir(self::YENI, self::ESKI);
    }

    private function yenidenAdlandir(string $eski, string $yeni): void
    {
        $eskiSatir = $this->idleri('universiteler', 'ad', $eski);
        $yeniSatir = $this->idleri('universiteler', 'ad', $yeni);

        if ($eskiSatir !== [] && $yeniSatir !== []) {
            $url = DB::table('universiteler')->where('id', $eskiSatir[0])->value('yonerge_url');
            DB::table('universiteler')->where('id', $yeniSatir[0])->whereNull('yonerge_url')->update(['yonerge_url' => $url]);
            DB::table('universiteler')->whereIn('id', $eskiSatir)->delete();
        } else {
            DB::table('universiteler')->whereIn('id', $eskiSatir)->update(['ad' => $yeni]);
        }

        foreach (self::AD_SUTUNLARI as [$tablo, $sutun]) {
            DB::table($tablo)->whereIn('id', $this->idleri($tablo, $sutun, $eski))->update([$sutun => $yeni]);
        }

        // Benzersiz sütun: yeni adla kayıt varsa eskisine dokunulmaz.
        if ($this->idleri('gizli_yonergeler', 'universite', $yeni) === []) {
            DB::table('gizli_yonergeler')->whereIn('id', $this->idleri('gizli_yonergeler', 'universite', $eski))->update(['universite' => $yeni]);
        }
    }

    /**
     * Sütunu verilen değere BAYT BAYT eşit olan satırların id'leri.
     *
     * @return list<int>
     */
    private function idleri(string $tablo, string $sutun, string $deger): array
    {
        $idler = [];

        foreach (DB::table($tablo)->select('id', $sutun)->get() as $satir) {
            if ($satir->{$sutun} === $deger) {
                $idler[] = (int) $satir->id;
            }
        }

        return $idler;
    }
};
