
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        $this->recreateTrigger(true);
    }

    public function down(): void
    {
        $this->recreateTrigger(false);
    }

    private function recreateTrigger(bool $includeAnnounceNumber): void
    {
        $columns = [
            'koen_participant_id',
            'participant_id',
            'koen_number',
        ];

        $values = [
            'NEW.id',
            'NEW.participant_id',
            'NEW.koen_number',
        ];

        if ($includeAnnounceNumber) {
            $columns[] = 'announcenumber';
            $values[] = 'NEW.announcenumber';
        }

        $columns = array_merge($columns, [
            'operation',
            'status',
            'operated_at',
            'participant_created_at',
            'participant_updated_at',
            'participant_deleted_at',
        ]);

        $values = array_merge($values, [
            "'INSERT'",
            'NEW.status',
            'NOW()',
            'NEW.created_at',
            'NEW.updated_at',
            'NEW.deleted_at',
        ]);

        for ($i = 1; $i <= 50; $i++) {
            $columns[] = "add_column_{$i}";
            $values[] = "NEW.add_column_{$i}";
        }

        $columnSql = implode(', ', $columns);
        $valueSql = implode(', ', $values);

        DB::unprepared('DROP TRIGGER IF EXISTS trg_koen_participants_ai');

        DB::unprepared("
            CREATE TRIGGER trg_koen_participants_ai
            AFTER INSERT ON koen_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO koen_participant_histories ({$columnSql})
                VALUES ({$valueSql});
            END
        ");
    }
};
