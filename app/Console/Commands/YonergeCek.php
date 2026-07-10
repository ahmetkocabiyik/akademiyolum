<?php

namespace App\Console\Commands;

use App\Models\Universite;
use App\Models\Yonerge;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

#[Signature('yonerge:cek {--url=https://personel.yok.gov.tr/tr/page/284}')]
#[Description('YÖK sayfasından üniversite yönerge linklerini çeker ve üniversitelere işler.')]
class YonergeCek extends Command
{
    public function handle(): int
    {
        $url = (string) $this->option('url');
        $this->info("Sayfa çekiliyor: {$url}");

        $yanit = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])->timeout(30)->get($url);

        if ($yanit->failed()) {
            $this->error("Sayfa çekilemedi (HTTP {$yanit->status()}).");

            return self::FAILURE;
        }

        $kayitlar = $this->ayristir($yanit->body());

        if ($kayitlar === []) {
            $this->error('Sayfada üniversite/yönerge bağlantısı bulunamadı.');

            return self::FAILURE;
        }

        $this->info(count($kayitlar).' bağlantı bulundu, işleniyor...');

        $mevcut = Universite::all()->keyBy(fn (Universite $u) => $this->anahtarla($u->ad));
        $sehirler = $this->sehirHaritasi();

        $guncellenen = 0;
        $eklenen = 0;

        foreach ($kayitlar as [$ham, $link, $tur]) {
            $anahtar = $this->anahtarla($ham);

            if ($universite = $mevcut->get($anahtar)) {
                $universite->update(['yonerge_url' => $link]);
                $guncellenen++;

                continue;
            }

            $universite = Universite::query()->create([
                'ad' => $this->turkceBaslik($ham),
                'sehir' => $sehirler[$anahtar] ?? null,
                'tur' => $tur,
                'yonerge_url' => $link,
            ]);

            $this->yonergeOlustur($universite);
            $mevcut->put($anahtar, $universite);
            $eklenen++;
        }

        $this->info("Tamamlandı — {$guncellenen} güncellendi, {$eklenen} yeni üniversite eklendi.");

        return self::SUCCESS;
    }

    /**
     * Tablodan [ad, link, tür] üçlülerini çıkarır (2. hücre devlet, 3. hücre vakıf).
     *
     * @return list<array{0: string, 1: string, 2: string}>
     */
    private function ayristir(string $html): array
    {
        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $kayitlar = [];

        foreach ($xpath->query('//table//tr') as $satir) {
            $hucreler = iterator_to_array($xpath->query('./td', $satir));

            foreach (['devlet' => 1, 'vakif' => 2] as $tur => $idx) {
                $hucre = $hucreler[$idx] ?? null;

                if (! $hucre instanceof DOMElement) {
                    continue;
                }

                $baglanti = $xpath->query('.//a[@href]', $hucre)->item(0);

                if ($baglanti instanceof DOMElement) {
                    $ad = trim($baglanti->textContent);
                    $link = trim($baglanti->getAttribute('href'));

                    if ($ad !== '' && str_contains($link, 'yok.gov.tr')) {
                        $kayitlar[] = [$ad, $link, $tur];
                    }
                }
            }
        }

        return $kayitlar;
    }

    /**
     * database/data/universiteler.php dosyasından normalize ad => şehir haritası.
     *
     * @return array<string, string>
     */
    private function sehirHaritasi(): array
    {
        /** @var list<array{0: string, 1: string, 2: string}> $veri */
        $veri = require database_path('data/universiteler.php');

        $harita = [];
        foreach ($veri as [$ad, $sehir]) {
            $harita[$this->anahtarla($ad)] = $sehir;
        }

        return $harita;
    }

    /**
     * Eşleştirme için normalize anahtar (Türkçe karakter katlama + büyük harf).
     */
    private function anahtarla(string $ad): string
    {
        $ad = html_entity_decode($ad, ENT_QUOTES, 'UTF-8');
        $ad = strtr($ad, [
            'İ' => 'I', 'I' => 'I', 'ı' => 'I', 'i' => 'I',
            'Ş' => 'S', 'ş' => 'S', 'Ğ' => 'G', 'ğ' => 'G',
            'Ü' => 'U', 'ü' => 'U', 'Ö' => 'O', 'ö' => 'O', 'Ç' => 'C', 'ç' => 'C',
        ]);
        $ad = mb_strtoupper($ad, 'UTF-8');

        return preg_replace('/\s+/', ' ', trim($ad));
    }

    /**
     * Büyük harfli ham adı düzgün Türkçe başlık biçimine çevirir.
     */
    private function turkceBaslik(string $ad): string
    {
        $ad = html_entity_decode($ad, ENT_QUOTES, 'UTF-8');
        $ad = mb_strtolower(strtr($ad, ['İ' => 'i', 'I' => 'ı', 'Ş' => 'ş', 'Ğ' => 'ğ', 'Ü' => 'ü', 'Ö' => 'ö', 'Ç' => 'ç']), 'UTF-8');
        $ad = preg_replace('/\s+/', ' ', trim($ad));

        return preg_replace_callback('/(^|\s)(\p{L})/u', function (array $m): string {
            $ust = ['i' => 'İ', 'ı' => 'I', 'ş' => 'Ş', 'ğ' => 'Ğ', 'ü' => 'Ü', 'ö' => 'Ö', 'ç' => 'Ç'];

            return $m[1].($ust[$m[2]] ?? mb_strtoupper($m[2], 'UTF-8'));
        }, $ad);
    }

    /**
     * Yeni üniversite için placeholder yönerge oluşturur (deterministik baraj).
     */
    private function yonergeOlustur(Universite $universite): void
    {
        /** @var array<string, array{tavan: int, puanlar: array<string, int>, varsayilan: int}> $kategoriler */
        $kategoriler = config('yonerge.setler.ilahiyat_2026.kategoriler');

        $tohum = crc32($universite->ad);
        $kadro = $tohum % 3 === 0 ? 'dr_ogr_uyesi' : 'docentlik';

        $yonerge = Yonerge::query()->create([
            'universite_id' => $universite->id,
            'anahtar' => str($universite->ad)->slug().'-'.$universite->id,
            'ad' => $universite->ad.' — '.($kadro === 'docentlik' ? 'Doçentlik' : 'Dr. Öğr. Üyesi'),
            'kadro' => $kadro,
            'yil' => 2024 + ($tohum % 3),
            'uak_hedef' => 100,
            'universite_hedef' => 55 + ($tohum % 71),
        ]);

        foreach ($kategoriler as $kategori => $kural) {
            $yonerge->kurallar()->create([
                'kategori' => $kategori,
                'tavan' => $kural['tavan'],
                'varsayilan_puan' => $kural['varsayilan'],
                'puanlar' => $kural['puanlar'],
            ]);
        }
    }
}
