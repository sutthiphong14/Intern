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
    <a href="{{ route('events.list') }}">จัดการกิจกรรม</a> / จัดการรูปภาพกิจกรรม

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
        <div class="image-container" id="image-{{ $image->id }}">
            <img src="{{ asset('storage/' . $image->image_event) }}" alt="Image" class="img-thumbnail">
            <!-- ปุ่มลบที่จะแสดงเมื่อ hover -->
            <button class="delete-btn" data-id="{{ $image->id }}" data-event-id="{{ $event->event_id }}">ลบ</button>
        </div>
    @endforeach
</div>

<!-- เพิ่ม CSS สำหรับการแสดงปุ่มลบ -->
<style>
    .gallery {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* แสดง 4 รูปในแถว */
        gap: 16px; /* ระยะห่างระหว่างรูป */
    }

    .image-container {
        position: relative;
    }

    .gallery img {
        width: 100%;
        height: 200px;
        object-fit: cover;
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
    button.addEventListener('click', function() {
        let imageId = this.getAttribute('data-id');
        let eventId = this.getAttribute('data-event-id');
        let confirmation = confirm('คุณต้องการลบรูปภาพนี้หรือไม่?');

        if (confirmation) {
            fetch(`/events/${eventId}/delete-image/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                // ตรวจสอบสถานะคำตอบของคำขอ
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('เกิดข้อผิดพลาดจากเซิร์ฟเวอร์');
                }
            })
            .then(data => {
                // ถ้าคำขอลบสำเร็จ
                if (data.success) {
                    document.getElementById('image-' + imageId).remove();
                    alert('ลบรูปภาพสำเร็จ!');
                } else {
                    alert(data.message); // แสดงข้อความข้อผิดพลาด
                }
            })
            .catch(error => {
                console.error("❌ เกิดข้อผิดพลาด:", error);
                alert("❌ เกิดข้อผิดพลาด กรุณาลองอีกครั้ง");
            });
        }
    });
});
</script>


@endsection