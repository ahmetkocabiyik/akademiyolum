<?php

namespace App\Livewire;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Models\User;
use Flux\Flux;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * Toplu işlem için işaretlenen faaliyet kimlikleri. Tarayıcıdan metin
     * olarak gelebiliyor; kullanılmadan önce {@see seciliSorgu()} süzüyor.
     *
     * @var list<int|string>
     */
    public array $secili = [];

    /**
     * Filtrelenmiş faaliyet listesi.
     *
     * @return Collection<int, Faaliyet>
     */
    public function faaliyetler(): Collection
    {
        return $this->filtreliSorgu()->latest()->get();
    }

    /**
     * @return HasMany<Faaliyet, User>
     */
    private function filtreliSorgu(): HasMany
    {
        return Auth::user()->faaliyetler()
            ->when($this->arama !== '', fn ($q) => $q->where('baslik', 'like', "%{$this->arama}%"))
            ->when($this->kategoriFiltre !== '', fn ($q) => $q->where('kategori', $this->kategoriFiltre));
    }

    /**
     * İşaretli kayıtlar — yalnız adayın kendi ve EKRANDA GÖRÜNEN kayıtları.
     * Filtre değiştikten sonra gizlenmiş bir kaydın toplu silmeyle habersiz
     * gitmemesi için filtre de uygulanıyor.
     *
     * @return HasMany<Faaliyet, User>
     */
    private function seciliSorgu(): HasMany
    {
        return $this->filtreliSorgu()->whereIn('id', array_map('intval', $this->secili));
    }

    /** Filtre değişince seçim sıfırlanır: işaretli kayıt artık görünmüyor olabilir. */
    public function updatedArama(): void
    {
        $this->secili = [];
    }

    public function updatedKategoriFiltre(): void
    {
        $this->secili = [];
    }

    /** Başlıktaki kutu: görünenlerin hepsi işaretliyse temizler, değilse hepsini işaretler. */
    public function tumunuSecDegistir(): void
    {
        $gorunen = $this->filtreliSorgu()->pluck('id')->all();

        $this->secili = count(array_diff($gorunen, array_map('intval', $this->secili))) === 0 ? [] : $gorunen;
    }

    /**
     * İşaretlileri onaylar ya da beklemeye alır.
     */
    public function topluDurum(string $durum): void
    {
        abort_unless(in_array($durum, ['onaylandi', 'beklemede'], true), 422);

        $sayi = $this->seciliSorgu()->update(['durum' => $durum]);
        $this->secili = [];

        Flux::toast(variant: 'success', text: $sayi.' faaliyet '.($durum === 'onaylandi' ? 'onaylandı.' : 'beklemeye alındı.'));
    }

    public function topluSil(): void
    {
        // Model üzerinden siliniyor (sorgu üzerinden değil): olay dinleyicileri çalışsın.
        $silinenler = $this->seciliSorgu()->get();
        $silinenler->each->delete();
        $this->secili = [];

        Flux::toast(variant: 'success', text: $silinenler->count().' faaliyet silindi.');
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
