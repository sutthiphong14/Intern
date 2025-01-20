@extends('admins.index')
@section('title')
รายการข้อมูล
@endsection
@section('header')
รายการข้อมูล
@endsection
@section('css')
<style>
    .carousel-inner img {
        object-fit: cover;
        width: 100%;
        /* Ensures proper scaling */
        max-height: 400px;
        /* Prevents overflow */
    }

    .carousel-inner img.fixed-size {
        width: 1600px;
        height: 400px;
        object-fit: cover;
        /* Ensures image covers the dimensions without distortion */
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

    .custom-size {
        width: 160px;
        height: 40px;
        object-fit: cover;

    }

    .image-container {
        position: relative;
    }

    .image-number {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(0, 0, 0, 0.6);
        /* พื้นหลังโปร่งแสง */
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        padding: 2px 5px;
        border-radius: 5px;
    }
</style>

@endsection
@section('content')
<h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light"></span>
<a href="{{ route('home') }}" class="">
                หน้าแรก
            </a>
            /
        </span> จัดการ Slideshow</h4>

<div class="content-wrapper">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <!-- หัวข้อ -->
            <h3 class="card-header text-dark">
                จัดการ Slideshow
            </h3>
            
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    ลบ
                </button>


                <!-- Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">ลบสไลด์</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                            <form id="deleteSlideForm" method="POST" action="{{ route('slideshow.destroy', ['id' => 'PLACEHOLDER_ID']) }}">
    @csrf
    @method('DELETE')
    <select id="slideId" name="slideId" class="form-select" onchange="updateSlideDetails()" required>
        <option value="" disabled selected>เลือกสไลด์...</option>
        @foreach ($slideshows as $slideshow)
            <option value="{{ $slideshow->slideshow_id }}"
                data-image="{{ asset('storage/' . $slideshow->slideshow_image) }}"
                data-number="{{ $loop->index + 1 }}">
                ลำดับ {{ $loop->index + 1 }} - {{ $slideshow->slideshow_link }}
            </option>
        @endforeach
    </select>
    <div class="mt-3">
        <img id="selectedSlideImage" src="" alt="Preview" style="display: none; max-width: 100%; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
        <p id="selectedSlideText" style="display: none; margin-top: 10px;"></p>
    </div>
</form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete()">ยืนยันการลบ</button>
                            </div>
                        </div>
                    </div>
                </div>



                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit"
                    onclick="selectSlide(slideshowId)">
                    แก้ไข
                </button>

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
                        @if ($slideshows->isEmpty())
                            <div class="carousel-item active">
                                <img src="{{ asset('storage/slideshow_images/none.png') }}"
                                    class="d-block w-100 rounded fixed-size" alt="Default Banner">
                            </div>
                        @else
                            @foreach ($slideshows as $index => $slideshow)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <a href="{{ $slideshow->slideshow_link }}" target="_blank">
                                        <img src="{{ asset('storage/' . $slideshow->slideshow_image) }}"
                                            class="d-block w-100 rounded fixed-size" alt="Banner {{ $index + 1 }}">
                                    </a>
                                </div>
                            @endforeach
                        @endif

                    </div>

                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="button-container d-flex flex-nowrap justify-content-start gap-2 py-3 overflow-auto">
                            <div class="image-container">
                                @foreach ($slideshows as $slideshow)
                                    <button type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide-to="{{ $loop->index }}" aria-label="Slide {{ $loop->index + 1 }}"
                                        class="p-0 border-0 position-relative"
                                        onclick="selectSlide({{ $slideshow->slideshow_id }})">
                                        <img src="{{ asset('storage/' . $slideshow->slideshow_image) }}"
                                            style="width: 160px; height: 40px;" class="rounded"
                                            alt="Banner {{ $loop->index + 1 }}">
                                        <span class="image-number">{{ $loop->index + 1 }}</span>
                                    </button>
                                @endforeach
                            </div>

                            <button type="button" style="width: 160px; height: 40px;" data-bs-toggle="modal"
                                data-bs-target="#exportModal" class="btn btn-dark flex-shrink-0">
                                เพิ่มหน้า
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="slideshowInfo" style="margin-top: 20px; font-size: 16px;">
                <!-- ข้อมูลของ slideshow ที่จะถูกแสดงที่นี่ -->
            </div>

            <hr>

        </div>

    </div>
</div>

<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('slideshows.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">

                    <h5 class="modal-title" id="exportModalLabel">เพิ่มข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="slideshow_image" class="form-label text-dark">เลือกไฟล์รูปภาพ</label>
                        <input class="form-control" type="file" id="slideshow_image" name="slideshow_image" required>
                    </div>

                    <div class="mb-3">
                        <label for="slideshow_link" class="form-label text-dark">เชื่อม Link ไปยังหน้าอื่น</label>
                        <input type="url" class="form-control" id="slideshow_link" name="slideshow_link"
                            placeholder="กรอก Link">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">ยืนยัน</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">



            <form id="editSlideshowForm"
                action="{{ $slideshows->isNotEmpty() ? route('slideshow.update', ['id' => $selectedSlideshow->slideshow_id ?? $slideshows->first()->slideshow_id]) : '#' }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">แก้ไข</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @if ($slideshows->isNotEmpty())
                        <!-- แสดงภาพแบนเนอร์ที่เลือก -->
                        <div class="mb-3">
                            <img id="imagePreview"
                                src="{{ isset($selectedSlideshow) ? asset('storage/' . $selectedSlideshow->slideshow_image) : asset('storage/' . $slideshows->first()->slideshow_image) }}"
                                style="width: 480px; height: 120px;" class="rounded mt-2">
                            <label for="slideshow_image" class="form-label text-dark">เลือกไฟล์รูปภาพ</label>
                            <input class="form-control" type="file" id="slideshow_image" name="slideshow_image">
                        </div>

                        <!-- ช่องกรอก URL (ลิงก์) -->
                        <div class="mb-3">
                            <label for="slideshow_link" class="form-label text-dark">เชื่อม Link ไปยังหน้าอื่น</label>
                            <input type="url" class="form-control" id="slideshow_link" name="slideshow_link"
                                placeholder="กรอก Link">
                        </div>

                    @else
                        <p>ไม่มีข้อมูลแบนเนอร์ให้เลือก</p>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success" {{ $slideshows->isEmpty() ? 'disabled' : '' }}>ยืนยัน</button>
                </div>
            </form>








        </div>
    </div>
</div>
<div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalScrollableTitle">คู่มือการใช้งานหน้าจัดการรายชื่อผู้ใช้งาน</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body text-dark">
            <h6 style="color: black; font-weight: bold;">
            1.การดูรายการ Slideshow (Read)
          </h6>
          <p>
            • ระบบจะแสดงรายการภาพ Slideshow ทั้งหมดที่มีในระบบ
          </p>
         
          <h6 style="color: black; font-weight: bold;">
            2. การเพิ่มภาพ Slideshow ใหม่ (Create)
          </h6>
          <p>
            • คลิกปุ่ม "เพิ่มหน้า"

          </p>
          <p>
            • เลือกไฟล์ภาพที่ต้องการอัพโหลด 
          </p>
          <p>
            • รองรับไฟล์นามสกุล: .jpg, .jpeg, .png
          </p>
          <p>
            • ขนาดภาพที่แนะนำ: 1600x400 pixels
          </p>
          <p>
            • คลิก "ยืนยัน" เพื่อเพิ่มSlideshow หรือ "ยกเลิก" เมื่อต้องการยกเลิก
          </p>

          
          <h6 style="color: black; font-weight: bold;">
            4.การแก้ไขภาพ Slideshow (Update)
          </h6>
          <p>
            • คลิกปุ่ม "แก้ไข" ที่ภาพต้องการ
          </p>
          <p>
            • อัพโหลดภาพใหม่แทนภาพเดิม
          </p>
          <p>
            • คลิกปุ่ม "บันทึก" เพื่อยืนยันการแก้ไข
          </p>
          <h6 style="color: black; font-weight: bold;">
            3.การลบผู้ใช้งาน (Delete)
          </h6>
          <p>
            • คลิกไอคอนลบ (รูปถังขยะ) ตรงเครื่องมือดำเนินการ
          </p>
          <p>
            • ระบบจะแสดงหน้าต่างยืนยันการลบ
          </p>
          <p>
            • คลิก "ยืนยัน" เพื่อลบผู้ใช้งาน หรือ "ยกเลิก" เพื่อยกเลิกการลบ
          </p>
          <h6 style="color: black; font-weight: bold;">
            คุณสมบัติเพิ่มเติม
          </h6>
          <p>
            • ระบบจะบันทึกประวัติการดำเนินการ (Audit Log)
          </p>
          <p>
            •มีระบบการแจ้งเตือนเมื่อดำเนินการสำเร็จหรือเกิดข้อผิดพลาด
          </p>
          <p>
            • รองรับการทำงานแบบ Responsive บนอุปกรณ์ทุกขนาดหน้าจอ
          </p>
          <h6 style="color: red;font-weight: bold;">
            ข้อควรระวัง
          </h6>
          
          <p>
            • การลบภาพไม่สามารถเรียกคืนได้
          </p>
          <p>
            • ควรตรวจสอบขนาดและคุณภาพของภาพก่อนอัพโหลด
          </p>
          <p>
            • ภาพที่อัพโหลดควรมีสัดส่วนที่เหมาะสมกับพื้นที่แสดงผล
          </p>
          <p>
            • ภาพที่อัพโหลดควรมีสัดส่วนที่เหมาะสมกับพื้นที่แสดงผล
          </p>
          <p>
            • ตรวจสอบนามสกุลไฟล์ทุกครั้งก่อนอัปโหลดภาพ
          </p>
          <p>
            • ควรใช้ภาพที่มีความคมชัดสูง
          </p>
          
          
          
          
          
        </div>

      </div>
    </div>
  </div>





<script>

    // ตัวอย่างการเปิด modal ด้วย JavaScript
    $(document).ready(function () {
        $('#exportModal').modal('show');
    });


    // เมื่อเลือกแบนเนอร์
    let selectedSlideId = null; // ตัวแปรสำหรับเก็บ ID ของสไลด์ที่เลือก

    function selectSlide(slideshowId) {
        selectedSlideId = slideshowId; // ตั้งค่า ID ของสไลด์ที่เลือก
        let slideshow = @json($slideshows);

        if (!Array.isArray(slideshow) || slideshow.length === 0) {
            console.log("ไม่มีข้อมูลแบนเนอร์");
            return;
        }

        let selectedSlideshow = slideshow.find(slide => slide.slideshow_id === slideshowId);

        if (selectedSlideshow) {
            let form = document.getElementById('editSlideshowForm');
            form.action = "/slideshow/" + selectedSlideshow.slideshow_id;

            let imagePreview = document.getElementById('imagePreview');
            imagePreview.style.display = 'block';
            imagePreview.src = '/storage/' + selectedSlideshow.slideshow_image;

            document.getElementById('slideshow_link').value = selectedSlideshow.slideshow_link;
        } else {
            console.log("ไม่พบแบนเนอร์ที่เลือก");
        }
    }

    // ฟังก์ชันนี้จะทำให้ข้อมูลแรกแสดงเมื่อเริ่มต้น
    window.onload = function () {
        // ตรวจสอบว่า $slideshows มีข้อมูลหรือไม่ก่อนเรียกฟังก์ชัน selectSlide
        @if($slideshows->isNotEmpty())
            selectSlide({{ $slideshows->first()->slideshow_id }});
        @else
            console.log("ไม่มีข้อมูลแบนเนอร์");
        @endif
    };




    function deleteSlide(slideshowId) {
        if (confirm('คุณต้องการลบสไลด์นี้หรือไม่?')) {
            fetch(`/slideshow/${slideshowId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
                .then(response => {
                    if (!response.ok) throw new Error('Failed to delete slideshow.');
                    return response.json();
                })
                .then(data => {
                    alert(data.message || 'ลบสำเร็จ');
                    location.reload();
                })
                .catch(error => console.error('Error deleting slideshow:', error));
        }
    }

    function updateSlideDetails() {
    const slideSelect = document.getElementById('slideId');
    const selectedOption = slideSelect.options[slideSelect.selectedIndex];

    if (selectedOption.value) {
        // ดึงข้อมูลรูปภาพและลำดับจาก data-attribute
        const imageSrc = selectedOption.getAttribute('data-image');
        const slideNumber = selectedOption.getAttribute('data-number');

        // แสดงข้อมูลในฟอร์ม
        const slideImage = document.getElementById('selectedSlideImage');
        const slideText = document.getElementById('selectedSlideText');

        slideImage.src = imageSrc;
        slideImage.style.display = 'block';
        slideText.textContent = `ลำดับ: ${slideNumber}`;
        slideText.style.display = 'block';
    } else {
        // ซ่อนข้อมูลถ้ายังไม่ได้เลือก
        document.getElementById('selectedSlideImage').style.display = 'none';
        document.getElementById('selectedSlideText').style.display = 'none';
    }
}

    function confirmDelete() {
        const slideSelect = document.getElementById('slideId');
        if (!slideSelect.value) {
            alert('กรุณาเลือกรายการที่ต้องการลบ');
            return;
        }

        const slideshowId = slideSelect.value; // Get selected slideshow ID
        fetch(`/slideshow/${slideshowId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'ลบสำเร็จ');
                location.reload(); // Reload page to reflect changes
            })
            .catch(error => console.error('Error:', error));
    }


</script>

@endsection