<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        $this->recreateTriggers(true);
    }

    public function down(): void
    {
        $this->recreateTriggers(false);
    }

    private function recreateTriggers(bool $withOperationId): void
    {
        $definitions = [
            [
                'trg_koen_participants_ai',
                'AFTER INSERT',
                'koen_participants',
                'koen_participant_histories',
                'NEW',
                "'INSERT'",
                true,
                null,
            ],
            [
                'trg_koen_participants_bu',
                'BEFORE UPDATE',
                'koen_participants',
                'koen_participant_histories',
                'OLD',
                "IF(OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL, 'DELETE', 'UPDATE')",
                false,
                null,
            ],
            [
                'trg_koen_participants_au',
                'AFTER UPDATE',
                'koen_participants',
                'koen_participant_histories',
                'NEW',
                "'UPDATE'",
                true,
                'NOT (OLD.announcenumber <=> NEW.announcenumber)',
            ],
        ];

        foreach ($definitions as [
            $name, $timing, $sourceTable, $historyTable,
            $source, $operation, $includeAnnounce, $condition
        ]) {
            $columns = [
                'koen_participant_id',
                'participant_id',
                'koen_number',
            ];

            $values = [
                "{$source}.id",
                "{$source}.participant_id",
                "{$source}.koen_number",
            ];

            if ($includeAnnounce) {
                $columns[] = 'announcenumber';
                $values[] = "{$source}.announcenumber";
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
                $operation,
                "{$source}.status",
                'NOW()',
                "{$source}.created_at",
                "{$source}.updated_at",
                "{$source}.deleted_at",
            ]);

            for ($i = 1; $i <= 50; $i++) {
                $columns[] = "add_column_{$i}";
                $values[] = "{$source}.add_column_{$i}";
            }

            $this->createTrigger(
                $name,
                $timing,
                $sourceTable,
                $historyTable,
                $columns,
                $values,
                $withOperationId,
                $condition
            );
        }

        $this->createTrigger(
            'trg_koen_participant_authors_ai',
            'AFTER INSERT',
            'koen_participant_authors',
            'koen_participant_author_histories',
            [
                'koen_participant_id', 'author_id', 'author_number',
                'is_presenter', 'is_award_contact',
                'family_name_ja', 'given_name_ja',
                'family_name_en', 'given_name_en',
                'affiliation_numbers', 'operated_at',
            ],
            [
                'NEW.koen_participant_id', 'NEW.id', 'NEW.author_number',
                'NEW.is_presenter', 'NEW.is_award_contact',
                'NEW.family_name_ja', 'NEW.given_name_ja',
                'NEW.family_name_en', 'NEW.given_name_en',
                'NEW.affiliation_numbers', 'NOW()',
            ],
            $withOperationId
        );

        $this->createTrigger(
            'trg_koen_participant_affiliations_ai',
            'AFTER INSERT',
            'koen_participant_affiliations',
            'koen_participant_affiliation_histories',
            [
                'koen_participant_id', 'affiliation_id',
                'affiliation_number', 'organization',
                'department', 'short_name',
                'english', 'english_short', 'operated_at',
            ],
            [
                'NEW.koen_participant_id', 'NEW.id',
                'NEW.affiliation_number', 'NEW.organization',
                'NEW.department', 'NEW.short_name',
                'NEW.english', 'NEW.english_short', 'NOW()',
            ],
            $withOperationId
        );
    }

    private function createTrigger(
        string $name,
        string $timing,
        string $sourceTable,
        string $historyTable,
        array $columns,
        array $values,
        bool $withOperationId,
        ?string $condition = null
    ): void {
        if ($withOperationId) {
            $columns[] = 'operation_id';
            $values[] = '@koen_operation_id';
        }

        $columnSql = implode(', ', $columns);
        $valueSql = implode(', ', $values);

        $insertSql = "
            INSERT INTO {$historyTable} ({$columnSql})
            VALUES ({$valueSql});
        ";

        $body = $condition
            ? "IF {$condition} THEN {$insertSql} END IF;"
            : $insertSql;

        DB::unprepared("DROP TRIGGER IF EXISTS {$name}");

        DB::unprepared("
            CREATE TRIGGER {$name}
            {$timing} ON {$sourceTable}
            FOR EACH ROW
            BEGIN
                {$body}
            END
        ");
    }
};
