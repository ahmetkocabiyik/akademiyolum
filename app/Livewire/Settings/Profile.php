<?php

namespace App\Livewire\Settings;

use App\Concerns\ProfileValidationRules;
use App\Enums\TemelAlan;
use App\Models\Universite;
use App\Models\User;
use App\Services\Scoring\Sart\ProfilCozucu;
use App\Services\Scoring\Sart\SartDeposu;
use Carbon\CarbonInterface;
use Flux\Flux;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Profil ayarları')]
class Profile extends Component
{
    use ProfileValidationRules;

    public string $name = '';

    public string $email = '';

    /**
     * Akademik unvan. Yalnızca gösterim değil: Yönerge Analizi varsayılan hedef
     * kadroyu buradan türetiyor, o yüzden terfi edildiğinde güncellenebilmeli.
     */
    public string $unvan = '';

    public string $universite = '';

    public string $fakulte = '';

    public string $bolum = '';

    /**
     * Program/birim. Bazı yönergeler kriterleri temel alana değil PROGRAMA göre
     * yazıyor; aynı alanda birden çok eşik varsa doğrusu ancak bununla seçilir.
     * Seçenekler yönerge verisinden gelir, genel bölüm listesinden değil.
     */
    public string $birim = '';

    public string $temelAlan = 'sosyal';

    /**
     * Akademik profil: şart ağacının `donem` ve `metrik` yapraklarının okuduğu
     * değerler. Boş bırakılan bir alan yönerge analizinde ilgili koşulu
     * "sağlanmadı" değil "belirsiz" yapar.
     *
     * @var array<string, string>
     */
    public array $akademik = [];

    /**
     * Alan tanımları: kolon => [etiket, tip, ipucu].
     *
     * Atıf, proje ve tez danışmanlığı BURADA YOK: onlar Faaliyetler bölümündeki
     * faaliyet kayıtlarından sayılır ({@see ProfilCozucu}).
     *
     * @return array<string, array{0: string, 1: string, 2: string}>
     */
    public static function akademikAlanlar(): array
    {
        return [
            'lisans_tarihi' => ['Lisans mezuniyeti', 'date', 'Güzel Sanatlar\'da bazı yönergeler lisans sonrasını sayar'],
            'doktora_tarihi' => ['Doktora / sanatta yeterlik', 'date', '"Doktora sonrası" koşulları bu tarihe göre hesaplanır'],
            'docentlik_tarihi' => ['Doçentlik unvanı', 'date', '"Doçentlik sonrası" koşulları bu tarihe göre hesaplanır'],
            'son_atama_tarihi' => ['Son atama', 'date', 'Yeniden atanma koşulları bu tarihten sonrasını sayar'],
            'yds_puani' => ['Yabancı dil sınavı puanı', 'number', 'YDS / YÖKDİL / eşdeğeri'],
            'h_indeksi' => ['WoS h-indeksi', 'number', 'Yönergelerin %35\'i arıyor'],
            'yurtdisi_ay' => ['Yurt dışı araştırma (ay)', 'number', ''],
        ];
    }

    /**
     * Kullanıcının üniversitesinde program bazlı eşik varsa program adları.
     * Boşsa yönerge programdan bağımsızdır ve alan gösterilmez.
     *
     * @return list<string>
     */
    public function birimSecenekleri(): array
    {
        return $this->universite === ''
            ? []
            : app(SartDeposu::class)->birimler($this->universite);
    }

    /**
     * Akademik unvanlar — onboarding ile aynı liste.
     *
     * @return list<string>
     */
    public static function unvanlar(): array
    {
        return User::UNVANLAR;
    }

    /**
     * Birimin öğretim dili — yabancı dil barajı buna göre kademelenir.
     *
     * @return array<string, string>
     */
    public static function programDilleri(): array
    {
        return [
            'turkce' => 'Türkçe',
            'yabanci_dil_30' => '%30 yabancı dilde',
            'yabanci_dil_100' => '%100 yabancı dilde',
            'yabanci_dil_egitimi' => 'Yabancı dil eğitimi veren birim',
        ];
    }

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->unvan = $user->unvan ?? '';
        $this->universite = $user->universite ?? '';
        $this->fakulte = $user->fakulte ?? '';
        $this->bolum = $user->bolum ?? '';
        $this->birim = $user->birim ?? '';
        $this->temelAlan = $user->temel_alan?->value ?? 'sosyal';

