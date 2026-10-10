<?php

namespace App\Models;

use App\Enums\YzOzelligi;
use App\Enums\YzSaglayiciTuru;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Bir YZ özelliğinin panelden seçilen sağlayıcı ve modeli.
 *
 * @property int $id
 * @property YzOzelligi $ozellik
 * @property YzSaglayiciTuru $saglayici
 * @property string|null $model
 * @property int|null $guncelleyen_id
 * @property Carbon|null $updated_at
 */
#[Fillable(['ozellik', 'saglayici', 'model', 'guncelleyen_id'])]
class YzAyari extends Model
{
    protected $table = 'yz_ayarlari';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ozellik' => YzOzelligi::class,
            'saglayici' => YzSaglayiciTuru::class,
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
