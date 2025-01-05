<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_masters', function (Blueprint $table) {
            $table->id();
            $table->string('master_type',20)->comment('マスタ種別');
            $table->string('master_code',3)->unique()->comment('マスタコード');
            $table->string('master_name',20)->comment('マスタ名称');
            $table->string('master_name_en',20)->nullable(true)->comment('マスタ英名称');
            $table->string('route')->comment('ルート');
            $table->integer('digit')->nullable()->comment('桁数');

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    // 1,10:共通,100,顧客種別マスタ,ClientTypeMaster,clienttypes.index,1,1,now,

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_masters');
    }
};
