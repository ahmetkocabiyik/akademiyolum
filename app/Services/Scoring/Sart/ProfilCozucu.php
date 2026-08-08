<?php

namespace App\Services\Scoring\Sart;

use App\Enums\Kategori;
use App\Models\Faaliyet;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Adayın {@see Profil}'ini üretir.
 *
 * Ölçütlerin bir kısmı FAALİYET SATIRLARINDAN türetilir, bir kısmı profil
 * alanından okunur. Ayrım şu: bir ölçüt "yayınlar" bölümünde tek tek
 * kaydedilebilen bir çalışmaya karşılık geliyorsa türetilir; adaya ait tek bir
 * skaler ise profilden okunur.
 *
 * Türetilenler (kullanıcı bunları elle giremez):
 *   atif_sayisi              ← Atıf kategorisindeki faaliyet sayısı
 *   proje_yurutuculuk        ← Proje kategorisi, rol = yürütücü/koordinatör
 *   proje_arastirmaci        ← Proje kategorisi, rol = araştırmacı
 *   proje_danisman           ← Proje kategorisi, rol = danışman
 *   tez_danismanlik          ← Tez Danışmanlığı kategorisi (tamamlanmış tezler)
 *   doktora_tez_danismanlik  ← Tez Danışmanlığı, kaynak = doktora/yeterlik tezi
 *   ders_yariyil             ← Eğitim-Öğretim kategorisindeki faaliyet sayısı
 *
 * Profilden okunanlar: dönem tarihleri, program dili, YDS, h-indeksi,
 * yurt dışı süresi. Bunlar tek tek faaliyet olarak kaydedilen şeyler değil.
 */
class ProfilCozucu
{
    /**
     * @param  iterable<Faaliyet>|null  $faaliyetler  null ise kullanıcının onaylı faaliyetleri çekilir
     */
    public function coz(User $user, ?iterable $faaliyetler = null): Profil
    {
        $faaliyetler = collect($faaliyetler ?? $user->faaliyetler()->onaylanmis()->get());

        return new Profil(
            doktoraTarihi: $user->doktora_tarihi,
            docentlikTarihi: $user->docentlik_tarihi,
            sonAtamaTarihi: $user->son_atama_tarihi,
            lisansTarihi: $user->lisans_tarihi,
            programDili: $user->program_dili,
            yds: $user->yds_puani,
            hIndeksi: $user->h_indeksi,
            yurtdisiAy: $user->yurtdisi_ay,

            // ── Faaliyetlerden türetilenler ──
            atifSayisi: $this->say($faaliyetler, Kategori::Atif),
            dersYariyil: $this->say($faaliyetler, Kategori::EgitimOgretim),
            tezDanismanlik: $this->say(
                $faaliyetler,
                Kategori::TezDanismanligi,
                haricKaynaklar: ['Tez İzleme / Jüri Üyeliği'],
            ),
            doktoraTezDanismanlik: $this->say(
                $faaliyetler,
                Kategori::TezDanismanligi,
                kaynaklar: ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'],
            ),
            projeYurutuculuk: $this->say($faaliyetler, Kategori::Proje, roller: ['yurutucu']),
            projeArastirmaci: $this->say($faaliyetler, Kategori::Proje, roller: ['arastirmaci', 'bursiyer']),
            projeDanisman: $this->say($faaliyetler, Kategori::Proje, roller: ['danisman']),
        );
    }

    /**
     * Kategori (ve varsa kaynak/rol) filtresine uyan faaliyet sayısı.
     *
     * Kategoride hiç faaliyet yoksa null döner — "0 tane var" ile "hiç
     * girilmemiş" farklı şeyler: birincisi kesin olumsuz, ikincisi belirsiz.
     *
     * @param  Collection<int, Faaliyet>  $faaliyetler
     * @param  list<string>|null  $kaynaklar
     * @param  list<string>|null  $haricKaynaklar
     * @param  list<string>|null  $roller
     */
    private function say(
        Collection $faaliyetler,
        Kategori $kategori,
        ?array $kaynaklar = null,
        ?array $haricKaynaklar = null,
        ?array $roller = null,
    ): ?int {
        $kategorideki = $faaliyetler->filter(fn (Faaliyet $f) => $f->kategori === $kategori);

        if ($kategorideki->isEmpty()) {
            return null;
        }

        return $kategorideki->filter(function (Faaliyet $f) use ($kaynaklar, $haricKaynaklar, $roller): bool {
            if ($kaynaklar !== null && ! in_array($f->kaynak, $kaynaklar, true)) {
                return false;
            }

            if ($haricKaynaklar !== null && in_array($f->kaynak, $haricKaynaklar, true)) {
                return false;
            }

            if ($roller !== null && ! in_array($f->rol, $roller, true)) {
                return false;
            }

            return true;
        })->count();
    }
}
