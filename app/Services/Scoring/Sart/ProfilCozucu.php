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
 *   tez_danismanlik          ← Tez Danışmanlığı, rol = danışman (baş danışmanlık)
 *   tez_es_danismanlik       ← Tez Danışmanlığı, rol = eş danışman
 *   doktora_tez_danismanlik  ← Baş danışmanlık, kaynak = doktora/yeterlik tezi
 *   ders_yariyil             ← Eğitim-Öğretim kategorisindeki faaliyet sayısı
 *                              (İSTİSNA: boş kategori 0 sayılır, bkz. aşağıda)
 *
 * Profilden okunanlar: dönem tarihleri, program dili, YDS, h-indeksi,
 * yurt dışı süresi. Bunlar tek tek faaliyet olarak kaydedilen şeyler değil.
 *
 * BOŞ KATEGORİ = BELİRSİZ kuralının istisnaları `ders_yariyil` ve tez
 * danışmanlığı ölçütleridir: kayıt girilmemişse 0 kabul edilir ve koşul kesin
 * sonuca bağlanır. Atıf ve proje ölçütlerinde boşluk belirsizlik üretmeye
 * devam eder.
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
            dersYariyil: $this->say($faaliyetler, Kategori::EgitimOgretim, bosSifir: true),
            // Yönergeler baş danışmanlık ile eş danışmanlığı ayırıyor
            // (Sabancı: "iki eş danışmanlık bir baş danışmanlığa eşdeğer").
            tezDanismanlik: $this->say(
                $faaliyetler,
                Kategori::TezDanismanligi,
                haricKaynaklar: ['Tez İzleme / Jüri Üyeliği'],
                roller: ['danisman'],
                bosSifir: true,
            ),
            tezEsDanismanlik: $this->say(
                $faaliyetler,
                Kategori::TezDanismanligi,
                haricKaynaklar: ['Tez İzleme / Jüri Üyeliği'],
                roller: ['es_danisman'],
                bosSifir: true,
            ),
            doktoraTezDanismanlik: $this->say(
                $faaliyetler,
                Kategori::TezDanismanligi,
                kaynaklar: ['Doktora Tezi', 'Tıpta/Diş/Sanatta Yeterlik Tezi'],
                roller: ['danisman'],
                bosSifir: true,
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
     * @param  bool  $bosSifir  Boş kategoriyi belirsiz değil kesin 0 say
     */
    private function say(
        Collection $faaliyetler,
        Kategori $kategori,
        ?array $kaynaklar = null,
        ?array $haricKaynaklar = null,
        ?array $roller = null,
        bool $bosSifir = false,
    ): ?int {
        $kategorideki = $faaliyetler->filter(fn (Faaliyet $f) => $f->kategori === $kategori);

        if ($kategorideki->isEmpty()) {
            return $bosSifir ? 0 : null;
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
