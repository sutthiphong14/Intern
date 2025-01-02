@extends('admins.index')
@section('title')
    ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('header')
    ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('css')
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid mb-3">

            <div class="card card-dark mt-3">

                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">ตรวจแก้ FTTx ภายใน 3 วัน. : จังหวัด.
                            กาฬสินธุ์

                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>

                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="card-title">Bar Chart - การติดตั้งภายใน 3 วันเปรียบเทียบแต่ละเดือน</h3>
                        <canvas id="myChart"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>

                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">
                            @if ($latestMonthData->isEmpty())
                                อันดับการติดตั้ง FTTx ได้ภายใน 3 วัน ไม่มีข้อมูล
                            @else
                                อันดับการติดตั้ง FTTx ได้ภายใน 3 วัน (ประจำเดือน
                                {{ $latestMonthData->first()->month }})
                            @endif
                        </h3>

                        <div class="card-tools">
                            @if (Auth::user()->permission['manage_dashboard'] ?? false)
                                <a href="importdata" class="btn bg-light ">
                                    <i class="d-flex justify-content-end "></i> Import
                                </a>
                            @endif
                            <a href="{{ route('exportInstallFTTxcenter') }}"
                                class="btn bg-gradient-warning text-dark">Export</a>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="text-center ">
                                    <tr>
                                        <th rowspan="2" class="col-data">อันดับ</th>
                                        <th rowspan="2" class="col-department">ส่วนงาน</th>
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
                                @php

                                    // แปลงข้อมูลจาก Collection เป็น Array
                                    $sectionsArray = $latestMonthData->toArray();

                                    // ใช้ usort เพื่อจัดเรียงตาม sum_installation_center
                                    usort($sectionsArray, function ($a, $b) {
                                        return strcoll($a['sum_installation_center'], $b['sum_installation_center']);
                                    });

                                    // ใช้ array_slice() เพื่อจำกัดการแสดงแค่ 14 ตัวแรก
                                    $sectionsArray = array_slice($sectionsArray, 1, 14);
                                @endphp

                                <tbody class="text-center align-items-center">
                                    @php $i = 0; @endphp <!-- กำหนดตัวแปรเริ่มต้น -->
                                    @foreach ($sortedDataMax as $data)
                                        @php    $i++; @endphp <!-- เพิ่มค่าลำดับ -->

                                        <!-- ตรวจสอบว่าเป็น 5 อันดับแรกหรือไม่ -->
                                        <tr class="{{ $i == 1 ? 'bg-success' : '' }}">
                                            <td>{{ $i }}</td> <!-- แสดงลำดับ -->
                                            <td>
                                                @if ($data['sum_installation_center'] == 'รวม บภน.3.1 (ชภ.)')
                                                    ชัยภูมิ
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.1 (นม.)')
                                                    นครราชสีมา
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.1 (บร.)')
                                                    บุรีรัมย์
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.1 (สร.)')
                                                    สุรินทร์
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.2 (ยส.)')
                                                    ยโสธร
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.2 (ศก.)')
                                                    ศรีสะเกษ
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.2 (อจ.)')
                                                    อำนาจเจริญ
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.2 (อบ.)')
                                                    อุบลราชธานี
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.1 (กส.)')
                                                    กาฬสินธุ์
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.1 (ขก.)')
                                                    ขอนแก่น
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.1 (มค.)')
                                                    มหาสารคาม
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.1 (รอ.)')
                                                    ร้อยเอ็ด
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (นค.)')
                                                    หนองคาย
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (นพ.)')
                                                    นครพนม
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (นภ.)')
                                                    หนองบัวลำภู
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (บก.)')
                                                    บึงกาฬ
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (มห.)')
                                                    มุกดาหาร
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (ลย.)')
                                                    เลย
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (สน.)')
                                                    สกลนคร
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (อด.)')
                                                    อุดรธานี
                                                @elseif ($data['sum_installation_center'] == 'รวม 3')
                                                    ภน.2.2
                                                @elseif ($data['sum_installation_center'] == 'รวม 2')
                                                    ภน.2.1
                                                @endif

                                            </td>
                                            <td>{{ $data['sum_num_of_circuits'] }}</td>
                                            <td>{{ $data['sum_total_preparation_time_days'] }}</td>
                                            <td>{{ $data['sum_total_processing_time_days'] }}</td>
                                            <td>{{ $data['sum_sdp_odp_deadline_days'] }}</td>
                                            <td>{{ $data['sum_wiring_time_days'] }}</td>
                                            <td>{{ $data['sum_config_nms_days'] }}</td>
                                            <td>{{ $data['sum_technician_appointment_and_scheduling_time_days'] }}</td>
                                            <td>{{ $data['sum_customer_waiting_time_days'] }}</td>
                                            <td>{{ $data['sum_cable_pulling_and_ont_installation_time_days'] }}</td>
                                            <td>{{ $data['sum_closing_work_time_days'] }}</td>
                                            <td>{{ $data['sum_total_average_time_per_circuit_days'] }}</td>
                                            <td>{{ $data['sum_num_of_circuits_installed_within_3_days'] }}</td>
                                            <td>{{ $data['sum_installation_percentage_within_3_days'] }} %</td>
                                        </tr>
                                    @endforeach

                                    <!-- แสดงอันดับสุดท้าย (อันดับที่ต่ำสุด) -->
                                    @foreach ($sortedDataMin as $data)
                                        <tr class="bg-danger"> <!-- แสดงแถวอันดับสุดท้าย -->
                                            <td>12</td> <!-- อันดับสุดท้าย -->
                                            <td>
                                                @if ($data['sum_installation_center'] == 'รวม บภน.2.1 (กส.)')
                                                    กาฬสินธุ์
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.1 (ขก.)')
                                                    ขอนแก่น
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.1 (มค.)')
                                                    มหาสารคาม
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.1 (รอ.)')
                                                    ร้อยเอ็ด
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (นค.)')
                                                    หนองคาย
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (นพ.)')
                                                    นครพนม
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (นภ.)')
                                                    หนองบัวลำภู
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (บก.)')
                                                    บึงกาฬ
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (มห.)')
                                                    มุกดาหาร
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (ลย.)')
                                                    เลย
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (สน.)')
                                                    สกลนคร
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.2.2 (อด.)')
                                                    อุดรธานี
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.1 (ชภ.)')
                                                    ชัยภูมิิ
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.1 (นม.)')
                                                    นครราชสีมา
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.1 (บร.)')
                                                    บุรีรัมย์
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.1 (สร.)')
                                                    สุรินทร์
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.2 (ยส.)')
                                                    ยโสธร
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.2 (ศก.)')
                                                    ศรีสะเกษ
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.2 (อจ.)')
                                                    อำนาจเจริญ
                                                @elseif ($data['sum_installation_center'] == 'รวม บภน.3.2 (อบ.)')
                                                    อุบลราชธานี
                                                @elseif ($data['sum_installation_center'] == 'รวม 3')
                                                    ภน.2.2
                                                @elseif ($data['sum_installation_center'] == 'รวม 2')
                                                    ภน.2.1
                                                @endif
                                            </td>
                                            <td>{{ $data['sum_num_of_circuits'] }}</td>
                                            <td>{{ $data['sum_total_preparation_time_days'] }}</td>
                                            <td>{{ $data['sum_total_processing_time_days'] }}</td>
                                            <td>{{ $data['sum_sdp_odp_deadline_days'] }}</td>
                                            <td>{{ $data['sum_wiring_time_days'] }}</td>
                                            <td>{{ $data['sum_config_nms_days'] }}</td>
                                            <td>{{ $data['sum_technician_appointment_and_scheduling_time_days'] }}</td>
                                            <td>{{ $data['sum_customer_waiting_time_days'] }}</td>
                                            <td>{{ $data['sum_cable_pulling_and_ont_installation_time_days'] }}</td>
                                            <td>{{ $data['sum_closing_work_time_days'] }}</td>
                                            <td>{{ $data['sum_total_average_time_per_circuit_days'] }}</td>
                                            <td>{{ $data['sum_num_of_circuits_installed_within_3_days'] }}</td>
                                            <td>{{ $data['sum_installation_percentage_within_3_days'] }} %</td>
                                        </tr>
                                    @endforeach
                                </tbody>






                            </table>
                        </div>
                    </div>



                </div>

                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">
                            @if ($latestMonthData->isEmpty())
                                ติดตั้ง FTTx ได้ภายใน 3 วัน ไม่มีข้อมูล
                            @else
                                ติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน {{ $latestMonthData->first()->month }})
                            @endif
                        </h3>
                        <div class="card-tools d-flex ">
                            <form action="{{ route('viewInstallFTTxYear', ['year' => now()->year]) }}" method="GET"
                                class="d-inline" id="yearForm">
                                <input type="number" name="year" id="yearInput" placeholder="Enter year"
                                    value="{{ $latestMonthData->isEmpty() ? '' : $latestMonthData->first()->year }}"
                                    class="form-control d-inline " style="width: 200px;" required min="2000"
                                    max="9999">
                            </form>

                            @if (Auth::user()->permission['manage_dashboard'] ?? false)
                                <a href="{{ route('importdata') }}" class="btn bg-light mx-1 ">
                                    <i class="d-flex justify-content-end "></i> Import
                                </a>
                            @endif
                            <a href="{{ route('exportInstallFTTxcenter') }}"
                                class="btn bg-gradient-warning text-dark">Export</a>

                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="text-center ">
                                <tr>
                                    <th rowspan="2" class="col-data">ดูข้อมูล</th>
                                    <th rowspan="2" class="col-department">ส่วนงาน</th>
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
                            @php
                                // แปลงข้อมูลจาก Collection เป็น Array
                                $sectionsArray = $latestMonthData->toArray();
                            @endphp

                            <tbody class="text-center align-items-center">
                                @foreach ($sectionsArray as $section)
                                    @if ($section['sum_installation_center'] == 'รวม 3' || $section['sum_installation_center'] == 'รวม 2')
                                        <tr>
                                            <td>
                                                <a href="{{ route('viewInstallFTTxprovin', ['section' => $section['sum_installation_center'], 'year' => $section['year'], 'month' => $section['month']]) }}"
                                                    class="btn btn-warning">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </td>
                                            <td>
                                                @if ($section['sum_installation_center'] == 'รวม 3')
                                                    ภน.2.2
                                                @elseif ($section['sum_installation_center'] == 'รวม 2')
                                                    ภน.2.1
                                                @endif
                                            </td>
                                            <!-- ค่าอื่นๆ -->
                                            <td>{{ $section['sum_num_of_circuits'] }}</td>
                                            <td>{{ $section['sum_total_preparation_time_days'] }}</td>
                                            <td>{{ $section['sum_total_processing_time_days'] }}</td>
                                            <td>{{ $section['sum_sdp_odp_deadline_days'] }}</td>
                                            <td>{{ $section['sum_wiring_time_days'] }}</td>
                                            <td>{{ $section['sum_config_nms_days'] }}</td>
                                            <td>{{ $section['sum_technician_appointment_and_scheduling_time_days'] }}</td>
                                            <td>{{ $section['sum_customer_waiting_time_days'] }}</td>
                                            <td>{{ $section['sum_cable_pulling_and_ont_installation_time_days'] }}</td>
                                            <td>{{ $section['sum_closing_work_time_days'] }}</td>
                                            <td>{{ $section['sum_total_average_time_per_circuit_days'] }}</td>
                                            <td>{{ $section['sum_num_of_circuits_installed_within_3_days'] }}</td>

                                            <td class=""
                                                style="background-color: {{ $section['sum_installation_percentage_within_3_days'] > 85
                                                    ? 'rgba(61, 183, 71, 1)'
                                                    : ($section['sum_installation_percentage_within_3_days'] > 83
                                                        ? 'rgb(142, 255, 56,1)'
                                                        : ($section['sum_installation_percentage_within_3_days'] > 80
                                                            ? 'rgba(255, 206, 86, 1)'
                                                            : ($section['sum_installation_percentage_within_3_days'] > 77
                                                                ? 'rgba(255, 165, 61, 1)'
                                                                : 'rgba(255, 35, 82, 1)'))) }}; color: white;">
                                                {{ $section['sum_installation_percentage_within_3_days'] }}%
                                            </td>


                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>





                        </table>
                    </div>
                </div>




            </div>



        </div>
        </div>
    </section>
    </section>
