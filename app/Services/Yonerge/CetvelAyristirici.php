<?php

namespace App\Services\Yonerge;

/**
 * Yönerge PDF'inin düz metninden puan tablosu satırlarını ayıklar ve her
 * satırın hangi çalışma türüne karşılık geldiğini tahmin eder.
 *
 * Komuttan ayrı durur çünkü asıl sınanması gereken burasıdır: PDF'e ihtiyaç
 * duymadan, elle yazılmış metin parçalarıyla test edilebilir.
 *
 * @phpstan-type Satir array{kod: string, baslik: string, puan: int}
 */
class CetvelAyristirici
{
    /**
     * Bent kodu. Yönergeler dört ayrı numaralandırma kullanıyor ve dördü de
     * korpusta mevcut:
     *
     *   `1.6` `11.1.3` `1.1a.`  noktalı, sonda harf olabilir  (Akdeniz, Afyon)
     *   `00.01.02`              sıfır dolgulu                 (Atatürk)
     *   `B5.` `A1a`             harf önekli                   (Gümüşhane)
     *   `2.` `a)`               yalın                         (çeşitli)
     */
    private const KOD = '(?:\d{1,2}(?:\.\d{1,2})+[a-zçğıöşü]?\.?|[A-ZÇĞİÖŞÜ]\d{1,2}[a-zçğıöşü]?\.?|\d{1,2}\.|[a-zçğıöşü]\))';

    /**
     * Başlık metninden kaynak etiketine eşleme kuralları.
     *
     * Sıra önemli: ilk eşleşen kazanır, bu yüzden özel olan genelden önce
     * gelir ("BKCI kitap bölümü" ile "kitap bölümü" ayrı satırlar).
     * Desenler küçük harfe çevrilmiş metne uygulanır.
     *
     * @var list<array{0: string, 1: string, 2: list<string>}> [desen, kategori, kaynaklar]
     */
    private const KURALLAR = [
        // ── Makale: çeyreklik ayrımı en özel bilgi, önce o denenir ──
        ['/\bq1\b/u', 'makale', ['SCIE/SSCI (Q1)']],
        ['/\bq2\b/u', 'makale', ['SCIE/SSCI (Q2)']],
        ['/\bq3\b/u', 'makale', ['SCIE/SSCI (Q3)']],
        ['/\bq4\b/u', 'makale', ['SCIE/SSCI (Q4)']],
        ['/\bahci\b/u', 'makale', ['AHCI']],
        ['/\besci\b/u', 'makale', ['ESCI / Scopus']],
        ['/\bscopus\b/u', 'makale', ['ESCI / Scopus']],
        ['/tr[\s\-]?dizin|ulakbim|ulakbİm/u', 'makale', ['TR Dizin']],
        ['/(sci|scie|ssci)[^a-z]/u', 'makale', ['SCIE/SSCI (Q1)', 'SCIE/SSCI (Q2)', 'SCIE/SSCI (Q3)', 'SCIE/SSCI (Q4)']],
        ['/diğer.*(hakemli|ulusal).*dergi/u', 'makale', ['Diğer Ulusal Hakemli']],
        ['/uluslararası.*indeks.*dergi/u', 'makale', ['Diğer Uluslararası İndeks']],

        // ── Kitap: bölüm önce, yoksa kitabın kendisi ──
        ['/(bkci|sense).*bölüm/u', 'kitap', ['BKCI / Scopus Kitap Bölümü']],
        ['/bölüm.*(bkci|sense)/u', 'kitap', ['BKCI / Scopus Kitap Bölümü']],
        ['/\b(bkci|sense)\b/u', 'kitap', ['BKCI / Scopus Kitap']],
        ['/kitap.*bölüm|bölüm.*yazarlı/u', 'kitap', ['Kitap Bölümü']],
        ['/çevir/u', 'kitap', ['Çeviri Kitap']],
        ['/kitap/u', 'kitap', ['Uluslararası/Ulusal Kitap']],

        // ── Atıf ──
        ['/atıf/u', 'atif', ['WoS / Scopus']],

        // ── Proje: fon kaynağı ──
        ['/ab çerçeve|horizon|ufuk|avrupa birliği/u', 'proje', ['AB Çerçeve / Ufuk']],
        ['/tübİtak|tubitak/u', 'proje', ['TÜBİTAK']],
        ['/tüseb/u', 'proje', ['TÜSEB']],
        ['/\bbap\b|bilimsel araştırma projeleri birimi|üniversite.*destek/u', 'proje', ['BAP (Üniversite)']],
        ['/sanayi|özel sektör|kamu kurum/u', 'proje', ['Özel Sektör / STK']],
        ['/proje/u', 'proje', ['Diğer Kamu Kurumu']],

        // ── Tez danışmanlığı ──
        ['/doktora.*(tez|danışman)|sanatta yeterlik/u', 'tez_danismanligi', ['Doktora Tezi']],
        ['/yüksek lisans.*(tez|danışman)/u', 'tez_danismanligi', ['Yüksek Lisans Tezi']],

        // ── Bildiri ──
        ['/(sözlü|tam metin).*bildiri|bildiri.*tam metin/u', 'bildiri', ['Uluslararası Tam Metin']],
        ['/özet.*bildiri|poster/u', 'bildiri', ['Uluslararası Özet/Poster']],
        ['/bildiri|kongre|sempozyum/u', 'bildiri', ['Uluslararası Tam Metin']],

        // ── Diğer ──
        ['/patent/u', 'patent', ['Patent (Uluslararası)']],
        ['/ödül/u', 'odul', ['Ulusal Bilim/Sanat Ödülü']],
        ['/editör/u', 'editorluk', ['Dergi Editörlüğü']],
    ];

