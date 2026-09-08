<?php

namespace App\Http\Controllers;

use App\Services\Scoring\Sart\SartDeposu;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Bir üniversitenin analizinin çıkarıldığı kaynak yönerge PDF'ini gösterir.
 *
 * Belgeler depoda `pdf/` altında duruyor — public/ dışında, yani doğrudan
 * erişilemez. Dosya adı istekten DEĞİL, kendi veri dosyalarımızdan geliyor
 * ({@see SartDeposu::kaynakPdf()}); istekten gelen tek şey üniversite adı, o
 * da eşleşmezse 404. Böylece dizin gezinmesi (`../`) mümkün olmuyor.
 */
class YonergeKaynakController extends Controller
{
    public function __invoke(SartDeposu $depo, string $universite): BinaryFileResponse
    {
        $dosya = $depo->kaynakPdf($universite);

        abort_if($dosya === null, 404);

        $yol = base_path('pdf/'.$dosya);

        abort_unless(is_file($yol), 404);

        $yanit = response()->file($yol, ['Content-Type' => 'application/pdf']);

        // Tarayıcıda açılsın: aday çoğu zaman tek bir maddeye bakmak istiyor,
        // indirip açmak gereksiz bir adım. Dosya adları Türkçe harf ve boşluk
        // içerdiği için başlığı Symfony kurar (RFC 5987 kodlaması + ASCII
        // yedeği); elle yazılsa başlık bozulurdu.
        $yanit->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $dosya, Str::ascii($dosya));

        return $yanit;
    }
}
