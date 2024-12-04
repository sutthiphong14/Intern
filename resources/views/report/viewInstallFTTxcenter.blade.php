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
                    <h3 class="card-title">ตรวจแก้ FTTx ภายใน 24 ชม. : จ. บภน.2.1 (กส.)</h3>
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
                        <h3 class="card-title">ติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน เดือนนี้)</h3>
                        <div class="card-tools">
                            <a href="importdata" class="btn bg-light ">
                                <i class="d-flex justify-content-end "></i> Import
                            </a>
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
                                        <th rowspan="2" class="col-department">เดือน</th>
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


                                            <td>{{ $item->month }}</td>
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
                                            <td>{{ $item->installation_percentage_within_3_days }}</td>
                                        </tr>
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
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
    document.addEventListener('DOMContentLoaded', function () {
        // ดึงข้อมูลจาก Controller
        const labels = @json($labels); // ชื่อ section หรือ center
        const data = @json($data);     // เปอร์เซ็นต์การติดตั้ง

        // ตรวจสอบว่ามีข้อมูลเพียงพอสำหรับการสร้างกราฟ
        if (labels.length === 0 || data.length === 0) {
            console.warn('No data available for chart.');
            return;
        }

        // สร้าง Bar Chart
        const ctx = document.getElementById('barChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'เปอร์เซ็นต์การติดตั้งภายใน 3 วัน',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // สีพื้นหลังแท่งกราฟ
                    borderColor: 'rgba(54, 162, 235, 1)',       // สีเส้นขอบ
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true, // เริ่มจาก 0
                        max: 100 // กำหนดค่าบนสุดของแกน Y เป็น 100
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