
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('koen_participant_author_histories', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
        });

        Schema::table('koen_participant_affiliation_histories', function (Blueprint $table) {
            $table->timestamp('deleted_at')->nullable();
        });

        DB::unprepared("
            CREATE TRIGGER trg_koen_participant_authors_au
            AFTER UPDATE ON koen_participant_authors
            FOR EACH ROW
            BEGIN
                IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL THEN
                    UPDATE koen_participant_author_histories
                    SET deleted_at = NEW.deleted_at
                    WHERE author_id = NEW.id;
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_koen_participant_affiliations_au
            AFTER UPDATE ON koen_participant_affiliations
            FOR EACH ROW
            BEGIN
                IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL THEN
                    UPDATE koen_participant_affiliation_histories
                    SET deleted_at = NEW.deleted_at
                    WHERE affiliation_id = NEW.id;
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_koen_participant_authors_au');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_koen_participant_affiliations_au');

        Schema::table('koen_participant_author_histories', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('koen_participant_affiliation_histories', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
};
