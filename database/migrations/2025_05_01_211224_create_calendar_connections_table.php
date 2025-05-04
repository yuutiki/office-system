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
        Schema::create('calendar_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('provider', ['google', 'outlook', 'apple', 'other']);
            $table->string('calendar_id'); // 外部カレンダーのID
            $table->string('name'); // カレンダーの名前
            $table->json('access_token'); // トークン情報（暗号化推奨）
            $table->dateTime('token_expires_at');
            $table->string('refresh_token')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('sync_settings')->nullable(); // 同期設定
            $table->timestamp('last_synced_at')->nullable(); // 最後に同期した日時
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_connections');
    }
};
