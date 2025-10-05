<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prefectures', function (Blueprint $table) {
            $table->id();
            $table->string('prefecture_code',2)->unique()->comment('都道府県コード');
            $table->string('prefecture_name',100)->comment('都道府県名称');
            $table->string('prefecture_eng_name',)->nullable()->comment('都道府県英名称');
            
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->boolean('is_searchable')->default(true)->comment('検索有効フラグ');

            $table->foreignId('created_by')->nullable(true)->constrained('users')->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->constrained('users')->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prefectures');
    }
};
