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
        
        // Worker起動コマンドを生成（nohupを追加）
        $baseCommand = "{$commandPrefix}nohup php artisan queue:work";
        
        // プロセスIDを格納する配列
        $pids = [];

        try {
            // Workerの起動処理開始を記録
            $startTime = now()->format('Y-m-d H:i:s');
            Log::channel('queue_workers')->info("Starting workers at {$startTime}");

            // 高優先度Worker起動（high -> defaultの順で処理）
            Log::channel('queue_workers')->info("Starting high priority workers");
            $pids[] = $this->startWorker("{$baseCommand} --queue=high,default {$workerOptions}");
            $pids[] = $this->startWorker("{$baseCommand} --queue=high,default {$workerOptions}");

            // 通常優先度Worker起動（default -> highの順で処理）
            Log::channel('queue_workers')->info("Starting default priority workers");
            $pids[] = $this->startWorker("{$baseCommand} --queue=default,high {$workerOptions}");
            $pids[] = $this->startWorker("{$baseCommand} --queue=default,high {$workerOptions}");

            sleep(1); // プロセスの起動を待機

            // 実際に稼働中のWorker数を確認
            $runningCount = $this->countRunningWorkers($pids);

            // 起動結果をログに記録
            Log::channel('queue_workers')->info("Workers started successfully", [
                'command' => $baseCommand,
                'worker_count' => $runningCount,
                'options' => $workerOptions
            ]);

            // コンソールに結果を表示
            $this->info("Workers started successfully. Running Count: {$runningCount}");

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
     * Workerを起動し、プロセスIDを取得
     * 
     * @param string $command 起動コマンド
     * @return int プロセスID
     */
    private function startWorker(string $command): int
    {
        // Process::runを実行し、実行結果からPIDを取得
        $process = Process::run("{$command} > /dev/null 2>&1 & echo $!");
        return (int) trim($process->output()); // プロセスIDを返す
    }

    /**
     * 稼働中のWorker数を確認
     * 
     * @param array $pids プロセスIDのリスト
     * @return int 現在稼働中のWorker数
     */
    private function countRunningWorkers(array $pids): int
    {
        $runningCount = 0;

        foreach ($pids as $pid) {
            // 各プロセスIDに対してpsで確認
            $result = Process::run("ps -p {$pid}");
            if ($result->successful()) {
                $runningCount++;
            }
        }

        return $runningCount;
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
