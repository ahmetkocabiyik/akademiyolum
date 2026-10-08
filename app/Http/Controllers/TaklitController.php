<?php

namespace App\Http\Controllers;

use App\Enums\YoneticiIslemi;
use App\Models\IslemKaydi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * "Kullanıcı olarak gör": süper admin, destek için bir kullanıcının ekranını
 * onun oturumuyla görür.
 *
 * Hassas bir yetki; bu yüzden:
 *   - başlangıç ve bitiş işlem kaydına yazılır,
 *   - süper admin ve askıdaki hesap taklit edilemez,
 *   - taklit süresince her sayfada belirgin bir şerit durur (bkz. sidebar),
 *   - bitirirken yöneticinin HÂLÂ süper admin olduğu yeniden doğrulanır.
 */
class TaklitController extends Controller
{
    /** Oturumda taklit eden yöneticinin kimliği. */
    public const OTURUM_ANAHTARI = 'taklit_eden_yonetici_id';

    public function baslat(Request $request, User $user): RedirectResponse
    {
        $yonetici = $request->user();

        abort_if($user->is($yonetici) || $user->super_admin || $user->askidaMi(), 403);

        IslemKaydi::yaz(YoneticiIslemi::KullaniciOlarakGirdi, $yonetici, $user);

        // Anahtar Auth::login'den ÖNCE yazılıyor: Login olayı bunu görüp
        // kullanıcının "son giriş" tarihini değiştirmiyor.
        $request->session()->put(self::OTURUM_ANAHTARI, $yonetici->id);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function bitir(Request $request): RedirectResponse
    {
        $yoneticiId = $request->session()->get(self::OTURUM_ANAHTARI);
        $yonetici = is_int($yoneticiId) ? User::query()->whereKey($yoneticiId)->first() : null;

        abort_if($yonetici === null || ! $yonetici->super_admin || $yonetici->askidaMi(), 403);

        $taklitEdilen = $request->user();

        IslemKaydi::yaz(YoneticiIslemi::KullaniciOlarakCikti, $yonetici, $taklitEdilen);

        Auth::login($yonetici);
        $request->session()->forget(self::OTURUM_ANAHTARI);
        $request->session()->regenerate();

        return $taklitEdilen === null
            ? redirect()->route('admin.kullanicilar')
            : redirect()->route('admin.kullanici', $taklitEdilen);
    }
}
