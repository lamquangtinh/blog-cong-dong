<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    // Dữ liệu form đặt lại mật khẩu hợp lệ, test nào cần thì ghi đè từng ô
    private function resetData(User $user, string $token, array $overrides = []): array
    {
        return array_merge([
            'token' => $token,
            'email' => $user->email,
            'password' => 'matkhaumoi123',
            'password_confirmation' => 'matkhaumoi123',
        ], $overrides);
    }

    public function test_forgot_password_page_and_login_link_are_available(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Quên mật khẩu?');
        $this->get(route('password.request'))->assertOk()->assertSee('Quên mật khẩu');
    }

    public function test_reset_link_is_sent_to_registered_email(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertSessionHas('success')
            ->assertSessionHasNoErrors();

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_unknown_email_gets_same_response_and_no_mail(): void
    {
        Notification::fake();

        // Phản hồi giống hệt email có thật, để không ai dò được email nào đã đăng ký
        $this->post(route('password.email'), ['email' => 'khongco@example.com'])
            ->assertSessionHas('success')
            ->assertSessionHasNoErrors();

        Notification::assertNothingSent();
    }

    public function test_invalid_email_format_is_rejected(): void
    {
        Notification::fake();

        $this->post(route('password.email'), ['email' => 'khong-phai-email'])
            ->assertSessionHasErrors('email');

        $this->post(route('password.email'), ['email' => ''])
            ->assertSessionHasErrors('email');

        Notification::assertNothingSent();
    }

    public function test_reset_mail_has_vietnamese_content_and_link(): void
    {
        $user = User::factory()->create();

        $mail = (new ResetPasswordNotification('token-thu-nghiem'))->toMail($user);

        $this->assertSame('Đặt lại mật khẩu - Blog Cộng Đồng', $mail->subject);
        $this->assertSame('Đặt lại mật khẩu', $mail->actionText);
        $this->assertStringContainsString('/reset-password/token-thu-nghiem', $mail->actionUrl);
        $this->assertStringContainsString('email=', $mail->actionUrl);
    }

    public function test_reset_form_opens_with_token_and_email(): void
    {
        $this->get(route('password.reset', ['token' => 'abc', 'email' => 'a@example.com']))
            ->assertOk()
            ->assertSee('Đặt lại mật khẩu')
            ->assertSee('a@example.com');
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create(); // mật khẩu cũ là "password"
        $token = Password::createToken($user);

        $this->post(route('password.update'), $this->resetData($user, $token))
            ->assertRedirect(route('login'))
            ->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('matkhaumoi123', $user->password));
        $this->assertFalse(Hash::check('password', $user->password));

        // Đăng nhập được bằng mật khẩu mới
        $this->post('/login', ['email' => $user->email, 'password' => 'matkhaumoi123'])
            ->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_token_cannot_be_used_twice(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $this->post(route('password.update'), $this->resetData($user, $token))
            ->assertRedirect(route('login'));

        $this->post(route('password.update'), $this->resetData($user, $token, [
            'password' => 'matkhauthuba1',
            'password_confirmation' => 'matkhauthuba1',
        ]))->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('matkhaumoi123', $user->fresh()->password));
    }

    public function test_invalid_token_is_rejected_and_password_unchanged(): void
    {
        $user = User::factory()->create();
        Password::createToken($user);

        $this->post(route('password.update'), $this->resetData($user, 'token-sai'))
            ->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_token_of_one_user_cannot_reset_another_account(): void
    {
        $owner = User::factory()->create();
        $victim = User::factory()->create();
        $token = Password::createToken($owner);

        $this->post(route('password.update'), $this->resetData($victim, $token))
            ->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('password', $victim->fresh()->password));
    }

    public function test_weak_or_mismatched_password_is_rejected(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $this->post(route('password.update'), $this->resetData($user, $token, [
            'password' => '123',
            'password_confirmation' => '123',
        ]))->assertSessionHasErrors('password');

        $this->post(route('password.update'), $this->resetData($user, $token, [
            'password_confirmation' => 'khac-hoan-toan',
        ]))->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_logged_in_user_is_redirected_away_from_forgot_password_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('password.request'))
            ->assertRedirect();
    }
}