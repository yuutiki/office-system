<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('employee_num',6)->unique()->comment('社員番号'); 
            $table->string('last_name',255)->nullable(true)->comment('姓');
            // $table->string('middle_name',255)->nullable(true)->comment('ミドルネーム');
            $table->string('first_name',255)->nullable(true)->comment('名');
            $table->string('name',255)->comment('氏名');
            $table->string('kana_name',255)->comment('カナ氏名');
            $table->date('birth')->nullable(true)->comment('生年月日');
            $table->string('email',100)->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable(true)->comment('メール認証日時');
            $table->string('password',255)->comment('パスワード');
            $table->rememberToken()->nullable(true)->comment('トークン');
            $table->string('int_phone',15)->nullable(true)->comment('内線番号');
            $table->string('ext_phone',15)->nullable(true)->comment('外線番号');
            $table->ipAddress('access_ip')->nullable(true)->comment('アクセスIPアドレス'); //追記
            $table->timestamp('last_login_at')->nullable(true)->comment('最終ログイン日時'); //追記
            $table->boolean('is_enabled')->default(1)->comment('有効フラグ'); 
            $table->foreignId('role_id')->default(4)->comment('権限ID'); //追記 rolesテーブル参照
            $table->foreignId('employee_status_id')->default(1)->comment('雇用状態ID');//追記 employee_statusesテーブル参照
            $table->foreignId('affiliation1_id')->comment('第一所属階層ID'); 
            $table->foreignId('department_id')->comment('事業部ID'); 
            $table->foreignId('affiliation3_id')->comment('第三所属階層ID'); 
            $table->string('profile_image')->nullable(true)->default('default.png')->comment('プロフ画像');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
