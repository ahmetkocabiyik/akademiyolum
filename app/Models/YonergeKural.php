<?php

namespace App\Models;

use App\Enums\Kategori;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $yonerge_id
 * @property Kategori $kategori
 * @property int $tavan
 * @property int $varsayilan_puan
 * @property array<string, int>|null $puanlar
 */
#[Fillable(['kategori', 'tavan', 'varsayilan_puan', 'puanlar'])]
class YonergeKural extends Model
{
    protected $table = 'yonerge_kurallari';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kategori' => Kategori::class,
            'tavan' => 'integer',
            'varsayilan_puan' => 'integer',
            'puanlar' => 'array',
        ];
    }

    /**
     * @return BelongsTo<Yonerge, $this>
     */
    public function yonerge(): BelongsTo
    {
        return $this->belongsTo(Yonerge::class);
    }
}
