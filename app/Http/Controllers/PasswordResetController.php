<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    // Form nhập email
    public function showLinkRequest(): View
    {
        return view('auth.forgot-password');
    }

    // Gửi liên kết đặt lại mật khẩu
    public function sendLink(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Cố ý bỏ qua kết quả trả về: luôn báo giống nhau dù email có đăng ký hay không,
        // để người lạ không dò được email nào đang có tài khoản trên trang.
        Password::sendResetLink(['email' => $data['email']]);

        Log::info('Yêu cầu đặt lại mật khẩu', ['email' => $data['email']]);

        return back()->with(
            'success',
            'Nếu email này đã đăng ký, chúng tôi vừa gửi liên kết đặt lại mật khẩu. Vui lòng kiểm tra hộp thư (liên kết có hiệu lực 60 phút).'
        );
    }

    // Form đặt mật khẩu mới (mở từ liên kết trong email)
    public function showReset(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // Lưu mật khẩu mới
    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                // Cột password có cast 'hashed' nên tự mã hóa khi gán
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                // Đăng xuất mọi thiết bị đang đăng nhập bằng mật khẩu cũ
                if (config('session.driver') === 'database') {
                    DB::table(config('session.table', 'sessions'))
                        ->where('user_id', $user->id)
                        ->delete();
                }

                event(new PasswordReset($user));

                Log::info('Đặt lại mật khẩu thành công', ['user_id' => $user->id]);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Đặt lại mật khẩu thành công. Hãy đăng nhập bằng mật khẩu mới.');
        }

        Log::warning('Đặt lại mật khẩu thất bại', ['email' => $request->input('email')]);

        // Token sai, hết hạn, đã dùng, hoặc email không khớp: cùng một thông báo
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __('passwords.token')]);
    }
}