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
            <h3 class="card-header text-dark">อัลบั้ม {{ $event->nameevent }}</h3>
            <div class="d-flex align-items-center gap-2">
                <!-- ปุ่มสำหรับอัปโหลดรูปภาพ -->
                <form action="{{ route('upload_image_event', ['event_id' => $event->event_id]) }}" method="POST"
                    enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                    @csrf
                    <div class="form-group mb-0">

                        <input type="file" name="image_event[]" id="image_event" class="form-control" multiple required
                            style="width: 300px;">
                    </div>
                    <button type="submit" class="btn btn-success me-1">อัปโหลดรูปภาพ</button>
                </form>
                <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                    data-bs-target="#modalScrollable">
                    <i class="fas fa-question-circle"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
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

<div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScrollableTitle">คำอธิบายข้อมูล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
                <p>
                    รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                    หน้าหลัก รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                </p>
                <p>
                    หมายเหตุ : รายงานระยะเวลาเฉลี่ยในการติดตั้ง ตามศูนย์บริการติดตั้ง
                </p>
                <p>
                    • จำนวนวงจร : จะนับเฉพาะใบคำขอที่ทำการปิดงานเรียบร้อยบนระบบ FTTxSM เท่านั้น (ไม่รวมข้อมูลใบคำขอที
                    import มาจากสผ.และใบคำขอที่ยังไม่เคยปิดงานเรียบร้อย) ตามช่วงเวลาที่เลือก
                </p>
                <p>
                    • ระยะเวลาเตรียมข้อมูลรวม : ยอดรวมระยะเวลาที่ใช้ในเตรียมเอกสารของวงจรตามช่วงเวลาที่เลือก
                    โดยนับระยะเวลาตั้งแต่วันที่สร้างคำขอ - รับชำระเงิน
                </p>
                <p>
                    • ระยะเวลาดำเนินการรวม : ยอดรวมระยะเวลาที่ใช้ในการติดตั้งของวงจรตามช่วงเวลาที่เลือก
                    โดยนับระยะเวลาตั้งแต่รับชำระเงิน - ปิดงานเรียบร้อย ยกเว้น ช่วงรอลูกค้า
                </p>
                <p>
                    • ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร :

                </p>
                <p>
                    - กำหนดSDP/ODP :
                </p>
                <p>
                    >> กรณีส่งงานโยงสายถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงานโยงสาย หารด้วย จำนวนวงจร
                    (ช่องที่ 1)
                </p>
                <p>
                    >> กรณีส่งงานNMSถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงาน NMS หารด้วย จำนวนวงจร
                    (ช่องที่ 1)
                </p>
                <p>
                    - โยงสาย (ถ้าส่งงาน) : ยอดรวมจำนวนวัน นับจากวันที่ส่งงานโยงสายจนถึงส่งงาน NMS หารด้วย จำนวนวงจร
                    (ช่องที่ 1)
                </p>
                <p>
                    - การดำเนินการของ NMS, นัดหมายและกำหนดช่าง, ปิดงาน : ยอดรวมจำนวนวัน
                    นับจากวันที่รับงานมาดำเนินการจนถึงวันที่จ่ายงานให้งานถัดไป หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    - รอลูกค้า :
                </p>
                <p>
                    >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                    นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่ติดตั้ง หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                    นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่นัดหมายลูกค้า หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    - ลากสายและติดตั้ง :
                </p>
                <p>
                    >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน นับจากวันที่ติดตั้งจนถึงวันที่ส่งงานปิดงาน
                    หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                    นับจากวันที่วันนัดหมายลูกค้าจนถึงวันที่ส่งงานปิดงาน หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    • รวมระยะเวลาเฉลี่ยที่ใช้ต่อวงจร : ระยะเวลารวม (ช่องที่ 3) หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    • ร้อยละการติดตั้งภายใน 3 วัน : ร้อยละการปิดงานเรียบร้อยภายใน 3 วัน(รับชำระเงิน - ปิดงานเรียบร้อย
                    ยกเว้นช่วงรอลูกค้า) เมื่อเทียบกับ จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    • กรณีมีการติดตั้งวงจร แต่ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจรเท่ากับ 0.00 :
                    ใช้ระยะเวลาในการดำเนินการเป็นระดับวินาที จึงไม่สามารถแสดงตัวเลขได้
                </p>
                <p>
                    • รายงานเดือนตุลา ที่มีตัวเลขติดลบในบางพื้นที่ ทางระบบกำลังดำเนินการตรวจสอบและแก้ไขค่ะ
                    เนื่องจากมีการเลือกวันที่ติดตั้งและส่งงานไม่ถูกต้อง
                </p>
            </div>

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