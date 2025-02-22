@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <div>
            <h3>สรุปผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }}</h3>



        </div>
        <div class="row">
            <!-- Card แรก -->
            <div class="col-md-7"> 
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">Fttxbroadband</h3>
                        <canvas id="myChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        
            <!-- Card ที่สอง -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">ICT solution</h3>
                        <canvas id="myChart2" style="min-height: 300px; height: 290px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h3 class="mb-4">SIM my</h3>
                <canvas id="myChart3" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
            </div>
        </div>
        
        
        
        <hr>
        <table class="table table-bordered text-center mt-1">
            <thead>
                <tr class="bg-dark text-center align-center">
                    <th rowspan="4">ดูข้อมูล</th>
                    <th rowspan="4">ส่วนงาน</th>
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
                    <td>{{ $sumNewOver33 }}</td>
                    <td>{{ $sumMoveOver33 }}</td>
                    <td>{{ $sumCountOver33 }}</td>
                    <td>{{ $sumPriceOver33 }}</td>
                    <td>{{ $IctCountOver33 }}</td>
                    <td>{{ $IctIncomeOver33 }}</td>
                </tr>
                <tr class="bg-warning">

                    <td colspan="2">รวมทั้งหมด</td>
                    <td>{{ $sumFttxNew + $sumFttxNewOver33 }}</td>
                    <td>{{ $sumSelfInstall + $sumSelfInstallOver33 }}</td>
                    <td>{{ $sumHireInstall + $sumHireInstallOver33 }}</td>
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
@endsection

