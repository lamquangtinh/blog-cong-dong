<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    // Dữ liệu form hợp lệ, test nào cần thì ghi đè từng ô
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Bai viet moi',
            'body' => 'Noi dung bai viet thu nghiem.',
            'status' => 'draft',
        ], $overrides);
    }

    public function test_member_can_create_post_with_image_category_and_tags(): void
    {
        Storage::fake('public'); // ảnh lưu vào thư mục tạm, không làm rác storage thật
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $tags = Tag::factory()->count(2)->create();

        $response = $this->actingAs($user)->post(route('my-posts.store'), $this->validData([
            'status' => 'published',
            'category_id' => $category->id,
            'tags' => $tags->pluck('id')->all(),
            'image' => UploadedFile::fake()->image('cover.jpg'),
        ]));

        $response->assertRedirect(route('my-posts.index'));

        $post = Post::firstOrFail();
        $this->assertEquals($user->id, $post->user_id);
        $this->assertSame('bai-viet-moi', $post->slug);
        $this->assertSame('published', $post->status);
        $this->assertNotNull($post->published_at);
        $this->assertCount(2, $post->tags);
        Storage::disk('public')->assertExists($post->image);
    }

    public function test_create_post_fails_without_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('my-posts.store'), $this->validData(['title' => '']));

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('posts', 0);
    }

    public function test_scheduled_post_with_past_time_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('my-posts.store'), $this->validData([
            'status' => 'scheduled',
            'published_at' => now()->subHour()->format('Y-m-d\TH:i'),
        ]));

        $response->assertSessionHasErrors('published_at');
        $this->assertDatabaseCount('posts', 0);
    }

    public function test_scheduled_post_with_future_time_is_saved(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('my-posts.store'), $this->validData([
            'status' => 'scheduled',
            'published_at' => now()->addDay()->format('Y-m-d\TH:i'),
        ]));

        $response->assertSessionHasNoErrors();
        $this->assertSame('scheduled', Post::firstOrFail()->status);
    }

    public function test_author_can_update_own_post_and_slug_is_kept(): void
    {
        $author = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $author->id,
            'title' => 'Tieu de cu',
            'slug' => 'tieu-de-cu',
        ]);

        $response = $this->actingAs($author)->put(route('my-posts.update', $post), $this->validData([
            'title' => 'Tieu de da sua',
            'status' => 'published',
        ]));

        $response->assertRedirect(route('my-posts.index'));

        $post->refresh();
        $this->assertSame('Tieu de da sua', $post->title);
        $this->assertSame('tieu-de-cu', $post->slug); // đường dẫn cũ không đổi
    }

    public function test_other_member_cannot_edit_or_update_post(): void
    {
        $author = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id, 'title' => 'Tieu de goc']);

        $this->actingAs($other)->get(route('my-posts.edit', $post))->assertForbidden();

        $this->actingAs($other)
            ->put(route('my-posts.update', $post), $this->validData(['title' => 'Bi sua trom']))
            ->assertForbidden();

        $this->assertSame('Tieu de goc', $post->fresh()->title);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('my-posts.index'))->assertRedirect(route('login'));
        $this->post(route('my-posts.store'), $this->validData())->assertRedirect(route('login'));

        $this->assertDatabaseCount('posts', 0);
    }
}