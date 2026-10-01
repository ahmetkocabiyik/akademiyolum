<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\TemelAlan;
use App\Services\Scoring\Sart\Profil;
use App\Services\Scoring\Sart\ProfilCozucu;
use Carbon\CarbonInterface;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string|null $unvan
 * @property string|null $universite
 * @property string|null $fakulte
 * @property string|null $bolum
 * @property string|null $birim
 * @property TemelAlan|null $temel_alan
 * @property CarbonInterface|null $lisans_tarihi
 * @property CarbonInterface|null $doktora_tarihi
 * @property CarbonInterface|null $docentlik_tarihi
 * @property CarbonInterface|null $son_atama_tarihi
 * @property string|null $program_dili
 * @property int|null $yds_puani
 * @property int|null $h_indeksi
 * @property int|null $yurtdisi_ay
 * @property string|null $orcid
 * @property string|null $avesis_id
 * @property Carbon|null $onboarded_at
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'name', 'unvan', 'universite', 'fakulte', 'bolum', 'birim', 'temel_alan', 'orcid', 'avesis_id',
    'onboarded_at', 'email', 'password',
    // Akademik profil — şart ağacının dönem ve metrik yaprakları için.
    'lisans_tarihi', 'doktora_tarihi', 'docentlik_tarihi', 'son_atama_tarihi',
    'program_dili', 'yds_puani', 'h_indeksi', 'yurtdisi_ay',
])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements PasskeyUser
{
    /**
     * Akademik unvanlar — onboarding ve profil aynı listeyi kullanır.
     *
     * @var list<string>
     */
    public const UNVANLAR = ['Arş. Gör.', 'Öğr. Gör.', 'Dr. Öğr. Üyesi', 'Doç. Dr.', 'Prof. Dr.'];

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'onboarded_at' => 'datetime',
            'temel_alan' => TemelAlan::class,
            'password' => 'hashed',
            'lisans_tarihi' => 'date',
            'doktora_tarihi' => 'date',
            'docentlik_tarihi' => 'date',
            'son_atama_tarihi' => 'date',
            'yds_puani' => 'integer',
            'h_indeksi' => 'integer',
            'yurtdisi_ay' => 'integer',
        ];
    }

    /**
     * Şart ağacı motorunun okuduğu akademik profil.
     *
     * Atıf, proje ve tez danışmanlığı sayıları burada DEĞİL, kullanıcının
     * faaliyet kayıtlarından türetilir ({@see ProfilCozucu}).
     *
     * @param  iterable<Faaliyet>|null  $faaliyetler  null ise onaylı faaliyetler çekilir
     */
    public function sartProfili(?iterable $faaliyetler = null): Profil
    {
        return (new ProfilCozucu)->coz($this, $faaliyetler);
    }

    /**
     * Akademik profilin doluluk oranı (0-100). Yalnızca kullanıcının elle
     * girdiği alanlar sayılır; faaliyetlerden türetilen ölçütler bu orana
     * girmez — onların kaynağı Faaliyetler bölümüdür.
     */
    public function profilDoluluk(): int
    {
        // Profil formunda sorulan alanlarla birebir aynı olmalı; biri eksik
        // kalırsa kullanıcı alanı doldurduğu hâlde oran %100'e ulaşmıyor.
        $alanlar = [
            'lisans_tarihi', 'doktora_tarihi', 'docentlik_tarihi', 'son_atama_tarihi',
            'program_dili', 'yds_puani', 'h_indeksi', 'yurtdisi_ay',
        ];

        $dolu = count(array_filter($alanlar, fn (string $alan) => $this->{$alan} !== null));

        return (int) round($dolu / count($alanlar) * 100);
    }

    /**
     * Determine whether the user has completed onboarding.
     */
    public function hasCompletedOnboarding(): bool
    {
        return $this->onboarded_at !== null;
    }

    /**
     * @return HasMany<Faaliyet, $this>
     */
    public function faaliyetler(): HasMany
    {
        return $this->hasMany(Faaliyet::class);
    }

    /**
     * @return HasMany<DanismanMesaj, $this>
     */
    public function danismanMesajlari(): HasMany
    {
        return $this->hasMany(DanismanMesaj::class);
    }

    /**
     * @return HasMany<DanismanSohbet, $this>
     */
    public function danismanSohbetleri(): HasMany
    {
        return $this->hasMany(DanismanSohbet::class);
    }

    /**
     * @return HasOne<CvProfili, $this>
     */
    public function cvProfili(): HasOne
    {
        return $this->hasOne(CvProfili::class);
    }

    /**
     * @return HasMany<JuriRaporu, $this>
     */
    public function juriRaporlari(): HasMany
    {
        return $this->hasMany(JuriRaporu::class);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }
}
