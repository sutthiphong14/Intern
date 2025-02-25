@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="mt-5">
        <h3>สรุปรายงานผลการดำเนินงานกิจกรรมการตลาด</h3>
    </div>
    <h5>Fttx broadband</h5>
    <table class="table table-bordered ">
        <thead>
            <tr class="bg-dark text-center align-center">
                <th rowspan="2">ลำดับ</th>
                <th rowspan="2">จังหวัด</th>
                <th colspan="3">FTTX</th>

            </tr>
            <tr class="bg-dark text-center">

                <th rowspan="2">new</th>
                <th rowspan="2">ติดตั้งเอง</th>
                <th rowspan="2">จ้างผู้รับเหมา</th>

            </tr>
        </thead>
        @php
            $sumFttxNew = $sumSelfInstall = $sumHireInstall = 0; // สำหรับ province_id <= 33
            $sumFttxNewOver33 = $sumSelfInstallOver33 = $sumHireInstallOver33 = 0; // สำหรับ province_id > 33
        @endphp
        <tbody class="text-center">
            @foreach ($provinces as $index => $province)
                {{-- Province ID <= 33 --}}
                @if ($province->province_id <= 12)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $province->province_name }}</td>
                        <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                        <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                        <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>
                    </tr>
                    @php
                        $sumFttxNew += $fttxNew[$province->province_id] ?? 0;
                        $sumSelfInstall += $selfInstall[$province->province_id] ?? 0;
                        $sumHireInstall += $HireInstall[$province->province_id] ?? 0;
                    @endphp
                @endif

                {{-- แสดงผลรวมตรงกลางเมื่อเปลี่ยนกลุ่ม --}}
                @if ($province->province_id == 12)
                    <tr class="bg-warning">
                        <td colspan="2">รวม ตป.1</td>
                        <td>{{ $sumFttxNew }}</td>
                        <td>{{ $sumSelfInstall }}</td>
                        <td>{{ $sumHireInstall }}</td>
                    </tr>
                @endif

                {{-- Province ID > 33 --}}
                @if ($province->province_id > 12)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $province->province_name }}</td>
                        <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                        <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                        <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>
                    </tr>
                    @php
                        $sumFttxNewOver33 += $fttxNew[$province->province_id] ?? 0;
                        $sumSelfInstallOver33 += $selfInstall[$province->province_id] ?? 0;
                        $sumHireInstallOver33 += $HireInstall[$province->province_id] ?? 0;
                    @endphp
                @endif
            @endforeach

            {{-- แสดงผลรวมสำหรับ province_id > 33 --}}
            <tr class="bg-warning">
                <td colspan="2">รวม ตป.2</td>
                <td>{{ $sumFttxNewOver33 }}</td>
                <td>{{ $sumSelfInstallOver33 }}</td>
                <td>{{ $sumHireInstallOver33 }}</td>
            </tr>

            <tr class="bg-success">
                <td colspan="2">รวม ทั้งหมด</td>
                <td>{{ $sumFttxNew + $sumFttxNewOver33 }}</td>
                <td>{{ $sumSelfInstall + $sumSelfInstallOver33 }}</td>
                <td>{{ $sumHireInstall + $sumHireInstallOver33 }}</td>
            </tr>
        </tbody>



    </table>
    
    <div class='card mt-5'>
        <h3 class="card-header bg-primary ">กราฟ Fttx broadband</h3>
        <canvas id="myChart" class="mt-5 "
            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
    </div>
@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
    // ดึงข้อมูลจาก Blade ไปใส่ใน JavaScript
    const provincesRaw = @json($provinces);
    const fttxNew = @json($fttxNew);
    const selfInstall = @json($selfInstall);
    const hireInstall = @json($HireInstall);

    // กรองข้อมูล: ไม่เอา provinces ที่ทุกค่า (fttxNew, selfInstall, hireInstall) เท่ากับ 0
    const filteredData = provincesRaw.filter((province) => {
        const provinceId = province.province_id;
        return (
            (fttxNew[provinceId] || 0) > 0 ||
            (selfInstall[provinceId] || 0) > 0 ||
            (hireInstall[provinceId] || 0) > 0
        );
    });

    // สร้างข้อมูลที่ผ่านการกรอง
    const provinces = filteredData.map((province) => province.province_name);
    const fttxData = filteredData.map((province) => fttxNew[province.province_id] || 0);
    const selfInstallData = filteredData.map((province) => selfInstall[province.province_id] || 0);
    const hireInstallData = filteredData.map((province) => hireInstall[province.province_id] || 0);

    const ctx = document.getElementById('myChart').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: provinces,
            datasets: [{
                    label: "จ้างผู้รับเหมา",
                    data: hireInstallData,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    barThickness: 25,
                    borderRadius: 5, // ทำมุมโค้งมน
                },
                {
                    label: "NEW",
                    data: fttxData,
                    backgroundColor: 'rgba(54, 162, 235, 0.45)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    barThickness: 50,
                    borderRadius: 5, // ทำมุมโค้งมน
                },
                {
                    label: "ติดตั้งเอง",
                    data: selfInstallData,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    barThickness: 25,
                    borderRadius: 5, // ทำมุมโค้งมน
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom', // ย้าย Legend มาด้านล่าง
                    labels: {
                        font: {
                            size: 14,
                        },
                    },
                },
                // ตั้งค่า Data Labels
                datalabels: {
                    display: true,
                    color: '#fff', // สีตัวอักษร
                    backgroundColor: 'rgba(0,0,0,0.5)', // สีพื้นหลังของตัวหนังสือ
                    borderRadius: 3,
                    anchor: 'end', // ตำแหน่งอ้างอิงให้อยู่ด้านบนของกราฟ
                    offset: -15, // ระยะห่างจากแท่งกราฟ
                    align: 'top', // จัดให้อยู่บนสุดของแท่งกราฟ
                    formatter: (value) => {
                        return value > 0 ? value : null; // ซ่อนค่าที่เป็น 0
                    },
                },

            },
            scales: {
                x: {
                    grid: {
                        display: false, // ซ่อนเส้น Grid
                    },
                    ticks: {
                        font: {
                            size: 12,
                        },
                        maxRotation: 45, // ตั้งค่ามุมการหมุนของป้ายแกน X
                        minRotation: 0,
                    },
                    title: {
                        display: true,
                        text: 'จังหวัด', // เพิ่มชื่อแกน X
                        font: {
                            size: 16,
                            weight: 'bold',
                        },
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'จำนวนการติดตั้ง', // เพิ่มชื่อแกน Y
                        font: {
                            size: 16,
                            weight: 'bold',
                        },
                    },
                },
            },
        },
        plugins: [ChartDataLabels], // ใช้ plugin datalabels
    });
</script>
@endsection