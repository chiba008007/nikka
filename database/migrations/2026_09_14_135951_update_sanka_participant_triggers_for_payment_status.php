<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->dropTriggers();

        // 支払ステータスを含むトリガーを再作成
        $this->createInsertTrigger(true);
        $this->createUpdateTrigger(true);
        $this->createDeleteTrigger(true);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropTriggers();

        // 元の状態に戻す
        $this->createInsertTrigger(false);
        $this->createUpdateTrigger(false);
        $this->createDeleteTrigger(false);
    }

    private function dropTriggers(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_delete');
    }

    private function historyColumns(bool $withPaymentStatus): string
    {
        $columns = [
            'participant_id',
            'reception_serial',
            'reception_number',
            'operation',
            'status',
        ];

        for ($i = 1; $i <= 50; $i++) {
            $columns[] = 'add_column_' . $i;
        }

        $columns[] = 'participation_status';
        $columns[] = 'banquet_status';

        if ($withPaymentStatus) {
            $columns[] = 'participation_payment_status';
            $columns[] = 'banquet_payment_status';
        }

        $columns[] = 'participant_created_at';
        $columns[] = 'participant_updated_at';
        $columns[] = 'participant_deleted_at';
        $columns[] = 'operated_at';

        return implode(",\n                    ", $columns);
    }

    private function values(
        string $prefix,
        string $operation,
        bool $withPaymentStatus
    ): string {
        $values = [
            "{$prefix}.id",
            "{$prefix}.reception_serial",
            "{$prefix}.reception_number",
            $operation,
            "{$prefix}.status",
        ];

        for ($i = 1; $i <= 50; $i++) {
            $values[] = "{$prefix}.add_column_{$i}";
        }

        $values[] = "{$prefix}.participation_status";
        $values[] = "{$prefix}.banquet_status";

        if ($withPaymentStatus) {
            $values[] = "{$prefix}.participation_payment_status";
            $values[] = "{$prefix}.banquet_payment_status";
        }

        $values[] = "{$prefix}.created_at";
        $values[] = "{$prefix}.updated_at";
        $values[] = "{$prefix}.deleted_at";
        $values[] = 'NOW()';

        return implode(",\n                    ", $values);
    }

    private function createInsertTrigger(bool $withPaymentStatus): void
    {
        $columns = $this->historyColumns($withPaymentStatus);
        $values = $this->values(
            'NEW',
            "'INSERT'",
            $withPaymentStatus
        );

        DB::unprepared("
            CREATE TRIGGER trg_sanka_participants_insert
            AFTER INSERT ON sanka_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO sanka_participant_histories (
                    {$columns}
                ) VALUES (
                    {$values}
                );
            END
        ");
    }

    private function createUpdateTrigger(bool $withPaymentStatus): void
    {
        $columns = $this->historyColumns($withPaymentStatus);

        $operation = "
            CASE
                WHEN OLD.deleted_at IS NULL
                 AND NEW.deleted_at IS NOT NULL
                THEN 'DELETE'
                ELSE 'UPDATE'
            END
        ";

        $values = $this->values(
            'NEW',
            $operation,
            $withPaymentStatus
        );

        DB::unprepared("
            CREATE TRIGGER trg_sanka_participants_update
            AFTER UPDATE ON sanka_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO sanka_participant_histories (
                    {$columns}
                ) VALUES (
                    {$values}
                );
            END
        ");
    }

    private function createDeleteTrigger(bool $withPaymentStatus): void
    {
        $columns = $this->historyColumns($withPaymentStatus);
        $values = $this->values(
            'OLD',
            "'HARD_DELETE'",
            $withPaymentStatus
        );

        DB::unprepared("
            CREATE TRIGGER trg_sanka_participants_delete
            AFTER DELETE ON sanka_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO sanka_participant_histories (
                    {$columns}
                ) VALUES (
                    {$values}
                );
            END
        ");
    }
};
