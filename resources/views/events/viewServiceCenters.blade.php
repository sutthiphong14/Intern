@extends('admins.index')
@section('content')
    @section('css')
        <style>
            /* กำหนดความสูงของ modal ให้เล็กลง */
            #editCenterModal .modal-dialog {
                max-width: 400px;
                /* ปรับความกว้างของ modal */
                height: auto;
                /* ความสูงปรับตามเนื้อหา */
            }

            #editCenterModal .modal-content {
                height: auto;
                /* ความสูงของ content ปรับตามเนื้อหาภายใน */
            }

            /* กำหนดความสูงของ modal ให้เล็กลง */
            #centerModal .modal-dialog {
                max-width: 400px;
                /* ปรับความกว้างของ modal */
                height: auto;
                /* ความสูงปรับตามเนื้อหา */
            }

            #centerModal .modal-content {
                height: auto;
                /* ความสูงของ content ปรับตามเนื้อหาภายใน */
            }
        </style>

    @endsection
    <h4 class="fw-bold py-2 mb-3">
        <a href="{{ route('home') }}">หน้าแรก</a> / <a href="{{ route('provinceactivityList') }}">จัดการข้อมูลจังหวัด</a> /
        ศูนย์บริการในจังหวัด {{ $province->province_name }}
    </h4>

    <div class="content-wrapper">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">จัดการข้อมูลจังหวัด</h3>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#centerModal">เพิ่มศูนย์บริการ</button>

                    <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                        data-bs-target="#modalScrollable">
                        <i class="fas fa-question-circle"></i>
                    </button>
                </div>
            </div>

            <div class="container">

                <table class="table table-bordered mb-4 text-center">
                    <thead>
                        <tr class="bg-dark text-light">
                            <th>ชื่อศูนย์บริการ</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($province->centers->count() > 0)
                            @foreach ($province->centers as $center)
                                <tr>
                                    <td>{{ $center->center_name }}</td>
                                    <td>

                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editCenterModal"
                                            data-url="{{ route('servicecenteractivityupdate', $center->center_id) }}"
                                            data-id="{{ $center->center_id }}" data-name="{{ $center->center_name }}">
                                            แก้ไข
                                        </button>

                                        <form action="{{ route('servicecenteractivitydelete', $center->center_id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-button"
                                                data-url="{{ route('servicecenteractivitydelete', $center->center_id) }}"
                                                onclick="showDeleteConfirm(event)">
                                                ลบ
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" class="text-center">ไม่พบข้อมูลศูนย์บริการ</td>
                            </tr>
                        @endif
                    </tbody>
                </table>


                <!-- Modal สำหรับเพิ่ม -->
                <div class="modal fade" id="centerModal" tabindex="-1" aria-labelledby="centerModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="centerForm" action="{{ route('province.storeServiceCenter', $province->province_id) }}"
                            method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="centerModalLabel">เพิ่มจังหวัด</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="center_name" class="form-label">ชื่อจังหวัด</label>
                                        <input type="text" class="form-control" id="center_name" name="center_name"
                                            required>
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
                <div class="modal fade" id="editCenterModal" tabindex="-1" aria-labelledby="editCenterModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCenterModalLabel">แก้ไขจังหวัด</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="editCenterForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="centerName" class="form-label">ชื่อจังหวัด</label>
                                        <input type="text" class="form-control" id="centerName" name="center_name" required>
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
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editCenterModal = document.getElementById('editCenterModal');
            editCenterModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');


                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editCenterForm');
                form.action = url;
                form.querySelector('#centerName').value = name;
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