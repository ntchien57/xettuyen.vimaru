<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('wishes', function (Blueprint $table) {
            $table->string('exam_id', 50)->nullable()->after('user_id');
        });
    }
    public function down(): void {
        Schema::table('wishes', function (Blueprint $table) {
            $table->dropColumn('exam_id');
        });
    }
};
