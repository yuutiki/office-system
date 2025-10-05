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
        Schema::create('project_types', function (Blueprint $table) {
            $table->id();
            $table->string('project_type_code',2)->unique()->comment('プロジェクト種別コード');
            $table->string('project_type_name',100)->comment('プロジェクト種別名称');

            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->boolean('is_searchable')->default(true)->comment('検索有効フラグ');

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_types');
    }
};
