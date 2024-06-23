<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->comment('契約ID');
            $table->foreignId('contract_partner_type_id')->comment('契約先タイプID');
            $table->foreignId('contract_update_type_id')->comment('契約更新タイプID');
            $table->foreignId('contract_change_type_id')->comment('契約変更タイプID');
            $table->foreignId('contract_sheet_status_id')->comment('契約書状態ID');
            $table->foreignId('project_id')->nullable(true)->comment('プロジェクトID');
            $table->date('contract_start_at')->comment('契約開始日');
            $table->date('contract_end_at')->comment('契約終了日');
            $table->decimal('contract_amount',10, 0)->default(0)->comment('契約金額');
            $table->text('contract_detail_memo')->nullable(true)->comment('契約詳細備考');
            $table->text('target_system')->nullable(true)->comment('対象システム');
            // $table->string('contract_pdf')->nullable(true)->comment('契約書PDF');
            
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_details');
    }
};
