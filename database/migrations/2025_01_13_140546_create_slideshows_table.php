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
        $table->string('slideshow_link');
        $table->boolean('slideshow_status')->default(1); // 1 = Active, 0 = Inactive
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('slideshows');
}

};
