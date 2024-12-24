<!-- listRequests.blade.php -->
@extends('admins.index')
@section('title')
    รายการคำขอ
@endsection
@section('header')
    รายการคำขอ
@endsection

@section('css')
    <style>
        .request-profile-image {
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
                            <h3 class="card-title col-5">รายการคำขอ</h3>
                            <div class="input-group col-4">
                                <form action="{{ route('requests.search') }}" method="GET" class="d-flex w-100">
                                    <input type="text" name="query" class="form-control"
                                        placeholder="ค้นหาคำขอ..." value="{{ request('query') }}">
                                    <button type="submit" class="btn btn-info btn-dark">ค้นหา</button>
                                </form>
                            </div>

                            <a href="{{ route('insertRequests') }}" class="btn bg-success col-2">
                                <i class="d-flex justify-content-end"></i> เพิ่มคำขอ
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class='text-center'>
                                    <tr>
                                       
                                        <th>รหัสพนักงาน</th>
                                        <th>ผู้ร้องขอ</th>
                                        <th>ชื่อ-สกุล</th>
                                        <th>อีเมล</th>
                                        <th>เบอร์โทร</th>
                                        <th>รหัสผ่าน</th>
                                        <th>รายละเอียด</th>
                                        <th>วันที่ส่งคำขอ</th>
                                        <th>การดำเนินการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requests as $request)
                                        <tr>
                                            
                                            <td class="text-center">{{ $request->id_employee }}</td>
                                            <td>{{ $request->user_request }}</td>
                                            <td>{{ $request->name_request }}</td>
                                            <td>{{ $request->email_request }}</td>
                                            <td>{{ $request->phone_request }}</td>
                                            <td>{{ $request->password_request }}</td>
                                            <td>{{ $request->description_request }}</td>
                                            <td>{{ $request->created_at }}</td>
                                            <td class="text-center">
                                                <!-- ปุ่ม ยอมรับ -->
                                                <form action="{{ route('requests.approve', $request->id_request) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" 
                                                        onclick="return confirm('คุณแน่ใจหรือไม่ที่จะยอมรับคำขอนี้?')">ยอมรับ</button>
                                                </form>
                                            
                                                <!-- ปุ่ม แก้ไข -->
                                                <a href="{{ route('requests.edit', $request->id_request) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                            
                                                <!-- ปุ่ม ลบ -->
                                                <form action="{{ route('requests.delete', $request->id_request) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                        onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบคำขอนี้?')">ลบ</button>
                                                </form>
                                            </td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">ไม่มีข้อมูล</td>
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