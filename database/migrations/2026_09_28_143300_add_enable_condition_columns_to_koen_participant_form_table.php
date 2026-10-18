<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('koen_participant_form', function (Blueprint $table) {
            $table->string('enable_source_name')
                ->nullable()
                ->after('name');

            $table->string('enable_source_value')
                ->nullable()
                ->after('enable_source_name');
        });
    }

    public function down(): void
    {
        Schema::table('koen_participant_form', function (Blueprint $table) {
            $table->dropColumn([
                'enable_source_name',
                'enable_source_value',
            ]);
        });
    }
};
