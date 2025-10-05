<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mpdf\Tag\Tr;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_num',6)->unique()->comment('ユーザ№'); 
            $table->string('user_name',255)->comment('ユーザ名');
            $table->string('user_kana_name',255)->comment('ユーザカナ名');
            $table->date('birth')->nullable(true)->comment('生年月日');
            $table->date('employment_at')->nullable(true)->comment('入職年月日');
            $table->string('email',100)->unique()->comment('メールアドレス'); // default
            $table->timestamp('email_verified_at')->nullable(true)->comment('メール認証日時'); // default
            $table->string('password',255)->comment('パスワード'); // default
            $table->rememberToken()->nullable(true)->comment('トークン'); // default
            $table->string('int_phone',15)->nullable(true)->comment('内線番号');
            $table->string('ext_phone',15)->nullable(true)->comment('外線番号');
            $table->ipAddress('access_ip')->nullable(true)->comment('アクセスIPアドレス'); //追記
            $table->timestamp('last_login_at')->nullable(true)->comment('最終ログイン日時'); //追記
            $table->boolean('is_enabled')->default(1)->comment('有効フラグ'); 
            // $table->foreignId('role_id')->default(4)->comment('権限ID'); //追記 rolesテーブル参照
            $table->foreignId('employee_status_id')->default(1)->comment('雇用状態ID');//追記 employee_statusesテーブル参照
            $table->foreignId('affiliation1_id')->nullable()->comment('第一所属階層ID'); 
            $table->foreignId('affiliation2_id')->nullable()->comment('第二所属階層ID'); 
            $table->foreignId('department_id')->nullable(true)->comment('所属部門ID'); 
            $table->string('profile_image')->default('users/profile_image/default.png')->comment('プロフ画像');
            $table->string('user_stamp_image')->default('users/stamp_image/default_user_stamp.png')->comment('個人印鑑画像');
            $table->boolean('password_change_required')->default(0)->comment('強制PW変更フラグ'); 

            $table->string('role')->default('user'); // システム管理者と利用ユーザを区別するためのカラム

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