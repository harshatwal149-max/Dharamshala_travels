<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('branding:optimize-logo', function () {
    $small = \App\Support\SiteLogo::refreshSmall();

    $small
        ? $this->info("Small logo created: {$small}")
        : $this->warn('Logo was not resized (external URL, SVG/ICO, or already small). The original will be used.');
})->purpose('Create the small website copy of the uploaded site logo');
