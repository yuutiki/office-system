<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('corporation_num',6)->unique()->comment('法人№');
            $table->string('corporation_number',13)->nullable(true)->comment('法人番号');
            $table->string('corporation_name')->comment('法人名称');
            $table->string('corporation_kana_name')->comment('法人カナ名称');
            $table->string('corporation_short_name')->comment('法人略称');
            $table->decimal('credit_limit',10, 0)->default(0)->comment('与信限度額');
            $table->text('corporation_memo')->nullable(true)->commebt('法人備考');

            $table->string('corporation_post_code',80)->nullable(true)->comment('法人郵便番号');
            $table->foreignId('corporation_prefecture_id')->nullable(true)->comment('法人都道府県コード');
            $table->string('corporation_address1',80)->nullable(true)->comment('法人住所1');

            $table->unsignedTinyInteger('tax_status')->default(0); // 0: unconfirmed, 1: tax_payer, 2: tax_exempt
            $table->boolean('is_stop_trading')->default(0)->comment('取引停止フラグ');
            $table->text('stop_trading_reason')->nullable(true)->comment('取引停止理由');
            $table->string('invoice_num')->nullable(true)->comment('インボイス番号');
            $table->string('invoice_at')->nullable(true)->comment('インボイス登録日');
            $table->boolean('is_active_invoice')->default(0)->comment('有効インボイスフラグ'); //0:未確認　//1:有効
            
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->index('corporation_num');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corporations');
    }
};
