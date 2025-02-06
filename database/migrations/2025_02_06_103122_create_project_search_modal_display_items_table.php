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
        Schema::create('project_search_modal_display_items', function (Blueprint $table) {
            $table->id();
            $table->string('screen_id', 50)->comment('画面ID');
            $table->string('column_key', 50)->comment('カラムキー');
            $table->string('display_default_name', 50)->comment('デフォルト表示名');
            $table->string('display_name', 50)->comment('表示名');
            $table->integer('display_order')->comment('表示順');
            $table->boolean('is_visible')->default(true)->comment('表示フラグ');
            $table->datetimes();

            // 画面IDとカラムキーの組み合わせでユニーク制約
            $table->unique(['screen_id', 'column_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_search_modal_display_items');
    }
};
