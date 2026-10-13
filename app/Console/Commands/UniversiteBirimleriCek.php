<?php

namespace App\Console\Commands;

use App\Models\Universite;
use App\Services\Kurum\BirimKatalogu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Üniversitelerin fakülte/yüksekokul ve programlarını YÖK Atlas tercih
 * kılavuzundan çeker, database/data/universite-birimleri.json'a yazar.
 *
 * Dosya repoya girer, UniversiteBirimiSeeder onu tabloya yükler; yani bu
 * komut deploy'da DEĞİL, yılda bir (yeni kılavuz yayımlanınca) elle çalışır.
 *
 * Kaynak, o yıl öğrenci alan programları listeler: öğrenci almayan
 * fakülte, enstitü ve araştırma merkezleri listede yoktur. Ekranlar bu
 * yüzden serbest metne izin veriyor.
 */
class UniversiteBirimleriCek extends Command
{
    public const ADRES = 'https://yokatlas.yok.gov.tr/api/tercih-kilavuz/search';

    /** Sadeleştirmenin yakalayamadığı ad farkları: atlas anahtarı → listemizdeki ad. */
    private const TAKMA_ADLAR = [
        'istanbulnişantaşıüniversitesi' => 'Nişantaşı Üniversitesi',
    ];

    /** Fakülte adlarında büyük harf kalması gereken kısaltmalar. */
    private const KISALTMALAR = ['asbü' => 'ASBÜ', 'itü' => 'İTÜ', 'kktc' => 'KKTC', 'odtü' => 'ODTÜ'];

    protected $signature = 'universite:birimleri-cek
        {--sayfa=2000 : Bir istekte alınacak program sayısı}
        {--dosya= : Çıktı dosyası (varsayılan database/data/universite-birimleri.json)}';

    protected $description = 'YÖK Atlas\'tan üniversitelerin fakülte ve programlarını çeker (database/data/universite-birimleri.json)';

    public function handle(): int
    {
        $eslesme = $this->universiteAnahtarlari();
        /** @var array<string, array<string, array<string, true>>> $veri */
        $veri = [];
        /** @var array<string, true> $eslesmeyen */
        $eslesmeyen = [];
        $sayfa = 0;
        $toplam = 0;

        do {
            $yanit = $this->sayfa($sayfa);

            foreach ($yanit['content'] as $program) {
                if (! is_array($program)) {
                    continue;
                }

                $toplam++;
                $universite = $eslesme[self::anahtar((string) $program['universiteAdi'])] ?? null;

                if ($universite === null) {
                    $eslesmeyen[(string) $program['universiteAdi']] = true;

                    continue;
                }

                $fakulte = self::baslikHarfi((string) $program['fymkAdi']);
                $bolum = trim((string) $program['birimGrupAdi']);

                if ($fakulte !== '' && $bolum !== '') {
                    $veri[$universite][$fakulte][$bolum] = true;
                }
            }

            $sayfa++;
        } while (! $yanit['last']);

        $this->yaz($veri);

        $this->info(sprintf('%d program okundu; %d üniversite, %d fakülte/yüksekokul yazıldı.',
            $toplam, count($veri), array_sum(array_map('count', $veri))));

        if ($eslesmeyen !== []) {
            $this->warn('Listemizde karşılığı bulunmayan üniversiteler (atlandı):');
            foreach (BirimKatalogu::sirala(array_keys($eslesmeyen)) as $ad) {
                $this->line("  - {$ad}");
            }
        }

        $eksik = array_diff(array_values($eslesme), array_keys($veri));
        if ($eksik !== []) {
            $this->warn('Atlas\'ta programı bulunmayan üniversitelerimiz:');
            foreach (BirimKatalogu::sirala(array_values(array_unique($eksik))) as $ad) {
                $this->line("  - {$ad}");
            }
        }

        return self::SUCCESS;
    }

