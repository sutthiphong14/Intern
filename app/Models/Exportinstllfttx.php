<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exportinstllfttx extends Model
{
    use HasFactory;
    protected $table = 'exportinstallfttx';

    protected $fillable = [
        'export_region',
        'export_department',
        'export_section',
        'export_installation_center',
        'export_num_of_circuits',
        'export_total_preparation_time_days',
        'export_total_processing_time_days',
        'export_sdp_odp_deadline_days',
        'export_wiring_time_days',
        'export_config_nms_days',
        'export_technician_appointment_and_scheduling_time_days',
        'export_customer_waiting_time_days',
        'export_cable_pulling_and_ont_installation_time_days',
        'export_closing_work_time_days',
        'export_total_average_time_per_circuit_days',
        'export_num_of_circuits_installed_within_3_days',
        'export_installation_percentage_within_3_days',
        'month',
        'year',
    ];
}
