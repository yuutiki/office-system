<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('client_id')->comment('顧客ID');// clientsテーブルのID
            $table->string('last_name',100)->nullable(true)->comment('姓');
            $table->string('first_name',100)->nullable(true)->comment('名');
            $table->string('last_name_kana',100)->nullable(true)->comment('カナ姓');
            $table->string('first_name_kana',100)->nullable(true)->comment('カナ名');
            $table->string('division_name',100)->nullable(true)->comment('部署名');
            $table->string('position_name',100)->nullable(true)->comment('役職名');
            $table->string('tel1',15)->nullable(true)->comment('電話番号1');
            $table->string('tel2',15)->nullable(true)->comment('電話番号2');
            $table->string('fax1',15)->nullable(true)->comment('FAX番号1');
            $table->string('fax2',15)->nullable(true)->comment('FAX番号2');
            $table->string('int_tel',15)->nullable(true)->comment('内線番号');
            $table->string('phone',15)->nullable(true)->comment('携帯番号');
            $table->string('mail',255)->nullable(true)->comment('メールアドレス1');
            $table->string('mail2',255)->nullable(true)->comment('メールアドレス2');
            $table->string('post_code',8)->nullable(true)->comment('郵便番号'); // ハイフンなしで登録する
            $table->foreignId('prefecture_id')->nullable(true)->comment('都道府県ID');// prefecturesテーブルのID
            $table->string('address_1',300)->nullable(true)->comment('住所1');
            $table->text('client_contact_memo')->nullable(true)->comment('担当者備考');

            $table->boolean('is_retired')->default(0)->comment('退職フラグ');
            $table->boolean('is_billing_receiver')->default(0)->comment('請求先フラグ');
            $table->boolean('is_payment_receiver')->default(0)->comment('支払先フラグ');
            
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_contacts');
    }
};







