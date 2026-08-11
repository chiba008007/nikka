<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sanka_fee_options', function (Blueprint $table) {
            $table->id();

            // 親の料金項目
            $table->foreignId('sanka_fee_item_id')
                ->constrained('sanka_fee_items')
                ->cascadeOnDelete();

            // 選択肢表示名
            $table->string('label_ja');
            $table->string('label_en')->nullable();

            // 保存値
            $table->string('value');

            // 金額
            $table->integer('amount')->default(0);

            // 表示順
            $table->integer('sort_order')->default(0);

            // 有効 / 無効
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanka_fee_options');
    }
};
