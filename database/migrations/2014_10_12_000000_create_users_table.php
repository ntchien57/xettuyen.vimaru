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
            $table->string('hoten');
            $table->string('email')->unique();
            $table->string('cccd', 12)->unique();
            $table->string('matkhau');
            $table->tinyInteger('role')->default(0); // 0: thí sinh, 1: pđt, 2: hiệu trưởng
            $table->timestamps();
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
