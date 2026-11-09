@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('content')
    <div class="auth-card">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="auth-icon">🔑</div>
                <h1 class="h4 text-center mb-1">Đặt lại mật khẩu</h1>
                <p class="text-center text-muted mb-4">Chọn một mật khẩu mới cho tài khoản của bạn.</p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $email) }}"
                               class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu mới (tối thiểu 8 ký tự)</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required autofocus>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Nhập lại mật khẩu mới</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Đặt lại mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
@endsection