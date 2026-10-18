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
        Schema::create('koen_participant_author_option', function (Blueprint $table) {
            $table->id();
            $table->string('type', 128);
            $table->text('note_ja')->nullable();
            $table->text('note_en')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('required')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koen_participant_author_option');
    }
};
