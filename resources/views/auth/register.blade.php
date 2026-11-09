@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
    <div class="auth-card">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="auth-icon">✍️</div>
                <h1 class="h4 text-center mb-1">Tạo tài khoản</h1>
                <p class="text-center text-muted mb-4">Tham gia cộng đồng và chia sẻ bài viết của bạn.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Họ tên</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu (tối thiểu 8 ký tự)</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Đăng ký</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    Đã có tài khoản? <a href="{{ route('login') }}" class="fw-semibold">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
@endsection