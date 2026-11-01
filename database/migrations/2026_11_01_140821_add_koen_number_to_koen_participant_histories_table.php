<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('koen_participant_histories', function (Blueprint $table) {
            $table->string('koen_number', 128)
                ->nullable()
                ->after('participant_id');
        });
    }

    public function down(): void
    {
        Schema::table('koen_participant_histories', function (Blueprint $table) {
            $table->dropColumn('koen_number');
        });
    }
};
