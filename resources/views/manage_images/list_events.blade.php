@extends('admins.index')
@section('title')
รายการข้อมูล
@endsection

@section('header')
รายการข้อมูล
@endsection

@section('css')
<style>
    /* กำหนดความสูงของ modal ให้เล็กลง */
    #editEventModal .modal-dialog {
        max-width: 400px;
        /* ปรับความกว้างของ modal */
        height: auto;
        /* ความสูงปรับตามเนื้อหา */
    }

    #editEventModal .modal-content {
        height: auto;
        /* ความสูงของ content ปรับตามเนื้อหาภายใน */
    }

    /* กำหนดความสูงของ modal ให้เล็กลง */
    #addEventModal .modal-dialog {
        max-width: 400px;
        /* ปรับความกว้างของ modal */
        height: auto;
        /* ความสูงปรับตามเนื้อหา */
    }

    #addEventModal .modal-content {
        height: auto;
        /* ความสูงของ content ปรับตามเนื้อหาภายใน */
    }

    
</style>


@endsection

@section('content')
<h4 class="fw-bold py-2 mb-3">
    <a href="{{ route('home') }}">หน้าแรก</a> / จัดการกิจกรรม
</h4>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<div class="content-wrapper">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <h3 class="card-header text-dark">จัดการอัลบั้มกิจกรรม</h3>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-success me-4" data-bs-toggle="modal"
                    data-bs-target="#addEventModal">
                    เพิ่มกิจกรรม
                </button>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-striped col-12">
                <thead>
                    <tr class='bg-dark text-center'>

                        <th class='7'>ชื่อกิจกรรม</th>
                        <th class='1'>สถานะ</th>
                        <th class='4'>Action</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($events as $key => $event)
        <tr class="text-center" id="event-{{ $event->event_id }}">

            <td>{{ $event->nameevent }}</td>
            <td><span class="status-label" data-id="{{ $event->event_id }}">
                    {{ $event->status == 'show' ? 'แสดง' : 'ไม่แสดง' }}
                </span></td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item edit-event" data-id="{{ $event->event_id }}"
                            data-name="{{ $event->nameevent }}">
                            <i class="bx bx-edit-alt me-1"></i> แก้ไข
                        </button>
                        <button class="dropdown-item toggle-status" data-id="{{ $event->event_id }}">
                            เปลี่ยนสถานะ
                        </button>

                        <button type="button" class="dropdown-item text-danger delete-event"
                            data-id="{{ $event->event_id }}">
                            <i class="bx bx-trash me-1"></i> ลบ
                        </button>

                        <!-- ปุ่มจัดการรูปภาพ -->
                        <a href="{{ route('manage_album_event', ['event_id' => $event->event_id]) }}"
                            class="dropdown-item">
                            <i class="bx bx-image me-1"></i> จัดการรูปภาพ
                        </a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal สำหรับเพิ่มกิจกรรม -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">เพิ่มกิจกรรม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEventForm" method="POST" action="{{ route('events.store') }}">
                    @csrf
                    <input type="text" class="form-control" name="nameevent" required>
                    <button class ='btn bg-success mt-3' type="submit">เพิ่มกิจกรรม</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal สำหรับแก้ไขชื่อกิจกรรม -->
<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEventModalLabel">แก้ไขชื่อกิจกรรม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="event_id" id="event_id">
                    <div class="mb-3">
                        <label for="nameevent" class="form-label">ชื่อกิจกรรม</label>
                        <input type="text" class="form-control" name="nameevent" id="nameevent" required>
                    </div>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $(".delete-event").on("click", function () {
            let eventId = $(this).data("id");
            let confirmation = confirm("คุณต้องการลบกิจกรรมนี้ใช่หรือไม่?");

            if (confirmation) {
                $.ajax({
                    url: "/events/" + eventId,  // URL ที่ใช้ลบ
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // ใส่ CSRF Token
                    },
                    success: function (response) {

                        $("#event-" + eventId).remove(); // ลบออกจากหน้าจอ
                    },
                    error: function (xhr) {
                        alert("เกิดข้อผิดพลาด: " + xhr.responseText);
                    }
                });
            }
        });
    });

    $(document).ready(function () {
        $(".toggle-status").on("click", function () {
            var eventId = $(this).data("id");

            $.ajax({
                url: "/events/update-status",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    event_id: eventId
                },
                success: function (response) {
                    if (response.success) {
                        window.location.reload(); // รีเฟรชหน้า
                    } else {
                        alert("เกิดข้อผิดพลาดในการอัปเดตสถานะ");
                    }
                },
                error: function () {
                    alert("เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์");
                }
            });
        });
    });

    $(document).ready(function () {
        // เปิด modal เมื่อคลิกปุ่มแก้ไข
        $(".edit-event").on("click", function () {
            var eventId = $(this).data("id");
            var eventName = $(this).data("name");

            // กำหนดค่าให้กับ input ใน modal
            $("#event_id").val(eventId);
            $("#nameevent").val(eventName);

            // เปิด modal
            $("#editEventModal").modal("show");
        });

        // เมื่อ submit form แก้ไขชื่อกิจกรรม
        $("#editEventForm").on("submit", function (e) {
            e.preventDefault();

            var eventId = $("#event_id").val();
            var nameevent = $("#nameevent").val();

            $.ajax({
                url: "/events/" + eventId,
                method: "PUT",
                data: {
                    _token: "{{ csrf_token() }}",
                    nameevent: nameevent
                },
                success: function (response) {
                    // ปิด modal
                    $("#editEventModal").modal("hide");

                    // อัปเดตชื่อกิจกรรมในตาราง
                    $("#event-" + eventId + " td:first").text(nameevent);
                },
                error: function (xhr) {
                    alert("เกิดข้อผิดพลาด: " + xhr.responseText);
                }
            });
        });
    });

</script>
@endsection