<?php

namespace App\Providers;

use App\Http\Controllers\TaklitController;
use App\Models\User;
use App\Services\Abonelik\PaketKatalogu;
use App\Services\AI\ClaudeSaglayici;
use App\Services\AI\JuriRaporcu;
use App\Services\AI\OpenAiSaglayici;
use App\Services\AI\SohbetSaglayici;
use App\Services\AI\StubJuriSaglayici;
use App\Services\AI\StubSaglayici;
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
use RuntimeException;

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
        $this->app->singleton(SartDeposu::class, fn (): SartDeposu => new SartDeposu);

        // Paket bilgileri istek başına bir kez okunur; scoped: her istek/iş
        // (ve test) temiz başlar, panelde değiştirilen fiyat bir sonraki
        // istekte görünür.
        $this->app->scoped(PaketKatalogu::class);

        $this->app->bind(CrossrefArama::class, fn (): CrossrefArama => new CrossrefArama(
            taban: config('services.crossref.taban'),
            posta: config('services.crossref.posta'),
        ));

        $this->app->bind(SohbetSaglayici::class, function (): SohbetSaglayici {
            if (config('ai.saglayici') === 'claude') {
                $anahtar = config('ai.claude.anahtar');

                if (blank($anahtar)) {
                    throw new RuntimeException('ANTHROPIC_API_KEY tanımlı değil.');
                }

                return new ClaudeSaglayici(
                    anahtar: $anahtar,
                    model: config('ai.claude.model'),
                    maxTokens: config('ai.claude.max_tokens'),
                );
            }

            if (config('ai.saglayici') === 'openai') {
                $anahtar = config('ai.openai.anahtar');

                if (blank($anahtar)) {
                    throw new RuntimeException('OPENAI_API_KEY tanımlı değil.');
                }

                return new OpenAiSaglayici(
                    anahtar: $anahtar,
                    model: config('ai.openai.model'),
                    maxTokens: config('ai.openai.max_tokens'),
                );
            }

            return new StubSaglayici;
        });

        // Jüri raporu aynı sağlayıcıyı kullanır ama tek yanıtta on adım yazdığı
        // için sohbetin token tavanı yetmiyor; sahte sağlayıcısı da ayrı, çünkü
        // jüri katmanı metin değil JSON okuyor.
        $this->app->when(JuriRaporcu::class)
            ->needs(SohbetSaglayici::class)
            ->give(fn (): SohbetSaglayici => $this->juriSaglayicisi());
    }

    /**
     * Jüri raporu için sağlayıcı: sohbetle aynı seçim, yüksek token tavanı.
     */
    private function juriSaglayicisi(): SohbetSaglayici
    {
        $maxTokens = (int) config('ai.juri.max_tokens');

        if (config('ai.saglayici') === 'claude') {
            $anahtar = config('ai.claude.anahtar');

            if (blank($anahtar)) {
                throw new RuntimeException('ANTHROPIC_API_KEY tanımlı değil.');
            }

            return new ClaudeSaglayici(
                anahtar: $anahtar,
                model: config('ai.claude.model'),
                maxTokens: $maxTokens,
            );
        }

        if (config('ai.saglayici') === 'openai') {
            $anahtar = config('ai.openai.anahtar');

            if (blank($anahtar)) {
                throw new RuntimeException('OPENAI_API_KEY tanımlı değil.');
            }

            return new OpenAiSaglayici(
                anahtar: $anahtar,
                model: config('ai.openai.model'),
                maxTokens: $maxTokens,
            );
        }

        return new StubJuriSaglayici;
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
