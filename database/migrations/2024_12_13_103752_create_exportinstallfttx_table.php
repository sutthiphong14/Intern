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
        Schema::create('exportinstallfttx', function (Blueprint $table) {
            $table->bigIncrements('exportdata_id'); // เปลี่ยนจาก id เป็น data_id และกำหนดให้เป็น primary key
            $table->string('export_region', 50)->nullable(); // เพิ่ม nullable ที่คอลัมน์ export_region
            $table->string('export_department', 50)->nullable(); // เพิ่ม nullable ที่คอลัมน์ export_department
            $table->string('export_section', 100)->nullable(); // เพิ่ม nullable ที่คอลัมน์ export_section
            $table->string('export_installation_center', 100);
            $table->bigInteger('export_num_of_circuits');
            $table->decimal('export_total_preparation_time_days', 8, 2);
            $table->decimal('export_total_processing_time_days', 8, 2);
            $table->decimal('export_sdp_odp_deadline_days', 4, 2);
            $table->unsignedSmallInteger('export_wiring_time_days');
            $table->decimal('export_config_nms_days', 4, 2);
            $table->decimal('export_technician_appointment_and_scheduling_time_days', 4, 2);
            $table->unsignedSmallInteger('export_customer_waiting_time_days');
            $table->decimal('export_cable_pulling_and_ont_installation_time_days', 5, 2);
            $table->decimal('export_closing_work_time_days', 4, 2);
            $table->decimal('export_total_average_time_per_circuit_days', 4, 2);
            $table->unsignedSmallInteger('export_num_of_circuits_installed_within_3_days');
            $table->bigInteger('export_installation_percentage_within_3_days');
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
        Schema::dropIfExists('exportinstallfttx');
    }
};
