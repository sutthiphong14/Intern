<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallfttxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installfttx', function (Blueprint $table) {
            $table->bigIncrements('data_id'); // เปลี่ยนจาก id เป็น data_id และกำหนดให้เป็น primary key
            $table->string('region', 50);
            $table->string('department', 50);
            $table->string('section', 100);
            $table->string('installation_center', 100);
            $table->bigInteger('num_of_circuits');
            $table->decimal('total_preparation_time_days', 8, 2);
            $table->decimal('total_processing_time_days', 8, 2);
            $table->decimal('sdp_odp_deadline_days', 4, 2);
            $table->unsignedSmallInteger('wiring_time_days');
            $table->decimal('config_nms_days', 4, 2);
            $table->decimal('technician_appointment_and_scheduling_time_days', 4, 2);
            $table->unsignedSmallInteger('customer_waiting_time_days');
            $table->decimal('cable_pulling_and_ont_installation_time_days', 5, 2);
            $table->decimal('closing_work_time_days', 4, 2);
            $table->decimal('total_average_time_per_circuit_days', 4, 2);
            $table->unsignedSmallInteger('num_of_circuits_installed_within_3_days');
            $table->bigInteger('installation_percentage_within_3_days');
            $table->string('month');
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installfttx');
    }
};


