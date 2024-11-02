<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue API supports an assortment of back-ends via a single
    | API, giving you convenient access to each back-end using the same
    | syntax for every one. Here you may define a default connection.
    |
    */

    'default' => env('QUEUE_CONNECTION', 'sync'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
            'after_commit' => false,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => 'localhost',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => 0,
            'after_commit' => false,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
            'after_commit' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Worker 設定
    |--------------------------------------------------------------------------
    |
    | Workerの動作に関する基本設定を定義します。
    | max_jobs: 1つのWorkerが処理する最大ジョブ数
    | max_time: Workerの最大実行時間（秒）
    | memory: 使用可能な最大メモリ量（MB）
    |
    | これらの値は環境変数で上書き可能です。
    |
    */

    'worker' => [
        'max_jobs' => env('QUEUE_WORKER_MAX_JOBS', 100),  // デフォルト100ジョブまで
        'max_time' => env('QUEUE_WORKER_MAX_TIME', 3600), // デフォルト1時間
        'memory' => env('QUEUE_WORKER_MEMORY', 128),      // デフォルト128MB
    ],

    /*
    |--------------------------------------------------------------------------
    | キューの優先度設定
    |--------------------------------------------------------------------------
    |
    | 各キューの詳細設定を定義します。
    | name: キュー名
    | priority: 優先度（数値が小さいほど優先度が高い）
    | max_tries: ジョブの最大再試行回数
    | timeout: ジョブの実行タイムアウト時間（秒）
    |
    | この設定により、ジョブの重要度に応じた実行制御が可能になります。
    |
    */

    'priorities' => [
        // 最優先キュー
        'high' => [
            'name' => 'high',
            'priority' => 1,        // 最優先
            'max_tries' => 3,      // 失敗時は3回まで再試行
            'timeout' => 60,       // 1分でタイムアウト
        ],
        // 通常キュー
        'default' => [
            'name' => 'default',
            'priority' => 2,        // 通常優先度
            'max_tries' => 2,      // 失敗時は2回まで再試行
            'timeout' => 45,       // 45秒でタイムアウト
        ],
        // 低優先キュー
        'low' => [
            'name' => 'low',
            'priority' => 3,        // 最低優先
            'max_tries' => 1,      // 再試行なし
            'timeout' => 30,       // 30秒でタイムアウト
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Job Batching
    |--------------------------------------------------------------------------
    |
    | The following options configure the database and table that store job
    | batching information. These options can be updated to any database
    | connection and table which has been defined by your application.
    |
    */

    'batching' => [
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'job_batches',
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control which database and table are used to store the jobs that
    | have failed. You may change them to any database / table you wish.
    |
    */

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

];
