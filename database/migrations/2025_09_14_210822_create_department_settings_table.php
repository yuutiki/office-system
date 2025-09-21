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
        Schema::create('department_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('max_level')->default(10)->comment('部門の最大階層数');
            $table->unsignedTinyInteger('code_length')->default(6)->comment('部門コードの桁数');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });

        // 初期値を1件挿入
        DB::table('department_settings')->insert([
            'max_level'   => 10,
            'code_length' => 6,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_settings');
    }
};
