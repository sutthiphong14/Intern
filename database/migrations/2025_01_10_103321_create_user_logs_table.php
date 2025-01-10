<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // User ที่ทำการแก้ไข
            $table->string('action'); // เช่น created, updated, deleted
            $table->string('model'); // ชื่อโมเดล เช่น "User"
            $table->json('data')->nullable(); // ข้อมูลที่เปลี่ยนแปลง
            $table->timestamps(); // เวลาเกิดเหตุการณ์
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_logs');
    }
};
