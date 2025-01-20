@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการกิจกรรม</h2>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTypeModal">
            เพิ่มกิจกรรม
        </button>

        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อกิจกรรม</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $row)
                        <tr>
                            <td class="col-5">{{ $row->type_name }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm editBtn" data-id="{{ $row->type_id }}"
                                    data-name="{{ $row->type_name }}" data-bs-toggle="modal"
                                    data-bs-target="#editTypeModal">
                                    Edit
                                </button>
                                <form action="{{ route('type_delete', $row->type_id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm deleteBtn"
                                        id="deleteBtn{{ $row->type_id }}">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">ไม่มีข้อมูลกิจกรรม</td>
                    </tr>
                @endif
            </tbody>
        </table>


        {{-- modal add --}}
        <div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="addTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTypeModalLabel">เพิ่มกิจกรรม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addTypeForm" action="{{ route('type_insert') }}" method="POST">
                            @csrf
                            <div class="mb-3">


                                <label for="type_name" class="form-label">ชื่อกิจกรรม</label>
                                <input type="text" class="form-control" id="type_name" name="type_name" required>
                                <input type="hidden" name="created_at" value="{{ \Carbon\Carbon::now() }}">
                                <input type="hidden" name="updated_at" value="{{ \Carbon\Carbon::now() }}">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Edit -->
        <div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="editTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTypeModalLabel">แก้ไขกิจกรรม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTypeForm" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="edit_type_name" class="form-label">ชื่อกิจกรรม</label>
                                <input type="text" class="form-control" id="edit_type_name" name="type_name" required>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('script')
    <script>
        // เปิด Modal พร้อมดึงข้อมูล
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                // อัปเดตฟิลด์ใน Modal
                document.getElementById('edit_type_name').value = name;

                // อัปเดต action ของฟอร์ม
                document.getElementById('editTypeForm').action = `/typeactivity_update/${id}`;
            });
        });
    </script>

    <script>
        document.getElementById('addTypeForm').addEventListener('submit', function(e) {
            e.preventDefault(); // ป้องกันการรีเฟรชหน้า
            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // ปิด Modal หลังจากบันทึกเสร็จ
                        $('#addTypeModal').modal('hide');

                        // แสดงข้อความสำเร็จด้วย SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: data.message,
                            showConfirmButton: true,
                            timer: 1500, // เพิ่มเวลาให้แสดงนานขึ้น
                            timerProgressBar: true,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload(); // รีเฟรชหน้าเมื่อกด OK
                        });
                    } else {
                        Swal.fire('ผิดพลาด!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดบางอย่าง', 'error');
                });
        });
    </script>



    <script>
        // Event listener สำหรับปุ่มลบ
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener สำหรับปุ่มลบ
            document.querySelectorAll('.deleteBtn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); // ป้องกันการลบโดยตรง

                    const form = this.closest('form');
                    const deleteUrl = form.action;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "คุณต้องการลบข้อมูลนี้ใช่หรือไม่?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // หากยืนยันการลบ
                        }
                    });
                });
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
@endsection
