<?php

namespace App\Models;

use Database\Factories\YonergeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $universite_id
 * @property string $anahtar
 * @property string $ad
 * @property string $kadro
 * @property int $yil
 * @property int $uak_hedef
 * @property int $universite_hedef
 * @property-read Universite|null $universite
 * @property-read Collection<int, YonergeKural> $kurallar
 */
#[Fillable(['universite_id', 'anahtar', 'ad', 'kadro', 'yil', 'uak_hedef', 'universite_hedef'])]
class Yonerge extends Model
{
    /** @use HasFactory<YonergeFactory> */
    use HasFactory;

    protected $table = 'yonergeler';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'yil' => 'integer',
            'uak_hedef' => 'integer',
            'universite_hedef' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Universite, $this>
     */
    public function universite(): BelongsTo
    {
        return $this->belongsTo(Universite::class);
    }

    /**
     * @return HasMany<YonergeKural, $this>
     */
    public function kurallar(): HasMany
    {
        return $this->hasMany(YonergeKural::class);
    }
}
