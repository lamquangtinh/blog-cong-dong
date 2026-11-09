<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

// Kế thừa thông báo có sẵn của Laravel (đã dựng đúng liên kết và token),
// chỉ viết lại nội dung email bằng tiếng Việt
class ResetPasswordNotification extends ResetPassword
{
    protected function buildMailMessage($url)
    {
        $minutes = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        return (new MailMessage)
            ->subject('Đặt lại mật khẩu - Blog Cộng Đồng')
            ->greeting('Xin chào!')
            ->line('Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.')
            ->action('Đặt lại mật khẩu', $url)
            ->line("Liên kết này có hiệu lực trong {$minutes} phút và chỉ dùng được một lần.")
            ->line('Nếu bạn không yêu cầu đặt lại mật khẩu, hãy bỏ qua email này. Tài khoản của bạn vẫn an toàn.')
            ->salutation('Blog Cộng Đồng');
    }
}