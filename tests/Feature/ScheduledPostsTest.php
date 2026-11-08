<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ScheduledPostsTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_publishes_due_scheduled_posts(): void
    {
        $due = Post::factory()->scheduled()->create(['published_at' => now()->subMinute()]);

        $this->artisan('posts:publish-scheduled')->assertSuccessful();

        $this->assertSame('published', $due->fresh()->status);
    }

    public function test_command_leaves_future_scheduled_posts_alone(): void
    {
        $future = Post::factory()->scheduled()->create(['published_at' => now()->addHour()]);

        $this->artisan('posts:publish-scheduled')->assertSuccessful();

        $this->assertSame('scheduled', $future->fresh()->status);
    }

    public function test_command_ignores_drafts_published_and_trashed_posts(): void
    {
        $draft = Post::factory()->draft()->create();
        $published = Post::factory()->create(['published_at' => now()->subDay()]);
        $trashed = Post::factory()->scheduled()->create(['published_at' => now()->subMinute()]);
        $trashed->delete();

        $this->artisan('posts:publish-scheduled')->assertSuccessful();

        $this->assertSame('draft', $draft->fresh()->status);
        $this->assertSame('published', $published->fresh()->status);
        $this->assertSame('scheduled', Post::withTrashed()->find($trashed->id)->status); // bài trong thùng rác không bị đăng
    }

    public function test_command_is_idempotent(): void
    {
        Post::factory()->scheduled()->create(['published_at' => now()->subMinute()]);

        Artisan::call('posts:publish-scheduled');
        $this->assertStringContainsString('Đã đăng 1 bài', Artisan::output());

        Artisan::call('posts:publish-scheduled'); // chạy lại: không đăng trùng
        $this->assertStringContainsString('Đã đăng 0 bài', Artisan::output());
    }

    public function test_due_post_becomes_visible_on_home_page_after_command(): void
    {
        Post::factory()->scheduled()->create([
            'title' => 'BaiHenGioHienRa',
            'published_at' => now()->subMinute(),
        ]);

        $this->get('/')->assertDontSee('BaiHenGioHienRa');

        $this->artisan('posts:publish-scheduled')->assertSuccessful();

        $this->get('/')->assertSee('BaiHenGioHienRa');
    }

    public function test_command_is_registered_in_scheduler(): void
    {
        Artisan::call('schedule:list');

        $this->assertStringContainsString('posts:publish-scheduled', Artisan::output());
    }
}