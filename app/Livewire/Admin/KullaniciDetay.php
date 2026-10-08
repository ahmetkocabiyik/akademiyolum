<?php

namespace App\Livewire\Admin;

use App\Enums\Plan;
use App\Models\Abonelik;
use App\Models\IslemKaydi;
use App\Models\User;
use App\Services\Abonelik\PaketKatalogu;
use App\Services\Yonetim\KullaniciYonetimi;
use Carbon\CarbonImmutable;
use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use InvalidArgumentException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Yönetim paneli — tek kullanıcı: profil, abonelik geçmişi ve işlemler.
 *
 * İş kuralları {@see KullaniciYonetimi}'nde; bileşen yalnızca formu
 * doğrulayıp servisi çağırıyor.
 *
 * @property-read Collection<int, Abonelik> $abonelikler
 * @property-read Collection<int, IslemKaydi> $islemler
 * @property-read array<string, int> $sayilar
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · Kullanıcı')]
class KullaniciDetay extends Component
{
    /** Süre seçenekleri: ay sayısı ya da süresiz / özel bitiş. */
    public const SURELER = [
        '1' => '1 ay',
        '3' => '3 ay',
        '6' => '6 ay',
        '12' => '1 yıl',
        'suresiz' => 'Süresiz',
        'ozel' => 'Özel bitiş tarihi',
    ];

    public User $user;

    public string $plan = 'akademisyen';

    public string $baslangic = '';

    public string $sure = '1';

    public string $bitis = '';

    /** TL; boşsa tutar yazılmaz (ör. ücretsiz deneme). */
    public string $tutar = '';

    public string $not = '';

    public string $askiNedeni = '';

