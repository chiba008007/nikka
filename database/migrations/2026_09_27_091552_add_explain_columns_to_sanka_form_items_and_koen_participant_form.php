<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('sanka_form_items', function (Blueprint $table) {
            $table->text('explain_jp')
                ->nullable()
                ->after('name');

            $table->text('explain_en')
                ->nullable()
                ->after('explain_jp');
        });

        Schema::table('koen_participant_form', function (Blueprint $table) {
            $table->text('explain_jp')
                ->nullable()
                ->after('name');

            $table->text('explain_en')
                ->nullable()
                ->after('explain_jp');
        });
    }

    public function down(): void
    {
        Schema::table('sanka_form_items', function (Blueprint $table) {
            $table->dropColumn([
                'explain_jp',
                'explain_en',
            ]);
        });

        Schema::table('koen_participant_form', function (Blueprint $table) {
            $table->dropColumn([
                'explain_jp',
                'explain_en',
            ]);
        });
    }
};
