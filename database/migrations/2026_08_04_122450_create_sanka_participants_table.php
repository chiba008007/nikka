<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * 参加者情報テーブルを作成する
     */
    public function up(): void
    {
        Schema::create('sanka_participants', function (Blueprint $table) {
            $table->id();

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
            $table->string('email', 255);

            // 必ずHash::make()でハッシュ化して保存する
            $table->string('password', 255);

            // 複数選択された専門分野ID
            $table->json('expertise_ids')->nullable();

            // 「その他」を選択した場合の入力内容
            $table->string('expertise_other', 255)->nullable();

            // 複数選択された所属学協会ID
            $table->json('society_ids')->nullable();

            // 「その他」を選択した場合の入力内容
            $table->string('society_other', 255)->nullable();

            // 参加情報
            $table->unsignedBigInteger('join_type_id')->nullable();
            $table->boolean('travel_support_requested')->default(false);
            $table->boolean('banquet_requested')->default(false);

            // 申込時点の金額
            $table->unsignedInteger('participation_fee')->default(0);
            $table->unsignedInteger('banquet_fee')->default(0);
            $table->unsignedInteger('total_amount')->default(0);

            // 参加者向け備考
            $table->text('remarks')->nullable();

            // 管理者向け備考
            $table->text('admin_remarks')->nullable();

            // メール送信状態
            $table->boolean('mail_sent')->default(false);

            // 選考委員状態
            $table->boolean('is_selector')->default(false);

            // 1:有効 2:無効 3:取消
            $table->unsignedTinyInteger('status')
                ->default(1)
                ->comment('1:有効 2:無効 3:取消');

            $table->timestamps();
            $table->softDeletes();

            // 検索用インデックス
            $table->index('email');
            $table->index('status');
            $table->index('address_type_id');
            $table->index('join_type_id');
            $table->index(['family_name', 'first_name']);
            $table->index(['family_name_kana', 'first_name_kana']);
        });
    }

    /**
     * 参加者情報テーブルを削除する
     */
    public function down(): void
    {
        Schema::dropIfExists('sanka_participants');
    }
};
