<?php

namespace App\Models;

use Database\Factories\DanismanSohbetFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $baslik
 */
#[Fillable(['baslik'])]
class DanismanSohbet extends Model
{
    /** @use HasFactory<DanismanSohbetFactory> */
    use HasFactory;

    protected $table = 'danisman_sohbetleri';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<DanismanMesaj, $this>
     */
    public function mesajlar(): HasMany
    {
        return $this->hasMany(DanismanMesaj::class);
    }

    /**
     * Listede gösterilecek başlık; boşsa varsayılan metin döner.
     */
    public function baslikMetni(): string
    {
        return $this->baslik ?: 'Yeni sohbet';
    }
}
