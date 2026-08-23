<?php

namespace App\Console\Commands;

use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Yonerge\CetvelAyristirici;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

/**
 * Yönerge PDF'inden puan cetveli TASLAĞI çıkarır ve elle girilmiş cetveli
 * kaynağına karşı denetler.
 *
 * Taslak, adaya gösterilmeye uygun değildir — eşiği `durum => taslak` ile
 * işaretlenir ve {@see SartDeposu} onu adaya giden hiçbir yolda döndürmez.
 * Bu komut insanın işini bitirmez, başlangıç noktasını verir.
 *
 * TASARIM KARARI: eşlenemeyen satır SESSİZCE DÜŞMEZ. Cetvelden düşen bir kalem
 * adayın puanını sessizce eksiltir ve bunu kimse fark etmez; eşlenememiş satır
 * ise raporda görünür ve elle doldurulur.
 *
 * Ayrıştırma mantığı {@see CetvelAyristirici} içindedir; komut yalnızca PDF'i
 * metne çevirir, sonucu raporlar ve PHP'ye döker.
 */
class CetvelTasla extends Command
{
    protected $signature = 'yonerge:cetvel-tasla
        {pdf : PDF yolu (ör. pdf/17536928172.akdenizuniversitesi.pdf)}
        {--yaz= : Taslağı bu dosyaya yaz (varsayılan: ekrana bas)}
        {--esle : Yalnızca eşleme raporunu göster, PHP üretme}
        {--karsilastir= : Elle girilmiş cetvele karşı denetle (ör. akdeniz-2026)}';

    protected $description = 'Yönerge PDF\'inden puan cetveli taslağı çıkarır (doğrulanmamış)';

    public function handle(SartDeposu $depo, CetvelAyristirici $ayristirici): int
    {
        $pdf = (string) $this->argument('pdf');

        if (! is_file($pdf)) {
            $this->error("PDF bulunamadı: {$pdf}");

            return self::FAILURE;
        }

        $metin = $this->metin($pdf);

        // Taranmış belgeler tamamen boş dönmüyor: KTÜ'nün 48 sayfası 48
        // karakter üretiyor (sayfa numaraları). Boşluk kontrolü bunu
        // yakalamadığı için komut "tablo düzeni farklı" diyor ve insanı
        // ayrıştırıcıyı düzeltmeye yönlendiriyordu — oysa yapılacak iş OCR.
        $sayfa = max(1, $this->sayfaSayisi($pdf));
        $karakterYogunlugu = mb_strlen(trim($metin)) / $sayfa;

        if ($karakterYogunlugu < 200) {
            $this->error(sprintf(
                'PDF taranmış görünüyor (sayfa başına %d karakter) — ayrıştırılamaz, önce OCR gerekiyor.',
                (int) $karakterYogunlugu,
            ));

            return self::FAILURE;
        }

        [$satirlar, $catisan] = $ayristirici->tekille($ayristirici->satirlar($metin));
        $coklular = $ayristirici->coklular($metin);

        if ($satirlar === []) {
            $this->error('Puan satırı bulunamadı. Tablo düzeni beklenenden farklı olabilir.');

            return self::FAILURE;
        }

        $eslesen = [];
        $eslesmeyen = [];

        foreach ($satirlar as $satir) {
            $kaynak = $ayristirici->esle($satir['baslik']);

            if ($kaynak === null) {
                $eslesmeyen[] = $satir;

                continue;
            }

            $eslesen[] = $satir + $kaynak;
        }

        $this->rapor($satirlar, $eslesen, $eslesmeyen, $catisan, $coklular);

        $karsilastir = $this->option('karsilastir');

        if ($karsilastir !== null) {
            return $this->karsilastir($depo, (string) $karsilastir, $satirlar, $eslesmeyen);
        }

        if ($this->option('esle')) {
            return self::SUCCESS;
        }

        $php = $this->php($pdf, $eslesen, $eslesmeyen);
        $hedef = $this->option('yaz');

        if ($hedef === null) {
            $this->newLine();
            $this->line($php);

            return self::SUCCESS;
        }

        file_put_contents((string) $hedef, $php);
        $this->info("Taslak yazıldı: {$hedef}");

        return self::SUCCESS;
    }

