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
            $table->timestamps();
        });
        
        // สร้างตาราง speed_activity
        Schema::create('speed_activity', function (Blueprint $table) {
            $table->id('speed_id');  // รหัสความเร็ว (Primary Key)
            $table->string('speed_name');  // ชื่อความเร็ว
            $table->unsignedBigInteger('price_id');  // รหัสราคา (Foreign Key)
            $table->foreign('price_id')->references('price_id')->on('price_activity');  // เชื่อมต่อกับ price_activity
            $table->timestamps();
        });

        // สร้างตาราง promotion_activity
        Schema::create('promotion_activity', function (Blueprint $table) {
            $table->id('promotion_id');
            $table->string('promotion_name');
            $table->unsignedBigInteger('speed_id');
            $table->timestamps();
            
            $table->foreign('speed_id')->references('speed_id')->on('speed_activity');
        });

        // สร้างตาราง serve_activity
        Schema::create('serve_activity', function (Blueprint $table) {
            $table->id('service_id');
            $table->string('service_name');
            $table->unsignedBigInteger('promotion_id');
            $table->timestamps();
            
            $table->foreign('promotion_id')->references('promotion_id')->on('promotion_activity');
        });

        // สร้างตาราง type_activity
        Schema::create('type_activity', function (Blueprint $table) {
            $table->id('type_id');
            $table->unsignedBigInteger('service_id');
            $table->string('type_name');
            $table->timestamps();
            
            $table->foreign('service_id')->references('service_id')->on('serve_activity');
        });

        // สร้างตาราง serviceCenter_activity
        Schema::create('serviceCenter_activity', function (Blueprint $table) {
            $table->id('center_id');
            $table->string('center_name');
            $table->timestamps();
        });

        // สร้างตาราง province_activity
        Schema::create('province_activity', function (Blueprint $table) {
            $table->id('province_id');
            $table->string('province_name');
            $table->unsignedBigInteger('center_id');
            $table->timestamps();
            
            $table->foreign('center_id')->references('center_id')->on('serviceCenter_activity');
        });



        // สร้างตาราง user_activity
        Schema::create('user_activity', function (Blueprint $table) {
            $table->string('id_card')->primary();
            $table->string('full_name');
            $table->string('photo')->nullable();
            $table->string('address_no');
            $table->string('road')->nullable();
            $table->string('soi')->nullable();
            $table->string('sub_district');
            $table->string('district');
            $table->string('postal_code');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('province_id');
            $table->timestamps();
            
            $table->foreign('type_id')->references('type_id')->on('type_activity');
            $table->foreign('province_id')->references('province_id')->on('province_activity');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_activity');
        Schema::dropIfExists('province_activity');
        Schema::dropIfExists('serviceCenter_activity');
        Schema::dropIfExists('type_activity');
        Schema::dropIfExists('serve_activity');
        Schema::dropIfExists('promotion_activity');
        Schema::dropIfExists('speed_activity');
    }
};