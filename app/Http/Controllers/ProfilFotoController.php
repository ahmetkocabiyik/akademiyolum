<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Oturumdaki kullanıcının profil fotoğrafını gösterir.
 *
 * Fotoğraf `local` (özel) diskte; kişisel bir görsel herkese açık bir
 * URL'den erişilebilir olmamalı. Rota parametre almıyor, dosya yalnızca
 * oturumdaki kullanıcının kendi kaydından okunuyor (CvFotoController ile
 * aynı ilke).
 */
class ProfilFotoController extends Controller
{
    public function __invoke(): StreamedResponse
    {
        $yol = Auth::user()?->profil_foto;

        abort_if($yol === null || ! Storage::disk('local')->exists($yol), 404);

        return Storage::disk('local')->response($yol, headers: [
            'Cache-Control' => 'private, max-age=31536000, immutable',
        ]);
    }
}
