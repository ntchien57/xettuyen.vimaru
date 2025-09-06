<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('combo_offsets', function (Blueprint $table) {
            $table->id();
            $table->string('combo_code', 10);      // A00, A01, C01, D01...
            $table->string('base_code', 10)->default('D01'); // tổ hợp gốc để so sánh
            $table->string('method', 10)->nullable(); // PT1 / PT2 (null = áp dụng chung)
            $table->decimal('delta', 6, 3)->default(0); // độ chênh (âm/dương)
            $table->unsignedSmallInteger('order_no')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['combo_code','base_code','method'], 'combo_offsets_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combo_offsets');
    }
};
