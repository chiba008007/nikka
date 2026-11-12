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
        Schema::table('koen_participant_authors', function (Blueprint $table) {
            $table->index(
                'koen_participant_id',
                'kpa_author_index'
            );
        });

        Schema::table('koen_participant_authors', function (Blueprint $table) {
            $table->dropUnique('kpa_author_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
