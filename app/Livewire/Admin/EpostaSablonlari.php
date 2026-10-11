<?php

namespace App\Livewire\Admin;

use App\Enums\EpostaTuru;
use App\Models\EpostaSablonu;
use Illuminate\Mail\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;

/**
 * Yönetim paneli — e-posta şablonları listesi ve e-posta bağlantı testi.
 *
 * @property-read Collection<string, EpostaSablonu> $kayitlar
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · E-posta Şablonları')]
class EpostaSablonlari extends Component
{
    /** Bu sürücülerde e-posta gönderilmez; test "başarılı" görünse de yanıltır. */
    public const GONDERMEYEN_SURUCULER = ['log', 'array'];

    public string $testAdresi = '';

    /**
     * Son testin sonucu; tur: success | warning | danger (Flux callout varyantı).
     *
     * @var array{tur: string, mesaj: string}|null
     */
    public ?array $testSonucu = null;

    public function mount(): void
    {
        $this->testAdresi = (string) Auth::user()?->email;
    }

    /**
     * Panelde düzenlenmiş şablonlar, türe göre.
     *
     * @return Collection<string, EpostaSablonu>
     */
    #[Computed]
    public function kayitlar(): Collection
    {
        return EpostaSablonu::query()->with('guncelleyen')->get()->keyBy(fn (EpostaSablonu $s) => $s->tur->value);
    }

    /**
     * Bağlantı testi: kuyruğa ATMADAN anında gönderir, böylece sağlayıcının
     * hatası (geçersiz anahtar, doğrulanmamış gönderen) burada görünür.
     */
    public function baglantiTesti(): void
    {
        $this->validate(['testAdresi' => ['required', 'email', 'max:255']], attributes: ['testAdresi' => 'e-posta adresi']);

        $anahtar = 'eposta-testi:'.Auth::id();

        if (RateLimiter::tooManyAttempts($anahtar, 5)) {
            $this->testSonucu = ['tur' => 'danger', 'mesaj' => 'Çok sık deneme yapıldı; '.RateLimiter::availableIn($anahtar).' saniye sonra tekrar deneyin.'];

            return;
        }

        RateLimiter::hit($anahtar, 60);

        try {
            Mail::raw(
                "Bu, Akademiyolum yönetim panelinden gönderilen bir test e-postasıdır.\n\nBu e-postayı aldıysanız e-posta gönderimi çalışıyor.\n\nGönderim zamanı: ".now()->format('d.m.Y H:i:s'),
                fn (Message $mesaj) => $mesaj->to($this->testAdresi)->subject(config('app.name').' e-posta testi'),
            );
        } catch (Throwable $hata) {
            report($hata);
            $this->testSonucu = ['tur' => 'danger', 'mesaj' => Str::limit($hata->getMessage(), 500)];

            return;
        }

        $this->testSonucu = in_array(config('mail.default'), self::GONDERMEYEN_SURUCULER, true)
            ? ['tur' => 'warning', 'mesaj' => 'Hata yok, ancak sürücü "'.config('mail.default').'" olduğu için e-posta gönderilmedi; yalnızca log dosyasına yazıldı.']
            : ['tur' => 'success', 'mesaj' => "Test e-postası {$this->testAdresi} adresine gönderildi. Gelen kutusunu (ve spam klasörünü) kontrol edin."];
    }

    public function render(): View
    {
        return view('livewire.admin.eposta-sablonlari', [
            'turler' => EpostaTuru::cases(),
            'surucu' => (string) config('mail.default'),
            'gonderen' => (string) config('mail.from.address'),
        ]);
    }
}
