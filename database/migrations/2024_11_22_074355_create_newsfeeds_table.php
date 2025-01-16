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
        Schema::create('newsfeeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('categories');
            $table->string('content_type')->default('file'); // เพิ่มคอลัมน์ content_type
            $table->string('link')->nullable(); // เพิ่มคอลัมน์ link
            $table->string('youtube')->nullable(); // เพิ่มคอลัมน์ youtube
            $table->string('file')->nullable(); // เปลี่ยนให้ file nullable
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsfeeds');
    }
};
