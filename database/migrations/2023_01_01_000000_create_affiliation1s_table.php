<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 会社
        Schema::create('affiliation1s', function (Blueprint $table) {
            $table->id();
            $table->string('affiliation1_code',2)->unique()->comment('第一所属階層コード');
            $table->string('affiliation1_prefix',1)->nullable(true)->unique()->comment('第一階層所属プレフィックス');
            $table->string('affiliation1_name',100)->comment('第一所属階層名称');
            $table->string('affiliation1_kana_name',100)->nullable(true)->comment('第一所属階層カナ名称');
            $table->string('affiliation1_eng_name',100)->nullable(true)->comment('第一所属階層英名称');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliation1s');
    }
};