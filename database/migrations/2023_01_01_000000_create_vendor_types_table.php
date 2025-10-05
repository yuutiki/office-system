<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_types', function (Blueprint $table) {
            $table->id();
            $table->string('code',2)->unique()->comment('業者種別コード');
            $table->string('name',100)->comment('業者種別名称');

            $table->boolean('is_active')->default(true)->comment('登録有効フラグ');
            $table->boolean('is_searchable')->default(true)->comment('検索有効フラグ');

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_types');
    }
};