@endsection

@section('script')
    <style>
        .text-warning {
            color: gold;
        }

        .text-dark {
            color: lightgray;
        }
    </style>


    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // กรองค่า null ออกจาก labels และ data
        const labels = @json($labels).filter(item => item !== null); // กรองค่า null ออกจาก labels
        const data1 = @json($data1); // กรองค่า null ออกจาก data
        const dataArray = Object.values(data1);
        console.log(labels, dataArray); // ตรวจสอบค่าผ่าน Console
    
        // ตรวจสอบว่ามีข้อมูลเพียงพอสำหรับการสร้างกราฟ
        console.log('Labels length:', labels.length);
        console.log('Data1 length:', dataArray.length);
    
        if (labels.length === 0 || dataArray.length === 0) {
            console.warn('No data available for chart.');
        } else {
            // เงื่อนไขกำหนดสีพื้นหลังและเส้นขอบตามค่าเปอร์เซ็นต์
            const backgroundColors = dataArray.map(value =>
                value > 85 ? 'rgba(61, 183, 71, 0.5)' :
                value > 83 ? 'rgba(180, 255, 122, 0.5)' :
                value > 80 ? 'rgba(255, 206, 86, 0.5)' :
                value > 77 ? 'rgba(253, 144, 19, 0.5)' :
                'rgba(255, 35, 82, 0.5)'
            );
    
            const borderColors = dataArray.map(value =>
                value > 85 ? 'rgba(61, 183, 71, 1)' :
                value > 83 ? 'rgba(180, 255, 122, 1)' :
                value > 80 ? 'rgba(255, 206, 86, 1)' :
                value > 77 ? 'rgb(253, 144, 19,1)' :
                'rgba(255, 35, 82, 1)'
            );
    
            const ctx = document.getElementById('myChart');
    
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'เปอร์เซ็นต์การติดตั้งภายใน 3 วัน',
                        data: dataArray, // ใช้ data แทน data1
                        backgroundColor: backgroundColors, // สีพื้นหลังแบบไดนามิก
                        borderColor: borderColors, // สีเส้นขอบแบบไดนามิก
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100 // ปรับให้แกน Y มีค่าสูงสุดเป็น 100
                        }
                    }
                }
            });
        }
    </script>
    



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('alert'))
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่พบข้อมูล',
                    text: '{{ session('alert') }}',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

    <script>
        // เมื่อค่าใน input เปลี่ยนให้ส่งฟอร์มทันที
        document.getElementById('yearInput').addEventListener('change', function() {
            document.getElementById('yearForm').submit();
        });
    </script>
@endsection
