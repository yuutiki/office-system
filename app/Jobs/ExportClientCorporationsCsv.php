<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exports\ClientCorporationsExport;
use Illuminate\Support\Facades\Storage;
use App\Models\ClientCorporation;

class ExportClientCorporationsCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filters;

    /**
     * Create a new job instance.
     */
    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
     * Execute the job.
     */
    public function handle(): string
    {
        \Log::info('ジョブが実行されました。');
        $clientCorporations = ClientCorporation::filter($this->filters)
            ->withCount('clients')
            ->sortable()
            ->get();

        // 生成されたファイル名
        $csvFileName = 'clientcorporations_' . now()->format('YmdHis') . '.csv';

        dd('$csvFileName'); // この行を追加してジョブがどこまで実行されているか確認

        // CSVヘッダーの動的生成
        $csvFileContent = $this->generateCsvHeader(ClientCorporation::class);

        // CSVデータの追加
        foreach ($clientCorporations as $item) {
            $csvFileContent .= $this->generateCsvRow($item);
        }

        // ファイルの保存先
        $csvFilePath = public_path("storage/{$csvFileName}");

        // ファイルの保存
        Storage::put($csvFilePath, $csvFileContent);

        return $csvFilePath;
    }

    /**
     * Generate CSV header dynamically.
     */
    private function generateCsvHeader($modelClass): string
    {
        $model = new $modelClass;
        $columns = $model->getFillable();

        return implode(',', $columns) . "\n";
    }

    /**
     * Generate CSV row for a given model instance.
     */
    private function generateCsvRow($model): string
    {
        $rowData = [];
        foreach ($model->getFillable() as $column) {
            $rowData[] = $model->{$column};
        }

        return implode(',', $rowData) . "\n";
    }
}
