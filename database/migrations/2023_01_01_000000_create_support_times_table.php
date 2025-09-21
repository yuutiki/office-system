<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_times', function (Blueprint $table) {
            $table->id();
            $table->string('code',2)->unique()->comment('所要時間コード');
            $table->string('name',20)->comment('所要時間名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_times');
    }
};
