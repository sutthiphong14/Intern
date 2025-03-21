@extends('admins.index')
@section('css')
@endsection
@section('content')
    <h4 class="fw-bold py-2 mb-3">
        <span class="text-muted fw-light">
            <a href="{{ route('home') }}" class="">หน้าแรก</a> /
            <a href="{{ route('type_list') }}" class="">ข้อมูลกิจกรรม</a> /
            <a href="javascript:history.back(-2)" class="">จัดการกิจกรรม {{ $types->type_name }}</a> /
            <a href="javascript:history.back()" class="">ส่วนงาน</a> /
        </span>
        จังหวัด {{ $provinces->province_name }}
    </h4>

    <div class="content-wrapper mb-5">
        <!-- Card for ICT solution chart -->
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-chart-line"></i> ICT solution รายได้รวม</h3>
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
                    <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse" data-bs-target="#chart2">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="card-body collapse show" id="chart2">
                    <canvas id="myChart3"
                        style="min-height: 300px; height: 290px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Card for ICT solution chart -->
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-chart-line"></i>จำนวนจุดติดตั้งบริการ ICT Solution</h3>
                    <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse"
                        data-bs-target="#chartservicesQuantityChart">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="card-body collapse show" id="chartservicesQuantityChart">
                    <canvas id="servicesQuantityChart"
                        style="min-height: 300px; height: 290px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

          <!-- Card for ICT solution chart -->
          <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-chart-line"></i>  รายได้บริการ ICT Solution</h3>
                    <button class="btn btn-sm btn-outline-dark" data-bs-toggle="collapse"
                        data-bs-target="#chartservicesIncomeChart">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="card-body collapse show" id="chartservicesIncomeChart">
                    <canvas id="servicesIncomeChart"
                        style="min-height: 300px; height: 290px; max-height: 300px; max-width: 100%;"></canvas>
                </div>
            </div>
        
    </div>




        <div class="card mt-4">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">สรุปผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }} จังหวัด
                    {{ $provinces->province_name }}</h3>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr class="bg-dark text-center">
                                <th rowspan="4">ดูข้อมูล</th>
                                <th rowspan="4">ศูนย์บริการ</th>
                                <th colspan="16">ICT Solution</th>
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
                            @foreach ($centers as $center)
                                <tr>
                                    <td>
                                        <!-- ปรับปรุงปุ่มดูข้อมูล -->
                                        <div class="d-flex flex-column gap-2">
                                            <a href="{{ route('event_serviceDetail_ict', ['center_id' => $center->center_id, 'type_id' => $types->type_id]) }}"
                                                class="btn btn-warning btn-sm d-flex align-items-center justify-content-center">
                                                <i class="fas fa-search me-1"></i>
                                                <span>บริการ ICT</span>
                                            </a>
                                            <a href="{{ route('event_customer_ict', ['center_id' => $center->center_id, 'type_id' => $types->type_id]) }}"
                                                class="btn btn-primary btn-sm d-flex align-items-center justify-content-center">
                                                <i class="fas fa-users me-1"></i>
                                                <span>ข้อมูลลูกค้า</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{ $center->center_name }}</td>
                                    <td>{{ $Ict_count[$center->center_id] ?? 0 }}</td>
                                    <td>{{ number_format($Ict_income[$center->center_id] ?? 0) }}</td>

                                    @foreach ($serviceNames as $serviceName)
                                        @php
                                            $quantity =
                                                $centerSummary[$center->center_id][$serviceName]['total_quantity'] ?? 0;
                                            $price =
                                                $centerSummary[$center->center_id][$serviceName]['total_price'] ?? 0;
                                        @endphp
                                        <td>{{ number_format($quantity, 0) }}</td>
                                        <td>{{ number_format($price) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach

                            <tr class="bg-dark text-light">
                                <td colspan="2">รวม</td>
                                <td>{{ number_format($IctCount + $IctCountOver33, 0) }}</td>
                                <td>{{ number_format($IctIncome + $IctIncomeOver33) }}</td>

                                @php
                                    $serviceTotals = [];
                                    foreach ($serviceNames as $serviceName) {
                                        $serviceTotals[$serviceName] = [
                                            'total_quantity' => 0,
                                            'total_price' => 0,
                                        ];
                                    }

                                    // คำนวณผลรวมแต่ละบริการ
                                    foreach ($centers as $center) {
                                        $centerId = $center->center_id;
                                        if (isset($centerSummary[$centerId])) {
                                            foreach ($serviceNames as $serviceName) {
                                                $serviceTotals[$serviceName]['total_quantity'] +=
                                                    $centerSummary[$centerId][$serviceName]['total_quantity'] ?? 0;
                                                $serviceTotals[$serviceName]['total_price'] +=
                                                    $centerSummary[$centerId][$serviceName]['total_price'] ?? 0;
                                            }
                                        }
                                    }
                                @endphp

                                @foreach ($serviceNames as $serviceName)
                                    <td>{{ number_format($serviceTotals[$serviceName]['total_quantity'], 0) }}</td>
                                    <td>{{ number_format($serviceTotals[$serviceName]['total_price']) }}</td>
                                @endforeach
                            </tr>
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
        var centerNames = [];
        var ictCount = [];
        var ictIncome = [];

        // ข้อมูลจาก PHP
        @foreach ($centers as $center)
            centerNames.push("{{ $center->center_name }}");
            ictCount.push({{ $Ict_count[$center->center_id] ?? 0 }});
            ictIncome.push({{ $Ict_income[$center->center_id] ?? 0 }});
        @endforeach

        // ✅ โหลด Plugin ก่อนใช้
        Chart.register(ChartDataLabels);

        // ✅ สร้างกราฟที่ 2
        var ctx2 = document.getElementById('myChart2').getContext('2d');

        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: centerNames, // ป้ายชื่อที่แสดงในกราฟ
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
            const serviceNames = @json($serviceNames); // รายชื่อบริการ

            // แปลงข้อมูล serviceTotals จาก PHP เป็น JavaScript
            const serviceTotals = @json($serviceTotals);

            // คำนวณจำนวนจุดติดตั้งและรายได้สำหรับแต่ละบริการ
            const quantities = serviceNames.map(service => serviceTotals[service].total_quantity);
            const prices = serviceNames.map(service => serviceTotals[service].total_price);
            const backgroundColors = [
                'rgba(255, 99, 132, 0.7)'
            ];

            const borderColors = [
                'rgba(201, 203, 207, 1)'
            ];

            const ctx = document.getElementById('myChart3').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: serviceNames,
                    datasets: [{
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

    <script>
        // เพิ่มโค้ดนี้ในส่วน script ของไฟล์ blade
        document.addEventListener('DOMContentLoaded', function() {
            // กำหนดชื่อบริการและสีที่จะใช้
            const serviceNames = @json($serviceNames);
            const serviceColors = [
                'rgba(255, 99, 132, 0.7)', // แดง
                'rgba(54, 162, 235, 0.7)', // น้ำเงิน
                'rgba(255, 206, 86, 0.7)', // เหลือง
                'rgba(75, 192, 192, 0.7)', // เขียวฟ้า
                'rgba(153, 102, 255, 0.7)', // ม่วง
                'rgba(255, 159, 64, 0.7)', // ส้ม
                'rgba(201, 203, 207, 0.7)' // เทา
            ];
            const serviceBorders = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(201, 203, 207, 1)'
            ];

            // เตรียมข้อมูลสำหรับกราฟแท่งรวม (Stacked Bar Chart)
            var centerNames = [];
            var serviceData = {};

            // สร้าง dataset สำหรับแต่ละบริการ
            serviceNames.forEach((service, index) => {
                serviceData[service] = {
                    label: service,
                    data: [],
                    backgroundColor: serviceColors[index],
                    borderColor: serviceBorders[index],
                    borderWidth: 1,
                    stack: 'Stack 0' // ทุก service จะซ้อนกันในแต่ละศูนย์
                };
            });

            // ดึงข้อมูลจาก PHP เพื่อกำหนดค่าให้กับแต่ละศูนย์
            @foreach ($centers as $center)
                centerNames.push("{{ $center->center_name }}");

                // เพิ่มข้อมูลบริการแต่ละประเภทสำหรับศูนย์นี้
                @foreach ($serviceNames as $index => $serviceName)
                    // ดึงจำนวนจุดติดตั้ง (quantity) และราคาสำหรับบริการนี้ในศูนย์นี้
                    serviceData['{{ $serviceName }}'].data.push(
                        {{ $centerSummary[$center->center_id][$serviceName]['total_quantity'] ?? 0 }}
                    );
                @endforeach
            @endforeach

            // สร้าง datasets จาก serviceData
            var datasets = Object.values(serviceData);

            // สร้างกราฟแท่งสำหรับจำนวนจุดติดตั้งบริการ ICT
            var ctxQuantity = document.getElementById('servicesQuantityChart').getContext('2d');
            var servicesQuantityChart = new Chart(ctxQuantity, {
                type: 'bar',
                data: {
                    labels: centerNames,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'จำนวนจุดติดตั้งบริการ ICT แยกตามศูนย์',
                            font: {
                                size: 16
                            }
                        },
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.raw !== null && context.raw !== 0) {
                                        label += context.raw.toLocaleString() + ' จุด';
                                    } else {
                                        label += '0 จุด';
                                    }
                                    return label;
                                }
                            }
                        },
                        datalabels: {
                            color: 'white',
                            font: {
                                weight: 'bold'
                            },
                            formatter: function(value, context) {
                                return value > 0 ? value.toLocaleString() : '';
                            },
                            display: function(context) {
                                return context.dataset.data[context.dataIndex] > 0;
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'ศูนย์'
                            }
                        },
                        y: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'จำนวนจุดติดตั้ง'
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // กำหนดชื่อบริการและสีที่จะใช้
            const serviceNames = @json($serviceNames); // ดึงข้อมูล serviceNames จาก PHP
            const serviceColors = [
                'rgba(255, 99, 132, 0.7)', // แดง
                'rgba(54, 162, 235, 0.7)', // น้ำเงิน
                'rgba(255, 206, 86, 0.7)', // เหลือง
                'rgba(75, 192, 192, 0.7)', // เขียวฟ้า
                'rgba(153, 102, 255, 0.7)', // ม่วง
                'rgba(255, 159, 64, 0.7)', // ส้ม
                'rgba(201, 203, 207, 0.7)' // เทา
            ];
            const serviceBorders = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(201, 203, 207, 1)'
            ];

            // เตรียมข้อมูลสำหรับกราฟรายได้แยกตามบริการและศูนย์
            var centerServiceIncome = {};

            // สร้าง dataset สำหรับแต่ละบริการ (รายได้)
            serviceNames.forEach((service, index) => {
                centerServiceIncome[service] = {
                    label: service,
                    data: [],
                    backgroundColor: serviceColors[index],
                    borderColor: serviceBorders[index],
                    borderWidth: 1,
                    stack: 'Stack 0' // ทุก service จะซ้อนกันในแต่ละศูนย์
                };
            });

            // ดึงข้อมูลรายได้จาก PHP
            @foreach ($centers as $center)
                // เพิ่มข้อมูลรายได้บริการแต่ละประเภทสำหรับศูนย์นี้
                @foreach ($serviceNames as $index => $serviceName)
                    // ดึงรายได้ (price) สำหรับบริการนี้ในศูนย์นี้
                    centerServiceIncome['{{ $serviceName }}'].data.push(
                        {{ $centerSummary[$center->center_id][$serviceName]['total_price'] ?? 0 }}
                    );
                @endforeach
            @endforeach

            // สร้าง datasets จาก centerServiceIncome
            var incomeDatasets = Object.values(centerServiceIncome);

            // สร้างกราฟแท่งสำหรับรายได้บริการตามศูนย์
            var ctxIncome = document.getElementById('servicesIncomeChart').getContext('2d');
            var servicesIncomeChart = new Chart(ctxIncome, {
                type: 'bar',
                data: {
                    labels: @json($centers->pluck('center_name')), // ชื่อศูนย์
                    datasets: incomeDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'รายได้บริการ ICT แยกตามศูนย์',
                            font: {
                                size: 16
                            }
                        },
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.raw !== null && context.raw !== 0) {
                                        label += context.raw.toLocaleString() + ' บาท';
                                    } else {
                                        label += '0 บาท';
                                    }
                                    return label;
                                }
                            }
                        },
                        datalabels: {
                            color: 'white',
                            font: {
                                weight: 'bold'
                            },
                            formatter: function(value, context) {
                                if (value === 0) return '0';
                                return value.toLocaleString();
                            },
                            display: function(context) {
                                return context.dataset.data[context.dataIndex] > 0;
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'ศูนย์'
                            }
                        },
                        y: {
                            stacked: true,
                            title: {
                                display: true,
                                text: 'รายได้ (บาท)'
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return (value / 1000000).toLocaleString() + 'M';
                                    } else if (value >= 1000) {
                                        return (value / 1000).toLocaleString() + 'K';
                                    }
                                    return value.toLocaleString();
                                }
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        });
    </script>
@endsection
