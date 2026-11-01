
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    private function historyInsert(
        string $row,
        string $operation,
        bool $withKoenNumber
    ): string {
        $columns = ['koen_participant_id', 'participant_id'];
        $values = ["$row.id", "$row.participant_id"];

        if ($withKoenNumber) {
            $columns[] = 'koen_number';
            $values[] = "$row.koen_number";
        }

        $columns = array_merge($columns, [
            'operation', 'status', 'operated_at',
            'participant_created_at',
            'participant_updated_at',
            'participant_deleted_at',
        ]);

        $values = array_merge($values, [
            "'$operation'", "$row.status", 'NOW()',
            "$row.created_at", "$row.updated_at", "$row.deleted_at",
        ]);

        foreach (range(1, 50) as $i) {
            $columns[] = "add_column_$i";
            $values[] = "$row.add_column_$i";
        }

        return 'INSERT INTO koen_participant_histories ('
            . implode(', ', $columns)
            . ') VALUES (' . implode(', ', $values) . ');';
    }

    private function recreateTriggers(bool $withKoenNumber): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_koen_participants_ai');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_koen_participants_bu');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_koen_participants_bd');

        DB::unprepared(
            'CREATE TRIGGER trg_koen_participants_ai
             AFTER INSERT ON koen_participants FOR EACH ROW
             BEGIN '
            . $this->historyInsert('NEW', 'INSERT', $withKoenNumber)
            . ' END'
        );

        DB::unprepared(
            'CREATE TRIGGER trg_koen_participants_bu
             BEFORE UPDATE ON koen_participants FOR EACH ROW
             BEGIN
                IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL THEN '
            . $this->historyInsert('OLD', 'DELETE', $withKoenNumber)
            . ' ELSE '
            . $this->historyInsert('OLD', 'UPDATE', $withKoenNumber)
            . ' END IF;
             END'
        );

        DB::unprepared(
            'CREATE TRIGGER trg_koen_participants_bd
             BEFORE DELETE ON koen_participants FOR EACH ROW
             BEGIN '
            . $this->historyInsert('OLD', 'HARD_DELETE', $withKoenNumber)
            . ' END'
        );
    }

    public function up(): void
    {
        $this->recreateTriggers(true);
    }

    public function down(): void
    {
        $this->recreateTriggers(false);
    }
};
