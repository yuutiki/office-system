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
        Schema::create('contract_detail_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_detail_id')->comment('契約詳細ID');
            $table->string('file_path')->comment('ファイルパス');
            $table->string('file_size')->comment('ファイルサイズ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->foreign('contract_detail_id')->references('id')->on('contract_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_detail_attachments');
    }
};
