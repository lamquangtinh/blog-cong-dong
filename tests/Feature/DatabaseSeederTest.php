<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_only_admin_categories_and_tags(): void
    {
        $this->seed();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['email' => 'admin@example.com', 'role' => 'admin']);
        $this->assertDatabaseCount('categories', 5);
        $this->assertDatabaseCount('tags', 8);
        $this->assertDatabaseCount('posts', 0);
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_seeded_admin_can_log_in_and_open_admin_area(): void
    {
        $this->seed();

        $this->post('/login', ['email' => 'admin@example.com', 'password' => '12345678'])
            ->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $admin = User::where('email', 'admin@example.com')->firstOrFail();
        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_seeder_can_run_twice_without_duplicates(): void
    {
        $this->seed();
        $this->seed();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('categories', 5);
        $this->assertDatabaseCount('tags', 8);
    }
}