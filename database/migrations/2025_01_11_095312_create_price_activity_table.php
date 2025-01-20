<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('price_activity', function (Blueprint $table) {
            $table->id('price_id');  // รหัสราคา (Primary Key)
            $table->string('price_name');  // ชื่อราคา
            $table->unsignedBigInteger('promotion_id');  // รหัสโปรโมชัน (Foreign Key)
            $table->unsignedBigInteger('service_id');  // รหัสบริการ (Foreign Key)
            $table->unsignedBigInteger('speed_id');  // รหัสความเร็ว (Foreign Key)
            $table->timestamps();
            $table->foreign('promotion_id')->references('promotion_id')->on('promotion_activity')->onDelete('cascade');  // เชื่อมต่อกับ promotion_activity
            $table->foreign('service_id')->references('service_id')->on('serve_activity')->onDelete('cascade');  // เชื่อมต่อกับ serve_activity
            $table->foreign('speed_id')->references('speed_id')->on('speed_activity')->onDelete('cascade');  // เชื่อมต่อกับ speed_activity

        });
    }

    public function down()
    {
        Schema::dropIfExists('price_activity');
    }
};
