<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->id();
            $table->string('corporation_num',6)->unique()->comment('法人№');
            $table->string('corporation_name')->comment('法人名称');
            $table->string('corporation_kana_name')->comment('法人カナ名称');
            $table->string('corporation_short_name')->comment('法人略称');
            $table->decimal('credit_limit',10, 0)->default(0)->comment('与信限度額');
            $table->text('memo')->nullable(true)->commebt('法人メモ');
            $table->boolean('is_stop_trading')->default(0)->comment('取引停止フラグ');
            $table->text('stop_trading_reason')->nullable(true)->comment('取引停止理由');
            $table->string('invoice_num')->nullable(true)->comment('インボイス番号');
            $table->string('invoice_at')->nullable(true)->comment('インボイス登録日');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corporations');
    }
};
