<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    Log::info('✅ Laravel 12 scheduler executed at '.now());
})->everyMinute();

Schedule::command('app:get-news-command')
        ->everyTwoHours()
        ->withoutOverlapping()
        ->sendOutputTo(storage_path('logs/get-news.log'));


