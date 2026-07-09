<?php

namespace App\Models;

use Database\Factories\UniversiteFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $ad
 * @property string|null $sehir
 * @property string $tur
 */
#[Fillable(['ad', 'sehir', 'tur'])]
class Universite extends Model
{
    /** @use HasFactory<UniversiteFactory> */
    use HasFactory;

    protected $table = 'universiteler';

    /**
     * @return HasMany<Yonerge, $this>
     */
    public function yonergeler(): HasMany
    {
        return $this->hasMany(Yonerge::class);
    }
}
