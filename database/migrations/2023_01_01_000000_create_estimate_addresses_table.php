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
        Schema::create('estimate_addresses', function (Blueprint $table) {
            $table->ulid();
            $table->string('estimate_address_code',2)->unique()->comment('見積住所コード');
            $table->string('estimate_address_name')->comment('見積住所名称');
            $table->string('estimate_address_1')->nullable(true)->comment('見積住所1'); // 支社名称や郵便番号など
            $table->string('estimate_address_2')->nullable(true)->comment('見積住所2'); // 住所
            $table->string('estimate_address_3')->nullable(true)->comment('見積住所3');
            $table->string('estimate_address_tel')->nullable(true)->comment('見積TEL');
            $table->string('estimate_address_fax')->nullable(true)->comment('見積FAX');
            $table->string('estimate_address_mail')->nullable(true)->comment('見積Mail');
            $table->string('estimate_address_url')->nullable(true)->comment('見積会社URL');
            
            // 所属階層に対応するカラムを追加（選択肢絞り込み用）
            $table->foreignId('project_affiliation1')->nullable(true)->comment('PJ所属階層1');
            $table->foreignId('project_affiliation2')->nullable(true)->comment('PJ所属階層2');
            $table->foreignId('project_affiliation3')->nullable(true)->comment('PJ所属階層3');
            $table->foreignId('project_affiliation4')->nullable(true)->comment('PJ所属階層4');
            $table->foreignId('project_affiliation5')->nullable(true)->comment('PJ所属階層5');
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
        
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
        Schema::dropIfExists('estimate_addresses');
    }
};
