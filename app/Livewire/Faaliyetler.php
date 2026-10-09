<?php

namespace App\Livewire;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use Flux\Flux;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Faaliyetler')]
class Faaliyetler extends Component
{
    public string $arama = '';

    public string $kategoriFiltre = '';

    /**
     * Filtrelenmiş faaliyet listesi.
     *
     * @return Collection<int, Faaliyet>
     */
    public function faaliyetler(): Collection
    {
        return Auth::user()->faaliyetler()
            ->when($this->arama !== '', fn ($q) => $q->where('baslik', 'like', "%{$this->arama}%"))
            ->when($this->kategoriFiltre !== '', fn ($q) => $q->where('kategori', $this->kategoriFiltre))
            ->latest()
            ->get();
    }

    /** Az önce eklenen/düzenlenen faaliyetlerin oturum anahtarı (listede parlar). */
    public const VURGULANAN = 'vurgulanan_faaliyetler';

    public function sil(int $id): void
    {
        Auth::user()->faaliyetler()->findOrFail($id)->delete();

        Flux::toast(variant: 'success', text: 'Faaliyet silindi.');
    }

    public function render()
    {
        return view('livewire.faaliyetler', [
            'faaliyetler' => $this->faaliyetler(),
            'kategoriler' => Kategori::secenekler(),
            'vurgulanan' => (array) session(self::VURGULANAN, []),
        ]);
    }
}
