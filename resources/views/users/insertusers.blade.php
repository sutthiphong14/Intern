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
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-warning mt-2">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">เพิ่มผู้ใช้งานระบบ +</h3>
                        </div>
                        
                        <!-- Form Start -->
                        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <!-- Display any validation errors -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                        
                                <!-- Success message -->
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                        
                                
                        
                                <div class="form-group">
                                    <label for="name">ชื่อผู้ใช้</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="กรอกชื่อผู้ใช้" required value="{{ old('username') }}">
                                </div>
                        
                                <div class="form-group">
                                    <label for="email">อีเมล</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="กรอกอีเมล" required value="{{ old('email') }}">
                                </div>
                        
                                <div class="form-group">
                                    <label for="password">รหัสผ่าน</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="กรอกรหัสผ่าน" required>
                                </div>
                        
                                <div class="form-group">
                                    <label for="profile_image">รูปโปรไฟล์</label>
                                    <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                                </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">สิทธิ์การใช้งาน</label>
                                </div>

                                <div class="table-responsive">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead class="text-center">
                                            <tr>
                                                <th class='col-4 bg-dark'>สิทธิ์</th>
                                                <th class='col-7 bg-dark'>คำอธิบาย</th>
                                                <th class='col-1 bg-dark'>อนุญาต</th>
                                            </tr>
                                        </thead>
                                        <tbody class='text-start align-items-center'>
                                            <tr>
                                                <td>จัดการผู้ใช้งานระบบ</td>
                                                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข ให้สิทธิ์การใช้งานในระบบต่างๆแก่ผู้ใช้งานระบบ</td>
                                                <td class='text-center'>
                                                    <div class="form-group">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" 
                                                                name="manage_users_permission" 
                                                                id="manageUsersSwitch" 
                                                                style="transform: scale(2);">
                                                            <label class="form-check-label" for="manageUsersSwitch"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>จัดการหน้าแดชบอร์ด</td>
                                                <td>สิทธิ์ในการ อัพโหลด ลบ แก้ไข หน้าแดชบอร์ด</td>
                                                <td class='text-center'>
                                                    <div class="form-group">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" 
                                                                name="manage_dashboard_permission" 
                                                                id="manageDashboardSwitch" 
                                                                style="transform: scale(2);">
                                                            <label class="form-check-label" for="manageDashboardSwitch"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>จัดการแหล่งป้อนข่าว</td>
                                                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข เปิดปิดการแสดงผลของหน้าฟีดข่าว</td>
                                                <td class='text-center'>
                                                    <div class="form-group">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" 
                                                                name="manage_newsfeed_permission" 
                                                                id="manageNewsFeedSwitch" 
                                                                style="transform: scale(2);">
                                                            <label class="form-check-label" for="manageNewsFeedSwitch"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer align-items-center text-center">
                                <button type="button" class="btn btn-danger" onclick="window.location='{{ route('users.list') }}'">ยกเลิก</button>
                                <button type="submit" class="btn btn-success">ยืนยัน</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
<!-- AdminLTE App -->

    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection