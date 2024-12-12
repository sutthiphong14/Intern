@extends('admins.index')
@section('title')
ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('header')
ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
@endsection
@section('content')
<section class="content">
    <div class="container-fluid mb-3">

        <div class="card card-dark mt-3">

            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">อันดับการติดตั้ง FTTx ได้ภายใน 3 วัน (ประจำเดือน {{ $latestMonthData->first()->month }})</h3>


                    <div class="card-tools">
                        @if(Auth::user()->permission['manage_dashboard'] ?? false)
                            <a href="importdata" class="btn bg-light ">
                                <i class="d-flex justify-content-end "></i> Import
                            </a>
                        @endif
                        <button type="button" class="btn bg-gradient-warning">Export</button>
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
                                            @elseif ($data['sum_installation_center'] == 'รวม ภน.2.2')
                                                ภน.2.2
                                            @elseif ($data['sum_installation_center'] == 'รวม ภน.2.1')
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
                                            @elseif ($data['sum_installation_center'] == 'รวม ภน.2.2')
                                                ภน.2.2
                                            @elseif ($data['sum_installation_center'] == 'รวม ภน.2.1')
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
                            <div class="card-tools">
                                <form action="{{ route('viewInstallFTTxYear', ['year' => now()->year]) }}" method="GET" class="d-inline" id="yearForm">
                                    <input type="number" name="year" id="yearInput" placeholder="Enter year"
                                        value="{{ $latestMonthData->isEmpty() ? '' : $latestMonthData->first()->year }}"
                                        class="form-control d-inline " style="width: 200px;" required 
                                        min="2000" max="9999">
                                </form>
                    
                                @if (Auth::user()->permission['manage_dashboard'] ?? false)
                                    <a href="{{ route('importdata') }}" class="btn bg-light ">
                                        <i class="d-flex justify-content-end "></i> Import
                                    </a>
                                @endif
                                <button type="button" class="btn bg-gradient-warning">Export</button>
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

                                // ใช้ usort เพื่อจัดเรียงตาม sum_installation_center
                                usort($sectionsArray, function ($a, $b) {
                                    return strcoll($a['sum_installation_center'], $b['sum_installation_center']);
                                });

                                // ใช้ array_slice() เพื่อจำกัดการแสดงแค่ 14 ตัวแรก
                                $sectionsArray = array_slice($sectionsArray, 1, 14);
                            @endphp

                            <tbody class='text-center align-items-center'>
                                @foreach ($sectionsArray as $section)
                                    <tr>
                                        <td>
                                            <a href="{{ route('viewInstallFTTxprovin', ['section' => $section['sum_installation_center'], 'year' => $section['year']]) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-search"></i>
                                            </a>

                                        </td>
                                        <td>
                                            @if ($section['sum_installation_center'] == 'รวม บภน.2.1 (กส.)')
                                                กาฬสินธุ์
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.1 (ขก.)')
                                                ขอนแก่น
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.1 (มค.)')
                                                มหาสารคาม
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.1 (รอ.)')
                                                ร้อยเอ็ด
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.2 (นค.)')
                                                หนองคาย
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.2 (นพ.)')
                                                นครพนม
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.2 (นภ.)')
                                                หนองบัวลำภู
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.2 (บก.)')
                                                บึงกาฬ
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.2 (มห.)')
                                                มุกดาหาร
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.2 (ลย.)')
                                                เลย
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.2 (สน.)')
                                                สกลนคร
                                            @elseif ($section['sum_installation_center'] == 'รวม บภน.2.2 (อด.)')
                                                อุดรธานี
                                            @elseif ($section['sum_installation_center'] == 'รวม ภน.2.2')
                                                ภน.2.2
                                            @elseif ($section['sum_installation_center'] == 'รวม ภน.2.1')
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

                                        <td
                                            class="{{ $section['sum_installation_percentage_within_3_days'] > 80 ? 'bg-success' : ($section['sum_installation_percentage_within_3_days'] > 60 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $section['sum_installation_percentage_within_3_days'] }} %
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>





                        </table>
                    </div>
                </div>



            </div>
        </div>



    </div>
    </div>
</section>
</section>
@endsection

@section('script')
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<style>
    .text-warning {
        color: gold;
    }

    .text-dark {
        color: lightgray;
    }
</style>

