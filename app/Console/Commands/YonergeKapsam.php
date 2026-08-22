<?php

namespace App\Console\Commands;

use App\Enums\TemelAlan;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Yönerge verisinin kapsam, kalite ve TALEP raporu.
 *
 * Üç soruyu birden cevaplar:
 *   1. Hangi üniversitelerin verisi girildi, hangi kadro/alan eksik?
 *   2. Girilen veri ne kadar sağlam (beyan oranı = otomatik doğrulanamayan koşul)?
 *   3. Kullanıcılar hangi üniversiteleri seçiyor da verisi henüz yok?
 *
 * 3. soru sıralamayı belirler: emek, dosya sırasına değil talebe göre harcanır.
 */
class YonergeKapsam extends Command
{
    protected $signature = 'yonerge:kapsam
        {--talep : Yalnızca talep listesini göster (verisi olmayan, en çok seçilen üniversiteler)}
        {--limit=25 : Talep listesinde gösterilecek satır sayısı}';

    protected $description = 'Yönerge verisinin kapsam, kalite ve kullanıcı talebi raporu';

    public function handle(SartDeposu $depo): int
    {
        if ($this->option('talep')) {
            return $this->talep($depo);
        }

        $this->kapsam($depo);
        $this->newLine();
        $this->talep($depo);

        return self::SUCCESS;
    }

    private function kapsam(SartDeposu $depo): void
    {
        $esikler = collect($depo->esikler());
        $kadrolar = ['dr_ogr_uyesi', 'docentlik', 'profesorluk'];
        $alanSayisi = count(TemelAlan::cases());
        $hedef = $alanSayisi * count($kadrolar);

        $this->info('KAPSAM — girilen üniversiteler');
        $this->line(str_repeat('─', 82));

        $satirlar = [];

        foreach ($esikler->groupBy('universite') as $universite => $kayitlar) {
            $dugum = 0;
            $beyan = 0;
            $kaynakEksik = 0;

            foreach ($kayitlar as $kayit) {
                $this->say($kayit['sart'], $dugum, $beyan, $kaynakEksik);
            }

            $taslak = $kayitlar->where('durum', SartDeposu::TASLAK)->count();

            // Bir üniversitede o temel alanın HİÇBİR kadrosu yoksa fakülte de
            // yoktur (Sabancı'nın tıp ya da ilahiyat fakültesi yok) — bu eksik
            // veri değil, doğru yokluk. Eksik sayılan yalnızca bazı kadrosu
            // girilip bazısı girilmemiş alanlar; "eksik" sütunu ancak böyle
            // eyleme dönük oluyor.
            $birimler = $depo->birimler($universite);
            $bulunur = function (string $kadro, string $alan) use ($depo, $universite, $birimler): bool {
                if ($depo->bul($universite, $kadro, $alan) !== null) {
                    return true;
                }

                // Programa göre ayrışan yönergelerde eşik ancak program
                // verilince dönüyor; rapor programsız çağırdığı için tek tek denenir.
                foreach ($birimler as $birim) {
                    if ($depo->bul($universite, $kadro, $alan, $birim) !== null) {
                        return true;
                    }
                }

                return false;
            };

            $eksik = [];

            foreach (TemelAlan::cases() as $alan) {
                $varlar = array_filter($kadrolar, fn (string $k) => $bulunur($k, $alan->value));

                if ($varlar === []) {
                    continue; // Üniversitede bu alan yok.
                }

                foreach ($kadrolar as $kadro) {
                    if (! $bulunur($kadro, $alan->value)) {
                        $eksik[] = "{$kadro}/{$alan->value}";
                    }
                }
            }

            $satirlar[] = [
                'universite' => $universite,
                'esik' => $kayitlar->count().'/'.$hedef,
                'taslak' => $taslak === 0 ? '—' : $taslak,
                'dugum' => $dugum,
                'beyan' => $beyan,
                'kaynak_eksik' => $kaynakEksik,
                'oran' => $dugum > 0 ? round(100 * $beyan / $dugum).'%' : '—',
                'eksik' => $eksik === [] ? '—' : count($eksik).' kombinasyon',
            ];
        }

        $this->table(
            ['Üniversite', 'Eşik', 'Taslak', 'Düğüm', 'Beyan', 'Cetvel eksik', 'Beyan oranı', 'Eksik'],
            $satirlar,
        );

        $toplamDugum = array_sum(array_column($satirlar, 'dugum'));
        $toplamBeyan = array_sum(array_column($satirlar, 'beyan'));
        $toplamKaynakEksik = array_sum(array_column($satirlar, 'kaynak_eksik'));

        $taslakToplam = $esikler->where('durum', SartDeposu::TASLAK)->count();

        // "Beyan" kalıcı bir gerçeklik (jüri kararı, belge); "cetvel eksik" bizim
        // veri açığımız ve kapanabilir. İkisi ayrı raporlanmazsa açık ölçülemez.
        $this->line(sprintf(
            '  %d üniversite · %d eşik · %d düğüm · %d beyan (%%%d) · %d düğüm cetvel eksikliğinden hesaplanamıyor',
            count($satirlar),
            $esikler->count(),
            $toplamDugum,
            $toplamBeyan,
            $toplamDugum > 0 ? round(100 * $toplamBeyan / $toplamDugum) : 0,
            $toplamKaynakEksik,
        ));

        // Taslak eşik adaya GÖSTERİLMEZ; sayısı burada durur ki doğrulama
        // kuyruğunun uzunluğu ölçülebilsin.
        if ($taslakToplam > 0) {
            $this->warn(sprintf(
                '  %d eşik TASLAK — kaynağına karşı okunmadığı için adaya gösterilmiyor.',
                $taslakToplam,
            ));
        }
    }

