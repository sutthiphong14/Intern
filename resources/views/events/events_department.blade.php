@extends('admins.index')
@section('css')


<style>
    @keyframes colorChange {
        0% { color: red; }        /* เริ่มต้นสีแดง */
        50% { color: yellow; }    /* ตรงกลางเป็นสีเหลือง */
        100% { color: #28a745; }    /* สิ้นสุดเป็นสีเขียว */
    }

    .dynamic-text {
        min-height: 300px;
        height: 290px;
        max-height: 300px;
        max-width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(30px, 7vw, 80px);
        font-weight: bold;
        border-radius: 10px;
        animation: colorChange 2s linear forwards; /* ใช้ Animation */
    }
</style>



<script>
  
</script>
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
        </span> กิจกรรม {{ $types->type_name }}
    </h4>

    <div class="content-wrapper mb-5">
        <div class="card mb-3">

            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">สรุปผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }}</h3>
                <div class="d-flex align-items-center gap-2">
                    <div class="form-group me-4">

                        <select id="chartFilter" class="form-control form-select me-5">
                            <option value="total" {{ request('chartFilter') == 'total' ? 'selected' : '' }}>รวมทั้งหมด
                            </option>
                            <option value="tp1" {{ request('chartFilter') == 'tp1' ? 'selected' : '' }}>ตป.1</option>
                            <option value="tp2" {{ request('chartFilter') == 'tp2' ? 'selected' : '' }}>ตป.2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <!-- Card แรก -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-warning "><i class="fas fa-wifi"></i> Fttxbroadband</h3>
                        <button class="btn btn-sm" data-bs-toggle="collapse" data-bs-target="#chart1">
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
                        <h3 class="mb-0 text-warning"><i class="fas fa-chart-line"></i> ICT solution</h3>
                        <button class="btn btn-sm" data-bs-toggle="collapse" data-bs-target="#chart2">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="card-body collapse show" id="chart2">
                        <!-- <canvas id="myChart2"
                                style="min-height: 300px; height: 290px; max-height: 300px; max-width: 100%;"></canvas> -->
                                <div class="dynamic-text" id="animatedNumber">0 ฿</div>
                    </div>
                </div>
            </div>

            <!-- Card ที่สาม -->
            <div class="col-md-7 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-warning"><i class="fas fa-sim-card"></i> SIM My </h3>
                        <button class="btn btn-sm" data-bs-toggle="collapse" data-bs-target="#chart3">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="card-body collapse show" id="chart3">
                        <canvas id="myChart3"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-5 mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-warning"><i class="fas fa-money-check-alt"></i> เติมเงินรายปี</h3>
                        <button class="btn btn-sm" data-bs-toggle="collapse" data-bs-target="#chart4">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="card-body collapse show" id="chart4">
                        <!-- <canvas id="myChart4"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas> -->
                            <div class="dynamic-text" id="animatedNumber2">0 ฿</div>
                    </div>
                </div>
            </div>

        </div>



        <div class="card mt-4">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">สรุปผลการดำเนินงานกิจกรรมการตลาด event1</h3>
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

            <div class="card-body">
                <div class="table-responsive ">
                    <table class="table table-bordered text-center ">
                        <thead>
                            <tr class="bg-dark text-center align-center">
                                <th rowspan="4">ดูข้อมูล</th>
                                <th rowspan="4">ส่วนงาน</th>
                                <th colspan="4">FTTX</th>
                                <th colspan="4">SIM my</th>
                                <th colspan="2">Ict Solution</th>

                            </tr>
                            <tr class="bg-dark text-center">

                                <th rowspan="4">new</th>
                                <th rowspan="4">ติดตั้งเอง</th>
                                <th rowspan="4">จ้างผู้รับเหมา</th>
                                <th rowspan="4">ปรับโปรโมชั่น</th>

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
                        <tbody>
                            <tr>
                                <td> <a href="{{ route('event_services', ['province_id' => 1, 'type_id' => $types->type_id]) }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-search"></i>
                                    </a> </td>
                                <td>ตป.1</td>
                                <td>{{ $sumFttxNew }}</td>
                                <td>{{ $sumSelfInstall }}</td>
                                <td>{{ $sumHireInstall }}</td>
                                <td>{{ $adjust12 }}</td>

                                <td>{{ $sumNew }}</td>
                                <td>{{ $sumMove }}</td>
                                <td>{{ $sumCount }}</td>
                                <td>{{ $sumPrice }}</td>
                                <td>{{ $IctCount }}</td>
                                <td>{{ $IctIncome }}</td>
                            </tr>
                            <tr>
                                <td> <a href="{{ route('event_services', ['province_id' => 2, 'type_id' => $types->type_id]) }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-search"></i>
                                    </a> </td>
                                <td>ตป.2</td>
                                <td>{{ $sumFttxNewOver33 }}</td>
                                <td>{{ $sumSelfInstallOver33 }}</td>
                                <td>{{ $sumHireInstallOver33 }}</td>
                                <td>{{ $adjustover12 }}</td>

                                <td>{{ $sumNewOver33 }}</td>
                                <td>{{ $sumMoveOver33 }}</td>
                                <td>{{ $sumCountOver33 }}</td>
                                <td>{{ $sumPriceOver33 }}</td>
                                <td>{{ $IctCountOver33 }}</td>
                                <td>{{ $IctIncomeOver33 }}</td>
                            </tr>
                            <tr class="bg-dark">

                                <td colspan="2">รวมทั้งหมด</td>
                                <td>{{ $sumFttxNew + $sumFttxNewOver33 }}</td>
                                <td>{{ $sumSelfInstall + $sumSelfInstallOver33 }}</td>
                                <td>{{ $sumHireInstall + $sumHireInstallOver33 }}</td>
                                <td>{{ $adjust12 + $adjustover12 }}</td>
                                <td>{{ $sumNew + $sumNewOver33 }}</td>
                                <td>{{ $sumMove + $sumMoveOver33 }}</td>
                                <td>{{ $sumCount + $sumCountOver33 }}</td>
                                <td>{{ $sumPrice + $sumPriceOver33 }}</td>
                                <td>{{ $IctCount + $IctCountOver33 }}</td>
                                <td>{{ $IctIncome + $IctIncomeOver33 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection

    @section('script')
        <!-- ChartJS -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    Chart.register(ChartDataLabels); // เปิดใช้งาน datalabels plugin

    var sumFttxNew = {{ isset($sumFttxNew) && isset($sumFttxNewOver33) ? $sumFttxNew + $sumFttxNewOver33 : 0 }};
    var sumSelfInstall = {{ isset($sumSelfInstall) && isset($sumSelfInstallOver33) ? $sumSelfInstall + $sumSelfInstallOver33 : 0 }};
    var sumHireInstall = {{ isset($sumHireInstall) && isset($sumHireInstallOver33) ? $sumHireInstall + $sumHireInstallOver33 : 0 }};
    var sumAdjust = {{ isset($adjust12) && isset($adjustover12) ? $adjust12 + $adjustover12 : 0 }};

    var adjust = {{ count($adjust) }};
    if (adjust === 0) {
        adjust = null; 
    }

    var selectedTypeName = "{{ isset($types->type_name) ? $types->type_name : 'Unknown' }}";

    var datasets = [
        {
            label: 'New',
            backgroundColor: 'rgba(1, 15, 11, 0.8)',
            borderColor: 'rgba(1, 15, 11, 1)',
            borderWidth: 1,
            data: [sumFttxNew],
        },
        {
            label: 'ติดตั้งเอง',
            backgroundColor: 'rgba(2, 178, 125, 1)',
            borderColor: 'rgba(2, 178, 150, 0.8)',
            borderWidth: 1,
            data: [sumSelfInstall],
        },
        {
            label: 'จ้างผู้รับเหมา',
            backgroundColor: 'rgba(54, 250, 110, 0.8)',
            borderColor: 'rgba(54, 250, 110, 1)',
            borderWidth: 1,
            data: [sumHireInstall],
        }
    ];

    if (sumAdjust !== null) {
        datasets.push({
            label: 'ปรับโปรโมชั่น',
            backgroundColor: 'rgba(204, 204, 204, 0.8)',
            borderColor: 'rgba(204, 220, 220, 1)',
            borderWidth: 1,
            data: [sumAdjust],
            stack: 'stack2'
        });
    }

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [selectedTypeName],
            datasets: datasets
        },
        options: {
            responsive: true,
            maxBarThickness: 60, // ✅ จำกัดความกว้างแท่ง
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function (value) {
                            return value.toFixed(0);
                        }
                    }
                },
                x: {
                    stacked: false,
                    ticks: {
                        padding: 10 // ✅ เพิ่ม padding ให้ Label X
                    }
                }
            },
            layout: {
                padding: {
                    bottom: 20 // ✅ เพิ่มที่ว่างให้ Label X
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                datalabels: {
                    anchor: 'end',
                    align: 'start', // ✅ ให้ตัวเลขอยู่บนสุด แต่ไม่บัง Label
                    offset: 5, // ✅ ให้ตัวเลขไม่ติดแท่งเกินไป
                    formatter: function (value) {
                        return value.toFixed(0);
                    },
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    color: '#000',
                    backgroundColor: 'rgba(255,255,255,0.7)', // ✅ เพิ่มพื้นหลังให้ตัวเลขอ่านง่าย
                    borderRadius: 3,
                    padding: 3
                }
            }
        }
    });
