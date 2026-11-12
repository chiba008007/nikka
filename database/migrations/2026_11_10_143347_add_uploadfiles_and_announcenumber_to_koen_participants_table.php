<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('koen_participants', function (Blueprint $table) {
            $table->string('uploadfile1', 512)->nullable()->after('othertext');
            $table->string('uploadfile2', 512)->nullable()->after('uploadfile1');
            $table->string('uploadfile3', 512)->nullable()->after('uploadfile2');
            $table->string('announcenumber', 128)->nullable()->after('uploadfile3');
        });
    }

    public function down(): void
    {
        Schema::table('koen_participants', function (Blueprint $table) {
            $table->dropColumn([
                'uploadfile1',
                'uploadfile2',
                'uploadfile3',
                'announcenumber',
            ]);
        });
    }
};
