<?php

namespace App\Models;

use App\Enums\EpostaTuru;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Panelden düzenlenmiş e-posta şablonu. Satırı olmayan tür koddaki
 * varsayılanla gönderilir ({@see EpostaTuru::varsayilanGovde()}).
 *
 * @property int $id
 * @property EpostaTuru $tur
 * @property string $konu
 * @property string $govde
 * @property bool $aktif
 * @property int|null $guncelleyen_id
 * @property Carbon|null $updated_at
 */
#[Fillable(['tur', 'konu', 'govde', 'aktif', 'guncelleyen_id'])]
class EpostaSablonu extends Model
{
    protected $table = 'eposta_sablonlari';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tur' => EpostaTuru::class,
            'aktif' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function guncelleyen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guncelleyen_id');
    }
}
