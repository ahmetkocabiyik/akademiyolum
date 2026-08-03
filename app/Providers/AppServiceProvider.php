<?php

namespace App\Providers;

use App\Services\AI\ClaudeSaglayici;
use App\Services\AI\OpenAiSaglayici;
use App\Services\AI\SohbetSaglayici;
use App\Services\AI\StubSaglayici;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
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
