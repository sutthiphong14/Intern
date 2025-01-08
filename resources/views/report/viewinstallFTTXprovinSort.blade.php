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
            <a href="{{ route('home') }}" class="">
                หน้าแรก
            </a>
            /
            <a href="{{ route('viewInstallFTTx') }}" class="">
                ข้อมูลการติดตั้ง fttx ภายใน 3 วัน
            </a>
            /
            <a href="javascript:history.back()" class="">
                ศูนย์ ภน.
            </a>
            /
        </span> จังหวัด
        @if ($section == 'รวม บตป.1 (กส.)')
            กาฬสินธุ์
        @elseif ($section == 'รวม บตป.1 (ขก.)')
            ขอนแก่น
        @elseif ($section == 'รวม บตป.1 (นค.)')
            หนองคาย
        @elseif ($section == 'รวม บตป.1 (นพ.)')
            นครพนม
        @elseif ($section == 'รวม บตป.1 (นภ.)')
            หนองบัวลำภู
        @elseif ($section == 'รวม บตป.1 (บก.)')
            บึงกาฬ
        @elseif ($section == 'รวม บตป.1 (มค.)')
            มหาสารคาม
        @elseif ($section == 'รวม บตป.1 (มห.)')
            มุกดาหาร
        @elseif ($section == 'รวม บตป.1 (รอ.)')
            ร้อยเอ็ด
        @elseif ($section == 'รวม บตป.1 (ลย.)')
            เลย
        @elseif ($section == 'รวม บตป.1 (สน.)')
            สกลนคร
        @elseif ($section == 'รวม บตป.1 (อด.)')
            อุดรธานี
        @elseif ($section == 'รวม บตป.2 (ชภ.)')
            ชัยภูมิ
        @elseif ($section == 'รวม บตป.2 (นม.)')
            นครราชสีมา
        @elseif ($section == 'รวม บตป.2 (บร.)')
            บุรีรัมย์
        @elseif ($section == 'รวม บตป.2 (ยส.)')
            ยโสธร
        @elseif ($section == 'รวม บตป.2 (ศก.)')
            ศรีสะเกษ
        @elseif ($section == 'รวม บตป.2 (สร.)')
            สุรินทร์
        @elseif ($section == 'รวม บตป.2 (อจ.)')
            อำนาจเจริญ
        @elseif ($section == 'รวม บตป.2 (อบ.)')
            อุบลราชธานี
        @endif


    </h4>


    <div class='card'>
        <div class="d-flex justify-content-between align-items-center gap-2">
            <!-- หัวข้อ -->
            <h4 class="card-header text-warning">กราฟข้อมูลการติดตั้ง fttx ภายใน 3 วัน จังหวัด
                @if ($section == 'รวม บตป.1 (กส.)')
                    กาฬสินธุ์
                @elseif ($section == 'รวม บตป.1 (ขก.)')
                    ขอนแก่น
                @elseif ($section == 'รวม บตป.1 (นค.)')
                    หนองคาย
                @elseif ($section == 'รวม บตป.1 (นพ.)')
                    นครพนม
                @elseif ($section == 'รวม บตป.1 (นภ.)')
                    หนองบัวลำภู
                @elseif ($section == 'รวม บตป.1 (บก.)')
                    บึงกาฬ
                @elseif ($section == 'รวม บตป.1 (มค.)')
                    มหาสารคาม
                @elseif ($section == 'รวม บตป.1 (มห.)')
                    มุกดาหาร
                @elseif ($section == 'รวม บตป.1 (รอ.)')
                    ร้อยเอ็ด
                @elseif ($section == 'รวม บตป.1 (ลย.)')
                    เลย
                @elseif ($section == 'รวม บตป.1 (สน.)')
                    สกลนคร
                @elseif ($section == 'รวม บตป.1 (อด.)')
                    อุดรธานี
                @elseif ($section == 'รวม บตป.2 (ชภ.)')
                    ชัยภูมิ
                @elseif ($section == 'รวม บตป.2 (นม.)')
                    นครราชสีมา
                @elseif ($section == 'รวม บตป.2 (บร.)')
                    บุรีรัมย์
                @elseif ($section == 'รวม บตป.2 (ยส.)')
                    ยโสธร
                @elseif ($section == 'รวม บตป.2 (ศก.)')
                    ศรีสะเกษ
                @elseif ($section == 'รวม บตป.2 (สร.)')
                    สุรินทร์
                @elseif ($section == 'รวม บตป.2 (อจ.)')
                    อำนาจเจริญ
                @elseif ($section == 'รวม บตป.2 (อบ.)')
                    อุบลราชธานี
                @endif

                ปี {{ $year }}


            </h4>


            <div class="d-flex align-items-center gap-2">

                <!-- ฟอร์มเลือกปี -->


                <!-- ปุ่ม Import -->
                @if (Auth::user()->permission['manage_dashboard'] ?? false)
                    <a href="{{ route('importdata') }}" class="btn bg-yellow" style="width: 150px;">
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
            <canvas id="myChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>

        </div>
    </div>


    <hr class="my-3" />
    <div class="card ">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <!-- หัวข้อ -->
            <h4 class="card-header text-warning">ข้อมูลการติดตั้ง fttx ภายใน 3 วัน จังหวัด
                @if ($section == 'รวม บตป.1 (กส.)')
                    กาฬสินธุ์
                @elseif ($section == 'รวม บตป.1 (ขก.)')
                    ขอนแก่น
                @elseif ($section == 'รวม บตป.1 (นค.)')
                    หนองคาย
                @elseif ($section == 'รวม บตป.1 (นพ.)')
                    นครพนม
                @elseif ($section == 'รวม บตป.1 (นภ.)')
                    หนองบัวลำภู
                @elseif ($section == 'รวม บตป.1 (บก.)')
                    บึงกาฬ
                @elseif ($section == 'รวม บตป.1 (มค.)')
                    มหาสารคาม
                @elseif ($section == 'รวม บตป.1 (มห.)')
                    มุกดาหาร
                @elseif ($section == 'รวม บตป.1 (รอ.)')
                    ร้อยเอ็ด
                @elseif ($section == 'รวม บตป.1 (ลย.)')
                    เลย
                @elseif ($section == 'รวม บตป.1 (สน.)')
                    สกลนคร
                @elseif ($section == 'รวม บตป.1 (อด.)')
                    อุดรธานี
                @elseif ($section == 'รวม บตป.2 (ชภ.)')
                    ชัยภูมิ
                @elseif ($section == 'รวม บตป.2 (นม.)')
                    นครราชสีมา
                @elseif ($section == 'รวม บตป.2 (บร.)')
                    บุรีรัมย์
                @elseif ($section == 'รวม บตป.2 (ยส.)')
                    ยโสธร
                @elseif ($section == 'รวม บตป.2 (ศก.)')
                    ศรีสะเกษ
                @elseif ($section == 'รวม บตป.2 (สร.)')
                    สุรินทร์
                @elseif ($section == 'รวม บตป.2 (อจ.)')
                    อำนาจเจริญ
                @elseif ($section == 'รวม บตป.2 (อบ.)')
                    อุบลราชธานี
                @endif

                ปี {{ $year }}

            </h4>


            <div class="d-flex align-items-center gap-2">

                <!-- ฟอร์มเลือกปี -->


                <!-- ปุ่ม Import -->
                @if (Auth::user()->permission['manage_dashboard'] ?? false)
                    <a href="{{ route('importdata') }}" class="btn bg-yellow" style="width: 150px;">
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

                            <th rowspan="2" class="col-department">เดือน</th>
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


                    <tbody class="text-center align-middle">
                        @php
                            $centers = [
                                'รวม บตป.1 (กส.)' => 'กาฬสินธุ์',
                                'รวม บตป.1 (ขก.)' => 'ขอนแก่น',
                                'รวม บตป.1 (นค.)' => 'หนองคาย',
                                'รวม บตป.1 (นพ.)' => 'นครพนม',
                                'รวม บตป.1 (นภ.)' => 'หนองบัวลำภู',
                                'รวม บตป.1 (บก.)' => 'บึงกาฬ',
                                'รวม บตป.1 (มค.)' => 'มหาสารคาม',
                                'รวม บตป.1 (มห.)' => 'มุกดาหาร',
                                'รวม บตป.1 (รอ.)' => 'ร้อยเอ็ด',
                                'รวม บตป.1 (ลย.)' => 'เลย',
                                'รวม บตป.1 (สน.)' => 'สกลนคร',
                                'รวม บตป.1 (อด.)' => 'อุดรธานี',
                                'รวม บตป.2 (ชภ.)' => 'ชัยภูมิ',
                                'รวม บตป.2 (นม.)' => 'นครราชสีมา',
                                'รวม บตป.2 (บร.)' => 'บุรีรัมย์',
                                'รวม บตป.2 (ยส.)' => 'ยโสธร',
                                'รวม บตป.2 (ศก.)' => 'ศรีสะเกษ',
                                'รวม บตป.2 (สร.)' => 'สุรินทร์',
                                'รวม บตป.2 (อจ.)' => 'อำนาจเจริญ',
                                'รวม บตป.2 (อบ.)' => 'อุบลราชธานี',
                            ];
                            // กรองข้อมูลเพื่อแสดงเฉพาะค่าใน $centers
                            $filteredData = $sumData->filter(function ($item) use ($centers) {
                                return isset($centers[$item->sum_installation_center]);
                            });
                        @endphp

                        @foreach ($filteredData as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('viewInstallFTTxcenter', ['section' => $item['sum_installation_center'], 'year' => $item['year'], 'month' => $item['month']]) }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-search"></i>
                                    </a>
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
                                <td
                                    class="{{ $item['sum_installation_percentage_within_3_days'] > 80 ? 'bg-success' : ($item['sum_installation_percentage_within_3_days'] > 60 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $item->sum_installation_percentage_within_3_days }}%
                                </td>
                            </tr>
                        @endforeach




                        <!-- เพิ่มข้อมูลอื่น ๆ -->
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
                    <button type="submit" class="btn btn-success" id="confirmExport" disabled>Confirm Export</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            // กรองค่า null ออกจาก labels และ data
            const labels = @json($labels).filter(item => item !== null); // กรองค่า null ออกจาก labels
            const data = @json($data).filter(item => item !== null); // กรองค่า null ออกจาก data

            console.log(labels, data); // ตรวจสอบค่าผ่าน Console


            // ตรวจสอบว่ามีข้อมูลเพียงพอสำหรับการสร้างกราฟ
            if (labels.length === 0 || data.length === 0) {
                console.warn('No data available for chart.');
            } else {
                // เงื่อนไขกำหนดสีพื้นหลังและเส้นขอบตามค่าเปอร์เซ็นต์
                const backgroundColors = data.map(value =>
                    value > 85 ? 'rgba(68, 180, 40, 0.8)' :
                    value > 83 ? 'rgba(113, 221, 55, 0.8)' :
                    value > 80 ? 'rgba(255, 196, 0,0.8)' :
                    value > 77 ? 'rgba(253, 126, 20, 0.8)' :
                    'rgba(255, 62, 29, 0.8)'
                );

                const borderColors = data.map(value =>
                    value > 85 ? 'rgba(79, 193, 51, 1)' :
                    value > 83 ? 'rgba(113, 221, 55, 1)' :
                    value > 80 ? 'rgba(255, 196, 0,1)' :
                    value > 77 ? 'rgb(253, 126, 20, 1)' :
                    'rgba(255, 62, 29, 1)'
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
        });
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

<script>
    $(document).ready(function() {
           const year = @json($year ?? ''); // ใช้ปีปัจจุบันถ้าตัวแปรไม่มีค่า
           const confirmExportBtn = $('#confirmExport'); // ปุ่ม Confirm Export
           const month = $('#month'); // ปุ่ม Confirm Export

        fetchMonths(year); // ดึงข้อมูลเดือนเมื่อเปิด Modal

    $('#year').val(year); // ตั้งค่าปีเริ่มต้นเป็นปีที่ดึงมาจาก latestMonthData

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
                        
                            
                      
                        // เพิ่ม option ว่าไม่มีข้อมูล
                         // ปิดการใช้งานปุ่ม Confirm Export
                         $('#no-data-msg').remove();
                        confirmExportBtn.prop('disabled', true);
                       
                        monthSelect.after('<p id="no-data-msg" class="text-danger">ไม่มีข้อมูลในปีนี้</p>');
                        return;
                    }
                    $('#no-data-msg').remove();

                    // เปิดใช้งานปุ่ม Confirm Export
                    confirmExportBtn.prop('disabled', false);
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
@endsection
