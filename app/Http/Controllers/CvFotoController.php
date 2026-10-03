<?php

namespace App\Http\Controllers;

use App\Models\CvProfili;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Oturumdaki adayın CV fotoğrafını gösterir.
 *
 * Fotoğraf `local` (özel) diskte duruyor; kişisel bir görsel herkese açık bir
 * URL'den erişilebilir olmamalı. Rota parametre almıyor, dosya yalnızca
 * oturumdaki kullanıcının kendi profilinden okunuyor: başkasının fotoğrafını
 * istemenin bir yolu yok.
 */
class CvFotoController extends Controller
{
    public function __invoke(): StreamedResponse
    {
        $yol = CvProfili::query()->where('user_id', Auth::id())->value('foto');

        abort_if($yol === null || ! Storage::disk('local')->exists($yol), 404);

        return Storage::disk('local')->response($yol, headers: [
            'Cache-Control' => 'private, max-age=31536000, immutable',
        ]);
    }
}
