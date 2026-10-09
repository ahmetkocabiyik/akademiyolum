<?php

namespace App\Models;

use App\Enums\Plan;
use Database\Factories\AbonelikTalebiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Kullanıcının ücretli paket talebi. Yönetici ödemeyi aldığında talebi
 * aboneliğe çevirir (`tamamlandi`) ya da kapatır (`kapatildi`).
 *
 * @property int $id
 * @property int $user_id
 * @property Plan $plan
 * @property string $donem `aylik` ya da `yillik`.
 * @property string $durum `bekliyor`, `tamamlandi` ya da `kapatildi`.
 * @property int|null $abonelik_id
 * @property int|null $sonuclandiran_id
 * @property Carbon|null $sonuclandi_at
 * @property Carbon|null $created_at
 */
#[Fillable(['plan', 'donem', 'durum', 'abonelik_id', 'sonuclandiran_id', 'sonuclandi_at'])]
class AbonelikTalebi extends Model
{
    /** @use HasFactory<AbonelikTalebiFactory> */
    use HasFactory;

    public const DONEMLER = ['aylik' => 'Aylık', 'yillik' => 'Yıllık'];

    public const BEKLIYOR = 'bekliyor';

    public const TAMAMLANDI = 'tamamlandi';

    public const KAPATILDI = 'kapatildi';

    protected $table = 'abonelik_talepleri';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'plan' => Plan::class,
            'sonuclandi_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param  Builder<AbonelikTalebi>  $query
     */
    public function scopeBekleyen(Builder $query): void
    {
        $query->where('durum', self::BEKLIYOR);
    }

    /** Talep edilen dönemin ay cinsinden uzunluğu. */
    public function ay(): int
    {
        return $this->donem === 'yillik' ? 12 : 1;
    }

    public function donemEtiketi(): string
    {
        return self::DONEMLER[$this->donem] ?? $this->donem;
    }
}
