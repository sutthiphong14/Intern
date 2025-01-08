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
<div class="card ">
    <div class="d-flex justify-content-between align-items-center gap-2">
        <!-- หัวข้อ -->
        <h4 class="card-header text-dark">
            รายชื่อผู้ใช้
        </h4>

        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('users.search') }}" method="GET" class="d-flex w-200">
                <input type="text" name="query" class="form-control" placeholder="ค้นหาชื่อผู้ใช้..."
                    value="{{ request('query') }}">
                <button type="submit" class="btn btn-info btn-dark">ค้นหา</button>
            </form>
            <a href="{{ route('insertusers') }}" class="btn bg-success col-4 me-4">
                <i class="d-flex justify-content-end"></i> เพิ่มผู้ใช้งาน
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive ">
            <table class="table table-hover">
                <thead class='text-center bg-dark'>
                    <tr class="col-12">
                        <th class='col-3'>username</th>
                        <th class='col-1'>รูปโปรไฟล์</th>
                        <th class='col-3'>ชื่อ-นามสกุล</th>
                        <th class='col-2'>อีเมล</th>
                        <th class='col-3'>การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody class='table-border-bottom-0 text-center'>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td class="text-center">
                                <img id="profile-image" src="{{ $user->profile_image ?? 'dist/img/defult_profile.jpg' }}" 
                                     alt="Profile Image" class="user-profile-image">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" 
                                            data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> แก้ไข
                                        </a>
                                        <form action="{{ route('delete', $user->id) }}" method="POST" 
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" 
                                                    style="border: none; background: none;">
                                                <i class="bx bx-trash me-1"></i> ลบ
                                            </button>
                                        </form>
                                    </div>
                                </div>
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

    <!-- Pagination -->
    <div class="d-flex justify-content-center align-items-center me-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{-- ลิงก์หน้าแรกสุด --}}
                @if ($users->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->appends(request()->query())->url(1) }}">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->appends(request()->query())->previousPageUrl() }}">
                            <i class="tf-icon bx bx-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- หมายเลขหน้า --}}
                @foreach ($users->appends(request()->query())->getUrlRange(1, $users->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                {{-- ลิงก์หน้าถัดไป --}}
                @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->appends(request()->query())->nextPageUrl() }}">
                            <i class="tf-icon bx bx-chevron-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->appends(request()->query())->url($users->lastPage()) }}">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="tf-icon bx bx-chevron-right"></i></span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="tf-icon bx bx-chevrons-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
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