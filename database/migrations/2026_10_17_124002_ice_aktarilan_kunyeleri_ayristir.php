<?php

use App\Enums\Kategori;
use App\Services\Yayin\KunyeAyristirici;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Daha önce içe aktarılmış (AVESİS/APBS) faaliyetlerin ham künyesini künye
 * alanlarına ayırır: dergi, cilt, sayı, sayfa, toplantı, yayınevi, ISBN…
 * Yeni içe aktarmalar bunu kayıt sırasında yapıyor (FaaliyetEkle::ekle).
 *
 * Yalnız BOŞ alan doldurulur; adayın elle girdiği değere dokunulmaz.
 *
 * Ayrıca APBS'nin son kitap kutusundan sayfa alt bilgisini yazar diye almış
 * kayıtların ("BAUM 2024 © Mersin Üniversitesi") yazar alanı boşaltılır;
 * hata ApbsProfili::ilkDiv ile giderildi, aday yazarı düzenlemede girer.
 * Geri alınmaz: eklenen anahtarlar ham künyeden türetilmiş, silmek bilgi
 * kaybettirir ve adayın sonradan düzelttiğini ayırt edemezdi.
 */
return new class extends Migration
{
    public function up(): void
    {
        $ayristirici = new KunyeAyristirici;

        DB::table('faaliyetler')
            ->where('meta', 'like', '%"kunye"%')
            ->orderBy('id')
            ->chunkById(500, function ($satirlar) use ($ayristirici): void {
                foreach ($satirlar as $satir) {
                    $kategori = Kategori::tryFrom((string) $satir->kategori);
                    $meta = json_decode((string) $satir->meta, true);

                    if ($kategori === null || ! is_array($meta) || ! is_string($meta['kunye'] ?? null)) {
                        continue;
                    }

                    $yeni = $meta + $ayristirici->ayristir($kategori, $meta['kunye']);
                    $degisiklik = $yeni !== $meta ? ['meta' => json_encode($yeni, JSON_UNESCAPED_UNICODE)] : [];

                    if (preg_match('/©|Bu sistemdeki veriler/u', (string) $satir->yazarlar) === 1) {
                        $degisiklik['yazarlar'] = null;
                    }

                    if ($degisiklik !== []) {
                        DB::table('faaliyetler')->where('id', $satir->id)->update($degisiklik);
                    }
                }
            });
    }

    public function down(): void
    {
        //
    }
};
