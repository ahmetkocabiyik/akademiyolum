<?php

namespace App\Services\Cv;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

/**
 * CV'deki faaliyet bölümlerinin düzeni: tasarımlı şablonlar için YÖKSİS
 * sırası, resmî şablon için YÖK EK-4A'nın numaralı başlıkları.
 *
 * İki şablon da AYNI faaliyetleri (onaylı ve CV'den çıkarılmamış) basıyor;
 * yalnız gruplama değişiyor.
 */
class CvDuzeni
{
    /** YÖKSİS özgeçmişinin bölüm sırası ve başlıkları. Atıflar tek tek listelenmez. */
    private const YOKSIS_SIRASI = [
        'makale' => 'Makaleler',
        'bildiri' => 'Bildiriler',
        'kitap' => 'Kitaplar ve Kitap Bölümleri',
        'tez_yayini' => 'Tezden Üretilmiş Yayınlar',
        'proje' => 'Projeler',
        'patent' => 'Patentler ve Tescilli Ürünler',
        'tez_danismanligi' => 'Yönetilen Tezler',
        'egitim_ogretim' => 'Verilen Dersler',
        'editorluk' => 'Editörlük ve Hakemlik',
        'odul' => 'Ödüller',
        'idari_gorev' => 'İdari Görevler',
        'sanatsal_etkinlik' => 'Sanatsal Etkinlikler',
        'toplumsal_katki' => 'Toplumsal Katkı',
        'diger' => 'Bilimsel Toplantı Görevleri',
    ];

    public function __construct(private KunyeYazici $yazici) {}

    /**
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @return list<array{baslik: string, kayitlar: list<array{kunye: HtmlString, rozet: string|null}>}>
     */
    public function yoksis(Collection $faaliyetler): array
    {
        $gruplar = $faaliyetler->groupBy(fn (Faaliyet $f) => $f->kategori->value);
        $bolumler = [];

        foreach (self::YOKSIS_SIRASI as $kategori => $baslik) {
            $kayitlar = $gruplar->get($kategori);

            if ($kayitlar === null || $kayitlar->isEmpty()) {
                continue;
            }

            $bolumler[] = [
                'baslik' => $baslik,
                'kayitlar' => $kayitlar->map(fn (Faaliyet $f) => [
                    // Dizin rozeti yalnız yayında anlamlı (SCIE Q1, TR Dizin…); rozet
                    // basıldığı için bildirinin türü künyede tekrarlanmıyor.
                    'kunye' => $this->yazici->yaz($f, kaynakla: false),
                    'rozet' => in_array($f->kategori, Kategori::yayinlar(), true) ? $f->kaynak : null,
                ])->values()->all(),
            ];
        }

        return $bolumler;
    }

    /**
     * YÖK EK-4A madde 6, 7, 8, 9, 11 ve 12 (faaliyetlerden gelenler).
     *
     * Yayınlar 7.1–7.6'ya ortamına (dergi/bildiri/kitap) ve kapsamına
     * (uluslararası/ulusal) göre dağılıyor; kapsamı bilinmeyen ya da formda
     * karşılığı olmayan (ulusal kitap, ansiklopedi maddesi…) yayın 7.6
     * "Diğer Yayınlar"a düşüyor — hiçbir yayın kaybolmuyor.
     *
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @return array{
     *     tezler: array{yuksek_lisans: list<HtmlString>, doktora: list<HtmlString>},
     *     yayinlar: array<string, list<HtmlString>>,
     *     projeler: list<HtmlString>,
     *     idari: list<HtmlString>,
     *     oduller: list<HtmlString>,
     *     dersler: list<array{akademik_yil: string, donem: string, ad: string, teorik: string, uygulama: string, ogrenci: string, lisansustu: bool}>
     * }
     */
    public function ek4a(Collection $faaliyetler, CarbonInterface $bugun): array
    {
        $yayinlar = array_fill_keys(['7.1', '7.2', '7.3', '7.4', '7.5', '7.6'], []);
        $tezler = ['yuksek_lisans' => [], 'doktora' => []];
        $projeler = $idari = $oduller = $dersler = [];

        foreach ($faaliyetler as $f) {
            match ($f->kategori) {
                Kategori::Makale, Kategori::Bildiri, Kategori::Kitap, Kategori::TezYayini => $yayinlar[$this->yayinMaddesi($f)][] = $this->yazici->yaz($f),
                Kategori::TezDanismanligi => match ($f->kaynak) {
                    'Yüksek Lisans Tezi' => $tezler['yuksek_lisans'][] = $this->yazici->yaz($f),
                    'Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi' => $tezler['doktora'][] = $this->yazici->yaz($f),
                    // Jüri / tez izleme üyeliği EK-4A'da yönetilen tez değil.
                    default => null,
                },
                Kategori::Proje => $projeler[] = $this->yazici->yaz($f),
                Kategori::IdariGorev => $idari[] = $this->yazici->yaz($f),
                Kategori::Odul => $oduller[] = $this->yazici->yaz($f),
                Kategori::EgitimOgretim => $this->dersMi($f, $bugun) ? $dersler[] = $this->dersSatiri($f) : null,
                default => null,
            };
        }

        // Yeni akademik yıl önce; yıl içinde Güz, Bahar, Yaz.
        $sira = ['Güz' => 0, 'Bahar' => 1, 'Yaz' => 2];
        usort($dersler, fn (array $a, array $b) => [$b['akademik_yil'], $sira[$a['donem']] ?? 3] <=> [$a['akademik_yil'], $sira[$b['donem']] ?? 3]);

        return compact('tezler', 'yayinlar', 'projeler', 'idari', 'oduller', 'dersler');
    }

