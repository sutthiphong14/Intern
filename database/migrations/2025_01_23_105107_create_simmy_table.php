<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimmyTable extends Migration


{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sim_my', function (Blueprint $table) {
            $table->id('sim_id');  // รหัสซิม (Primary Key)
            $table->boolean('cus_new')->default(false);  // ลูกใหม่ (Boolean)
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('service_id')->on('serve_activity')->onDelete('cascade');
            $table->unsignedBigInteger('price_id');
            $table->foreign('price_id')->references('price_id')->on('price_activity')->onDelete('cascade');
            $table->unsignedBigInteger('cus_id');
            $table->foreign('cus_id')->references('cus_id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('province_id')->on('province_activity')->onDelete('cascade');
            $table->timestamps();

            // สร้าง Foreign Key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sim');
    }
};