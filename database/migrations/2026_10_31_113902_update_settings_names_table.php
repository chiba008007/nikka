<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 先にnameをname_jaへ変更
        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('name', 'name_ja');
        });

        // その後、name_enを追加
        Schema::table('settings', function (Blueprint $table) {
            $table->string('name_en', 1280)
                ->nullable()
                ->after('name_ja');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('name_en');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('name_ja', 'name');
        });
    }
};
