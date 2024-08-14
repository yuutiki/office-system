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
        Schema::create('estimate_attachments', function (Blueprint $table) {
            $table->ulid('ulid')->primary();
            $table->ulid('estimate_id')->comment('見積書ID');
            $table->string('file_path')->comment('ファイルパス');
            $table->string('file_size')->comment('ファイルサイズ');
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->foreign('estimate_id')->references('ulid')->on('estimates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_attachments');
    }
};
