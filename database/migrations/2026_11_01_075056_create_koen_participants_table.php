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
        Schema::create('koen_participants', function (Blueprint $table) {
            $table->id();

            // 参加者との関連付け
            $table->foreignId('participant_id')
                ->constrained('sanka_participants');

            $table->unsignedTinyInteger('status')->default(1);

            // 講演登録フォームの入力値
            for ($i = 1; $i <= 50; $i++) {
                $table->text("add_column_{$i}")->nullable();
            }

            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koen_participants');
    }
};
