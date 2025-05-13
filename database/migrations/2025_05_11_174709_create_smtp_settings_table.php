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
        Schema::create('smtp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('設定名');
            $table->string('host')->comment('SMTPホスト');
            $table->integer('port')->comment('ポート番号');
            $table->string('username')->comment('ユーザー名');
            $table->string('password')->nullable()->comment('パスワード（通常認証用）');
            $table->enum('encryption', ['none', 'tls', 'ssl'])->nullable()->default('tls')->comment('暗号化方式');
            $table->string('from_address')->comment('送信元メールアドレス');
            $table->string('from_name')->comment('送信元名');
            $table->enum('type', ['internal', 'external'])->comment('設定タイプ（社内/社外）');
            $table->boolean('is_active')->default(false)->comment('有効フラグ');
            
            // OAuth認証用のカラム
            $table->enum('auth_type', ['password', 'oauth'])->default('password')->comment('認証タイプ');
            $table->text('oauth_client_id')->nullable();
            $table->text('oauth_client_secret')->nullable();
            $table->text('oauth_refresh_token')->nullable();
            $table->text('oauth_access_token')->nullable();
            $table->dateTime('oauth_expires_at')->nullable();
            
            $table->datetimes();
            
            // 設定タイプごとに1つのアクティブ設定のみ許可
            $table->unique(['type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smtp_settings');
    }
};
