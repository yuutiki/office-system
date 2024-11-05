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
        // 実行環境の情報を収集
        $environmentInfo = [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'pid' => getmypid(),
            'ppid' => posix_getppid(),
            'user' => posix_getpwuid(posix_geteuid())['name'],
            'pwd' => getcwd(),
            'php_binary' => PHP_BINARY,
            'sapi' => php_sapi_name(),
            'environment' => app()->environment(),
            'path' => getenv('PATH'),
        ];

        // 実行環境の情報をログに記録
        Log::channel('queue_workers')->info("Environment info", $environmentInfo);

        $workerOptions = implode(' ', [
            '--max-time=60',
            '--memory=256',
            '--tries=3',
            '--timeout=60',
        ]);

        $commandPrefix = $this->getCommandPrefix();
        $baseCommand = "{$commandPrefix}php artisan queue:work";

        // 起動前の状態を確認
        $beforeProcesses = $this->getRunningWorkers();
        Log::channel('queue_workers')->info("Existing workers before start", [
            'count' => count($beforeProcesses),
            'processes' => $beforeProcesses
        ]);

        $pids = [];

        try {
            $startTime = now()->format('Y-m-d H:i:s');
            Log::channel('queue_workers')->info("Starting workers at {$startTime}");

            // 高優先度Worker起動
            Log::channel('queue_workers')->info("Starting high priority workers");
            for ($i = 0; $i < 2; $i++) {
                $pid = $this->startWorker("{$baseCommand} --queue=high,default {$workerOptions}");
                Log::channel('queue_workers')->info("Started high priority worker", [
                    'pid' => $pid,
                    'index' => $i
                ]);
                $pids[] = $pid;
            }

            // 通常優先度Worker起動
            Log::channel('queue_workers')->info("Starting default priority workers");
            for ($i = 0; $i < 2; $i++) {
                $pid = $this->startWorker("{$baseCommand} --queue=default,high {$workerOptions}");
                Log::channel('queue_workers')->info("Started default priority worker", [
                    'pid' => $pid,
                    'index' => $i
                ]);
                $pids[] = $pid;
            }

            sleep(2); // プロセスの起動を待機

            // 起動後の状態を確認
            $afterProcesses = $this->getRunningWorkers();
            $runningCount = $this->countRunningWorkers($pids);

            // 詳細な結果をログに記録
            Log::channel('queue_workers')->info("Workers status", [
                'command' => $baseCommand,
                'expected_pids' => $pids,
                'running_count' => $runningCount,
                'before_processes' => $beforeProcesses,
                'after_processes' => $afterProcesses,
                'options' => $workerOptions
            ]);

            $this->info("Workers started. Expected PIDs: " . implode(', ', $pids));
            $this->info("Actually running: {$runningCount}");

        } catch (\Exception $e) {
            Log::channel('queue_workers')->error("Failed to start workers", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'environment' => $environmentInfo
            ]);
            
            $this->error($e->getMessage());
        }
    }

    private function startWorker(string $command): int
    {
        $result = Process::run("{$command} > /dev/null 2>&1 & echo $!");
        $pid = (int) trim($result->output());

        Log::channel('queue_workers')->info("Worker process execution", [
            'command' => $command,
            'pid' => $pid,
            'success' => $result->successful(),
            'output' => $result->output(),
            'error' => $result->errorOutput()
        ]);

        return $pid;
    }

    private function countRunningWorkers(array $pids): int
    {
        $runningCount = 0;
        foreach ($pids as $pid) {
            $result = Process::run("ps -p {$pid}");
            $isRunning = $result->successful();
            
            Log::channel('queue_workers')->info("Checking worker process", [
                'pid' => $pid,
                'is_running' => $isRunning,
                'ps_output' => $result->output(),
                'ps_error' => $result->errorOutput()
            ]);

            if ($isRunning) {
                $runningCount++;
            }
        }
        return $runningCount;
    }

    private function getRunningWorkers(): array
    {
        $result = Process::run("ps aux | grep '[q]ueue:work'");
        return array_filter(explode("\n", $result->output()));
    }

    private function getCommandPrefix(): string
    {
        $isLocal = App::environment('local');
        Log::channel('queue_workers')->info("Command prefix check", [
            'is_local' => $isLocal,
            'app_env' => App::environment()
        ]);

        return $isLocal ? 'docker compose exec -T app ' : '';
    }
}