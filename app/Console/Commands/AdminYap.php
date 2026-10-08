<?php

namespace App\Console\Commands;

use App\Enums\YoneticiIslemi;
use App\Models\IslemKaydi;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

/**
 * Süper admin yetkisini verir ya da geri alır.
 *
 * Yetki ARAYÜZDEN verilemiyor, yalnızca sunucuya erişimi olan biri bu komutla
 * verebilir: paneldeki bir hata ya da ele geçirilmiş bir admin hesabı başka
 * hesapları admin yapamasın.
 */
#[Signature('admin:yap {eposta : Kullanıcının e-posta adresi} {--geri-al : Yetkiyi geri al}')]
#[Description('Bir kullanıcıya süper admin yetkisi verir (ya da --geri-al ile alır).')]
class AdminYap extends Command
{
    public function handle(): int
    {
        $user = User::query()->where('email', $this->argument('eposta'))->first();

        if ($user === null) {
            $this->error('Bu e-postayla kullanıcı bulunamadı.');

            return self::FAILURE;
        }

        $ver = ! $this->option('geri-al');

        if ($user->super_admin === $ver) {
            $this->info($ver ? "{$user->email} zaten süper admin." : "{$user->email} zaten süper admin değil.");

            return self::SUCCESS;
        }

        $user->super_admin = $ver;
        $user->save();

        IslemKaydi::yaz($ver ? YoneticiIslemi::AdminYapildi : YoneticiIslemi::AdminligiAlindi, null, $user, ['kaynak' => 'komut']);

        $this->info($ver ? "{$user->email} artık süper admin." : "{$user->email} artık süper admin değil.");

        return self::SUCCESS;
    }
}
