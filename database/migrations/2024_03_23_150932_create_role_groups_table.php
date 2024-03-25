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
        Schema::create('role_groups', function (Blueprint $table) {
            $table->id();
            $table->string('role_group_code',4)->unique()->comment('権限グループコード');
            $table->string('role_group_name')->comment('権限グループ名称');
            $table->string('role_group_eng_name')->nullable(true)->comment('権限グループ名称');
            $table->string('role_group_memo')->nullable(true)->comment('権限グループ備考');

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_groups');
    }
};

