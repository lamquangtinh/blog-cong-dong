<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->post('/register', [
            'name' => 'Nguyen Van A',
            'email' => 'a@example.com',
            'password' => 'matkhau123',
            'password_confirmation' => 'matkhau123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'a@example.com', 'role' => 'member']);
    }

    public function test_register_fails_with_invalid_data(): void
    {
        User::factory()->create(['email' => 'trung@example.com']);

        $response = $this->post('/register', [
            'name' => 'Nguyen Van B',
            'email' => 'trung@example.com',   // email đã tồn tại
            'password' => '123',              // quá ngắn
            'password_confirmation' => '456', // không khớp
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
    }

    public function test_register_cannot_set_admin_role(): void
    {
        $this->post('/register', [
            'name' => 'Ke Gian',
            'email' => 'gian@example.com',
            'password' => 'matkhau123',
            'password_confirmation' => 'matkhau123',
            'role' => 'admin', // cố tình gửi thêm để tự phong quản trị viên
        ]);

        $this->assertDatabaseHas('users', ['email' => 'gian@example.com', 'role' => 'member']);
    }

    public function test_user_can_login_with_correct_password(): void
    {
        $user = User::factory()->create(); // mật khẩu mặc định của factory là "password"

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create();

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'sai-mat-khau',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}