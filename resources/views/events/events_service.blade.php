@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3>สรุปผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }} <br>
                @if ($province_id == 1)
                    ตป.1
                @else
                    ตป.2
                @endif
            </h3>
            <a class="btn btn-secondary mb-3 text-white"
                href="{{ route('event_customer', $types->type_id) }}">ดูข้อมูลลูกค้า</a>
        </div>

        <div class="row">
            <!-- Card แรก -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Fttxbroadband</h3>
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
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">ICT solution</h3>
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
                        <h3 class="mb-0">SIM my</h3>
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
        </div>
        <hr>
        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-center align-center">
                    <th rowspan="4">ดูข้อมูล</th>
                    <th rowspan="4">จังหวัด</th>
                    <th colspan="3">FTTX</th>
                    <th colspan="4">SIM my</th>
                    <th colspan="2">Ict Solution</th>

                </tr>
                <tr class="bg-dark text-center">

                    <th rowspan="4">new</th>
                    <th rowspan="4">ติดตั้งเอง</th>
                    <th rowspan="4">จ้างผู้รับเหมา</th>

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
                    {{-- Province ID <= 33 --}}
                    @if ($province->province_id <= 12)
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
                        <tr class="bg-warning">
                            <td colspan="2">รวม ตป.1</td>
                            <td>{{ $sumFttxNew }}</td>
                            <td>{{ $sumSelfInstall }}</td>
                            <td>{{ $sumHireInstall }}</td>

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
                    <tr class="bg-warning">
                        <td colspan="2">รวม ตป.2</td>
                        <td>{{ $sumFttxNewOver33 }}</td>
                        <td>{{ $sumSelfInstallOver33 }}</td>
                        <td>{{ $sumHireInstallOver33 }}</td>

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
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // ดึงข้อมูลเฉพาะ province_id <= 12
        var provinceNames = [];
        var fttxNewData = [];
        var selfInstallData = [];
        var hireInstallData = [];

        @foreach ($provinces as $province)
            @if ($province->province_id <= 12)
                provinceNames.push("{{ $province->province_name }}");
                fttxNewData.push({{ $fttxNew[$province->province_id] ?? 0 }});
                selfInstallData.push({{ $selfInstall[$province->province_id] ?? 0 }});
                hireInstallData.push({{ $HireInstall[$province->province_id] ?? 0 }});
            @else
                provinceNames.push("{{ $province->province_name }}");
                fttxNewData.push({{ $fttxNew[$province->province_id] ?? 0 }});
                selfInstallData.push({{ $selfInstall[$province->province_id] ?? 0 }});
                hireInstallData.push({{ $HireInstall[$province->province_id] ?? 0 }});
            @endif
        @endforeach

        var ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: provinceNames,
                datasets: [{
                        label: 'New',
                        data: fttxNewData,
                        backgroundColor: 'rgba(1, 15, 11, 0.8)',
                        borderColor: 'rgba(1, 15, 11, 1)',
                        borderWidth: 1,
                        stack: 'stack1' // Grouping FTTX New into 'stack1'
                    },
                    {
                        label: 'ติดตั้งเอง',
                        data: selfInstallData,
                        backgroundColor: 'rgba(2, 178, 125, 0.8)',
                        borderColor: 'rgba(2, 178, 125, 1)',
                        borderWidth: 1,
                        stack: 'stack1' // Grouping Self Install into the same stack
                    },
                    {
                        label: 'จ้างผู้รับเหมา',
                        data: hireInstallData,
                        backgroundColor: 'rgba(54, 162, 67, 0.8)',
                        borderColor: 'rgba(54, 162, 67, 1)',
                        borderWidth: 1,
                        stack: 'stack1' // Grouping Hire Install into the same stack
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true // Enable stacking on the x-axis
                    },
                    y: {
                        beginAtZero: true,
                        stacked: true, // Enable stacking on the y-axis as well
                        ticks: {
                            stepSize: 1000,
                            callback: function(value) {
                                return value.toFixed(0); // แสดงค่าทศนิยม 0 ตำแหน่ง
                            }
                        }
                    }
                }
            }
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

        // สร้างกราฟที่ 2
        var ctx2 = document.getElementById('myChart2').getContext('2d');

        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: provinceNames, // ป้ายชื่อที่แสดงในกราฟ
                datasets: [{
                    label: 'รายได้',
                    backgroundColor: 'rgba(236, 229, 21, 0.8)', // สีเหลือง
                    borderColor: 'rgba(236, 229, 21, 1)',
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
                                return value.toFixed(2); // แสดงค่าทศนิยม 0 ตำแหน่ง
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
                                    'รายได้ : ' + ictIncomeValue + ' บาท'
                                ];
                            }
                        }
                    }
                }
            }
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
        @if ($province->province_id <= 12)
            provinceNames.push("{{ $province->province_name }}");
            Simmy_count.push({{ $Simmy_count[$province->province_id] ?? 0 }});
            Simmy_move.push({{ $Simmy_move[$province->province_id] ?? 0 }});
            Simmy_new.push({{ $Simmy_new[$province->province_id] ?? 0 }});
            Simmy_price.push({{ $Simmy_price[$province->province_id] ?? 0 }});
        @else
            provinceNames.push("{{ $province->province_name }}");
            Simmy_count.push({{ $Simmy_count[$province->province_id] ?? 0 }});
            Simmy_move.push({{ $Simmy_move[$province->province_id] ?? 0 }});
            Simmy_new.push({{ $Simmy_new[$province->province_id] ?? 0 }});
            Simmy_price.push({{ $Simmy_price[$province->province_id] ?? 0 }});
        @endif
    @endforeach

    // สร้างกราฟที่ 2
    var ctx3 = document.getElementById('myChart3').getContext('2d');

    var myChart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: provinceNames, // ป้ายชื่อที่แสดงในกราฟ
            datasets: [{
                    label: 'ลูกค้าใหม่',
                    backgroundColor: 'rgba(32, 118, 232, 0.8)', // สีฟ้า
                    borderColor: 'rgba(32, 118, 232, 1)',
                    borderWidth: 1,
                    data: Simmy_new
                },
                {
                    label: 'ลูกค้า(ย้ายค่าย)',
                    backgroundColor: 'rgba(32, 232, 93, 0.8)', // สีเขียว
                    borderColor: 'rgba(32, 232, 93, 1)',
                    borderWidth: 1,
                    data: Simmy_move
                },
                {
                    label: 'จำนวน',
                    backgroundColor: 'rgba(255, 99, 132, 0.8)', // สีแดง
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    data: Simmy_count // เพิ่มข้อมูลสำหรับ Simmy_count
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            maxBarThickness: 90,
            scales: {
                x: {
                    stacked: false, // ปรับเป็น false เพื่อแสดงเป็นแท่งแยก
                    maxBarThickness: 20 // กำหนดขนาดแท่ง
                },
                y: {
                    beginAtZero: true, // เริ่มจาก 0 ที่แกน Y
                    stacked: false, // ปรับเป็น false เพื่อแสดงเป็นแท่งแยก
                    ticks: {
                        stepSize: 1000,
                        callback: function(value) {
                            return value.toFixed(2); // แสดงค่าทศนิยม 0 ตำแหน่ง
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
                            // เช็คว่า tooltipItem.datasetIndex คือ dataset ของ "จำนวน"
                            if (tooltipItem.datasetIndex === 2) { // index ของ dataset "จำนวน"
                                var Simmy_countValue = Simmy_count[tooltipItem.dataIndex]; // ดึงค่า Simmy_count
                                var Simmy_priceValue = Simmy_price[tooltipItem.dataIndex]; // ดึงค่า Simmy_price

                                // แสดงข้อมูลใน tooltip เฉพาะสำหรับ "จำนวน"
                                return [
                                    'จำนวน : ' + Simmy_countValue + ' ราย',
                                    'รายได้ : ' + Simmy_priceValue + ' บาท'
                                ];
                            } else {
                                // ถ้าไม่ใช่ dataset ของ "จำนวน" ก็ให้แสดงข้อมูลของแท่งนั้นๆ
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        }
    });
</script>


@endsection
