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
            $table->unsignedBigInteger('type_id'); // รหัสบริการ (Foreign Key)
            $table->timestamps();
            $table->foreign('type_id')->references('type_id')->on('type_activity')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('serve_activity');
    }
};