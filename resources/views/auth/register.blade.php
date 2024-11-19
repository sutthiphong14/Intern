@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="height: 100vh; background: linear-gradient(135deg, #ecd716, #ddc806); font-family: 'Kanit', sans-serif;">
    <div class="login-card p-4 bg-white rounded shadow" style="width: 500px;">
        <!-- โลโก้ -->
        <img src="/dist/img/ntlogo.png" alt="NT Logo" class="brand-image mb-4" style="display: block; margin: 0 auto; height: 70px;">

        <!-- ฟอร์ม -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="background-color: #646461; border: none;">Register</button>
        </form>

        <p class="text-center mt-4">
            Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign In</a>
        </p>
    </div>
</div>
@endsection
