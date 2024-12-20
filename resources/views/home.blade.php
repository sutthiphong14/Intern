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
                        <img src={{ asset('/img/banner_images/ceo_intranet.jpg') }}
                            class="d-block w-100 rounded" alt="Banner 1">
                    </div>
                    <div class="carousel-item">
                        <img src={{ asset('/img/banner_images/nt_net_ban.jpg') }}
                            class="d-block w-100 rounded" alt="Banner 2">
                    </div>
                    <div class="carousel-item">
                        <img src={{ asset('/img/banner_images/nt_sta-66.jpg') }}
                            class="d-block w-100 rounded" alt="Banner 3">
                    </div>
                    <div class="carousel-item">
                        <img src={{ asset('/img/banner_images/S__31670320.jpg') }}
                            class="d-block w-100 rounded" alt="Banner 3">
                    </div>
                    <div class="carousel-item">
                        <img src={{ asset('/img/banner_images/S__68780184V2.jpg') }}
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

<div class="col-md-12 mt-3">
    <!-- BAR CHART -->
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">ข่าว</h3>
            <div class="card-tools">
            <a href="newsfeed" class="btn bg-light  ">
                    <i class="d-flex justify-content-end "></i> แสดงเพิ่มเติม
                </a>
            @if(Auth::user()->permission['manage_newsfeed'] ?? false)
                <a href="listnewsfeed" class="btn bg-warning  ">
                    <i class="d-flex justify-content-end "></i> แก้ไขกระดานข่าว
                </a>
            @endif

            </div>
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover align-items-center">

                <tbody class='align-items-center '>
                    @foreach ($data->take(10) as $item1)
                    <tr class=>
                        <td class='ms-5 text-start'>
                            <h5>
                                {{ $item1->name }}
                                @if ($loop->index < 2)
                                    <span class="right badge badge-danger">New</span>
                                @endif
                            </h5>
                        </td>
                        <td class='ms-5 text-center'><a href="{{ $item1->link }}" class="btn btn-warning" target="_blank">Download <i class="fas fa-arrow-down"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>













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
    $(function () {
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