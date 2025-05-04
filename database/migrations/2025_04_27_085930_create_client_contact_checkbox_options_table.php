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
        Schema::create('client_contact_checkbox_options', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // チェックボックスの名前（例：is_billing_receiver）
            $table->string('label'); // 表示ラベル（例：請求先）
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_contact_checkbox_options');
    }
};
