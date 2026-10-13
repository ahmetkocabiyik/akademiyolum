<?php

namespace App\Models;

use Database\Factories\UniversiteBirimiFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bir üniversitenin fakülte/yüksekokulunda açılan program (YÖK Atlas).
 *
 * @property int $id
 * @property int $universite_id
 * @property string $fakulte
 * @property string $bolum
 */
#[Fillable(['universite_id', 'fakulte', 'bolum'])]
class UniversiteBirimi extends Model
{
    /** @use HasFactory<UniversiteBirimiFactory> */
    use HasFactory;

    protected $table = 'universite_birimleri';

    public $timestamps = false;

    /**
     * @return BelongsTo<Universite, $this>
     */
    public function universite(): BelongsTo
    {
        return $this->belongsTo(Universite::class);
    }
}
