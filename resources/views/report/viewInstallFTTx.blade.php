@extends('admins.index')
@section('title')
    ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('header')
    ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('custom/css/custom-style.css') }}">
@endsection
@section('content')



    <!-- navigate -->
    <h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">
            <a href="home" class="">
                หน้าแรก
            </a>
            /
        </span> ข้อมูลการติดตั้ง fttx ภายใน 3 วัน</h4>


    <div class='card'>
        <div class="d-flex justify-content-between align-items-center gap-2">
            <!-- หัวข้อ -->
            <h4 class="card-header text-warning">
                @php
                    $latestMonthData = $latestMonthData ?? collect(); // กำหนดค่าเริ่มต้นเป็น Collection ว่าง
                @endphp
                @if ($latestMonthData->isEmpty())
                    กกราฟแสดงข้อมูลการติดตั้ง FTTx ได้ภายใน 3 วัน ไม่มีข้อมูล
                @else
                    กราฟแสดงข้อมูลการติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน {{ $latestMonthData->first()->month }})
                @endif

            </h4>


            <div class="d-flex align-items-center gap-2">


                <!-- ฟอร์มเลือกปี -->
                <form action="{{ route('viewInstallFTTxYear', ['year' => now()->year]) }}" method="GET" class="d-inline"
                    id="yearForm">
                    <input type="number" name="year" id="yearInput" placeholder="Enter year"
                        value="{{ isset($message) ? now()->year : ($latestMonthData->isEmpty() ? '' : $latestMonthData->first()->year) }}"
                        class="form-control" style="width: 200px;" required min="2000" max="9999">
                </form>

                <!-- ปุ่ม Import -->
                @if (Auth::user()->permission['manage_dashboard'] ?? false)
                    <a href="{{ route('importdata') }}" class="btn bg-yellow">
                        <i class="fas fa-file-import"></i> Import
                    </a>
                @endif

                <!-- ฟอร์ม Export -->
                <button type="button" class="btn bg-dark" data-toggle="modal" data-target="#exportModal">
                    <i class="fas fa-file-export"></i> Export
                </button>

                <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                    <i class="fas fa-question-circle"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            <h3 id="noDataMessage" style=" text-align: center; "></h3>
            <canvas id="myChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
        </div>
    </div>


    <hr class="my-3" />
    <div class="card ">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <!-- หัวข้อ -->
            <h4 class="card-header text-warning">
                @if ($latestMonthData->isEmpty())
                    ข้อมูลการติดตั้ง FTTx ได้ภายใน 3 วัน ไม่มีข้อมูล
                @else
                    ข้อมูลการติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน {{ $latestMonthData->first()->month }})
                @endif
            </h4>


            <div class="d-flex align-items-center gap-2">

                <!-- ฟอร์มเลือกปี -->
                <form action="{{ route('viewInstallFTTxYear', ['year' => now()->year]) }}" method="GET" class="d-inline"
                    id="yearForm1">
                    <input type="number" name="year" id="yearInput1" placeholder="Enter year"
                        value="{{ isset($message) ? now()->year : ($latestMonthData->isEmpty() ? '' : $latestMonthData->first()->year) }}"
                        class="form-control" style="width: 200px;" required min="2000" max="9999">
                </form>
                <!-- ปุ่ม Import -->
                @if (Auth::user()->permission['manage_dashboard'] ?? false)
                    <a href="{{ route('importdata') }}" class="btn bg-yellow">
                        <i class="fas fa-file-import"></i> Import
                    </a>
                @endif

                <!-- ฟอร์ม Export -->
                <button type="button" class="btn bg-dark" data-toggle="modal" data-target="#exportModal">
                    <i class="fas fa-file-export"></i> Export
                </button>

                <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                    <i class="fas fa-question-circle"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                    <thead class="text-center ">
                        <tr class='bg-dark'>
                            <th rowspan="2" class="col-data ">ดูข้อมูล</th>
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
                        <tr class='bg-dark'>
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

                        // ใช้ array_slice() เพื่อจำกัดการแสดงแค่ 22 ตัวแรก
                        $sectionsArray = array_slice($sectionsArray, 0, 22);
                    @endphp

                    <tbody class="text-center align-items-center">
                        @if (count($sectionsArray) > 1)
                            @foreach ($sectionsArray as $section)
                                @if ($section['sum_installation_center'] == 'รวม ตป.1' || $section['sum_installation_center'] == 'รวม ตป.2')
                                    <tr>
                                        <td>
                                            <a href="{{ route('viewInstallFTTxprovin', ['section' => $section['sum_installation_center'], 'year' => $section['year'], 'month' => $section['month']]) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($section['sum_installation_center'] == 'รวม ตป.1')
                                                ตป.1
                                            @elseif ($section['sum_installation_center'] == 'รวม ตป.2')
                                                ตป.2
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
                                                ? 'rgba(68, 180, 40, 1)'
                                                : ($section['sum_installation_percentage_within_3_days'] > 83
                                                    ? 'rgb(113, 221, 55,1)'
                                                    : ($section['sum_installation_percentage_within_3_days'] > 80
                                                        ? 'rgba(255, 196, 0,1)'
                                                        : ($section['sum_installation_percentage_within_3_days'] > 77
                                                            ? 'rgba(253, 126, 20, 1)'
                                                            : 'rgba(255, 62, 29, 1)'))) }}; color: white;">
                                            {{ $section['sum_installation_percentage_within_3_days'] }}%
                                        </td>




                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="15">
                                    <h3>ไม่มีข้อมูลในปีนี้</h3>
                                </td>
                            </tr>
                        @endif
                    </tbody>





                </table>
            </div>
        </div>
    </div>




    <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScrollableTitle">คำอธิบายข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark">
                    <p>
                        รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                        หน้าหลัก รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                    </p>
                    <p>
                        หมายเหตุ : รายงานระยะเวลาเฉลี่ยในการติดตั้ง ตามศูนย์บริการติดตั้ง
                    </p>
                    <p>
                        • จำนวนวงจร : จะนับเฉพาะใบคำขอที่ทำการปิดงานเรียบร้อยบนระบบ FTTxSM เท่านั้น (ไม่รวมข้อมูลใบคำขอที
                        import มาจากสผ.และใบคำขอที่ยังไม่เคยปิดงานเรียบร้อย) ตามช่วงเวลาที่เลือก
                    </p>
                    <p>
                        • ระยะเวลาเตรียมข้อมูลรวม : ยอดรวมระยะเวลาที่ใช้ในเตรียมเอกสารของวงจรตามช่วงเวลาที่เลือก
                        โดยนับระยะเวลาตั้งแต่วันที่สร้างคำขอ - รับชำระเงิน
                    </p>
                    <p>
                        • ระยะเวลาดำเนินการรวม : ยอดรวมระยะเวลาที่ใช้ในการติดตั้งของวงจรตามช่วงเวลาที่เลือก
                        โดยนับระยะเวลาตั้งแต่รับชำระเงิน - ปิดงานเรียบร้อย ยกเว้น ช่วงรอลูกค้า
                    </p>
                    <p>
                        • ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร :

                    </p>
                    <p>
                        - กำหนดSDP/ODP :
                    </p>
                    <p>
                        >> กรณีส่งงานโยงสายถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงานโยงสาย หารด้วย จำนวนวงจร
                        (ช่องที่ 1)
                    </p>
                    <p>
                        >> กรณีส่งงานNMSถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงาน NMS หารด้วย จำนวนวงจร
                        (ช่องที่ 1)
                    </p>
                    <p>
                        - โยงสาย (ถ้าส่งงาน) : ยอดรวมจำนวนวัน นับจากวันที่ส่งงานโยงสายจนถึงส่งงาน NMS หารด้วย จำนวนวงจร
                        (ช่องที่ 1)
                    </p>
                    <p>
                        - การดำเนินการของ NMS, นัดหมายและกำหนดช่าง, ปิดงาน : ยอดรวมจำนวนวัน
                        นับจากวันที่รับงานมาดำเนินการจนถึงวันที่จ่ายงานให้งานถัดไป หารด้วย จำนวนวงจร (ช่องที่ 1)
                    </p>
                    <p>
                        - รอลูกค้า :
                    </p>
                    <p>
                        >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                        นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่ติดตั้ง หารด้วย จำนวนวงจร (ช่องที่ 1)
                    </p>
                    <p>
                        >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                        นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่นัดหมายลูกค้า หารด้วย จำนวนวงจร (ช่องที่ 1)
                    </p>
                    <p>
                        - ลากสายและติดตั้ง :
                    </p>
                    <p>
                        >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน นับจากวันที่ติดตั้งจนถึงวันที่ส่งงานปิดงาน
                        หารด้วย จำนวนวงจร (ช่องที่ 1)
                    </p>
                    <p>
                        >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                        นับจากวันที่วันนัดหมายลูกค้าจนถึงวันที่ส่งงานปิดงาน หารด้วย จำนวนวงจร (ช่องที่ 1)
                    </p>
                    <p>
                        • รวมระยะเวลาเฉลี่ยที่ใช้ต่อวงจร : ระยะเวลารวม (ช่องที่ 3) หารด้วย จำนวนวงจร (ช่องที่ 1)
                    </p>
                    <p>
                        • ร้อยละการติดตั้งภายใน 3 วัน : ร้อยละการปิดงานเรียบร้อยภายใน 3 วัน(รับชำระเงิน - ปิดงานเรียบร้อย
                        ยกเว้นช่วงรอลูกค้า) เมื่อเทียบกับ จำนวนวงจร (ช่องที่ 1)
                    </p>
                    <p>
                        • กรณีมีการติดตั้งวงจร แต่ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจรเท่ากับ 0.00 :
                        ใช้ระยะเวลาในการดำเนินการเป็นระดับวินาที จึงไม่สามารถแสดงตัวเลขได้
                    </p>
                    <p>
                        • รายงานเดือนตุลา ที่มีตัวเลขติดลบในบางพื้นที่ ทางระบบกำลังดำเนินการตรวจสอบและแก้ไขค่ะ
                        เนื่องจากมีการเลือกวันที่ติดตั้งและส่งงานไม่ถูกต้อง
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Export -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export ข้อมูล</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- ฟิลด์สำหรับกรอกข้อมูล -->
                    <form action="{{ route('export') }}" method="get" enctype="multipart/form-data"
                        class="form-group">
                        @csrf
                        <div class="form-group">
                            <label for="year">ปี</label>
                            <input type="number" id="year" name="year" min="2014" max="3000"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="month">เดือน</label>
                            <select id="month" name="month" class="form-control" required>
                                <option value="" disabled selected>เลือกเดือน</option>
                                <option value="มกราคม">มกราคม</option>
                                <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                                <option value="มีนาคม">มีนาคม</option>
                                <option value="เมษายน">เมษายน</option>
                                <option value="พฤษภาคม">พฤษภาคม</option>
                                <option value="มิถุนายน">มิถุนายน</option>
                                <option value="กรกฎาคม">กรกฎาคม</option>
                                <option value="สิงหาคม">สิงหาคม</option>
                                <option value="กันยายน">กันยายน</option>
                                <option value="ตุลาคม">ตุลาคม</option>
                                <option value="พฤศจิกายน">พฤศจิกายน</option>
                                <option value="ธันวาคม">ธันวาคม</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm Export</button>
                </div>
                </form>

            </div>
        </div>
    </div>
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
        const labels = @json($labels ?? []).filter(item => item !== null); // กรองค่า null ออกจาก labels
        const data1 = @json($data1 ?? []); // ถ้า data1 ไม่มีค่า ให้เป็น array ว่าง
        const dataArray = Object.values(data1);


        // ตรวจสอบว่ามีข้อมูลเพียงพอสำหรับการสร้างกราฟ
        console.log('Labels length:', labels.length);
        console.log('Data1 length:', dataArray.length);

        if (labels.length === 0 || dataArray.length === 0) {
            // แสดงข้อความในตารางหากไม่มีข้อมูล
            document.getElementById('noDataMessage').innerHTML = `
        
           
                    <div>ไม่มีข้อมูลในปีนี้</div>`;

        } else {
            // เงื่อนไขกำหนดสีพื้นหลังและเส้นขอบตามค่าเปอร์เซ็นต์
            const backgroundColors = dataArray.map(value =>
                value > 85 ? 'rgba(68, 180, 40, 0.7)' :
                value > 83 ? 'rgba(113, 221, 55, 0.7)' :
                value > 80 ? 'rgba(255, 196, 0,0.7)' :
                value > 77 ? 'rgba(253, 126, 20, 0.7)' :
                'rgb(255, 0, 0,0.7)'
            );

            const borderColors = dataArray.map(value =>
                value > 85 ? 'rgba(79, 193, 51, 1)' :
                value > 83 ? 'rgba(113, 221, 55, 1)' :
                value > 80 ? 'rgba(255, 196, 0,1)' :
                value > 77 ? 'rgb(253, 126, 20, 1)' :
                'rgb(255, 38, 0)'
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
        // เมื่อค่าใน input เปลี่ยนให้ส่งฟอร์มทันที
        document.getElementById('yearInput').addEventListener('change', function() {
            document.getElementById('yearForm').submit();
        });
        // เมื่อค่าใน input เปลี่ยนให้ส่งฟอร์มทันที
        document.getElementById('yearInput1').addEventListener('change', function() {
            document.getElementById('yearForm1').submit();
        });
        // เมื่อค่าใน input เปลี่ยนให้ส่งฟอร์มทันที
        document.getElementById('yearInput2').addEventListener('change', function() {
            document.getElementById('yearForm2').submit();
        });
    </script>



    <script>
        $(document).ready(function() {
            const latestYear = @json($latestYear); // ดึงปีที่เลือกจาก Collection
            fetchMonths(latestYear); // ดึงข้อมูลเดือนเมื่อเปิด Modal
    
    $('#year').val(latestYear); // ตั้งค่าปีเริ่มต้นเป็นปีที่ดึงมาจาก latestMonthData
            // กำหนดสไตล์ CSS สำหรับ SweetAlert
            $('<style>')
                .text(`
            .swal2-container {
                z-index: 2000 !important;
            }
            .modal {
                z-index: 1050;
            }
            .modal-backdrop.show {
                z-index: 1040;
            }
            .swal2-backdrop-show {
                z-index: 1999 !important;
            }
        `)
                .appendTo('head');

            function fetchMonths(year) {
                // ตรวจสอบค่าของ year ก่อน
                if (!year || year.length !== 4 || isNaN(year)) {
                    console.warn("Invalid year:", year);
                    return; // ไม่ทำงานถ้าค่า year ไม่ถูกต้อง
                }

                $.ajax({
                    url: "{{ route('api.existing.months') }}",
                    method: "GET",
                    data: {
                        year: year
                    },
                    success: function(response) {
                        const monthsWithData = response.map(item => item.month);
                        const monthSelect = $('#month');

                        // เคลียร์ตัวเลือกเดิม
                        monthSelect.empty();

                        if (monthsWithData.length === 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'ไม่มีข้อมูล',
                                text: `ไม่มีข้อมูลสำหรับปี ${year}`,
                                confirmButtonText: 'ตกลง',
                                customClass: {
                                    container: 'my-swal-container',
                                    popup: 'my-swal-popup'
                                },
                                backdrop: true,
                                allowOutsideClick: false,
                            });
                            // เพิ่ม option ว่าไม่มีข้อมูล
                            monthSelect.append(
                                '<option disabled>ไม่มีข้อมูลในปีนี้</option>');
                            return;
                        }

                        // กรองค่าซ้ำจาก monthsWithData โดยใช้ Set
                        const uniqueMonths = [...new Set(monthsWithData)];

                        // เพิ่ม months ที่มีข้อมูล
                        uniqueMonths.forEach(function(month) {
                            monthSelect.append(`<option value="${month}">${month}</option>`);
                        });
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถดึงข้อมูลได้ โปรดลองอีกครั้ง',
                            confirmButtonText: 'ตกลง',
                            customClass: {
                                container: 'my-swal-container',
                                popup: 'my-swal-popup'
                            },
                            backdrop: true
                        });
                    }
                });
            }

            // ดึงข้อมูลเมื่อ Modal เปิด
            $('#myModal').on('shown.bs.modal', function() {
                const selectedYear = $('#year').val();
           
            });

            // อัปเดตข้อมูลเมื่อป้อนหรือเปลี่ยนค่าปี
            $('#year').on('keydown', function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    const selectedYear = $(this).val();
                    if (selectedYear.length === 4 && !isNaN(selectedYear)) {
                        fetchMonths(selectedYear);
                    }
                }
            });

            $('#year').on('change', function() {
                const selectedYear = $(this).val();
                if (selectedYear.length === 4 && !isNaN(selectedYear)) {
                    fetchMonths(selectedYear);
                }
            });
            fetchMonths(selectedYear);
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
@endsection
