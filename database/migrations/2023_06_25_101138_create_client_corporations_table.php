<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_corporations', function (Blueprint $table) {
            $table->id();
            $table->string('clientcorporation_num',6)->unique()->comment('法人番号');
            $table->string('clientcorporation_name')->comment('法人名称');
            $table->string('clientcorporation_kana_name')->comment('法人カナ名称');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_corporations');
    }
};
