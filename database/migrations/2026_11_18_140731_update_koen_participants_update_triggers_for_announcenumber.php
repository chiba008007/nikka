
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        // 既存の更新前履歴はそのまま残す
        // 発表番号が変更された場合、更新後の状態を追加記録する
        $columns = [
            'koen_participant_id', 'participant_id', 'koen_number',
            'announcenumber', 'operation', 'status', 'operated_at',
            'participant_created_at', 'participant_updated_at',
            'participant_deleted_at',
        ];

        $values = [
            'NEW.id', 'NEW.participant_id', 'NEW.koen_number',
            'NEW.announcenumber', "'UPDATE'", 'NEW.status', 'NOW()',
            'NEW.created_at', 'NEW.updated_at', 'NEW.deleted_at',
        ];

        for ($i = 1; $i <= 50; $i++) {
            $columns[] = "add_column_{$i}";
            $values[] = "NEW.add_column_{$i}";
        }

        $columnSql = implode(', ', $columns);
        $valueSql = implode(', ', $values);

        DB::unprepared("
            CREATE TRIGGER trg_koen_participants_au
            AFTER UPDATE ON koen_participants
            FOR EACH ROW
            BEGIN
                IF NOT (OLD.announcenumber <=> NEW.announcenumber) THEN
                    INSERT INTO koen_participant_histories ({$columnSql})
                    VALUES ({$valueSql});
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared(
            'DROP TRIGGER IF EXISTS trg_koen_participants_au'
        );
    }
};
