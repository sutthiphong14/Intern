@extends('admins.index')
@section('title')
    รายการข้อมูล
@endsection
@section('header')
    รายการข้อมูล
@endsection
@section('css')
<link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ URL::asset(path: 'plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- Theme style -->
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="dist/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="dist/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="dist/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="dist/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="dist/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="dist/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="dist/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="dist/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="dist/assets/js/config.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"
        integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning mt-2">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">แก้ไขผู้ใช้งานระบบ</h3>
                            </div>

                            <!-- Form Start -->
                            <form method="POST" action="{{ route('users.update', $user->id) }}"
                                enctype="multipart/form-data">
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
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="name">ชื่อผู้ใช้</label>
                                        <input type="text" class="form-control" id="name" name="username"
                                            placeholder="กรอกชื่อผู้ใช้" required
                                            value="{{ old('name', $user->username) }}">
                                    </div>


                                    <div class="form-group">
                                        <label for="name">ชื่อ-นามสกุล</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="กรอกชื่อผู้ใช้" required value="{{ old('name', $user->name) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">อีเมล</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="กรอกอีเมล" required value="{{ old('email', $user->email) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">รหัสผ่าน (เว้นว่างถ้าไม่ต้องการเปลี่ยน)</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="กรอกรหัสผ่านใหม่ถ้าต้องการเปลี่ยน">
                                    </div>
                                    <div class="form-group">
                                        <label for="profile_image">รูปโปรไฟล์</label>
                                        @if ($user->profile_image)
                                            <div class="mb-3">
                                                <img src="{{ $user->profile_image }}" alt="Profile Image" class="img-fluid"
                                                    style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                            </div>
                                        @else
                                            <img src="{{ asset('dist/img/defult_profile.jpg') }}" alt="Default Profile Image"
                                                class="img-size-50 img-circle mr-2">
                                        @endif
                                 

                                        <input type="file" class="form-control-file" id="profile_image"
                                            name="profile_image" accept="image/*">
                                        <small class="form-text text-muted">
                                            อัพโหลดรูปโปรไฟล์ใหม่ (ไฟล์ jpeg, png, jpg เท่านั้น ขนาดไม่เกิน 2MB)
                                        </small>
                                    </div>
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
                                                    <td> <i class="fas fa-users-cog"></i> จัดการผู้ใช้งานระบบ</td>
                                                    <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข
                                                        ให้สิทธิ์การใช้งานในระบบต่างๆแก่ผู้ใช้งานระบบ</td>
                                                    <td class='text-center'>
                                                        <div class="form-group">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="manage_users_permission" id="manageUsersSwitch"
                                                                    style="transform: scale(2);"
                                                                    {{ $user->permission['manage_users'] ?? false ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <i class="fas fa-chart-line"></i> จัดการหน้าแดชบอร์ด</td>
                                                    <td>สิทธิ์ในการ อัพโหลด ลบ แก้ไข หน้าแดชบอร์ด</td>
                                                    <td class='text-center'>
                                                        <div class="form-group">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="manage_dashboard_permission"
                                                                    id="manageDashboardSwitch"
                                                                    style="transform: scale(2);"
                                                                    {{ $user->permission['manage_dashboard'] ?? false ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <i class="fas fa-newspaper"></i> จัดการแหล่งป้อนข่าว</td>
                                                    <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข เปิดปิดการแสดงผลของหน้าฟีดข่าว</td>
                                                    <td class='text-center'>
                                                        <div class="form-group">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="manage_newsfeed_permission"
                                                                    id="manageNewsFeedSwitch" style="transform: scale(2);"
                                                                    {{ $user->permission['manage_newsfeed'] ?? false ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="card-footer align-items-center text-center">
                                    <button type="button" class="btn btn-danger"
                                        onclick="window.location='{{ route('users.list') }}'">ยกเลิก</button>
                                    <button type="submit" class="btn btn-success">อัปเดต</button>
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
    
    <script>
        $(function() {
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
