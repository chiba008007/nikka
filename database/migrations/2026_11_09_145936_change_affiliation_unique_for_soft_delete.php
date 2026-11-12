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
        Schema::table('koen_participant_affiliations', function (Blueprint $table) {
            $table->index(
                ['koen_participant_id', 'affiliation_number'],
                'kpa_affiliation_index'
            );
        });

        Schema::table('koen_participant_affiliations', function (Blueprint $table) {
            $table->dropUnique('kpa_affiliation_unique');
        });
    }

    public function down(): void
    {
        Schema::table('koen_participant_affiliations', function (Blueprint $table) {
            $table->dropIndex('kpa_affiliation_index');
            $table->unique(
                ['koen_participant_id', 'affiliation_number'],
                'kpa_affiliation_unique'
            );
        });
    }
};
