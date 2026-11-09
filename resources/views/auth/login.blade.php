@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
    <div class="auth-card">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="auth-icon">🔐</div>
                <h1 class="h4 text-center mb-1">Chào mừng trở lại</h1>
                <p class="text-center text-muted mb-4">Đăng nhập để viết bài và bình luận.</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <a href="{{ route('password.request') }}" class="small">Quên mật khẩu?</a>
                        </div>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" id="remember" name="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Ghi nhớ đăng nhập</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Đăng nhập</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    Chưa có tài khoản? <a href="{{ route('register') }}" class="fw-semibold">Đăng ký</a>
                </p>
            </div>
        </div>
    </div>
@endsection