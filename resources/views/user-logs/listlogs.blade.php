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

<div class="container mt-5">
    <div class="card ">
        <h4 class='card-header'>User Logs</h4>

        <div class="d-flex justify-content-between align-items-center gap-2">

        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table class="table table-hover">

                    <table class="table table-hover">
                        <thead class='text-center bg-dark'>
                            <tr>
                                <th>User Name</th>
                                <th>Model</th>
                                <th>Action</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                                        <tr>
                                                            <td>@if($log->user)
                                                                {{ $log->user->username }}
                                                            @else
                                                                N/A
                                                            @endif
                                                            </td>
                                                            <td>{{ $log->model }}</td>
                                                            <td>
                                                                @php
                                                                    $data = json_decode($log->data, true);
                                                                @endphp
                                                                {{ $data['message'] ?? 'ไม่มีข้อความ' }} {{ $data['username'] ?? 'N/A' }}

                                                            </td>


                                                            <td>{{ $log->created_at->format('m-d-Y / H:i') }}</td>
                                                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    // เก็บรูปภาพลงใน Local Storage
    const profileImage = document.getElementById('profile-image');
    localStorage.setItem('profileImage', profileImage.src);

    // โหลดรูปภาพจาก Local Storage เมื่อเปลี่ยน section
    window.addEventListener('DOMContentLoaded', () => {
        const storedImage = localStorage.getItem('profileImage');
        if (storedImage) {
            profileImage.src = storedImage;
        }
    });
</script>

<script>
    // การยืนยันการลบข้อมูลด้วย SweetAlert
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
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