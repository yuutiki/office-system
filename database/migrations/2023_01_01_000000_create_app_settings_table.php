<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_code')->unique()->comment('設定コード');
            $table->string('setting_name')->comment('設定名（日）');
            $table->string('setting_name_en')->comment('設定名（英）');
            $table->text('description')->nullable()->comment('説明文');
            $table->boolean('is_editable')->default(false)->comment('編集可能フラグ');
            $table->string('route')->nullable()->comment('設定画面のルート名');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
