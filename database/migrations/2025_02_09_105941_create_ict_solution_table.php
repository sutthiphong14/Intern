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
        Schema::create('ict_solution', function (Blueprint $table) {
            $table->id('ict_id');
            $table->enum('customer_type', ['หน่วยงานรัฐบาล', 'หน่วยงานเอกชน', 'หน่วยงานทั่วไป'])->default('หน่วยงานทั่วไป');
            $table->string('quote')->nullable(); // ชื่อไฟล์ใบเสนอราคา
            $table->decimal('income', 10, 2); // 10 หลัก และทศนิยม 2 ตำแหน่ง
            $table->unsignedBigInteger('cus_id');
            $table->foreign('cus_id')->references('cus_id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('type_id')->on('type_activity')->onDelete('cascade');
            $table->unsignedBigInteger('ict_service_id');
            $table->foreign('ict_service_id')->references('ict_service_id')->on('ict_services')->onDelete('cascade');
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('province_id')->on('province_activity')->onDelete('cascade');
            $table->unsignedBigInteger('center_id');
            $table->foreign('center_id')->references('center_id')->on('servicecenter_activity')->onDelete('cascade');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ict_solution');
    }
};
