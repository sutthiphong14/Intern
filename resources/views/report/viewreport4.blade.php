

@extends('admins.index')
@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
@endsection
@section('content')
<section class="content">
    <div class="container-fluid mb-3">

        <div class="col-md-12 mt-3">
            <!-- BAR CHART -->
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">ตรวจแก้ FTTx ภายใน 24 ชม. : จ. บภน.2.1 (กส.)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body">
                <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                </div>


                <div class="card card-dark mt-3">

                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">ติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน เดือนนี้)</h3>
                            <div class="card-tools">
                            <button type="button" class="btn bg-gradient-warning">Export</button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="text-center ">
                                        <tr>
                                            <th rowspan="2" class="col-data">หน่วยงาน</th>
                                            <th rowspan="2" class="col-department">เดือน</th>
                                            <th rowspan="2" class="col-count">จำนวนวงจร</th>
                                            <th rowspan="2" class="col-doc-time">ระยะเวลาเตรียม
                                            เอกสารรวม(วัน)</th>
                                            <th rowspan="2" class="col-process-time">ระยะเวลาดำเนิน
                                            การรวม(วัน)</th>
                                            <th colspan="7">ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร</th>
                                            <th rowspan="2" class="col-total-time">รวมระยะเวลาเฉลี่ย
                                            ที่ใช้ต่อวงจร (วัน)
                                            </th>
                                            <th rowspan="2" class="col-install-count">จำนวนวงจรที่ติดตั้งภายใน 3 วัน
                                            </th>
                                            <th rowspan="2" class="col-install-percent">ร้อยละการติดตั้งภายใน 3 วัน</th>
                                        </tr>
                                        <tr>
                                            <th class="col-sdp">กำหนดSDP/ODP (วัน)</th>
                                            <th class="col-cable">โยงสาย (วัน)</th>
                                            <th class="col-config">Config NMS (วัน)</th>
                                            <th class="col-schedule">นัดหมายและกำหนดช่าง (วัน)</th>
                                            <th class="col-wait-customer">รอลูกค้า (วัน)</th>
                                            <th class="col-install">ลากสายและติดตั้ง ONT (วัน)</th>
                                            <th class="col-close-job">ปิดงาน (วัน)</th>
                                        </tr>
                                    </thead>
                                    <tbody class ='text-center align-items-center'>
                                        <tr>
                                            
                                            <td>ชื่อหน่วยงาน</td>
                                            <td>เดือน</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                            <td>ooo</td>
                                        </tr>
                                      
                                        <!-- เพิ่มข้อมูลอื่น ๆ -->
                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>
                </div>

            

        </div>
        </div>
        </section>
</section>
@endsection

@section('script')

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script>
    // JavaScript ที่ใช้ในการกำหนดสีของหลอดตามเปอร์เซ็นต์
    const bars = document.querySelectorAll('.performance-bar');
    bars.forEach(bar => {
        const width = parseInt(bar.style.width);
        if (width >= 80) {
            bar.classList.add('green');
        } else if (width >= 50) {
            bar.classList.add('yellow');
        } else {
            bar.classList.add('red');
        }
    });
</script>
<script>

    $(function () {
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = {
            labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.','ส.ค.','ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'], // ป้ายกำกับเดือน
            datasets: [
                {
                    label: 'ตรวจแก้ วงจรเช่า',
                    backgroundColor: 'rgb(60, 179, 113)', // สีสำหรับรายได้
                    borderColor: 'rgb(60, 179, 113)',
                    data: [100, 100, 99, 99, 91, 96, 94, 90, 97, 94, 0, 0,] // ข้อมูลรายได้
                },
                
            ]
        };

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + tooltipItem.yLabel.toLocaleString() ;
                    }
                }
            },
            // scales: {
            //     yAxes: [{
            //         ticks: {
            //             beginAtZero: true, // เริ่มจาก 0
            //             callback: function (value) {
            //                 return value.toLocaleString() + ' บาท'; // แสดงตัวเลขแบบมีคอมม่า
            //             }
            //         },
            //         // scaleLabel: {
            //         //     display: true,
            //         //     labelString: 'จำนวนเงิน (บาท)' // ชื่อแกน Y
            //         // }
            //     }],
            //     xAxes: [{
            //         scaleLabel: {
            //             display: true,
            //             labelString: 'เดือน' // ชื่อแกน X
            //         }
            //     }]
            // }
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });
    
</script>
@endsection