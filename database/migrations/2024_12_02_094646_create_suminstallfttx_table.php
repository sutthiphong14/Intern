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
        Schema::create('suminstallfttx', function (Blueprint $table) {
            $table->bigIncrements('sumdata_id'); // เปลี่ยนจาก id เป็น data_id และกำหนดให้เป็น primary key
            $table->string('sum_installation_center', 100);
            $table->bigInteger('sum_num_of_circuits');
            $table->decimal('sum_total_preparation_time_days', 8, 2);
            $table->decimal('sum_total_processing_time_days', 8, 2);
            $table->decimal('sum_sdp_odp_deadline_days', 4, 2);
            $table->unsignedSmallInteger('sum_wiring_time_days');
            $table->decimal('sum_config_nms_days', 4, 2);
            $table->decimal('sum_technician_appointment_and_scheduling_time_days', 4, 2);
            $table->unsignedSmallInteger('sum_customer_waiting_time_days');
            $table->decimal('sum_cable_pulling_and_ont_installation_time_days', 5, 2);
            $table->decimal('sum_closing_work_time_days', 4, 2);
            $table->decimal('sum_total_average_time_per_circuit_days', 4, 2);
            $table->unsignedSmallInteger('sum_num_of_circuits_installed_within_3_days');
            $table->bigInteger('sum_installation_percentage_within_3_days');
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
        Schema::dropIfExists('suminstallfttx');
    }
};
