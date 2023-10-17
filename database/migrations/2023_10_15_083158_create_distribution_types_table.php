<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('distribution_types', function (Blueprint $table) {
            $table->id();
            $table->string('distribution_type_code',2)->unique()->comment('商流種別コード');
            $table->string('distribution_type_name',20)->comment('商流種別名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distribution_types');
    }
};
