<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('speed_activity', function (Blueprint $table) {
            $table->id('speed_id');  // รหัสความเร็ว (Primary Key)
            $table->string('speed_name');  // ชื่อความเร็ว
            $table->unsignedBigInteger('promotion_id');  // รหัสราคา (Foreign Key)
            $table->unsignedBigInteger('service_id'); // รหัสบริการ (Foreign Key)
            $table->timestamps();

            $table->foreign('promotion_id')->references('promotion_id')->on('promotion_activity')->onDelete('cascade');  // เชื่อมต่อกับ promotion_activity
            $table->foreign('service_id')->references('service_id')->on('serve_activity')->onDelete('cascade');  // เชื่อมต่อกับ serve_activity
        });
    }

    public function down()
    {
        Schema::dropIfExists('speed_activity');
    }
};