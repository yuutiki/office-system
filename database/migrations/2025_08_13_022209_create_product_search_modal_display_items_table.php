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
        Schema::create('product_search_modal_display_items', function (Blueprint $table) {
            $table->id();
            $table->string('screen_id')->comment('画面ID');  // どの画面の検索モーダルかを識別
            $table->string('column_key')->comment('項目キー'); // 表示する項目のキー（例：client_name, client_num）
            $table->string('display_default_name')->comment('画面表示名（標準）');
            $table->string('display_name')->comment('画面表示名');
            $table->integer('display_order')->comment('表示順');
            $table->boolean('is_visible')->default(true);
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_search_modal_display_items');
    }
};
