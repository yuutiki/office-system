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
        Schema::create('estimate_details', function (Blueprint $table) {
            $table->ulid('ulid')->primary();
            $table->ulid('estimate_id')->comment('見積書ID');
            $table->foreignId('product_id')->nullable(true)->comment('商品ID');
            $table->string('product_name')->nullable(true)->comment('商品名称');
            $table->string('product_model_num')->nullable(true)->comment('型番');
            $table->decimal('unit_price', 10, 2)->nullable(true)->comment('単価/個');
            $table->decimal('unit_cost', 10, 2)->nullable(true)->comment('原価/個');
            $table->integer('quantity')->nullable(true)->comment('数量');
            // $table->decimal('amount', 10, 2)->comment('標準価格'); 計算で求める
            $table->decimal('discount', 10, 2)->nullable(true)->comment('値引額');
            $table->integer('sort_order')->default(0)->comment('並び順');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->foreign('estimate_id')->references('ulid')->on('estimates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_details');
    }
};
