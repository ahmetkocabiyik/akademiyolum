<?php

namespace App\Services\Scoring;

use App\Models\User;
use App\Models\Yonerge;

/**
 * Bir kullanıcı için aktif kural setini (RuleSet) çözer. Kullanıcının seçili
 * yönergesi yoksa genel ÜAK yönergesine, o da yoksa config'teki varsayılana düşer.
 */
class KuralSetiCozucu
{
    public function kullaniciIcin(User $user): RuleSet
    {
        if ($user->yonerge_id !== null && $user->yonergeModel !== null) {
            return RuleSet::fromYonerge($user->yonergeModel);
        }

        $genel = Yonerge::query()->whereNull('universite_id')->first();

        if ($genel !== null) {
            return RuleSet::fromYonerge($genel);
        }

        return RuleSet::fromConfig();
    }
}
