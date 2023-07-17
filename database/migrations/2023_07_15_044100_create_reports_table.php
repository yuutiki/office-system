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
            $table->string('type')->comment('報告種別');//非リレーション
            $table->string('title')->comment('報告タイトル');
            $table->string('contact_type')->comment('対応種別');//非リレーション
            $table->text('content')->comment('報告内容');
            $table->text('notice')->nullable()->comment('特記事項');
            $table->string('client_representative')->nullable()->comment('顧客担当者');//非リレーション
            $table->unsignedBigInteger('user_id')->nullable()->comment('報告者');//Userテーブルを参照
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //報告先は多対多のリレーションをするため上記に報告先のカラムは持たない。投稿データと報告先（User）を紐付ける中間テーブルを用意する
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
