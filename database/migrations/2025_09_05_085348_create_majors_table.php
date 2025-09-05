<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();     // Mã CN: D101...
            $table->string('name');                   // Tên chuyên ngành
            $table->string('group_name')->nullable(); // Nhóm (Kỹ thuật & CN…)
            $table->json('exam_combos')->nullable();  // Tổ hợp xét tuyển (mảng JSON)
            $table->boolean('is_advanced')->default(false);        // (nâng cao)
            $table->boolean('is_optional')->default(false);        // (chọn)
            $table->boolean('taught_in_english')->default(false);  // Giảng dạy bằng tiếng Anh
            $table->unsignedSmallInteger('order_no')->default(0);  // Thứ tự hiển thị
            $table->boolean('active')->default(true);
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
