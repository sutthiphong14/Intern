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

    <h4 class="fw-bold py-2 mb-3">
        <a href="{{ route('home') }}">หน้าแรก</a> / <a href="{{ route('profile') }}"> รายชื่อผู้ใช้ </a>/ แก้ไขผู้ใช้งาน
    </h4>

    <div class="card mb-4">
        <h4 class="card-header">เพิ่มผู้ใช้งานระบบ</h4>
        

        <hr class="my-0" />
                            <!-- Form Start -->
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
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
                                                                        {{-- อัพโหลดรูปโปรไฟล์ --}}
                                    <div class="form-group">
                                    <label for="profile_image">รูปโปรไฟล์</label>
                                    <div id="image-preview">
                                    <img 
    id="profile-preview" 
    src="{{ $user->profile_image ? asset($user->profile_image) : asset('storage/profile_images/default_profile.jpg') }}" 
    class="user-profile-image mb-3" 
    style="max-width: 500px; max-height: 500px; object-fit: cover;">
    </div>
<input type="file" class="form-control-file mb-3" id="profile_image" name="profile_image" accept="image/*">
<input type="hidden" name="cropped_image" id="cropped_image">
<small class="form-text text-muted">อัพโหลดรูปโปรไฟล์ใหม่ (jpeg, png, jpg เท่านั้น ขนาดไม่เกิน 2MB)</small>

                                        <!-- Hidden input for cropped image -->
                                        <input type="hidden" id="cropped_image" name="cropped_image">

                                    </div>


                                    <div class="form-group mb-3">
    <label class='form-label text-dark' for="username">ชื่อผู้ใช้</label>
    <input type="text" class="form-control" id="username" name="username" required
        value="{{ old('username', $user->username) }}" disabled>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let profileImage = document.getElementById("profile_image");
    let previewImage = document.getElementById("profile-preview");
    let croppedImageInput = document.getElementById("cropped_image");

    let cropper;
    
    profileImage.addEventListener("change", function (event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(previewImage, {
                    aspectRatio: 1, // 1:1
                    viewMode: 2,
                    autoCropArea: 1,
                    scalable: false,
                    zoomable: false,
                    minCropBoxWidth: 200,
                    minCropBoxHeight: 200,
                    crop(event) {
                        let canvas = cropper.getCroppedCanvas({ width: 200, height: 200 });
                        croppedImageInput.value = canvas.toDataURL("image/png");
                    }
                });
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

@endsection