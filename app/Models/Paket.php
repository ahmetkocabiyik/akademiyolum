<?php

namespace App\Models;

use App\Enums\Plan;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Bir abonelik paketinin panelden düzenlenen bilgileri.
 *
 * @property int $id
 * @property Plan $plan
 * @property string $ad
 * @property string|null $aciklama
 * @property int $aylik_fiyat_kurus
 * @property int|null $yillik_fiyat_kurus
 * @property list<string> $ozellikler
 * @property string $buton_metni
 * @property bool $satista
 * @property bool $one_cikan
 * @property int|null $guncelleyen_id
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'plan', 'ad', 'aciklama', 'aylik_fiyat_kurus', 'yillik_fiyat_kurus',
    'ozellikler', 'buton_metni', 'satista', 'one_cikan', 'guncelleyen_id',
])]
class Paket extends Model
{
    protected $table = 'paketler';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'plan' => Plan::class,
            'aylik_fiyat_kurus' => 'integer',
            'yillik_fiyat_kurus' => 'integer',
            'ozellikler' => 'array',
            'satista' => 'boolean',
            'one_cikan' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function guncelleyen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guncelleyen_id');
    }

    /**
     * Yıllık fiyatın 12 aylığa göre indirimi (%); yıllık fiyat yoksa ya da
     * indirim yoksa null.
     */
    public function yillikIndirim(): ?int
    {
        $tamYil = $this->aylik_fiyat_kurus * 12;

        if ($this->yillik_fiyat_kurus === null || $tamYil === 0 || $this->yillik_fiyat_kurus >= $tamYil) {
            return null;
        }

        return (int) round(100 - $this->yillik_fiyat_kurus / $tamYil * 100);
    }

    /**
     * "₺299" ya da "₺1.299,50": tam liralarda kuruş yazılmaz.
     */
    public static function fiyatMetni(int $kurus): string
    {
        $ondalik = $kurus % 100 === 0 ? 0 : 2;

        return '₺'.number_format($kurus / 100, $ondalik, ',', '.');
    }
}
