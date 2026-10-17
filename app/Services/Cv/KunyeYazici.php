<?php

namespace App\Services\Cv;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use Illuminate\Support\HtmlString;

/**
 * Bir faaliyetin CV'deki künye satırı ve yayınların EK-4A sınıflandırması.
 *
 * Künye APA'ya yakın Türkçe biçimde: "Yazarlar (Yıl). Başlık. Dergi,
 * Cilt(Sayı), Sayfa. doi: …". Eksik parça yazılmıyor; dergi ya da kitap adı
 * italik. Yapılandırılmış alan girilmemiş içe aktarılmış kayıtta ham künyenin
 * ilk parçası ("Dergi, vol. 13, no. 1, pp. 313–343") yayın yeri olarak
 * kullanılıyor.
 */
class KunyeYazici
{
    /** Dergi makalesi sayılan kaynaklar (uluslararası). */
    private const ULUSLARARASI_DERGI = ['SCIE', 'SSCI', 'AHCI', 'ESCI', 'Scopus', 'Diğer Uluslararası İndeks'];

    /** Dergi makalesi sayılan kaynaklar (ulusal). */
    private const ULUSAL_DERGI = ['TR Dizin', 'Diğer Ulusal Hakemli'];

    /**
     * @param  bool  $kaynakla  Bildiride kaynak türünü ("Uluslararası Tam Metin") künyeye yaz.
     *                          Tasarımlı şablon onu rozet olarak ayrıca basıyor.
     */
    public function yaz(Faaliyet $f, bool $kaynakla = true): HtmlString
    {
        $meta = (array) ($f->meta ?? []);
        $yil = $f->tarih?->year;
        $basi = collect([
            $f->yazarlar ? e($f->yazarlar) : null,
            $yil !== null ? "({$yil})" : null,
        ])->filter()->implode(' ');

        $parcalar = match ($f->kategori) {
            Kategori::Makale, Kategori::TezYayini => [
                $basi, e($f->baslik), $this->yayinYeri($f, $meta['dergi'] ?? null, self::ciltSayiSayfa($meta)),
            ],
            Kategori::Bildiri => [
                $basi, e($f->baslik), $this->yayinYeri($f, $meta['toplanti'] ?? null, self::birlestir([$meta['yer'] ?? null, self::sayfa($meta)])),
                $kaynakla && $f->kaynak ? '('.e($f->kaynak).')' : null,
            ],
            Kategori::Kitap => $this->kitap($f, $basi, $meta),
            Kategori::Proje => [
                e($f->baslik),
                self::birlestir([$meta['kurum'] ?? $f->kaynak, isset($meta['proje_no']) ? 'Proje No: '.$meta['proje_no'] : null, $this->rolEtiketi($f)], escape: true),
                self::donem($f, $meta['bitis'] ?? null),
            ],
            Kategori::TezDanismanligi => [
                collect([isset($meta['ogrenci']) ? e($meta['ogrenci']) : null, $yil !== null ? "({$yil})" : null])->filter()->implode(' ') ?: null,
                e($f->baslik),
                self::birlestir([$f->kaynak, $meta['universite'] ?? null, $this->rolEtiketi($f)], escape: true),
            ],
            Kategori::Editorluk => [
                e($f->baslik),
                self::birlestir([$meta['yayin'] ?? null, $f->kaynak], escape: true),
                self::donem($f, $meta['bitis'] ?? null),
            ],
            Kategori::EgitimOgretim => [
                e($f->baslik),
                self::birlestir([
                    $f->kaynak,
                    self::birlestir([$meta['akademik_yil'] ?? null, $meta['yariyil'] ?? null], ' '),
                    self::saat($meta),
                    filled($meta['ogrenci_sayisi'] ?? null) ? $meta['ogrenci_sayisi'].' öğrenci' : null,
                ], escape: true) ?? ($yil !== null ? (string) $yil : null),
            ],
            Kategori::IdariGorev => [
                e($f->baslik), isset($meta['kurum']) ? e($meta['kurum']) : null, self::donem($f, $meta['bitis'] ?? null),
            ],
            default => [
                e($f->baslik),
                self::birlestir([$meta['patent_no'] ?? null, $meta['kurum'] ?? null, $meta['toplanti'] ?? null, $meta['yer'] ?? null, $f->kaynak], escape: true),
                $yil !== null ? (string) $yil : null,
            ],
        };

        $metin = collect($parcalar)->filter(fn (?string $p) => filled($p))
            ->map(fn (string $p) => rtrim($p, '.'))
            ->implode('. ').'.';

        if (filled($meta['doi'] ?? null)) {
            $metin .= ' doi: '.e($meta['doi']);
        }

        return new HtmlString($metin);
    }

