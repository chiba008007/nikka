<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * error_messages を削除し、
     * 日本語・英語のエラーメッセージ列を追加する
     */
    public function up(): void
    {
        Schema::table('sanka_form_items', function (Blueprint $table) {
            // 既存JSONカラムを削除
            $table->dropColumn('error_messages');

            // 日本語エラーメッセージ
            $table->text('error_message_ja')
                ->nullable()
                ->after('column');

            // 英語エラーメッセージ
            $table->text('error_message_en')
                ->nullable()
                ->after('error_message_ja');
        });
    }

    /**
     * 元の構成へ戻す
     */
    public function down(): void
    {
        Schema::table('sanka_form_items', function (Blueprint $table) {
            // 追加したカラムを削除
            $table->dropColumn([
                'error_message_ja',
                'error_message_en',
            ]);

            // 元のJSONカラムを復元
            $table->json('error_messages')
                ->nullable()
                ->after('column');
        });
    }
};