@section('script')
    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ข้อมูลที่ดึงมาจาก PHP
        var sumFttxNew = {{ isset($sumFttxNew) && isset($sumFttxNewOver33) ? $sumFttxNew + $sumFttxNewOver33 : 0 }};
        var sumSelfInstall =
            {{ isset($sumSelfInstall) && isset($sumSelfInstallOver33) ? $sumSelfInstall + $sumSelfInstallOver33 : 0 }};
        var sumHireInstall =
            {{ isset($sumHireInstall) && isset($sumHireInstallOver33) ? $sumHireInstall + $sumHireInstallOver33 : 0 }};

        // ตรวจสอบค่า adjust ว่ามีค่าเท่ากับ 0 หรือไม่
        var adjust = {{ count($adjust) }};
        if (adjust === 0) {
            adjust = null; // ถ้า adjust เป็น 0 จะไม่แสดง
        }


        var selectedTypeName = "{{ isset($types->type_name) ? $types->type_name : 'Unknown' }}";

        // สร้าง datasets สำหรับกราฟ
        var datasets = [{
                label: 'New',
                backgroundColor: 'rgba(1, 15, 11, 0.8)', // สีน้ำเงิน
                borderColor: 'rgba(1, 15, 11, 1)',
                borderWidth: 1,
                data: [sumFttxNew],
                stack: 'stack1' // กำหนดให้ stack กัน
            },
            {
                
                label: 'ติดตั้งเอง',
                backgroundColor: 'rgba(2, 178, 125, 0.8)', // สีเขียว
                borderColor: 'rgba(2, 178, 125, 1)',
                borderWidth: 1,
                data: [sumSelfInstall],
                stack: 'stack1' // กำหนดให้ stack กัน
            },
            {
                label: 'จ้างผู้รับเหมา',
                backgroundColor: 'rgba(54, 162, 67, 0.8)', // สีเหลือง
                borderColor: 'rgba(54, 162, 67, 1)',
                borderWidth: 1,
                data: [sumHireInstall],
                stack: 'stack1' // กำหนดให้ stack กัน
            }
        ];

        // ถ้ามีค่า adjust ให้เพิ่มเป็นแท่งแยก
        if (adjust !== null) {
            datasets.push({
                label: 'ปรับโปรโมชั่น',
                backgroundColor: 'rgba(204, 204, 204, 0.8)', // สีเทา
                borderColor: 'rgba(204, 204, 204, 1)',
                borderWidth: 1,
                data: [adjust],
                stack: 'stack2' // ให้ adjust อยู่คนละกลุ่ม
            });
        }

        // สร้างกราฟด้วย Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [selectedTypeName],
                datasets: datasets // ใช้ datasets ที่กำหนดไว้
            },
            options: {
                responsive: true,
                maxBarThickness: 100,
                scales: {
                    y: {
                        beginAtZero: true, // เริ่มต้นแกน Y จากศูนย์
                        
                        ticks: {
                            stepSize: 1, // กำหนดขนาดแต่ละขั้นที่แกน Y
                            callback: function(value) {
                                return value.toFixed(0); // แสดงค่าของ Y ในรูปแบบทศนิยม 1 ตำแหน่ง
                            }
                        }
                    },
                    x: {
                        stacked: true,
                    }
                },
                plugins: {
                    legend: {
                        position: 'top', // ตั้งตำแหน่ง legend
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
            backgroundColor: 'rgba(236, 229, 21, 0.8)', // สีน้ำเงิน
            borderColor: 'rgba(236, 229, 21, 1)',
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
            labels: ['ICT Data'], // ป้ายชื่อที่แสดงในกราฟ
            datasets: datasets2 // ใช้ datasets ที่กำหนด
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
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
                        // กำหนดข้อความ tooltip เอง
                        label: function(tooltipItem) {
                            // คำนวณเปอร์เซ็นต์ของแต่ละค่า
                            var ictCountPercentage = ((ictCount / (ictCount + ictIncome)) * 100).toFixed(2);
                            var ictIncomePercentage = ((ictIncome / (ictCount + ictIncome)) * 100).toFixed(2);

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
    // ข้อมูลจาก PHP สำหรับ myChart3
    var sumNew = {{ isset($sumNew) && isset($sumNewOver33) ? $sumNew + $sumNewOver33 : 0 }};
    var sumMove = {{ isset($sumMove) && isset($sumMoveOver33) ? $sumMove + $sumMoveOver33 : 0 }};
    var sumCount = {{ isset($sumCount) && isset($sumCountOver33) ? $sumCount + $sumCountOver33 : 0 }};
    var sumPrice = {{ isset($sumPrice) && isset($sumPriceOver33) ? $sumPrice + $sumPriceOver33 : 0 }};

    // สร้าง datasets สำหรับ myChart3
    var datasets3 = [
        {
            label: 'New',
            backgroundColor: 'rgba(32, 118, 232, 0.8)', // สีฟ้า
            borderColor: 'rgba(32, 118, 232, 1)',
            borderWidth: 1,
            data: [sumNew]
        },
        {
            label: 'Move',
            backgroundColor: 'rgba(32, 232, 93, 0.8)', // สีเขียว
            borderColor: 'rgba(32, 232, 93, 1)',
            borderWidth: 1,
            data: [sumMove]
        },
        {
            label: 'Count',
            backgroundColor: 'rgba(232, 201, 32, 0.8)', // สีเหลือง
            borderColor: 'rgba(232, 201, 32, 1)',
            borderWidth: 1,
            data: [sumCount]
        },
       
    ];

    // สร้างกราฟที่ 3
    var ctx3 = document.getElementById('myChart3').getContext('2d');
    var myChart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['ข้อมูลทั้งหมด'], // ป้ายชื่อแกน X
            datasets: datasets3 // ใช้ datasets ที่กำหนด
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    // กำหนดให้แต่ละแท่งแยกกัน
                    maxBarThickness: 20 // ขนาดแท่งกราฟ
                },
                y: {
                    beginAtZero: true, // เริ่มจาก 0
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return value.toFixed(0); // แสดงค่าเป็นตัวเลขทศนิยม 0 ตำแหน่ง
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top' // ตำแหน่ง legend
                },
                tooltip: {
                    enabled: true, // เปิดใช้งาน tooltip
                    callbacks: {
                        // กำหนด tooltip แบบกำหนดเอง
                        label: function(tooltipItem) {
                            var sumTotal = sumNew + sumMove + sumCount + sumPrice;
                            var newPercentage = ((sumNew / sumTotal) * 100).toFixed(2);
                            var movePercentage = ((sumMove / sumTotal) * 100).toFixed(2);
                            var countPercentage = ((sumCount / sumTotal) * 100).toFixed(2);
                            var pricePercentage = ((sumPrice / sumTotal) * 100).toFixed(2);

                            // แสดง tooltip โดยใช้ค่าที่คำนวณมา
                           if (tooltipItem.datasetIndex === 2) {
                                return [
                                'จำนวน: '+ sumCount + ' ราย',
                                'รายได้: ' + sumPrice + ' บาท']
                            }
                        },
                    }
                }
            }
        }
    });
</script>




@endsection
