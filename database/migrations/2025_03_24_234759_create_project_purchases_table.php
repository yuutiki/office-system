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
        Schema::create('project_purchases', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->comment('プロジェクトID');

            $table->string('purchase_number')->comment('発注No.');

            $table->date('purchase_date')->comment('発注日');
            $table->foreignId('vendor_id')->comment('業者ID');
            $table->string('vendor_estimate_number')->nullable()->comment('発注先見積番号'); 
            $table->date('vendor_estimate_date')->nullable()->comment('発注先見積日付'); 
            $table->foreignId('payment_method_id')->comment('支払方法ID');// ※
            $table->foreignId('purchase_user_id')->comment('発注者ID（ユーザーID）');
            $table->foreignId('purchase_manager_user_id')->comment('発注管理者ID（ユーザーID）');
            // 
            $table->foreignId('sales_category_id')->comment('販売先区分ID'); // ※
            $table->foreignId('purchase_category_id')->comment('発注区分ID'); // ※

            $table->foreignId('affiliation1_id')->nullable(true)->comment('発注所属1ID');//Affiliation1テーブル参照
            $table->foreignId('affiliation2_id')->nullable(true)->comment('発注所属2ID');//Affiliation2テーブル参照
            $table->foreignId('affiliation3_id')->nullable(true)->comment('発注所属3ID');//Affiliation3テーブル参照
            $table->foreignId('affiliation4_id')->nullable(true)->comment('発注所属4ID');//Affiliation4テーブル参照
            $table->foreignId('affiliation5_id')->nullable(true)->comment('発注所属5ID');//Affiliation5テーブル参照
            $table->foreignId('affiliation6_id')->nullable(true)->comment('発注所属6ID');//Affiliation6テーブル参照
            $table->foreignId('affiliation7_id')->nullable(true)->comment('発注所属7ID');//Affiliation7テーブル参照
            $table->foreignId('affiliation8_id')->nullable(true)->comment('発注所属8ID');//Affiliation8テーブル参照
            $table->foreignId('affiliation9_id')->nullable(true)->comment('発注所属9ID');//Affiliation9テーブル参照
            $table->foreignId('affiliation10_id')->nullable(true)->comment('発注所属10ID');//Affiliation10テーブル参照

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
        Schema::dropIfExists('project_purchases');
    }
};
