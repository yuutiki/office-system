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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_num',9)->unique()->comment('顧客番号');
            $table->string('client_name',255)->comment('顧客名称');
            $table->string('client_kana_name',255)->comment('顧客カナ名称');
            // $table->int('establishment_type')->nullable()->length(2)->comment('設置種別');
            // $table->int('client_type')->nullable()->length(2)->comment('顧客種別');
            // $table->int('client_attribute')->nullable()->length(2)->comment('顧客属性');
            $table->foreignId('client_corporation_id')->comment('法人ID'); //追記 ClientCorporationsテーブル参照
            $table->timestamps();
            $table->foreign('client_corporation_id')->references('id')->on('client_corporations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
