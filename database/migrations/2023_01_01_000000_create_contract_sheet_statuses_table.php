<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_sheet_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('contract_sheet_status_code',2)->unique()->comment('契約書状態コード');
            $table->string('contract_sheet_status_name',20)->comment('契約書状態名称');
            $table->string('contract_sheet_status_name_en',20)->nullable(true)->comment('契約書状態英名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_sheet_statuses');
    }
};
