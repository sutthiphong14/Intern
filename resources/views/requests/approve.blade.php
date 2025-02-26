@extends('admins.index')

@section('title', 'อนุมัติคำขอ')

@section('content')


    <h4 class="fw-bold py-2 mb-3">
        <a href="{{ route('home') }}">หน้าแรก</a> / <a href="{{ route('users.list') }}"> รายชื่อผู้ใช้ </a>/ เพิ่มผู้ใช้งาน
    </h4>



    <div class="card mb-4">
        <h4 class="card-header">อนุมัติคำขอ</h4>

        <hr class="my-0" />
        <div class="card-body">

            <form action="{{ route('requests.createUser', $request->id_request) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">ชื่อผู้ใช้</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="{{ $request->user_request }}">
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">ชื่อ-สกุล</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $request->name_request }}">
                </div>

                <div class="mb-3">
                    <label for="emp_id" class="form-label">รหัสพนักงาน</label>
                    <input type="text" class="form-control" id="emp_id" name="emp_id"
                        value="{{ $request->id_employee_request }}">
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">แผนก</label>
                    <input type="text" class="form-control" id="department" name="department"
                        value="{{ $request->department_request }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">อีเมล</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $request->email_request }}">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">รหัสผ่าน</label>
                    <input type="password" class="form-control" id="password" name="password"
                        value="{{ $request->password_request }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="province" class="form-label">จังหวัด</label>
                    <input type="text" class="form-control" id="province" name="province"
                        value="{{ $request->province->province_name ?? 'N/A' }}">
                </div>

                <div class="mb-3">
                    <label for="center" class="form-label">ศูนย์บริการ</label>
                    <input type="text" class="form-control" id="center" name="center"
                        value="{{ $request->serviceCenter->center_name ?? 'N/A' }}">
                </div>

                <!-- สิทธิ์จัดการผู้ใช้ -->
                <div class="table-responsive">
                    <table id="permissionTable" class="table table-bordered table-hover">
                        <thead class="text-center">
                            <tr>
                                <th class='col-4 bg-dark text-white'>สิทธิ์</th>
                                <th class='col-7 bg-dark text-white'>คำอธิบาย</th>
                                <th class='col-1 bg-dark text-white'>อนุญาต</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(Auth::user()->permission['adminper_mission'] ?? false)

                                <!-- ✅ ตั้งค่าสิทธิ์แอดมิน -->
                                <tr class="text-start">
                                    <td><i class="fas fa-user-shield"></i> ตั้งค่าสิทธิ์แอดมิน</td>
                                    <td>กำหนดสิทธิ์การเข้าถึงระดับแอดมิน</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input user-permission" type="checkbox"
                                                name="adminper_mission" data-group="users">
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- ✅ จัดการผู้ใช้งาน -->
                            <tr class="text-start">
                                <td><i class="fas fa-users-cog"></i> จัดการผู้ใช้งานระบบ</td>
                                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข และกำหนดสิทธิ์ให้ผู้ใช้งานระบบ</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input user-permission" type="checkbox" name="manage_users"
                                            data-group="users">
                                    </div>
                                </td>
                            </tr>

                            <!-- ✅ จัดการหน้าแดชบอร์ด -->
                            <tr class="text-start">
                                <td><i class="fas fa-chart-line"></i> จัดการหน้าแดชบอร์ด</td>
                                <td>สิทธิ์ในการอัปโหลด ลบ แก้ไข หน้าแดชบอร์ด</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input dashboard-permission" type="checkbox"
                                            name="manage_dashboard" data-group="dashboard">
                                    </div>
                                </td>
                            </tr>

                            <!-- ✅ ดูข้อมูลแดชบอร์ด -->
                            <tr class="text-start">
                                <td><i class="fas fa-chart-line"></i> ดูข้อมูลแดชบอร์ด </td>
                                <td>สิทธิ์ในการดูข้อมูลแดชบอร์ดทุกหน้า</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input dashboard-permission" type="checkbox"
                                            name="view_fttx" data-group="dashboard">
                                    </div>
                                </td>
                            </tr>

                            <!-- ✅ จัดการแหล่งป้อนข่าว -->
                            <tr class="text-start">
                                <td><i class="fas fa-newspaper"></i> จัดการแหล่งป้อนข่าว</td>
                                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข และเปิด/ปิด การแสดงผลของข่าว</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input " type="checkbox" name="managenews_feeds"
                                            data-group="news">
                                    </div>
                                </td>
                            </tr>

                            <!-- ✅ จัดการสื่อประชาสัมพันธ์ -->
                            <tr class="text-start">
                                <td><i class="fas fa-images"></i> จัดการรูปภาพ</td>
                                <td>สิทธิ์ในการอัปโหลด ลบ และแก้ไขเนื้อหาจัดการรูปภาพ ปกเว็บ</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input " type="checkbox" name="manage_banner"
                                            data-group="banner">
                                    </div>
                                </td>
                            </tr>

                            <tr class="text-start">
                                <td><i class="fas fa-images"></i> จัดการจัดการอัลบั้ม</td>
                                <td>สิทธิ์ในการอัปโหลด ลบ และแก้ไขเนื้อหาจัดการรูปภาพ อัลบั้ม</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input " type="checkbox" name="manage_imageevent"
                                            data-group="banner">
                                    </div>
                                </td>
                            </tr>

                            <!-- ✅ จัดการแบบฟอร์มกิจกรรม -->
                            <tr class="text-start">
                                <td><i class="fas fa-clipboard-list"></i> จัดการแบบฟอร์มกิจกรรม</td>
                                <td>สิทธิ์ในการสร้างและจัดการหมวดหมู่ข้อมูลพื้นฐานกิจกรรม</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input " type="checkbox" name="manage_formevent"
                                            data-group="event">
                                    </div>
                                </td>
                            </tr>

                            <tr class="text-start">
                                <td><i class="fas fa-clipboard-list"></i> กรอกแบบฟอร์มกิจกรรม</td>
                                <td>สิทธิ์ในการกรอกข้อมูลกิจกรรม</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input " type="checkbox" name="form_event"
                                            data-group="event">
                                    </div>
                                </td>
                            </tr>

                            <tr class="text-start">
                                <td><i class="fas fa-user-tie"></i> เข้าถึงข้อมูลลูกค้า</td>
                                <td>สิทธิ์ในการเข้าถึงข้อมูลลูกค้า</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input event-permission" type="checkbox"
                                            name="view_customer" data-group="event">
                                    </div>
                                </td>
                            </tr>
                        </tbody>


                    </table>

                </div>
                <div class = 'mt-3 item-align-center'>

                <button type="submit" class="btn btn-success mt">สร้างบัญชีผู้ใช้</button>
                <a href="{{ route('requests.list') }}" class="btn btn-secondary">ยกเลิก</a>
                </div>
            </form>
            

        </div>

@endsection