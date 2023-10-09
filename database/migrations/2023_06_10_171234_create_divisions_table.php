<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('division_code',2)->unique()->comment('部署コード');
            $table->string('division_name',100)->comment('部署名称');
            $table->string('division_kana_name',100)->nullable(true)->comment('部署カナ名称');
            $table->string('division_eng_name',100)->nullable(true)->comment('部署英名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
