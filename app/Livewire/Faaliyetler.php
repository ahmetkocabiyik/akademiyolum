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

    /**
     * Listeden tek tıkla onaylandı ↔ beklemede. Beklemedeki kayıt puana,
     * analize ve CV'ye girmiyor; içe aktarılanları gözden geçirirken her
     * birini düzenleme sayfasında açmak gerekmesin.
     */
    public function durumDegistir(int $id): void
    {
        $faaliyet = Auth::user()->faaliyetler()->findOrFail($id);

        $faaliyet->update(['durum' => $faaliyet->durum === 'onaylandi' ? 'beklemede' : 'onaylandi']);
    }

    public function render()
    {
        return view('livewire.faaliyetler', [
            'faaliyetler' => $faaliyetler = $this->faaliyetler(),
            // Puan saklanmıyor; kendi cetvelinden hesaplanır. Yönerge yoksa null.
            'puanlar' => Auth::user()->puanCetveli()?->faaliyetPuanlari($faaliyetler),
            'kategoriler' => Kategori::secenekler(),
            'vurgulanan' => (array) session(self::VURGULANAN, []),
        ]);
    }
}
