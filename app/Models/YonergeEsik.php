<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $yonerge_id
 * @property string $kadro
 * @property string $alan
 * @property int $min_toplam
 * @property int|null $yayin_min
 * @property int|null $index_min
 * @property int|null $yds_min
 * @property string|null $notlar
 * @property array<int, array<string, mixed>>|null $kosullar
 * @property string $kaynak
 */
#[Fillable(['kadro', 'alan', 'min_toplam', 'yayin_min', 'index_min', 'yds_min', 'notlar', 'kosullar', 'kaynak'])]
class YonergeEsik extends Model
{
    protected $table = 'yonerge_esikleri';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'min_toplam' => 'integer',
            'yayin_min' => 'integer',
            'index_min' => 'integer',
            'yds_min' => 'integer',
            'kosullar' => 'array',
        ];
    }

    /**
     * @return BelongsTo<Yonerge, $this>
     */
    public function yonerge(): BelongsTo
    {
        return $this->belongsTo(Yonerge::class);
    }

    public function dogrulandi(): bool
    {
        return $this->kaynak === 'pdf';
    }
}
