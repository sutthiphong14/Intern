<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFttxBroadbandTable extends Migration
{
    public function up()
    {
        Schema::create('fttx_broadband', function (Blueprint $table) {
            $table->id('fttx_id');  // รหัสหลัก (Primary Key)
            $table->boolean('new');  // ฟิลด์ลูกค้าใหม่
            // ฟิลด์เดียวแทน ติดตั้งเอง หรือ จ้างผู้รับเหมา
            $table->boolean('installation_type');
            // Foreign Key to customers table
            $table->unsignedBigInteger('cus_id');
            $table->foreign('cus_id')->references('cus_id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('center_id');
            $table->foreign('center_id')->references('center_id')->on('servicecenter_activity')->onDelete('cascade');
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('province_id')->on('province_activity')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fttx_broadband');
    }
}
