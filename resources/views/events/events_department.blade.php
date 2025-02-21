@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <div >
            <h3>สรุปผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }}</h3>

         

        </div>
       <div class="card">
        <div class="card-body ">
            <h3>Fttxbroadband</h3>
            <canvas id="myChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
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
                    <td> <a href="{{ route('event_services', ['province_id' => 1, 'type_id' => $types->type_id]) }}" class="btn btn-warning">
                        <i class="fas fa-search"></i>
                    </a>   </td>
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
                    <td> <a href="{{ route('event_services', ['province_id' => 2, 'type_id' => $types->type_id]) }}" class="btn btn-warning">
                        <i class="fas fa-search"></i>
                    </a>   </td>
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
           
                    <td colspan="2" >รวมทั้งหมด</td>
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
    var sumSelfInstall = {{ isset($sumSelfInstall) && isset($sumSelfInstallOver33) ? $sumSelfInstall + $sumSelfInstallOver33 : 0 }};
    var sumHireInstall = {{ isset($sumHireInstall) && isset($sumHireInstallOver33) ? $sumHireInstall + $sumHireInstallOver33 : 0 }};
    
    // ตรวจสอบค่า adjust ว่ามีค่าเท่ากับ 0 หรือไม่
    var adjust = {{ count($adjust) }}; // หรือใช้ first() หากต้องการค่าตัวแรก
    if (adjust === 0) {
        adjust = null; // ถ้า adjust เป็น 0 จะไม่แสดง
    }

    console.log(adjust); // ตรวจสอบค่าในคอนโซล

    var selectedTypeName = "{{ isset($types->type_name) ? $types->type_name : 'Unknown' }}";

    // กำหนด datasets ตามเงื่อนไข
    var datasets = [
        {
            label: 'New',
            backgroundColor: 'rgba(32, 118, 232, 0.8)',
            borderColor: 'rgba(32, 118, 232, 1)',
            borderWidth: 1,
            data: [sumFttxNew]
        },
        {
            label: 'ติดตั้งเอง',
            backgroundColor: 'rgba(32, 232, 93, 0.8)',
            borderColor: 'rgba(32, 232, 93, 1)',
            borderWidth: 1,
            data: [sumSelfInstall]
        },
        {
            label: 'จ้างผู้รับเหมา',
            backgroundColor: 'rgba(232, 201, 32, 0.8)',
            borderColor: 'rgba(232, 201, 32, 1)',
            borderWidth: 1,
            data: [sumHireInstall]
        }
    ];

    // หาก adjust มีค่า (ไม่เป็น null หรือ 0) จะเพิ่ม datasets สำหรับ adjust
    if (adjust !== null) {
        datasets.push({
            label: 'ปรับโปรโมชั่น',
            backgroundColor: 'rgba(204, 204, 204, 0.8)',
            borderColor: 'rgba(204, 204, 204, 1)',
            borderWidth: 1,
            data: [adjust]
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
            scales: {
                y: {
                    beginAtZero: true, // เริ่มต้นแกน Y จากศูนย์
                    ticks: {
                        stepSize: 1, // กำหนดขนาดแต่ละขั้นที่แกน Y
                        callback: function(value) {
                            return value.toFixed(1); // แสดงค่าของ Y ในรูปแบบทศนิยม 1 ตำแหน่ง
                        }
                    }
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



@endsection