    /** Silme onayı: yanlış kullanıcıyı silmemek için e-postası yazdırılıyor. */
    public string $silmeOnayi = '';

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->baslangic = app(KullaniciYonetimi::class)->siradakiBaslangic($user)->toDateString();
        $this->tutar = $this->tlMetni(app(PaketKatalogu::class)->onerilenTutar(Plan::Akademisyen, 1));
    }

    /**
     * Plan ya da süre değişince tutar paket fiyatına göre önerilir (12 ayda
     * yıllık fiyat); admin isterse değiştirir (indirim, kurum fiyatı).
     */
    public function updated(string $alan): void
    {
        if (in_array($alan, ['plan', 'sure'], true)) {
            $plan = Plan::tryFrom($this->plan);
            $ay = ctype_digit($this->sure) ? (int) $this->sure : null;

            if ($plan !== null && $ay !== null) {
                $this->tutar = $this->tlMetni(app(PaketKatalogu::class)->onerilenTutar($plan, $ay));
            }
        }
    }

    /** Kuruşu sayı kutusunun beklediği metne çevirir: 29900 → "299", 29950 → "299.50". */
    private function tlMetni(int $kurus): string
    {
        return $kurus % 100 === 0 ? (string) intdiv($kurus, 100) : number_format($kurus / 100, 2, '.', '');
    }

    /**
     * @return Collection<int, Abonelik>
     */
    #[Computed]
    public function abonelikler(): Collection
    {
        return $this->user->abonelikler()->with('olusturan')->latest('baslangic')->latest('id')->get();
    }

    /**
     * @return Collection<int, IslemKaydi>
     */
    #[Computed]
    public function islemler(): Collection
    {
        return IslemKaydi::query()->where('hedef_user_id', $this->user->id)->latest('id')->limit(15)->get();
    }

    /**
     * @return array<string, int>
     */
    #[Computed]
    public function sayilar(): array
    {
        return [
            'Onaylı faaliyet' => $this->user->faaliyetler()->onaylanmis()->count(),
            'Bekleyen faaliyet' => $this->user->faaliyetler()->where('durum', 'beklemede')->count(),
            'Jüri raporu' => $this->user->juriRaporlari()->count(),
            'Danışman sohbeti' => $this->user->danismanSohbetleri()->count(),
        ];
    }

    /** Kendisi ve diğer süper adminler panelden değiştirilemez. */
    public function korumali(): bool
    {
        return $this->user->is(Auth::user()) || $this->user->super_admin;
    }

    public function abonelikEkle(KullaniciYonetimi $yonetim): void
    {
        $veri = $this->validate([
            'plan' => ['required', Rule::in(array_map(fn (Plan $p) => $p->value, Plan::ucretliler()))],
            'baslangic' => ['required', 'date'],
            'sure' => ['required', Rule::in(array_keys(self::SURELER))],
            'bitis' => ['nullable', 'required_if:sure,ozel', 'date', 'after_or_equal:baslangic'],
            'tutar' => ['nullable', 'numeric', 'min:0', 'max:1000000'],
            'not' => ['nullable', 'string', 'max:500'],
        ], attributes: ['bitis' => 'bitiş tarihi', 'baslangic' => 'başlangıç', 'tutar' => 'tutar']);

        $baslangic = CarbonImmutable::parse($veri['baslangic']);
        $bitis = match ($veri['sure']) {
            'suresiz' => null,
            'ozel' => CarbonImmutable::parse($veri['bitis']),
            // "1 ay" 8 Ekim'de başlıyorsa 7 Kasım'da biter: başlangıç günü dahil.
            default => $baslangic->addMonthsNoOverflow((int) $veri['sure'])->subDay(),
        };

        $yonetim->abonelikEkle(
            $this->user,
            Auth::user(),
            Plan::from($veri['plan']),
            $baslangic,
            $bitis,
            $veri['tutar'] === null || $veri['tutar'] === '' ? null : (int) round((float) $veri['tutar'] * 100),
            $veri['not'] ?: null,
        );

        unset($this->abonelikler, $this->islemler);
        $this->reset('not', 'bitis');
        $this->baslangic = $yonetim->siradakiBaslangic($this->user->refresh())->toDateString();

        Flux::toast(variant: 'success', text: 'Abonelik eklendi.');
    }

    public function abonelikIptal(int $abonelikId, KullaniciYonetimi $yonetim): void
    {
        $abonelik = $this->user->abonelikler()->findOrFail($abonelikId);
        $yonetim->abonelikIptal($abonelik, Auth::user());

        unset($this->abonelikler, $this->islemler);
        $this->baslangic = $yonetim->siradakiBaslangic($this->user->refresh())->toDateString();

        Flux::toast(text: 'Abonelik iptal edildi.');
    }

    public function askiyaAl(KullaniciYonetimi $yonetim): void
    {
        $this->validate(['askiNedeni' => ['nullable', 'string', 'max:300']]);

        $this->guvenle(fn () => $yonetim->askiyaAl($this->user, Auth::user(), $this->askiNedeni ?: null), 'Hesap askıya alındı; kullanıcının oturumu kapatılacak.');
        $this->reset('askiNedeni');
    }

    public function askidanCikar(KullaniciYonetimi $yonetim): void
    {
        $yonetim->askidanCikar($this->user, Auth::user());
        unset($this->islemler);
        $this->user->refresh();

        Flux::toast(variant: 'success', text: 'Askı kaldırıldı.');
    }

    public function sil(KullaniciYonetimi $yonetim): void
    {
        $this->validate(['silmeOnayi' => ['required', 'in:'.$this->user->email]], [
            'silmeOnayi.in' => 'Onay için kullanıcının e-posta adresini aynen yazın.',
        ]);

        $email = $this->user->email;

        if ($this->guvenle(fn () => $yonetim->sil($this->user, Auth::user()), null)) {
            Flux::toast(variant: 'success', text: "{$email} silindi.");
            $this->redirectRoute('admin.kullanicilar', navigate: true);
        }
    }

    /**
     * Servisin koruma kuralı (kendi hesabı, süper admin) ekranda toast olarak.
     */
    private function guvenle(callable $islem, ?string $basari): bool
    {
        try {
            $islem();
        } catch (InvalidArgumentException $e) {
            Flux::toast(variant: 'danger', text: $e->getMessage());

            return false;
        }

        unset($this->islemler);

        // Silinen kullanıcı yeniden okunamaz; sayfa zaten listeye dönüyor.
        if ($this->user->exists) {
            $this->user->refresh();
        }

        if ($basari !== null) {
            Flux::toast(variant: 'success', text: $basari);
        }

        return true;
    }

    public function render(): View
    {
        return view('livewire.admin.kullanici-detay');
    }
}
