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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('cus_id');
            $table->string('cus_fullname');
            $table->string('id_card', 13);
            $table->string('cus_photo')->nullable();
            $table->text('cus_address');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('type_id')->on('type_activity')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('service_id')->on('serve_activity')->onDelete('cascade');
            $table->unsignedBigInteger('promotion_id');
            $table->foreign('promotion_id')->references('promotion_id')->on('promotion_activity')->onDelete('cascade');
            $table->unsignedBigInteger('speed_id');
            $table->foreign('speed_id')->references('speed_id')->on('speed_activity')->onDelete('cascade');
            $table->unsignedBigInteger('price_id');
            $table->foreign('price_id')->references('price_id')->on('price_activity')->onDelete('cascade');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('province_id')->on('province_activity')->onDelete('cascade');
            $table->unsignedBigInteger('center_id')->nullable();
            $table->foreign('center_id')->references('center_id')->on('servicecenter_activity')->onDelete('cascade');
            $table->text('other')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

