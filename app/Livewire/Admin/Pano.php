<?php

namespace App\Livewire\Admin;

use App\Models\Abonelik;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Yönetim paneli — genel bakış.
 *
 * @property-read array{kullanici: int, yeni: int, abone: int, askida: int} $sayilar
 * @property-read Collection<int, Abonelik> $bitecekler
 * @property-read Collection<int, User> $sonKayitlar
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · Genel Bakış')]
class Pano extends Component
{
    /** Bu kadar gün içinde bitecek aktif abonelikler "süresi yaklaşan" sayılır. */
    public const YAKLASAN_GUN = 14;

    /**
     * @return array{kullanici: int, yeni: int, abone: int, askida: int}
     */
    #[Computed]
    public function sayilar(): array
    {
        return [
            'kullanici' => User::query()->count(),
            'yeni' => User::query()->where('created_at', '>=', now()->subDays(30))->count(),
            // Aynı kullanıcının üst üste binen iki dönemi tek abone sayılır.
            'abone' => User::query()->whereHas('abonelikler', fn (Builder $q) => Abonelik::aktifKosulu($q))->count(),
            'askida' => User::query()->whereNotNull('askiya_alindi_at')->count(),
        ];
    }

    /**
     * @return Collection<int, Abonelik>
     */
    #[Computed]
    public function bitecekler(): Collection
    {
        $bugun = CarbonImmutable::today();

        return Abonelik::query()
            ->aktif()
            ->whereNotNull('bitis')
            ->whereDate('bitis', '<=', $bugun->addDays(self::YAKLASAN_GUN)->toDateString())
            ->with('user')
            ->orderBy('bitis')
            ->limit(10)
            ->get();
    }

    /**
     * @return Collection<int, User>
     */
    #[Computed]
    public function sonKayitlar(): Collection
    {
        return User::query()->latest()->limit(8)->get();
    }

    public function render(): View
    {
        return view('livewire.admin.pano');
    }
}
