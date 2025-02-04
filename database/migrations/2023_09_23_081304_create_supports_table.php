<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->comment('顧客ID'); //clientsテーブル参照
            $table->string('request_num',4)->comment('問合せ連番');
            $table->date('received_at')->nullable(true)->comment('受付日');
            $table->string('title',100)->nullable(true)->comment('タイトル');
            $table->text('request_content')->nullable(true)->comment('内容');
            $table->text('response_content')->nullable(true)->comment('回答');
            $table->text('internal_message')->nullable(true)->comment('社内連絡欄');
            $table->text('internal_memo1')->nullable(true)->comment('社内メモ欄');
            $table->foreignId('support_type_id')->nullable(true)->comment('サポート種別ID'); //support_typesテーブル参照
            $table->foreignId('support_time_id')->nullable(true)->comment('サポート所要時間ID'); //support_timesテーブル参照
            $table->foreignId('user_id')->nullable(true)->comment('受付対応者ID'); //usersテーブル参照
            $table->string('client_user_department',20)->nullable(true)->comment('顧客担当者部署');
            $table->string('client_user_kana_name',20)->nullable(true)->comment('顧客担当者カナ氏名');
            $table->foreignId('product_series_id')->nullable(true)->comment('対象システムシリーズID'); //product_seriesテーブル参照
            $table->foreignId('product_version_id')->nullable(true)->comment('対象システムバージョンID'); //product_versionsテーブル参照
            $table->foreignId('product_category_id')->nullable(true)->comment('対象システム系統ID'); //product_categoriesテーブル参照
            $table->string('redmine',10)->nullable(true)->comment('redmine番号');
            $table->boolean('is_finished')->default(false)->comment('対応完了フラグ'); 
            $table->boolean('is_disclosured')->default(false)->comment('顧客開示フラグ');
            $table->boolean('is_confirmed')->default(false)->comment('上長確認済フラグ');
            $table->boolean('is_troubled')->default(false)->comment('トラブルフラグ');
            $table->boolean('is_faq_target')->default(false)->comment('FAQ対象フラグ');
            $table->boolean('is_draft')->default(false)->comment('下書きフラグ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};
