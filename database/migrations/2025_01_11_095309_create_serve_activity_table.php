<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('serve_activity', function (Blueprint $table) {
            $table->id('service_id');  // รหัสบริการ (Primary Key)
            $table->string('service_name');  // ชื่อบริการ
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('serve_activity');
    }
};