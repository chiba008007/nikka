
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('koen_participant_author_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('koen_participant_id')->index();
            $table->unsignedBigInteger('author_id');
            $table->unsignedInteger('author_number');
            $table->boolean('is_presenter')->nullable();
            $table->boolean('is_award_contact')->nullable();
            $table->string('family_name_ja')->nullable();
            $table->string('given_name_ja')->nullable();
            $table->string('family_name_en')->nullable();
            $table->string('given_name_en')->nullable();
            $table->string('affiliation_numbers')->nullable();
            $table->timestamp('operated_at')->useCurrent();
        });

        Schema::create('koen_participant_affiliation_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('koen_participant_id')->index();
            $table->unsignedBigInteger('affiliation_id');
            $table->unsignedInteger('affiliation_number');
            $table->string('organization')->nullable();
            $table->string('department')->nullable();
            $table->string('short_name')->nullable();
            $table->string('english')->nullable();
            $table->string('english_short')->nullable();
            $table->timestamp('operated_at')->useCurrent();
        });

        Schema::table('koen_participant_histories', function (Blueprint $table) {
            $table->dropColumn(['authors_json', 'affiliations_json']);
        });
    }

    public function down(): void
    {
        Schema::table('koen_participant_histories', function (Blueprint $table) {
            $table->json('authors_json')->nullable();
            $table->json('affiliations_json')->nullable();
        });

        Schema::dropIfExists('koen_participant_author_histories');
        Schema::dropIfExists('koen_participant_affiliation_histories');
    }
};