        $this->akademik = ['program_dili' => $user->program_dili ?? ''];

        foreach (array_keys(self::akademikAlanlar()) as $alan) {
            $deger = $user->{$alan};
            // CarbonInterface: uygulama Date::use(CarbonImmutable) ile çalışıyor,
            // dolayısıyla cast'ten dönen değer Illuminate\Support\Carbon DEĞİL.
            // Somut sınıfa bakmak tarihi "2016-06-20 00:00:00" olarak stringe
            // çeviriyor ve input[type=date] onu reddedip boş görünüyordu.
            $this->akademik[$alan] = match (true) {
                $deger === null => '',
                $deger instanceof CarbonInterface => $deger->toDateString(),
                default => (string) $deger,
            };
        }
    }

    public function updatedTemelAlan(): void
    {
        $this->kaskadiSagla();
    }

    public function updatedFakulte(): void
    {
        $this->kaskadiSagla();
    }

    /**
     * Kaskad tutarlılık: temel alan → fakülte → bölüm.
     * Bir üst seçim değişince alt seçim listede yoksa sıfırlanır.
     */
    private function kaskadiSagla(): void
    {
        $fakulteler = TemelAlan::tryFrom($this->temelAlan)?->fakulteler() ?? [];
        if (! in_array($this->fakulte, $fakulteler, true)) {
            $this->fakulte = '';
        }

        $bolumler = $this->bolumHaritasi()[$this->fakulte] ?? [];
        if (! in_array($this->bolum, $bolumler, true)) {
            $this->bolum = '';
        }
    }

    /**
     * @return array<string, list<string>>
     */
    private function bolumHaritasi(): array
    {
        return require database_path('data/bolumler.php');
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $akademikKurallar = ['akademik.program_dili' => ['nullable', Rule::in(array_keys(self::programDilleri()))]];

        foreach (self::akademikAlanlar() as $alan => [, $tip]) {
            $akademikKurallar["akademik.{$alan}"] = $tip === 'date'
                ? ['nullable', 'date', 'before_or_equal:today']
                : ['nullable', 'integer', 'min:0', 'max:9999'];
        }

        $this->validate($this->profileRules($user->id) + [
            'universite' => ['nullable', 'string', 'max:255'],
            'fakulte' => ['nullable', 'string', 'max:255'],
            'bolum' => ['nullable', 'string', 'max:255'],
            'temelAlan' => ['required', Rule::enum(TemelAlan::class)],
            'unvan' => ['nullable', Rule::in(User::UNVANLAR)],
            'birim' => ['nullable', Rule::in($this->birimSecenekleri())],
        ] + $akademikKurallar);

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'unvan' => $this->unvan ?: null,
            'birim' => $this->birim ?: null,
            'universite' => $this->universite ?: null,
            'fakulte' => $this->fakulte ?: null,
            'bolum' => $this->bolum ?: null,
            'temel_alan' => $this->temelAlan,
            'program_dili' => ($this->akademik['program_dili'] ?? '') ?: null,
        ]);

        // Boş bırakılan alan null kalır: "0" ile "girilmemiş" farklı anlamlar
        // taşıyor (0 kesin olumsuz, null belirsiz).
        foreach (array_keys(self::akademikAlanlar()) as $alan) {
            $user->{$alan} = ($this->akademik[$alan] ?? '') === '' ? null : $this->akademik[$alan];
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: __('A new verification link has been sent to your email address.'));
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        $user = Auth::user();

        return $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        $user = Auth::user();

        return ! $user instanceof MustVerifyEmail || $user->hasVerifiedEmail();
    }

    public function render()
    {
        return view('livewire.settings.profile', [
            'universiteler' => Universite::query()->orderBy('ad')->pluck('ad'),
            'temelAlanlar' => TemelAlan::secenekler(),
            'bolumler' => $this->bolumHaritasi(),
            'akademikAlanlar' => self::akademikAlanlar(),
            'programDilleri' => self::programDilleri(),
            'unvanlar' => self::unvanlar(),
            'birimler' => $this->birimSecenekleri(),
        ]);
    }
}
