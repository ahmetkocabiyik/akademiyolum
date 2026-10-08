<?php

namespace App\Console\Commands;

use App\Enums\EpostaTuru;
use App\Models\Abonelik;
use App\Services\Eposta\EpostaGonderici;
use Carbon\CarbonImmutable;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

/**
 * Abonelik bildirimlerini gönderir; her gün zamanlanmış çalışır
 * (routes/console.php).
 *
 *   - Bitişine HATIRLATMA_GUN ya da daha az kalan aktif aboneliklere
 *     hatırlatma; o gün hatırlatma gidenlerin listesi yöneticilere.
 *   - Bitiş günü geçmiş aboneliklere "sona erdi".
 *
 * Her mail bir abonelik için bir kez gider (gonderildi_at izleri). "Tam 7
 * gün kala" değil "7 gün ya da daha az" aranıyor: görev bir gün çalışmazsa
 * hatırlatma kaçmasın, ertesi gün gitsin. Yenilenmiş abonelik (aynı
 * kullanıcının daha geç biten bir dönemi var) mail almaz.
 */
#[Signature('abonelik:bildir')]
#[Description('Süresi yaklaşan ve biten abonelikler için e-posta gönderir.')]
class AbonelikBildir extends Command
{
    /** "Sona erdi" maili bitişten en geç bu kadar gün sonra gider. */
    public const GEC_BILDIRIM_GUN = 7;

    public function handle(EpostaGonderici $eposta): int
    {
        $bugun = CarbonImmutable::today();

        $hatirlatilanlar = Abonelik::query()
            ->aktif()
            ->whereNull('hatirlatma_gonderildi_at')
            ->whereNotNull('bitis')
            ->whereDate('bitis', '<=', $bugun->addDays(EpostaTuru::HATIRLATMA_GUN)->toDateString())
            ->with('user')
            ->get()
            ->reject(fn (Abonelik $a) => $a->yenilendiMi())
            ->values();

        foreach ($hatirlatilanlar as $abonelik) {
            $eposta->abonelikBitiyor($abonelik);
            $abonelik->forceFill(['hatirlatma_gonderildi_at' => now()])->save();
        }

        $eposta->bitiyorOzeti($hatirlatilanlar);

        $bitenler = Abonelik::query()
            ->whereNull('iptal_edildi_at')
            ->whereNull('bitis_bildirimi_gonderildi_at')
            ->whereNotNull('bitis')
            ->whereDate('bitis', '<', $bugun->toDateString())
            ->with('user')
            ->get();

        $bittiSayisi = 0;

        // Bundan eski bitişlere mail gitmez, yalnız iz yazılır: görev ilk kez
        // çalıştığında (ya da uzun süre çalışmadıysa) aylar önce bitmiş
        // aboneliklere toplu "sona erdi" gitmesin.
        $esik = $bugun->subDays(self::GEC_BILDIRIM_GUN);

        foreach ($bitenler as $abonelik) {
            // Yenilenmişse mail yok ama iz yine yazılıyor: yeni dönem iptal
            // edilirse bu eski dönem için geç bir "sona erdi" gitmesin.
            if ($abonelik->bitis?->greaterThanOrEqualTo($esik) && ! $abonelik->yenilendiMi()) {
                $eposta->abonelikBitti($abonelik);
                $bittiSayisi++;
            }

            $abonelik->forceFill(['bitis_bildirimi_gonderildi_at' => now()])->save();
        }

        $this->info("Hatırlatma: {$hatirlatilanlar->count()}, sona erdi: {$bittiSayisi}.");

        return self::SUCCESS;
    }
}
