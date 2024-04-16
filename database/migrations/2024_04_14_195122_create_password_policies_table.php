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
        Schema::create('password_policies', function (Blueprint $table) {
            $table->id();
            $table->integer('min_length')->default(8);
            $table->boolean('require_uppercase')->default(true)->comment('英大文字必須');
            $table->boolean('require_lowercase')->default(true)->comment('英小文字必須');
            $table->boolean('require_numeric')->default(true)->comment('半角数字必須');
            $table->boolean('require_symbol')->default(true)->comment('記号文字必須');
            $table->boolean('banned_email_use')->default(true)->comment('メールアドレスを含めるのを禁止');
            $table->boolean('banned_password_reuse')->default(true)->comment('前回パスワード再利用を禁止');
            $table->unsignedInteger('max_login_attempt')->default(5)->comment('アカウントロックまでの試行回数'); 
            $table->unsignedInteger('lockout_time')->default(30)->comment('アカウントロック解除までの時間（分）'); 
            $table->unsignedInteger('date_inactive')->default(30)->comment('最終ログインから◯日経過したら自動無効化');
            $table->unsignedInteger('date_password_expiration')->default(90)->comment('パスワード有効期限');
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
        Schema::dropIfExists('password_policies');
    }
};