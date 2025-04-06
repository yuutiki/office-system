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
        Schema::create('user_column_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('page_identifier'); // 例: 'corporations_index'
            $table->json('visible_columns'); // 表示する列の配列をJSON形式で保存
            $table->datetimes();
        
            $table->unique(['user_id', 'page_identifier']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_column_settings');
    }
};
