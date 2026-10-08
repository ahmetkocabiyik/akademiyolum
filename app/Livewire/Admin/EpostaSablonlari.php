<?php

namespace App\Livewire\Admin;

use App\Enums\EpostaTuru;
use App\Models\EpostaSablonu;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Yönetim paneli — e-posta şablonları listesi.
 *
 * @property-read Collection<string, EpostaSablonu> $kayitlar
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · E-posta Şablonları')]
class EpostaSablonlari extends Component
{
    /**
     * Panelde düzenlenmiş şablonlar, türe göre.
     *
     * @return Collection<string, EpostaSablonu>
     */
    #[Computed]
    public function kayitlar(): Collection
    {
        return EpostaSablonu::query()->with('guncelleyen')->get()->keyBy(fn (EpostaSablonu $s) => $s->tur->value);
    }

    public function render(): View
    {
        return view('livewire.admin.eposta-sablonlari', ['turler' => EpostaTuru::cases()]);
    }
}
