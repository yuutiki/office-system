<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->string('project_num');
            $table->string('project_name');
            $table->foreignId('sales_stage_id')->comment('営業段階ID');
            $table->foreignId('project_type_id')->comment('プロジェクト種別ID');
            $table->foreignId('accounting_type_id')->comment('計上種別ID');
            $table->foreignId('distribution_type_id')->comment('商流ID');

            $table->dateTime('proposed_order_date')->nullable(true)->comment('受注予定月');
            $table->dateTime('proposed_delivery_date')->nullable(true)->comment('納品予定月');
            $table->dateTime('proposed_accounting_date')->nullable(true)->comment('計上予定月');
            $table->dateTime('proposed_payment_date')->nullable(true)->comment('入金予定月');

            $table->foreignId('billing_corporation_id')->comment('請求先法人ID');
            $table->string('billing_corporation_name')->nullable(true)->comment('請求先名');
            $table->string('billing_corporation_division_name')->nullable(true)->comment('請求先部署名');
            $table->string('billing_corporation_person_name')->nullable(true)->comment('請求先担当者名');
            $table->string('billing_head_post_code',80)->nullable(true)->comment('請求先郵便番号');
            $table->string('billing_head_prefecture',80)->nullable(true)->comment('請求先都道府県');
            $table->string('billing_head_address1',80)->nullable(true)->comment('請求先住所1');
            
                        
            $table->text('project_memo')->nullable(true)->comment('プロジェクト備考');

            $table->foreignId('account_affiliation1_id')->comment('計上会社ID'); 
            $table->foreignId('account_affiliation2_id')->comment('計上事業部ID'); 
            $table->foreignId('account_affiliation3_id')->comment('計上所属階層3ID'); 
            $table->foreignId('account_user_id')->comment('計上担当者');

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
