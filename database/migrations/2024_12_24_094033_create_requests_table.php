<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id_request'); // แก้ไขตรงนี้
            $table->string('user_request')->nullable();
            $table->string('name_request');
            $table->string('id_employee_request')->nullable();
            $table->string('department_request');
            $table->string('email_request')->unique();
            $table->string('password_request');
            $table->longText('description_request')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('center_id')->nullable();
            $table->timestamps();

            // ตั้งค่า Foreign Key
            $table->foreign('province_id')->references('province_id')->on('province_activity')->onDelete('set null');
            $table->foreign('center_id')->references('center_id')->on('servicecenter_activity')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};

