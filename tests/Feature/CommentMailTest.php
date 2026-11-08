<?php

namespace Tests\Feature;

use App\Mail\NewCommentMail;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CommentMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_author_is_emailed_via_queue_when_someone_comments(): void
    {
        Mail::fake();

        $author = User::factory()->create(['email' => 'tacgia@example.com']);
        $post = Post::factory()->create(['user_id' => $author->id]);
        $commenter = User::factory()->create();

        $this->actingAs($commenter)
            ->post(route('comments.store', ['post' => $post->slug]), ['body' => 'Noi dung binh luan']);

        // assertQueued: email được đưa vào hàng đợi, chưa gửi trực tiếp
        Mail::assertQueued(NewCommentMail::class, function (NewCommentMail $mail) use ($author) {
            return $mail->hasTo($author->email);
        });
    }

    public function test_no_email_when_author_comments_on_own_post(): void
    {
        Mail::fake();

        $author = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);

        $this->actingAs($author)
            ->post(route('comments.store', ['post' => $post->slug]), ['body' => 'Tu binh luan bai cua minh']);

        $this->assertDatabaseCount('comments', 1);
        Mail::assertNothingQueued();
    }

    public function test_no_email_when_comment_is_invalid(): void
    {
        Mail::fake();

        $post = Post::factory()->create();
        $commenter = User::factory()->create();

        $this->actingAs($commenter)
            ->post(route('comments.store', ['post' => $post->slug]), ['body' => ''])
            ->assertSessionHasErrors('body');

        Mail::assertNothingQueued();
    }

    public function test_mail_content_has_comment_text_and_post_link(): void
    {
        $author = User::factory()->create(['name' => 'Nguyen Van An']);
        $commenter = User::factory()->create(['name' => 'Tran Thi Binh']);
        $post = Post::factory()->create([
            'user_id' => $author->id,
            'title' => 'Bai viet ve Laravel',
            'slug' => 'bai-viet-ve-laravel',
        ]);
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $commenter->id,
            'body' => 'Binh luan thu nghiem',
        ]);

        $mail = new NewCommentMail($comment);

        $mail->assertSeeInHtml('Nguyen Van An');
        $mail->assertSeeInHtml('Tran Thi Binh');
        $mail->assertSeeInHtml('Binh luan thu nghiem');
        $mail->assertSeeInHtml(route('posts.show', ['post' => 'bai-viet-ve-laravel']));
        $mail->assertHasSubject('Bình luận mới trong bài "Bai viet ve Laravel"');
    }
}