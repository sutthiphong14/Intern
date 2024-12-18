<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>






    <div class="card-body">
        <div class="table-responsive">
            <table id="example2" class="table table-bordered table-hover">
                <thead class="text-center ">
                    <tr>
                        <td colspan="9">
                            รายงานระยะเวลาเฉลี่ยในการติดตั้งอินเทอร์เน็ตความเร็วสูง ประจำเดือน {{ $month }} ปี
                            {{ $year }}
                        </td>

                    </tr>
                    <tr>
                        <th rowspan="2" class="col-department">ลำดับ</th>
                        <th rowspan="2" class="col-department">ภาค</th>
                        <th rowspan="2" class="col-department">ฝ่าย</th>
                        <th rowspan="2" class="col-department">ส่วน</th>
                        <th rowspan="2" class="col-department">ศูนย์(ติดตั้ง)</th>
                        <th rowspan="2" class="col-count">จำนวนวงจร</th>
                        <th rowspan="2" class="col-doc-time">ระยะเวลาเตรียมเอกสารรวม (วัน)</th>
                        <th rowspan="2" class="col-process-time">ระยะเวลาดำเนินการรวม (วัน)</th>
                        <th colspan="7">ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร</th>
                        <th rowspan="2" class="col-total-time">รวมระยะเวลาเฉลี่ยที่ใช้ต่อวงจร (วัน)
                        </th>
                        <th rowspan="2" class="col-install-count">จำนวนวงจรที่ติดตั้งภายใน 3 วัน
                        </th>
                        <th rowspan="2" class="col-install-percent">ร้อยละการติดตั้งภายใน 3 วัน
                        </th>
                    </tr>
                    <tr>
                        <th class="col-sdp">กำหนด SDP/ODP (วัน)</th>
                        <th class="col-cable">โยงสาย (วัน)</th>
                        <th class="col-config">Config NMS (วัน)</th>
                        <th class="col-schedule">นัดหมายและกำหนดช่าง (วัน)</th>
                        <th class="col-wait-customer">รอลูกค้า (วัน)</th>
                        <th class="col-install">ลากสายและติดตั้ง ONT (วัน)</th>
                        <th class="col-close-job">ปิดงาน (วัน)</th>
                    </tr>
                </thead>
                {{-- @php
                    // แปลงข้อมูลจาก Collection เป็น Array
                    $sectionsArray = $latestMonthData->toArray();

            // ใช้ usort เพื่อจัดเรียงตาม sum_installation_center
            usort($sectionsArray, function ($a, $b) {
                return strcoll($a['sum_installation_center'], $b['sum_installation_center']);
            });

            // ใช้ array_slice() เพื่อจำกัดการแสดงแค่ 14 ตัวแรก
            $sectionsArray = array_slice($sectionsArray, 1, 14);
        @endphp --}}

                <tbody class='text-center align-items-center'>
                    @php
                        $rowIndex = 1; // ตัวแปรลำดับเริ่มต้น
                    @endphp
                    @foreach ($data as $section)
                        <tr>
                            @if (strpos($section['export_installation_center'], 'รวม') !== false)
                                <td></td> <!-- เว้นช่องว่างในลำดับ -->
                            @else
                                <td>{{ $rowIndex++ }}</td>
                            @endif

                            <td>{{ $section['export_region'] }}</td>
                            <!-- ค่าอื่นๆ -->

                            <td>{{ $section['export_department'] }}</td>
                            <td>{{ $section['export_section'] }}</td>
                            <td>{{ $section['export_installation_center'] }}</td>
                            <td>{{ $section['export_num_of_circuits'] }}</td>
                            <td>{{ $section['export_total_preparation_time_days'] }}</td>
                            <td>{{ $section['export_total_processing_time_days'] }}</td>
                            <td>{{ $section['export_sdp_odp_deadline_days'] }}</td>
                            <td>{{ $section['export_wiring_time_days'] }}</td>
                            <td>{{ $section['export_config_nms_days'] }}</td>
                            <td>{{ $section['export_technician_appointment_and_scheduling_time_days'] }}</td>
                            <td>{{ $section['export_customer_waiting_time_days'] }}</td>
                            <td>{{ $section['export_cable_pulling_and_ont_installation_time_days'] }}</td>
                            <td>{{ $section['export_closing_work_time_days'] }}</td>
                            <td>{{ $section['export_total_average_time_per_circuit_days'] }}</td>
                            <td>{{ $section['export_num_of_circuits_installed_within_3_days'] }}</td>
                            <td>{{ $section['export_installation_percentage_within_3_days'] }}</td>


                        </tr>
                    @endforeach
                </tbody>





            </table>
        </div>
    </div>


</body>

</html>
