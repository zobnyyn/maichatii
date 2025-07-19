<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Запускает миграцию: добавляет внешний ключ к таблице posts
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Добавляем внешний ключ для связи с таблицей categories
            $table->unsignedBigInteger('category_id')->nullable(); // поле для внешнего ключа
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null'); // устанавливаем связь с таблицей categories
        });
    }

    /**
     * Откатывает миграцию: удаляет внешний ключ и столбец
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Удаляем внешний ключ и столбец
            $table->dropForeign(['category_id']); // вначале удаляем внешний ключ, а потом удаляем столбец
            $table->dropColumn('category_id');
        });
    }
};
