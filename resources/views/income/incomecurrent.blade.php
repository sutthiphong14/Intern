@extends('admins.index')
@section('css')
@endsection
@section('content')
    <section class="content">
        <!-- navigate -->
        <h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">
                <a href="home" class="">
                    หน้าแรก
                </a>
                /
            </span> รายได้รวม</h4>

        <div class="container mt-4">
            <!-- Header Section -->
            <div class="text-center mb-4">
                <h3>รายงานภาพรวมรายได้💵</h3>
                <p>ข้อมูลกราฟแสดงผลรายได้ในรูปแบบต่าง ๆ</p>
            </div>

            <!-- Charts Section -->
            <div class="row">
                <!-- Bar Chart -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card card-dark">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title">รายได้รวม (Bar Chart)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Line Chart -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card card-dark">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title">แนวโน้มรายได้ (Line Chart)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="lineChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card card-dark">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title">สัดส่วนรายได้ (Pie Chart)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Radar Chart -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card card-dark">
                        <div class="card-header bg-danger text-white">
                            <h5 class="card-title">เปรียบเทียบรายได้ (Radar Chart)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="radarChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>







        <div class="card card-dark mt-4">

            <div class="card card-dark ">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title text-dark">รายได้รวม</h5>
                    
            
                     <div>
                    <!-- ฟอร์ม import -->
                    <a href="#" class="btn-fixed-size btn bg-yellow">
                        <i class="fas fa-file-import"></i> Import
                    </a>
                    
                    <!-- ฟอร์ม Export -->
                     <button type="button" class="btn bg-dark btn-fixed-size" >
                        <i class="fas fa-file-export"></i> Export
                    </button>
                </div>
                </div>
                     
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="text-center bg-dark">
                                <tr>
                                    <th>ดูข้อมูล</th>
                                    <th>พื้นที่</th>
                                    <th>เป้าปี 67 </th>
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
                                    <td class ='bg-success'></td>
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
                                    <td class ='bg-success'></td>
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
                                    <td class ='bg-danger'></td>
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
                                    <td class ='bg-warning'></td>
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
                                    <td class ='bg-success'></td>
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




    </section>
@endsection

@section('script')
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>

    <script>
        $(function() {
            // สร้าง Bar Chart
            var barChartCanvas = $('#barChart').get(0).getContext('2d');
            var barChartData = {
                labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ต.ค.', 'พ.ย.',
                'ธ.ค.'], // ป้ายกำกับเดือน
                datasets: [{
                        label: 'รายได้จริง',
                        backgroundColor: 'rgb(60, 179, 113)', // สีสำหรับรายได้
                        borderColor: 'rgb(60, 179, 113)',
                        data: [46.83, 47.6, 48.2, 48.25, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83,
                            46.83,
                        ] // ข้อมูลรายได้
                    },
                    {
                        label: 'เป้าหมาย',
                        backgroundColor: 'rgba(210, 214, 222, 1)', // สีสำหรับเป้าหมาย
                        borderColor: 'rgba(210, 214, 222, 1)',
                        data: [52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34,
                            52.34,
                        ] // ข้อมูลเป้าหมาย
                    }
                ]
            };

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{ // ใช้แบบ yAxes สำหรับ Chart.js 2.x 
                        ticks: {
                            beginAtZero: true // บังคับให้แกน Y เริ่มต้นที่ 0
                        }
                    }]
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return data.datasets[tooltipItem.datasetIndex].label + ': ' + tooltipItem
                                    .yLabel.toLocaleString();
                            }
                        }
                    }
                }
            };



            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });
        });
    </script>

    <script>
        $(function() {
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
            var lineChartData = {
                labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.',
                    'พ.ย.', 'ธ.ค.'
                ],
                datasets: [{
                        label: 'รายได้จริง',
                        backgroundColor: 'rgba(60, 179, 113, 0.2)',
                        borderColor: 'rgb(60, 179, 113)',
                        pointBackgroundColor: 'rgb(60, 179, 113)',
                        data: [4, 47.6, 48.2, 48.25, 46.83, 5.83, 46.83, 46.83, 46.83, 46.83, 1.83,
                            46.83
                        ],
                        fill: true
                    },
                    {
                        label: 'เป้าหมาย',
                        backgroundColor: 'rgba(200, 214, 222, 0.1)',
                        borderColor: 'rgba(310, 214, 222, 1)',
                        pointBackgroundColor: 'rgba(220, 214, 222, 1)',
                        data: [52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34,
                            52.34
                        ],
                        fill: true
                    }
                ]
            };


            var lineChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{ // ใช้แบบ yAxes สำหรับ Chart.js 2.x 
                        ticks: {
                            beginAtZero: true // บังคับให้แกน Y เริ่มต้นที่ 0
                        }
                    }]
                },
            };

            new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            });
        });
    </script>


    <script>
        $(function() {
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieChartData = {
                labels: ['เป้าหมาย', 'รายได้จริง'],
                datasets: [{
                    data: [300, 500, 200],
                    backgroundColor: ['rgb(60, 179, 113)', 'rgba(210, 214, 222, 1)']
                }]
            };

            var pieChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
            };

            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieChartData,
                options: pieChartOptions
            });
        });
    </script>

    <script>
        $(function() {
            var radarChartCanvas = $('#radarChart').get(0).getContext('2d');
            var radarChartData = {
                labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.'],
                datasets: [{
                        label: 'รายได้จริง',
                        backgroundColor: 'rgba(60, 179, 113, 0.2)',
                        borderColor: 'rgb(60, 179, 113)',
                        data: [46.83, 47.6, 48.2, 48.25, 46.83, 46.83]
                    },
                    {
                        label: 'เป้าหมาย',
                        backgroundColor: 'rgba(210, 214, 222, 0.2)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        data: [52.34, 52.34, 52.34, 52.34, 52.34, 52.34]
                    }
                ]
            };

            var radarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                
            };

            new Chart(radarChartCanvas, {
                type: 'radar',
                data: radarChartData,
                options: radarChartOptions
                
            });
        });
    </script>
@endsection
