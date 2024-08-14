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
            $table->string('estimate_title')->comment('見積件名');
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
            $table->decimal('subtotal_amount', 10, 2)->comment('税抜合計金額');
            $table->decimal('tax_amount', 10, 2)->comment('消費税額');
            $table->decimal('total_amount', 10, 2)->comment('税込合計金額');
            $table->text('estimate_memo')->nullable(true)->comment('見積備考');
            $table->text('estimate_sheet')->nullable(true)->comment('見積別紙');


            // 印刷設定（表題、注文書表題、差出人住所、差出人担当者、差出人役職、レイアウト
            $table->text('estimate_name')->nullable(true)->comment('見積書類名');
            $table->text('estimate_sender_address')->nullable(true)->comment('差出人住所');
            $table->text('estimate_sender_user')->nullable(true)->comment('差出人担当者');
            $table->text('estimate_sender_user_position')->nullable(true)->comment('差出人担当者役職');
            $table->text('estimate_layout')->nullable(true)->comment('見積書レイアウト');

            // 注文書
            $table->text('order_sheet_name')->nullable(true)->comment('注文書類名');

            // 注文請書
            $table->text('order_confirmation_sheet_name')->nullable(true)->comment('注文請書類名');
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
