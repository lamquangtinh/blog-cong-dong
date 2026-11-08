<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TrashTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_move_post_to_trash(): void
    {
        $author = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);

        $this->actingAs($author)
            ->delete(route('my-posts.destroy', $post))
            ->assertRedirect(route('my-posts.index'));

        $this->assertSoftDeleted($post);

        // Bài trong thùng rác không còn xem được ở trang công khai
        $this->get(route('posts.show', ['post' => $post->slug]))->assertNotFound();
    }

    public function test_author_can_restore_post_from_trash(): void
    {
        $author = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);
        $post->delete();

        $this->actingAs($author)
            ->patch(route('my-posts.restore', $post->id))
            ->assertRedirect(route('my-posts.trash'));

        $this->assertNotSoftDeleted($post);
    }

    public function test_author_can_force_delete_post_and_its_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('posts/anh.jpg', 'noi dung anh');

        $author = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id, 'image' => 'posts/anh.jpg']);
        $post->delete();

        $this->actingAs($author)
            ->delete(route('my-posts.force-destroy', $post->id))
            ->assertRedirect(route('my-posts.trash'));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        Storage::disk('public')->assertMissing('posts/anh.jpg');
    }

    public function test_other_member_cannot_trash_restore_or_force_delete(): void
    {
        $author = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);

        $this->actingAs($other)->delete(route('my-posts.destroy', $post))->assertForbidden();
        $this->assertNotSoftDeleted($post);

        $post->delete();

        $this->actingAs($other)->patch(route('my-posts.restore', $post->id))->assertForbidden();
        $this->actingAs($other)->delete(route('my-posts.force-destroy', $post->id))->assertForbidden();

        $this->assertSoftDeleted($post); // vẫn nằm trong thùng rác, chưa bị xóa hẳn
    }

    public function test_cannot_force_delete_post_that_is_not_in_trash(): void
    {
        $author = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]); // chưa xóa mềm

        $this->actingAs($author)
            ->delete(route('my-posts.force-destroy', $post->id))
            ->assertNotFound();

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }
}