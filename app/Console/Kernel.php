<?php

namespace App\Console;

use App\Console\Commands\DisableInactiveUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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

                // スケジューラー実行時の環境情報を記録
                Log::info('Schedule starting', [
                    'timestamp' => now()->format('Y-m-d H:i:s'),
                    'pid' => getmypid(),
                    'ppid' => posix_getppid(),
                    'user' => posix_getpwuid(posix_geteuid())['name'],
                    'pwd' => getcwd(),
                    'sapi' => php_sapi_name(),
                    'argv' => $_SERVER['argv'] ?? []
                ]);

        // $schedule->command('inspire')->hourly();
        // $schedule->command(DisableInactiveUsers::class)->daily(); // 毎日実行する例
        $schedule->command(DisableInactiveUsers::class)->daily(); 

        $schedule->command('queue:workers')
        ->runInBackground()
        ->everyMinute()
        ->before(function () {
            Log::info('Before queue:workers execution');
        })
        ->after(function () {
            Log::info('After queue:workers execution');
        })
        ->onSuccess(function () {
            Log::info('queue:workers executed successfully');
        })
        ->onFailure(function () {
            Log::error('queue:workers execution failed');
        });
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
