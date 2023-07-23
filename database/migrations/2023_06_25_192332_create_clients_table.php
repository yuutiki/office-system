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
            $table->string('client_num',10)->unique()->comment('顧客番号');
            $table->string('client_name',255)->comment('顧客名称');
            $table->string('client_kana_name',255)->comment('顧客カナ名称');
            $table->string('department_name',100)->comment('管轄事業部');
            $table->text('memo',1000)->nullable()->comment('備考');
            $table->string('distribution',50)->nullable()->default('直販')->comment('商流');
            $table->string('head_post_code',80)->nullable()->comment('本部郵便番号');
            $table->string('head_prefecture',80)->nullable()->comment('本部都道府県');
            $table->string('head_address1',80)->nullable()->comment('本部住所1');
            $table->string('head_address2',80)->nullable()->comment('本部住所2');
            $table->string('head_address3',80)->nullable()->comment('本部住所3');
            $table->string('head_tel',80)->nullable()->comment('代表TEL');
            $table->unsignedBigInteger('students')->length(5)->nullable()->comment('学生数');
            $table->unsignedBigInteger('user_id')->nullable()->comment('営業担当');//add Usersテーブル参照
            $table->unsignedBigInteger('installation_type_id')->nullable()->comment('設置種別');//add Installation_typesテーブル参照
            $table->unsignedBigInteger('client_type_id')->nullable()->comment('顧客種別');//add Client_typesテーブル参照
            $table->unsignedBigInteger('trade_status_id')->comment('取引状態');//add Trade_statusesテーブル参照
            $table->foreignId('client_corporation_id')->comment('法人ID'); //add ClientCorporationsテーブル参照
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('client_corporation_id')->references('id')->on('client_corporations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('installation_type_id')->references('id')->on('installation_types');
            $table->foreign('client_type_id')->references('id')->on('client_types');
            $table->foreign('trade_status_id')->references('id')->on('trade_statuses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
