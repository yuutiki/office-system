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
        Schema::create('function_menu_role_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_group_id')->constrained()->onDelete('cascade');
            $table->foreignId('function_menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade'); // PermissionテーブルのIDを参照
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            // 複合インデックスを追加
            $table->index(['role_group_id', 'function_menu_id']);
            $table->index(['function_menu_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('function_menu_role_group');
    }
};
