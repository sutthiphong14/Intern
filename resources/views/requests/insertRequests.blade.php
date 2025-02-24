<!-- insertRequests.blade.php -->
@extends('admins.index')
@section('title')
    เพิ่มคำขอ
@endsection
@section('header')
    เพิ่มคำขอ
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning mt-2">
                        <div class="card-header">
                            <h3 class="card-title">เพิ่มคำขอใหม่</h3>
                        </div>

                        <form method="POST" action="{{ route('requests.store') }}">
                            @csrf
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

                                <div class="form-group">
                                    <label for="id_employee_request">รหัสพนักงาน</label>
                                    <input type="text" class="form-control" id="id_employee_request"
                                        name="id_employee_request" value="{{ old('id_employee_request') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="user_request">ผู้ร้องขอ</label>
                                    <input type="text" class="form-control" id="user_request" name="user_request"
                                        value="{{ old('user_request') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="name_request">ชื่อ-สกุล</label>
                                    <input type="text" class="form-control" id="name_request" name="name_request"
                                        value="{{ old('name_request') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="email_request">อีเมล</label>
                                    <input type="email" class="form-control" id="email_request" name="email_request"
                                        value="{{ old('email_request') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="password_request">รหัสผ่าน</label>
                                    <input type="password" id="password_request" name="password_request"
                                        class="form-control" placeholder="กรอกรหัสผ่าน...">
                                </div>

                                <div class="form-group">
                                    <label for="department_request">แผนก</label>
                                    <textarea class="form-control" id="department_request" name="department_request"
                                        rows="3" required>{{ old('department_request') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="description_request">รายละเอียด</label>
                                    <textarea class="form-control" id="description_request" name="description_request"
                                        rows="3" required>{{ old('description_request') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="province_id_request" class="form-label">จังหวัด</label>
                                    <select class="form-select" id="province_id_request" name="province_id_request" required>
                                        <option value="" disabled selected>-- เลือกจังหวัด --</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="center_id_request" class="form-label">ศูนย์บริการ</label>
                                    <select class="form-select" id="center_id_request" name="center_id_request" required disabled>
                                        <option value="" disabled selected>-- เลือกศูนย์บริการ --</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="department" class="form-label text-dark">แผนก</label>
                                    <input type="text" class="form-control" id="department" name="department"
                                        placeholder="กรอกแผนก" required value="{{ old('department') }}">
                                </div>

                                <div class="card-footer text-center">
                                    <button type="button" class="btn btn-danger"
                                        onclick="window.location='{{ route('requests.list') }}'">ยกเลิก</button>
                                    <button type="submit" class="btn btn-success">บันทึก</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
    $('#province_id').on('change', function () {
        var provinceId = $(this).val();

        if (provinceId) {
            $.ajax({
                url: "{{ route('getCentersByProvince') }}",
                type: "GET",
                data: { province_id: provinceId },
                success: function (data) {
                    $('#center_id_request').html('<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>');
                    if (data.length === 0) {
                        $('#center_id_request').append('<option value="" disabled>-- ไม่มีศูนย์บริการ --</option>');
                    } else {
                        $.each(data, function (key, center) {
                            $('#center_id_request').append('<option value="' + center.center_id + '">' + center.center_name + '</option>');
                        });
                    }
                    $('#center_id_request').prop('disabled', false);
                },
                error: function (xhr, status, error) {
                    console.log('Error:', error);
                    alert('เกิดข้อผิดพลาดในการโหลดศูนย์บริการ');
                }
            });
        } else {
            $('#center_id_request').html('<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>').prop('disabled', true);
        }
    });
});


    </script>
    <script>
        $(document).ready(function () {
    $('#province_id_request').on('change', function () {
        var provinceId = $(this).val();

        if (provinceId) {
            $.ajax({
                url: "{{ route('getCentersByProvince') }}",  // ใช้ route ที่ถูกต้อง
                type: "GET",
                data: { province_id: provinceId },
                success: function (data) {
                    $('#center_id_request').html('<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>');
                    if (data.length === 0) {
                        $('#center_id_request').append('<option value="" disabled>-- ไม่มีศูนย์บริการ --</option>');
                    } else {
                        $.each(data, function (key, value) {
                            $('#center_id_request').append('<option value="' + value.center_id + '">' + value.center_name + '</option>');
                        });
                    }
                    $('#center_id_request').prop('disabled', false);
                },
                error: function (xhr, status, error) {
                    console.log('Error:', error); // ดู error ที่เกิดขึ้นใน console
                    alert('เกิดข้อผิดพลาดในการโหลดศูนย์บริการ');
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