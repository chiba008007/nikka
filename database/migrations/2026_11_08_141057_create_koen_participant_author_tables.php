<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        // 所属機関
        Schema::create('koen_participant_affiliations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koen_participant_id')
                ->constrained('koen_participants')
                ->cascadeOnDelete();

            $table->unsignedInteger('affiliation_number');
            $table->string('organization')->nullable();
            $table->string('department')->nullable();
            $table->string('short_name')->nullable();
            $table->string('english')->nullable();
            $table->string('english_short')->nullable();

            $table->timestamps();

            $table->unique(
                ['koen_participant_id', 'affiliation_number'],
                'kpa_affiliation_unique'
            );
        });

        // 著者名
        Schema::create('koen_participant_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('koen_participant_id')
                ->constrained('koen_participants')
                ->cascadeOnDelete();

            $table->unsignedInteger('author_number');

            $table->boolean('is_presenter')->default(false);
            $table->boolean('is_award_contact')->default(false);

            $table->string('family_name_ja')->nullable();
            $table->string('given_name_ja')->nullable();
            $table->string('given_name_en')->nullable();
            $table->string('family_name_en')->nullable();

            $table->string('affiliation_numbers')->nullable();

            $table->timestamps();

            $table->unique(
                ['koen_participant_id', 'author_number'],
                'kpa_author_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koen_participant_authors');
        Schema::dropIfExists('koen_participant_affiliations');
    }
};
