@extends('admins.index')
@section('title')
    รายการข้อมูล
@endsection
@section('header')
    รายการข้อมูล
@endsection
@section('css')

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
                                        <label for="username">ชื่อผู้ใช้</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="กรอกชื่อผู้ใช้" required
                                            value="{{ old('username', $user->username) }}">
                                    </div>


                                    <div class="form-group">
                                        <label for="name">ชื่อ-นามสกุล</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="กรอกชื่อผู้ใช้" required value="{{ old('name', $user->name) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="emp_id">รหัสพนักงาน</label>
                                        <input type="text" class="form-control" id="emp_id" name="emp_id"
                                            placeholder="กรอกรหัสพนักงาน" required value="{{ old('emp_id', $user->emp_id) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="department">สังกัด</label>
                                        <input type="text" class="form-control" id="department" name="department"
                                            placeholder="กรอกรหัสพนักงาน" required value="{{ old('department', $user->department) }}">
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
