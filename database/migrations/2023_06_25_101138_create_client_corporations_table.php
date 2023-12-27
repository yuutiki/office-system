<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_corporations', function (Blueprint $table) {
            $table->id();
            $table->string('clientcorporation_num',6)->unique()->comment('法人番号');
            $table->string('clientcorporation_name')->comment('法人名称');
            $table->string('clientcorporation_kana_name')->comment('法人カナ名称');
            $table->string('clientcorporation_short_name')->comment('法人略称');
            $table->unsignedInteger('credit_limit')->default(0)->comment('与信限度額');
            $table->text('memo')->nullable(true)->commebt('法人メモ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_corporations');
    }
};
