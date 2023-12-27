<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_code',2)->unique()->comment('会社コード');
            $table->string('company_name',100)->comment('会社名称');
            $table->string('company_kana_name',100)->nullable(true)->comment('会社カナ名称');
            $table->string('company_eng_name',100)->nullable(true)->comment('会社英名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