    /**
     * Tablo satırlarını ayıklar.
     *
     * Yönergeler üç ayrı düzen kullanıyor ve üçü de desteklenmek zorunda:
     *
     *   A) Tek satır      `1.6   ESCI dergide makale                    50`
     *   B) Kod ortada     `      Uluslararası fonlayıcı ... yürütücü veya`
     *                     `6.1                                        200`
     *                     `      koordinatör olarak görev almak`
     *   C) Puan ayrı      `1.1   SCI-Expanded ... dergilerde yayımlanmış özgün`
     *                     `                                           450`
     *                     `      araştırma/derleme makalesi`
     *
     * B ve C düzenlerinde açıklama hücresi sarmalanıyor ve puan kendi satırına
     * düşüyor. Bunlar kaçırılırsa kalem sessizce cetvelden düşer ve adayın
     * puanı sebepsiz eksilir — Akdeniz'de proje bölümü (B) ve makale bölümü (C)
     * tam olarak böyleydi.
     *
     * Puan her düzende kendi satırından okunur; birleştirilen yalnızca AÇIKLAMA
     * metnidir. Açıklamanın fazladan bir cümle kapması zararsızdır (insan
     * okuyor), puanın yanlış satıra oturması zararlı olurdu.
     *
     * @return list<Satir>
     */
    public function satirlar(string $metin): array
    {
        /** @var list<string> $ham */
        $ham = array_map(rtrim(...), preg_split('/\R/u', $metin) ?: []);

        // Önce her satır sınıflandırılır; komşuluk ancak ondan sonra kurulabilir.
        $tipler = array_map(fn (string $ln): array => $this->coz($ln), $ham);
        $satirlar = [];

        // Alt bentler (`a)`, `b)`) üst kalemin kırılımıdır ve tek başına kod
        // taşımaz: yönergede "B8. Ulusal bildiri" altında "a) tam metin" durur.
        // Üst kod hatırlanmazsa iki farklı bölümün `a)` bendi aynı koda düşer
        // ve biri diğerini sessizce ezer.
        $anaKod = '';

        foreach ($tipler as $i => $t) {
            if ($t['tip'] !== 'kod') {
                continue;
            }

            if (preg_match('/^[a-zçğıöşü]$/u', $t['kod']) === 1) {
                $t['kod'] = $anaKod.$t['kod'];
            } else {
                $anaKod = $t['kod'];
            }

            $baslik = $t['baslik'];
            $puan = $t['puan'];

            // C düzeni: puan kendi satırında, hemen altta.
            if ($puan === 0) {
                for ($j = $i + 1; $j <= $i + 2; $j++) {
                    if (($tipler[$j]['tip'] ?? null) === 'sayi') {
                        $puan = $tipler[$j]['puan'];

                        break;
                    }
                }
            }

            // B düzeni: açıklama kod satırında yok, üst komşudan gelir.
            if ($baslik === '' && ($tipler[$i - 1]['tip'] ?? null) === 'metin') {
                $baslik = $tipler[$i - 1]['baslik'];
            }

            // Her iki sarmalanmış düzende de açıklama alttan devam edebilir.
            for ($j = $i + 1; $j <= $i + 2; $j++) {
                if (($tipler[$j]['tip'] ?? null) === 'metin') {
                    $baslik = trim($baslik.' '.$tipler[$j]['baslik']);

                    break;
                }
            }

            if ($baslik === '' || $puan === 0) {
                continue;
            }

            $satirlar[] = ['kod' => $t['kod'], 'baslik' => $this->temizle($baslik), 'puan' => $puan];
        }

        return $satirlar;
    }

