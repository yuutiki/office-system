<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->comment('顧客ID');//顧客tableを参照
            $table->foreignId('product_id')->comment('製品ID');//製品tableを参照
            $table->unsignedInteger('quantity')->length(2)->comment('数量');//非負の整数
            $table->foreignId('product_version_id')->comment('バージョン');//バージョンtableを参照
            $table->boolean('is_customized')->comment('CUSフラグ');
            $table->boolean('is_contracted')->comment('契約フラグ');
            $table->text('install_memo')->nullable(true)->comment('導入メモ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_products');
    }
};
