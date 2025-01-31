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
        Schema::create('service_attributes', function (Blueprint $table) {
            $table->id('attribute_id');
            $table->unsignedBigInteger('service_id');
            $table->string('attribute_name'); // ชื่อฟิลด์ (เช่น serial_number, installation_date)
            $table->string('data_type'); // ชนิดข้อมูล (string, number, boolean)
            $table->string('custom_true_value')->nullable(); // ชนิดข้อมูล (string, number, boolean)
            $table->string('custom_false_value')->nullable(); // ชนิดข้อมูล (string, number, boolean)
            $table->boolean('is_required')->default(false); // จำเป็นต้องกรอกหรือไม่
            $table->timestamps();
            $table->foreign('service_id')->references('service_id')->on('serve_activity')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_attributes');
    }
};
