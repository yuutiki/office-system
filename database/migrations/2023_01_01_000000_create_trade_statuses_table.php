<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trade_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('trade_status_code',2)->unique()->comment('取引種別コード');
            $table->string('trade_status_name',20)->comment('取引種別名称');
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trade_statuses');
    }
};
