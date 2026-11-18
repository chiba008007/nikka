
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        DB::unprepared("
            CREATE TRIGGER trg_koen_participant_authors_ai
            AFTER INSERT ON koen_participant_authors
            FOR EACH ROW
            BEGIN
                INSERT INTO koen_participant_author_histories (
                    koen_participant_id,
                    author_id,
                    author_number,
                    is_presenter,
                    is_award_contact,
                    family_name_ja,
                    given_name_ja,
                    family_name_en,
                    given_name_en,
                    affiliation_numbers,
                    operated_at
                ) VALUES (
                    NEW.koen_participant_id,
                    NEW.id,
                    NEW.author_number,
                    NEW.is_presenter,
                    NEW.is_award_contact,
                    NEW.family_name_ja,
                    NEW.given_name_ja,
                    NEW.family_name_en,
                    NEW.given_name_en,
                    NEW.affiliation_numbers,
                    NOW()
                );
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_koen_participant_affiliations_ai
            AFTER INSERT ON koen_participant_affiliations
            FOR EACH ROW
            BEGIN
                INSERT INTO koen_participant_affiliation_histories (
                    koen_participant_id,
                    affiliation_id,
                    affiliation_number,
                    organization,
                    department,
                    short_name,
                    english,
                    english_short,
                    operated_at
                ) VALUES (
                    NEW.koen_participant_id,
                    NEW.id,
                    NEW.affiliation_number,
                    NEW.organization,
                    NEW.department,
                    NEW.short_name,
                    NEW.english,
                    NEW.english_short,
                    NOW()
                );
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared(
            'DROP TRIGGER IF EXISTS trg_koen_participant_authors_ai'
        );

        DB::unprepared(
            'DROP TRIGGER IF EXISTS trg_koen_participant_affiliations_ai'
        );
    }
};
