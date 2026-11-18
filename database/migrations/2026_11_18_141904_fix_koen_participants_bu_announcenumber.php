
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    private function recreate(bool $includeAnnouncenumber): void
    {
        $columns = [
            'koen_participant_id', 'participant_id', 'koen_number',
        ];
        $values = [
            'OLD.id', 'OLD.participant_id', 'OLD.koen_number',
        ];

        if ($includeAnnouncenumber) {
            $columns[] = 'announcenumber';
            $values[] = 'OLD.announcenumber';
        }

        $columns = array_merge($columns, [
            'operation', 'status', 'operated_at',
            'participant_created_at', 'participant_updated_at',
            'participant_deleted_at',
        ]);

        $values = array_merge($values, [
            "IF(OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL, 'DELETE', 'UPDATE')",
            'OLD.status', 'NOW()', 'OLD.created_at',
            'OLD.updated_at', 'OLD.deleted_at',
        ]);

        for ($i = 1; $i <= 50; $i++) {
            $columns[] = "add_column_{$i}";
            $values[] = "OLD.add_column_{$i}";
        }

        $columnSql = implode(', ', $columns);
        $valueSql = implode(', ', $values);

        DB::unprepared('DROP TRIGGER IF EXISTS trg_koen_participants_bu');

        DB::unprepared("
            CREATE TRIGGER trg_koen_participants_bu
            BEFORE UPDATE ON koen_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO koen_participant_histories ({$columnSql})
                VALUES ({$valueSql});
            END
        ");
    }

    public function up(): void
    {
        $this->recreate(true);
    }

    public function down(): void
    {
        $this->recreate(false);
    }
};
