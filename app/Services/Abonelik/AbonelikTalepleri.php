<?php

namespace App\Services\Abonelik;

use App\Enums\Plan;
use App\Enums\YoneticiIslemi;
use App\Models\Abonelik;
use App\Models\AbonelikTalebi;
use App\Models\IslemKaydi;
use App\Models\User;
use App\Services\Eposta\EpostaGonderici;
use App\Services\Yonetim\KullaniciYonetimi;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Ücretli paket talepleri — online ödeme gelene kadarki ara yol.
 *
 * Kullanıcı kurulumda paketi seçer, talep oluşur, yönetici ödemeyi aldıktan
 * sonra talebi tek tıkla aboneliğe çevirir. Ödeme sağlayıcısı geldiğinde
 * {@see self::olustur()} yerine ödeme sayfası açılacak; onay tarafı
 * {@see KullaniciYonetimi::abonelikEkle()} üzerinden değişmeden kalır.
 */
class AbonelikTalepleri
{
    public function __construct(
        private readonly KullaniciYonetimi $yonetim,
        private readonly PaketKatalogu $katalog,
        private readonly EpostaGonderici $eposta,
    ) {}

    /**
     * Yeni talep. Kullanıcının bekleyen eski talebi varsa yerini alır:
     * yöneticinin önünde aynı kişiden iki talep durmasın.
     */
    public function olustur(User $user, Plan $plan, string $donem): AbonelikTalebi
    {
        if ($plan === Plan::Ucretsiz) {
            throw new InvalidArgumentException('Ücretsiz plan için talep oluşturulmaz.');
        }

        if (! array_key_exists($donem, AbonelikTalebi::DONEMLER)) {
            throw new InvalidArgumentException("Bilinmeyen dönem: {$donem}");
        }

        return DB::transaction(function () use ($user, $plan, $donem): AbonelikTalebi {
            $user->abonelikTalepleri()->bekleyen()->update([
                'durum' => AbonelikTalebi::KAPATILDI,
                'sonuclandi_at' => now(),
            ]);

            $talep = $user->abonelikTalepleri()->create([
                'plan' => $plan,
                'donem' => $donem,
                'durum' => AbonelikTalebi::BEKLIYOR,
            ]);

            $this->eposta->talep($talep->setRelation('user', $user));

            return $talep;
        });
    }

    /**
     * Talebi aboneliğe çevirir: dönem sıradaki boş günden başlar, tutar
     * paketin güncel fiyatı. Talep, {@see KullaniciYonetimi::abonelikEkle()}
     * içinde tamamlandı olarak işaretleniyor.
     */
    public function onayla(AbonelikTalebi $talep, User $yonetici): Abonelik
    {
        $this->bekliyorMu($talep);

        $user = $talep->user;
        $baslangic = $this->yonetim->siradakiBaslangic($user);

        return $this->yonetim->abonelikEkle(
            $user,
            $yonetici,
            $talep->plan,
            $baslangic,
            $baslangic->addMonthsNoOverflow($talep->ay())->subDay(),
            $this->katalog->onerilenTutar($talep->plan, $talep->ay()),
            'Paket talebinden ('.$talep->donemEtiketi().')',
        );
    }

    /**
     * Ödeme gelmedi, kullanıcı vazgeçti… Kullanıcıya mail gitmez.
     */
    public function kapat(AbonelikTalebi $talep, User $yonetici): void
    {
        $this->bekliyorMu($talep);

        DB::transaction(function () use ($talep, $yonetici): void {
            $talep->update([
                'durum' => AbonelikTalebi::KAPATILDI,
                'sonuclandiran_id' => $yonetici->id,
                'sonuclandi_at' => now(),
            ]);

            IslemKaydi::yaz(YoneticiIslemi::TalebiKapatti, $yonetici, $talep->user, [
                'talep_id' => $talep->id,
                'plan' => $talep->plan->value,
                'donem' => $talep->donem,
            ]);
        });
    }

    /**
     * Kullanıcı kendi bekleyen talebini geri çeker. Yöneticiye mail gitmez;
     * talep panel listesinden düşer.
     */
    public function geriCek(AbonelikTalebi $talep, User $user): void
    {
        $this->bekliyorMu($talep);

        if ($talep->user_id !== $user->id) {
            throw new InvalidArgumentException('Başkasının talebi geri çekilemez.');
        }

        $talep->update([
            'durum' => AbonelikTalebi::KAPATILDI,
            'sonuclandiran_id' => $user->id,
            'sonuclandi_at' => now(),
        ]);
    }

    private function bekliyorMu(AbonelikTalebi $talep): void
    {
        if ($talep->durum !== AbonelikTalebi::BEKLIYOR) {
            throw new InvalidArgumentException('Talep zaten sonuçlanmış.');
        }
    }
}
