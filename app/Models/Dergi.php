<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * DergiPark'taki bir derginin dizin listesi (yerel kopya).
 *
 * @property int $id
 * @property string $slug
 * @property string|null $ad
 * @property list<string>|null $atif_dizinleri
 * @property list<string>|null $diger_dizinler
 * @property Carbon|null $kontrol_edildi_at
 */
class Dergi extends Model
{
    protected $table = 'dergiler';

    protected $fillable = ['slug', 'ad', 'atif_dizinleri', 'diger_dizinler', 'kontrol_edildi_at'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'atif_dizinleri' => 'array',
            'diger_dizinler' => 'array',
            'kontrol_edildi_at' => 'datetime',
        ];
    }
}
