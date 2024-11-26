

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
                    <h3 class="card-title">ติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน เดือนนี้)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover align-items-center">
                        <thead class='text-center col-12'>
                            <tr>
                                <th class='col-3 '>พื้นที่</th>
                                <th class='col-3'>ระดับ</th>
                                <th class='col-4'>Performance (%)</th>
                            </tr>
                        </thead>
                        <tbody class = 'align-items-center text-center'>
                            <tr>
                                <td>กาฬสินธุ์</td>
                                <td><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"></i></td>
                                <td>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="20"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 85%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ขอนแก่น</td>
                                <td><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"></i></td>
                                <td>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="20"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>มหาสารคาม</td>
                                <td><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i class="fas fa-star text-info"><i class="fas fa-star text-info"></i></td>
                                <td>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="20"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ร้อยเอ็ด</td>
                                <td><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i></td>
                                <td>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="20"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ภน.2.1</td>
                                <td><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i class="fas fa-star text-info"><i class="fas fa-star text-info"><i class="fas fa-star text-info"></i></td>
                                <td>
                                    <div class="progress mb-3">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="20"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>


                <div class="card card-dark mt-3">

                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">ติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน เดือนนี้)</h3>
                            <div class="card-tools">
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
                                            <th rowspan="2" class="col-data">ดูข้อมูล</th>
                                            <th rowspan="2" class="col-department">ส่วนงาน</th>
                                            <th rowspan="2" class="col-count">จำนวนวงจร</th>
                                            <th rowspan="2" class="col-doc-time">ระยะเวลาเตรียมเอกสารรวม (วัน)</th>
                                            <th rowspan="2" class="col-process-time">ระยะเวลาดำเนินการรวม (วัน)</th>
                                            <th colspan="7">ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร</th>
                                            <th rowspan="2" class="col-total-time">รวมระยะเวลาเฉลี่ยที่ใช้ต่อวงจร (วัน)
                                            </th>
                                            <th rowspan="2" class="col-install-count">จำนวนวงจรที่ติดตั้งภายใน 3 วัน
                                            </th>
                                            <th rowspan="2" class="col-install-percent">ร้อยละการติดตั้งภายใน 3 วัน</th>
                                        </tr>
                                        <tr>
                                            <th class="col-sdp">กำหนด SDP/ODP (วัน)</th>
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
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>กาฬสินธุ์</td>
                                            <td>10</td>
                                            <td>3</td>
                                            <td>5</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>9</td>
                                            <td>5</td>
                                            <td>50%</td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>ขอนแก่น</td>
                                            <td>10</td>
                                            <td>3</td>
                                            <td>5</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>9</td>
                                            <td>5</td>
                                            <td>50%</td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>มหาสารคาม</td>
                                            <td>10</td>
                                            <td>3</td>
                                            <td>5</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>9</td>
                                            <td>5</td>
                                            <td>50%</td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>ร้อยเอ็ด</td>
                                            <td>10</td>
                                            <td>3</td>
                                            <td>5</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>9</td>
                                            <td>5</td>
                                            <td>50%</td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>ภน.2.1</td>
                                            <td>10</td>
                                            <td>3</td>
                                            <td>5</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>9</td>
                                            <td>5</td>
                                            <td>50%</td>
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
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
            labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'], // ป้ายกำกับเดือน
            datasets: [
                {
                    label: 'รายได้จริง',
                    backgroundColor: 'rgb(60, 179, 113)', // สีสำหรับรายได้
                    borderColor: 'rgb(60, 179, 113)',
                    data: [46.83, 47.6, 48.2, 48.25, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83,] // ข้อมูลรายได้
                },
                {
                    label: 'เป้าหมาย',
                    backgroundColor: 'rgba(210, 214, 222, 1)', // สีสำหรับเป้าหมาย
                    borderColor: 'rgba(210, 214, 222, 1)',
                    data: [52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34,] // ข้อมูลเป้าหมาย
                }
            ]
        };

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + tooltipItem.yLabel.toLocaleString() + ' บาท';
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