    private function metin(string $pdf): string
    {
        $surec = new Process(['pdftotext', '-q', '-layout', $pdf, '-']);
        $surec->run();

        return $surec->getOutput();
    }

    private function sayfaSayisi(string $pdf): int
    {
        $surec = new Process(['pdfinfo', $pdf]);
        $surec->run();

        return preg_match('/^Pages:\s+(\d+)/m', $surec->getOutput(), $m) === 1 ? (int) $m[1] : 0;
    }

    /**
     * Elle girilmiş cetveli PDF'e karşı denetler.
     *
     * Ayrıştırıcının asıl değeri burada: elle girilen bir puanın kaynağıyla
     * çelişip çelişmediğini söyler. Atatürk'ün ödül bölümünde uydurulmuş bir
     * "Burs, 5 puan" kalemi bu yolla bulundu.
     *
     * ARAÇ HANGİSİNİN DOĞRU OLDUĞUNU SÖYLEYEMEZ, yalnızca ayrışmayı gösterir.
     * İki sebebi olabilir ve ayırt etmek insanın işi:
     *
     *   · Elle giriş yanlış — Atatürk'te uydurulmuş "Burs, 5 puan" kalemi.
     *   · Kod çakışması — Gümüşhane'de bizim sentetik `E3a` ("araştırmacı,
     *     yürütücünün 1/2'si" kuralından türetilmiş) yönergenin gerçek `E3.a)`
     *     bendiyle (BİDEB projeleri) aynı koda düşüyor. İkisi de doğru.
     *
     * Bu yüzden çıktı iki başlığı yan yana basar ve "çelişki" değil "ayrışma"
     * der. Kodu bulunamayan kalem ayrışma bile değildir: ayrıştırıcı her tablo
     * düzenini okuyamıyor.
     *
     * @param  list<array{kod: string, baslik: string, puan: int}>  $satirlar
     * @param  list<array<string, mixed>>  $eslesmeyen
     */
    private function karsilastir(SartDeposu $depo, string $cetvel, array $satirlar, array $eslesmeyen): int
    {
        $katalog = $depo->katalog($cetvel);

        if ($katalog === null) {
            $this->error("Cetvel bulunamadı: {$cetvel}");

            return self::FAILURE;
        }

        $pdfPuani = [];

        foreach ($satirlar as $s) {
            $pdfPuani[$s['kod']] = $s;
        }

        $gorunur = array_column($eslesmeyen, 'kod');
        $tutan = 0;
        $ulasilamayan = 0;
        $sapan = [];

        foreach ($katalog->maddeler as $kod => $madde) {
            $puan = $madde['puan'] ?? null;

            if ($puan === null) {
                continue; // Adet tabanlı cetvel; karşılaştırılacak sayı yok.
            }

            if (! isset($pdfPuani[$kod])) {
                $ulasilamayan += in_array($kod, $gorunur, true) ? 0 : 1;

                continue;
            }

            if ($pdfPuani[$kod]['puan'] === $puan) {
                $tutan++;

                continue;
            }

            $sapan[] = [
                'kod' => $kod,
                'elle' => sprintf('%-5d %s', $puan, mb_substr($madde['baslik'], 0, 58)),
                'pdf' => sprintf('%-5d %s', $pdfPuani[$kod]['puan'], mb_substr($pdfPuani[$kod]['baslik'], 0, 58)),
            ];
        }

        $this->newLine();
        $this->info(sprintf('DENETİM · %s — %d kod doğrulandı, %d ulaşılamadı',
            $cetvel, $tutan, $ulasilamayan));

        if ($sapan === []) {
            return self::SUCCESS;
        }

        $this->warn(count($sapan).' kalemde PDF ile AYRIŞMA — elle bakılmalı:');
        $this->line('  (ya elle giriş yanlış, ya da kodlar farklı kalemlere denk geliyor)');

        foreach ($sapan as $s) {
            $this->newLine();
            $this->line("   <options=bold>{$s['kod']}</>");
            $this->line("     elle : {$s['elle']}");
            $this->line("     PDF  : {$s['pdf']}");
        }

        return self::FAILURE;
    }

