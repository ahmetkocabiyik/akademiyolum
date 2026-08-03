<?php

namespace App\Livewire;

use App\Models\DanismanMesaj;
use App\Models\DanismanSohbet;
use App\Services\AI\DanismanContext;
use App\Services\AI\SaglayiciException;
use App\Services\AI\SohbetSaglayici;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('YZ Danışman')]
class YzDanisman extends Component
{
    public string $mesaj = '';

    public bool $bekleniyor = false;

    public ?string $hata = null;

    public ?int $aktifSohbetId = null;

    /**
     * Hazır öneri promptları.
     *
     * @var list<string>
     */
    public array $oneriler = [
        'Doçentlik için öncelikli yol haritamı çıkar.',
        'Hangi kategoride eksiğim var?',
        'Puanımı en hızlı nasıl artırırım?',
    ];

    public function mount(): void
    {
        $this->aktifSohbetId = Auth::user()->danismanSohbetleri()
            ->latest('updated_at')
            ->value('id');
    }

    /**
     * Kullanıcının sohbetleri, en son güncellenen en üstte.
     *
     * @return Collection<int, DanismanSohbet>
     */
    #[Computed]
    public function sohbetler(): Collection
    {
        return Auth::user()->danismanSohbetleri()
            ->latest('updated_at')
            ->get();
    }

    /**
     * Aktif sohbetin mesajları.
     *
     * @return Collection<int, DanismanMesaj>
     */
    #[Computed]
    public function mesajlar(): Collection
    {
        if ($this->aktifSohbetId === null) {
            return collect();
        }

        $sohbet = Auth::user()->danismanSohbetleri()->find($this->aktifSohbetId);

        if ($sohbet === null) {
            return collect();
        }

        return $sohbet->mesajlar()->orderBy('id')->get();
    }

    public function gonder(): void
    {
        $this->validate(['mesaj' => ['required', 'string', 'max:2000']]);

        $metin = trim($this->mesaj);
        $sohbet = $this->aktifSohbetiHazirla($metin);

        $sohbet->mesajlar()->create([
            'user_id' => $sohbet->user_id,
            'rol' => 'user',
            'icerik' => $metin,
        ]);
        $sohbet->touch();

        $this->mesaj = '';
        $this->hata = null;
        $this->bekleniyor = true;
        unset($this->mesajlar, $this->sohbetler);

        $this->dispatch('sohbet-kaydir');
        $this->dispatch('danisman-yanit-al');
    }

    public function oneriGonder(string $metin): void
    {
        $this->mesaj = $metin;
        $this->gonder();
    }

    #[On('danisman-yanit-al')]
    public function yanitAl(SohbetSaglayici $saglayici): void
    {
        $sohbet = Auth::user()->danismanSohbetleri()->find($this->aktifSohbetId);

        if ($sohbet === null) {
            $this->bekleniyor = false;

            return;
        }

        $gecmis = $sohbet->mesajlar()
            ->orderBy('id')
            ->get()
            ->map(fn (DanismanMesaj $m) => ['rol' => $m->rol, 'icerik' => $m->icerik])
            ->all();

        $sistemPrompt = (new DanismanContext)->sistemPrompt(Auth::user());

        try {
            $yanit = $saglayici->yanitla($sistemPrompt, $gecmis);
        } catch (SaglayiciException $e) {
            $this->bekleniyor = false;
            $this->hata = $e->getMessage();

            return;
        }

        $sohbet->mesajlar()->create([
            'user_id' => $sohbet->user_id,
            'rol' => 'assistant',
            'icerik' => $yanit,
        ]);
        $sohbet->touch();

        $this->bekleniyor = false;
        unset($this->mesajlar, $this->sohbetler);

        $this->dispatch('sohbet-kaydir');
    }

    public function yeniSohbet(): void
    {
        $this->aktifSohbetId = null;
        $this->bekleniyor = false;
        $this->hata = null;
        $this->mesaj = '';
        unset($this->mesajlar);
    }

    public function sohbetSec(int $sohbetId): void
    {
        $sohbet = Auth::user()->danismanSohbetleri()->find($sohbetId);

        if ($sohbet === null) {
            return;
        }

        $this->aktifSohbetId = $sohbet->id;
        $this->bekleniyor = false;
        $this->hata = null;
        unset($this->mesajlar);

        $this->dispatch('sohbet-kaydir');
    }

    public function sohbetiSil(int $sohbetId): void
    {
        $sohbet = Auth::user()->danismanSohbetleri()->find($sohbetId);

        if ($sohbet === null) {
            return;
        }

        $sohbet->delete();

        if ($this->aktifSohbetId === $sohbetId) {
            $this->aktifSohbetId = Auth::user()->danismanSohbetleri()
                ->latest('updated_at')
                ->value('id');
            $this->bekleniyor = false;
            $this->hata = null;
        }

        unset($this->mesajlar, $this->sohbetler);
    }

    /**
     * Aktif sohbet yoksa yeni bir sohbet oluşturur; başlığı ilk mesajdan türetir.
     */
    private function aktifSohbetiHazirla(string $ilkMesaj): DanismanSohbet
    {
        if ($this->aktifSohbetId !== null) {
            $mevcut = Auth::user()->danismanSohbetleri()->find($this->aktifSohbetId);

            if ($mevcut !== null) {
                return $mevcut;
            }
        }

        $sohbet = Auth::user()->danismanSohbetleri()->create([
            'baslik' => Str::limit($ilkMesaj, 57),
        ]);

        $this->aktifSohbetId = $sohbet->id;

        return $sohbet;
    }

    public function render()
    {
        return view('livewire.yz-danisman');
    }
}
