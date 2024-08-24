<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_histories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('model')->comment('モデル名');
            $table->ulidMorphs('model');
            $table->foreignId('user_id')->nullable()->comment('操作したユーザー')->constrained()->onDelete('set null');
            $table->string('operation_type')->comment('操作のタイプ');
            $table->json('changes')->nullable()->comment('変更内容');
            $table->ipAddress('ip_address')->nullable()->comment('IPアドレス');
            $table->text('user_agent')->nullable()->comment('ユーザーエージェント');
            $table->json('meta')->nullable()->comment('追加のメタデータ');
            $table->timestamps();

            $table->index(['model', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_histories');
    }
};