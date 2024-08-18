<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 会社
        Schema::create('affiliation1s', function (Blueprint $table) {
            $table->id();
            $table->string('affiliation1_code',2)->unique()->comment('第一所属階層コード');
            $table->string('affiliation1_prefix',1)->nullable(true)->unique()->comment('第一階層所属プレフィックス');
            $table->string('affiliation1_name',100)->comment('第一所属階層名称');
            $table->string('affiliation1_kana_name',100)->nullable(true)->comment('第一所属階層カナ名称');
            $table->string('affiliation1_eng_name',100)->nullable(true)->comment('第一所属階層英名称');
            $table->string('affiliation1_name_short',100)->nullable(true)->comment('第一階層所属略称');

            $table->string('affiliation1_post_code',80)->nullable(true)->comment('本社郵便番号');
            $table->foreignId('affiliation1_prefecture_id')->nullable(true)->comment('本社都道府県コード');
            $table->string('affiliation1_address1',80)->nullable(true)->comment('本社所在地1');
            $table->string('company_TEL',15)->nullable(true)->comment('代表TEL番号');
            $table->string('company_FAX',15)->nullable(true)->comment('代表FAX番号');

            $table->string('company_stamp_image')->nullable(true)->comment('会社印鑑画像');
            $table->string('company_logo_image')->nullable(true)->comment('会社ロゴ画像');
            $table->string('company_president_position_name')->nullable(true)->comment('会社代表者役職');
            $table->foreignId('company_president_id')->nullable(true)->comment('会社代表者');

            $table->string('corporation_number')->nullable(true)->comment('法人番号（国税庁）');
            $table->string('stock_code')->nullable(true)->comment('証券コード');
            $table->string('invoice_num')->nullable(true)->comment('インボイス番号');
            $table->string('invoice_at')->nullable(true)->comment('インボイス登録日');

            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliation1s');
    }
};