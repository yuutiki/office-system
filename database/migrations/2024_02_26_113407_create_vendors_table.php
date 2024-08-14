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
        Schema::create('vendors', function (Blueprint $table) {
            // $table->id();
            $table->ulid('ulid')->primary();

            $table->string('vendor_num',12)->unique()->comment('業者No.');
            $table->string('vendor_name',255)->comment('業者名称');
            $table->string('vendor_kana_name',255)->comment('業者カナ名称');
            $table->foreignId('corporation_id')->comment('法人ID'); // ClientCorporationsテーブル参照
            $table->foreignId('affiliation2_id')->comment('管轄事業部ID');// Affiliation2テーブル参照
            $table->foreignId('vendor_type_id')->nullable(true)->comment('業者種別ID');// Client_typesテーブル参照
            $table->text('vendor_memo', 1000)->nullable(true)->comment('業者備考');//


            $table->string('vendor_post_code', 80)->nullable(true)->comment('業者郵便番号');//
            $table->string('vendor_prefecture_id', 80)->nullable(true)->comment('業者都道府県');//
            $table->string('vendor_address1', 80)->nullable(true)->comment('業者住所1');//
            $table->string('vendor_tel', 80)->nullable(true)->comment('業者TEL');//
            $table->string('vendor_fax', 80)->nullable(true)->comment('業者FAX');//

            $table->foreignId('number_of_employees')->length(6)->nullable(true)->comment('従業員数');
            $table->text('vendor_url',30000)->nullable(true)->comment('企業HP');

            $table->boolean('is_supplier')->default(0)->comment('仕入外注先フラグ');
            $table->boolean('is_dealer')->default(0)->comment('ディーラフラグ');
            $table->boolean('is_lease')->default(0)->comment('リース会社フラグ');
            $table->boolean('is_other_partner')->default(0)->comment('その他協業フラグ');

            $table->string('bank_code', 4)->nullable(true)->comment('銀行CD');
            $table->string('bank_name')->nullable(true)->comment('銀行名称');
            $table->string('branch_code', 3)->nullable(true)->comment('支店CD');
            $table->string('branch_name')->nullable(true)->comment('支店名称');
            $table->string('account_type', 1)->nullable(true)->comment('口座種別'); // 0:ordinary, 1:current, 2:savings
            $table->string('account_number', 7)->nullable(true)->comment('口座番号');
            $table->string('account_name')->nullable(true)->comment('口座名義');

            // 法人が取引停止なら停止,与信限度額がオーバすると発注できなくなるし、ulIDにしたい。
            // 口座種別のマスタ化、銀行、支店のマスタ化検討

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->index('vendor_num');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
