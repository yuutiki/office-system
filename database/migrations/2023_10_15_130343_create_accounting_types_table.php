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
        Schema::create('accounting_types', function (Blueprint $table) {
            $table->id();
            $table->string('accounting_type_code',2)->unique()->comment('計上種別コード');
            $table->string('accounting_type_name',20)->comment('計上種別名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('accounting_types');
    }
};
