<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function test_admin_user_is_admin(): void
    {
        $this->assertTrue(User::factory()->admin()->make()->isAdmin());
    }

    public function test_member_user_is_not_admin(): void
    {
        $this->assertFalse(User::factory()->make()->isAdmin());
        $this->assertFalse(User::factory()->make(['role' => 'khach'])->isAdmin());
    }
}