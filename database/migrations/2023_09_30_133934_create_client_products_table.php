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
            $table->foreignId('client_id')->nullable(false)->comment('顧客コード');//顧客tableを参照
            $table->foreignId('product_id')->nullable(false)->comment('製品コード');//製品tableを参照
            $table->unsignedInteger('quantity')->nullable(false)->length(2)->comment('数量');//非負の整数
            $table->foreignId('product_version_id')->nullable(false)->comment('バージョン');//バージョンtableを参照
            $table->boolean('is_customized')->nullable(false)->comment('CUSフラグ');
            $table->boolean('is_contracted')->nullable(false)->comment('契約フラグ');
            $table->text('install_memo')->nullable(false)->comment('導入メモ');
            $table->foreignId('crated_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_products');
    }
};
