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
        Schema::create('estimates', function (Blueprint $table) {
            $table->ulid('ulid')->primary();
            $table->foreignId('project_id')->comment('プロジェクトID');
            $table->string('estimate_num')->comment('見積番号');
            $table->string('estimate_subject')->comment('見積件名');
            $table->string('estimate_recipient')->comment('見積宛名');

            // 見積書トップ
            $table->date('estimate_at')->comment('見積日付');
            $table->date('submit_at')->nullable(true)->comment('提出日付');
            $table->string('delivery_place')->default('御指定場所')->comment('受渡場所');
            $table->string('delivery_at')->default('御相談')->comment('受渡期日');
            $table->string('transaction_method')->default('月末締翌月末迄現金')->comment('取引方法');
            $table->string('expiration_at')->default('3ヶ月')->comment('有効期限');

            // 見積書ボディ（detailテーブル）

            // 見積書フッタ
            $table->decimal('total_without_tax', 14, 2)->comment('税抜合計金額');
            $table->decimal('total_tax', 14, 2)->comment('消費税額');
            $table->decimal('total_with_tax', 14, 2)->comment('税込合計金額');
            $table->text('estimate_memo')->nullable(true)->comment('見積備考');
            // $table->text('estimate_sheet')->nullable(true)->comment('見積別紙');


            // 見積書設定（、注文書表題、差出人住所、差出人担当者、差出人役職、レイアウト
            $table->text('estimate_document_title')->nullable(true)->comment('見積書類名');
            $table->ulid('estimate_address_id')->comment('見積住所ID'); // estimate_addressesテーブルのulid
            $table->boolean('is_affiliation2_hidden')->default(false)->comment('担当部署_非表示フラグ');
            $table->string('user_position_name')->nullable(true)->comment('担当者_役職名称'); // 基本はNULL、設定されていれば表示される（代表取締役社長など印字する場合）
            $table->foreignId('custom_user_id')->nullable(true)->comment('カスタム担当者ID'); // 基本はNULL、設定されていればPJの担当者ではなく設定されたUserが表示される

            $table->text('estimate_layout')->nullable(true)->comment('見積書レイアウト');


            // 注文書
            $table->text('order_document_title')->nullable(true)->comment('注文書類名');

            // 注文請書
            $table->text('order_confirmation_document_title')->nullable(true)->comment('注文請書類名');
            $table->date('order_confirmation_sheet_at')->nullable(true)->comment('注文請書日付');


            // 決裁関連
            $table->text('approval_info')->nullable(true)->comment('決裁情報');
            $table->text('supervisor_comment_1')->nullable(true)->comment('上長コメント1');
            $table->text('supervisor_comment_2')->nullable(true)->comment('上長コメント2');

            // 共通
            $table->foreignId('created_by')->nullable(true)->comment('作成者');
            $table->foreignId('updated_by')->nullable(true)->comment('更新者');
            $table->datetimes();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimates');
    }
};
