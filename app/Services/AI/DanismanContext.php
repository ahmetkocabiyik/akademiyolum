<?php

namespace App\Services\AI;

use App\Models\User;
use App\Services\Scoring\KuralSetiCozucu;
use App\Services\Scoring\PuanRaporu;

/**
 * Kullanıcının profili ve puan raporundan YZ Danışman için kişiselleştirilmiş
 * sistem promptu üretir.
 */
class DanismanContext
{
    public function sistemPrompt(User $user): string
    {
        $ruleSet = (new KuralSetiCozucu)->kullaniciIcin($user);
        $rapor = (new PuanRaporu($ruleSet))->olustur(
            $user->faaliyetler()->where('durum', 'onaylandi')->get()
        );

        $kategoriSatirlari = collect($rapor->tumKategoriler())
            ->map(fn ($s) => "- {$s->kategori->label()}: {$s->puan}/{$s->tavan} puan ({$s->adet} kayıt)")
            ->implode("\n");

        $unvan = $user->unvan ?? '—';
        $universite = $user->universite ?? '—';
        $bolum = $user->bolum ?? '—';

        return <<<PROMPT
        Sen "Akademiyolum" platformunun YZ Akademik Danışmanısın. Türk akademisyenlere
        doçentlik ve akademik yükselme sürecinde yol gösterirsin. Yanıtların Türkçe, net,
        somut ve puan/yönerge odaklı olsun. Uydurma bilgi verme; yalnızca aşağıdaki profil
        ve puan verisine dayan. Eksik alanları önceliklendir, uygulanabilir adımlar öner.

        AKADEMİSYEN PROFİLİ
        - Ad: {$user->name}
        - Unvan: {$unvan}
        - Üniversite: {$universite}
        - Bölüm: {$bolum}
        - Aktif Yönerge: {$ruleSet->ad}

        PUAN DURUMU
        - Toplam Puan: {$rapor->toplamPuan}
        - ÜAK Hedefi: {$rapor->uakHedef} (tamamlanma %{$rapor->uakYuzde()}, kalan {$rapor->kalanUakPuan()} puan)
        - Üniversite Barajı: {$rapor->universiteHedef}

        KATEGORİ DAĞILIMI
        {$kategoriSatirlari}
        PROMPT;
    }
}
