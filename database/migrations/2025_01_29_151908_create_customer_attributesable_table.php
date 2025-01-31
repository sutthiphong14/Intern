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
        Schema::create('customer_attributes', function (Blueprint $table) {
            $table->id('entry_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('attribute_id');
            $table->text('value'); // เก็บค่าเป็น JSON
            $table->timestamps();
            $table->foreign('customer_id')->references('cus_id')->on('customers')->onDelete('cascade');
            $table->foreign('attribute_id')->references('attribute_id')->on('service_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_attributesables');
    }
};
