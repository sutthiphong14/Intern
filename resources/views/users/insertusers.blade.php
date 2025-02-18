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
    <h4 class="fw-bold py-2 mb-3">
        <a href="{{ route('home') }}">หน้าแรก</a> / <a href="{{ route('users.list') }}"> รายชื่อผู้ใช้ </a>/ เพิ่มผู้ใช้งาน
    </h4>

    <div class="card mb-4">
        <h4 class="card-header">เพิ่มผู้ใช้งานระบบ</h4>

        <hr class="my-0" />
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                        <label for="email" class="form-label text-dark">อีเมล</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="กรอกอีเมล" required
                            value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-dark">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="กรอกรหัสผ่าน"
                            required>
                    </div>




                    <div class="mb-3">
                        <label for="province_id" class="form-label">จังหวัด</label>
                        <select class="form-select" id="province_id" name="province_id" required>
                            <option value="" disabled selected>-- เลือกจังหวัด --</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="center_id" class="form-label">ศูนย์บริการ</label>
                        <select class="form-select" id="center_id" name="center_id" required disabled>
                            <option value="" disabled selected>-- เลือกศูนย์บริการ --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="department" class="form-label text-dark">แผนก</label>
                        <input type="text" class="form-control" id="department" name="department" placeholder="กรอกแผนก"
                            required value="{{ old('department') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark">สิทธิ์การใช้งาน</label>

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
                                                <input class="form-check-input user-permission" type="checkbox"
                                                    name="manage_users" data-group="users">
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

                        <div class="card-footer align-items-center text-center">
                            <button type="button" class="btn btn-danger"
                                onclick="window.location='{{ route('users.list') }}'">ยกเลิก</button>
                            <button type="submit" class="btn btn-success">ยืนยัน</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // On province_id change, load centers
            $('#province_id').change(function () {
                var provinceId = $(this).val();
                if (provinceId) {
                    $.ajax({
                        url: '/getCentersUser',
                        type: 'GET',
                        data: { province_id: provinceId },
                        success: function (data) {
                            $('#center_id').html('<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>');
                            $.each(data, function (key, center) {
                                $('#center_id').append('<option value="' + center.center_id + '">' + center.center_name + '</option>');
                            });
                            console.log($('#center_id').val()); // Check if it gets the correct value
                        },
                        error: function (xhr, status, error) {
                            alert('เกิดข้อผิดพลาดในการโหลดศูนย์บริการ');
                        }
                    });
                } else {
                    $('#center_id').html('<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>');
                }
            });

            // Form submission (Make sure center_id is selected)
            $('#yourForm').submit(function (e) {
                e.preventDefault(); // Prevent default form submission

                var centerId = $('#center_id').val();
                if (centerId === undefined || centerId === "") {
                    alert('กรุณาเลือกศูนย์บริการ');
                    return; // Stop form submission if no center is selected
                }

                // If all required data is ready, submit the form
                $.ajax({
                    url: $(this).attr('action'), // Use the form's action attribute
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        username: $('#username').val(),
                        province_id: $('#province_id').val(),
                        center_id: centerId,
                        name: $('#name').val(),
                        emp_id: $('#emp_id').val(),
                        department: $('#department').val(),
                        password: $('#password').val(),
                        email: $('#email').val()
                    },
                    success: function (response) {
                        // Handle success response, e.g., redirect or show a message
                    },
                    error: function (xhr, status, error) {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล');
                    }
                });
            });
        });

    </script>
    <script>
        $(document).ready(function () {
            // ล็อก dropdown ศูนย์บริการ ตอนโหลดหน้า
            $('#center_id').prop('disabled', true);

            // เมื่อเลือกจังหวัด
            $('#province_id').on('change', function () {
                let provinceId = $(this).val();

                if (provinceId) {
                    // ดึงข้อมูลศูนย์บริการจากเซิร์ฟเวอร์
                    $.ajax({
                        url: "{{ route('getCentersByProvince') }}",
                        type: "GET",
                        data: { province_id: provinceId },
                        success: function (data) {
                            $('#center_id').html('<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>');
                            $.each(data, function (key, value) {
                                $('#center_id').append('<option value="' + value.center_id + '">' + value.center_name + '</option>');
                            });
                            $('#center_id').prop('disabled', false); // ปลดล็อก
                        }
                    });
                } else {
                    $('#center_id').prop('disabled', true).html('<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>');
                }
            });
        });



        $(document).ready(function () {
            // เมื่อกด checkbox หลัก ให้เลือก-ยกเลิก checkbox ย่อยทั้งหมดในกลุ่มเดียวกัน
            $('.master-permission').on('change', function () {
                let group = $(this).data('group'); // ดึงชื่อกลุ่มจาก data-group
                let isChecked = $(this).prop('checked'); // ตรวจสอบว่า checkbox หลักถูกเลือกหรือไม่

                // ค้นหา checkbox ที่อยู่ในกลุ่มเดียวกัน และตั้งค่าตาม checkbox หลัก
                $('input[data-group="' + group + '"]').prop('checked', isChecked);
            });

            // เมื่อกด checkbox ย่อย ให้เช็คว่า checkbox หลักควรถูกเลือกหรือไม่
            $('input[class$="-permission"]').on('change', function () {
                let group = $(this).data('group'); // ดึงชื่อกลุ่มจาก data-group
                let allChecked = $('input[data-group="' + group + '"]:not(.master-permission):checked').length ===
                    $('input[data-group="' + group + '"]:not(.master-permission)').length;

                // ถ้า checkbox ย่อยถูกเลือกทั้งหมด checkbox หลักต้องถูกเลือกด้วย
                $('input.master-permission[data-group="' + group + '"]').prop('checked', allChecked);
            });
        });


    </script>
@endsection