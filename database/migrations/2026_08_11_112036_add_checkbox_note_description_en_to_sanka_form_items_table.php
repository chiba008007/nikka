<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('sanka_form_items', function (Blueprint $table) {
            // checkbox選択時に表示する備考説明文（英語）
            $table->text('checkbox_note_description_en')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('sanka_form_items', function (Blueprint $table) {
            // 英語説明文カラムを削除
            $table->dropColumn('checkbox_note_description_en');
        });
    }
};
