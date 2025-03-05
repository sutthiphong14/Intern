@extends('admins.index')
@section('css')
<style>
  /* กำหนดความสูงของ modal ให้เล็กลง */
  #ProductModal .modal-dialog {
        max-width: 400px;
        /* ปรับความกว้างของ modal */
        height: auto;
        /* ความสูงปรับตามเนื้อหา */
    }

    #ProductModal .modal-content {
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
        <a href="javascript:history.back(-2)" class="">
            ข้อมูลพื้นฐานบริการ
        </a>
        /
        <a href="javascript:history.back()" class="">
            หมวดหมู่บริการICT solution
            </a>
        /
        </span>
        ข้อมูลพื้นฐาน Product
</h4>



<div class="content-wrapper">
<div class="card">
        <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">ข้อมูลพื้นฐาน Product</h3>
                <div class="d-flex align-items-center gap-2">

                    <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ProductModal">เพิ่มProduct</button>
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
                    <th>ชื่อ Product</th>
                    <th>รายละเอียด</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $row)
                        <tr>
                            <td class="col-5">{{ $row->product_name }}</td>
                            <td class="col-5">{{ $row->description ?? 'ไม่ระบุ' }}</td>
                            <td>

                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editProductModal"
                                    data-url="{{ route('product_update',[$row->product_id,$type_id, $ict_service_id]) }}"
                                    data-id="{{ $row->product_id }}" data-name="{{ $row->product_name }}" data-description="{{ $row->description }}">
                                    แก้ไข
                                </button>

                                  <form action="{{ route('product_delete', [$row->product_id,$type_id, $ict_service_id]) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-button"
                                         data-url="{{ route('product_delete', [$row->product_id,$type_id, $ict_service_id]) }}"
                                        onclick="showDeleteConfirm(event)">
                                        ลบ
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">ไม่มีข้อมูลProduct</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Modal สำหรับเพิ่ม -->
        <div class="modal fade" id="ProductModal" tabindex="-1" aria-labelledby="ProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="productForm" action="{{ route('product_insert',[$type_id, $ict_service_id]) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ProductModalLabel">เพิ่มProduct</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="product_name" class="form-label">ชื่อProduct</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>

                                <label for="description" class="form-label">รายละเอียด</label>
                                <input type="text" class="form-control" id="description" name="description" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal สำหรับแก้ไข -->
        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">แก้ไขProduct</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editProductForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="productName" class="form-label">ชื่อProduct</label>
                                <input type="text" class="form-control" id="productName" name="product_name" required>

                                <label for="description" class="form-label">รายละเอียด</label>
                                <input type="text" class="form-control" id="Description" name="description" >
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
            const editProductModal = document.getElementById('editProductModal');
            editProductModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const rate = button.getAttribute('data-rate');
                const description = button.getAttribute('data-description');

                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editProductForm');
                form.action = url;
                form.querySelector('#productName').value = name;
                form.querySelector('#Description').value = description;
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
