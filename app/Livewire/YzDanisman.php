<?php

namespace App\Livewire;

use App\Models\DanismanMesaj;
use App\Services\AI\DanismanContext;
use App\Services\AI\SohbetSaglayici;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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

    /**
     * @return Collection<int, DanismanMesaj>
     */
    #[Computed]
    public function mesajlar(): Collection
    {
        return Auth::user()->danismanMesajlari()->orderBy('id')->get();
    }

    public function gonder(): void
    {
        $this->validate(['mesaj' => ['required', 'string', 'max:2000']]);

        Auth::user()->danismanMesajlari()->create([
            'rol' => 'user',
            'icerik' => trim($this->mesaj),
        ]);

        $this->mesaj = '';
        $this->bekleniyor = true;
        unset($this->mesajlar);

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
        $user = Auth::user();

        $gecmis = $user->danismanMesajlari()
            ->orderBy('id')
            ->get()
            ->map(fn (DanismanMesaj $m) => ['rol' => $m->rol, 'icerik' => $m->icerik])
            ->all();

        $sistemPrompt = (new DanismanContext)->sistemPrompt($user);

        $yanit = $saglayici->yanitla($sistemPrompt, $gecmis);

        $user->danismanMesajlari()->create([
            'rol' => 'assistant',
            'icerik' => $yanit,
        ]);

        $this->bekleniyor = false;
        unset($this->mesajlar);

        $this->dispatch('sohbet-kaydir');
    }

    public function sohbetiTemizle(): void
    {
        Auth::user()->danismanMesajlari()->delete();
        $this->bekleniyor = false;
        unset($this->mesajlar);
    }

    public function render()
    {
        return view('livewire.yz-danisman');
    }
}
