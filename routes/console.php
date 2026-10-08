<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Abonelik hatırlatma ve "sona erdi" mailleri. Sunucuda zamanlayıcının
// (`php artisan schedule:run`, cron ile her dakika) çalışması gerekir.
Schedule::command('abonelik:bildir')->dailyAt('09:00')->timezone('Europe/Istanbul')->withoutOverlapping();
