<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('type', 11);
            $table->string('name', 1280);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('id');
        });

        DB::statement(
            'ALTER TABLE `settings` DROP PRIMARY KEY, ADD PRIMARY KEY (`type`)'
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
