@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการข้อมูลจังหวัด</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#provinceModal">เพิ่มจังหวัด</button>

        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ลำดับ</th> <!-- เพิ่มคอลัมน์สำหรับลำดับ -->
                    <th>ชื่อจังหวัด</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td> <!-- ใช้ $loop->iteration แสดงลำดับ -->
                        <td>{{ $row->province_name }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProvinceModal"
                                data-url="{{ route('provinceactivityupdate', $row->province_id) }}"
                                data-id="{{ $row->province_id }}" data-name="{{ $row->province_name }}">
                                แก้ไข
                            </button>
                            <form action="{{ route('provinceactivitydelete', $row->province_id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-button"
                                    data-url="{{ route('provinceactivitydelete', $row->province_id) }}"
                                    onclick="showDeleteConfirm(event)">
                                    ลบ
                                </button>
                            </form>
                            <a href="{{ route('province.viewServiceCenters', $row->province_id) }}"
                                class="btn btn-info btn-sm">ดูศูนย์บริการ</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <!-- Modal สำหรับเพิ่ม -->
        <div class="modal fade" id="provinceModal" tabindex="-1" aria-labelledby="provinceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="provinceForm" action="{{ route('provinceactivityadd') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="provinceModalLabel">เพิ่มจังหวัด</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="province_name" class="form-label">ชื่อจังหวัด</label>
                                <input type="text" class="form-control" id="province_name" name="province_name" required>
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
        <div class="modal fade" id="editProvinceModal" tabindex="-1" aria-labelledby="editProvinceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProvinceModalLabel">แก้ไขจังหวัด</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editProvinceForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="provinceName" class="form-label">ชื่อจังหวัด</label>
                                <input type="text" class="form-control" id="provinceName" name="province_name" required>
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
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editProvinceModal = document.getElementById('editProvinceModal');
            editProvinceModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');


                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editProvinceForm');
                form.action = url;
                form.querySelector('#provinceName').value = name;
            });
        });
    </script>

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
