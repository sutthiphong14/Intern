<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('serviceCenter_activity', function (Blueprint $table) {
            $table->id('center_id');
            $table->string('center_name');
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('province_id')->on('province_activity')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('serviceCenter_activity');
    }
};