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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('name');
            $table->string('emp_id')->nullable();
            $table->string('department');
            $table->string('email')->unique();
            $table->string('password');
            $table->longText('profile_image')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('center_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        
            // ตั้งค่า Foreign Key
            $table->foreign('province_id')->references('province_id')->on('province_activity')->onDelete('set null');
            $table->foreign('center_id')->references('center_id')->on('servicecenter_activity')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
