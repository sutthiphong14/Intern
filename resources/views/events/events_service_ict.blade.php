@extends('admins.index')
@section('css')
    <style>
        /* กำหนดความสูงของ modal ให้เล็กลง */
        #ProductModal .modal-dialog {
            max-width: 400px;
            /* ปรับความกว้างของ modal */
            height: auto;
            /* ความสูงปรับตามเนื้อหา */
        }

        #ProductModal .modal-content {
            height: auto;
            /* ความสูงของ content ปรับตามเนื้อหาภายใน */
        }
    </style>
@endsection

@section('content')
    <h4 class="fw-bold py-2 mb-3">
        <span class="text-muted fw-light">
            <a href="{{ route('home') }}" class="">หน้าแรก</a> /
            <a href="{{ route('type_list') }}" class="">ข้อมูลกิจกรรม</a> /
            <a href="javascript:history.back()" class="">กิจกรรม {{ $types->type_name }}</a> /
        </span>
        ICT solution
        ส่วนงาน
        @if ($province_id == 1)
            ตป.1
        @else
            ตป.2
        @endif
    </h4>

    <div class="content-wrapper mb-5">

        <!-- Card for ICT solution chart -->
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-chart-line"></i> ICT solution</h3>
                    <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse" data-bs-target="#chart2">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="card-body collapse show" id="chart2">
                    <canvas id="myChart2"
                        style="min-height: 300px; height: 290px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Table for ICT Solution -->
        <div class="card mt-4">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">สรุปผลการดำเนินงานกิจกรรมบริการ ICT Solution @if ($province_id == 1)
                        ตป.1
                    @else
                        ตป.2
                    @endif
                </h3>
                <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                    <i class="fas fa-question-circle"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-dark text-center">
                                <th rowspan="4">ดูข้อมูล</th>
                                <th rowspan="4">จังหวัด</th>
                                <th colspan="2">Ict Solution</th>
                            </tr>
                            <tr class="bg-dark text-center">
                                <!-- You can add additional rows here if needed -->
                            </tr>
                            <tr class="bg-dark text-center">
                                <th rowspan="2">จำนวน (ราย)</th>
                                <th rowspan="2">รายได้</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($provinces as $province)
                                {{-- Grouping Provinces --}}
                                @if ($province->province_id <= 12)
                                    <tr>
                                        <td>
                                            <a href="{{ route('event_center_ict', ['province_id' => $province->province_id, 'type_id' => $types->type_id]) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                        <td>{{ $province->province_name }}</td>
                                        <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                                    </tr>
                                @endif

                                {{-- Aggregating total for Province Group --}}
                                @if ($province->province_id == 12)
                                    <tr class="bg-dark">
                                        <td colspan="2">รวม ตป.1</td>
                                        <td>{{ $IctCount }}</td>
                                        <td>{{ $IctIncome }}</td>
                                    </tr>
                                @endif

                                @if ($province->province_id > 12)
                                    <tr>
                                        <td>
                                            <a href="{{ route('event_center_ict', ['province_id' => $province->province_id, 'type_id' => $types->type_id]) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                        <td>{{ $province->province_name }}</td>
                                        <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                                    </tr>
                                @endif
                            @endforeach

                            {{-- Aggregating total for Province Group > 33 --}}
                            @if ($province->province_id > 12)
                                <tr class="bg-dark">
                                    <td colspan="2">รวม ตป.2</td>
                                    <td>{{ $IctCountOver33 }}</td>
                                    <td>{{ $IctIncomeOver33 }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>



    <script>
        var provinceNames = [];
        var ictCount = [];
        var ictIncome = [];

        // ข้อมูลจาก PHP
        @foreach ($provinces as $province)
            @if ($province->province_id <= 12)
                provinceNames.push("{{ $province->province_name }}");
                ictCount.push({{ $Ict_count[$province->province_id] ?? 0 }});
                ictIncome.push({{ $Ict_income[$province->province_id] ?? 0 }});
            @else
                provinceNames.push("{{ $province->province_name }}");
                ictCount.push({{ $Ict_count[$province->province_id] ?? 0 }});
                ictIncome.push({{ $Ict_income[$province->province_id] ?? 0 }});
            @endif
        @endforeach

        // ✅ โหลด Plugin ก่อนใช้
        Chart.register(ChartDataLabels);

        // ✅ สร้างกราฟที่ 2
        var ctx2 = document.getElementById('myChart2').getContext('2d');

        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: provinceNames, // ป้ายชื่อที่แสดงในกราฟ
                datasets: [{
                    label: 'รายได้',
                    backgroundColor: 'rgba(167, 85, 33, 0.8)', // สีเหลือง
                    borderColor: 'rgba(167, 85, 33, 1)',
                    borderWidth: 1,
                    data: ictIncome, // แสดงรายได้
                    stack: 'stack2' // stack อยู่ในกลุ่ม 'stack2'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                maxBarThickness: 90,
                scales: {
                    x: {
                        stacked: true, // stack ข้อมูลให้แสดงในแท่งเดียว
                        maxBarThickness: 20 // กำหนดขนาดแท่ง
                    },
                    y: {
                        beginAtZero: true, // เริ่มจาก 0 ที่แกน Y
                        stacked: true, // stack ข้อมูล
                        ticks: {
                            stepSize: 1000,
                            callback: function(value) {
                                return value.toFixed(2); // แสดงค่าทศนิยม 2 ตำแหน่ง
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top' // ตำแหน่ง legend
                    },
                    tooltip: {
                        enabled: true, // เปิด tooltip
                        callbacks: {
                            label: function(tooltipItem) {
                                // ดึงค่า ictCount และ ictIncome ตาม index ของ tooltip
                                var ictCountValue = ictCount[tooltipItem.dataIndex];
                                var ictIncomeValue = ictIncome[tooltipItem.dataIndex];

                                // แสดงข้อมูลใน tooltip
                                return [
                                    'จำนวน : ' + ictCountValue + ' ราย',
                                    'รายได้ : ' + ictIncomeValue.toLocaleString() + ' บาท'
                                ];
                            }
                        }
                    },
                    datalabels: { // ✅ เพิ่มตัวเลขในแท่งกราฟ
                        anchor: 'center', // ✅ วางเลขกลางแท่ง
                        align: 'center', // ✅ จัดให้ตรงกลางแท่ง
                        formatter: function(value) {
                            return value.toLocaleString(); // ✅ ใส่ comma ให้ตัวเลข
                        },
                        color: '#fff', // ✅ สีขาว (ถ้าแท่งสีอ่อน ให้ใช้ '#000')
                        font: {
                            weight: 'bold',
                            size: 14
                        }
                    }
                }
            },
            plugins: [ChartDataLabels] // ✅ เปิดใช้งาน Plugin
        });
    </script>
@endsection
