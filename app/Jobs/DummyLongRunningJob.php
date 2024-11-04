<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DummyLongRunningJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * ジョブの試行回数
     */
    public $tries = 3;

    /**
     * ジョブのタイムアウト時間（秒）
     */
    public $timeout = 180; // 3分（余裕を持って設定）

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // 必要に応じてキューを指定
        $this->onQueue('high');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $startTime = now();
        Log::info("Starting dummy long running job", [
            'job_id' => $this->job->getJobId(),
            'started_at' => $startTime
        ]);

        // 2分間スリープ
        sleep(60);

        $endTime = now();
        $duration = $endTime->diffInSeconds($startTime);

        Log::info("Completed dummy long running job", [
            'job_id' => $this->job->getJobId(),
            'duration' => $duration,
            'started_at' => $startTime,
            'ended_at' => $endTime
        ]);
    }

    /**
     * ジョブの失敗を処理
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Dummy job failed", [
            'job_id' => $this->job->getJobId(),
            'error' => $exception->getMessage()
        ]);
    }
}