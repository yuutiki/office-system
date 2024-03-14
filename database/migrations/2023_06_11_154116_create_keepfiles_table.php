<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keepfiles', function (Blueprint $table) {
            $table->id();
            $table->string('project_num',14)->comment('プロジェクト№');
            $table->string('clientname',100)->comment('顧客名');
            $table->foreignId('project_id')->nullable(true)->comment('プロジェクトID');

            $table->string('purpose',50)->comment('用途');
            $table->date('keep_at')->comment('預託日');
            $table->date('return_at')->comment('消去予定日');
            $table->text('memo',500)->nullable()->comment('備考');
            $table->boolean('is_finished')->nullable()->default(false)->comment('完了フラグ');
            $table->foreignId('user_id')->nullable()->comment('担当者'); //本来は担当者だろうが
            $table->text('pdf_file')->nullable(true)->comment('PDFファイル');
            
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();


            // 個人情報有無、資料データ名称、お預かり方法、消去予定延長日、使用USB？
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keepfiles');
    }
};
