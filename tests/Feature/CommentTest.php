<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Chặn email thật khi bình luận; phần email được test riêng ở CommentMailTest
        Mail::fake();
    }

    public function test_member_can_comment_on_published_post(): void
    {
        $post = Post::factory()->create();
        $member = User::factory()->create();

        $this->actingAs($member)
            ->post(route('comments.store', ['post' => $post->slug]), ['body' => 'Bai viet rat hay'])
            ->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $member->id,
            'body' => 'Bai viet rat hay',
        ]);

        $this->get(route('posts.show', ['post' => $post->slug]))
            ->assertOk()
            ->assertSee('Bai viet rat hay');
    }

    public function test_guest_cannot_comment(): void
    {
        $post = Post::factory()->create();

        $this->post(route('comments.store', ['post' => $post->slug]), ['body' => 'Khach go cua'])
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_cannot_comment_on_draft_or_scheduled_post(): void
    {
        $member = User::factory()->create();
        $draft = Post::factory()->draft()->create();
        $scheduled = Post::factory()->scheduled()->create();

        $this->actingAs($member)
            ->post(route('comments.store', ['post' => $draft->slug]), ['body' => 'Binh luan'])
            ->assertNotFound();

        $this->actingAs($member)
            ->post(route('comments.store', ['post' => $scheduled->slug]), ['body' => 'Binh luan'])
            ->assertNotFound();

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_empty_or_too_long_comment_is_rejected(): void
    {
        $post = Post::factory()->create();
        $member = User::factory()->create();

        $this->actingAs($member)
            ->post(route('comments.store', ['post' => $post->slug]), ['body' => ''])
            ->assertSessionHasErrors('body');

        $this->actingAs($member)
            ->post(route('comments.store', ['post' => $post->slug]), ['body' => str_repeat('a', 1001)])
            ->assertSessionHasErrors('body');

        $this->assertDatabaseCount('comments', 0);
    }

    public function test_comment_html_is_escaped(): void
    {
        $post = Post::factory()->create();
        Comment::factory()->create([
            'post_id' => $post->id,
            'body' => '<script>alert(1)</script>',
        ]);

        // false = so sánh nguyên văn HTML, không tự thoát ký tự
        $this->get(route('posts.show', ['post' => $post->slug]))
            ->assertOk()
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    public function test_comment_author_can_delete_own_comment(): void
    {
        $post = Post::factory()->create();
        $writer = User::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $writer->id]);

        $this->actingAs($writer)
            ->delete(route('comments.destroy', $comment))
            ->assertRedirect();

        $this->assertModelMissing($comment);
    }

    public function test_post_author_can_delete_comment_on_own_post(): void
    {
        $postAuthor = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $postAuthor->id]);
        $comment = Comment::factory()->create(['post_id' => $post->id]); // người viết là người khác

        $this->actingAs($postAuthor)
            ->delete(route('comments.destroy', $comment))
            ->assertRedirect();

        $this->assertModelMissing($comment);
    }

    public function test_admin_can_delete_any_comment(): void
    {
        $admin = User::factory()->admin()->create();
        $comment = Comment::factory()->create();

        $this->actingAs($admin)
            ->delete(route('comments.destroy', $comment))
            ->assertRedirect();

        $this->assertModelMissing($comment);
    }

    public function test_other_member_cannot_delete_comment(): void
    {
        $comment = Comment::factory()->create();
        $stranger = User::factory()->create();

        $this->actingAs($stranger)
            ->delete(route('comments.destroy', $comment))
            ->assertForbidden();

        $this->assertModelExists($comment);
    }

    public function test_guest_cannot_delete_comment(): void
    {
        $comment = Comment::factory()->create();

        $this->delete(route('comments.destroy', $comment))
            ->assertRedirect(route('login'));

        $this->assertModelExists($comment);
    }

    public function test_delete_button_is_shown_only_to_authorized_users(): void
    {
        $post = Post::factory()->create();
        Comment::factory()->create(['post_id' => $post->id]); // người viết là một người khác
        $stranger = User::factory()->create();
        $url = route('posts.show', ['post' => $post->slug]);

        $this->get($url)->assertOk()->assertDontSee('Xóa');                              // khách
        $this->actingAs($stranger)->get($url)->assertOk()->assertDontSee('Xóa');         // người lạ
        $this->actingAs($post->user)->get($url)->assertOk()->assertSee('Xóa');           // tác giả bài
    }
}