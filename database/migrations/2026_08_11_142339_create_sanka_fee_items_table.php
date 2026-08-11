<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sanka_fee_items', function (Blueprint $table) {
            $table->id();

            // 管理用名称
            $table->string('name');

            // 表示タイトル
            $table->string('label_ja')->nullable();
            $table->string('label_en')->nullable();

            // radio / checkbox など
            $table->string('type');

            // 説明文
            $table->text('description_ja')->nullable();
            $table->text('description_en')->nullable();

            // 通貨表記
            $table->string('currency_label_ja')->default('円');
            $table->string('currency_label_en')->default('yen');

            // 表示順
            $table->integer('sort_order')->default(0);

            // 有効 / 無効
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanka_fee_items');
    }
};
