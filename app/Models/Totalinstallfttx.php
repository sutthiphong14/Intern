<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Totalinstallfttx extends Model
{
    use HasFactory;
    // กำหนดชื่อตาราง
    protected $table = 'totalinstallfttx';

    // กำหนดคอลัมน์ที่สามารถบันทึกข้อมูลได้
    protected $fillable = [
        'total_installation_center',
        'total_num_of_circuits',
        'total_total_preparation_time_days',
        'total_total_processing_time_days',
        'total_sdp_odp_deadline_days',
        'total_wiring_time_days',
        'total_config_nms_days',
        'total_technician_appointment_and_scheduling_time_days',
        'total_customer_waiting_time_days',
        'total_cable_pulling_and_ont_installation_time_days',
        'total_closing_work_time_days',
        'total_total_average_time_per_circuit_days',
        'total_num_of_circuits_installed_within_3_days',
        'total_installation_percentage_within_3_days',
        'month',
        'year'
    ];
}
