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
        Schema::create('ict_services', function (Blueprint $table) {
            $table->id('ict_service_id');
            $table->string('service_name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('service_id')->on('serve_activity')->onDelete('cascade');
            $table->unsignedBigInteger('type_id'); 
            $table->timestamps();
            $table->foreign('type_id')->references('type_id')->on('type_activity')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ict_services');
    }
};