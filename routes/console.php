<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('whatsapp:process-queue')
    ->everyMinute()
    ->withoutOverlapping()  // Prevent multiple processes running simultaneously
    ->runInBackground();    // Non-blocking

// Optional: Cleanup old failed notifications
Schedule::call(function () {
    $failedFile = storage_path('app/whatsapp_failed.json');
    
    if (file_exists($failedFile)) {
        $failed = json_decode(file_get_contents($failedFile), true) ?? [];
        
        // Keep only last 7 days
        $cutoffDate = now()->subDays(7);
        
        $filtered = array_filter($failed, function($item) use ($cutoffDate) {
            if (!isset($item['queued_at'])) {
                return false;
            }
            
            $queuedAt = \Carbon\Carbon::parse($item['queued_at']);
            return $queuedAt->greaterThan($cutoffDate);
        });
        
        file_put_contents($failedFile, json_encode(array_values($filtered), JSON_PRETTY_PRINT));
    }
})->dailyAt('02:00');