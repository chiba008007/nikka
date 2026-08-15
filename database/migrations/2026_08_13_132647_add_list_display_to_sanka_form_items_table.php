<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('sanka_form_items', function (Blueprint $table) {
            // 一覧画面に表示するかどうか
            $table->boolean('list_display')
                ->default(false)
                ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('sanka_form_items', function (Blueprint $table) {
            // 一覧表示フラグを削除する
            $table->dropColumn('list_display');
        });
    }
};
