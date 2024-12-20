@extends('admins.index')
@section('title')
    รายการข้อมูล
@endsection
@section('header')
    รายการข้อมูล
@endsection

@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<style>
    .user-profile-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-warning mt-3 mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title col-5">รายชื่อผู้ใช้</h3>
                        <div class="input-group col-4">
                            <form action="{{ route('users.search') }}" method="GET" class="d-flex w-100">
                                <input type="text" name="query" class="form-control" placeholder="ค้นหาชื่อผู้ใช้..." value="{{ request('query') }}">
                                <button type="submit" class="btn btn-info btn-dark">ค้นหา</button>
                            </form>
                        </div>
                        
                        <a href="insertusers" class="btn bg-success col-2">
                            <i class="d-flex justify-content-end"></i> เพิ่มผู้ใช้งาน
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class='text-center'>
                                <tr class="col-12">
                                    
                                    <th class='col-1'>รหัสพนักงาน</th>
                                    <th class='col-1'>รูปโปรไฟล์</th>
                                    <th class='col-4'>ชื่อ</th>
                                    <th class='col-4'>อีเมล</th>    
                                    <th class='col-3'>การดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                   
                                    <td class="text-center">{{ $user->employee_id }}</td>
                                    <td class="text-center">
                                        <img src="{{ $user->profile_image ? Storage::url($user->profile_image) : 'dist/img/default-user.png' }}" 
                                             alt="Profile Image" 
                                             class="user-profile-image">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                        <a href="#"
                                           class="btn btn-danger btn-sm delete-btn"
                                           data-url="{{ route('delete', $user->id) }}">ลบ</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')

<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    // SweetAlert2 สำหรับการยืนยันการลบ
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // ป้องกันการส่งลิงก์เดิม
                let url = this.getAttribute('data-url');
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "ข้อมูลจะถูกลบและไม่สามารถกู้คืนได้!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url; // ส่งคำขอลบ
                    }
                });
            });
        });
    });
</script>
@endsection