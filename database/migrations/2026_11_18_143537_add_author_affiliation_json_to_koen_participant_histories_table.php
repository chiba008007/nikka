
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('koen_participant_histories', function (Blueprint $table) {
            $table->json('authors_json')->nullable();
            $table->json('affiliations_json')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('koen_participant_histories', function (Blueprint $table) {
            $table->dropColumn([
                'authors_json',
                'affiliations_json',
            ]);
        });
    }
};
