@extends('admins.index')
@section('title')
รายการข้อมูล
@endsection

@section('header')
รายการข้อมูล
@endsection

@section('css')

@endsection

@section('content')
<h4 class="fw-bold py-2 mb-3">
    <a href="{{ route('home') }}">หน้าแรก</a> / จัดการกิจกรรม
</h4>


<div class="content-wrapper">
    <div class="card">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <h3 class="card-header text-dark">จัดการอัลบั้มกิจกรรม</h3>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-success me-4" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    เพิ่มกิจกรรม
                </button>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-striped col-12">
                <thead>
                    <tr class='bg-dark text-center'>
                        <th class = '1'>ลำดับ</th>
                        <th class = '7'>ชื่อกิจกรรม</th>
                        <th class = '4'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $key => $event)
                        <tr class = 'text-center'>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $event->nameevent }}</td>
                            <td>
                                <div class="dropdown-menu-start">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="">
                                            <i class="bx bx-edit-alt me-1"></i> แก้ไข
                                        </a>

                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                style="border: none; background: none;">
                                                <i class="bx bx-trash me-1"></i> ลบ
                                            </button>

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
                    <input type="text" name="nameevent" required>
                    <button type="submit">เพิ่มกิจกรรม</button>
                </form>
            </div>
        </div>
    </div>
</div>






<script>
    $(document).ready(function () {
        $("#addEventForm").on("submit", function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('events.store') }}",
                method: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert(response.message);
                    window.location.href = "{{ route('events.list') }}"; // กลับไปหน้าหลัก
                },
                error: function (xhr) {
                    alert("เกิดข้อผิดพลาด: " + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection