// Migration: Create 'promotion_activity' Table
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promotion_activity', function (Blueprint $table) {
            $table->id('promotion_id');
            $table->string('promotion_name');
            $table->unsignedBigInteger('service_id'); // รหัสบริการ (Foreign Key)
            $table->timestamps();

            
            $table->foreign('service_id')->references('service_id')->on('serve_activity')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotion_activity');
    }
};