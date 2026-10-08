<?php

namespace App\Livewire\Admin;

use App\Enums\YoneticiIslemi;
use App\Models\IslemKaydi as IslemKaydiModeli;
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
 * Yönetim paneli — yönetici işlem kaydı (salt okunur).
 *
 * @property-read LengthAwarePaginator<int, IslemKaydiModeli> $kayitlar
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · İşlem Kaydı')]
class IslemKaydi extends Component
{
    use WithPagination;

    /** Yönetici ya da hedef e-postasında arar. */
    #[Url(except: '')]
    public string $arama = '';

    #[Url(except: '')]
    public string $islem = '';

    public function updated(string $alan): void
    {
        if (in_array($alan, ['arama', 'islem'], true)) {
            $this->resetPage();
        }
    }

    /**
     * @return LengthAwarePaginator<int, IslemKaydiModeli>
     */
    #[Computed]
    public function kayitlar(): LengthAwarePaginator
    {
        $islem = YoneticiIslemi::tryFrom($this->islem);
        $arama = trim($this->arama);

        return IslemKaydiModeli::query()
            ->when($islem !== null, fn (Builder $q) => $q->where('islem', $islem->value))
            ->when($arama !== '', fn (Builder $q) => $q->where(fn (Builder $w) => $w
                ->where('hedef_eposta', 'like', "%{$arama}%")
                ->orWhere('yonetici_eposta', 'like', "%{$arama}%")))
            ->latest('id')
            ->paginate(30);
    }

    public function render(): View
    {
        return view('livewire.admin.islem-kaydi');
    }
}
