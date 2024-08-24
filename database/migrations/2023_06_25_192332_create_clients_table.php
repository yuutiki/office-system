<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_num',12)->unique()->comment('顧客番号');
            $table->string('client_name',255)->comment('顧客名称');
            $table->string('client_kana_name',255)->comment('顧客カナ名称');
            $table->foreignId('affiliation2_id')->comment('管轄事業部ID');//Affiliation2テーブル参照
            $table->foreignId('user_id')->nullable(true)->comment('営業担当ID');// Usersテーブル参照
            $table->foreignId('installation_type_id')->nullable(true)->comment('設置種別ID');// Installation_typesテーブル参照
            $table->foreignId('client_type_id')->nullable(true)->comment('顧客種別ID');// Client_typesテーブル参照
            $table->foreignId('trade_status_id')->comment('取引状態ID');// Trade_statusesテーブル参照
            $table->foreignUlid('corporation_id')->comment('法人ID'); // Corporationsテーブル参照

            $table->string('head_post_code',80)->nullable(true)->comment('本店郵便番号');
            $table->string('head_prefecture',80)->nullable(true)->comment('本店都道府県');
            $table->string('head_address1',80)->nullable(true)->comment('本店住所1');
            $table->string('head_tel',80)->nullable(true)->comment('本店TEL');
            $table->string('head_fax',80)->nullable(true)->comment('本店FAX');
            $table->foreignId('students')->length(5)->nullable(true)->comment('学生数');
            $table->text('memo',1000)->nullable(true)->comment('備考');

            $table->string('distribution',100)->nullable(true)->default('直販')->comment('商流');
            $table->foreignId('dealer_id')->nullable(true)->comment('ディーラID');// Vendorテーブルから取得
            
            $table->boolean('is_enduser')->default(0)->comment('エンドユーザフラグ');
            $table->boolean('is_supplier')->default(0)->comment('仕入外注先フラグ');
            $table->boolean('is_dealer')->default(0)->comment('ディーラフラグ');
            $table->boolean('is_lease')->default(0)->comment('リース会社フラグ');
            $table->boolean('is_other_partner')->default(0)->comment('その他協業フラグ');
            $table->boolean('is_closed')->default(0)->comment('閉校フラグ');

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->index('client_num');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
