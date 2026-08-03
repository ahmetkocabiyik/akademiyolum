<?php

namespace App\Models;

use Database\Factories\DanismanMesajFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $danisman_sohbet_id
 * @property string $rol
 * @property string $icerik
 */
#[Fillable(['user_id', 'rol', 'icerik', 'danisman_sohbet_id'])]
class DanismanMesaj extends Model
{
    /** @use HasFactory<DanismanMesajFactory> */
    use HasFactory;

    protected $table = 'danisman_mesajlari';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<DanismanSohbet, $this>
     */
    public function sohbet(): BelongsTo
    {
        return $this->belongsTo(DanismanSohbet::class, 'danisman_sohbet_id');
    }
}
