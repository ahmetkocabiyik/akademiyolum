<?php

namespace App\Livewire;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Services\Scoring\KuralSetiCozucu;
use App\Services\Scoring\PuanRaporu;
use App\Services\Scoring\RaporSonucu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    /**
     * Kullanıcının faaliyetleri (en yeni önce).
     *
     * @return Collection<int, Faaliyet>
     */
    #[Computed]
    public function faaliyetler(): Collection
    {
        return Auth::user()->faaliyetler()->latest()->get();
    }

    /**
     * Aktif yönergeye göre puanlama raporu.
     */
    #[Computed]
    public function rapor(): RaporSonucu
    {
        $ruleSet = (new KuralSetiCozucu)->kullaniciIcin(Auth::user());
        $motor = new PuanRaporu($ruleSet);

        return $motor->olustur(
            $this->faaliyetler->where('durum', 'onaylandi')
        );
    }

    /**
     * Rapordan türetilen dinamik bildirimler.
     *
     * @return list<array{tip: string, baslik: string, aciklama: string}>
     */
    #[Computed]
    public function bildirimler(): array
    {
        $rapor = $this->rapor;
        $bildirimler = [];

        if ($rapor->kategori(Kategori::ToplumsalKatki)->adet === 0) {
            $bildirimler[] = [
                'tip' => 'danger',
                'baslik' => 'Toplumsal Katkı eklenmemiş',
                'aciklama' => 'Asgari şart — en az 1 kayıt zorunlu',
            ];
        }

        if ($rapor->kategori(Kategori::Makale)->adet === 0) {
            $bildirimler[] = [
                'tip' => 'warn',
                'baslik' => 'Henüz makale girilmemiş',
                'aciklama' => 'Puanınızı en çok makaleler artırır',
            ];
        }

        if ($rapor->kalanUakPuan() > 0) {
            $bildirimler[] = [
                'tip' => 'info',
                'baslik' => "ÜAK hedefine {$rapor->kalanUakPuan()} puan kaldı",
                'aciklama' => "Mevcut: {$rapor->toplamPuan} / {$rapor->uakHedef}",
            ];
        }

        return $bildirimler;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