</script>





        <script>
            // ข้อมูลจาก PHP
            var ictCount = {{ isset($IctCount) && isset($IctCountOver33) ? $IctCount + $IctCountOver33 : 0 }};
            var ictIncome = {{ isset($IctIncome) && isset($IctIncomeOver33) ? $IctIncome + $IctIncomeOver33 : 0 }};
            // ข้อมูลการ์ดที่สอง
            var datasets2 = [

                {
                    label: 'รายได้',
                    backgroundColor: 'rgba(236, 229, 21, 0.8)', // สีเหลือง
                    borderColor: 'rgba(236, 229, 80, 1)',
                    borderWidth: 1,
                    data: [ictIncome],
                    stack: 'stack2' // stack อยู่ในอีกกลุ่มหนึ่ง
                }
            ];

            // สร้างกราฟที่ 2
            var ctx2 = document.getElementById('myChart2').getContext('2d');
            var myChart2 = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: [selectedTypeName], // ป้ายชื่อที่แสดงในกราฟ
                    datasets: datasets2 // ใช้ datasets ที่กำหนด
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
                                callback: function (value) {
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
                                // กำหนดข้อความ tooltip เอง
                                label: function (tooltipItem) {
                                    // คำนวณเปอร์เซ็นต์ของแต่ละค่า
                                    var ictCountPercentage = ((ictCount / (ictCount + ictIncome)) * 100).toFixed(2);
                                    var ictIncomePercentage = ((ictIncome / (ictCount + ictIncome)) * 100).toFixed(
                                        2);

                                    // แสดงข้อมูล ICT Count และ ICT Income พร้อมเปอร์เซ็นต์
                                    return [
                                        'จำนวน :' + ictCount + 'ราย',
                                        'รายได้ :' + ictIncome + 'บาท'
                                    ];
                                },

                            }
                        }
                    }
                }
            });
        </script>

        <script>
            // ข้อมูลจาก PHP สำหรับ myChart3 และ myChart4
            var sumNew = {{ isset($sumNew) && isset($sumNewOver33) ? $sumNew + $sumNewOver33 : 0 }};
            var sumMove = {{ isset($sumMove) && isset($sumMoveOver33) ? $sumMove + $sumMoveOver33 : 0 }};
            var sumCount = {{ isset($sumCount) && isset($sumCountOver33) ? $sumCount + $sumCountOver33 : 0 }};
            var sumPrice = {{ isset($sumPrice) && isset($sumPriceOver33) ? $sumPrice + $sumPriceOver33 : 0 }};

            // สร้าง datasets สำหรับ myChart3 (ตัดเติมเงินรายปีออก)
            var datasets3 = [{
                label: 'ลูกค้าใหม่',
                backgroundColor: 'rgba(32, 118, 200, 0.8)', // สีฟ้า
                borderColor: 'rgba(2, 178, 200, 1)',
                borderWidth: 1,
                data: [sumNew]
            },
            {
                label: 'ลูกค้า(ย้ายค่าย)',
                backgroundColor: 'rgba(32, 232, 93, 0.8)', // สีเขียว
                borderColor: 'rgba(54, 250, 110, 1)',
                borderWidth: 1,
                data: [sumMove]
            }
            ];

            // สร้างกราฟที่ 3 (ลูกค้าใหม่ + ย้ายค่าย)
            var ctx3 = document.getElementById('myChart3').getContext('2d');
            var myChart3 = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: [selectedTypeName], // ป้ายชื่อแกน X
                    datasets: datasets3
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    maxBarThickness: 90,
                    scales: {
                        x: {
                            maxBarThickness: 20
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: value => value.toFixed(0)
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });

            // สร้าง datasets สำหรับ myChart4 (เฉพาะเติมเงินรายปี)
            var datasets4 = [

                {
                    label: 'เติมเงินรายปี (ยอดเงิน)',
                    backgroundColor: 'rgba(244, 29, 255, 0.8)', // สีแดง
                    borderColor: 'rgba(244, 29, 255, 1)',
                    borderWidth: 1,
                    data: [sumPrice]
                }
            ];


            // สร้างกราฟที่ 4 (เติมเงินรายปี)
            var ctx4 = document.getElementById('myChart4').getContext('2d');
            var myChart4 = new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: [selectedTypeName], // ป้ายชื่อแกน X
                    datasets: datasets4
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    maxBarThickness: 90,
                    scales: {
                        x: {
                            maxBarThickness: 20
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 50,
                                callback: value => value.toFixed(2)
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
                                label: function (tooltipItem) {

                                    return [
                                        '-เติมเงินรายปี-',
                                        'จำนวน: ' + sumCount + ' ราย',
                                        'รายได้: ' + sumPrice + ' บาท'
                                    ]



                                }
                            }
                        }
                    }
                }
            });
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
    // Get the initial selected filter value
    let currentFilter = document.getElementById("chartFilter").value;
    
    // Function to get the income target values based on filter
    function getIncomeTargetValue(filter) {
        if (filter === "total") {
            return {{ $IctIncome + $IctIncomeOver33 }};
        } else if (filter === "tp1") {
            return {{ $IctIncome }};
        } else if (filter === "tp2") {
            return {{ $IctIncomeOver33 }};
        }
        return {{ $IctIncome + $IctIncomeOver33 }};
    }
    
    // Function to get the price target values based on filter
    function getPriceTargetValue(filter) {
        if (filter === "total") {
            return {{ $sumPrice + $sumPriceOver33 }};
        } else if (filter === "tp1") {
            return {{ $sumPrice }};
        } else if (filter === "tp2") {
            return {{ $sumPriceOver33 }};
        }
        return {{ $sumPrice + $sumPriceOver33 }};
    }
    
    // Generic animation function that can be reused for different elements
    function animateNumberTo(elementId, targetValue, duration = 2000) {
        let element = document.getElementById(elementId);
        if (!element) return; // Safety check
        
        let frameRate = 20; // จำนวนเฟรมต่อวินาที
        let totalFrames = (duration / 1000) * frameRate;
        let count = 0;
        let step = targetValue / totalFrames;
        
        function animateNumber() {
            count += step;
            if (count >= targetValue) {
                element.textContent = `${targetValue.toLocaleString()}฿`; // แสดงค่าขั้นสุดท้าย
            } else {
                element.textContent = `${Math.floor(count).toLocaleString()}฿`; // อัปเดตค่าตัวเลข
                requestAnimationFrame(animateNumber);
            }
        }
        
        // Start the animation
        animateNumber();
    }
    
    // Run the initial animations
    animateNumberTo("animatedNumber", getIncomeTargetValue(currentFilter));
    animateNumberTo("animatedNumber2", getPriceTargetValue(currentFilter));
    
    // Event listener for the chart filter
    document.getElementById("chartFilter").addEventListener("change", function () {
        // Update filter value
        currentFilter = this.value;
        
        // Update both animations
        animateNumberTo("animatedNumber", getIncomeTargetValue(currentFilter));
        animateNumberTo("animatedNumber2", getPriceTargetValue(currentFilter));
        
        // Update the chart data
        updateChart(currentFilter);
    });
    
    // Your existing updateChart function
    function updateChart(filter) {
        var newFttxNew, newSelfInstall, newHireInstall, adjust, newIctCount, newIctIncome, newSumNew, newSumMove,
            newSumCount, newSumPrice;

        if (filter === "tp1") {
            newFttxNew = {{ $sumFttxNew }};
            newSelfInstall = {{ $sumSelfInstall }};
            newHireInstall = {{ $sumHireInstall }};
            adjust = {{ $adjust12 }};
            newIctCount = {{ $IctCount }};
            newIctIncome = {{ $IctIncome }};
            newSumNew = {{ $sumNew }};
            newSumMove = {{ $sumMove }};
            newSumCount = {{ $sumCount }};
            newSumPrice = {{ $sumPrice }};
        } else if (filter === "tp2") {
            newFttxNew = {{ $sumFttxNewOver33 }};
            newSelfInstall = {{ $sumSelfInstallOver33 }};
            newHireInstall = {{ $sumHireInstallOver33 }};
            adjust = {{ $adjustover12 }};
            newIctCount = {{ $IctCountOver33 }};
            newIctIncome = {{ $IctIncomeOver33 }};
            newSumNew = {{ $sumNewOver33 }};
            newSumMove = {{ $sumMoveOver33 }};
            newSumCount = {{ $sumCountOver33 }};
            newSumPrice = {{ $sumPriceOver33 }};
        } else {
            newFttxNew = {{ $sumFttxNew + $sumFttxNewOver33 }};
            newSelfInstall = {{ $sumSelfInstall + $sumSelfInstallOver33 }};
            newHireInstall = {{ $sumHireInstall + $sumHireInstallOver33 }};
            adjust = {{ $adjust12 + $adjustover12 }};
            newIctCount = {{ $IctCount + $IctCountOver33 }};
            newIctIncome = {{ $IctIncome + $IctIncomeOver33 }};
            newSumNew = {{ $sumNew + $sumNewOver33 }};
            newSumMove = {{ $sumMove + $sumMoveOver33 }};
            newSumCount = {{ $sumCount + $sumCountOver33 }};
            newSumPrice = {{ $sumPrice + $sumPriceOver33 }};
        }

        myChart.data.datasets[0].data = [newFttxNew];
        myChart.data.datasets[1].data = [newSelfInstall];
        myChart.data.datasets[2].data = [newHireInstall];
        myChart.data.datasets[3].data = [adjust];
        myChart.update(); // อัปเดตกราฟ

        // อัปเดตข้อมูลใน datasets2
        myChart2.data.datasets[0].data = [newIctIncome]; // อัปเดตข้อมูลรายได้
        ictCount = newIctCount; // อัปเดตค่า ictCount
        ictIncome = newIctIncome; // อัปเดตค่า ictIncome
        myChart2.update();

        // อัปเดตข้อมูลใน datasets3
        myChart3.data.datasets[0].data = [newSumNew]; // ลูกค้าใหม่
        myChart3.data.datasets[1].data = [newSumMove]; // ลูกค้า(ย้ายค่าย)

        // อัปเดต sumTotal สำหรับ Tooltip
        sumNew = newSumNew;
        sumMove = newSumMove;
        sumCount = newSumCount;
        sumPrice = newSumPrice;
        myChart3.update();

        myChart4.data.datasets[0].data = [newSumCount]; // เติมเงินรายปี
        myChart4.update();
    }
});
        </script>
    @endsection