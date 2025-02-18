@extends('admins.index')

@section('css')

    <style>
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 160px);
        }

        .profile-card {
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-image-container {
            position: relative;
            cursor: pointer;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #007bff;
            transition: opacity 0.3s ease;
        }

        .profile-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 50%;
        }

        .profile-image-container:hover .profile-image {
            opacity: 0.7;
        }

        .profile-image-container:hover .profile-image-overlay {
            opacity: 1;
        }

        .upload-icon {
            color: white;
            font-size: 30px;
        }

        .hidden-file-input {
            display: none;
        }
    </style>

@endsection

@section('content')

    <div class="card mb-4">
        <h5 class="card-header">รายละเอียดบัญชี</h5>
        <!-- Account -->
        <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                @if ($user->profile_image)
                    <img src="{{ $user->profile_image }}" alt="user-avatar" class="d-block rounded" height="100" width="100"
                        id="uploadedAvatar">
                @else
                    <img src="dist/img/defult_profile.jpg" alt="user-avatar" class="d-block rounded" height="100" width="100"
                        id="uploadedAvatar">
                @endif

                <form id="profileImageForm" action="{{ route('profile.update-image') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-warning me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">แก้ไขบัญชี</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" class="account-file-input" name="profile_image" hidden
                                accept="image/png, image/jpeg" />
                        </label>
                    </div>
                </form>
            </div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="firstName" class="form-label">ชื่อผู้ใช้งาน</label>
                    <h4>{{ $user->username }}</h4>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="lastName" class="form-label">ชื่อ-นามสกุล</label>
                    <h4>{{ $user->name }}</h4>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="firstName" class="form-label">รหัสพนักงาน</label>
                    <h4>{{ $user->emp_id }}</h4>
                </div>
                
                <div class="mb-3 col-md-6">
                    <label for="lastName" class="form-label">อีเมล</label>
                    <h4>{{ $user->email }}</h4>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="province" class="form-label">จังหวัด</label>
                    <h4>{{ $provinceName }}</h4>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="center" class="form-label">ศูนย์บริการ</label>
                    <h4>{{ $centerName }}</h4>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="lastName" class="form-label">แผนก</label>
                    <h4>{{ $user->department }}</h4>
                </div>
            </div>
        </div>
        <!-- /Account -->
    </div>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profileImageContainer = document.querySelector('.profile-image-container');
            const profileImageInput = document.getElementById('profileImageInput');
            const profileImageForm = document.getElementById('profileImageForm');

            // Trigger file input when clicking on profile image
            profileImageContainer.addEventListener('click', function () {
                profileImageInput.click();
            });

            // Submit form automatically when file is selected
            profileImageInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    profileImageForm.submit();
                }
            });
        });
    </script>
@endsection