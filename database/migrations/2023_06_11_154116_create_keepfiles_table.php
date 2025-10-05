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
            $table->foreignId('project_id')->nullable(true)->comment('プロジェクトID');
            $table->string('purpose',50)->comment('用途');
            $table->date('keep_at')->comment('預託日');
            $table->date('return_at')->comment('消去予定日');
            $table->boolean('is_finished')->nullable()->default(false)->comment('完了フラグ');
            $table->foreignId('user_id')->nullable()->comment('担当者'); //本来は担当者だろうが
            $table->text('pdf_file')->nullable(true)->comment('PDFファイル');
            $table->boolean('has_personal_information')->default(1)->comment('個人情報含むフラグ');

            $table->string('keep_method')->nullable(true)->comment('預託方法');

            $table->text('keep_data',2000)->nullable(true)->comment('預託データ内容');
            $table->text('keepfile_memo',2000)->nullable(true)->comment('備考');

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            // 資料データ名称、お預かり方法、消去予定延長日、使用USB？
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keepfiles');

        // 関連する添付ファイルを削除
        $files = Storage::disk('public')->files('keepfiles/pdf'); // 関連するフォルダ内のファイルを取得
        foreach ($files as $file) {
            Storage::disk('public')->delete($file); // ファイルを削除
        }
    }
};
