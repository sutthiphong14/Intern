<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installfttx extends Model
{
    use HasFactory;

    protected $table = 'installfttx';

    protected $fillable = [
        'region',
        'department',
        'section',
        'installation_center',
        'num_of_circuits',
        'total_preparation_time_days',
        'total_processing_time_days',
        'sdp_odp_deadline_days',
        'wiring_time_days',
        'config_nms_days',
        'technician_appointment_and_scheduling_time_days',
        'customer_waiting_time_days',
        'cable_pulling_and_ont_installation_time_days',
        'closing_work_time_days',
        'total_average_time_per_circuit_days',
        'num_of_circuits_installed_within_3_days',
        'installation_percentage_within_3_days',
        'month',
        'year',
    ];
}


