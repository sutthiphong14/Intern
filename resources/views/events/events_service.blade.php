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
    <h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">
            <a href="{{ route('home') }}" class="">
                หน้าแรก
            </a>
            /
            <a href="{{ route('type_list') }}" class="">
                ข้อมูลกิจกรรม
            </a>
            /
            <a href="javascript:history.back()" class="">
                กิจกรรม {{ $types->type_name }}
            </a>
            /
        </span> ศูนย์ @if ($province_id == 1)
            ตป.1
        @else
            ตป.2
        @endif
    </h4>

    <div class="content-wrapper mb-5">

        <div class="card mb-3">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">สรุปผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }}
                    @if ($province_id == 1)
                        ตป.1
                    @else
                        ตป.2
                    @endif
                </h3>
                <div class="d-flex align-items-center gap-2">
                    <div class="form-group me-4">

                    </div>
                </div>

            </div>
        </div>




        <div class="row">
            <!-- Card แรก -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-wifi"></i> Fttxbroadband</h3>
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse" data-bs-target="#chart1">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="card-body collapse show" id="chart1">
                        <canvas id="myChart"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>


            <!-- Card ที่สอง -->
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

            <!-- Card ที่สาม -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-sim-card"></i> SIM My</h3>
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse" data-bs-target="#chart3">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="card-body collapse show" id="chart3">
                        <canvas id="myChart3"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Card ที่สี่ -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><i class="fas fa-money-check-alt"></i> เติมเงินรายปี</h3>
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse" data-bs-target="#chart4">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="card-body collapse show" id="chart4">
                        <canvas id="myChart4"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="card mt-4">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">สรุปผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }}</h3>
                <div class="d-flex align-items-center gap-2">

                    <div class="d-flex align-items-center gap-2">
                        <div class="form-group me-4">

                        </div>

                        <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                            data-bs-target="#modalScrollable">
                            <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body ">
                <div class="table-responsive ">

                    <table class="table table-bordered ">
                        <thead>
                            <tr class="bg-dark text-center align-center">
                                <th rowspan="4">ดูข้อมูล</th>
                                <th rowspan="4">จังหวัด</th>
                                <th colspan="5">FTTX</th>
                                <th colspan="4">SIM my</th>
                                <th colspan="2">Ict Solution</th>

                            </tr>
                            <tr class="bg-dark text-center">

                                <th rowspan="4">new</th>
                                <th rowspan="4">ติดตั้งเอง</th>
                                <th rowspan="4">จ้างผู้รับเหมา</th>
                                <th rowspan="4">ปรับโปรโมชั่น</th>
                                <th rowspan="4">ลูกค้าย้ายค่าย</th>

                            </tr>
                            <tr class="bg-dark text-center">
                                <th rowspan="2">ลูกค้าใหม่</th>
                                <th rowspan="2">ลูกค้า (ย้ายค่าย)</th>
                                <th colspan="2">เติมเงินรายปี</th>
                                <th rowspan="2">จำนวน
                                    (ราย)</th>
                                <th rowspan="2">รายได้</th>

                            </tr>
                            <tr class="bg-dark text-center ">
                                <th>จำนวน
                                    (ราย)</th>
                                <th>ยอดเงิน</th>
                            </tr>

                        </thead>
                        <tbody class="text-center">
                            @foreach ($provinces as $province)
                                {{-- Province ID <= 33 --}} @if ($province->province_id <= 12)
                                    <tr>
                                        <td>
                                            <a href="{{ route('event_center', ['province_id' => $province->province_id, 'type_id' => $types->type_id]) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                        <td>{{ $province->province_name }}</td>
                                        <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $adjust12[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $move12[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                                    </tr>
                                @endif
                                {{-- แสดงผลรวมตรงกลางเมื่อเปลี่ยนกลุ่ม --}}
                                @if ($province->province_id == 12)
                                    <tr class="bg-dark">
                                        <td colspan="2">รวม ตป.1</td>
                                        <td>{{ $sumFttxNew }}</td>
                                        <td>{{ $sumSelfInstall }}</td>
                                        <td>{{ $sumHireInstall }}</td>
                                        <td>{{ $sumAdjust }}</td>
                                        <td>{{ $sumMovefttx }}</td>


                                        <td>{{ $sumNew }}</td>
                                        <td>{{ $sumMove }}</td>
                                        <td>{{ $sumCount }}</td>
                                        <td>{{ $sumPrice }}</td>
                                        <td>{{ $IctCount }}</td>
                                        <td>{{ $IctIncome }}</td>
                                    </tr>
                                @endif
                                {{-- Province ID > 33 --}}
                                @if ($province->province_id > 12)
                                    <tr>
                                        <td>
                                            <a href="{{ route('event_center', ['province_id' => $province->province_id, 'type_id' => $types->type_id]) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </td>
                                        <td>{{ $province->province_name }}</td>
                                        <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $adjustover12[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $moveover12[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                                        <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            @if ($province->province_id > 12)
                                {{-- แสดงผลรวมสำหรับ province_id > 33 --}}
                                <tr class="bg-dark">
                                    <td colspan="2">รวม ตป.2</td>
                                    <td>{{ $sumFttxNewOver33 }}</td>
                                    <td>{{ $sumSelfInstallOver33 }}</td>
                                    <td>{{ $sumHireInstallOver33 }}</td>
                                    <td>{{ $sumAdjustOver33 }}</td>
                                    <td>{{ $sumMovefttxOver33 }}</td>
                                    <td>{{ $sumNewOver33 }}</td>
                                    <td>{{ $sumMoveOver33 }}</td>
                                    <td>{{ $sumCountOver33 }}</td>
                                    <td>{{ $sumPriceOver33 }}</td>
                                    <td>{{ $IctCountOver33 }}</td>
                                    <td>{{ $IctIncomeOver33 }}</td>

                                </tr>
                            @endif


                        </tbody>



                    </table>
                </div>

            </div>
        </div>
    @endsection

    @section('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

        <script>
            // ดึงข้อมูลเฉพาะ province_id <= 12
            var provinceNames = [];
            var fttxNewData = [];
            var selfInstallData = [];
            var hireInstallData = [];
            var adJust = [];
            var sumMovefttx = [];

            @foreach ($provinces as $province)
                @if ($province->province_id <= 12)
                    provinceNames.push("{{ $province->province_name }}");
                    fttxNewData.push({{ $fttxNew[$province->province_id] ?? 0 }});
                    selfInstallData.push({{ $selfInstall[$province->province_id] ?? 0 }});
                    hireInstallData.push({{ $HireInstall[$province->province_id] ?? 0 }});
                    adJust.push({{ $adjust12[$province->province_id] ?? 0 }});
                    sumMovefttx.push({{ $move12[$province->province_id] ?? 0 }});
                @else
                    provinceNames.push("{{ $province->province_name }}");
                    fttxNewData.push({{ $fttxNew[$province->province_id] ?? 0 }});
                    selfInstallData.push({{ $selfInstall[$province->province_id] ?? 0 }});
                    hireInstallData.push({{ $HireInstall[$province->province_id] ?? 0 }});
                    adJust.push({{ $adjustover12[$province->province_id] ?? 0 }});
                    sumMovefttx.push({{ $moveover12[$province->province_id] ?? 0 }});
                @endif
            @endforeach

            var ctx = document.getElementById('myChart').getContext('2d');

            var datasets = [{
                    label: 'New',
                    data: fttxNewData,
                    backgroundColor: 'rgba(20, 56, 94, 0.9)', 
                    borderColor: 'rgba(20, 56, 94, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ติดตั้งเอง',
                    data: selfInstallData,
                    backgroundColor: 'rgba(68, 131, 108, 0.9)',
                    borderColor: 'rgba(68, 131, 108, 1)',
                    borderWidth: 1
                },
                {
                    label: 'จ้างผู้รับเหมา',
                    data: hireInstallData,
                    backgroundColor: 'rgba(249, 232, 151, 0.9)',
                    borderColor: 'rgba(249, 232, 151, 1)',
                    borderWidth: 1
                }
            ];

            // ถ้ามีค่าปรับโปรโมชั่น ให้เพิ่มเป็นแท่งแยก
            if (adJust.length > 0) {
                datasets.push({
                    label: 'ปรับโปรโมชั่น',
                    backgroundColor: 'rgba(231, 183, 136, 0.9)',
                    borderColor: 'rgba(231, 183, 136, 1)',
                    borderWidth: 1,
                    data: adJust
                });
            }

            // ถ้ามีค่าปรับโปรโมชั่น ให้เพิ่มเป็นแท่งแยก
            if (sumMovefttx.length > 0) {
                datasets.push({
                    label: 'ลูกค้าย้ายค่าย',
                    backgroundColor: 'rgba(235, 117, 13, 0.8)',
                    borderColor: 'rgba(235, 117, 13, 1)',
                    borderWidth: 1,
                    data: sumMovefttx
                });
            }

            // ✅ โหลด Plugin ก่อนใช้
Chart.register(ChartDataLabels);

// ✅ สร้างกราฟ
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: provinceNames,
        datasets: datasets
    },
    options: {
        responsive: true,
        scales: {
            x: {
                stacked: false // ❌ ปิด stacked เพื่อแยกแท่ง
            },
            y: {
                beginAtZero: true,
                stacked: false, // ❌ ปิด stacked เพื่อแยกแท่ง
                ticks: {
                    stepSize: 1,
                    callback: function(value) {
                        return value.toFixed(0);
                    }
                }
            }
        },
        barPercentage: 1, // ✅ ปรับให้แท่งไม่กว้างเกินไป
        categoryPercentage: 0.8, // ✅ กำหนดระยะห่างของแต่ละแท่ง
        plugins: {
            legend: {
                position: 'top'
            },
            datalabels: { // ✅ เพิ่มตัวเลขในแท่งกราฟ
                anchor: 'center',  // ✅ วางเลขกลางแท่ง
                align: 'center',   // ✅ จัดให้ตรงกลางแท่ง
                formatter: function(value) {
                    return value.toLocaleString(); // ✅ ใส่ comma ให้ตัวเลข
                },
                color: '#fff', // ✅ สีขาว (ถ้าแท่งสีอ่อน ให้ใช้ '#000')
                font: {
                    weight: 'bold',
                    size: 10
                }
            }
        }
    },
    plugins: [ChartDataLabels] // ✅ เปิดใช้งาน Plugin
});

        </script>

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
                anchor: 'center',  // ✅ วางเลขกลางแท่ง
                align: 'center',   // ✅ จัดให้ตรงกลางแท่ง
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

        <script>
            var provinceNames = [];
            var Simmy_count = [];
            var Simmy_move = [];
            var Simmy_new = [];
            var Simmy_price = [];

            // ข้อมูลจาก PHP
            @foreach ($provinces as $province)
                provinceNames.push("{{ $province->province_name }}");
                Simmy_count.push({{ $Simmy_count[$province->province_id] ?? 0 }});
                Simmy_move.push({{ $Simmy_move[$province->province_id] ?? 0 }});
                Simmy_new.push({{ $Simmy_new[$province->province_id] ?? 0 }});
                Simmy_price.push({{ $Simmy_price[$province->province_id] ?? 0 }});
            @endforeach

            // 🎯 กราฟ 1: ลูกค้าใหม่ และย้ายค่าย
            var ctx3 = document.getElementById('myChart3').getContext('2d');

            var myChart3 = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: provinceNames,
                    datasets: [{
                            label: 'ลูกค้าใหม่',
                            backgroundColor: 'rgba(67, 31, 61, 0.8)', // สีฟ้า
                borderColor: 'rgba(67, 31, 61, 1)',
                            borderWidth: 1,
                            data: Simmy_new
                        },
                        {
                            label: 'ลูกค้า(ย้ายค่าย)',
                            backgroundColor: 'rgba(63, 61, 89, 0.8)', // สีเขียว
                borderColor: 'rgba(63, 61, 89, 1)',
                            borderWidth: 1,
                            data: Simmy_move
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    maxBarThickness: 90,
                    scales: {
                        x: {
                            stacked: false
                        },
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return value.toFixed(0); // แสดงค่าทศนิยม 0 ตำแหน่ง
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
                anchor: 'center',  // ✅ วางเลขกลางแท่ง
                align: 'center',   // ✅ จัดให้ตรงกลางแท่ง
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
                }
            });


Chart.register(ChartDataLabels);

var ctx4 = document.getElementById('myChart4').getContext('2d');

var myChart4 = new Chart(ctx4, {
    type: 'bar',
    data: {
        labels: provinceNames,
        datasets: [{
            label: 'เติมเงินรายปี (ยอดเงิน)',
            backgroundColor: 'rgba(118, 215, 215, 0.9)', // ✅ แก้สีให้ถูกต้อง (0.8)
            borderColor: 'rgba(118, 215, 215, 1)',
            borderWidth: 1,
            data: Simmy_price
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        maxBarThickness: 90,
        scales: {
            x: {
                stacked: false
            },
            y: {
                beginAtZero: true,
                stacked: false,
                ticks: {
                    callback: function(value) {
                        return value.toFixed(2); // ✅ แสดงทศนิยม 2 ตำแหน่ง
                    }
                }
            }
        },
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function(tooltipItem) {
                        var Simmy_countValue = Simmy_count[tooltipItem.dataIndex]; // ดึงค่า Simmy_count
                        var Simmy_priceValue = Simmy_price[tooltipItem.dataIndex]; // ดึงค่า Simmy_price

                        return [
                            'เติมเงินรายปี',
                            'จำนวน : ' + Simmy_countValue.toLocaleString() + ' ราย',
                            'ยอดเงิน : ' + Simmy_priceValue.toLocaleString() + ' บาท'
                        ];
                    }
                }
            },
            datalabels: { // ✅ เพิ่มตัวเลขในแท่งกราฟ
                anchor: 'center',  // ✅ วางเลขกลางแท่ง
                align: 'center',   // ✅ จัดให้ตรงกลางแท่ง
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
