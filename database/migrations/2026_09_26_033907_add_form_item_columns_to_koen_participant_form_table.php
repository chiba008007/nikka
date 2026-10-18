<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('koen_participant_form', function (Blueprint $table) {

            $table->boolean('required')->default(false)->after('placeholder_en');
            $table->integer('sort_order')->nullable()->after('required');
            $table->integer('column')->nullable()->after('sort_order');

            $table->integer('error_flag')->nullable()->after('error_message_en');

            $table->integer('status')->default(1)->after('error_flag');
            $table->boolean('list_display')->default(false)->after('status');

            $table->text('checkbox_note_description')
                ->nullable()
                ->after('list_display');

            $table->text('checkbox_note_description_en')
                ->nullable()
                ->after('checkbox_note_description');
        });
    }

    public function down(): void
    {
        Schema::table('koen_participant_form', function (Blueprint $table) {
            $table->dropColumn([
                'required',
                'sort_order',
                'column',
                'error_flag',
                'status',
                'list_display',
                'checkbox_note_description',
                'checkbox_note_description_en',
            ]);
        });
    }
};
