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
        Schema::create('koen_participant_histories', function (Blueprint $table) {
            $table->id();

            // 履歴対象
            $table->unsignedBigInteger('koen_participant_id');
            $table->unsignedBigInteger('participant_id');

            // 操作情報
            $table->string('operation', 20);
            $table->unsignedTinyInteger('status');
            $table->timestamp('operated_at')->useCurrent();
            $table->unsignedBigInteger('operated_by')->nullable();

            // 元データの日時
            $table->timestamp('participant_created_at')->nullable();
            $table->timestamp('participant_updated_at')->nullable();
            $table->timestamp('participant_deleted_at')->nullable();

            // 入力値の履歴
            for ($i = 1; $i <= 50; $i++) {
                $table->text("add_column_{$i}")->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koen_participant_histories');
    }
};
