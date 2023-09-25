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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code',13)->comment('製品コード');
            $table->foreignId('product_maker_id')->comment('メーカーID'); //add
            $table->foreignId('department_id')->comment('事業部ID');
            $table->foreignId('product_type_id')->comment('製品種別ID');
            $table->foreignId('product_split_type_id')->comment('製品内訳種別ID');
            $table->foreignId('product_series_id')->comment('製品シリーズID');
            $table->decimal('unit_price', $precision = 12, $scale = 2)->default(0)->comment('標準単価');
            $table->string('product_name',50)->comment('製品名称');
            $table->string('product_short_name',50)->comment('製品略称');
            $table->boolean('is_stop_selling')->default(0)->comment('販売停止フラグ');
            $table->boolean('is_listed')->default(0)->comment('一覧表示対象フラグ');// 顧客の導入・契約一覧に表示するシステムかどうか
            $table->text('product_memo1')->nullable()->comment('製品備考1');
            $table->text('product_memo2')->nullable()->comment('製品備考2');
            $table->foreignId('crated_by')->nullable()->comment('作成者');
            $table->foreignId('updated_by')->nullable()->comment('更新者');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
