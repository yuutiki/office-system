<?php

namespace App\Console;

use App\Console\Commands\DisableInactiveUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ログディレクトリの存在確認と作成（workers専用フォルダ）
        $logDir = storage_path('logs/workers');
        
        if (!File::exists($logDir)) {
            File::makeDirectory($logDir, 0775, true);
        }

        // $schedule->command('inspire')->hourly();
        // $schedule->command(DisableInactiveUsers::class)->daily(); // 毎日実行する例
        $schedule->command(DisableInactiveUsers::class)->daily(); 

        $schedule->exec('nohup php artisan queue:workers > /dev/null 2>&1 & echo $!')
        ->everyMinute()
        ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
