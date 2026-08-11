<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * 不要な参加者情報カラムを削除し、
     * 履歴保存トリガーを現在のテーブル構成に合わせて再作成する。
     */
    public function up(): void
    {
        /*
         * カラム削除前に既存トリガーを削除する。
         */
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_delete');

        /*
         * sanka_participants から削除するカラム。
         * is_selector は前Migrationですでに削除済みでも問題ないよう存在確認する。
         */
        $participantColumns = [
            'family_name',
            'first_name',
            'family_name_kana',
            'first_name_kana',
            'organization',
            'department',
            'laboratory',
            'address_type_id',
            'postal_code',
            'address',
            'telephone',
            'fax',
            'email',
            'password',
            'expertise_ids',
            'expertise_other',
            'society_ids',
            'society_other',
            'join_type_id',
            'travel_support_requested',
            'banquet_requested',
            'participation_fee',
            'banquet_fee',
            'total_amount',
            'remarks',
            'admin_remarks',
            'mail_sent',
            'is_selector',
        ];

        /*
         * 外部キーが存在する場合は先に削除する。
         */
        $this->dropForeignKeysForColumns(
            'sanka_participants',
            $participantColumns
        );

        /*
         * 存在するカラムだけ削除する。
         */
        $existingParticipantColumns = array_values(
            array_filter(
                $participantColumns,
                fn ($column) => Schema::hasColumn(
                    'sanka_participants',
                    $column
                )
            )
        );

        if (!empty($existingParticipantColumns)) {
            Schema::table(
                'sanka_participants',
                function (Blueprint $table) use ($existingParticipantColumns) {
                    // 不要カラムを削除
                    $table->dropColumn($existingParticipantColumns);
                }
            );
        }

        /*
         * 履歴テーブルから削除するカラム。
         * password は履歴テーブルには元々存在しないため対象外。
         */
        $historyColumns = [
            'family_name',
            'first_name',
            'family_name_kana',
            'first_name_kana',
            'organization',
            'department',
            'laboratory',
            'address_type_id',
            'postal_code',
            'address',
            'telephone',
            'fax',
            'email',
            'expertise_ids',
            'expertise_other',
            'society_ids',
            'society_other',
            'join_type_id',
            'travel_support_requested',
            'banquet_requested',
            'participation_fee',
            'banquet_fee',
            'total_amount',
            'remarks',
            'admin_remarks',
            'mail_sent',
            'is_selector',
        ];

        /*
         * 履歴テーブル側の外部キーが存在する場合は先に削除する。
         */
        $this->dropForeignKeysForColumns(
            'sanka_participant_histories',
            $historyColumns
        );

        /*
         * 存在するカラムだけ削除する。
         */
        $existingHistoryColumns = array_values(
            array_filter(
                $historyColumns,
                fn ($column) => Schema::hasColumn(
                    'sanka_participant_histories',
                    $column
                )
            )
        );

        if (!empty($existingHistoryColumns)) {
            Schema::table(
                'sanka_participant_histories',
                function (Blueprint $table) use ($existingHistoryColumns) {
                    // 不要カラムを削除
                    $table->dropColumn($existingHistoryColumns);
                }
            );
        }

        /*
         * 現在残っている項目だけで履歴保存トリガーを作り直す。
         */
        $this->createTriggers();
    }

    /**
     * 削除したデータそのものは復元できないため、
     * downではトリガーのみ削除する。
     */
    public function down(): void
    {
        // 再作成したトリガーを削除
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_sanka_participants_delete');
    }

    /**
     * 指定カラムに設定されている外部キーを削除する。
     */
    private function dropForeignKeysForColumns(
        string $tableName,
        array $columns
    ): void {
        $foreignKeys = DB::select(
            '
            SELECT
                CONSTRAINT_NAME,
                COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND REFERENCED_TABLE_NAME IS NOT NULL
            ',
            [$tableName]
        );

        foreach ($foreignKeys as $foreignKey) {
            if (!in_array($foreignKey->COLUMN_NAME, $columns, true)) {
                continue;
            }

            // 外部キー制約を削除
            DB::statement(
                sprintf(
                    'ALTER TABLE `%s` DROP FOREIGN KEY `%s`',
                    $tableName,
                    $foreignKey->CONSTRAINT_NAME
                )
            );
        }
    }

    /**
     * 履歴保存トリガーを作成する。
     */
    private function createTriggers(): void
    {
        /*
         * add_column_1 ～ add_column_50 を生成する。
         */
        $addColumns = [];

        for ($i = 1; $i <= 50; $i++) {
            $addColumns[] = 'add_column_' . $i;
        }

        /*
         * sanka_participants と履歴テーブルの両方に存在する
         * 追加カラムだけを履歴保存対象にする。
         */
        $addColumns = array_values(
            array_filter(
                $addColumns,
                fn ($column) =>
                    Schema::hasColumn('sanka_participants', $column)
                    && Schema::hasColumn(
                        'sanka_participant_histories',
                        $column
                    )
            )
        );

        /*
         * participation_status / banquet_status も
         * 両テーブルに存在する場合は履歴保存する。
         */
        $statusColumns = [];

        foreach (['participation_status', 'banquet_status'] as $column) {
            if (
                Schema::hasColumn('sanka_participants', $column)
                && Schema::hasColumn(
                    'sanka_participant_histories',
                    $column
                )
            ) {
                $statusColumns[] = $column;
            }
        }

        /*
         * INSERT INTO 側のカラム。
         */
        $historyColumns = array_merge(
            [
                'participant_id',
                'reception_serial',
                'reception_number',
                'operation',
                'status',
            ],
            $addColumns,
            $statusColumns,
            [
                'participant_created_at',
                'participant_updated_at',
                'participant_deleted_at',
                'operated_at',
            ]
        );

        $historyColumnSql = implode(
            ",\n                    ",
            $historyColumns
        );

        /*
         * INSERT時の値。
         */
        $insertValues = array_merge(
            [
                'NEW.id',
                'NEW.reception_serial',
                'NEW.reception_number',
                "'INSERT'",
                'NEW.status',
            ],
            array_map(
                fn ($column) => 'NEW.' . $column,
                $addColumns
            ),
            array_map(
                fn ($column) => 'NEW.' . $column,
                $statusColumns
            ),
            [
                'NEW.created_at',
                'NEW.updated_at',
                'NEW.deleted_at',
                'NOW()',
            ]
        );

        $insertValueSql = implode(
            ",\n                    ",
            $insertValues
        );

        /*
         * UPDATE時の値。
         */
        $updateValues = array_merge(
            [
                'NEW.id',
                'NEW.reception_serial',
                'NEW.reception_number',
                "
                CASE
                    WHEN OLD.deleted_at IS NULL
                     AND NEW.deleted_at IS NOT NULL
                    THEN 'DELETE'
                    ELSE 'UPDATE'
                END
                ",
                'NEW.status',
            ],
            array_map(
                fn ($column) => 'NEW.' . $column,
                $addColumns
            ),
            array_map(
                fn ($column) => 'NEW.' . $column,
                $statusColumns
            ),
            [
                'NEW.created_at',
                'NEW.updated_at',
                'NEW.deleted_at',
                'NOW()',
            ]
        );

        $updateValueSql = implode(
            ",\n                    ",
            $updateValues
        );

        /*
         * DELETE時の値。
         */
        $deleteValues = array_merge(
            [
                'OLD.id',
                'OLD.reception_serial',
                'OLD.reception_number',
                "'HARD_DELETE'",
                'OLD.status',
            ],
            array_map(
                fn ($column) => 'OLD.' . $column,
                $addColumns
            ),
            array_map(
                fn ($column) => 'OLD.' . $column,
                $statusColumns
            ),
            [
                'OLD.created_at',
                'OLD.updated_at',
                'OLD.deleted_at',
                'NOW()',
            ]
        );

        $deleteValueSql = implode(
            ",\n                    ",
            $deleteValues
        );

        /*
         * INSERTトリガー。
         */
        DB::unprepared("
            CREATE TRIGGER trg_sanka_participants_insert
            AFTER INSERT ON sanka_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO sanka_participant_histories (
                    {$historyColumnSql}
                ) VALUES (
                    {$insertValueSql}
                );
            END
        ");

        /*
         * UPDATE / 論理削除トリガー。
         */
        DB::unprepared("
            CREATE TRIGGER trg_sanka_participants_update
            AFTER UPDATE ON sanka_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO sanka_participant_histories (
                    {$historyColumnSql}
                ) VALUES (
                    {$updateValueSql}
                );
            END
        ");

        /*
         * 物理削除トリガー。
         */
        DB::unprepared("
            CREATE TRIGGER trg_sanka_participants_delete
            AFTER DELETE ON sanka_participants
            FOR EACH ROW
            BEGIN
                INSERT INTO sanka_participant_histories (
                    {$historyColumnSql}
                ) VALUES (
                    {$deleteValueSql}
                );
            END
        ");
    }
};
