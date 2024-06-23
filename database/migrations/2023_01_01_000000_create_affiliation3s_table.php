<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 部署
        Schema::create('affiliation3s', function (Blueprint $table) {
            $table->id();
            $table->string('affiliation3_code',2)->unique()->comment('第三階層所属コード');
            $table->string('affiliation3_prefix',1)->nullable(true)->unique()->comment('第三階層所属プレフィックス');
            $table->string('affiliation3_name',100)->comment('第三階層所属名称');
            $table->string('affiliation3_name_kana',100)->nullable(true)->comment('第三階層所属カナ名称');
            $table->string('affiliation3_name_en',100)->nullable(true)->comment('第三階層所属英名称');
            $table->string('affiliation3_name_short',100)->nullable(true)->comment('第三階層所属略称');
            $table->foreignId('affiliation2_id')->comment('所属階層2（親）ID');
            $table->boolean('is_active')->default(1)->comment('有効フラグ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliation3s');
    }
};
