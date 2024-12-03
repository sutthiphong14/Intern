@extends('admins.index')
@section('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   
    <!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- AdminLTE -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
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
                    <div class="card-body">
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart"
                                    style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                            </div>
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
                                            <th rowspan="2" class="col-data">ดูข้อมูล</th>
                                            <th rowspan="2" class="col-data">ส่วนงาน</th>
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
                                        @foreach ($sumData as $item)
                                            <tr>

                                                <td>
                                                    <a href="{{ route('viewInstallFTTxcenter', ['section' => $item['sum_installation_center'], 'year' => $item['year'], 'month' => $item['month']]) }}" class="btn btn-warning">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                </td>


                                                <td>
                                                    @if ($section == 'รวม บภน.2.1 (กส.)')
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
                                        </td>
                                        <td>{{ $item->month }}</td>
                                        <td>{{ $item->sum_num_of_circuits }}</td>
                                        <td>{{ $item->sum_total_preparation_time_days }}</td>
                                        <td>{{ $item->sum_total_processing_time_days }}</td>
                                        <td>{{ $item->sum_sdp_odp_deadline_days }}</td>
                                        <td>{{ $item->sum_wiring_time_days }}</td>
                                        <td>{{ $item->sum_config_nms_days }}</td>
                                        <td>{{ $item->sum_technician_appointment_and_scheduling_time_days }}</td>
                                        <td>{{ $item->sum_customer_waiting_time_days }}</td>
                                        <td>{{ $item->sum_cable_pulling_and_ont_installation_time_days }}</td>
                                        <td>{{ $item->sum_closing_work_time_days }}</td>
                                        <td>{{ $item->sum_total_average_time_per_circuit_days }}</td>
                                        <td>{{ $item->sum_num_of_circuits_installed_within_3_days }}</td>
                                        <td>{{ $item->sum_installation_percentage_within_3_days }}</td>
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
    <script>
      $(function() {
    // ตรวจสอบว่ามีข้อมูลจาก Backend หรือไม่
    const sumData = @json($sumData);
    if (!sumData || sumData.length === 0) {
        console.warn('No data found for the chart');
        return;
    }

    // ดึงชื่อเดือนและร้อยละจากข้อมูล
    const labels = sumData.map(item => item.month || 'ไม่ระบุ');
    const data = sumData.map(item => parseFloat(item.sum_installation_percentage_within_3_days) || 0);

    // ตรวจสอบความถูกต้องของข้อมูล
    console.log('Labels:', labels);
    console.log('Data:', data);

    // การตั้งค่ากราฟ
    const barChartCanvas = $('#barChart').get(0).getContext('2d');
    const barChartData = {
        labels: labels,
        datasets: [{
            label: 'ร้อยละการติดตั้งภายใน 3 วัน',
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            data: data
        }]
    };

    // ตัวเลือกเพิ่มเติมสำหรับกราฟ
    const barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                min: 0,  // กำหนดให้แกน Y เริ่มที่ 0
                max: 100, // กำหนดให้แกน Y จบที่ 100
                ticks: {
                    stepSize: 20, // เพิ่มขึ้นทีละ 10 (0, 10, 20, 30, ..., 100)
                    callback: function(value) {
                        return value; // แสดงค่าตัวเลข 0, 10, 20, ...
                    }
                }
            }
        }
    };

    // วาดกราฟ
    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    });
});

    </script>
@endsection
