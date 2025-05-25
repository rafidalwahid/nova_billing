<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule automated status management
Schedule::command('billing:update-domain-statuses')->daily();
Schedule::command('billing:sync-subscription-statuses')->daily();
Schedule::command('billing:fix-server-counts')->weekly();
