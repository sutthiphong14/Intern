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

        <!-- Card for ICT solution chart -->
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-chart-line"></i> ICT solution</h3>
                    <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse" data-bs-target="#chart3">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="card-body collapse show" id="chart3">
                    <canvas id="myChart3"
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
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="bg-dark text-center">
                                <th rowspan="4">ดูข้อมูล</th>
                                <th rowspan="4">จังหวัด</th>
                                <th colspan="16">Ict Solution</th>
                            </tr>
                            <tr class="bg-dark text-center">
                                <th rowspan="2">จำนวน (ราย)</th>
                                <th rowspan="2">รายได้</th>
                                <th colspan="2">CCTV</th>
                                <th colspan="2">smart pole</th>
                                <th colspan="2">internet wifi</th>
                                <th colspan="2">smart office</th>
                                <th colspan="2">cyber security</th>
                                <th colspan="2">ultimate connect</th>
                                <th colspan="2">บริการอื่นๆ</th>
                            </tr>
                            <tr class="bg-dark text-center">
                                <th>จำนวนจุดติดตั้ง</th>
                                <th>รายได้</th>
                                <th>จำนวนจุดติดตั้ง</th>
                                <th>รายได้</th>
                                <th>จำนวนจุดติดตั้ง</th>
                                <th>รายได้</th>
                                <th>จำนวนจุดติดตั้ง</th>
                                <th>รายได้</th>
                                <th>จำนวนจุดติดตั้ง</th>
                                <th>รายได้</th>
                                <th>จำนวนจุดติดตั้ง</th>
                                <th>รายได้</th>
                                <th>จำนวนจุดติดตั้ง</th>
                                <th>รายได้</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @php
                                $group1Provinces = [];
                                $group2Provinces = [];
                                
                                // แยกจังหวัดเป็นสองกลุ่ม
                                foreach ($provinces as $province) {
                                    if ($province->province_id <= 12) {
                                        $group1Provinces[] = $province;
                                    } else {
                                        $group2Provinces[] = $province;
                                    }
                                }
                                
                                // เตรียมตัวแปรสำหรับรวมข้อมูลกลุ่มที่ 1
                                $group1TotalCount = 0;
                                $group1TotalIncome = 0;
                                $group1ServiceTotals = [
                                    'CCTV' => ['total_quantity' => 0, 'total_price' => 0],
                                    'smart pole' => ['total_quantity' => 0, 'total_price' => 0],
                                    'internet wifi' => ['total_quantity' => 0, 'total_price' => 0],
                                    'smart office' => ['total_quantity' => 0, 'total_price' => 0],
                                    'cyber security' => ['total_quantity' => 0, 'total_price' => 0],
                                    'ultimate connect' => ['total_quantity' => 0, 'total_price' => 0],
                                    'บริการอื่นๆ' => ['total_quantity' => 0, 'total_price' => 0]
                                ];
                                
                                // เตรียมตัวแปรสำหรับรวมข้อมูลกลุ่มที่ 2
                                $group2TotalCount = 0;
                                $group2TotalIncome = 0;
                                $group2ServiceTotals = [
                                    'CCTV' => ['total_quantity' => 0, 'total_price' => 0],
                                    'smart pole' => ['total_quantity' => 0, 'total_price' => 0],
                                    'internet wifi' => ['total_quantity' => 0, 'total_price' => 0],
                                    'smart office' => ['total_quantity' => 0, 'total_price' => 0],
                                    'cyber security' => ['total_quantity' => 0, 'total_price' => 0],
                                    'ultimate connect' => ['total_quantity' => 0, 'total_price' => 0],
                                    'บริการอื่นๆ' => ['total_quantity' => 0, 'total_price' => 0]
                                ];
                                
                                $serviceNames = ['CCTV', 'smart pole', 'internet wifi', 'smart office', 'cyber security', 'ultimate connect', 'บริการอื่นๆ'];
                            @endphp
                            
                            {{-- แสดงข้อมูลกลุ่มที่ 1 --}}
                            @foreach ($group1Provinces as $province)
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
                                    
                                    @php
                                        // รวมข้อมูลสำหรับกลุ่มที่ 1
                                        $group1TotalCount += ($Ict_count[$province->province_id] ?? 0);
                                        $group1TotalIncome += ($Ict_income[$province->province_id] ?? 0);
                                    @endphp
                                    
                                    @foreach ($serviceNames as $serviceName)
                                        @php
                                            $quantity = $provinceSummary[$province->province_id][$serviceName]['total_quantity'] ?? 0;
                                            $price = $provinceSummary[$province->province_id][$serviceName]['total_price'] ?? 0;
                                            
                                            // รวมข้อมูลบริการสำหรับกลุ่มที่ 1
                                            $group1ServiceTotals[$serviceName]['total_quantity'] += $quantity;
                                            $group1ServiceTotals[$serviceName]['total_price'] += $price;
                                        @endphp
                                        <td>{{ number_format($quantity, 0) }}</td>
                                        <td>{{ number_format($price) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            
                            {{-- แสดงผลรวมของกลุ่มที่ 1 --}}
                            @if ($province->province_id == 12)
                            <tr class="bg-dark">
                                <td colspan="2">รวม ตป.1</td>
                                <td>{{ number_format($group1TotalCount, 0) }}</td>
                                <td>{{ number_format($group1TotalIncome) }}</td>
                                
                                @foreach ($serviceNames as $serviceName)
                                    <td>{{ number_format($group1ServiceTotals[$serviceName]['total_quantity'], 0) }}</td>
                                    <td>{{ number_format($group1ServiceTotals[$serviceName]['total_price']) }}</td>
                                @endforeach
                            </tr>
                            @endif
                            
                            {{-- แสดงข้อมูลกลุ่มที่ 2 --}}
                            @foreach ($group2Provinces as $province)
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
                                    
                                    @php
                                        // รวมข้อมูลสำหรับกลุ่มที่ 2
                                        $group2TotalCount += ($Ict_count[$province->province_id] ?? 0);
                                        $group2TotalIncome += ($Ict_income[$province->province_id] ?? 0);
                                    @endphp
                                    
                                    @foreach ($serviceNames as $serviceName)
                                        @php
                                            $quantity = $provinceSummary[$province->province_id][$serviceName]['total_quantity'] ?? 0;
                                            $price = $provinceSummary[$province->province_id][$serviceName]['total_price'] ?? 0;
                                            
                                            // รวมข้อมูลบริการสำหรับกลุ่มที่ 2
                                            $group2ServiceTotals[$serviceName]['total_quantity'] += $quantity;
                                            $group2ServiceTotals[$serviceName]['total_price'] += $price;
                                        @endphp
                                        <td>{{ number_format($quantity, 0) }}</td>
                                        <td>{{ number_format($price) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            
                            {{-- แสดงผลรวมของกลุ่มที่ 2 --}}
                            @if ($province->province_id > 12)
                            <tr class="bg-dark">
                                <td colspan="2">รวม ตป.2</td>
                                <td>{{ number_format($group2TotalCount, 0) }}</td>
                                <td>{{ number_format($group2TotalIncome) }}</td>
                                
                                @foreach ($serviceNames as $serviceName)
                                    <td>{{ number_format($group2ServiceTotals[$serviceName]['total_quantity'], 0) }}</td>
                                    <td>{{ number_format($group2ServiceTotals[$serviceName]['total_price']) }}</td>
                                @endforeach
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const serviceNames = [
            'CCTV', 
            'smart pole', 
            'internet wifi', 
            'smart office', 
            'cyber security', 
            'ultimate connect', 
            'บริการอื่นๆ'
        ];
    
        const backgroundColors = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(201, 203, 207, 0.7)'
        ];
    
        const borderColors = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(201, 203, 207, 1)'
        ];
    
        // Directly assign the serviceTotals based on the Blade condition
        @if ($province->province_id <= 12)
        const serviceTotals = @json($group1ServiceTotals);
        @else
        const serviceTotals = @json($group2ServiceTotals);
        @endif
    
        const quantities = serviceNames.map(service => serviceTotals[service].total_quantity);
        const prices = serviceNames.map(service => serviceTotals[service].total_price);
    
        const ctx = document.getElementById('myChart3').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: serviceNames,
                datasets: [
                    {
                        label: 'จำนวนจุดติดตั้ง',
                        data: quantities,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 2,
                        yAxisID: 'y-axis-quantity'
                    },
                    {
                        label: 'รายได้ (บาท)',
                        data: prices,
                        backgroundColor: 'rgba(201, 203, 207, 0.8)',
                        borderColor: 'rgba(201, 203, 207, 1)',
                        borderWidth: 2,
                        yAxisID: 'y-axis-price'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.raw === 0) {
                                    return null;
                                }
    
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.datasetIndex === 0) {
                                    label += context.raw.toLocaleString() + ' จุด';
                                } else {
                                    label += context.raw.toLocaleString() + ' บาท';
                                }
                                return label;
                            }
                        }
                    },
                    datalabels: {
                        color: '#000',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: function(value, context) {
                            return value > 0 ? value.toLocaleString() : '';
                        }
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'ประเภทบริการ',
                            font: {
                                size: 14
                            }
                        }
                    },
                    'y-axis-quantity': {
                        type: 'linear',
                        position: 'left',
                        title: {
                            display: true,
                            text: 'จำนวน (รายการ)',
                            font: {
                                size: 14
                            }
                        },
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                if (value === 0) return '';
                                return value.toLocaleString();
                            }
                        }
                    },
                    'y-axis-price': {
                        type: 'linear',
                        position: 'right',
                        title: {
                            display: true,
                            text: 'รายได้ (บาท)',
                            font: {
                                size: 14
                            }
                        },
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                if (value === 0) return '';
                                if (value >= 1000000) {
                                    return (value / 1000000).toLocaleString() + 'M';
                                } else if (value >= 1000) {
                                    return (value / 1000).toLocaleString() + 'K';
                                }
                                return value.toLocaleString();
                            }
                        },
                        grid: {
                            drawOnChartArea: false
                        },
                    }
                }
            }
        });
    });
    </script>
    

@endsection
