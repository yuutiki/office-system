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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->comment('部門コード');
            $table->string('name', 100)->comment('部門名');
            $table->string('name_kana',100)->nullable(true)->comment('部門カナ名称');
            $table->string('name_en',100)->nullable(true)->comment('部門英名称');
            $table->string('name_short',100)->nullable(true)->comment('部門略称');

            $table->unsignedBigInteger('parent_id')->nullable()->comment('親部門ID');
            $table->unsignedTinyInteger('level')->default(1)->comment('階層レベル');
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->foreign('parent_id')->references('id')->on('departments')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
