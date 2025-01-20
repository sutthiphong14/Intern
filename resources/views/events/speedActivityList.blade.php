@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <h2>จัดการความเร็ว</h2>
        
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#speedModal">เพิ่มความเร็ว</button>
        
        <a href="{{ route('promotion_list', $service_id) }}" class="btn btn-secondary mb-3">Back</a>
        
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อความเร็ว</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $row)
                        <tr>
                            <td class="col-5">{{ $row->speed_name }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editSpeedModal"
                                    data-url="{{ route('speed_update', ['promotion_id' => $promotion_id, 'speed_id' => $row->speed_id, 'service_id' => $service_id]) }}"
                                    data-id="{{ $row->speed_id }}" data-name="{{ $row->speed_name }}">
                                    แก้ไข
                                </button>
                                
                                <form
                                    action="{{ route('speed_delete', ['promotion_id' => $promotion_id, 'speed_id' => $row->speed_id, 'service_id' => $service_id]) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-button"
                                        data-url="{{ route('speed_delete', ['promotion_id' => $promotion_id, 'speed_id' => $row->speed_id, 'service_id' => $service_id]) }}"
                                        onclick="showDeleteConfirm(event)">
                                        ลบ
                                    </button>
                                </form>
                                
                                <a href="{{ route('price_list', ['promotion_id' => $promotion_id, 'speed_id' => $row->speed_id, 'service_id' => $service_id]) }}"
                                    class="btn btn-info btn-sm">ดูราคา</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">ไม่มีข้อมูลความเร็ว</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Modal สำหรับเพิ่ม -->
        <div class="modal fade" id="speedModal" tabindex="-1" aria-labelledby="speedModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="speedForm"
                    action="{{ route('speed_insert', ['service_id' => $service_id, 'promotion_id' => $promotion_id]) }}"
                    method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="speedModalLabel">เพิ่มความเร็ว</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="speed_name" class="form-label">ชื่อความเร็ว</label>
                                <input type="text" class="form-control" id="speed_name" name="speed_name" required>
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
        <div class="modal fade" id="editSpeedModal" tabindex="-1" aria-labelledby="editSpeedModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editSpeedForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editSpeedModalLabel">แก้ไขความเร็ว</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="speedName" class="form-label">ชื่อบริการ</label>
                                <input type="text" class="form-control" id="speedName" name="speed_name" required>
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
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editSpeedModal = document.getElementById('editSpeedModal');
            editSpeedModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                
                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editSpeedForm');
                form.action = url;
                form.querySelector('#speedName').value = name;
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
