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
    <h5 class="card-header">Profile Details</h5>
    <!-- Account -->
    <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
            @if ($user->profile_image)
                <img src="{{ $user->profile_image }}" alt="user-avatar" class="d-block rounded" height="100" width="100"
                id="uploadedAvatar" >
            @else
                <img src="dist/img/defult_profile.jpg" alt="user-avatar" class="d-block rounded" height="100" width="100"
                id="uploadedAvatar" >
            @endif

            <form id="profileImageForm" action="{{ route('profile.update-image') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">Upload new photo</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input type="file" id="upload" class="account-file-input"  name="profile_image" hidden accept="image/png, image/jpeg" />
                </label>
                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                    <i class="bx bx-reset d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Reset</span>
                </button>

                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
            </div>
            </form>




        </div>
    </div>
    <hr class="my-0" />
    <div class="card-body">
        <form id="formAccountSettings" method="POST" onsubmit="return false">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input class="form-control" type="text" id="firstName" name="firstName" value="John" autofocus />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input class="form-control" type="text" name="lastName" id="lastName" value="Doe" />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input class="form-control" type="text" id="email" name="email" value="john.doe@example.com"
                        placeholder="john.doe@example.com" />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="organization" class="form-label">Organization</label>
                    <input type="text" class="form-control" id="organization" name="organization"
                        value="ThemeSelection" />
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="phoneNumber">Phone Number</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">US (+1)</span>
                        <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                            placeholder="202 555 0111" />
                    </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="state" class="form-label">State</label>
                    <input class="form-control" type="text" id="state" name="state" placeholder="California" />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="zipCode" class="form-label">Zip Code</label>
                    <input type="text" class="form-control" id="zipCode" name="zipCode" placeholder="231465"
                        maxlength="6" />
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="country">Country</label>
                    <select id="country" class="select2 form-select">
                        <option value="">Select</option>
                        <option value="Australia">Australia</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Brazil">Brazil</option>
                        <option value="Canada">Canada</option>
                        <option value="China">China</option>
                        <option value="France">France</option>
                        <option value="Germany">Germany</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Japan">Japan</option>
                        <option value="Korea">Korea, Republic of</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Russia">Russian Federation</option>
                        <option value="South Africa">South Africa</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="language" class="form-label">Language</label>
                    <select id="language" class="select2 form-select">
                        <option value="">Select Language</option>
                        <option value="en">English</option>
                        <option value="fr">French</option>
                        <option value="de">German</option>
                        <option value="pt">Portuguese</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="timeZones" class="form-label">Timezone</label>
                    <select id="timeZones" class="select2 form-select">
                        <option value="">Select Timezone</option>
                        <option value="-12">(GMT-12:00) International Date Line West</option>
                        <option value="-11">(GMT-11:00) Midway Island, Samoa</option>
                        <option value="-10">(GMT-10:00) Hawaii</option>
                        <option value="-9">(GMT-09:00) Alaska</option>
                        <option value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
                        <option value="-8">(GMT-08:00) Tijuana, Baja California</option>
                        <option value="-7">(GMT-07:00) Arizona</option>
                        <option value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                        <option value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
                        <option value="-6">(GMT-06:00) Central America</option>
                        <option value="-6">(GMT-06:00) Central Time (US & Canada)</option>
                        <option value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                        <option value="-6">(GMT-06:00) Saskatchewan</option>
                        <option value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                        <option value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
                        <option value="-5">(GMT-05:00) Indiana (East)</option>
                        <option value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
                        <option value="-4">(GMT-04:00) Caracas, La Paz</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="currency" class="form-label">Currency</label>
                    <select id="currency" class="select2 form-select">
                        <option value="">Select Currency</option>
                        <option value="usd">USD</option>
                        <option value="euro">Euro</option>
                        <option value="pound">Pound</option>
                        <option value="bitcoin">Bitcoin</option>
                    </select>
                </div>
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
            </div>
        </form>
    </div>
    <!-- /Account -->
</div>


<div class="profile-container">
    <div class="col-md-4">
        <div class="card card-primary card-outline profile-card">
            <div class="card-body box-profile text-center">
                <form id="profileImageForm" action="{{ route('profile.update-image') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="profileImageInput" name="profile_image" class="hidden-file-input"
                        accept="image/*">

                    <div class="profile-image-container text-center">

                        @if ($user->profile_image)
                            <img src="{{ $user->profile_image }}" alt="User profile picture" id="profileImage"
                                class="profile-user-img img-fluid img-circle profile-image">
                        @else
                            <img src="dist/img/defult_profile.jpg" alt="Default Profile Image" id="profileImage"
                                class="profile-user-img img-fluid img-circle profile-image">
                        @endif

                        <div class="profile-image-overlay">
                            <i class="fas fa-camera upload-icon"></i>
                        </div>
                    </div>
                </form>

                <h3 class="profile-username text-center mt-3">{{ $user->username }}</h3>

                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>name : </strong>
                            <span>{{ $user->name }}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>email : </strong>
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