    /**
     * Bir satırı sınıflandırır.
     *
     * @return array{tip: string, kod: string, baslik: string, puan: int}
     */
    private function coz(string $ln): array
    {
        $bos = ['tip' => 'yok', 'kod' => '', 'baslik' => '', 'puan' => 0];

        if (trim($ln) === '') {
            return $bos;
        }

        // ÇOK DEĞERLİ HÜCRE: `G3. Ulusal patent/faydalı model/telif  40/20/5`
        // ya da `E1. AB projesi  60/40` (yürütücü/araştırmacı). Tek satırda
        // birden çok kalem var; hangisinin hangi değere ait olduğu ancak metin
        // okunarak anlaşılır. Birini seçmek SESSİZ TAHMİN olurdu, o yüzden
        // ayrı işaretlenir ve puan üretilmez.
        if (preg_match('/^\s*(?:\d{1,3}\s+)?('.self::KOD.')\s+(\S.*?)\s{2,}(\d{1,4}(?:\s*\/\s*\d{1,4})+)\s*$/u', $ln, $m) === 1) {
            return ['tip' => 'coklu', 'kod' => rtrim($m[1], ').'), 'baslik' => trim($m[2]).'  →  '.$m[3], 'puan' => 0];
        }

        // `1.6   Açıklama   50`
        if (preg_match('/^\s*(?:\d{1,3}\s+)?('.self::KOD.')\s+(\S.*?)\s{2,}(\d{1,4})\s*$/u', $ln, $m) === 1) {
            return ['tip' => 'kod', 'kod' => rtrim($m[1], ').'), 'baslik' => $m[2], 'puan' => (int) $m[3]];
        }

        // `6.1                    200`  — açıklama komşu satırlarda
        if (preg_match('/^\s*(?:\d{1,3}\s+)?('.self::KOD.')\s{2,}(\d{1,4})\s*$/u', $ln, $m) === 1) {
            return ['tip' => 'kod', 'kod' => rtrim($m[1], ').'), 'baslik' => '', 'puan' => (int) $m[2]];
        }

        // Kodu olmayan yalnız sayı: bir üstteki kodun puanı (C düzeni).
        if (preg_match('/^\s{20,}(\d{1,4})\s*$/u', $ln, $m) === 1) {
            return ['tip' => 'sayi', 'kod' => '', 'baslik' => '', 'puan' => (int) $m[1]];
        }

        // Kod + metin, puan ayrı satırda (C düzeninin ilk satırı).
        if (preg_match('/^\s*(?:\d{1,3}\s+)?('.self::KOD.')\s+(\S.{15,})$/u', $ln, $m) === 1) {
            return ['tip' => 'kod', 'kod' => rtrim($m[1], ').'), 'baslik' => trim($m[2]), 'puan' => 0];
        }

        // Girintili düz metin: sarmalanmış açıklama parçası olabilir.
        if (preg_match('/^\s{4,}(\D\S*(?:\s+\S+){2,})\s*$/u', $ln, $m) === 1) {
            return ['tip' => 'metin', 'kod' => '', 'baslik' => trim($m[1]), 'puan' => 0];
        }

        return $bos;
    }

