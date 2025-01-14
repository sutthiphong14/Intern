<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('slideshows', function (Blueprint $table) {
            $table->id('slideshow_id');
            $table->string('slideshow_image');
            $table->string('slideshow_link')->nullable(); // ทำให้คอลัมน์ slideshow_link รองรับค่า null
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slideshows');
    }
};
