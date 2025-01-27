@extends('admins.index')
@section('css')
@endsection

@section('content')
<h5 id="sim_my">SIM my</h5>
<table class="table table-bordered text-center" >
    <thead>
        <tr class="bg-dark">
            <th rowspan="3">ลำดับ</th>
            <th rowspan="3">จังหวัด</th>
            <th colspan="5" rowspan="1">SIM my</th>
           
        </tr>
        <tr class="bg-dark">
            <th rowspan="2">ลูกค้าใหม่</th>
            <th rowspan="2">ลูกค้า (ย้ายค่าย)</th>
            <th colspan="3">เติมเงินรายปี</th>
        
        
        </tr>
        <tr class="bg-dark">
            <th>จำนวน
                 (ราย)</th>
            <th>ยอดเงิน</th>
         
        </tr>
    </thead>

    @php
        $sumNew = $sumMove = $sumCount = $sumPrice  = 0; // สำหรับ province_id <= 33
        $sumNewOver33 = $sumMoveOver33 = $sumCountOver33 = $sumPriceOver33 = 0; // สำหรับ province_id > 33
    @endphp
    <tbody class="text-center">
        @foreach ($provinces as $index => $province)
            {{-- Province ID <= 33 --}}
            @if ($province->province_id <= 12)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $province->province_name }}</td>
                    <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                </tr>
                @php
                    $sumNew += $Simmy_new[$province->province_id] ?? 0;
                    $sumMove += $Simmy_move[$province->province_id] ?? 0;
                     $sumCount += $Simmy_count[$province->province_id] ?? 0;
                     $sumPrice += $Simmy_price[$province->province_id] ?? 0;
                 @endphp
            @endif

            {{-- แสดงผลรวมตรงกลางเมื่อเปลี่ยนกลุ่ม --}}
            @if ($province->province_id == 12)
                <tr class="bg-warning">
                    <td colspan="2">รวม ตป.1</td>
                    <td>{{ $sumNew }}</td>
                    <td>{{ $sumMove }}</td>
                    <td>{{ $sumCount }}</td>
                    <td>{{ $sumPrice }}</td>
                </tr>
            @endif

            {{-- Province ID > 33 --}}
            @if ($province->province_id > 12)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $province->province_name }}</td>
                    <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                </tr>
                @php
                $sumNewOver33 += $Simmy_new[$province->province_id] ?? 0;
                $sumMoveOver33 += $Simmy_move[$province->province_id] ?? 0;
                 $sumCountOver33 += $Simmy_count[$province->province_id] ?? 0;
                 $sumPriceOver33 += $Simmy_price[$province->province_id] ?? 0;
             @endphp
               
            @endif
        @endforeach

        {{-- แสดงผลรวมสำหรับ province_id > 33 --}}
        @if ($province->province_id > 12)
                <tr class="bg-warning">
                    <td colspan="2">รวม ตป.2</td>
                    <td>{{ $sumNewOver33 }}</td>
                    <td>{{ $sumMoveOver33 }}</td>
                    <td>{{ $sumCountOver33 }}</td>
                    <td>{{ $sumPriceOver33 }}</td>
                </tr>
            @endif

        <tr class="bg-success">
            <td colspan="2">รวม ทั้งหมด</td>
            <td>{{ $sumNew + $sumNewOver33 }}</td>
            <td>{{ $sumMove  + $sumMoveOver33 }}</td>
            <td>{{ $sumCount  + $sumCountOver33}}</td>
            <td>{{ $sumPrice  + $sumPriceOver33}}</td>
        </tr>
    </tbody>
</table>

<div class='card mt-5'>
    <h3 class="card-header bg-primary ">กราฟ Fttx broadband</h3>
    <canvas id="simMyChart" width="400" height="200"></canvas>
</div>
<!-- HTML สำหรับ Canvas -->


@endsection

@section('script')
   
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<script>
    // เตรียมข้อมูลจาก PHP
    const provinces = @json($provinces);
    const simNewData = @json($Simmy_new);
    const simMoveData = @json($Simmy_move);
    const simCountData = @json($Simmy_count);
    
     // สร้างอาร์เรย์สำหรับ Bar และ Line chart
     const labels = provinces.map(province => province.province_name);
    const newCustomers = provinces.map(province => simNewData[province.province_id] || 0);
    const moveCustomers = provinces.map(province => simMoveData[province.province_id] || 0);
    const counts = provinces.map(province => simCountData[province.province_id] || 0);

    // เปลี่ยนชื่อ config เป็น simMyChartConfig
    const simMyChartConfig = {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                type: 'bar', // Bar สำหรับลูกค้าใหม่
                label: 'ลูกค้าใหม่',
                data: newCustomers,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                order: 1 // ลำดับของ Bar จะต่ำกว่า Line
            },
            {
                type: 'line', // Line สำหรับลูกค้าย้ายค่าย
                label: 'ลูกค้า (ย้ายค่าย)',
                data: moveCustomers,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                tension: 0.4, // เพิ่มความยืดหยุ่นให้เส้นเพื่อให้มันดูมีระยะห่าง
                fill: false,  // ไม่เติมสีใต้เส้น
                pointRadius: 5, // เพิ่มขนาดจุดเพื่อให้เห็นชัดขึ้น
                pointHoverRadius: 7, // ขนาดของจุดเมื่อ hover
                order: 2 // ให้ Line อยู่เหนือ Bar
            },
            {
                type: 'line', // Line สำหรับจำนวนราย
                label: 'จำนวน (ราย)',
                data: counts,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4, // เพิ่มความยืดหยุ่นให้เส้น
                fill: false,
                pointRadius: 5,
                pointHoverRadius: 7,
                order: 3 // ให้ Line อยู่เหนือ Bar
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'กราฟแสดงข้อมูล SIM my'
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'จังหวัด'
                },
                ticks: {
                    autoSkip: true,  // กำหนดให้ไม่แสดงทุก label ถ้ามีข้อมูลมาก
                    maxTicksLimit: 20, // จำกัดจำนวน label ที่จะแสดง
                    maxRotation: 0,  // ปรับให้ label บนแกน X ไม่หมุน
                    minRotation: 0,  // กำหนดไม่ให้ label หมุน
                },
                grid: {
                    display: true,
                    drawBorder: true
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'จำนวนลูกค้า'
                },
                beginAtZero: true,
               
            }
        }
    }
};

// เรนเดอร์กราฟ
const ctx = document.getElementById('simMyChart').getContext('2d');
new Chart(ctx, simMyChartConfig);


</script>



@endsection
