<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('koen_participant_form_options', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('koen_participant_form_id');

            $table->text('label_ja')->nullable();
            $table->text('label_en')->nullable();
            $table->string('value')->nullable();
            $table->integer('sort_order')->nullable();
            $table->integer('status')->default(1);

            $table->timestamps();

            $table->foreign('koen_participant_form_id')
                ->references('id')
                ->on('koen_participant_form')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koen_participant_form_options');
    }
};
