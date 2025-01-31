<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('image_events', function (Blueprint $table) {
        $table->id('image_id');  // Primary key
        $table->foreignId('event_id')->references('event_id')->on('events')->onDelete('cascade'); // อ้างอิง event_id
        $table->string('image_event'); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_events');
    }
};
