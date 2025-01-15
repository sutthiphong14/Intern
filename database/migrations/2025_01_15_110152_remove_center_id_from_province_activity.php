<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('province_activity', function (Blueprint $table) {
            $table->id('province_id');
            $table->string('province_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('province_activity');
    }
};