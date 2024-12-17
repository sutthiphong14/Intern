@extends('admins.index')

@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
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
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
        background: rgba(0,0,0,0.5);
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
<div class="profile-container">
    <div class="col-md-4">
        <div class="card card-primary card-outline profile-card">
            <div class="card-body box-profile text-center">
                <form id="profileImageForm" action="{{ route('profile.update-image') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="profileImageInput" name="profile_image" class="hidden-file-input" accept="image/*">
                    
                    <div class="profile-image-container text-center">
                        <img id="profileImage" class="profile-user-img img-fluid img-circle profile-image" 
                             src="{{ $user->profile_image ? Storage::url($user->profile_image) : 'dist/img/default-user.png' }}" 
                             alt="User profile picture">
                        <div class="profile-image-overlay">
                            <i class="fas fa-camera upload-icon"></i>
                        </div>
                    </div>
                </form>

                <h3 class="profile-username text-center mt-3">{{ $user->username }}</h3>

                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Email</strong>
                            <span>{{ $user->email }}</span>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileImageContainer = document.querySelector('.profile-image-container');
    const profileImageInput = document.getElementById('profileImageInput');
    const profileImageForm = document.getElementById('profileImageForm');

    // Trigger file input when clicking on profile image
    profileImageContainer.addEventListener('click', function() {
        profileImageInput.click();
    });

    // Submit form automatically when file is selected
    profileImageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            profileImageForm.submit();
        }
    });
});
</script>
@endsection