    /**
     * Yayının EK-4A ortamı ve kapsamı: ['dergi'|'bildiri'|'kitap'|null, 'uluslararasi'|'ulusal'|null].
     *
     * Kapsam önce `kaynak`tan (dizin), o boşsa içe aktarılan ham künyenin
     * sonundaki "Uluslararası / Ulusal" etiketinden okunuyor (AVESİS bunu yazıyor).
     *
     * @return array{0: 'dergi'|'bildiri'|'kitap'|null, 1: 'uluslararasi'|'ulusal'|null}
     */
    public function siniflandir(Faaliyet $f): array
    {
        $kaynak = (string) $f->kaynak;

        $ortam = match ($f->kategori) {
            Kategori::Makale => 'dergi',
            Kategori::Bildiri => 'bildiri',
            Kategori::Kitap => 'kitap',
            Kategori::TezYayini => match (true) {
                str_contains($kaynak, 'Bildiri') => 'bildiri',
                str_contains($kaynak, 'Kitap') => 'kitap',
                self::ileBaslar($kaynak, [...self::ULUSLARARASI_DERGI, ...self::ULUSAL_DERGI]) => 'dergi',
                default => null,
            },
            default => null,
        };

        $kapsam = match (true) {
            $kaynak === '' => self::hamKunyeKapsami($f),
            // "Uluslararası/Ulusal Kitap": yönerge ikisini birlikte puanlıyor, kapsam bilinmiyor.
            str_contains($kaynak, 'Uluslararası/Ulusal') => null,
            self::ileBaslar($kaynak, self::ULUSAL_DERGI), str_contains($kaynak, 'Ulusal)'), str_starts_with($kaynak, 'Ulusal') => 'ulusal',
            self::ileBaslar($kaynak, self::ULUSLARARASI_DERGI), str_contains($kaynak, 'Uluslararası'), str_contains($kaynak, 'BKCI'), str_contains($kaynak, 'CPCI') => 'uluslararasi',
            default => null,
        };

        return [$ortam, $kapsam];
    }

    /**
     * @param  array<string, mixed>  $meta
     * @return list<string|null>
     */
    private function kitap(Faaliyet $f, string $basi, array $meta): array
    {
        $yayin = self::birlestir([$meta['yer'] ?? null, $meta['yayinevi'] ?? null], ': ', escape: true);
        $bolumMu = filled($meta['kitap_adi'] ?? null);

        if ($bolumMu) {
            $editor = filled($meta['editor'] ?? null) ? e($meta['editor']).' (Ed.), ' : '';
            $sayfa = filled($meta['sayfa'] ?? null) ? ' (s. '.e($meta['sayfa']).')' : '';

            return [$basi, e($f->baslik), $editor.'<i>'.e($meta['kitap_adi']).'</i>'.$sayfa, $yayin];
        }

        return [
            $basi,
            '<i>'.e($f->baslik).'</i>',
            $yayin ?: $this->hamYayinYeri($f),
            filled($meta['isbn'] ?? null) ? 'ISBN: '.e($meta['isbn']) : null,
        ];
    }

