<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('display_name')->comment('表示名');
            $table->unsignedInteger('display_order')->comment('表示順');
            $table->string('url')->comment('URL');
            $table->foreignId('department_id')->nullable(true)->comment('所属部門');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->foreignId('affiliation2_id')->comment('事業部ID');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
