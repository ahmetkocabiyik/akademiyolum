<?php

namespace App\Livewire\Admin;

use App\Enums\Plan;
use App\Models\Abonelik;
use App\Models\AbonelikTalebi;
use App\Services\Abonelik\AbonelikTalepleri;
use Carbon\CarbonImmutable;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Yönetim paneli — tüm abonelik dönemleri. Atama ve iptal kullanıcının
 * sayfasında; burası takip için (süresi yaklaşan, biten).
 *
 * @property-read LengthAwarePaginator<int, Abonelik> $abonelikler
 * @property-read Collection<int, AbonelikTalebi> $talepler
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · Abonelikler')]
class Abonelikler extends Component
{
    use WithPagination;

    public const DURUMLAR = [
        'aktif' => 'Aktif',
        'yaklasan' => 'Süresi yaklaşan (14 gün)',
        'bitti' => 'Süresi dolmuş',
        'iptal' => 'İptal edilmiş',
        '' => 'Tümü',
    ];

    #[Url(except: 'aktif')]
    public string $durum = 'aktif';

    #[Url(except: '')]
    public string $plan = '';

    public function updated(string $alan): void
    {
        if (in_array($alan, ['durum', 'plan'], true)) {
            $this->resetPage();
        }
    }

    /**
     * @return LengthAwarePaginator<int, Abonelik>
     */
    #[Computed]
    public function abonelikler(): LengthAwarePaginator
    {
        $bugun = CarbonImmutable::today()->toDateString();
        $plan = Plan::tryFrom($this->plan);

        return Abonelik::query()
            ->with(['user', 'olusturan'])
            ->when($this->durum === 'aktif', fn (Builder $q) => $q->aktif())
            ->when($this->durum === 'yaklasan', fn (Builder $q) => $q->aktif()->whereNotNull('bitis')
                ->whereDate('bitis', '<=', CarbonImmutable::today()->addDays(Pano::YAKLASAN_GUN)->toDateString()))
            ->when($this->durum === 'bitti', fn (Builder $q) => $q->whereNull('iptal_edildi_at')->whereDate('bitis', '<', $bugun))
            ->when($this->durum === 'iptal', fn (Builder $q) => $q->whereNotNull('iptal_edildi_at'))
            ->when($plan !== null, fn (Builder $q) => $q->where('plan', $plan->value))
            ->when(in_array($this->durum, ['aktif', 'yaklasan'], true),
                fn (Builder $q) => $q->orderByRaw('bitis is null')->orderBy('bitis'),
                fn (Builder $q) => $q->latest('baslangic')->latest('id'))
            ->paginate(25);
    }

    /**
     * Kurulumda ücretli paket seçenlerin bekleyen talepleri, eskisi önde.
     *
     * @return Collection<int, AbonelikTalebi>
     */
    #[Computed]
    public function talepler(): Collection
    {
        return AbonelikTalebi::query()->bekleyen()->with('user')->oldest('id')->get();
    }

    /**
     * Ödeme alındı: talep, paketin güncel fiyatıyla sıradaki boş günden
     * başlayan aboneliğe çevrilir; kullanıcıya ve yöneticilere mail gider.
     */
    public function talebiOnayla(int $talepId): void
    {
        $talep = AbonelikTalebi::query()->bekleyen()->findOrFail($talepId);
        $abonelik = app(AbonelikTalepleri::class)->onayla($talep, Auth::user());

        unset($this->talepler, $this->abonelikler);
        Flux::toast(variant: 'success', text: "{$talep->user->name} için {$abonelik->plan->etiket()} aboneliği tanımlandı.");
    }

    public function talebiKapat(int $talepId): void
    {
        $talep = AbonelikTalebi::query()->bekleyen()->findOrFail($talepId);
        app(AbonelikTalepleri::class)->kapat($talep, Auth::user());

        unset($this->talepler);
        Flux::toast(text: 'Talep kapatıldı.');
    }

    public function render(): View
    {
        return view('livewire.admin.abonelikler');
    }
}
