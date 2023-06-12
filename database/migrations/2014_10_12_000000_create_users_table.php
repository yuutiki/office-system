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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->length(6)->nullable()->comment('社員番号'); //追記
            $table->string('name');
            $table->string('name_kana');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('role_id')->default(3)->comment('権限ID'); //追記 rolesテーブル参照
            $table->ipAddress('access_ip')->nullable()->comment('アクセスIPアドレス'); //追記
            $table->timestamp('last_login_at')->nullable()->comment('最終ログイン日時'); //追記
            $table->foreignId('employee_status_id')->default(1)->comment('雇用状態'); //追記 employee_statusesテーブル参照
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
