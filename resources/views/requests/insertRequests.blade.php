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
                                <label for="id_employee">รหัสพนักงาน</label>
                                <input type="text" class="form-control" id="id_employee" name="id_employee" required>
                            </div>

                            <div class="form-group">
                                <label for="user_request">ผู้ร้องขอ</label>
                                <input type="text" class="form-control" id="user_request" name="user_request" required>
                            </div>

                            <div class="form-group">
                                <label for="name_request">ชื่อ-สกุล</label>
                                <input type="text" class="form-control" id="name_request" name="name_request" required>
                            </div>

                            <div class="form-group">
                                <label for="email_request">อีเมล</label>
                                <input type="email" class="form-control" id="email_request" name="email_request" required>
                            </div>

                            <div class="form-group">
                                <label for="phone_request">เบอร์โทร</label>
                                <input type="text" class="form-control" id="phone_request" name="phone_request" required>
                            </div>

                            <div class="form-group">
                                <label for="password_request">รหัสผ่าน</label>
                                <input type="password" id="password_request" name="password_request" class="form-control"
                                    placeholder="กรอกรหัสผ่าน...">
                            </div>

                            <div class="form-group">
                                <label for="description_request">รายละเอียด</label>
                                <textarea class="form-control" id="description_request" name="description_request" rows="3" required></textarea>
                            </div>
                        </div>


                        <div class="card-footer text-center">
                            <button type="button" class="btn btn-danger" onclick="window.location='{{ route('requests.list') }}'">ยกเลิก</button>
                            <button type="submit" class="btn btn-success">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection