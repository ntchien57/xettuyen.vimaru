<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            // Chỉ tiêu (số nguyên, có thể để trống)
            $table->unsignedInteger('quota')->nullable()->after('note');
            // Điểm chuẩn (thang 30, 2 chữ số thập phân, có thể để trống)
            $table->decimal('cutoff_score', 5, 2)->nullable()->after('quota');
        });
    }

    public function down(): void
    {
        Schema::table('majors', function (Blueprint $table) {
            $table->dropColumn(['quota', 'cutoff_score']);
        });
    }
};
