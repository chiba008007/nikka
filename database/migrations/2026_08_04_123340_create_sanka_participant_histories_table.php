<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * 参加者情報履歴テーブルを作成する
     */
    public function up(): void
    {
        Schema::create('sanka_participant_histories', function (Blueprint $table) {
            // 履歴自身のID
            $table->id();

            // 元の参加者ID
            $table->unsignedBigInteger('participant_id');

            // INSERT・UPDATE・DELETE・HARD_DELETE
            $table->string('operation', 20);

            // 参加受付番号
            $table->unsignedInteger('reception_serial')->unique();
            $table->string('reception_number', 30)->unique();
            // 参加者氏名
            $table->string('family_name', 100)->nullable();
            $table->string('first_name', 100)->nullable();
            $table->string('family_name_kana', 100)->nullable();
            $table->string('first_name_kana', 100)->nullable();

            // 所属情報
            $table->string('organization', 255)->nullable();
            $table->string('department', 255)->nullable();
            $table->string('laboratory', 255)->nullable();

            // 連絡先情報
            $table->unsignedBigInteger('address_type_id')->nullable();
            $table->string('postal_code', 8)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('email', 255)->nullable();

            /*
             * パスワードは履歴へ保存しない。
             * ハッシュ値であっても履歴への複製は不要。
             */

            // 複数選択項目
            $table->json('expertise_ids')->nullable();
            $table->string('expertise_other', 255)->nullable();
            $table->json('society_ids')->nullable();
            $table->string('society_other', 255)->nullable();

            // 参加情報
            $table->unsignedBigInteger('join_type_id')->nullable();
            $table->boolean('travel_support_requested')->default(false);
            $table->boolean('banquet_requested')->default(false);

            // 申込時点の金額
            $table->unsignedInteger('participation_fee')->default(0);
            $table->unsignedInteger('banquet_fee')->default(0);
            $table->unsignedInteger('total_amount')->default(0);

            // 備考・管理情報
            $table->text('remarks')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->boolean('mail_sent')->default(false);
            $table->boolean('is_selector')->default(false);

            // 状態
            $table->unsignedTinyInteger('status')->default(1);

            // 元データの日時
            $table->timestamp('participant_created_at')->nullable();
            $table->timestamp('participant_updated_at')->nullable();
            $table->timestamp('participant_deleted_at')->nullable();

            // 履歴が保存された日時
            $table->timestamp('operated_at')->useCurrent();

            // 操作者IDはアプリ側から記録する場合に使用する
            $table->unsignedBigInteger('operated_by')->nullable();

            // 検索用インデックス
            $table->index('participant_id');
            $table->index('operation');
            $table->index('email');
            $table->index('status');
            $table->index('address_type_id');
            $table->index('join_type_id');
            $table->index('operated_at');
            $table->index(['family_name', 'first_name']);
        });
    }

    /**
     * 参加者情報履歴テーブルを削除する
     */
    public function down(): void
    {
        Schema::dropIfExists('sanka_participant_histories');
    }
};
