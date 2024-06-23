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
        Schema::create('project_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->comment('プロジェクトID');
            $table->foreignId('user_id')->comment('ユーザID');
            $table->date('payment_at')->comment('支払日');
            $table->decimal('payment_amount', 10, 0)->comment('支払金額');
            $table->string('payment_to', 100)->comment('支払先');
            $table->string('payment_method', 50)->comment('支払方法');
            $table->text('expense_memo')->nullable()->comment('経費備考');
            $table->string('account_title', 50)->nullable()->comment('勘定科目');
            $table->string('account_description', 100)->nullable()->comment('摘要');
            $table->string('input_mode', 50)->comment('入力方法');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_expenses');
    }
};
