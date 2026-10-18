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
        Schema::table('koen_participant_form', function (Blueprint $table) {
            $table->renameColumn('note', 'note_ja');
        });

        Schema::table('koen_participant_form', function (Blueprint $table) {
            $table->text('note_en')->nullable()->after('note_ja');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('koen_participant_form', function (Blueprint $table) {
            $table->dropColumn('note_en');
            $table->renameColumn('note_ja', 'note');
        });
    }
};
