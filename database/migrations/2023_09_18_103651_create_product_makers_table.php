<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_makers', function (Blueprint $table) {
            $table->id();
            $table->string('maker_code',2)->unique()->comment('製品メーカーコード');
            $table->string('maker_name',20)->comment('製品メーカー名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_makers');
    }
};
