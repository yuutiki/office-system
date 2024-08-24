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
        Schema::create('corporation_credits', function (Blueprint $table) {
            $table->ulid('ulid')->primary();
            $table->foreignUlid('corporation_id')->comment('法人ID');
            $table->decimal('credit_limit', 15, 0)->default(0)->comment('与信限度額');
            $table->integer('credit_rate')->default(0)->comment('与信評価点');
            $table->string('credit_rater', 100)->nullable(true)->comment('与信評価者');
            $table->text('credit_reason',1000)->nullable(true)->comment('与信根拠');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            // 外部キー制約(親法人が削除されたとき、関連する子レコードも削除する)
            $table->foreign('corporation_id')->references('id')->on('corporations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporation_credits');
    }
};
