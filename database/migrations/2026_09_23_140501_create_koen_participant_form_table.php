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
        Schema::create('koen_participant_form', function (Blueprint $table) {
            $table->increments('id');

            $table->string('page_type', 20);
            $table->string('type', 20);
            $table->string('type_code', 20);

            $table->string('name', 255);
            $table->string('label_ja', 255)->nullable();
            $table->string('label_en', 255)->nullable();

            $table->string('placeholder_ja', 255)->nullable();
            $table->string('placeholder_en', 255)->nullable();

            $table->text('note')->nullable();
            $table->text('error_message')->nullable();
            $table->text('error_message_en')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koen_participant_form');
    }
};
