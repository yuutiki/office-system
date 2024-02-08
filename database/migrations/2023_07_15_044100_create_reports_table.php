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
            $table->unsignedBigInteger('client_id')->comment('顧客ID');//clientテーブル参照
            $table->date('contact_at')->comment('対応日付');
            $table->foreignId('contact_type_id')->comment('対応種別ID');//contact_typeテーブル参照
            $table->foreignId('report_type_id')->comment('報告種別ID');//report_typeテーブル参照
            $table->string('report_title')->comment('報告タイトル');
            $table->text('report_content')->comment('報告内容');
            $table->text('report_notice')->nullable()->comment('特記事項');
            $table->string('client_representative')->nullable()->comment('顧客担当者');
            $table->unsignedBigInteger('user_id')->nullable()->comment('報告者ID');//Userテーブルを参照
            $table->foreignId('created_by')->nullable(true)->constrained('users')->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->constrained('users')->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
