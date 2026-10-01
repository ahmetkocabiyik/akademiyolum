<?php

namespace App\Services\AI;

use App\Enums\JuriKarari;
use App\Enums\TemelAlan;
use App\Models\BeyanOnayi;
use App\Models\Faaliyet;
use App\Models\User;
use App\Services\Scoring\Sart\Durum;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Scoring\Sart\SartSonucu;
use Illuminate\Support\Collection;
use RuntimeException;

/**
 * Adayın dosyasını, hedef yönergeye karşı ÖLÇÜLMÜŞ hâlde hazırlar.
 *
 * Bu sınıfın tek işi YZ'ye verilecek gerçekleri üretmek. Puan, koşul sonucu ve
 * karar şart ağacı motorundan geliyor; YZ'nin bunları yeniden hesaplamasına
 * izin verilmiyor. Jüri raporu bir LLM'in aritmetiğine bırakılsaydı aynı dosya
 * için Yönerge Analizi ile çelişen sayılar üretirdi.
 *
 * @see JuriRaporcu  Dosyayı rapora çeviren katman.
 */
class JuriDosyasi
{
    /** Prompta yazılacak en fazla faaliyet satırı. */
    private const FAALIYET_SINIRI = 60;

    public function __construct(private readonly SartDeposu $depo) {}

    /**
     * @throws RuntimeException Hedef için doğrulanmış bir eşik yoksa.
     */
    public function hazirla(User $user, string $universite, string $hedefKadro, ?string $birim = null): JuriDosya
    {
        $alan = ($user->temel_alan ?? TemelAlan::Sosyal)->value;
        $esik = $this->depo->bul($universite, $hedefKadro, $alan, $birim);

        if ($esik === null) {
            throw new RuntimeException("Jüri analizi için eşik bulunamadı: {$universite} · {$hedefKadro} · {$alan}");
        }

        $faaliyetler = $user->faaliyetler()->onaylanmis()->get();
        $sonuc = $this->depo->degerlendir(
            $esik,
            $faaliyetler,
            $user->sartProfili($faaliyetler),
            $this->beyanOnaylari($user, (string) $esik['anahtar']),
        );

        return new JuriDosya(
            universite: $universite,
            hedefKadro: $hedefKadro,
            birim: $birim,
            alan: $alan,
            karar: $this->karar($sonuc),
            olcumler: $this->olcumler($sonuc),
            metin: $this->metin($user, $esik, $sonuc, $faaliyetler),
        );
    }

    /**
     * Kararı motor verir, YZ değil.
     */
    private function karar(SartSonucu $sonuc): JuriKarari
    {
        return match ($sonuc->durum) {
            Durum::Saglandi => JuriKarari::Basvurabilir,
            Durum::Belirsiz => JuriKarari::Sinirda,
            Durum::Saglanmadi => JuriKarari::Basvuramaz,
        };
    }

    /**
     * Raporun tepesindeki çubuklar: ölçülebilen her asgari koşul.
     *
     * Ölçülemeyen koşullar (beyan, cetvel eksiği) çubuk almıyor — "0 / 0" diye
     * bir çubuk adaya koşulun sıfırlandığını söylerdi.
     *
     * @return list<array{etiket: string, mevcut: int, gerekli: int, oran: int}>
     */
    private function olcumler(SartSonucu $sonuc): array
    {
        $olcumler = [];
        $toplam = $sonuc->rolile('toplam');

        if ($toplam !== null && $toplam->gerekli !== null && $toplam->mevcut !== null) {
            $olcumler[] = [
                'etiket' => 'Toplam puan',
                'mevcut' => (int) $toplam->mevcut,
                'gerekli' => (int) $toplam->gerekli,
                'oran' => $toplam->oran(),
            ];
        }

        foreach ($sonuc->kosullar() as $kosul) {
            if ($kosul === $toplam || $kosul->gerekli === null || $kosul->mevcut === null) {
                continue;
            }

            $olcumler[] = [
                'etiket' => $kosul->aciklama,
                'mevcut' => (int) $kosul->mevcut,
                'gerekli' => (int) $kosul->gerekli,
                'oran' => $kosul->oran(),
            ];
        }

        return $olcumler;
    }

    /**
     * Adayın işaretlediği beyan onayları — motor bunları sağlanmış sayıyor.
     *
     * @return list<string>
     */
    private function beyanOnaylari(User $user, string $esikAnahtari): array
    {
        $anahtarlar = [];

        $onaylar = BeyanOnayi::query()
            ->where('user_id', $user->id)
            ->where('esik_anahtari', $esikAnahtari)
            ->get();

        foreach ($onaylar as $onay) {
            $anahtarlar[] = $onay->kosul_anahtari;
        }

        return $anahtarlar;
    }

