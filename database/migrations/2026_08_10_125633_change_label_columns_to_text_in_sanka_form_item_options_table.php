<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * label_ja / label_en を text 型へ変更
     */
    public function up(): void
    {
        Schema::table('sanka_form_item_options', function (Blueprint $table) {
            // 日本語ラベルを text 型へ変更
            $table->text('label_ja')->change();

            // 英語ラベルを text 型へ変更
            $table->text('label_en')->change();
        });
    }

    /**
     * varchar(255) へ戻す
     */
    public function down(): void
    {
        Schema::table('sanka_form_item_options', function (Blueprint $table) {
            // 日本語ラベルを varchar(255) へ戻す
            $table->string('label_ja', 255)->change();

            // 英語ラベルを varchar(255) へ戻す
            $table->string('label_en', 255)->change();
        });
    }
};
