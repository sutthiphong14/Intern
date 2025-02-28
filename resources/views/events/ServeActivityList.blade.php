@extends('admins.index')
@section('css')
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
        </span>
        ข้อมูลพื้นฐานบริการ

    </h4>
    <div class="content-wrapper">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">ข้อมูลพื้นฐานบริการ {{ $typeName }}</h3>
                <div class="d-flex align-items-center gap-2">

                    <div class="d-flex align-items-center gap-2">


                        <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                            data-bs-target="#modalScrollable">
                            <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#serviceModal">เพิ่มบริการ</button>
            <a href="{{ route('type_list') }}" class="btn btn-secondary mb-3">Back</a> -->
            <div class="card-body">
                <div class="table-responsive ">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>ชื่อบริการ</th>
                                <th>เครื่องมือ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count() > 0)
                                @foreach ($data as $row)
                                    <tr>

                                        <td class="col-5">{{ $row->service_name }}</td>

                                        <td>
                                            @if (stripos($row->service_name, 'ict') === false)
                                                <a href="{{ route('promotion_list', $row->service_id) }}"
                                                    class="btn btn-info btn-sm">จัดการข้อมูลโปรโมชั่น</a>
                                            @else
                                                <a href="{{ route('product_list', $type_id) }}" class="btn btn-info btn-sm">จัดการข้อมูล
                                                    product</a>
                                            @endif
                                            <!-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editServiceModal"
                                                data-url="{{ route('serve_update', $row->service_id) }}"
                                                data-id="{{ $row->service_id }}" data-name="{{ $row->service_name }}">
                                                แก้ไข
                                            </button> -->

                                            <form action="{{ route('service_delete', $row->service_id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm delete-button"
                                                    data-url="{{ route('service_delete', $row->service_id) }}"
                                                    onclick="showDeleteConfirm(event)">
                                                    ลบ
                                                </button>
                                            </form>


                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="text-center">ไม่มีข้อมูลบริการ</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>




        </div>
    </div>


    <!-- Modal สำหรับเพิ่ม -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="serviceForm" action="{{ route('service_insert') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" id="service_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceModalLabel">เพิ่ม/แก้ไขบริการ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="service_name" class="form-label">ชื่อบริการ</label>
                            <input type="text" class="form-control" id="service_name" name="service_name" required>
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
    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">แก้ไขบริการ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editServiceForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">ชื่อบริการ</label>
                            <input type="text" class="form-control" id="serviceName" name="service_name" required>
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
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editServiceModal = document.getElementById('editServiceModal');
            editServiceModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');


                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editServiceForm');
                form.action = url;
                form.querySelector('#serviceName').value = name;
            });
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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