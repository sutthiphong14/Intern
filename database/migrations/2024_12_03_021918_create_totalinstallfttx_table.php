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
        Schema::create('totalinstallfttx', function (Blueprint $table) {
            $table->bigIncrements('totaldata_id'); // เปลี่ยนจาก id เป็น data_id และกำหนดให้เป็น primary key
            $table->string('total_installation_center', 100);
            $table->bigInteger('total_num_of_circuits');
            $table->decimal('total_total_preparation_time_days', 8, 2);
            $table->decimal('total_total_processing_time_days', 8, 2);
            $table->decimal('total_sdp_odp_deadline_days', 4, 2);
            $table->unsignedSmallInteger('total_wiring_time_days');
            $table->decimal('total_config_nms_days', 4, 2);
            $table->decimal('total_technician_appointment_and_scheduling_time_days', 4, 2);
            $table->unsignedSmallInteger('total_customer_waiting_time_days');
            $table->decimal('total_cable_pulling_and_ont_installation_time_days', 5, 2);
            $table->decimal('total_closing_work_time_days', 4, 2);
            $table->decimal('total_total_average_time_per_circuit_days', 4, 2);
            $table->bigInteger('total_num_of_circuits_installed_within_3_days');
            $table->bigInteger('total_installation_percentage_within_3_days');
            $table->string('month');
            $table->string('year');
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('totalinstallfttx');
    }
};
