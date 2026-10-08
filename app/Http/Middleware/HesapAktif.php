<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Askıya alınmış hesabın oturumunu kapatır.
 *
 * Giriş formunda değil burada: uygulamaya şifre dışında passkey ile de
 * giriliyor, ayrıca askıya alma ANINDA açık olan oturumlar da kapanmalı.
 * Her web isteğinde (Livewire güncellemeleri dahil) çalışıyor.
 */
class HesapAktif
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null || ! $user->askidaMi()) {
            return $next($request);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $mesaj = 'Hesabınız askıya alındı. Destek için bizimle iletişime geçin.';

        if ($request->hasHeader('X-Livewire') || $request->expectsJson()) {
            abort(403, $mesaj);
        }

        return redirect()->route('login')->withErrors(['email' => $mesaj]);
    }
}
