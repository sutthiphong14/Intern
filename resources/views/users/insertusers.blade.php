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

<div class="card mb-4">
    
    <h4 class="card-header">เพิ่มผู้ใช้งานระบบ</h4>
    


    <hr class="my-0" />
    <div class="card-body">
        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label for="username" class="form-label text-dark">ชื่อผู้ใช้</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="กรอกชื่อผู้ใช้"
                        required value="{{ old('username') }}">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label text-dark">ชื่อ-นามสกุล</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="กรอกชื่อ-นามสกุล"
                        required value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label for="emp_id" class="form-label text-dark">รหัสพนักงาน</label>
                    <input type="text" class="form-control" id="emp_id" name="emp_id" placeholder="กรอกรหัสพนักงาน"
                        required value="{{ old('emp_id') }}">
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label text-dark">แผนก</label>
                    <input type="text" class="form-control" id="department" name="department" placeholder="กรอกแผนก"
                        required value="{{ old('department') }}">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-dark">รหัสผ่าน</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="กรอกรหัสผ่าน"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-dark">อีเมล</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="กรอกอีเมล" required
                        value="{{ old('email') }}">
                </div>

                <hr class="my-3" />
                <h4 class="card-header">ให้สิทธิ์การใช้งาน</h4>
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th class='col-4 bg-dark'>สิทธิ์</th>
                                <th class='col-7 bg-dark'>คำอธิบาย</th>
                                <th class='col-1 bg-dark'>อนุญาต</th>
                            </tr>
                        </thead>
                        <tbody class='align-items-center'>
                            <tr>
                                <td> <i class="fas fa-users-cog"></i> จัดการผู้ใช้งานระบบ</td>
                                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข ให้สิทธิ์การใช้งานในระบบต่างๆแก่ผู้ใช้งานระบบ</td>
                                <td class="align-items-center text-center">
                                    <div class="form-group d-flex justify-content-center align-items-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                name="manage_users_permission" id="manageUsersSwitch"
                                                style="transform: scale(2);">
                                            <label class="form-check-label" for="manageUsersSwitch"></label>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td> <i class="fas fa-chart-line"></i> จัดการหน้าแดชบอร์ด</td>
                                <td>สิทธิ์ในการ อัพโหลด ลบ แก้ไข หน้าแดชบอร์ด</td>
                                <td class="align-items-center text-center">
                                    <div class="form-group d-flex justify-content-center align-items-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                name="manage_dashboard_permission" id="manageDashboardSwitch"
                                                style="transform: scale(2);">
                                            <label class="form-check-label" for="manageDashboardSwitch"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-newspaper"></i> จัดการแหล่งป้อนข่าว</td>
                                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข เปิดปิดการแสดงผลของหน้าฟีดข่าว</td>
                                <td class="align-items-center text-center">
                                    <div class="form-group d-flex justify-content-center align-items-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                name="manage_newsfeed_permission" id="manageNewsFeedSwitch"
                                                style="transform: scale(2);">
                                            <label class="form-check-label" for="manageNewsFeedSwitch"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer align-items-center text-center">
                    <button type="button" class="btn btn-danger"
                        onclick="window.location='{{ route('users.list') }}'">ยกเลิก</button>
                    <button type="submit" class="btn btn-success">ยืนยัน</button>
                </div>


        </form>
    </div>
    <!-- /Account -->
</div>





@endsection

@section('script')



@endsection