    /**
     * @param  list<array<string, mixed>>  $satirlar
     * @param  list<array<string, mixed>>  $eslesen
     * @param  list<array<string, mixed>>  $eslesmeyen
     * @param  list<string>  $catisan
     * @param  list<array{kod: string, baslik: string}>  $coklular
     */
    private function rapor(array $satirlar, array $eslesen, array $eslesmeyen, array $catisan, array $coklular): void
    {
        $this->info(sprintf(
            '%d puan satırı bulundu · %d eşlendi (%%%d) · %d eşlenmedi',
            count($satirlar),
            count($eslesen),
            count($satirlar) > 0 ? round(100 * count($eslesen) / count($satirlar)) : 0,
            count($eslesmeyen),
        ));

        if ($catisan !== []) {
            $this->error('AYNI KOD FARKLI PUANLA okundu — ayrıştırma hatası, elle bakılmalı:');

            foreach ($catisan as $c) {
                $this->line('   '.$c);
            }
        }

        if ($coklular !== []) {
            $this->warn(count($coklular).' satır tek hücrede birden çok değer taşıyor — puanı okunmadı:');

            foreach (array_slice($coklular, 0, 10) as $c) {
                $this->line(sprintf('   %-8s %s', $c['kod'], mb_substr($c['baslik'], 0, 88)));
            }
        }

        if ($eslesmeyen === [] || $this->option('karsilastir') !== null) {
            return;
        }

        $this->warn('Kaynak etiketi tahmin edilemeyen satırlar — elle doldurulacak:');

        foreach (array_slice($eslesmeyen, 0, 20) as $s) {
            $this->line(sprintf('   %-8s %-72s %s', $s['kod'], mb_substr((string) $s['baslik'], 0, 72), $s['puan']));
        }

        if (count($eslesmeyen) > 20) {
            $this->line('   … ve '.(count($eslesmeyen) - 20).' satır daha');
        }
    }

    /**
     * @param  list<array<string, mixed>>  $eslesen
     * @param  list<array<string, mixed>>  $eslesmeyen
     */
    private function php(string $pdf, array $eslesen, array $eslesmeyen): string
    {
        $q = fn (string $s): string => "'".str_replace(['\\', "'"], ['\\\\', "\\'"], $s)."'";

        $o = ["<?php\n"];
        $o[] = '/**';
        $o[] = ' * TASLAK — makineyle çıkarıldı, kaynağına karşı OKUNMADI.';
        $o[] = ' *';
        $o[] = ' * Kaynak: '.$pdf;
        $o[] = ' * Üreten: php artisan yonerge:cetvel-tasla';
        $o[] = ' *';
        $o[] = ' * Bu cetveli kullanan eşikler `durum => SartDeposu::TASLAK` taşımalıdır;';
        $o[] = ' * aksi hâlde doğrulanmamış puanlar adaya gösterilir.';

        if ($eslesmeyen !== []) {
            $o[] = ' *';
            $o[] = ' * EŞLENEMEYEN '.count($eslesmeyen).' SATIR aşağıda yorum olarak duruyor —';
            $o[] = ' * kaynak etiketi verilmeden hiçbir faaliyetle eşleşmezler.';
        }

        $o[] = ' */';
        $o[] = '';
        $o[] = 'return [';
        $o[] = "    'maddeler' => [";

        foreach ($eslesen as $m) {
            $o[] = sprintf(
                '        %-10s => [%s, %s, %s, %s],',
                $q((string) $m['kod']),
                "'baslik' => ".$q((string) $m['baslik']),
                "'kategori' => ".$q((string) $m['kategori']),
                "'kaynaklar' => [".implode(', ', array_map($q, $m['kaynaklar'])).']',
                "'puan' => ".$m['puan'],
            );
        }

        foreach ($eslesmeyen as $m) {
            $o[] = sprintf('        // %-8s %s  → %s puan  (kaynak etiketi girilmeli)',
                $m['kod'], $m['baslik'], $m['puan']);
        }

        $o[] = '    ],';
        $o[] = '];';

        return implode("\n", $o)."\n";
    }
}
