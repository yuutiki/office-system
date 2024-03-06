<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('report_id');
            $table->text('content');
            $table->foreignId('created_by')->nullable(true)->constrained('users')->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->constrained('users')->comment('更新者');
            $table->datetimes();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
