@extends('admins.index')
@section('title')
รายการข้อมูล
@endsection
@section('header')
รายการข้อมูล
@endsection
@section('css')
<style>
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
    <div class="card">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <!-- หัวข้อ -->
            <h3 class="card-header text-dark">
                จัดการ Slideshow
            </h3>
            <div class="d-flex align-items-center gap-2">

                <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                    data-bs-target="#modalScrollable">
                    <i class="fas fa-question-circle"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="slide">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-pause="true"
                    data-bs-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('/img/banner_images/1.png') }}" class="d-block w-100 rounded"
                                alt="Banner 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('/img/banner_images/2.png') }}" class="d-block w-100 rounded"
                                alt="Banner 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('/img/banner_images/3.png') }}" class="d-block w-100 rounded"
                                alt="Banner 3">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('/img/banner_images/4.png') }}" class="d-block w-100 rounded"
                                alt="Banner 4">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('/img/banner_images/5.png') }}" class="d-block w-100 rounded"
                                alt="Banner 5">
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
                            <button type="button" style="width: 160px; height: 40px;" data-toggle="modal"
                                data-target="#exportModal" class="p-0 border-0 bg-dark">
                                +
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <label for="" class="form-label text-dark">เลือกไฟล์รูปภาพ</label>
                <input class="form-control" type="file" id="import_file" name="import_file">
            </div>

            <div class="mb-3">
                <label for="" class="form-label text-dark">เชื่อม Link ไปยังหน้าอื่น</label>
                <input type="text" class="form-control" id="" name="" placeholder="กรอก Link" required value="">
            </div>
            <div class="card-footer align-items-center text-center">
                <button type="button" class="btn btn-danger" onclick="">ลบ</button>
                <button type="submit" class="btn btn-success">แก้ไข</button>
            </div>







        </div>

    </div>
</div>






<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">เพิ่มข้อมูล</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label text-dark">เลือกไฟล์รูปภาพ</label>
                    <input class="form-control" type="file" id="import_file" name="import_file">
                </div>

                <div class="mb-3">
                    <label for="" class="form-label text-dark">เชื่อม Link ไปยังหน้าอื่น</label>
                    <input type="text" class="form-control" id="" name="" placeholder="กรอก Link" required value="">
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-success" id="confirmExport" disabled>ยืนยัน</button>
            </div>
            </form>

        </div>
    </div>
</div>

@endsection




@if(isset($slideshow) && $slideshow->id)
<form id="editSlideshowForm" action="{{ route('slideshow.update', ['id' => $slideshow->id]) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')


    <div class="modal-header">
        <h5 class="modal-title" id="exportModalLabel">แก้ไข</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="slideshow_image" class="form-label text-dark">เลือกไฟล์รูปภาพ</label>
            <input class="form-control" type="file" id="slideshow_image" name="slideshow_image">
            <!-- Optional Image Preview -->
            <img id="imagePreview" style="width: 160px; height: 40px; display: none;" class="rounded mt-2">
        </div>

        <div class="mb-3">
            <label for="slideshow_link" class="form-label text-dark">เชื่อม Link ไปยังหน้าอื่น</label>
            <input type="url" class="form-control" id="slideshow_link" name="slideshow_link" placeholder="กรอก Link"
                required>
        </div>

        <div class="mb-3">
            <label for="slideshow_status" class="form-label text-dark">สถานะ</label>
            <select class="form-select" id="slideshow_status" name="slideshow_status" required>
                <option value="1">เปิดใช้งาน</option>
                <option value="0">ปิดใช้งาน</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <button type="submit" class="btn btn-success">ยืนยัน</button>
    </div>
</form>
@else
<form id="editSlideshowForm" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Fields -->
</form>
@endif