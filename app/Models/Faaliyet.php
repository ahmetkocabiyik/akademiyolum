<?php

namespace App\Models;

use App\Enums\Kategori;
use Database\Factories\FaaliyetFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property Kategori $kategori
 * @property string $tur
 * @property string $baslik
 * @property string|null $yazarlar
 * @property string|null $donem
 * @property string|null $kaynak
 * @property int $puan
 * @property string $durum
 * @property array<string, mixed>|null $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['kategori', 'tur', 'baslik', 'yazarlar', 'donem', 'kaynak', 'puan', 'durum', 'meta'])]
class Faaliyet extends Model
{
    /** @use HasFactory<FaaliyetFactory> */
    use HasFactory;

    protected $table = 'faaliyetler';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kategori' => Kategori::class,
            'puan' => 'integer',
            'meta' => 'array',
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
     * @param  Builder<Faaliyet>  $query
     */
    public function scopeOnaylanmis(Builder $query): void
    {
        $query->where('durum', 'onaylandi');
    }
}