    /**
     * @param  array<string, mixed>  $esik
     * @param  Collection<int, Faaliyet>  $faaliyetler
     */
    private function metin(User $user, array $esik, SartSonucu $sonuc, Collection $faaliyetler): string
    {
        $profil = $this->profilMetni($user, $esik);
        $envanter = $this->envanterMetni($faaliyetler);
        $kosullar = $this->kosulMetni($sonuc);
        $olcum = $this->olcumMetni();

        return <<<METIN
        ADAY PROFİLİ
        {$profil}

        FAALİYET ENVANTERİ
        {$envanter}

        YÖNERGE KOŞULLARI — MOTOR SONUCU
        {$kosullar}

        {$olcum}
        METIN;
    }

    /**
     * @param  array<string, mixed>  $esik
     */
    private function profilMetni(User $user, array $esik): string
    {
        $satirlar = [
            '- Ad: '.$user->name,
            '- Unvan: '.($user->unvan ?? 'belirtilmemiş'),
            '- Üniversite: '.($user->universite ?? 'belirtilmemiş'),
            '- Birim: '.($user->birim ?: 'belirtilmemiş'),
            '- Bölüm: '.($user->bolum ?? 'belirtilmemiş'),
            '- Temel alan: '.($user->temel_alan?->label() ?? 'belirtilmemiş'),
            '- Profil doluluğu: '.$user->profilDoluluk().'%',
            '- Değerlendirilen yönerge: '.$esik['universite'].' · '.$esik['kadro']
                .($esik['birim'] !== null ? ' · '.$esik['birim'] : ''),
            '- Dayandığı cetvel: '.$esik['cetvel'],
        ];

        return implode("\n", $satirlar);
    }

    /**
     * @param  Collection<int, Faaliyet>  $faaliyetler
     */
    private function envanterMetni(Collection $faaliyetler): string
    {
        if ($faaliyetler->isEmpty()) {
            return '- Onaylı faaliyet yok.';
        }

        $satirlar = [];

        foreach ($faaliyetler->groupBy(fn (Faaliyet $f) => $f->kategori->label()) as $kategori => $grup) {
            $satirlar[] = "- {$kategori}: {$grup->count()} kayıt";
        }

        $satirlar[] = '';
        $satirlar[] = 'Kayıtlar (tür · tarih · kaynak/kademe · rol):';

        foreach ($faaliyetler->take(self::FAALIYET_SINIRI) as $faaliyet) {
            $satirlar[] = sprintf(
                '- %s | %s · %s · %s · %s',
                mb_strimwidth($faaliyet->baslik, 0, 120, '…'),
                $faaliyet->tur ?: $faaliyet->kategori->label(),
                $faaliyet->tarih?->format('Y-m') ?? 'tarihsiz',
                $faaliyet->kaynak ?: 'kaynak girilmemiş',
                $faaliyet->rol ?: 'rol girilmemiş',
            );
        }

        if ($faaliyetler->count() > self::FAALIYET_SINIRI) {
            $satirlar[] = '- (… '.($faaliyetler->count() - self::FAALIYET_SINIRI).' kayıt daha)';
        }

        return implode("\n", $satirlar);
    }

    /**
     * Koşul ağacını düz metne çevirir; belirsizliğin GEREKÇESİ de taşınır.
     */
    private function kosulMetni(SartSonucu $sonuc): string
    {
        $satirlar = ['- Genel sonuç: '.$sonuc->durum->etiket()];

        foreach ($sonuc->kosullar() as $kosul) {
            $olcum = $kosul->gerekli !== null ? " ({$kosul->mevcut}/{$kosul->gerekli})" : '';
            $madde = $kosul->madde !== null ? " [{$kosul->madde}]" : '';
            $satirlar[] = "- [{$kosul->durum->etiket()}] {$kosul->aciklama}{$olcum}{$madde}";

            if ($kosul->belirsizlikNedeni !== null) {
                $satirlar[] = '    · karara bağlanamadı: '.$kosul->belirsizlikNedeni;
            }

            if ($kosul->kaynakEksik) {
                $satirlar[] = '    · bu koşulun cetveli projeye girilmedi; adayın kendi beyanına bırakıldı.';
            }
        }

        return implode("\n", $satirlar);
    }

    private function olcumMetni(): string
    {
        return 'NOT: Yukarıdaki sayılar şart ağacı motorundan geliyor ve KESİNDİR. '
            .'Yeni puan hesaplamayacak, verilen sayıları değiştirmeyeceksin.';
    }
}