    private function talep(SartDeposu $depo): int
    {
        $girilen = $depo->universiteler();

        $this->info('TALEP — kullanıcıların seçtiği ama verisi olmayan üniversiteler');
        $this->line(str_repeat('─', 82));

        /** @var array<string, int> $secimler  Üniversite adı => kullanıcı sayısı */
        $secimler = User::query()
            ->whereNotNull('universite')
            ->groupBy('universite')
            ->orderByRaw('count(*) desc')
            ->pluck(DB::raw('count(*)'), 'universite')
            ->all();

        if ($secimler === []) {
            $this->warn('  Henüz üniversite seçmiş kullanıcı yok.');
            $this->line('  Talep verisi birikene kadar öncelik için: büyük devlet üniversiteleri.');
            $this->newLine();
            $this->line('  Veri girilmemiş üniversite sayısı: '.
                (Universite::query()->whereNotIn('ad', $girilen)->count()));

            return self::SUCCESS;
        }

        $satirlar = collect($secimler)
            ->reject(fn (int $adet, string $ad) => in_array($ad, $girilen, true))
            ->take((int) $this->option('limit'))
            ->map(fn (int $adet, string $ad) => [
                'universite' => $ad,
                'kullanici' => $adet,
                'durum' => '✗ EKSİK',
            ])
            ->values();

        if ($satirlar->isEmpty()) {
            $this->line('  Kullanıcıların seçtiği tüm üniversitelerin verisi girilmiş.');

            return self::SUCCESS;
        }

        $this->table(['Üniversite', 'Kullanıcı', 'Durum'], $satirlar->all());
        $this->line('  ↑ Sıradaki giriş önceliği bu liste.');

        return self::SUCCESS;
    }

    /**
     * Ağaçtaki düğüm, beyan ve "cetveli eksik" sayısını toplar.
     *
     * @param  array<string, mixed>  $dugum
     */
    private function say(array $dugum, int &$toplam, int &$beyan, int &$kaynakEksik): void
    {
        $toplam++;

        if (($dugum['tip'] ?? null) === 'beyan') {
            $beyan++;

            if ($dugum['kaynak_eksik'] ?? false) {
                $kaynakEksik++;
            }
        }

        foreach ($dugum['cocuklar'] ?? [] as $cocuk) {
            $this->say($cocuk, $toplam, $beyan, $kaynakEksik);
        }

        if (isset($dugum['telafi'])) {
            $this->say($dugum['telafi'], $toplam, $beyan, $kaynakEksik);
        }
    }
}
