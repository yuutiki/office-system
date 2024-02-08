<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->comment('顧客ID');// clientsテーブルのID
            $table->string('last_name',100)->nullable(true)->comment('姓');
            $table->string('first_name',100)->nullable(true)->comment('名');
            $table->string('last_name_kana',100)->nullable(true)->comment('カナ姓');
            $table->string('first_name_kana',100)->nullable(true)->comment('カナ名');
            $table->string('division_name',100)->nullable(true)->comment('部署名');
            $table->string('position_name',100)->nullable(true)->comment('役職名');
            $table->string('tel1',15)->nullable(true)->comment('電話番号1');
            $table->string('tel2',15)->nullable(true)->comment('電話番号2');///いらん
            $table->string('fax1',15)->nullable(true)->comment('FAX番号1');
            $table->string('fax2',15)->nullable(true)->comment('FAX番号2');///いらん
            $table->string('int_tel',15)->nullable(true)->comment('内線番号');///いらん
            $table->string('phone',15)->nullable(true)->comment('携帯番号');
            $table->string('mail',30)->nullable(true)->comment('メールアドレス');
            $table->string('head_post_code',8)->nullable(true)->comment('郵便番号');//////ハイフンありで登録する
            $table->foreignId('prefecture_id',80)->nullable(true)->comment('都道府県ID');/////////////IDを登録する
            $table->string('head_address1',300)->nullable(true)->comment('住所1');
            $table->text('person_memo',1000)->nullable(true)->comment('担当者備考');
            $table->boolean('is_retired')->default(0)->comment('退職フラグ');
            $table->boolean('is_billing_receiver')->default(0)->comment('請求先フラグ');
            $table->boolean('is_payment_receiver')->default(0)->comment('支払先フラグ');
            $table->boolean('is_support_info_receiver')->default(0)->comment('サポートシートフラグ');
            $table->boolean('is_closing_info_receiver')->default(0)->comment('休業案内フラグ');
            $table->boolean('is_exhibition_info_receiver')->default(0)->comment('展示会案内フラグ');
            $table->boolean('is_cloud_info_receiver')->default(0)->comment('クラウド会案内フラグ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_people');
    }
};







