<?php

namespace App\Console\Commands;

use App\Models\RoleGroup;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;

class SyncFunctionMenus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:syncFunctionMenus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize function menus in the pivot table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // すべての機能メニューの ID を取得
        $existingFunctionMenuIds = DB::table('function_menus')->pluck('id');

        // すべての RoleGroup を取得
        $roleGroups = RoleGroup::all();

        foreach ($roleGroups as $roleGroup) {
            // すべての FunctionMenu に対する Permission のリレーションを取得
            $linkedFunctionMenus = $roleGroup->functionMenus()->with('permission')->get();

            // RoleGroup に関連付けられている機能メニューの ID を取得
            $linkedFunctionMenuIds = $linkedFunctionMenus->pluck('id')->toArray();

            // すべての機能メニューの ID と関連付けられた機能メニューの ID を比較し、関連付けられていない機能メニューの ID を抽出
            $missingFunctionMenuIds = array_diff($existingFunctionMenuIds->toArray(), $linkedFunctionMenuIds);

            // 関連付けられていない機能メニューがあれば、それらを RoleGroup に関連付ける
            if (!empty($missingFunctionMenuIds)) {
                foreach ($missingFunctionMenuIds as $missingFunctionMenuId) {
                    $roleGroup->functionMenus()->attach($missingFunctionMenuId, ['permission_id' => 1]); // デフォルトの権限IDを設定
                }
            }
        }

        // 処理が完了したら、コンソールにメッセージを出力して処理の成功を通知
        $this->info('Function menus synchronized successfully.');
    }
}
