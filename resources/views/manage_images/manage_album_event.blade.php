@extends('admins.index')
@section('title')
รายการข้อมูล
@endsection

@section('header')
รายการข้อมูล
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<h4 class="fw-bold py-2 mb-3">
<a href="{{ route('home') }}">หน้าแรก</a> / <a href="{{ route('events.list') }}">รายการอัลบั้มกิจกรรม</a> / จัดการรูปภาพในอัลบั้ม

</h4>


<div class="content-wrapper">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <h3 class="card-header text-dark">อัลบั้มเก็บรูปภาพของกิจกรรม {{ $event->nameevent }}</h3>
            <div class="d-flex align-items-center gap-2">
                <!-- ปุ่มสำหรับอัปโหลดรูปภาพ -->
                <form action="{{ route('upload_image_event', ['event_id' => $event->event_id]) }}" method="POST"
                    enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                    @csrf
                    <div class="form-group mb-0">

                        <input type="file" name="image_event[]" id="image_event" class="form-control" multiple required
                            style="width: 300px;">
                    </div>
                    <button type="submit" class="btn btn-success me-4">อัปโหลดรูปภาพ</button>
                </form>
            </div>
        </div>
        <div class="card-body">





            <!-- แสดงรูปภาพที่เกี่ยวข้องกับกิจกรรม -->
            <!-- แสดงรูปภาพที่เกี่ยวข้องกับกิจกรรม -->
            <div class="gallery">
                @foreach($images as $image)
                    <div class="image-container" id="image-{{ $image->image_id }}">
                        <img src="{{ asset('storage/' . $image->image_event) }}" alt="Image" class="img-thumbnail">
                        <button class="delete-btn" data-id="{{ $image->image_id }}"
                            data-event-id="{{ $event->event_id }}">ลบ</button>
                    </div>

                @endforeach

            </div>

            <!-- เพิ่ม CSS สำหรับการแสดงปุ่มลบ -->
            <style>
                .gallery {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    /* แสดง 4 รูปในแถว */
                    gap: 16px;
                    /* ระยะห่างระหว่างรูป */
                }

                .image-container {
                    position: relative;
                }

                .gallery img {
                    width: 100%;

                    object-fit: cover;
                    border-radius: 10px;
                }

                /* ปุ่มลบจะถูกซ่อนจนกว่าจะมีการ hover */
                .delete-btn {
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    background-color: red;
                    color: white;
                    border: none;
                    padding: 5px 10px;
                    cursor: pointer;
                    display: none;
                    border-radius: 10px; /* ปรับค่าความโค้งของขอบ */
                }

                /* เมื่อ hover บนรูปภาพ ปุ่มลบจะแสดง */
                .image-container:hover .delete-btn {
                    display: block;
                }
            </style>




        </div>
    </div>
</div>


<!-- เพิ่ม JavaScript สำหรับการลบภาพ -->
<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
        let imageId = this.getAttribute('data-id');
        let eventId = this.getAttribute('data-event-id');

        console.log("📢 กำลังลบรูป ID:", imageId, "จากกิจกรรม ID:", eventId);

        if (!imageId) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: 'ไม่พบค่า image_id ที่ส่งไป',
            });
            return;
        }

        // ใช้ SweetAlert2 แทน confirm
        Swal.fire({
    title: 'คุณแน่ใจหรือไม่?',
    text: "คุณต้องการลบรูปภาพนี้หรือไม่?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'ลบรูปภาพ',
    cancelButtonText: 'ยกเลิก',
    reverseButtons: true,
    customClass: {
        confirmButton: 'btn btn-success',  // ปรับสีปุ่มยืนยันเป็นสีเขียว
        cancelButton: 'btn btn-danger'     // ปรับสีปุ่มยกเลิกเป็นสีแดง
    }
}).then((result) => {
    if (result.isConfirmed) {
        fetch(`/events/${eventId}/delete-image/${imageId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('❌ เซิร์ฟเวอร์ส่งกลับข้อผิดพลาด');
                }
                return response.json();
            })
            .then(data => {
                console.log("📢 Response Data:", data);
                if (data.success) {
                    // 🛠 ลบรูปออกจาก DOM ทันที
                    let imageElement = document.getElementById('image-' + imageId);
                    if (imageElement) {
                        imageElement.remove();
                    }
                    // ใช้ SweetAlert2 แจ้งเตือน
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบรูปภาพสำเร็จ!',
                        text: 'รูปภาพได้ถูกลบออกจากอัลบั้ม',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: data.message,
                    });
                }
            })
            .catch(error => {
                console.error("❌ Fetch Error:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'เกิดข้อผิดพลาด กรุณาลองอีกครั้ง',
                });
            });
    }
});

    });
});

</script>


@endsection