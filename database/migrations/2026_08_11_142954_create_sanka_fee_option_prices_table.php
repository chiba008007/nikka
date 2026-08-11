<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sanka_fee_option_prices', function (Blueprint $table) {
            $table->id();

            // 料金選択肢
            $table->foreignId('sanka_fee_option_id')
                ->constrained('sanka_fee_options')
                ->cascadeOnDelete();

            // 参加区分ID
            $table->integer('join_type_id');

            // 区分ごとの金額
            $table->integer('amount')->default(0);

            // 有効 / 無効
            $table->boolean('status')->default(true);

            $table->timestamps();

            // 同じ選択肢・参加区分を重複登録させない
            $table->unique(
                ['sanka_fee_option_id', 'join_type_id'],
                'sanka_fee_option_prices_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanka_fee_option_prices');
    }
};
