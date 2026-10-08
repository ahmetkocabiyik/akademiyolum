<?php

namespace App\Models;

use App\Enums\Plan;
use Carbon\CarbonImmutable;
use Database\Factories\AbonelikFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Bir kullanıcının bir abonelik dönemi.
 *
 * Aktiflik SAKLANMIYOR, tarihten türetiliyor ({@see self::scopeAktif()}):
 * "durum" sütunu tutulsaydı süresi dolan aboneliği pasife çekecek bir
 * zamanlanmış iş gerekir, iş aksarsa bitmiş abonelik aktif görünürdü.
 *
 * @property int $id
 * @property int $user_id
 * @property Plan $plan
 * @property CarbonImmutable $baslangic
 * @property CarbonImmutable|null $bitis Boş: süresiz.
 * @property string $kaynak `elle` ya da (ileride) `odeme`.
 * @property int|null $tutar_kurus
 * @property string|null $not
 * @property int|null $olusturan_id
 * @property Carbon|null $iptal_edildi_at
 * @property Carbon|null $created_at
 */
#[Fillable(['plan', 'baslangic', 'bitis', 'kaynak', 'tutar_kurus', 'not', 'olusturan_id'])]
class Abonelik extends Model
{
    /** @use HasFactory<AbonelikFactory> */
    use HasFactory;

    protected $table = 'abonelikler';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'plan' => Plan::class,
            'baslangic' => 'immutable_date',
            'bitis' => 'immutable_date',
            'iptal_edildi_at' => 'datetime',
            'tutar_kurus' => 'integer',
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
     * @return BelongsTo<User, $this>
     */
    public function olusturan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'olusturan_id');
    }

    /**
     * Bugün geçerli olanlar: başlamış, bitmemiş (bitiş günü dahil), iptal edilmemiş.
     *
     * @param  Builder<Abonelik>  $query
     */
    public function scopeAktif(Builder $query): void
    {
        self::aktifKosulu($query);
    }

    /**
     * Aktiflik koşulunun tek kaynağı. Statik çünkü whereHas kapanışlarında
     * da kullanılıyor; orada sorgunun modeli statik analize görünmüyor.
     *
     * @template TModel of Model
     *
     * @param  Builder<TModel>  $query
     */
    public static function aktifKosulu(Builder $query): void
    {
        $bugun = CarbonImmutable::today()->toDateString();

        $query->whereNull('iptal_edildi_at')
            ->whereDate('baslangic', '<=', $bugun)
            ->where(fn (Builder $q) => $q->whereNull('bitis')->orWhereDate('bitis', '>=', $bugun));
    }

    public function aktifMi(): bool
    {
        $bugun = CarbonImmutable::today();

        return $this->iptal_edildi_at === null
            && $this->baslangic->lessThanOrEqualTo($bugun)
            && ($this->bitis === null || $this->bitis->greaterThanOrEqualTo($bugun));
    }

    /**
     * Ekrandaki durum: `aktif`, `baslamadi`, `bitti`, `iptal`.
     */
    public function durum(): string
    {
        $bugun = CarbonImmutable::today();

        return match (true) {
            $this->iptal_edildi_at !== null => 'iptal',
            $this->baslangic->greaterThan($bugun) => 'baslamadi',
            $this->bitis !== null && $this->bitis->lessThan($bugun) => 'bitti',
            default => 'aktif',
        };
    }

    /** Bitişe kalan gün; süresizse ya da bitmişse null. */
    public function kalanGun(): ?int
    {
        if ($this->bitis === null || $this->durum() !== 'aktif') {
            return null;
        }

        return (int) CarbonImmutable::today()->diffInDays($this->bitis);
    }

    /** "1.299,00 ₺" — Türkçe para biçimi. */
    public function tutarMetni(): ?string
    {
        return $this->tutar_kurus === null
            ? null
            : number_format($this->tutar_kurus / 100, 2, ',', '.').' ₺';
    }
}
