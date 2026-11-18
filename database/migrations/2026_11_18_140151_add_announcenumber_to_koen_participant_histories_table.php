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
        Schema::table('koen_participant_histories', function (Blueprint $table) {
            $table->string('announcenumber', 128)
                ->nullable()
                ->after('koen_number');
        });
    }

    public function down(): void
    {
        Schema::table('koen_participant_histories', function (Blueprint $table) {
            $table->dropColumn('announcenumber');
        });
    }
};
