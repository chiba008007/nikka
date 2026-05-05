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
        Schema::create('sanka_form_items', function (Blueprint $table) {
            $table->id();

            $table->string('group_key')->nullable(); // name_group など
            $table->string('name');                  // name1, name2, mail など

            $table->string('label_ja');
            $table->string('label_en')->nullable();

            $table->string('type');                  // text, email, radio, checkbox, textarea
            $table->string('placeholder_ja')->nullable();
            $table->string('placeholder_en')->nullable();

            $table->boolean('required')->default(false);
            $table->integer('sort_order')->default(0);
            $table->integer('column')->default(1);

            $table->json('error_messages')->nullable();
            $table->integer('error_flag')->default(1);
            $table->integer('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanka_form_items');
    }
};
