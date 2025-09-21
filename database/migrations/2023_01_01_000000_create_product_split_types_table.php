<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_split_types', function (Blueprint $table) {
            $table->id();
            $table->string('split_type_code',4)->unique()->comment('製品内訳種別コード');
            $table->string('split_type_name',20)->comment('製品内訳種別名称');
            $table->foreignId('product_type_id')->comment('製品種別コード'); //product_typesテーブル参照
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('product_split_types');
    }
};
