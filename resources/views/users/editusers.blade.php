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
    <section class="content">

    <h4 class="fw-bold py-2 mb-3">
        <a href="{{ route('home') }}">หน้าแรก</a> / <a href="{{ route('users.list') }}"> รายชื่อผู้ใช้ </a>/ เพิ่มผู้ใช้งาน
    </h4>

    <div class="card mb-4">
        <h4 class="card-header">เพิ่มผู้ใช้งานระบบ</h4>
        

        <hr class="my-0" />



                            <!-- Form Start -->
                            <form method="POST" action="{{ route('users.update', $user->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')  {{-- แก้ปัญหา "PUT method is not supported" --}}

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

                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <div class="form-group mb-3">
                                        <label class = 'form-label text-dark' for="username">ชื่อผู้ใช้</label>
                                        <input type="text" class="form-control" id="username" name="username" required
                                            value="{{ old('username', $user->username) }}">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class = 'form-label text-dark' for="name">ชื่อ-นามสกุล</label>
                                        <input type="text" class="form-control" id="name" name="name" required
                                            value="{{ old('name', $user->name) }}">
                                    </div>

                                    <div class="form-group mb-3 ">
                                        <label class = 'form-label text-dark' for="emp_id">รหัสพนักงาน</label>
                                        <input type="text" class="form-control" id="emp_id" name="emp_id" required
                                            value="{{ old('emp_id', $user->emp_id) }}">
                                    </div>

                                    <div class="form-group mb-3 ">
                                        <label class = 'form-label text-dark' for="department">สังกัด</label>
                                        <input type="text" class="form-control" id="department" name="department" required
                                            value="{{ old('department', $user->department) }}">
                                    </div>

                                    <div class="form-group mb-3 ">
                                        <label class = 'form-label text-dark' for="email">อีเมล</label>
                                        <input type="email" class="form-control" id="email" name="email" required
                                            value="{{ old('email', $user->email) }}">
                                    </div>

                                    <div class="form-group mb-3 ">
                                        <label class = 'form-label text-dark' for="password">รหัสผ่าน (เว้นว่างถ้าไม่ต้องการเปลี่ยน)</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="กรอกรหัสผ่านใหม่ถ้าต้องการเปลี่ยน">
                                    </div>

                                    {{-- จังหวัด --}}
                                    <div class="form-group mb-3 ">
                                        <label class = 'form-label text-dark' for="province_id">จังหวัด</label>
                                        <select class="form-control" id="province_id" name="province_id">
                                            <option value="">-- เลือกจังหวัด --</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->province_id }}" {{ $user->province_id == $province->province_id ? 'selected' : '' }}>
                                                    {{ $province->province_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- ศูนย์บริการ --}}
                                    <div class="form-group mb-3 ">
                                        <label class = 'form-label text-dark' for="center_id">ศูนย์บริการ</label>
                                        <select class="form-control" id="center_id" name="center_id">
                                            <option value="">-- เลือกศูนย์บริการ --</option>
                                            @foreach ($centers as $center)
                                                <option value="{{ $center->center_id }}" {{ $user->center_id == $center->center_id ? 'selected' : '' }}>
                                                    {{ $center->center_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- {{-- อัพโหลดรูปโปรไฟล์ --}}
            <div class="form-group">
                <label for="profile_image">รูปโปรไฟล์</label>
                @if ($user->profile_image)
                    <div class="mb-3">
                        <img src="{{ $user->profile_image }}" alt="Profile Image" class="img-fluid" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                    </div>
                @else
                    <img src="{{ asset('dist/img/defult_profile.jpg') }}" alt="Default Profile Image" class="img-size-50 img-circle mr-2">
                @endif
                <input type="file" class="form-control-file" id="profile_image" name="profile_image" accept="image/*">
                <small class="form-text text-muted">อัพโหลดรูปโปรไฟล์ใหม่ (jpeg, png, jpg เท่านั้น ขนาดไม่เกิน 2MB)</small>
            </div>
        </div> -->

                                    {{-- สิทธิ์การใช้งาน --}}
                                    {{-- สิทธิ์การใช้งาน --}}
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
                <tr class="text-start">
                    <td><i class="fas fa-user-shield"></i> ตั้งค่าสิทธิ์แอดมิน</td>
                    <td>กำหนดสิทธิ์การเข้าถึงระดับแอดมิน</td>
                    <td class="text-center">
                        <input class="form-check-input user-permission" type="checkbox" name="adminper_mission" 
                            {{ $user->permission['adminper_mission'] ?? false ? 'checked' : '' }} data-group="users">
                    </td>
                </tr>
            @endif

            <tr class="text-start">
                <td><i class="fas fa-users-cog"></i> จัดการผู้ใช้งานระบบ</td>
                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข และกำหนดสิทธิ์ให้ผู้ใช้งานระบบ</td>
                <td class="text-center">
                    <input class="form-check-input user-permission" type="checkbox" name="manage_users" 
                        {{ $user->permission['manage_users'] ?? false ? 'checked' : '' }} data-group="users">
                </td>
            </tr>

            <tr class="text-start">
                <td><i class="fas fa-chart-line"></i> จัดการหน้าแดชบอร์ด</td>
                <td>สิทธิ์ในการอัปโหลด ลบ แก้ไข หน้าแดชบอร์ด</td>
                <td class="text-center">
                    <input class="form-check-input dashboard-permission" type="checkbox" name="manage_dashboard" 
                        {{ $user->permission['manage_dashboard'] ?? false ? 'checked' : '' }} data-group="dashboard">
                </td>
            </tr>

            <tr class="text-start">
                <td><i class="fas fa-chart-line"></i> ดูข้อมูลแดชบอร์ด</td>
                <td>สิทธิ์ในการดูข้อมูลแดชบอร์ดทุกหน้า</td>
                <td class="text-center">
                    <input class="form-check-input dashboard-permission" type="checkbox" name="view_fttx" 
                        {{ $user->permission['view_fttx'] ?? false ? 'checked' : '' }} data-group="dashboard">
                </td>
            </tr>

            <tr class="text-start">
                <td><i class="fas fa-newspaper"></i> จัดการแหล่งป้อนข่าว</td>
                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข และเปิด/ปิด การแสดงผลของข่าว</td>
                <td class="text-center">
                    <input class="form-check-input" type="checkbox" name="managenews_feeds" 
                        {{ $user->permission['managenews_feeds'] ?? false ? 'checked' : '' }} data-group="news">
                </td>
            </tr>

            <tr class="text-start">
                <td><i class="fas fa-images"></i> จัดการรูปภาพ</td>
                <td>สิทธิ์ในการอัปโหลด ลบ และแก้ไขเนื้อหาจัดการรูปภาพ ปกเว็บ</td>
                <td class="text-center">
                    <input class="form-check-input" type="checkbox" name="manage_banner" 
                        {{ $user->permission['manage_banner'] ?? false ? 'checked' : '' }} data-group="banner">
                </td>
            </tr>

            <tr class="text-start">
                <td><i class="fas fa-images"></i> จัดการอัลบั้ม</td>
                <td>สิทธิ์ในการอัปโหลด ลบ และแก้ไขเนื้อหาจัดการรูปภาพ อัลบั้ม</td>
                <td class="text-center">
                    <input class="form-check-input" type="checkbox" name="manage_imageevent" 
                        {{ $user->permission['manage_imageevent'] ?? false ? 'checked' : '' }} data-group="banner">
                </td>
            </tr>

            <tr class="text-start">
                <td><i class="fas fa-clipboard-list"></i> จัดการแบบฟอร์มกิจกรรม</td>
                <td>สิทธิ์ในการสร้างและจัดการหมวดหมู่ข้อมูลพื้นฐานกิจกรรม</td>
                <td class="text-center">
                    <input class="form-check-input" type="checkbox" name="manage_formevent" 
                        {{ $user->permission['manage_formevent'] ?? false ? 'checked' : '' }} data-group="event">
                </td>
            </tr>

            <tr class="text-start">
                <td><i class="fas fa-clipboard-list"></i> กรอกแบบฟอร์มกิจกรรม</td>
                <td>สิทธิ์ในการกรอกข้อมูลกิจกรรม</td>
                <td class="text-center">
                    <input class="form-check-input" type="checkbox" name="form_event" 
                        {{ $user->permission['form_event'] ?? false ? 'checked' : '' }} data-group="event">
                </td>
            </tr>

            <tr class="text-start">
                <td><i class="fas fa-user-tie"></i> เข้าถึงข้อมูลลูกค้า</td>
                <td>สิทธิ์ในการเข้าถึงข้อมูลลูกค้า</td>
                <td class="text-center">
                    <input class="form-check-input event-permission" type="checkbox" name="view_customer" 
                        {{ $user->permission['view_customer'] ?? false ? 'checked' : '' }} data-group="event">
                </td>
            </tr>
        </tbody>
    </table>
</div>



                                    <div class="card-footer text-center">
                                        <button type="button" class="btn btn-danger"
                                            onclick="window.location='{{ route('users.list') }}'">ยกเลิก</button>
                                        <button type="submit" class="btn btn-success">อัปเดต</button>
                                    </div>
                            </form>
                        </div>
                    </div>

    </section>
@endsection

@section('script')

    <script>
        $(function () {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>
        document.getElementById('province_id').addEventListener('change', function () {
            let provinceId = this.value;
            let centerSelect = document.getElementById('center_id');

            centerSelect.innerHTML = '<option value="">-- เลือกศูนย์บริการ --</option>'; // เคลียร์ค่าเดิม

            if (provinceId) {
                fetch(`/get-centers/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(center => {
                            let option = document.createElement('option');
                            option.value = center.center_id;
                            option.textContent = center.center_name;
                            centerSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching centers:', error));
            }
        });
    </script>
@endsection