    /**
     * Dergi / toplantı adı italik, ardından ayrıntı. Ad girilmemişse ham künye.
     */
    private function yayinYeri(Faaliyet $f, ?string $ad, ?string $ayrinti): ?string
    {
        if (blank($ad)) {
            return $this->hamYayinYeri($f) ?? $ayrinti;
        }

        return '<i>'.e($ad).'</i>'.($ayrinti ? ', '.$ayrinti : '');
    }

    /**
     * İçe aktarılan ham künyenin ilk parçası; sistem dipnotları ve kapsam
     * etiketi atılır ("Dergi, vol. 13, no. 1, pp. 313–343 · Uluslararası").
     */
    private function hamYayinYeri(Faaliyet $f): ?string
    {
        $ham = (string) ($f->meta['kunye'] ?? '');

        if ($ham === '') {
            return null;
        }

        $ilk = trim(explode(' · ', $ham)[0]);

        return $ilk === '' ? null : e($ilk);
    }

    /**
     * @return 'uluslararasi'|'ulusal'|null
     */
    private static function hamKunyeKapsami(Faaliyet $f): ?string
    {
        $ham = (string) ($f->meta['kunye'] ?? '');

        return match (true) {
            preg_match('/·\s*\d*\s*Uluslararası\s*$/u', $ham) === 1 => 'uluslararasi',
            preg_match('/·\s*\d*\s*Ulusal\s*$/u', $ham) === 1 => 'ulusal',
            default => null,
        };
    }

    private function rolEtiketi(Faaliyet $f): ?string
    {
        return $f->rol !== null ? ($f->kategori->roller()[$f->rol] ?? null) : null;
    }

    /**
     * @param  array<string, mixed>  $meta
     */
    private static function ciltSayiSayfa(array $meta): ?string
    {
        $cilt = filled($meta['cilt'] ?? null) ? e($meta['cilt']) : '';
        $sayi = filled($meta['sayi'] ?? null) ? '('.e($meta['sayi']).')' : '';

        return self::birlestir([$cilt.$sayi ?: null, self::sayfa($meta)]);
    }

    /**
     * @param  array<string, mixed>  $meta
     */
    private static function sayfa(array $meta): ?string
    {
        return filled($meta['sayfa'] ?? null) ? e($meta['sayfa']) : null;
    }

    /**
     * Haftalık ders saati "teorik+uygulama saat" (ör. "2+0 saat").
     *
     * @param  array<string, mixed>  $meta
     */
    private static function saat(array $meta): ?string
    {
        $teorik = $meta['teorik'] ?? null;
        $uygulama = $meta['uygulama'] ?? null;

        if (blank($teorik) && blank($uygulama)) {
            return null;
        }

        return ($teorik ?: '0').'+'.($uygulama ?: '0').' saat';
    }

    /**
     * Başlangıç yılı – bitiş yılı; bitiş yoksa "devam ediyor".
     */
    private static function donem(Faaliyet $f, ?string $bitis): ?string
    {
        if ($f->tarih === null) {
            return null;
        }

        $son = filled($bitis) ? substr($bitis, 0, 4) : 'devam ediyor';

        return $f->tarih->year.'–'.$son;
    }

    /**
     * @param  list<string|null>  $parcalar
     */
    private static function birlestir(array $parcalar, string $ayrac = ', ', bool $escape = false): ?string
    {
        $dolu = array_values(array_filter($parcalar, fn (?string $p) => filled($p)));

        if ($escape) {
            $dolu = array_map(fn (string $p) => e($p), $dolu);
        }

        return $dolu === [] ? null : implode($ayrac, $dolu);
    }

    /**
     * @param  list<string>  $onekler
     */
    private static function ileBaslar(string $metin, array $onekler): bool
    {
        foreach ($onekler as $onek) {
            if (str_starts_with($metin, $onek)) {
                return true;
            }
        }

        return false;
    }
}
