<?php

namespace App\Models;

use App\Enums\CvBolumu;
use App\Enums\CvSablonu;
use App\Enums\CvYaziTipi;
use Database\Factories\CvProfiliFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $ad
 * @property string|null $unvan
 * @property string|null $kurum
 * @property string|null $bolum
 * @property string|null $eposta
 * @property string|null $telefon
 * @property string|null $sehir
 * @property string|null $web
 * @property string|null $ozet
 * @property string|null $foto
 * @property array<int, mixed> $egitimler
 * @property array<int, mixed> $deneyimler
 * @property array<int, mixed> $beceriler
 * @property array<int, mixed> $diller
 * @property array<int, mixed> $haric_faaliyetler
 * @property CvSablonu $sablon
 * @property string $renk
 * @property string|null $cizgi_renk
 * @property CvYaziTipi $yazi_tipi
 * @property array<string, mixed> $bolumler
 */
#[Fillable([
    'ad', 'unvan', 'kurum', 'bolum', 'eposta', 'telefon', 'sehir', 'web', 'ozet', 'foto',
    'egitimler', 'deneyimler', 'beceriler', 'diller', 'haric_faaliyetler',
    'sablon', 'renk', 'cizgi_renk', 'yazi_tipi', 'bolumler',
])]
class CvProfili extends Model
{
    /** @use HasFactory<CvProfiliFactory> */
    use HasFactory;

    protected $table = 'cv_profilleri';

    /**
     * Seçilebilir renkler. Serbest hex kabul edilmiyor: CV'nin okunabilirliği
     * (beyaz üstüne kontrast) bu sekiz tonda sınandı, kullanıcıdan gelen bir
     * değer doğrudan `style`a yazılacağı için de kapalı liste gerekiyor.
     *
     * @var list<string>
     */
    public const RENKLER = [
        '#0a1628', // navy
        '#1a56db', // brand
        '#c9a84c', // gold
        '#16a34a', // green
        '#534ab7', // purple
        '#0f6e56', // teal
        '#dc2626', // red
        '#374151', // gri
    ];

    /**
     * Çizgi renkleri: ana paletin üstüne iki açık gri. İnce çizgide koyu
     * tonlar ağır kaçabiliyor, aday sayfayı sakinleştirmek isteyebilir.
     * Serbest hex yine kabul edilmiyor; değer `style`a yazılıyor.
     *
     * @var list<string>
     */
    public const CIZGI_RENKLERI = [...self::RENKLER, '#9ca3af', '#e5e7eb'];

    /**
     * Seçim yapılmamışsa (sütun boş) çizgiler bu griyle basılıyor: ana rengi
     * izleyen çizgi koyu paletlerde sayfayı ağırlaştırıyordu.
     */
    public const VARSAYILAN_CIZGI_RENGI = '#9ca3af';

    /** Dil seviyesi etiketleri (1-5). */
    public const DIL_SEVIYELERI = [
        1 => 'Başlangıç',
        2 => 'Temel',
        3 => 'Orta',
        4 => 'İleri',
        5 => 'Anadil / Çok iyi',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'egitimler' => 'array',
            'deneyimler' => 'array',
            'beceriler' => 'array',
            'diller' => 'array',
            'haric_faaliyetler' => 'array',
            'bolumler' => 'array',
            'sablon' => CvSablonu::class,
            'yazi_tipi' => CvYaziTipi::class,
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
     * Kullanıcının CV'si; yoksa akademik profilinden DOLDURULARAK oluşturulur.
     *
     * Boş bir forma düşen aday CV'yi baştan yazmak zorunda kalıyordu; oysa ad,
     * kurum, bölüm, e-posta ve ORCID zaten sistemde. Doldurma yalnızca İLK
     * oluşturmada olur — sonra alanlar CV'nin kendi malı.
     */
    public static function kullaniciIcin(User $user): self
    {
        $profil = static::query()->firstWhere('user_id', $user->id);

        if ($profil !== null) {
            return $profil;
        }

        return $user->cvProfili()->create([
            'ad' => $user->name,
            'unvan' => $user->unvan,
            'kurum' => $user->universite,
            'bolum' => collect([$user->fakulte, $user->bolum])->filter()->implode(' — ') ?: null,
            'eposta' => $user->email,
            'web' => $user->orcid,
            'egitimler' => self::egitimTaslagi($user),
            'deneyimler' => [],
            'beceriler' => [],
            'diller' => [],
            'haric_faaliyetler' => [],
            'sablon' => CvSablonu::Minimal,
            'renk' => self::RENKLER[0],
            'yazi_tipi' => CvYaziTipi::Sans,
            'bolumler' => CvBolumu::varsayilan(),
        ]);
    }

    /**
     * Profildeki mezuniyet tarihlerinden eğitim satırları.
     *
     * Yalnızca TARİH biliniyor; üniversite ve bölüm adını aday dolduracak. Yine
     * de satırı açıyoruz: boş listede aday eğitim bölümünün varlığını fark
     * etmiyordu.
     *
     * @return list<array<string, string|null>>
     */
    private static function egitimTaslagi(User $user): array
    {
        $satirlar = [];

        foreach ([
            ['Doktora', $user->doktora_tarihi],
            ['Lisans', $user->lisans_tarihi],
        ] as [$derece, $tarih]) {
            if ($tarih === null) {
                continue;
            }

            $satirlar[] = [
                'derece' => $derece,
                'universite' => null,
                'bolum' => null,
                'baslangic' => null,
                'bitis' => (string) $tarih->year,
            ];
        }

        return $satirlar;
    }

    public function bolumAcik(CvBolumu $bolum): bool
    {
        return (bool) ($this->bolumler[$bolum->value] ?? true);
    }
}
