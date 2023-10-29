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
            $table->foreignId('sales_stage_id');//営業段階ID
            $table->foreignId('project_type_id');//プロジェクト種別ID
            $table->foreignId('accounting_type_id');//計上種別ID
            $table->foreignId('distribution_type_id');//商流ID
            $table->string('client_budget_year')->nullable(true);//客先予算年度
            $table->date('accounting_start_date');//計上開始月
            $table->date('accounting_end_date');//計上終了月
            $table->foreignId('accounting_period_id_1');//会計期1
            $table->decimal('revenue_distribution_set1_0',10, 0)->default(0)->comment('1月');
            $table->decimal('revenue_distribution_set1_1',10, 0)->default(0)->comment('2月');
            $table->decimal('revenue_distribution_set1_2',10, 0)->default(0)->comment('3月');
            $table->decimal('revenue_distribution_set1_3',10, 0)->default(0)->comment('4月');
            $table->decimal('revenue_distribution_set1_4',10, 0)->default(0)->comment('5月');
            $table->decimal('revenue_distribution_set1_5',10, 0)->default(0)->comment('6月');
            $table->decimal('revenue_distribution_set1_6',10, 0)->default(0)->comment('7月');
            $table->decimal('revenue_distribution_set1_7',10, 0)->default(0)->comment('8月');
            $table->decimal('revenue_distribution_set1_8',10, 0)->default(0)->comment('9月');
            $table->decimal('revenue_distribution_set1_9',10, 0)->default(0)->comment('10月');
            $table->decimal('revenue_distribution_set1_10',10, 0)->default(0)->comment('11月');
            $table->decimal('revenue_distribution_set1_11',10, 0)->default(0)->comment('12月');
            $table->foreignId('accounting_period_id_2');//会計期2
            $table->decimal('revenue_distribution_set2_0',10, 0)->default(0)->comment('1月');
            $table->decimal('revenue_distribution_set2_1',10, 0)->default(0)->comment('2月');
            $table->decimal('revenue_distribution_set2_2',10, 0)->default(0)->comment('3月');
            $table->decimal('revenue_distribution_set2_3',10, 0)->default(0)->comment('4月');
            $table->decimal('revenue_distribution_set2_4',10, 0)->default(0)->comment('5月');
            $table->decimal('revenue_distribution_set2_5',10, 0)->default(0)->comment('6月');
            $table->decimal('revenue_distribution_set2_6',10, 0)->default(0)->comment('7月');
            $table->decimal('revenue_distribution_set2_7',10, 0)->default(0)->comment('8月');
            $table->decimal('revenue_distribution_set2_8',10, 0)->default(0)->comment('9月');
            $table->decimal('revenue_distribution_set2_9',10, 0)->default(0)->comment('10月');
            $table->decimal('revenue_distribution_set2_10',10, 0)->default(0)->comment('11月');
            $table->decimal('revenue_distribution_set2_11',10, 0)->default(0)->comment('12月');
                        
            $table->text('project_memo')->nullable(true);
            $table->foreignId('company_id')->comment('計上会社ID'); 
            $table->foreignId('department_id')->comment('計上事業部ID'); 
            $table->foreignId('division_id')->comment('計上部署ID'); 
            $table->foreignId('user_id')->nullable()->comment('計上担当者');
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
