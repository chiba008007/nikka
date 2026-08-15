<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->id();

            // メール種別
            $table->string('mail_type', 50);

            // 新規登録時の件名
            $table->text('create_subject');

            // 編集時の件名
            $table->text('update_subject');

            // メール本文
            $table->text('body');

            // 有効・無効
            $table->unsignedTinyInteger('status')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_templates');
    }
};
