<?php

namespace App\Services\AI;

use App\Enums\Kadro;
use App\Enums\TemelAlan;
use App\Models\User;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Scoring\Sart\SartSonucu;

/**
 * Kullanıcının profili ve şart ağacı sonucundan YZ Danışman için
 * kişiselleştirilmiş sistem promptu üretir.
 *
 * Veriyi Yönerge Analizi ve Dashboard ile AYNI motordan alır; üç ekran da
 * aynı sayıyı söyler. Kullanıcının üniversitesinin yönergesi girilmemişse
 * puan uydurulmaz — prompt bunu açıkça belirtir.
 */
class DanismanContext
{
    public function __construct(private readonly SartDeposu $depo) {}

    public function sistemPrompt(User $user): string
    {
        $faaliyetler = $user->faaliyetler()->onaylanmis()->get();
        $kadro = $this->hedefKadro($user);

        $esik = $user->universite !== null
            ? $this->depo->bul($user->universite, $kadro, ($user->temel_alan ?? TemelAlan::Sosyal)->value, $user->birim)
            : null;

        $durum = $esik !== null
            ? $this->durumMetni($this->depo->degerlendir($esik, $faaliyetler, $user->sartProfili($faaliyetler)))
            : "- {$user->universite} yönergesi henüz sisteme girilmedi; puan ve koşul değerlendirmesi yapılamıyor.";

        $dagilim = $faaliyetler
            ->groupBy(fn ($f) => $f->kategori->label())
            ->map(fn ($grup, $ad) => "- {$ad}: {$grup->count()} kayıt")
            ->implode("\n") ?: '- Henüz onaylı faaliyet yok.';

        $unvan = $user->unvan ?? '—';
        $universite = $user->universite ?? '—';
        $bolum = $user->bolum ?? '—';
        $alan = $user->temel_alan?->label() ?? '—';

        return <<<PROMPT
        Sen "Akademiyolum" platformunun YZ Akademik Danışmanısın. Türk akademisyenlere
        doçentlik ve akademik yükselme sürecinde yol gösterirsin. Yanıtların Türkçe, net,
        somut ve puan/yönerge odaklı olsun. Uydurma bilgi verme; yalnızca aşağıdaki profil
        ve değerlendirme verisine dayan. Eksik alanları önceliklendir, uygulanabilir adımlar öner.

        Bir koşul "belirsiz" işaretliyse bu koşulun SAĞLANMADIĞI anlamına GELMEZ; adayın
        profilinde ya da faaliyet tarihlerinde eksik veri olduğu için değerlendirilemediği
        anlamına gelir. Böyle durumlarda önce hangi bilginin girilmesi gerektiğini söyle.

        AKADEMİSYEN PROFİLİ
        - Ad: {$user->name}
        - Unvan: {$unvan}
        - Üniversite: {$universite}
        - Bölüm: {$bolum}
        - Temel Alan: {$alan}
        - Hedef Kadro: {$kadro}

        YÖNERGE DEĞERLENDİRMESİ
        {$durum}

        FAALİYET DAĞILIMI
        {$dagilim}
        PROMPT;
    }

    private function hedefKadro(User $user): string
    {
        return Kadro::hedef($user->unvan)->value;
    }

    private function durumMetni(SartSonucu $sonuc): string
    {
        $satirlar = ['- Genel sonuç: '.$sonuc->durum->etiket()];

        foreach ($sonuc->kosullar() as $kosul) {
            $olcum = $kosul->gerekli !== null ? " ({$kosul->mevcut}/{$kosul->gerekli})" : '';
            $satirlar[] = "- [{$kosul->durum->etiket()}] {$kosul->aciklama}{$olcum}";
        }

        return implode("\n", $satirlar);
    }
}
