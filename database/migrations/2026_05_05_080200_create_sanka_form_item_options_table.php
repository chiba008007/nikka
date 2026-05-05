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
        Schema::create('sanka_form_item_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sanka_form_item_id')->constrained()->cascadeOnDelete();
            $table->string('label_ja');
            $table->string('label_en')->nullable();
            $table->string('value');
            $table->integer('sort_order')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanka_form_item_options');
    }
};
