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
        if ($dateInactive === 0) {
            return; // 無期限の場合は何もしない
        }

        $inactiveThreshold = now()->subDays($dateInactive);

        User::where(function ($query) use ($inactiveThreshold) {
            $query->where('last_login_at', '<=', $inactiveThreshold)
                ->orWhereNull('last_login_at');
        })
        ->update(['is_enabled' => false]); // 有効フラグを無効化する

        Log::info('Inactive users have been disabled.'); // ログを書き出す

        $this->info('Inactive users have been disabled.');
    }
}
