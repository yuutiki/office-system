<?php

namespace App\Console\Commands;

use App\Models\PasswordPolicy;
use App\Models\User;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DisableInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:disable-inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable users who have not logged in for a specified date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateInactive = PasswordPolicy::value('date_inactive');
        $inactiveThreshold = $dateInactive !== 0 ? now()->subDays($dateInactive) : null;
    
        User::where('is_enabled', true)
            ->where(function ($query) use ($inactiveThreshold) {
                // 24時間以上経過して未ログインのユーザー
                $query->where(function ($q) {
                    $q->whereNull('last_login_at')
                        ->where('updated_at', '<=', now()->subHours(24));
                });
    
                // 一般的な非アクティブユーザー
                if ($inactiveThreshold) {
                    $query->orWhere('last_login_at', '<=', $inactiveThreshold);
                }
            })
            ->update(['is_enabled' => false]);
    
        Log::info('Inactive users have been disabled.');
        $this->info('Inactive users have been disabled.');
    }
}
