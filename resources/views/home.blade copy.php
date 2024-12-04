@extends('admins.index')
@section('title')
    หน้าแรก
@endsection
@section('header')
    หน้าแรก
@endsection
@section('content')
    <section class="py-2 bg-back">
        <div class="container col-12">
            <!-- Bootstrap Carousel -->
            <div class="slide">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="2500">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://orgweb.intra.ntplc.co.th/v003/images/slide/S__31670320.jpg"
                                class="d-block w-100 rounded" alt="Banner 1">
                        </div>
                        <div class="carousel-item">
                            <img src="https://orgweb.intra.ntplc.co.th/v003/images/slide/cg_banner.gif"
                                class="d-block w-100 rounded" alt="Banner 2">
                        </div>
                        <div class="carousel-item">
                            <img src="https://orgweb.intra.ntplc.co.th/v003/images/slide/nt_net_ban.jpg"
                                class="d-block w-100 rounded" alt="Banner 3">
                        </div>
                    </div>
                    <a class="carousel-control-prev custom-control-prev" href="#carouselExampleIndicators" role="button"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next custom-control-next" href="#carouselExampleIndicators" role="button"
                        data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="my-2 ">
        <div class="container col-12">
            <!-- ใช้ตารางสำหรับคำว่า Feed News -->
            <table class="table  bg-warning" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th colspan="2" class="col-12">
                            <h2 class="text-center mb-0 "><i class="far fa-file-alt"></i> Feed News
                            </h2>

                        </th>
                        <th class = 'col-1'>
                            <a href="listnewsfeed" class="btn bg-dark  ">
                                <i class="d-flex justify-content-end "></i> แก้ไข
                            </a>
                        </th>
                    </tr>
                </thead>
            </table>

            <table class="table table-striped table-hover">
                <tbody>
                    @foreach ($data->where('category_id', 1)->take(5) as $item1)
                        <tr class="d-flex justify-content-between">
                            <td class = 'ms-5'>
                                <h5 >
                                {{ $item1->name }}
                                @if ($loop->index < 2)
                                    <!-- เงื่อนไขแสดง "New" แค่ 2 รายการแรก -->
                                    <span class="right badge badge-danger">New</span>
                                @endif
                                </h5>
                            </td>
                            <td><a href="{{ $item1->link }}" class="btn btn-dark" target="_blank">Download <i
                                        class="fas fa-arrow-down"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>

                
            </table>


        </div>
    </section>

    <section class="my-2 p-2 col-12 ">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col-12 mb-1">
                    <div class="performance p-2 bg-back rounded">
                        <h4 class="bg-warning p-4"><i class="fas fa-money-bill-wave"></i> ผลการดำเนินงาน สายงาน ภน.</h4>
                        <ul class="list-unstyled text-dark">
                            @foreach ($data->take(5) as $item2)
                                <li>
                                    <i class="fas fa-tag"></i>
                                    <a href="{{ $item2->link }}" class="text-dark" target="_blank">{{ $item2->name }}</a>
                                    @if ($loop->index < 2)
                                        <!-- แสดง "New" เฉพาะ 2 รายการแรก -->
                                        <span class="right badge badge-danger">New</span>
                                    @endif
                                </li>
                            @endforeach



                        </ul>
                    </div>
                </div>

                <div class="col mb-4">
                    <div class="performanceMk p-2 bg-back pb-4 rounded">
                        <h4 class="bg-warning p-4"><i class="fas fa-signal"></i> ผลการดำเนินงานด้านการตลาด<br>สายงาน ภน.
                        </h4>
                        <ul class="list-unstyled text-dark">
                            @foreach ($data->where('category_id', 3)->take(5) as $item3)
                                <li>
                                    <i class="fas fa-tag"></i>
                                    <a href="{{ $item3->link }}" class="text-dark" target="_blank">{{ $item3->name }}</a>
                                    @if ($loop->index < 2)
                                        <!-- แสดง "New" เฉพาะ 2 รายการแรก -->
                                        <span class="right badge badge-danger">New</span>
                                    @endif
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <div class="col mb-4">
                    <div class="performanceMk p-2 bg-back rounded">
                        <h4 class="bg-warning p-4"><i class="fas fa-check-circle"></i> คุณภาพบริการ</h4>
                        <ul class="list-unstyled text-dark">
                            @foreach ($data->where('category_id', 4)->take(5) as $item4)
                                <li>
                                    <i class="fas fa-tag"></i>
                                    <a href="{{ $item4->link }}" target="_blank" class="text-dark">{{ $item4->name }}</a>
                                    @if ($loop->index < 2)
                                        <!-- แสดง "New" เฉพาะ 2 รายการแรก -->
                                        <span class="right badge badge-danger">New</span>
                                    @endif
                                </li>
                            @endforeach



                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="my-2 ">
        <div class="container-fluid card card-warning ">
            <div class="card-header d-flex justify-content-between align-items-center ">
                <h3 class="card-title col-5">ข้อมูลสถิติ </h3>

                <a href="insertnewsfeed" class="btn bg-success col-2">
                    <i class="d-flex justify-content-end "></i> Edit
                </a>
            </div>
            <div class="row mt-3">
                <div class="col-5">


                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Bar Chart</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart" style="min-height: 250px; max-width: 100%;"></canvas>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
                <div class="col-7">


                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Area Chart</h3>


                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="areaChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>




                </div>
            </div>

    </section>
    <section class="py-2">
        <div class="container">
            <img src="https://orgweb.intra.ntplc.co.th/v003/images/Design/1.jpg" alt=""
                class="d-block w-100 rounded-top">
            <img src="https://orgweb.intra.ntplc.co.th/v003/images/Design/2.jpg" alt="" class="d-block w-100 ">
            <img src="https://orgweb.intra.ntplc.co.th/v003/images/Design/5.jpg" alt=""
                class="d-block w-100 rounded-bottom">

        </div>
    </section>












    <!-- Custom CSS -->
    <style>
        /* ปรับระยะห่างของปุ่มควบคุม */
        .custom-control-prev {
            left: -50px;
            /* เพิ่มระยะห่างจากขอบซ้าย */
        }

        .custom-control-next {
            right: -50px;
            /* เพิ่มระยะห่างจากขอบขวา */
        }
    </style>
@endsection

@section('script')
    <!-- Page specific script -->
    <script>
        $(function() {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.
            var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

            var areaChartData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                        label: 'Digital Goods',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [28, 48, 40, 19, 86, 27, 90]
                    },
                    {
                        label: 'Electronics',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [65, 59, 80, 81, 56, 55, 40]
                    },
                ]
            }

            var areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }]
                }
            }

            // This will get the first returned node in the jQuery collection.
            new Chart(areaChartCanvas, {
                type: 'line',
                data: areaChartData,
                options: areaChartOptions
            })

            //-------------
            //- LINE CHART -
            //--------------
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            var lineChartOptions = $.extend(true, {}, areaChartOptions)
            var lineChartData = $.extend(true, {}, areaChartData)
            lineChartData.datasets[0].fill = false;
            lineChartData.datasets[1].fill = false;
            lineChartOptions.datasetFill = false

            var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            })

            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Chrome',
                    'IE',
                    'FireFox',
                    'Safari',
                    'Opera',
                    'Navigator',
                ],
                datasets: [{
                    data: [700, 500, 400, 600, 300, 100],
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData = donutData;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })

            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            //---------------------
            //- STACKED BAR CHART -
            //---------------------
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
            var stackedBarChartData = $.extend(true, {}, barChartData)

            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
    </script>
@endsection
