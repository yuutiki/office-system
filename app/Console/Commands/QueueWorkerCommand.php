<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class QueueWorkerCommand extends Command
{
    protected $signature = 'queue:workers';
    protected $description = 'Start queue workers with configured options';

    public function handle()
    {
        // Workerの実行オプションを設定
        $workerOptions = implode(' ', [
            '--max-time=60',    // 60秒でWorkerを再起動
            '--memory=256',     // メモリ256MBで再起動
            '--tries=3',        // ジョブの最大試行回数
            '--timeout=60',     // 1ジョブの実行時間制限
        ]);

        // 環境に応じてコマンドプレフィックスを設定（開発環境ではdocker compose exec）
        $commandPrefix = $this->getCommandPrefix();
        
        // Worker起動コマンドを生成
        $baseCommand = "{$commandPrefix}php artisan queue:work";

        try {
            // Workerの起動処理開始を記録
            $startTime = now()->format('Y-m-d H:i:s');
            Log::channel('queue_workers')->info("Starting workers at {$startTime}");

            // 高優先度Worker起動（high -> defaultの順で処理）
            Log::channel('queue_workers')->info("Starting high priority workers");
            Process::run("{$baseCommand} --queue=high,default {$workerOptions} > /dev/null 2>&1 & echo $!");
            Process::run("{$baseCommand} --queue=high,default {$workerOptions} > /dev/null 2>&1 & echo $!");

            // 通常優先度Worker起動（default -> highの順で処理）
            Log::channel('queue_workers')->info("Starting default priority workers");
            Process::run("{$baseCommand} --queue=default,high {$workerOptions} > /dev/null 2>&1 & echo $!");
            Process::run("{$baseCommand} --queue=default,high {$workerOptions} > /dev/null 2>&1 & echo $!");

            // 起動したWorker数を確認
            $workerCount = Process::run("pgrep -f 'queue:work' | wc -l");
            $count = (int)$workerCount->output();
            
            // 起動結果をログに記録
            Log::channel('queue_workers')->info("Workers started successfully", [
                'command' => $baseCommand,
                'worker_count' => $count,
                'options' => $workerOptions
            ]);

            // コンソールに結果を表示
            $this->info("Workers started successfully. Count: {$count}");

        } catch (\Exception $e) {
            // エラー発生時のログ記録
            Log::channel('queue_workers')->error("Failed to start workers", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // コンソールにエラーを表示
            $this->error("Failed to start workers: {$e->getMessage()}");
        }
    }

    /**
     * 環境に応じたコマンドプレフィックスを取得
     * 開発環境の場合はdocker compose execを使用
     */
    private function getCommandPrefix(): string
    {
        // APP_ENVがlocalまたはqueue.use_dockerがtrueの場合
        if (App::environment('local')) {
            return 'docker compose exec -T app ';  // -Tオプションで疑似TTY割り当てを防止
        }

        // 本番環境の場合は追加のプレフィックスなし
        return '';
    }
}