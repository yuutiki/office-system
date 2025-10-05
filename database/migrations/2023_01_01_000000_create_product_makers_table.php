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
            $table->string('maker_name',100)->comment('製品メーカー名称');

            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->boolean('is_searchable')->default(true)->comment('検索有効フラグ');

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
