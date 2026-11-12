<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('koen_participants', function (Blueprint $table) {
            $table->text('othertext')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('koen_participants', function (Blueprint $table) {
            $table->dropColumn('othertext');
        });
    }
};
