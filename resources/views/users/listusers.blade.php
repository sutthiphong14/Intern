@extends('admins.index')
@section('title')
    รายการข้อมูล
@endsection
@section('header')
    รายการข้อมูล
@endsection

@section('css')
    <style>
        .user-profile-image {
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
                            <h3 class="card-title col-5">รายชื่อผู้ใช้</h3>
                            <div class="input-group col-4">
                                <form action="{{ route('users.search') }}" method="GET" class="d-flex w-100">
                                    <input type="text" name="query" class="form-control"
                                        placeholder="ค้นหาชื่อผู้ใช้..." value="{{ request('query') }}">
                                    <button type="submit" class="btn btn-info btn-dark">ค้นหา</button>
                                </form>
                            </div>

                            <a href="{{ route('insertusers') }}" class="btn bg-success col-2">
                                <i class="d-flex justify-content-end"></i> เพิ่มผู้ใช้งาน
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class='text-center'>
                                    <tr class="col-12">

                                        <th class='col-1'>รหัสพนักงาน</th>
                                        <th class='col-1'>รูปโปรไฟล์</th>
                                        <th class='col-2'>ชื่อ</th>
                                        <th class='col-3'>อีเมล</th>
                                        <th class='col-3'>username</th>
                                        <th class='col-3'>การดำเนินการ</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>

                                            <td class="text-center">{{ $user->id }}</td>
                                            <td class="text-center">
                                                @if ($user->profile_image)
                                                    <img src="{{ $user->profile_image }}" alt="Profile Image"
                                                        class="user-profile-image">
                                                @else
                                                    <img src="dist/img/defult_profile.jpg" alt="Default Profile Image"
                                                        class="user-profile-image">
                                                @endif
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm">แก้ไข</a>
                                                    <form action="{{ route('delete', $user->id) }}" method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                                                    </form>
                                                    


                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
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

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // การยืนยันการลบข้อมูลด้วย SweetAlert
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // ป้องกันการส่งฟอร์มทันที

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "ข้อมูลจะถูกลบและไม่สามารถกู้คืนได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // ส่งฟอร์มหากผู้ใช้ยืนยัน
                }
            });
        });
    });
</script>

<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: '{{ session('success') }}',
            confirmButtonText: 'ตกลง'
        });
    @endif
</script>
@endsection

