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
        Schema::create('ict_products', function (Blueprint $table) {
            $table->id('product_id'); // Primary Key
            $table->string('product_name'); // ชื่อสินค้า
            $table->text('description')->nullable(); // รายละเอียดสินค้า
            $table->unsignedBigInteger('type_id'); // รหัสบริการ (Foreign Key)
            $table->foreign('type_id')->references('type_id')->on('type_activity')->onDelete('cascade');
            $table->unsignedBigInteger('ict_service_id');
            $table->foreign('ict_service_id')->references('ict_service_id')->on('ict_services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ict_products');
    }
};
