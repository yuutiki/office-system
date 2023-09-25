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
            $table->foreignId('crated_by')->nullable()->comment('作成者'); //usersテーブル参照
            $table->foreignId('updated_by')->nullable()->comment('更新者'); //usersテーブル参照
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('product_split_types');
    }
};
