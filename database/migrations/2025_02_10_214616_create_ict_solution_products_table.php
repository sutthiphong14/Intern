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
        Schema::create('ict_solution_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ict_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1); // จำนวนสินค้า

            // เชื่อม Foreign Key
            $table->foreign('ict_id')->references('ict_id')->on('ict_solution')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('ict_products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ict_solution_products');
    }
};
