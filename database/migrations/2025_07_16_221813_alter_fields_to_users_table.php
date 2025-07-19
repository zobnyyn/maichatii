<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //хочу изменить длину поля name с 255 до 100 символов и email
            $table->string('name', 100)->change();
            $table->string('email', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //возвращаю длину поля name с 100 до 255 символов и email
            $table->string('name', 255)->change();
            $table->string('email', 255)->change();
        });
    }
};
