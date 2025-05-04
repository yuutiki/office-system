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
        Schema::create('client_contact_checkbox_values', function (Blueprint $table) {
            $table->id();
            // client_contact_idをulid型に変更
            $table->ulid('client_contact_id');
            // 外部キー制約を手動で設定（client_contactsのulid型のidに対応）
            $table->foreign('client_contact_id')->references('id')->on('client_contacts')->onDelete('cascade');

            $table->foreignId('checkbox_option_id')->constrained('client_contact_checkbox_options')->onDelete('cascade');
            $table->boolean('value')->default(false);
            $table->datetimes();
            
            // 重複を防ぐためのユニーク制約
            $table->unique(['client_contact_id', 'checkbox_option_id'], 'cc_checkbox_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_contact_checkbox_values');
    }
};
