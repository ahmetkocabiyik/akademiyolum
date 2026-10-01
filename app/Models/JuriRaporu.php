<?php

namespace App\Models;

use App\Enums\JuriAdimi;
use App\Enums\JuriAgirligi;
use App\Enums\JuriKarari;
use App\Enums\JuriSapkasi;
use App\Enums\JuriSertligi;
use App\Enums\Kadro;
use Database\Factories\JuriRaporuFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $universite
 * @property string $hedef_kadro
 * @property string|null $birim
 * @property string $alan
 * @property JuriSapkasi $sapka
 * @property JuriSertligi $sertlik
 * @property JuriKarari $karar
 * @property list<array{etiket: string, mevcut: int, gerekli: int, oran: int}> $olcumler
 * @property array<string, mixed> $adimlar Ham JSON: eski satırlar ya da bozuk
 *                                         bir yanıt beklenen şekli taşımayabilir, okuyan taraf doğrular.
 * @property string $ozet
 * @property Carbon|null $created_at
 */
#[Fillable([
    'universite', 'hedef_kadro', 'birim', 'alan',
    'sapka', 'sertlik', 'karar', 'olcumler', 'adimlar', 'ozet',
])]
class JuriRaporu extends Model
{
    /** @use HasFactory<JuriRaporuFactory> */
    use HasFactory;

    protected $table = 'juri_raporlari';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sapka' => JuriSapkasi::class,
            'sertlik' => JuriSertligi::class,
            'karar' => JuriKarari::class,
            'olcumler' => 'array',
            'adimlar' => 'array',
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
     * Raporun on adımı, SABİT sırada ve ekranın beklediği şekilde.
     *
     * Sıra JSON'daki anahtar sırasından okunmuyor: YZ adımları başka sırada
     * döndürse rapor karışırdı. Eksik adım atlanır — yarım rapor hiç rapordan
     * iyidir, ama boş kutu çizilmez.
     *
     * @return list<array{adim: JuriAdimi, agirlik: JuriAgirligi, icerik: string}>
     */
    public function adimSatirlari(): array
    {
        $satirlar = [];

        foreach (JuriAdimi::cases() as $adim) {
            $kayit = $this->adimlar[$adim->value] ?? null;

            if (! is_array($kayit) || blank($kayit['icerik'] ?? null)) {
                continue;
            }

            $satirlar[] = [
                'adim' => $adim,
                'agirlik' => JuriAgirligi::tryFrom((string) ($kayit['agirlik'] ?? '')) ?? JuriAgirligi::Notr,
                'icerik' => (string) $kayit['icerik'],
            ];
        }

        return $satirlar;
    }

    public function kadroEtiketi(): string
    {
        return Kadro::etiketi($this->hedef_kadro);
    }

    /**
     * Listede gösterilecek tek satırlık başlık.
     */
    public function baslikMetni(): string
    {
        return $this->universite.' · '.$this->sapka->etiket();
    }
}
