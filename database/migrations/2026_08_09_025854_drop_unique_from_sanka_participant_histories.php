<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        // UNIQUE制約が存在する場合のみ削除する
        $indexes = DB::select("
        SHOW INDEX FROM sanka_participant_histories
        WHERE Key_name IN (
            'sanka_participant_histories_reception_serial_unique',
            'sanka_participant_histories_reception_number_unique'
        )
    ");

        $indexNames = collect($indexes)->pluck('Key_name')->unique()->all();

        if (in_array('sanka_participant_histories_reception_serial_unique', $indexNames, true)) {
            Schema::table('sanka_participant_histories', function (Blueprint $table) {
                $table->dropUnique('sanka_participant_histories_reception_serial_unique');
            });
        }

        if (in_array('sanka_participant_histories_reception_number_unique', $indexNames, true)) {
            Schema::table('sanka_participant_histories', function (Blueprint $table) {
                $table->dropUnique('sanka_participant_histories_reception_number_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::table('sanka_participant_histories', function (Blueprint $table) {
            // rollback時のみUNIQUEを戻す
            $table->unique('reception_serial');
            $table->unique('reception_number');
        });
    }
};
