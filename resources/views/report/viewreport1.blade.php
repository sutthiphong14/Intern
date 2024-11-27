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
    <div class="container-fluid">
        
            <div class="col-md-12 mt-3">
                <!-- BAR CHART -->
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">รายได้รวม</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
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
                                            <th>ดูข้อมูล</th>
                                            <th>พื้นที่</th>
                                            <th>เป้าปี 67	</th>
                                            <th>เป้าเดือน 67</th>
                                            <th>รายได้รวม</th>
                                            <th>รายได้เทียบเป้าปี</th>
                                            <th>รายได้เทียบเป้า9เดือน</th>
                                            <th>ม.ค.</th>
                                            <th>ก.พ.</th>
                                            <th>มี.ค.</th>
                                            <th>เม.ย.</th>
                                            <th>พ.ค.</th>
                                            <th>มิ.ย.</th>
                                            <th>ก.ค.</th>
                                            <th>ส.ค.</th>
                                            <th>ก.ย.</th>
                                            <th>พ.ย.</th>
                                            <th>ธ.ค.</th>
                                        </tr>
                                     
                                    </thead>
                                    <tbody class ='text-center align-items-center'>
                                        <tr>
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>กาฬสินธุ์</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>ขอนแก่น</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>มหาสารคาม</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>ร้อยเอ็ด</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-info btn-warning"><i
                                                        class="fas fa-search"></i></button></td>
                                            <td>ภน.2.1</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
@endsection

@section('script')
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<script>
    $(function () {
        // สร้าง Bar Chart
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = {
            labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'], // ป้ายกำกับเดือน
            datasets: [
                {
                    label: 'รายได้จริง',
                    backgroundColor: 'rgb(60, 179, 113)', // สีสำหรับรายได้
                    borderColor: 'rgb(60, 179, 113)',
                    data: [46.83, 47.6,48.2,48.25,46.83,46.83,46.83,46.83,46.83,46.83,46.83,46.83,] // ข้อมูลรายได้
                },
                {
                    label: 'เป้าหมาย',
                    backgroundColor: 'rgba(210, 214, 222, 1)', // สีสำหรับเป้าหมาย
                    borderColor: 'rgba(210, 214, 222, 1)',
                    data: [52.34,52.34,52.34,52.34,52.34,52.34,52.34,52.34,52.34,52.34,52.34,52.34,] // ข้อมูลเป้าหมาย
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
