<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prefectures', function (Blueprint $table) {
            $table->id();
            $table->string('code',2)->unique()->comment('都道府県コード');
            $table->string('name',10)->comment('都道府県名称');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prefectures');
    }
};
