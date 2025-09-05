<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // THÔNG TIN CHUNG
            $table->string('full_name');
            $table->date('dob');
            $table->enum('gender', ['male','female'])->nullable(); // 0/1 → map sau
            $table->string('ethnicity')->nullable(); // Dân tộc
            $table->string('cccd_number')->unique();
            $table->string('birth_place')->nullable(); // Nơi sinh
            $table->string('email');
            $table->string('phone');
            $table->string('cccd_front_path')->nullable();
            $table->string('cccd_back_path')->nullable();
            $table->string('address')->nullable();

            // THÔNG TIN TUYỂN SINH
            $table->string('priority_object')->nullable(); // Đối tượng ưu tiên (01..10)
            $table->string('priority_area')->nullable();   // KV1/KV2/…/KV3
            $table->unsignedSmallInteger('graduation_year')->nullable();

            // NGƯỜI LIÊN HỆ
            $table->string('contact_name')->nullable();
            $table->string('contact_relation')->nullable(); // Bố/Mẹ/Người giám hộ
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
