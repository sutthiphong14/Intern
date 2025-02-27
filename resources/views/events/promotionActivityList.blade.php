@extends('admins.index')
@section('css')
<style>
  /* กำหนดความสูงของ modal ให้เล็กลง */
  #editPromotionModal .modal-dialog {
        max-width: 400px;
        /* ปรับความกว้างของ modal */
        height: auto;
        /* ความสูงปรับตามเนื้อหา */
    }

    #editPromotionModal .modal-content {
        height: auto;
        /* ความสูงของ content ปรับตามเนื้อหาภายใน */
    }

      /* กำหนดความสูงของ modal ให้เล็กลง */
  #PromotionModal .modal-dialog {
        max-width: 400px;
        /* ปรับความกว้างของ modal */
        height: auto;
        /* ความสูงปรับตามเนื้อหา */
    }

    #PromotionModal .modal-content {
        height: auto;
        /* ความสูงของ content ปรับตามเนื้อหาภายใน */
    }

</style>
@endsection
@section('content')
<h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">
        <a href="{{ route('home') }}" class="">
            หน้าแรก
        </a>
        /
        <a href="{{ route('type_list') }}" class="">
        ข้อมูลกิจกรรม
        </a>
        /
        <a href="javascript:history.back()" class="">
        ข้อมูลพื้นฐานบริการ
        </a>
        /
        </span>
        ข้อมูลพื้นฐานโปรโมชัน 
</h4>

<div class="content-wrapper">
<div class="card">
        <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">ข้อมูลพื้นฐานโปรโมชัน</h3>
                <div class="d-flex align-items-center gap-2">

                    <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-success " data-bs-toggle="modal" data-bs-target="#PromotionModal">เพิ่มโปรโมชัน</button>
                        <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                            data-bs-target="#modalScrollable">
                            <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive ">

        
        <table class="table table-bordered text-center">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อโปรโมชัน</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $row)
                        <tr>
                            <td class="col-5">{{ $row->promotion_name }}</td>
                            <td>
                            <a href="{{ route('speed_list', ['promotion_id' => $row->promotion_id, 'service_id' => $service_id]) }}"
                            class="btn btn-info btn-sm">จัดการข้อมูลความเร็ว</a>

                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editPromotionModal"
                                    data-url="{{ route('promotion_update', ['promotion_id' => $row->promotion_id, 'service_id' => $service_id]) }}"
                                    data-id="{{ $row->promotion_id }}" data-name="{{ $row->promotion_name }}">
                                    แก้ไข
                                </button>

                                <form
                                    action="{{ route('promotion_delete', ['promotion_id' => $row->promotion_id, 'service_id' => $service_id]) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-button"
                                        data-url="{{ route('promotion_delete', ['promotion_id' => $row->promotion_id, 'service_id' => $service_id]) }}"
                                        onclick="showDeleteConfirm(event)">
                                        ลบ
                                    </button>
                                </form>

                                
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">ไม่มีข้อมูลโปรโมชั่น</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Modal สำหรับเพิ่ม -->
        <div class="modal fade" id="PromotionModal" tabindex="-1" aria-labelledby="PromotionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="promotionForm" action="{{ route('promotion_insert', $service_id) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="PromotionModalLabel">เพิ่มโปรโมชั่น</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="promotion_name" class="form-label">ชื่อโปรโมชั่น</label>
                                <input type="text" class="form-control" id="promotion_name" name="promotion_name"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-success">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Modal สำหรับแก้ไข -->
        <div class="modal fade" id="editPromotionModal" tabindex="-1" aria-labelledby="editPromotionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPromotionModalLabel">แก้ไขโปรโมชั่น</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editPromotionForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="promotionName" class="form-label">ชื่อโปรโมชัน</label>
                                <input type="text" class="form-control" id="promotionName" name="promotion_name"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        </div>
        </div>
        </div>
    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 1500, // เพิ่มเวลาให้แสดงนานขึ้น
                    timerProgressBar: true,
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editPromotionModal = document.getElementById('editPromotionModal');
            editPromotionModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const rate = button.getAttribute('data-rate');

                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editPromotionForm');
                form.action = url;
                form.querySelector('#promotionName').value = name;
            });
        });
    </script>

    <script>
        function showDeleteConfirm(event) {
            event.preventDefault(); // หยุดการ reload หน้า
            const form = event.target.closest('form'); // หาฟอร์มที่เกี่ยวข้อง

            Swal.fire({
                title: 'ลบข้อมูลหรือไม่?',
                text: "คุณจะไม่สามารถย้อนกลับได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // ทำการส่งฟอร์ม
                }
            });
        }
    </script>
@endsection
