<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Geçici olarak yayından kaldırılmış bir üniversite yönergesi.
 *
 * @property int $id
 * @property string $universite
 * @property string $neden
 * @property int|null $gizleyen_id
 * @property Carbon|null $created_at
 */
#[Fillable(['universite', 'neden', 'gizleyen_id'])]
class GizliYonerge extends Model
{
    protected $table = 'gizli_yonergeler';

    /**
     * @return BelongsTo<User, $this>
     */
    public function gizleyen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gizleyen_id');
    }
}