    /**
     * @return array{content: array<mixed>, last: bool}
     */
    private function sayfa(int $sayfa): array
    {
        $yanit = Http::acceptJson()->timeout(120)->retry(3, 2000)->post(self::ADRES, [
            'filters' => (object) [],
            'page' => $sayfa,
            'size' => (int) $this->option('sayfa'),
        ]);

        $json = $yanit->json();

        if (! is_array($json) || ! is_array($json['content'] ?? null)) {
            throw new RuntimeException("YÖK Atlas beklenmeyen yanıt verdi (sayfa {$sayfa}).");
        }

        return ['content' => $json['content'], 'last' => (bool) ($json['last'] ?? true)];
    }

    /**
     * Karşılaştırma anahtarı → listemizdeki ad.
     *
     * @return array<string, string>
     */
    private function universiteAnahtarlari(): array
    {
        $adlar = Universite::query()->pluck('ad');

        return $adlar
            ->mapWithKeys(fn (string $ad): array => [self::anahtar($ad) => $ad])
            ->merge(array_filter(self::TAKMA_ADLAR, fn (string $ad): bool => $adlar->contains($ad)))
            ->all();
    }

    /**
     * @param  array<string, array<string, array<string, true>>>  $veri
     */
    private function yaz(array $veri): void
    {
        $cikti = [];

        foreach (BirimKatalogu::sirala(array_keys($veri)) as $universite) {
            foreach (BirimKatalogu::sirala(array_keys($veri[$universite])) as $fakulte) {
                $cikti[$universite][$fakulte] = BirimKatalogu::sirala(array_map('strval', array_keys($veri[$universite][$fakulte])));
            }
        }

        file_put_contents(
            $this->option('dosya') ?: BirimKatalogu::veriDosyasi(),
            json_encode($cikti, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR)."\n",
        );
    }

    /**
     * Atlas "ABDULLAH GÜL ÜNİVERSİTESİ (KAYSERİ)" yazıyor, biz "Abdullah Gül
     * Üniversitesi": parantez (şehir) atılır, Türkçe küçük harfe indirilir.
     * Şapka ve harf dışı her şey de atılır: "BEZM-İ ÂLEM" ile "Bezmiâlem",
     * "CELÂL" ile "Celal" aynı anahtara düşsün.
     */
    public static function anahtar(string $ad): string
    {
        $sade = strtr(self::kucukHarf(self::sadelestir($ad)), ['â' => 'a', 'î' => 'i', 'û' => 'u']);

        return (string) preg_replace('/[^\p{L}\p{N}]/u', '', $sade);
    }

    /**
     * "FEN-EDEBİYAT FAKÜLTESİ (Kahta)" → "Fen-Edebiyat Fakültesi". Parantez
     * içi yerleşke adı; aynı fakülte iki ayrı satıra bölünmesin diye atılır.
     */
    public static function baslikHarfi(string $ad): string
    {
        $kelimeler = explode(' ', self::kucukHarf(self::sadelestir($ad)));

        foreach ($kelimeler as $i => $kelime) {
            if ($i > 0 && in_array($kelime, ['ve', 'ile', 'için'], true)) {
                continue;
            }

            $kelimeler[$i] = implode('-', array_map(self::ilkHarfBuyuk(...), explode('-', $kelime)));
        }

        return implode(' ', $kelimeler);
    }

    private static function sadelestir(string $ad): string
    {
        return trim((string) preg_replace(['/\s*\([^)]*\)/u', '/\s+/u'], ['', ' '], $ad));
    }

    /** mb_strtolower "I"yı "i"ye çeviriyor; Türkçede "ı" olmalı. */
    private static function kucukHarf(string $metin): string
    {
        return mb_strtolower(strtr($metin, ['I' => 'ı', 'İ' => 'i']));
    }

    private static function ilkHarfBuyuk(string $kelime): string
    {
        if ($kelime === '' || isset(self::KISALTMALAR[$kelime])) {
            return self::KISALTMALAR[$kelime] ?? $kelime;
        }

        $ilk = mb_substr($kelime, 0, 1);
        $buyuk = strtr($ilk, ['i' => 'İ', 'ı' => 'I']);

        return ($buyuk === $ilk ? mb_strtoupper($ilk) : $buyuk).mb_substr($kelime, 1);
    }
}
