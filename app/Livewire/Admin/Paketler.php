<?php

namespace App\Livewire\Admin;

use App\Enums\Plan;
use App\Enums\YoneticiIslemi;
use App\Models\IslemKaydi;
use App\Models\Paket;
use App\Services\Abonelik\PaketKatalogu;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Yönetim paneli — abonelik paketleri: ad, fiyat, açıklama, özellikler.
 *
 * Paket eklenip silinmiyor (kimlikler Plan enum'unda); her paket ayrı
 * kaydediliyor. Fiyatlar formda TL, veritabanında kuruş. Fiyat değişikliği
 * mevcut abonelikleri etkilemez: her abonelik ödenen tutarı kendisi tutuyor.
 */
#[Layout('layouts.admin')]
#[Title('Yönetim · Paketler')]
class Paketler extends Component
{
    /**
     * Form durumu, plan değerine göre.
     *
     * @var array<string, array{ad: string, aciklama: string, aylik: string, yillik: string, ozellikler: string, buton_metni: string, satista: bool, one_cikan: bool}>
     */
    public array $paketler = [];

    public function mount(PaketKatalogu $katalog): void
    {
        foreach ($katalog->hepsi() as $deger => $paket) {
            $this->paketler[$deger] = [
                'ad' => $paket->ad,
                'aciklama' => (string) $paket->aciklama,
                'aylik' => self::tl($paket->aylik_fiyat_kurus),
                'yillik' => $paket->yillik_fiyat_kurus === null ? '' : self::tl($paket->yillik_fiyat_kurus),
                'ozellikler' => implode("\n", $paket->ozellikler),
                'buton_metni' => $paket->buton_metni,
                'satista' => $paket->satista,
                'one_cikan' => $paket->one_cikan,
            ];
        }
    }

    public function kaydet(string $deger, PaketKatalogu $katalog): void
    {
        $plan = Plan::tryFrom($deger) ?? abort(404);
        $onek = "paketler.{$deger}";
        $ucretsiz = $plan === Plan::Ucretsiz;

        $this->validate([
            "{$onek}.ad" => ['required', 'string', 'max:60'],
            "{$onek}.aciklama" => ['nullable', 'string', 'max:200'],
            "{$onek}.aylik" => $ucretsiz ? ['nullable'] : ['required', 'numeric', 'min:0', 'max:1000000'],
            "{$onek}.yillik" => $ucretsiz ? ['nullable'] : ['nullable', 'numeric', 'min:0', 'max:10000000'],
            "{$onek}.ozellikler" => ['nullable', 'string', 'max:2000'],
            "{$onek}.buton_metni" => ['required', 'string', 'max:40'],
            "{$onek}.satista" => ['boolean'],
            "{$onek}.one_cikan" => ['boolean'],
        ], attributes: [
            "{$onek}.ad" => 'paket adı',
            "{$onek}.aylik" => 'aylık fiyat',
            "{$onek}.yillik" => 'yıllık fiyat',
            "{$onek}.buton_metni" => 'buton metni',
        ]);

        $form = $this->paketler[$deger];
        $ozellikler = array_values(array_filter(array_map('trim', explode("\n", $form['ozellikler'])), fn (string $s) => $s !== ''));

        if (count($ozellikler) > 12 || collect($ozellikler)->contains(fn (string $s) => mb_strlen($s) > 120)) {
            $this->addError("{$onek}.ozellikler", 'En fazla 12 özellik, her biri en fazla 120 karakter.');

            return;
        }

        $paket = $katalog->bilgi($plan);
        $eskiAylik = $paket->aylik_fiyat_kurus;
        $eskiYillik = $paket->yillik_fiyat_kurus;

        DB::transaction(function () use ($paket, $form, $ozellikler, $ucretsiz, $eskiAylik, $eskiYillik): void {
            $paket->fill([
                'ad' => trim($form['ad']),
                'aciklama' => trim($form['aciklama']) ?: null,
                // Ücretsiz paketin fiyatı her zaman 0: aboneliksiz kullanıcının adı.
                'aylik_fiyat_kurus' => $ucretsiz ? 0 : self::kurus($form['aylik']),
                'yillik_fiyat_kurus' => $ucretsiz || $form['yillik'] === '' ? null : self::kurus($form['yillik']),
                'ozellikler' => $ozellikler,
                'buton_metni' => trim($form['buton_metni']),
                'satista' => $form['satista'],
                'one_cikan' => $form['one_cikan'],
                'guncelleyen_id' => Auth::id(),
            ])->save();

            IslemKaydi::yaz(YoneticiIslemi::PaketGuncelledi, Auth::user(), null, array_filter([
                'paket' => $paket->ad,
                'aylik' => $eskiAylik !== $paket->aylik_fiyat_kurus
                    ? Paket::fiyatMetni($eskiAylik).' → '.Paket::fiyatMetni($paket->aylik_fiyat_kurus) : null,
                'yillik' => $eskiYillik !== $paket->yillik_fiyat_kurus
                    ? ($eskiYillik === null ? 'yok' : Paket::fiyatMetni($eskiYillik)).' → '.($paket->yillik_fiyat_kurus === null ? 'yok' : Paket::fiyatMetni($paket->yillik_fiyat_kurus)) : null,
                'satista' => $paket->satista ? 'evet' : 'hayır',
            ], fn ($v) => $v !== null));
        });

        $katalog->yenile();
        $this->paketler[$deger]['ozellikler'] = implode("\n", $ozellikler);

        Flux::toast(variant: 'success', text: "{$paket->ad} paketi kaydedildi.");
    }

    /** 29900 → "299", 29950 → "299.50" (sayı kutusu biçimi). */
    private static function tl(int $kurus): string
    {
        return $kurus % 100 === 0 ? (string) intdiv($kurus, 100) : number_format($kurus / 100, 2, '.', '');
    }

    private static function kurus(string $tl): int
    {
        return (int) round((float) $tl * 100);
    }

    public function render(): View
    {
        return view('livewire.admin.paketler', ['planlar' => Plan::cases()]);
    }
}
