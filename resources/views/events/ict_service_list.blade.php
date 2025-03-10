@extends('admins.index')
@section('css')
    <style>
        /* กำหนดความสูงของ modal ให้เล็กลง */
        #serviceModal .modal-dialog {
            max-width: 400px;
            /* ปรับความกว้างของ modal */
            height: auto;
            /* ความสูงปรับตามเนื้อหา */
        }

        #serviceModal .modal-content {
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
    หมวดหมู่บริการICT solution
</h4>
    <div class="content-wrapper">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">จัดการหมวดหมู่บริการICT solution</h3>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-success" data-bs-toggle="modal"data-bs-target="#serviceModal">เพิ่มบริการ</button>
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
                        <th>ชื่อบริการ</th>
                        <th>รายละเอียด</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->count() > 0)
                        @foreach ($data as $row)
                            <tr>
                                <td class="col-4">{{ $row->service_name }}</td>
                                <td class="col-5">{{ $row->description ?? 'ไม่ระบุ' }}</td>
                                <td>

                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editserviceModal"
                                        data-url="{{ route('ict_service_update', [$row->ict_service_id, $type_id, $service_id]) }}"
                                        data-id="{{ $row->ict_service_id }}" data-name="{{ $row->service_name }}"
                                        data-description="{{ $row->description }}">
                                        แก้ไข
                                    </button>

                                    <form
                                        action="{{ route('ict_service_delete', [$row->ict_service_id, $type_id, $service_id]) }}"
                                        method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-button"
                                            data-url="{{ route('ict_service_delete', [$row->ict_service_id, $type_id, $service_id]) }}"
                                            onclick="showDeleteConfirm(event)">
                                            ลบ
                                        </button>
                                    </form>
                                    <a href="{{ route('product_list', [$type_id, $row->ict_service_id]) }}"
                                        class="btn btn-info btn-sm">จัดการproducts</a>

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">ไม่มีข้อมูลบริการ</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Modal สำหรับเพิ่ม -->
            <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="serviceForm" action="{{ route('ict_service_insert', [$type_id, $service_id]) }}"
                        method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="serviceModalLabel">เพิ่มบริการ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="service_name" class="form-label">ชื่อบริการ</label>
                                    <input type="text" class="form-control" id="service_name" name="service_name"
                                        required>

                                    <label for="description" class="form-label">รายละเอียด</label>
                                    <input type="text" class="form-control" id="description" name="description">
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
            <div class="modal fade" id="editserviceModal" tabindex="-1" aria-labelledby="editserviceModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editserviceModalLabel">แก้ไขบริการ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editserviceForm" method="POST" action="">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="serviceName" class="form-label">ชื่อบริการ</label>
                                    <input type="text" class="form-control" id="serviceName" name="service_name"
                                        required>

                                    <label for="description" class="form-label">รายละเอียด</label>
                                    <input type="text" class="form-control" id="Description" name="description">
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
            const editserviceModal = document.getElementById('editserviceModal');
            editserviceModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const description = button.getAttribute('data-description');

                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editserviceForm');
                form.action = url;
                form.querySelector('#serviceName').value = name;
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
