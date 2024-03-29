<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_change_types', function (Blueprint $table) {
            $table->id();
            $table->string('contract_change_type_code',2)->unique()->comment('契約変更種別コード');
            $table->string('contract_change_type_name',20)->comment('契約変更種別名称');
            $table->string('contract_change_type_name_en',20)->nullable(true)->comment('契約変更種別英名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_change_types');
    }
};
