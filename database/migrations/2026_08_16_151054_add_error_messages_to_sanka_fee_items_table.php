<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('sanka_fee_items', function (Blueprint $table) {
            // 日本語エラーメッセージ
            $table->text('error_message_ja')
                ->nullable()
                ->after('description_en');

            // 英語エラーメッセージ
            $table->text('error_message_en')
                ->nullable()
                ->after('error_message_ja');
        });
    }

    public function down(): void
    {
        Schema::table('sanka_fee_items', function (Blueprint $table) {
            // 追加したカラムを削除する
            $table->dropColumn([
                'error_message_ja',
                'error_message_en',
            ]);
        });
    }
};
