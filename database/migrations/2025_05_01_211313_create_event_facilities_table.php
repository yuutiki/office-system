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
        Schema::create('event_facilities', function (Blueprint $table) {
            $table->id();
            $table->ulid('event_id');
            $table->ulid('facility_id');
            $table->text('notes')->nullable(); // 予約に関する追加メモ
            $table->datetimes();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
            $table->unique(['event_id', 'facility_id']); // 同じイベントで同じ設備を複数予約することはない
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_facilities');
    }
};
