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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('cus_id'); // Primary Key ชื่อ customer_id
            $table->string('cus_fullname'); // ชื่อ นามสกุล
            $table->string('id_card', 13); // รหัสบัตรประชาชน (13 หลัก) และต้องไม่ซ้ำ
            $table->string('cus_photo')->nullable(); // เก็บ Path ของรูปถ่าย (optional)
            $table->text('cus_address'); // ที่อยู่
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('type_id')->on('type_activity');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('service_id')->on('serve_activity');
            $table->unsignedBigInteger('promotion_id');
            $table->foreign('promotion_id')->references('promotion_id')->on('promotion_activity');
            $table->unsignedBigInteger('speed_id');
            $table->foreign('speed_id')->references('speed_id')->on('speed_activity');
            $table->unsignedBigInteger('price_id');
            $table->foreign('price_id')->references('price_id')->on('price_activity');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('province_id')->on('province_activity');
            $table->unsignedBigInteger('center_id')->nullable();
            $table->foreign('center_id')->references('center_id')->on('servicecenter_activity');
            $table->text('other')->nullable();
            $table->timestamps(); // สร้าง created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
