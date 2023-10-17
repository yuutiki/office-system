<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->string('project_num');
            $table->string('project_name');
            $table->foreignId('sales_stage_id');
            $table->foreignId('distribution_type_id');//商流ID
            $table->string('client_budget_year')->nullable(true);//客先予算年度
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_revenue', 10, 2); // 10進数で2桁の小数点
            $table->text('project_memo')->nullable(true);
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
