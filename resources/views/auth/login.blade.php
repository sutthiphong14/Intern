@extends('layouts.app')


@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh; background: linear-gradient(135deg, #ecd716, #ddc806);">
    <div class="login-card card" style="width: 500px; padding: 2rem; border-radius: 15px; background-color: #fff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        
        <!-- โลโก้ตรงกลาง -->
        <div class="text-center mb-4">
            <img src="{{ asset('dist/img/ntlogo.png') }}" alt="NT Logo" style="height: 70px;">
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" 
                           required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="current-password">
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
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-decoration-none">{{ __('Forgot Password?') }}</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 mt-3" style="background-color: #646461; border: none;">
                    {{ __('Login') }}
                </button>
            </form>

            <!-- Sign Up Link -->
            <p class="text-center mt-4">
                {{ __("Don't have an account?") }} <a href="/register" class="text-decoration-none">{{ __('register') }}</a>
            </p>
        </div>
    </div>
</div>
@endsection

