<?php

namespace App\Livewire\Admin;

use App\Enums\Plan;
use App\Models\Abonelik;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Yönetim paneli — kullanıcı listesi. Filtreler adreste: süzülmüş liste
 * paylaşılabilir, geri tuşuyla korunur.
 *
 * @property-read LengthAwarePaginator<int, User> $kullanicilar
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · Kullanıcılar')]
class Kullanicilar extends Component
{
    use WithPagination;

    public const SIRALAMALAR = [
        'yeni' => 'En yeni kayıt',
        'eski' => 'En eski kayıt',
        'son_giris' => 'Son giriş',
        'ad' => 'Ada göre',
    ];

    public const DURUMLAR = [
        '' => 'Tüm durumlar',
        'aktif' => 'Aktif',
        'askida' => 'Askıda',
        'admin' => 'Süper admin',
    ];

    #[Url(except: '')]
    public string $arama = '';

    #[Url(except: '')]
    public string $plan = '';

    #[Url(except: '')]
    public string $durum = '';

    #[Url(except: 'yeni')]
    public string $siralama = 'yeni';

    /** Filtre değişince ilk sayfaya dön; yoksa boş bir 5. sayfada kalınırdı. */
    public function updated(string $alan): void
    {
        if (in_array($alan, ['arama', 'plan', 'durum', 'siralama'], true)) {
            $this->resetPage();
        }
    }

    /**
     * @return LengthAwarePaginator<int, User>
     */
    #[Computed]
    public function kullanicilar(): LengthAwarePaginator
    {
        $plan = Plan::tryFrom($this->plan);
        $arama = trim($this->arama);

        return User::query()
            ->withCount('faaliyetler')
            ->with(['abonelikler' => fn ($q) => $q->aktif()->orderByDesc('bitis')])
            ->when($arama !== '', fn (Builder $q) => $q->where(fn (Builder $w) => $w
                ->where('name', 'like', "%{$arama}%")
                ->orWhere('email', 'like', "%{$arama}%")
                ->orWhere('universite', 'like', "%{$arama}%")))
            ->when($plan === Plan::Ucretsiz, fn (Builder $q) => $q->whereDoesntHave('abonelikler', fn (Builder $a) => Abonelik::aktifKosulu($a)))
            ->when($plan !== null && $plan !== Plan::Ucretsiz, fn (Builder $q) => $q->whereHas('abonelikler', fn (Builder $a) => Abonelik::aktifKosulu($a->where('plan', $plan->value))))
            ->when($this->durum === 'aktif', fn (Builder $q) => $q->whereNull('askiya_alindi_at'))
            ->when($this->durum === 'askida', fn (Builder $q) => $q->whereNotNull('askiya_alindi_at'))
            ->when($this->durum === 'admin', fn (Builder $q) => $q->where('super_admin', true))
            ->tap(fn (Builder $q) => match ($this->siralama) {
                'eski' => $q->oldest(),
                'son_giris' => $q->orderByRaw('son_giris_at is null')->orderByDesc('son_giris_at'),
                'ad' => $q->orderBy('name'),
                default => $q->latest()->orderByDesc('id'),
            })
            ->paginate(25);
    }

    public function filtreleriTemizle(): void
    {
        $this->reset('arama', 'plan', 'durum', 'siralama');
        $this->resetPage();
    }

    public function render(): View
    {
        return view('livewire.admin.kullanicilar');
    }
}