    /**
     * EK-4A'nın yayın başlıkları.
     *
     * @return array<string, string>
     */
    public static function yayinBasliklari(): array
    {
        return [
            '7.1' => 'Uluslararası hakemli dergilerde yayınlanan makaleler',
            '7.2' => 'Uluslararası bilimsel toplantılarda sunulan ve bildiri kitabında (Proceeding) basılan bildiriler',
            '7.3' => 'Yazılan uluslararası kitaplar veya kitaplarda bölümler',
            '7.4' => 'Ulusal hakemli dergilerde yayınlanan makaleler',
            '7.5' => 'Ulusal bilimsel toplantılarda sunulan ve bildiri kitabında basılan bildiriler',
            '7.6' => 'Diğer yayınlar',
        ];
    }

    private function yayinMaddesi(Faaliyet $f): string
    {
        return match ($this->yazici->siniflandir($f)) {
            ['dergi', 'uluslararasi'] => '7.1',
            ['bildiri', 'uluslararasi'] => '7.2',
            ['kitap', 'uluslararasi'] => '7.3',
            ['dergi', 'ulusal'] => '7.4',
            ['bildiri', 'ulusal'] => '7.5',
            default => '7.6',
        };
    }

    /**
     * EK-4A madde 12: "son iki yılda verdiği lisans ve lisansüstü düzeyindeki
     * dersler". Akademik yıl girildiyse ona (içinde bulunulan ve bir önceki
     * akademik yıl), girilmediyse faaliyet tarihine (son iki yıl) bakılır.
     * Akreditasyon görevleri ders değil.
     */
    private function dersMi(Faaliyet $f, CarbonInterface $bugun): bool
    {
        if (str_starts_with((string) $f->kaynak, 'Akreditasyon')) {
            return false;
        }

        $buYil = $bugun->month >= 9 ? $bugun->year : $bugun->year - 1;

        if (preg_match('/^(\d{4})/', (string) ($f->meta['akademik_yil'] ?? ''), $m) === 1) {
            return (int) $m[1] >= $buYil - 1;
        }

        return $f->tarih !== null && $f->tarih->greaterThanOrEqualTo($bugun->subYears(2));
    }

    /**
     * @return array{akademik_yil: string, donem: string, ad: string, teorik: string, uygulama: string, ogrenci: string, lisansustu: bool}
     */
    private function dersSatiri(Faaliyet $f): array
    {
        $meta = (array) ($f->meta ?? []);

        return [
            'akademik_yil' => (string) ($meta['akademik_yil'] ?? ($f->tarih !== null ? self::akademikYil($f->tarih) : '')),
            'donem' => (string) ($meta['yariyil'] ?? ''),
            'ad' => $f->baslik,
            'teorik' => (string) ($meta['teorik'] ?? ''),
            'uygulama' => (string) ($meta['uygulama'] ?? ''),
            'ogrenci' => (string) ($meta['ogrenci_sayisi'] ?? ''),
            'lisansustu' => $f->kaynak === 'Lisansüstü Ders',
        ];
    }

    private static function akademikYil(CarbonInterface $tarih): string
    {
        $baslangic = $tarih->month >= 9 ? $tarih->year : $tarih->year - 1;

        return $baslangic.'-'.($baslangic + 1);
    }
}
