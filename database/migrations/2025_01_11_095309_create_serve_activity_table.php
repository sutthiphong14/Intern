<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // ใน migration เดิมของ serve_activity
        Schema::create('serve_activity', function (Blueprint $table) {
            $table->id('service_id');
            $table->string('service_name');
            $table->boolean('needs_installation')->default(false); // ต้องการฟิลด์การติดตั้งหรือไม่
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('serve_activity');
    }
};
