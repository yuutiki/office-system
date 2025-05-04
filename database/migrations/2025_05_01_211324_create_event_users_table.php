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
        Schema::create('event_users', function (Blueprint $table) {
            $table->id();
            $table->ulid('event_id');
            $table->foreignId('user_id');
            $table->enum('status', ['invited', 'accepted', 'declined', 'tentative'])->default('invited');
            $table->datetimes();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['event_id', 'user_id']); // 同じイベントに同じユーザーが複数参加することはない
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_users');
    }
};
