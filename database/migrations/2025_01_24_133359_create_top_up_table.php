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
        Schema::create('top_up', function (Blueprint $table) {
            $table->id('topUp_id');
            $table->string('phone')->nullable();
            $table->decimal('amount', 10, 2); // 10 หลัก และทศนิยม 2 ตำแหน่ง
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('province_id')->on('province_activity')->onDelete('cascade');
            $table->unsignedBigInteger('center_id');
            $table->foreign('center_id')->references('center_id')->on('servicecenter_activity')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_up');
    }
};
