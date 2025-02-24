<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id('id_request');
            $table->string('user_request')->nullable();
            $table->string('name_request');
            $table->string('id_employee_request')->nullable();
            $table->string('department_request');
            $table->string('email_request')->unique();
            $table->string('password_request');
            $table->longText('description_request')->nullable();
            $table->unsignedBigInteger('province_id_request')->nullable();
            $table->unsignedBigInteger('center_id_request')->nullable();
            $table->timestamps();

            // ตั้งค่า Foreign Key
            $table->foreign('province_id_request')->references('province_id')->on('province_activity')->onDelete('set null');
            $table->foreign('center_id_request')->references('center_id')->on('servicecenter_activity')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
