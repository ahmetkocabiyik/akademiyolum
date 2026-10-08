<?php

namespace App\Services\Yonetim;

use App\Enums\Plan;
use App\Enums\YoneticiIslemi;
use App\Models\Abonelik;
use App\Models\IslemKaydi;
use App\Models\User;
use App\Services\Eposta\EpostaGonderici;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Süper adminin kullanıcılar üzerindeki işlemleri.
 *
 * Kurallar ekranda değil burada: panel ne gösterirse göstersin, kendi
 * hesabını ya da başka bir süper admini askıya alamaz, silemez. Her işlem
 * işlem kaydına yazılır; kayıt ve değişiklik aynı veritabanı işleminde,
 * biri olmadan öbürü kalmasın.
 */
class KullaniciYonetimi
{
    public function __construct(private readonly EpostaGonderici $eposta) {}

    public function askiyaAl(User $hedef, User $yonetici, ?string $neden = null): void
    {
        $this->korumaliMi($hedef, $yonetici);

        if ($hedef->askidaMi()) {
            return;
        }

        DB::transaction(function () use ($hedef, $yonetici, $neden): void {
            $hedef->forceFill(['askiya_alindi_at' => now()])->save();
            IslemKaydi::yaz(YoneticiIslemi::AskiyaAldi, $yonetici, $hedef, array_filter(['neden' => $neden]));
            $this->eposta->askiyaAlindi($hedef, $neden);
        });
    }

    public function askidanCikar(User $hedef, User $yonetici): void
    {
        if (! $hedef->askidaMi()) {
            return;
        }

        DB::transaction(function () use ($hedef, $yonetici): void {
            $hedef->forceFill(['askiya_alindi_at' => null])->save();
            IslemKaydi::yaz(YoneticiIslemi::AskidanCikardi, $yonetici, $hedef);
            $this->eposta->askidanCikarildi($hedef);
        });
    }

    /**
     * Kullanıcıyı ve verisini kalıcı siler (faaliyet, CV, abonelik satırları
     * yabancı anahtarla; dosyalar User::booted kancasıyla). Kayıt önce yazılır:
     * hedefin e-postası anlık görüntü olarak kalır.
     */
    public function sil(User $hedef, User $yonetici): void
    {
        $this->korumaliMi($hedef, $yonetici);

        DB::transaction(function () use ($hedef, $yonetici): void {
            IslemKaydi::yaz(YoneticiIslemi::KullaniciyiSildi, $yonetici, $hedef, [
                'ad' => $hedef->name,
                'faaliyet_sayisi' => $hedef->faaliyetler()->count(),
            ]);

            // Ad ve e-posta silmeden ÖNCE alınıyor; mail işlem tamamlanınca gider.
            $this->eposta->hesapSilindi($hedef->name, $hedef->email);

            $hedef->delete();
        });
    }

    /**
     * Elle abonelik dönemi ekler (havale, kurum anlaşması, deneme).
     */
    public function abonelikEkle(
        User $hedef,
        User $yonetici,
        Plan $plan,
        CarbonImmutable $baslangic,
        ?CarbonImmutable $bitis,
        ?int $tutarKurus = null,
        ?string $not = null,
    ): Abonelik {
        if ($plan === Plan::Ucretsiz) {
            throw new InvalidArgumentException('Ücretsiz plan abonelik olarak yazılmaz; aboneliği olmayan kullanıcı ücretsiz plandadır.');
        }

        if ($bitis !== null && $bitis->lessThan($baslangic)) {
            throw new InvalidArgumentException('Bitiş tarihi başlangıçtan önce olamaz.');
        }

        return DB::transaction(function () use ($hedef, $yonetici, $plan, $baslangic, $bitis, $tutarKurus, $not): Abonelik {
            $abonelik = $hedef->abonelikler()->create([
                'plan' => $plan,
                'baslangic' => $baslangic->toDateString(),
                'bitis' => $bitis?->toDateString(),
                'kaynak' => 'elle',
                'tutar_kurus' => $tutarKurus,
                'not' => $not,
                'olusturan_id' => $yonetici->id,
            ]);

            IslemKaydi::yaz(YoneticiIslemi::AbonelikEkledi, $yonetici, $hedef, [
                'abonelik_id' => $abonelik->id,
                'plan' => $plan->value,
                'baslangic' => $baslangic->toDateString(),
                'bitis' => $bitis?->toDateString(),
                'tutar_kurus' => $tutarKurus,
            ]);

            // Kullanıcıya ve yöneticilere bildirim. Mail işlem tamamlanınca
            // kuyruğa düşer (SablonluEposta::afterCommit); işlem geri alınırsa gitmez.
            $this->eposta->abonelik($abonelik->setRelation('user', $hedef)->setRelation('olusturan', $yonetici));

            return $abonelik;
        });
    }

    public function abonelikIptal(Abonelik $abonelik, User $yonetici): void
    {
        if ($abonelik->iptal_edildi_at !== null) {
            return;
        }

        // Bitmiş bir dönemi iptal etmek kullanıcı için bir şey değiştirmiyor; mail
        // yalnızca aktif ya da başlamamış abonelikte gider.
        $etkili = in_array($abonelik->durum(), ['aktif', 'baslamadi'], true);

        DB::transaction(function () use ($abonelik, $yonetici, $etkili): void {
            $abonelik->forceFill(['iptal_edildi_at' => now()])->save();

            if ($etkili) {
                $this->eposta->abonelikIptal($abonelik);
            }

            IslemKaydi::yaz(YoneticiIslemi::AbonelikIptalEtti, $yonetici, $abonelik->user, [
                'abonelik_id' => $abonelik->id,
                'plan' => $abonelik->plan->value,
            ]);
        });
    }

    /**
     * Uzatmanın varsayılan başlangıcı: aktif abonelik bitiyorsa ertesi gün
     * (dönemler üst üste binmesin), yoksa bugün.
     */
    public function siradakiBaslangic(User $hedef): CarbonImmutable
    {
        $aktif = $hedef->aktifAbonelik();

        return $aktif?->bitis !== null
            ? $aktif->bitis->addDay()
            : CarbonImmutable::today();
    }

    /**
     * Kendi hesabı ve başka süper adminler panelden askıya alınamaz,
     * silinemez; önce `admin:yap --geri-al` ile yetkisi alınmalı.
     */
    private function korumaliMi(User $hedef, User $yonetici): void
    {
        if ($hedef->is($yonetici)) {
            throw new InvalidArgumentException('Kendi hesabınız üzerinde bu işlem yapılamaz.');
        }

        if ($hedef->super_admin) {
            throw new InvalidArgumentException('Süper admin hesabı panelden değiştirilemez.');
        }
    }
}
