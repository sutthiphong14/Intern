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

            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">ตรวจแก้ FTTx ภายใน 3 วัน. : จังหวัด. @if ($section == 'รวม บภน.2.1 (กส.)')
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
                        <h3 class="card-title">Bar Chart - การติดตั้งภายใน 3 วันเปรียบเทียบแต่ละเดือน</h3>



                    </div>
                    <div class="card-body">
                        <canvas id="myChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <div class="card card-dark mt-3">

                <div class="card card-dark">
                    <div class="card-header">


                        <h3 class="card-title">ติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำปี {{$year}})</h3>
                        <div class="card-tools">
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
                                                                            <a href="{{ route('viewInstallFTTxcenter', ['section' => $item['sum_installation_center'], 'year' => $item['year'], 'month' => $item['month']]) }}"
                                                                                class="btn btn-warning">
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
                                                                        <td class="" style="background-color: {{
                                        $item['sum_installation_percentage_within_3_days'] > 85 ? 'rgba(61, 183, 71, 1)' :
                                        ($item['sum_installation_percentage_within_3_days'] > 83 ? 'rgb(142, 255, 56,1)' :
                                            ($item['sum_installation_percentage_within_3_days'] > 80 ? 'rgba(255, 206, 86, 1)' :
                                                ($item['sum_installation_percentage_within_3_days'] > 77 ? 'rgba(255, 165, 61, 1)' :
                                                    'rgba(255, 35, 82, 1)')))
                                                            }}; color: white;">
                                                                            {{ $item['sum_installation_percentage_within_3_days'] }}%
                                                                        </td>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    // ดึงข้อมูลจาก Controller
    const labels = @json($labels); // ชื่อเดือน
    const data = @json($data); // เปอร์เซ็นต์รวม

    // ตรวจสอบว่ามีข้อมูลเพียงพอสำหรับการสร้างกราฟ
    if (labels.length === 0 || data.length === 0) {
        console.warn('No data available for chart.');
    } else {
        // เงื่อนไขกำหนดสีพื้นหลังและเส้นขอบตามค่าเปอร์เซ็นต์
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

        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'เปอร์เซ็นต์การติดตั้งภายใน 3 วัน',
                    data: data,
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






@endsection