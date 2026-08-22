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
 * @property string|null $rol
 * @property string|null $donem
 * @property Carbon|null $tarih
 * @property string|null $kaynak
 * @property int $puan
 * @property string $durum
 * @property array<string, mixed>|null $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['kategori', 'tur', 'baslik', 'yazarlar', 'rol', 'donem', 'tarih', 'kaynak', 'puan', 'durum', 'meta'])]
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
            'tarih' => 'date',
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
     * Şart ağacındaki `haric` etiketinin bu faaliyet için değeri.
     *
     * `null` "bilinmiyor" demektir — motor o faaliyeti dışlamaz ama koşulu da
     * kesin sonuca bağlamaz (belirsiz kalır). "false" ile karıştırılmamalı.
     *
     * Tez ilişkisi `donem` kolonunda tutuluyor. Yönergeler iki ayrı şey soruyor:
     * Sabancı "doktora tezinden üretilmemiş" derken ÜAK "lisansüstü tezlerden
     * üretilmiş" diyor — yüksek lisans tezinden üretilen bir makale birincisine
     * SAYILIR, ikincisine sayılmaz. Bu yüzden düzey ayrı tutulur.
     *
     * Eski kayıtlarda düzey belirtilmemiş olabilir (`tezden`); doktoraya özgü
     * koşullarda bu "bilinmiyor"dur, doktora varsayılmaz.
     */
    public function haricDegeri(string $etiket): ?bool
    {
        if ($etiket === 'doktora_tezinden') {
            return match ($this->donem) {
                'doktora' => true,
                'yuksek_lisans', 'tez_disi' => false,
                default => null,   // 'tezden' (düzey bilinmiyor) ve boş
            };
        }

        if (in_array($etiket, ['lisansustu_tezden', 'tezden_uretilmis'], true)) {
            return match ($this->donem) {
                'doktora', 'yuksek_lisans', 'tezden' => true,
                'tez_disi' => false,
                default => null,
            };
        }

        $deger = $this->meta[$etiket] ?? null;

        return $deger === null ? null : (bool) $deger;
    }

    /**
     * Tez ilişkisi seçenekleri. `tezden` listelenmez: düzeyi belirsiz olduğu
     * için yeni kayıtlarda kullanılmaz, yalnızca eski kayıtlarda görünür.
     *
     * @return array<string, string>
     */
    public static function tezIliskileri(): array
    {
        return [
            'tez_disi' => 'Tezden bağımsız',
            'yuksek_lisans' => 'Yüksek lisans tezinden üretilmiş',
            'doktora' => 'Doktora tezinden üretilmiş',
        ];
    }

    /**
     * @param  Builder<Faaliyet>  $query
     */
    public function scopeOnaylanmis(Builder $query): void
    {
        $query->where('durum', 'onaylandi');
    }
}
