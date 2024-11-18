@extends('admins.index')
@section('title')
    หน้าแรก
@endsection
@section('header')
    หน้าแรก
@endsection
@section('content')
    <section class="py-4 bg-back">
        <div class="container">
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
        <div class="container">
            <!-- ใช้ตารางสำหรับคำว่า Feed News -->
            <table class="table table-bordered bg-warning" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th colspan="2">
                            <h2 class="text-center mb-0"><i class="far fa-file-alt"></i> Feed News</h2>
                        </th>
                    </tr>
                </thead>
            </table>

            <table class="table table-striped table-hover">
                <tbody>
                    <tr>
                        <td>เลขหมายมีแนวโน้มยกเลิก ปี 2567 ไตรมาสที่ 3 ของ ภน.1 <span
                                class="right badge badge-danger">New</span></td>
                        <td><a type="submit"
                                href="https://orgweb.intra.ntplc.co.th/v003/images/Feednew/Data_Prediction_2024Q3_PN1.xls"
                                class="btn btn-success">Download <i class="fas fa-arrow-down"></i></a></td>
                    </tr>
                    <tr>
                        <td>เลขหมายมีแนวโน้มยกเลิก ปี 2567 ไตรมาสที่ 3 ของ ภน.2 <span
                                class="right badge badge-danger">New</span></td>
                        <td><a type="submit"
                                href="https://orgweb.intra.ntplc.co.th/v003/images/Feednew/Data_Prediction_2024Q3_PN2.xls"
                                class="btn btn-success">Download <i class="fas fa-arrow-down"></i></a></td>
                    </tr>
                    <tr>
                        <td>เลขหมายมีแนวโน้มยกเลิก ปี 2567 ไตรมาสที่ 3 ของ ภน.3 <span
                                class="right badge badge-danger">New</span></td>
                        <td><a type="submit"
                                href="https://orgweb.intra.ntplc.co.th/v003/images/Feednew/Data_Prediction_2024Q3_PN3.xls"
                                class="btn btn-success">Download <i class="fas fa-arrow-down"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="my-2 p-2 ">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col mb-1">
                    <div class="performance p-2 bg-back rounded">
                        <h4 class="bg-warning p-4"><i class="fas fa-money-bill-wave"></i> ผลการดำเนินงาน สายงาน ภน.</h4>
                        <ul class="list-unstyled text-dark">
                            <li><i class="fas fa-tag"></i><a href="#" class="text-dark">ผลการดำเนินงาน เดือน ก.ย. 67</a> <span
                                class="right badge badge-danger">New</span></li>
                            <li><i class="fas fa-tag"></i><a href="#" class="text-dark">สถานภาพกลุ่ม Broadband เดือน ต.ค. 67</a> <span
                                class="right badge badge-danger">New</span></li>
                            <li><i class="fas fa-tag"></i><a href="#" class="text-dark">ประสิทธิภาพการจัดเก็บหนี้ เดือน ก.ย. 67</a> <span
                                class="right badge badge-danger">New</span></li>
                            <li><i class="fas fa-tag"></i><a href="#" class="text-dark">ความคืบหน้า Digital Transformation เดือน ต.ค. 67</a> <span
                                class="right badge badge-danger">New</span></li>
                        </ul>
                    </div>
                </div>
    
                <div class="col mb-4">
                    <div class="performanceMk p-2 bg-back pb-4 rounded">
                        <h4 class="bg-warning p-4"><i class="fas fa-signal"></i> ผลการดำเนินงานด้านการตลาด<br>สายงาน ภน.</h4>
                        <ul class="list-unstyled text-dark">
                            <li><i class="fas fa-tag"></i><a href="#" class="text-dark">ผลการดำเนินงานกลุ่มบริการ SI เดือน ก.ย. 67</a> <span
                                class="right badge badge-danger">New</span></li>
                            <li><i class="fas fa-tag"></i><a href="#" class="text-dark">ผลการดำเนินงานบริการ ICT Solution เดือน ก.ค. 67</a> <span
                                class="right badge badge-danger">New</span></li>
                        </ul>
                    </div>
                </div>
    
                <div class="col mb-4">
                    <div class="performanceMk p-2 bg-back rounded">
                        <h4 class="bg-warning p-4"><i class="fas fa-check-circle"></i> คุณภาพบริการ</h4>
                        <ul class="list-unstyled text-dark">
                            <li><i class="fas fa-tag"></i><a href="#" class="text-dark">คุณภาพบริการ Broadband เดือน ก.ย. 67</a> <span
                                class="right badge badge-danger">New</span></li>
                            <li><i class="fas fa-tag"></i><a href="#" class="text-dark">คุณภาพบริการสื่อสารข้อมูล</a> <span
                                class="right badge badge-danger">New</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-2">
        <div class="container">
            <img src="https://orgweb.intra.ntplc.co.th/v003/images/Design/1.jpg" alt="" class="d-block w-100 rounded-top">
            <img src="https://orgweb.intra.ntplc.co.th/v003/images/Design/2.jpg" alt="" class="d-block w-100 ">
            <img src="https://orgweb.intra.ntplc.co.th/v003/images/Design/5.jpg" alt="" class="d-block w-100 rounded-bottom">
            
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
