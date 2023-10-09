<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department_code',2)->unique()->comment('事業部コード');
            $table->string('prefix_code')->unique()->comment('プレフィックスコード');
            $table->string('department_name',100)->comment('事業部名称');
            $table->string('department_kana_name',100)->nullable(true)->comment('事業部カナ名称');
            $table->string('department_eng_name',100)->nullable(true)->comment('事業部英名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
