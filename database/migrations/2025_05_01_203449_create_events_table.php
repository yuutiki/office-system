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
        Schema::create('events', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->boolean('all_day')->default(false);
            $table->foreignId('event_category_id')->nullable();
            $table->string('meeting_url')->nullable()->comment('会議リンク');
            $table->string('location')->nullable()->comment('場所');
            $table->string('color', 30)->nullable();
            $table->foreignId('owner_id')->constrained('users'); // イベント作成者
            $table->string('source')->default('internal'); // データソース (internal, google, outlook など)
            $table->string('external_id')->nullable(); // 外部サービスでのID
            $table->boolean('is_public')->default(true); // 公開/非公開設定
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
