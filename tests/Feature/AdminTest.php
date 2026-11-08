<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private const ADMIN_URLS = ['/admin', '/admin/categories', '/admin/posts', '/admin/comments'];

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_guest_is_redirected_to_login_from_admin(): void
    {
        foreach (self::ADMIN_URLS as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }
    }

    public function test_member_gets_403_on_every_admin_page(): void
    {
        $member = User::factory()->create();

        foreach (self::ADMIN_URLS as $url) {
            $this->actingAs($member)->get($url)->assertForbidden();
        }
    }

    public function test_admin_can_open_every_admin_page(): void
    {
        $admin = $this->admin();

        foreach (self::ADMIN_URLS as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    public function test_dashboard_shows_correct_counts(): void
    {
        $admin = $this->admin();
        $members = User::factory()->count(3)->create();
        $author = $members->first();

        $first = Post::factory()->create(['user_id' => $author->id]);               // đã đăng
        Post::factory()->create(['user_id' => $author->id]);                        // đã đăng
        Post::factory()->draft()->create(['user_id' => $author->id]);               // nháp: không tính
        Post::factory()->scheduled()->create(['user_id' => $author->id]);           // hẹn giờ: không tính
        Post::factory()->create(['user_id' => $author->id])->delete();              // thùng rác: không tính

        Comment::factory()->count(4)->create(['post_id' => $first->id, 'user_id' => $author->id]);

        $response = $this->actingAs($admin)->get('/admin')->assertOk();

        $response->assertViewHas('memberCount', 3);     // không tính quản trị viên
        $response->assertViewHas('publishedCount', 2);
        $response->assertViewHas('commentCount', 4);
    }

    public function test_dashboard_lists_top_5_posts_by_comment_count(): void
    {
        $admin = $this->admin();
        $member = User::factory()->create();

        foreach ([0, 1, 2, 3, 4, 5] as $count) {
            $post = Post::factory()->create(['user_id' => $member->id]);
            Comment::factory()->count($count)->create(['post_id' => $post->id, 'user_id' => $member->id]);
        }

        $top = $this->actingAs($admin)->get('/admin')->assertOk()->viewData('topPosts');

        $this->assertCount(5, $top); // 6 bài nhưng chỉ lấy 5
        $this->assertEquals([5, 4, 3, 2, 1], $top->pluck('comments_count')->all());
    }

    public function test_admin_post_list_shows_every_status_and_can_filter(): void
    {
        $admin = $this->admin();
        Post::factory()->create(['title' => 'BaiDaDangX']);
        Post::factory()->draft()->create(['title' => 'BaiNhapY']);

        $this->actingAs($admin)->get('/admin/posts')
            ->assertOk()
            ->assertSee('BaiDaDangX')
            ->assertSee('BaiNhapY');

        $this->actingAs($admin)->get('/admin/posts?status=draft')
            ->assertOk()
            ->assertSee('BaiNhapY')
            ->assertDontSee('BaiDaDangX');
    }

    public function test_admin_can_force_delete_any_post_with_its_image_and_comments(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/vi-pham.jpg', 'anh');

        $post = Post::factory()->create(['image' => 'posts/vi-pham.jpg']);
        $comment = Comment::factory()->create(['post_id' => $post->id]);

        $this->actingAs($this->admin())
            ->delete(route('admin.posts.destroy', $post))
            ->assertRedirect();

        // Xóa vĩnh viễn (không vào thùng rác nên tác giả không khôi phục lại được)
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
        Storage::disk('public')->assertMissing('posts/vi-pham.jpg');
    }

    public function test_member_cannot_delete_posts_from_admin_area(): void
    {
        $post = Post::factory()->create();
        $member = User::factory()->create();

        $this->actingAs($member)
            ->delete(route('admin.posts.destroy', $post))
            ->assertForbidden();

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }

    public function test_admin_comment_list_shows_comments(): void
    {
        Comment::factory()->create(['body' => 'NoiDungBinhLuanZ']);

        $this->actingAs($this->admin())->get('/admin/comments')
            ->assertOk()
            ->assertSee('NoiDungBinhLuanZ');
    }
}