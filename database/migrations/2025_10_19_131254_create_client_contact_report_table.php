<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_contact_report', function (Blueprint $table) {
            $table->id();

            // ✅ ULID参照に変更
            $table->foreignUlid('client_contact_id')
                ->constrained('client_contacts')
                ->cascadeOnDelete();

            // reports テーブルが通常のid (bigint) の場合はこちら
            $table->foreignId('report_id')
                ->constrained('reports')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_contact_report');
    }
};
