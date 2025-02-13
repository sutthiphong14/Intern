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

                <label for="province_id" class="form-label">จังหวัด</label>
                <select class="form-select" id="province_id" name="province_id" required>
                    <option value="" disabled selected>-- เลือกจังหวัด --</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                    @endforeach
                </select>

                <label for="center_id" class="form-label">ศูนย์บริการ</label>
                <select class="form-select" id="center_id" name="center_id" required>
                    <option value="" disabled selected>-- เลือกศูนย์บริการ --</option>
                </select>



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

                <!-- Other fields like permission... -->

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
@endsection