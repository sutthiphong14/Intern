@extends('layouts.app')

<title>Nt |@yield('title')</title>
@section('content')


<style>
    .custom-btn {
        background-color: rgb(45, 43, 49);
        border: none;
        color: #fff;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .custom-btn:hover {
        background-color: rgb(60, 57, 65);
        transform: scale(1.05); /* ขยายปุ่มเล็กน้อย */
    }

    .custom-btn:active {
        transform: scale(0.95); /* ย่อเล็กลงเมื่อกด */
    }
</style>

<div class="d-flex justify-content-center align-items-center" 
     style="height: 100vh; background: url('{{ asset('dist/img/backlogin.png') }}') no-repeat center center fixed; 
            background-size: cover;">
    <div class="login-card card" style="width: 500px; padding: 2rem; border-radius: 15px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        
        <!-- โลโก้ตรงกลาง -->
        <div class="text-center mb-4">
            <img src="{{ asset('dist/img/ntlogo.png') }}" alt="NT Logo" style="height: 70px;">
        </div>

        <div class="card-body">
        @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username Field -->
                <div class="mb-3">
                    <label for="username" class="form-label">{{ __('ชื่อผู้ใช้') }}</label>
                    <input id="username" type="text" 
                           class="form-control @error('username') is-invalid @enderror" 
                           name="username" value="{{ old('username') }}" 
                           required autocomplete="username" autofocus>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-3">
    <label for="password" class="form-label">{{ __('รหัสผ่าน') }}</label>
    <div class="input-group">
        <input id="password" type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               name="password" required autocomplete="current-password">
        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
            {{ __('แสดง') }}
        </button>
    </div>
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

                <!-- Remember Me Checkbox -->
                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               name="remember" id="remember" 
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('จดจำผู้ใช้') }}
                        </label>
                    </div>
                    <a href="{{ route('insertRequests') }}" class="text-decoration-none">{{ __('ส่งคำขอเปิดใช้งาน') }}</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
        class="btn btn-primary w-100 mt-3 custom-btn">
    {{ __('Login') }}
</button>

            </form>

            
            
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const isPasswordVisible = passwordInput.type === 'password';
        passwordInput.type = isPasswordVisible ? 'text' : 'password';
        this.textContent = isPasswordVisible ? '{{ __('ซ่อน') }}' : '{{ __('แสดง') }}';
    });
</script>
@endsection