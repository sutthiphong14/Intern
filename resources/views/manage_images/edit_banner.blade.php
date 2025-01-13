@extends('admins.index')
@section('title')
รายการข้อมูล
@endsection
@section('header')
รายการข้อมูล
@endsection
@section('css')
<style>
    .content-wrapper .card {
        overflow: hidden;
        /* ซ่อนเนื้อหาที่เกินขอบ */
    }

    #carouselExampleIndicators {
        width: 100%;
        /* ให้ Carousel มีความกว้างเต็มของ Card */
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
        /* ปรับขนาดของปุ่มให้เหมาะสม */
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5);
        /* เพิ่มพื้นหลังให้ไอคอนปุ่ม */
        border-radius: 50%;
        /* ทำให้ปุ่มเป็นทรงกลม */
    }

    .button-container {
        max-width: 100%;
        margin: auto;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .button-container button img {
        width: 100%;
        /* ให้ขนาดปุ่มปรับตาม Container */
        max-width: 160px;
        /* กำหนดขนาดสูงสุด */
        height: 40px;
    }

    @media (max-width: 768px) {
        .button-container button img {
            max-width: 120px;
            height: 30px;
        }
    }

    @media (max-width: 480px) {
        .button-container button img {
            max-width: 100px;
            height: 25px;
        }
    }
</style>

@endsection
@section('content')
<div class="content-wrapper">
    <div class="card mb-1">
    <div class="d-flex justify-content-between align-items-center gap-2">
            <!-- หัวข้อ -->
            <h5 class="card-header text-dark">
                จัดการ Slideshow
            </h5>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn bg-dark btn-fixed-size" data-toggle="modal" data-target="#exportModal">
                    <i class="fas fa-file-export"></i> Export
                </button>

                <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                    <i class="fas fa-question-circle"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
        <div class="slide">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-interval="500">

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('/img/banner_images/1.png') }}" class="d-block w-100 rounded" alt="Banner 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('/img/banner_images/2.png') }}" class="d-block w-100 rounded" alt="Banner 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('/img/banner_images/3.png') }}" class="d-block w-100 rounded" alt="Banner 3">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('/img/banner_images/4.png') }}" class="d-block w-100 rounded" alt="Banner 4">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('/img/banner_images/5.png') }}" class="d-block w-100 rounded" alt="Banner 5">
                    </div>
                </div>

            </div>

        </div>



    </div>








    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="button-container d-flex flex-nowrap justify-content-start gap-2 py-3 overflow-auto">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        aria-label="Slide 1" class="p-0 border-0">
                        <img src="{{ asset('/img/banner_images/1.png') }}" style="width: 160px; height: 40px;"
                            class="rounded" alt="Banner 1">
                    </button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2" class="p-0 border-0">
                        <img src="{{ asset('/img/banner_images/2.png') }}" style="width: 160px; height: 40px;"
                            class="rounded" alt="Banner 2">
                    </button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3" class="p-0 border-0">
                        <img src="{{ asset('/img/banner_images/3.png') }}" style="width: 160px; height: 40px;"
                            class="rounded" alt="Banner 3">
                    </button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                        aria-label="Slide 4" class="p-0 border-0">
                        <img src="{{ asset('/img/banner_images/4.png') }}" style="width: 160px; height: 40px;"
                            class="rounded" alt="Banner 4">
                    </button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"
                        aria-label="Slide 5" class="p-0 border-0">
                        <img src="{{ asset('/img/banner_images/5.png') }}" style="width: 160px; height: 40px;"
                            class="rounded" alt="Banner 5">
                    </button>
                    <button type="button" style="width: 160px; height: 40px;" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5"
                        aria-label="Slide 6" class="p-0 border-0 bg-dark" >
                        +
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>

</div>



@endsection