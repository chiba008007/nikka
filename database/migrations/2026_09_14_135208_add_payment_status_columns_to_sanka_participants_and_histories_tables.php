<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sanka_participants', function (Blueprint $table) {
            $table->unsignedTinyInteger('participation_payment_status')
                ->default(0)
                ->comment('参加費支払ステータス')
                ->after('banquet_status');

            $table->unsignedTinyInteger('banquet_payment_status')
                ->default(0)
                ->comment('懇親会費支払ステータス')
                ->after('participation_payment_status');
        });

        Schema::table('sanka_participant_histories', function (Blueprint $table) {
            $table->unsignedTinyInteger('participation_payment_status')
                ->default(0)
                ->comment('参加費支払ステータス')
                ->after('banquet_status');

            $table->unsignedTinyInteger('banquet_payment_status')
                ->default(0)
                ->comment('懇親会費支払ステータス')
                ->after('participation_payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sanka_participants', function (Blueprint $table) {
            $table->dropColumn([
                'participation_payment_status',
                'banquet_payment_status',
            ]);
        });

        Schema::table('sanka_participant_histories', function (Blueprint $table) {
            $table->dropColumn([
                'participation_payment_status',
                'banquet_payment_status',
            ]);
        });
    }
};