<script>
    // ฟังก์ชันสำหรับแปลงค่าคะแนนเป็นดาว
    function renderStarsForAll() {
        const starContainers = document.querySelectorAll(".star-container");
        starContainers.forEach(container => {
            const rating = parseFloat(container.getAttribute("data-rating")); // รับค่าคะแนนจาก data-rating
            container.innerHTML = ""; // เคลียร์ค่าก่อนหน้า

                for (let i = 1; i <= 5; i++) {
                    const star = document.createElement("i");
                    if (i <= Math.floor(rating)) {
                        star.className = "fas fa-star text-warning"; // ดาวเต็ม
                    } else if (i === Math.ceil(rating) && rating % 1 !== 0) {
                        star.className = "fas fa-star-half-alt text-warning"; // ดาวครึ่ง
                    } else {
                        star.className = "fas fa-star text-dark"; // ดาวว่าง
                    }
                    container.appendChild(star);
                }
            });
        }

    // เรียกใช้งานเมื่อโหลดหน้าเสร็จ
    renderStarsForAll();
</script>

    <script>
        // ฟังก์ชันแสดงผลหลอดเปอร์เซ็นต์
        function updateProgressBars() {
            // ดึงองค์ประกอบทุก progress-container
            const containers = document.querySelectorAll('.progress-container');

            containers.forEach(container => {
                const value = parseInt(container.getAttribute('data-value')); // รับค่าจาก data-value
                const progressBar = container.querySelector('.progress-bar');

                // ตั้งค่าขนาดและข้อความ
                progressBar.style.width = value + '%';
                progressBar.textContent = value + '%';

                // กำหนดสีตามเงื่อนไข
                if (value < 50) {
                    progressBar.className = 'progress-bar red';
                } else if (value < 80) {
                    progressBar.className = 'progress-bar yellow';
                } else {
                    progressBar.className = 'progress-bar green';
                }
            });
        }

        // เรียกใช้งานฟังก์ชันเมื่อโหลดหน้าเสร็จ
        updateProgressBars();
    </script>

    <style>
        .progress-container {
            width: 100%;
            max-width: 100%;
            background-color: #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .progress-bar {
            height: 25px;
            width: 100;
            text-align: center;
            line-height: 30px;
            color: white;
            transition: width 0.3s ease;
        }

        .red {
            background-color: Crimson;
        }

        .yellow {
            background-color: gold;
            color: black;
        }

        .green {
            background-color: SeaGreen;
        }
    </style>

<script>
    // JavaScript ที่ใช้ในการกำหนดสีของหลอดตามเปอร์เซ็นต์
    const bars = document.querySelectorAll('.performance-bar');
    bars.forEach(bar => {
        const width = parseInt(bar.style.width);
        if (width >= 80) {
            bar.classList.add('green');
        } else if (width >= 50) {
            bar.classList.add('yellow');
        } else {
            bar.classList.add('red');
        }
    });
</script>
<script>
    $(function () {
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = {
            labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ต.ค.', 'พ.ย.',
                'ธ.ค.'
            ], // ป้ายกำกับเดือน
            datasets: [{
                label: 'รายได้จริง',
                backgroundColor: 'rgb(60, 179, 113)', // สีสำหรับรายได้
                borderColor: 'rgb(60, 179, 113)',
                data: [46.83, 47.6, 48.2, 48.25, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83,
                    46.83,
                ] // ข้อมูลรายได้
            },
            {
                label: 'เป้าหมาย',
                backgroundColor: 'rgba(210, 214, 222, 1)', // สีสำหรับเป้าหมาย
                borderColor: 'rgba(210, 214, 222, 1)',
                data: [52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34,
                    52.34,
                ] // ข้อมูลเป้าหมาย
            }
            ]
        };

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + tooltipItem.yLabel
                            .toLocaleString() + ' บาท';
                    }
                }
            },
            // scales: {
            //     yAxes: [{
            //         ticks: {
            //             beginAtZero: true, // เริ่มจาก 0
            //             callback: function (value) {
            //                 return value.toLocaleString() + ' บาท'; // แสดงตัวเลขแบบมีคอมม่า
            //             }
            //         },
            //         // scaleLabel: {
            //         //     display: true,
            //         //     labelString: 'จำนวนเงิน (บาท)' // ชื่อแกน Y
            //         // }
            //     }],
            //     xAxes: [{
            //         scaleLabel: {
            //             display: true,
            //             labelString: 'เดือน' // ชื่อแกน X
            //         }
            //     }]
            // }
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });
</script>


<<script>
    document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('status')) {
    Swal.fire({
    icon: 'success',
    title: 'Success',
    text: localStorage.getItem('status'),
    confirmButtonText: 'OK'
    }).then(() => {
    localStorage.removeItem('status');
    });
    } else {
    // ถ้าไม่มีใน localStorage ให้เช็ค session
    const status = '{{ session('status') }}';
    if (status) {
    localStorage.setItem('status', status);
    location.reload();
    }
    }
    });
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
