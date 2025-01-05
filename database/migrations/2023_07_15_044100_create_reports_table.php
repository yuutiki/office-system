<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->comment('顧客ID');//clientテーブル参照
            $table->string('client_representative')->nullable(true)->comment('顧客担当者');
            $table->string('report_title')->nullable(true)->comment('報告タイトル');
            $table->date('contact_at')->nullable(true)->comment('対応日付');
            $table->foreignId('contact_type_id')->nullable(true)->comment('対応種別ID');//contact_typeテーブル参照
            $table->foreignId('report_type_id')->nullable(true)->comment('報告種別ID');//report_typeテーブル参照
            $table->text('report_content')->nullable(true)->comment('報告内容');
            $table->text('report_notice')->nullable(true)->comment('特記事項');
            $table->foreignId('user_id')->nullable(true)->comment('報告者ID');//Userテーブルを参照
            $table->boolean('is_draft')->default(false)->comment('下書きフラグ');
            $table->foreignId('project_id')->nullable(true)->comment('プロジェクトID');//Userテーブルを参照
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
