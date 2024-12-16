@extends('admins.index')
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

        <div class="col-md-12 mt-3">
            <!-- BAR CHART -->
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">ตรวจแก้ FTTx ภายใน 24 ชม. : จ. @if ($section == 'รวม บภน.2.1 (กส.)')
                                                        กาฬสินธุ์
                                                    @elseif ($section == 'รวม บภน.2.1 (ขก.)')
                                                        ขอนแก่น
                                                    @elseif ($section == 'รวม บภน.2.1 (มค.)')
                                                        มหาสารคาม
                                                    @elseif ($section == 'รวม บภน.2.1 (รอ.)')
                                                        ร้อยเอ็ด
                                                    @elseif ($section == 'รวม บภน.2.2 (นค.)')
                                                        หนองคาย
                                                    @elseif ($section == 'รวม บภน.2.2 (นพ.)')
                                                        นครพนม
                                                    @elseif ($section == 'รวม บภน.2.2 (นภ.)')
                                                        หนองบัวลำภู
                                                    @elseif ($section == 'รวม บภน.2.2 (บก.)')
                                                        บึงกาฬ
                                                    @elseif ($section == 'รวม บภน.2.2 (มห.)')
                                                        มุกดาหาร
                                                    @elseif ($section == 'รวม บภน.2.2 (ลย.)')
                                                        เลย
                                                    @elseif ($section == 'รวม บภน.2.2 (สน.)')
                                                        สกลนคร
                                                    @elseif ($section == 'รวม บภน.2.2 (อด.)')
                                                        อุดรธานี
                                                    @elseif ($section == 'รวม ภน.2.2')
                                                        ภน.2.2
                                                    @elseif ($section == 'รวม ภน.2.1')
                                                        ภน.2.1
                                                    @else
                                                        {{ $section }}
                                                        <!-- ถ้าค่าของ section ไม่ตรงกับที่กำหนด จะพิมพ์ค่าของ section -->
                                                    @endif
                                                </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bar Chart - การติดตั้งภายใน 3 วัน</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>


            <div class="card card-dark mt-3">

                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">ติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน {{$month}})</h3>
                        <div class="card-tools">
                        @if (Auth::user()->permission['manage_dashboard'] ?? false)
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
                                        <th rowspan="2" class="col-data">หน่วยงาน</th>
                                       
                                        <th rowspan="2" class="col-count">จำนวนวงจร</th>
                                        <th rowspan="2" class="col-doc-time">ระยะเวลาเตรียม
                                            เอกสารรวม(วัน)</th>
                                        <th rowspan="2" class="col-process-time">ระยะเวลาดำเนิน
                                            การรวม(วัน)</th>
                                        <th colspan="7">ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร</th>
                                        <th rowspan="2" class="col-total-time">รวมระยะเวลาเฉลี่ย
                                            ที่ใช้ต่อวงจร (วัน)
                                        </th>
                                        <th rowspan="2" class="col-install-count">จำนวนวงจรที่ติดตั้งภายใน 3 วัน
                                        </th>
                                        <th rowspan="2" class="col-install-percent">ร้อยละการติดตั้งภายใน 3 วัน</th>
                                    </tr>
                                    <tr>
                                        <th class="col-sdp">กำหนดSDP/ODP (วัน)</th>
                                        <th class="col-cable">โยงสาย (วัน)</th>
                                        <th class="col-config">Config NMS (วัน)</th>
                                        <th class="col-schedule">นัดหมายและกำหนดช่าง (วัน)</th>
                                        <th class="col-wait-customer">รอลูกค้า (วัน)</th>
                                        <th class="col-install">ลากสายและติดตั้ง ONT (วัน)</th>
                                        <th class="col-close-job">ปิดงาน (วัน)</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center align-middle">
                                    @foreach ($installData as $item)
                                        <tr>





                                            <td>{{ $item->installation_center }}</td>


                                         
                                            <td>{{ $item->num_of_circuits }}</td>
                                            <td>{{ $item->total_preparation_time_days }}</td>
                                            <td>{{ $item->total_processing_time_days }}</td>
                                            <td>{{ $item->sdp_odp_deadline_days }}</td>
                                            <td>{{ $item->wiring_time_days }}</td>
                                            <td>{{ $item->config_nms_days }}</td>
                                            <td>{{ $item->technician_appointment_and_scheduling_time_days }}</td>
                                            <td>{{ $item->customer_waiting_time_days }}</td>
                                            <td>{{ $item->cable_pulling_and_ont_installation_time_days }}</td>
                                            <td>{{ $item->closing_work_time_days }}</td>
                                            <td>{{ $item->total_average_time_per_circuit_days }}</td>
                                            <td>{{ $item->num_of_circuits_installed_within_3_days }}</td>
                                            <td class="" style="background-color: 
                                            {{$item['installation_percentage_within_3_days'] > 85 ? 'rgba(61, 183, 71, 1)' :
                                ($item['installation_percentage_within_3_days'] > 83 ? 'rgb(142, 255, 56,1)' :
                                    ($item['installation_percentage_within_3_days'] > 80 ? 'rgba(255, 206, 86, 1)' :
                                        ($item['installation_percentage_within_3_days'] > 77 ? 'rgba(255, 165, 61, 1)' :
                                            'rgba(255, 35, 82, 1)')))
                            }}; color: white;">
                                                        {{ $item['installation_percentage_within_3_days'] }}%
                                                    </td>
                                    @endforeach



                                    <!-- เพิ่มข้อมูลอื่น ๆ -->
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

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ดึงข้อมูลจาก Controller
        const labels = @json($labels); // ชื่อเดือน
        const data = @json($data); // เปอร์เซ็นต์รวม

        // ตรวจสอบว่ามีข้อมูลเพียงพอสำหรับการสร้างกราฟ
        if (labels.length === 0 || data.length === 0) {
            console.warn('No data available for chart.');
            return;
        }

        // กำหนดสีของแท่งกราฟตามเงื่อนไข
        const backgroundColors = data.map(value =>
            value > 85 ? 'rgba(61, 183, 71, 0.5)' :
                value > 83 ? 'rgba(180, 255, 122, 0.5)' :
                    value > 80 ? 'rgba(255, 206, 86, 0.5)' :
                        value > 77 ? 'rgba(255, 165, 61, 0.5)' :
                            'rgba(255, 35, 82, 0.5)'
        );
        const borderColors = data.map(value =>
            value > 85 ? 'rgba(61, 183, 71, 1)' :
                value > 83 ? 'rgba(180, 255, 122, 1)' :
                    value > 80 ? 'rgba(255, 206, 86, 1)' :
                        value > 77 ? 'rgba(255, 165, 61, 1)' :
                            'rgba(255, 35, 82, 1)'
        );

        // สร้าง Bar Chart
        const ctx = document.getElementById('barChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'เปอร์เซ็นต์การติดตั้งภายใน 3 วัน',
                    data: data,
                    backgroundColor: backgroundColors, // ใช้สีที่ตั้งตามเงื่อนไข
                    borderColor: borderColors, // ใช้สีเส้นขอบที่ตั้งตามเงื่อนไข
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true, // เริ่มจาก 0
                        min: 0, // กำหนดค่าต่ำสุดของแกน Y เป็น 0
                        max: 100, // กำหนดค่าบนสุดของแกน Y เป็น 100
                        suggestedMax: 100, // แนะนำค่าบนสุดของแกน Y เป็น 100
                        ticks: {
                            stepSize: 10, // กำหนดให้ค่าบนแกน Y เพิ่มขึ้นทีละ 10
                            callback: function(value) {
                                // จัดการแสดงค่าบนแกน Y ให้แสดงตั้งแต่ 0 ถึง 100
                                return value % 10 === 0 ? value : ''; // แสดงเฉพาะ 0, 10, 20, ...
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    });
</script>

@endsection