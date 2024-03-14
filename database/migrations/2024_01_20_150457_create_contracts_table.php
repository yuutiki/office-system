<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->comment('顧客ID');
            $table->string('contract_num',3)->comment('契約番号'); // 顧客別の3桁連番
            $table->foreignId('contract_type_id')->comment('契約種別ID');
            // $table->string('update_month')->comment('更新月');//enum
            $table->date('cancelled_at')->nullable(true)->comment('解約日');
            $table->text('contract_memo',1000)->nullable(true)->comment('契約備考');
            $table->foreignId('client_person_id')->nullable(true)->comment('顧客担当者ID');
            $table->foreignId('vendor_person_id')->nullable(true)->comment('業者担当者ID');

            $table->string('support_page_id',50)->nullable(true)->comment('SPページID');
            $table->string('support_page_pass',50)->nullable(true)->comment('SPページPW');
            $table->string('support_page_memo',50)->nullable(true)->comment('SPページ備考');
            $table->string('faq_page_id',50)->nullable(true)->comment('FAQページID');
            $table->string('faq_page_pass',50)->nullable(true)->comment('FAQページPW');
            $table->string('faq_page_memo',50)->nullable(true)->comment('FAQページ備考');

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
