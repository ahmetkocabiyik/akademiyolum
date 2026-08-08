<?php

namespace App\Livewire;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Services\Scoring\KuralSetiCozucu;
use App\Services\Scoring\PuanHesaplayici;
use App\Services\Scoring\RuleSet;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.focused')]
#[Title('Faaliyet Ekle')]
class FaaliyetEkle extends Component
{
    public ?Faaliyet $faaliyet = null;

    public string $sekme = 'manuel';

    // Form alanları
    public string $kategori = 'makale';

    public string $baslik = '';

    /** @var list<string> */
    public array $yazarlar = [''];

    /** Adayın faaliyetteki rolü; geçerli değerler kategoriye göre değişir. */
    public string $rol = '';

    public string $donem = '';

    public string $kaynak = '';

    public string $yil = '';

    public string $doi = '';

    public string $aciklama = '';

    public function mount(?Faaliyet $faaliyet = null): void
    {
        if ($faaliyet !== null && $faaliyet->exists) {
            abort_unless($faaliyet->user_id === Auth::id(), 404);

            $this->faaliyet = $faaliyet;
            $this->kategori = $faaliyet->kategori->value;
            $this->baslik = $faaliyet->baslik;
            $this->yazarlar = $faaliyet->yazarlar
                ? array_map('trim', explode(',', $faaliyet->yazarlar))
                : [''];
            $this->rol = $faaliyet->rol ?? '';
            $this->donem = $faaliyet->donem ?? '';
            $this->kaynak = $faaliyet->kaynak ?? '';
            $this->yil = (string) ($faaliyet->meta['yil'] ?? '');
            $this->doi = (string) ($faaliyet->meta['doi'] ?? '');
            $this->aciklama = (string) ($faaliyet->meta['aciklama'] ?? '');

            return;
        }

        // Dashboard hızlı-ekle bağlantısından gelen kategori ön-seçimi.
        $kategori = request('kategori');
        if (is_string($kategori) && Kategori::tryFrom($kategori) !== null) {
            $this->kategori = $kategori;
        }
    }

    public function updatedKategori(): void
    {
        // Kaynak ve rol sözlüğü kategoriye göre değişiyor.
        $this->kaynak = '';
        $this->rol = '';
    }

    /**
     * Seçili kategoride geçerli roller (yayında yazarlık, projede görev...).
     *
     * @return array<string, string>
     */
    public function rolSecenekleri(): array
    {
        return Kategori::from($this->kategori)->roller();
    }

    public function yazarEkle(): void
    {
        $this->yazarlar[] = '';
    }

    public function yazarSil(int $index): void
    {
        unset($this->yazarlar[$index]);
        $this->yazarlar = array_values($this->yazarlar);

        if ($this->yazarlar === []) {
            $this->yazarlar = [''];
        }
    }

    private function ruleSet(): RuleSet
    {
        return (new KuralSetiCozucu)->kullaniciIcin(Auth::user());
    }

    /**
     * Seçili kategorinin alt türleri.
     *
     * Kaynak, kullanıcının seçtiği yönergeden DEĞİL kategorinin kendi
     * sözlüğünden gelir: form hangi cetvelin yüklü olduğuna bağlı olmamalı.
     * Cetvelde karşılığı olmayan bir alt tür yalnızca 0 puan alır.
     *
     * @return list<string>
     */
    public function kaynakSecenekleri(): array
    {
        return Kategori::from($this->kategori)->kaynaklar();
    }

    /**
     * Girilen bilgilere göre canlı tahmini puan.
     */
    public function tahminiPuan(): int
    {
        $gecici = new Faaliyet(['kategori' => $this->kategori, 'kaynak' => $this->kaynak ?: null]);

        return (new PuanHesaplayici($this->ruleSet()))->hesapla($gecici);
    }

    public function kaydet(): void
    {
        $veri = $this->validate([
            'kategori' => ['required', Rule::enum(Kategori::class)],
            'baslik' => ['required', 'string', 'max:255'],
            'yazarlar' => ['array'],
            'yazarlar.*' => ['nullable', 'string', 'max:255'],
            'rol' => ['nullable', 'string', 'max:32'],
            'donem' => ['nullable', Rule::in(['tez_disi', 'tezden'])],
            'kaynak' => ['nullable', 'string', 'max:255'],
            'yil' => ['nullable', 'digits:4'],
            'doi' => ['nullable', 'string', 'max:255'],
            'aciklama' => ['nullable', 'string', 'max:1000'],
        ]);

        $kategori = Kategori::from($veri['kategori']);

        $yazarlar = array_values(array_filter(
            array_map('trim', $this->yazarlar),
            fn (string $yazar) => $yazar !== '',
        ));

        $rol = $this->rolBelirle($kategori, $yazarlar);

        $faaliyet = $this->faaliyet ?? new Faaliyet(['durum' => 'onaylandi']);

        $faaliyet->fill([
            'kategori' => $kategori->value,
            'tur' => $kategori->label(),
            'baslik' => $veri['baslik'],
            'yazarlar' => $yazarlar ? implode(', ', $yazarlar) : null,
            'rol' => $rol,
            'donem' => $veri['donem'] ?: null,
            'kaynak' => $veri['kaynak'] ?: null,
            'meta' => array_filter([
                'yil' => $veri['yil'] ?: null,
                'doi' => $veri['doi'] ?: null,
                'aciklama' => $veri['aciklama'] ?: null,
            ]),
        ]);

        $faaliyet->puan = (new PuanHesaplayici($this->ruleSet()))->hesapla($faaliyet);

        Auth::user()->faaliyetler()->save($faaliyet);

        Flux::toast(variant: 'success', text: $this->faaliyet !== null ? 'Faaliyet güncellendi.' : 'Faaliyet eklendi.');

        $this->redirectRoute('faaliyetler', navigate: true);
    }

    /**
     * Rolü belirler. Yayın türlerinde tek yazarlık otomatik çıkarılır; diğer
     * kategorilerde (proje, tez danışmanlığı) kullanıcının seçimi esastır.
     *
     * @param  list<string>  $yazarlar
     */
    private function rolBelirle(Kategori $kategori, array $yazarlar): ?string
    {
        $gecerli = $kategori->roller();

        if ($gecerli === []) {
            return null;
        }

        if (isset($gecerli['tek']) && count($yazarlar) <= 1) {
            return 'tek';
        }

        if (isset($gecerli[$this->rol])) {
            return $this->rol;
        }

        // Çok yazarlı ama rol seçilmemişse en kapsayıcı varsayılan.
        return isset($gecerli['ortak']) ? 'ortak' : array_key_first($gecerli);
    }

    public function render()
    {
        return view('livewire.faaliyet-ekle', [
            'kategoriler' => Kategori::cases(),
        ]);
    }
}
