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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('user'); // Default role is 'user'
            $table->string('avatar')->nullable(); // Optional avatar field
            $table->timestamps(); // стандартные created_at и updated_at
            $table->timestamp('updated')->useCurrent()->useCurrentOnUpdate(); // отдельное поле, если нужно
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
