@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
    <div class="auth-card">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="auth-icon">✉️</div>
                <h1 class="h4 text-center mb-1">Quên mật khẩu</h1>
                <p class="text-center text-muted mb-4">
                    Nhập email đã đăng ký, chúng tôi sẽ gửi liên kết để bạn đặt lại mật khẩu.
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Gửi liên kết đặt lại mật khẩu</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    <a href="{{ route('login') }}">&larr; Quay lại đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
@endsection