    /**
     * Tek hücrede birden çok değer taşıyan satırlar.
     *
     * Bunlar ayıklanan satırlara GİRMEZ — değerlerden birini seçmek sessiz
     * tahmin olurdu. Yerine listelenirler ki elle girilirken gözden kaçmasın.
     *
     * @return list<array{kod: string, baslik: string}>
     */
    public function coklular(string $metin): array
    {
        /** @var list<string> $ham */
        $ham = array_map(rtrim(...), preg_split('/\R/u', $metin) ?: []);
        $coklu = [];

        foreach ($ham as $ln) {
            $t = $this->coz($ln);

            if ($t['tip'] === 'coklu') {
                $coklu[] = ['kod' => $t['kod'], 'baslik' => $t['baslik']];
            }
        }

        return $coklu;
    }

    /**
     * Aynı kodu birden çok kez ayıklanmış satırları teke indirir.
     *
     * Yönergeler puan tablosunu ekte bir kez daha basabiliyor (Atatürk böyle);
     * aynı kod PHP dizisinde iki kez yazılırsa dil SESSİZCE sonuncuyu tutar.
     * Değerler aynıysa sorun yok, FARKLIYSA ayrıştırıcı satırlardan birini
     * yanlış okumuş demektir ve bu görünmek zorunda.
     *
     * @param  list<Satir>  $satirlar
     * @return array{0: list<Satir>, 1: list<string>}
     */
    public function tekille(array $satirlar): array
    {
        $tekil = [];
        $catisan = [];

        foreach ($satirlar as $satir) {
            $kod = $satir['kod'];
            $onceki = $tekil[$kod] ?? null;

            if ($onceki === null) {
                $tekil[$kod] = $satir;

                continue;
            }

            if ($onceki['puan'] !== $satir['puan']) {
                $catisan[] = sprintf('%s → %d ve %d puan', $kod, $onceki['puan'], $satir['puan']);
            }
        }

        return [array_values($tekil), array_values(array_unique($catisan))];
    }

    /** Dipnot işaretlerini ve fazla boşluğu atar. */
    public function temizle(string $baslik): string
    {
        $baslik = preg_replace('/\s*(?:\d\s*,\s*)*\d\s*$/u', '', $baslik) ?? $baslik;

        return trim((string) preg_replace('/\s{2,}/u', ' ', $baslik));
    }

    /**
     * Başlıktan çalışma türünü tahmin eder. Tahmin edilemezse null döner ve
     * satır çağıran tarafından RAPORLANIR — sessizce atılmaz.
     *
     * @return array{kategori: string, kaynaklar: list<string>}|null
     */
    public function esle(string $baslik): ?array
    {
        $dusuk = mb_strtolower($baslik, 'UTF-8');

        foreach (self::KURALLAR as [$desen, $kategori, $kaynaklar]) {
            if (preg_match($desen, $dusuk) === 1) {
                return ['kategori' => $kategori, 'kaynaklar' => $kaynaklar];
            }
        }

        return null;
    }
}
