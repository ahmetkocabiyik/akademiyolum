<?php

namespace App\Services\AI;

use App\Enums\JuriAdimi;
use App\Enums\JuriAgirligi;
use App\Enums\JuriSapkasi;
use App\Enums\JuriSertligi;
use App\Models\JuriRaporu;
use App\Models\User;

/**
 * Dosyayı jüri raporuna çevirir ve raporu saklar.
 *
 * İŞ BÖLÜMÜ: ölçüm ve karar {@see JuriDosyasi}'ndan (şart ağacı motoru), metin
 * YZ'den gelir. YZ'ye "şu puanı hesapla" denmiyor, "şu ölçümü jüri gözüyle
 * yorumla" deniyor. Rapor iskeleti de sabit ({@see JuriAdimi}); YZ yalnızca her
 * adımın içeriğini ve ağırlığını yazar.
 */
class JuriRaporcu
{
    public function __construct(
        private readonly SohbetSaglayici $saglayici,
        private readonly JuriDosyasi $dosyalar,
    ) {}

    /**
     * @throws SaglayiciException Sağlayıcıya ulaşılamazsa ya da yanıt okunamazsa.
     */
    public function uret(
        User $user,
        string $universite,
        string $hedefKadro,
        JuriSapkasi $sapka,
        JuriSertligi $sertlik,
        ?string $birim = null,
    ): JuriRaporu {
        $dosya = $this->dosyalar->hazirla($user, $universite, $hedefKadro, $birim);

        $yanit = $this->saglayici->yanitla(
            $this->sistemPrompt($sapka, $sertlik),
            [['rol' => 'user', 'icerik' => $this->istem($dosya)]],
        );

        $cozulen = $this->coz($yanit);

        return $user->juriRaporlari()->create([
            'universite' => $dosya->universite,
            'hedef_kadro' => $dosya->hedefKadro,
            'birim' => $dosya->birim,
            'alan' => $dosya->alan,
            'sapka' => $sapka,
            'sertlik' => $sertlik,
            'karar' => $dosya->karar,
            'olcumler' => $dosya->olcumler,
            'adimlar' => $cozulen['adimlar'],
            'ozet' => $cozulen['ozet'],
        ]);
    }

    private function sistemPrompt(JuriSapkasi $sapka, JuriSertligi $sertlik): string
    {
        $adimlar = collect(JuriAdimi::cases())
            ->map(fn (JuriAdimi $adim, int $i) => sprintf(
                '%d. "%s" — %s: %s',
                $i + 1,
                $adim->value,
                $adim->baslik(),
                $adim->istem(),
            ))
            ->implode("\n");

        $agirliklar = collect(JuriAgirligi::cases())
            ->map(fn (JuriAgirligi $a) => $a->value)
            ->implode(' · ');

        return <<<PROMPT
        {$sapka->persona()}

        {$sertlik->ton()}

        Sana bir adayın akademik dosyası, hedef yönergenin koşulları ve bu koşulların
        MOTOR TARAFINDAN ÖLÇÜLMÜŞ sonuçları verilecek. Görevin on adımlık bir jüri
        raporu yazmak. Tamamı Türkçe olacak.

        KESİN KURALLAR
        - Verilen sayıları değiştirmeyeceksin, yeni puan hesaplamayacaksın. Dosyada
          olmayan bir yayın, atıf ya da puan UYDURMAYACAKSIN.
        - "Karara bağlanamadı" işaretli bir koşul, koşulun SAĞLANMADIĞI anlamına
          gelmez: adayın verisi eksik olduğu için ölçülemiyor. Böyle koşullarda önce
          hangi bilginin girilmesi gerektiğini söyleyeceksin.
        - KARAR sana verilir; onu gerekçelendirirsin, değiştirmezsin.
        - Her adımın içeriği Markdown olacak (tablo, kalın metin, liste serbest).
          Başlık (#) KULLANMA; başlıkları ekran kendisi basıyor.

        ADIMLAR
        {$adimlar}

        YANIT BİÇİMİ
        Yalnızca geçerli JSON döndür, başka hiçbir metin ekleme:
        {
          "adimlar": {
            "<adim_anahtari>": {"agirlik": "<{$agirliklar}>", "icerik": "<markdown>"}
          },
          "ozet": "<adaya son söz: en çok 3 cümle>"
        }
        PROMPT;
    }

    private function istem(JuriDosya $dosya): string
    {
        $olcumler = collect($dosya->olcumler)
            ->map(fn (array $o) => "- {$o['etiket']}: {$o['mevcut']} / {$o['gerekli']} (%{$o['oran']})")
            ->implode("\n") ?: '- Yönerge koşullarını sayıyla değil adetle/koşulla ifade ediyor.';

        return <<<ISTEM
        {$dosya->metin}

        ÖLÇÜM
        {$olcumler}

        KARAR (motordan): {$dosya->karar->etiket()} — {$dosya->karar->aciklama()}

        Şimdi on adımlık jüri raporunu yaz.
        ISTEM;
    }

    /**
     * Yanıtı JSON olarak çözer.
     *
     * Model JSON'u kod bloğuna sarabiliyor; sarmalayıcı atılır. Tek bir adım
     * bile okunamazsa rapor boş kutu dolu bir ekran olarak kaydedilmiyor —
     * hata adaya söylenir.
     *
     * @return array{adimlar: array<string, array{agirlik: string, icerik: string}>, ozet: string}
     *
     * @throws SaglayiciException
     */
    private function coz(string $yanit): array
    {
        $ham = trim($yanit);

        if (str_starts_with($ham, '```')) {
            $ham = (string) preg_replace('/^```[a-z]*\s*|\s*```$/u', '', $ham);
        }

        $veri = json_decode($ham, true);

        if (! is_array($veri) || ! is_array($veri['adimlar'] ?? null)) {
            throw SaglayiciException::raporOkunamadi();
        }

        $adimlar = [];

        foreach (JuriAdimi::cases() as $adim) {
            $kayit = $veri['adimlar'][$adim->value] ?? null;

            if (! is_array($kayit) || blank($kayit['icerik'] ?? null)) {
                continue;
            }

            $adimlar[$adim->value] = [
                'agirlik' => (JuriAgirligi::tryFrom((string) ($kayit['agirlik'] ?? '')) ?? JuriAgirligi::Notr)->value,
                'icerik' => trim((string) $kayit['icerik']),
            ];
        }

        if ($adimlar === []) {
            throw SaglayiciException::raporOkunamadi();
        }

        return [
            'adimlar' => $adimlar,
            'ozet' => trim((string) ($veri['ozet'] ?? '')),
        ];
    }
}
