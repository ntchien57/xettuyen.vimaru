<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wishes', function (Blueprint $table) {
            $table->id();

            // Thí sinh
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Chuyên ngành được chọn (tham chiếu majors.code)
            $table->string('major_code', 20);
            // Nếu majors.code là unique, bạn có thể gắn FK như sau (MySQL/MariaDB ok):
            // $table->foreign('major_code')->references('code')->on('majors')->cascadeOnUpdate();

            // Thứ tự nguyện vọng (1,2,3,...) — quan trọng
            $table->unsignedSmallInteger('order_no');

            // Mở rộng (tuỳ dùng)
            $table->string('exam_combo', 10)->nullable();      // A00, D01...
            $table->string('method', 10)->nullable();          // PT1, PT2...
            $table->decimal('raw_score', 5, 2)->nullable();    // điểm thí sinh nhập
            $table->decimal('converted_score', 5, 2)->nullable(); // điểm quy đổi (nếu tính và lưu)

            // Trạng thái xử lý NV (t tuỳ chỉnh)
            $table->string('status', 20)->default('pending');  // pending/accepted/rejected
            $table->string('note')->nullable();

            $table->timestamps();

            // Mỗi user chỉ có 1 bản ghi cho mỗi thứ tự NV
            $table->unique(['user_id', 'order_no']);
            // Tra cứu nhanh
            $table->index(['user_id', 'major_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishes');
    }
};
