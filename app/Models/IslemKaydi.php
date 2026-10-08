<?php

namespace App\Models;

use App\Enums\YoneticiIslemi;
use Database\Factories\IslemKaydiFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Yönetici işlem kaydı. Yalnızca {@see self::yaz()} ile oluşturulur ve
 * sonradan değiştirilmez: kayıt, yöneticinin ne yaptığının kanıtı.
 *
 * @property int $id
 * @property int|null $yonetici_id
 * @property string|null $yonetici_eposta
 * @property int|null $hedef_user_id
 * @property string|null $hedef_eposta
 * @property YoneticiIslemi $islem
 * @property array<string, mixed>|null $detay
 * @property string|null $ip
 * @property Carbon $created_at
 */
class IslemKaydi extends Model
{
    /** @use HasFactory<IslemKaydiFactory> */
    use HasFactory;

    protected $table = 'yonetici_islemleri';

    public const UPDATED_AT = null;

    /** Toplu atamaya kapalı: kayıt yalnızca yaz() ile, alanlar tek tek. */
    protected $guarded = ['*'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'islem' => YoneticiIslemi::class,
            'detay' => 'array',
            'created_at' => 'datetime',
        ];
    }

    /**
     * İşlemi kaydeder. E-postalar anlık görüntü olarak da yazılıyor: kullanıcı
     * silinince yabancı anahtar null'a düşer, kayıt kimi kastettiğini yine söyler.
     *
     * @param  array<string, mixed>  $detay
     */
    public static function yaz(YoneticiIslemi $islem, ?User $yonetici, ?User $hedef = null, array $detay = []): self
    {
        $kayit = new self;
        $kayit->yonetici_id = $yonetici?->id;
        $kayit->yonetici_eposta = $yonetici?->email;
        $kayit->hedef_user_id = $hedef?->id;
        $kayit->hedef_eposta = $hedef?->email;
        $kayit->islem = $islem;
        $kayit->detay = $detay === [] ? null : $detay;
        $kayit->ip = app()->runningInConsole() ? null : request()->ip();
        $kayit->save();

        return $kayit;
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function yonetici(): BelongsTo
    {
        return $this->belongsTo(User::class, 'yonetici_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function hedef(): BelongsTo
    {
        return $this->belongsTo(User::class, 'hedef_user_id');
    }
}
