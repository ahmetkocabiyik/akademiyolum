<?php

namespace App\Providers;

use App\Enums\YzOzelligi;
use App\Http\Controllers\TaklitController;
use App\Http\Middleware\SuperAdmin;
use App\Models\GizliYonerge;
use App\Models\User;
use App\Services\Abonelik\PaketKatalogu;
use App\Services\AI\JuriRaporcu;
use App\Services\AI\SohbetSaglayici;
use App\Services\AI\YzAyarlari;
use App\Services\Eposta\EpostaGonderici;
use App\Services\Scoring\Sart\SartDeposu;
use App\Services\Yayin\CrossrefArama;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Şart ağaçları ve madde cetvelleri istek başına bir kez okunur.
        // Testler kendi verisiyle bir örnek bağlayarak üretim verisinden
        // bağımsız senaryo kurabilir.
        $this->app->singleton(SartDeposu::class, fn (): SartDeposu => new SartDeposu(
            // Panelden gizlenen yönergeler (Yönetim → Yönergeler).
            gizliKaynak: fn (): array => array_values(GizliYonerge::query()->get()->map(fn (GizliYonerge $g): string => $g->universite)->all()),
        ));

        // Paket bilgileri istek başına bir kez okunur; scoped: her istek/iş
        // (ve test) temiz başlar, panelde değiştirilen fiyat bir sonraki
        // istekte görünür.
        $this->app->scoped(PaketKatalogu::class);

        $this->app->bind(CrossrefArama::class, fn (): CrossrefArama => new CrossrefArama(
            taban: config('services.crossref.taban'),
            posta: config('services.crossref.posta'),
        ));

        // Sağlayıcı panelden seçiliyor (Yönetim → YZ Ayarları); seçim yoksa
        // .env'deki AI_SAGLAYICI.
        $this->app->bind(SohbetSaglayici::class, fn (): SohbetSaglayici => app(YzAyarlari::class)->saglayici(YzOzelligi::Danisman));

        // Jüri raporunun sağlayıcısı ayrı seçiliyor; tek yanıtta on adım yazdığı
        // için sohbetin token tavanı yetmiyor.
        $this->app->when(JuriRaporcu::class)
            ->needs(SohbetSaglayici::class)
            ->give(fn (): SohbetSaglayici => app(YzAyarlari::class)->saglayici(YzOzelligi::Juri, (int) config('ai.juri.max_tokens')));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureYonetim();
    }

    /**
     * Yönetim paneli yetkisi ve son giriş kaydı.
     */
    private function configureYonetim(): void
    {
        // Panel rotasının ara katmanı Livewire'ın sonraki isteklerinde
        // (livewire/update) de çalışsın: yoksa sayfa açıldıktan sonra yetkisi
        // alınan ya da başka sekmede "kullanıcı olarak gör"e geçen yöneticinin
        // açık paneli işlem yapmaya devam ediyordu.
        Livewire::addPersistentMiddleware([SuperAdmin::class]);

        // Askıdaki bir admin de paneli açamaz.
        Gate::define('super-admin', fn (User $user): bool => $user->super_admin && ! $user->askidaMi());

        // "Kullanıcı olarak gör" de bir Login olayı üretiyor; o, kullanıcının
        // kendi girişi değil, son giriş tarihini bozmamalı.
        Event::listen(function (Login $olay): void {
            if (session()->has(TaklitController::OTURUM_ANAHTARI) || ! $olay->user instanceof User) {
                return;
            }

            $olay->user->forceFill(['son_giris_at' => now()])->saveQuietly();
        });

        // Yeni kayıt: kullanıcıya hoş geldin, yöneticilere bildirim (kuyrukta).
        Event::listen(function (Registered $olay): void {
            if ($olay->user instanceof User) {
                app(EpostaGonderici::class)->kayit($olay->user);
            }
        });

        // Şifre sıfırlama ve doğrulama Laravel'in bildirimleriyle gidiyor (anahtar,
        // bekleme süresi, imzalı bağlantı onlarda); yalnızca METİN panelden
        // düzenlenen şablondan. Bağlantı Laravel'in varsayılanıyla aynı.
        ResetPassword::toMailUsing(fn (User $kullanici, string $anahtar) => app(EpostaGonderici::class)->sifreSifirlama(
            $kullanici,
            url(route('password.reset', ['token' => $anahtar, 'email' => $kullanici->getEmailForPasswordReset()], false)),
        ));

        VerifyEmail::toMailUsing(fn (User $kullanici, string $adres) => app(EpostaGonderici::class)->epostaDogrulama($kullanici, $adres));
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        // wire:navigate yükleme çubuğu düğmelerin marka mavisinde
        // (--color-brand); Livewire varsayılanı turkuaz #2299dd. Yapılandırma
        // dosyasını yayımlamak yerine tek anahtar burada değiştiriliyor.
        config(['livewire.navigate.progress_bar_color' => '#1a56db']);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
