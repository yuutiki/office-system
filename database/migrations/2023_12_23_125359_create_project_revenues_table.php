<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_revenues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->comment('プロジェクトID');
            $table->date('revenue_year_month')->comment('売上年月');
            $table->decimal('revenue',10, 0)->default(0)->comment('売上金額');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_revenues');
    }
};
