<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumInstallfttx extends Model
{
    use HasFactory;

    protected $table = 'suminstallfttx';

    protected $fillable = [
        'sum_installation_center',
        'sum_num_of_circuits',
        'sum_total_preparation_time_days',
        'sum_total_processing_time_days',
        'sum_sdp_odp_deadline_days',
        'sum_wiring_time_days',
        'sum_config_nms_days',
        'sum_technician_appointment_and_scheduling_time_days',
        'sum_customer_waiting_time_days',
        'sum_cable_pulling_and_ont_installation_time_days',
        'sum_closing_work_time_days',
        'sum_total_average_time_per_circuit_days',
        'sum_num_of_circuits_installed_within_3_days',
        'sum_installation_percentage_within_3_days',
        'month',
        'year'

    ];
}
