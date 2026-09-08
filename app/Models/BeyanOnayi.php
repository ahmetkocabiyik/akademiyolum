<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Adayın bir yönerge koşulu için "belgem var" beyanı.
 *
 * Motor bu koşulu göremez (belge bizde değil), o yüzden normalde BELİRSİZ
 * döner ve tek bir beyan satırı bütün üniversiteyi "Eksik Bilgi"de tutar.
 * İşaret, koşulu sağlanmış saydırır — beyan zaten adayın kendi belgesi
 * hakkındaki ifadesidir.
 *
 * @property int $id
 * @property int $user_id
 * @property string $esik_anahtari
 * @property string $kosul_anahtari
 */
#[Fillable(['user_id', 'esik_anahtari', 'kosul_anahtari'])]
class BeyanOnayi extends Model
{
    protected $table = 'beyan_onaylari';

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
