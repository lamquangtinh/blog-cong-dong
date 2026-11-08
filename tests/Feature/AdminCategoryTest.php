<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_admin_can_create_category_and_slug_is_generated(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.categories.store'), ['name' => 'Công nghệ'])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', ['name' => 'Công nghệ', 'slug' => 'cong-nghe']);
    }

    public function test_duplicate_or_empty_name_is_rejected(): void
    {
        Category::factory()->create(['name' => 'Du lich', 'slug' => 'du-lich']);
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), ['name' => 'Du lich'])
            ->assertSessionHasErrors('name');

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), ['name' => ''])
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 1);
    }

    public function test_admin_can_rename_category(): void
    {
        $category = Category::factory()->create(['name' => 'Du lich', 'slug' => 'du-lich']);
        $admin = $this->admin();

        $this->actingAs($admin)
            ->put(route('admin.categories.update', $category), ['name' => 'Am thuc'])
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Am thuc',
            'slug' => 'am-thuc',
        ]);

        // Lưu lại đúng tên hiện tại của chính nó thì không bị báo "trùng"
        $this->actingAs($admin)
            ->put(route('admin.categories.update', $category), ['name' => 'Am thuc'])
            ->assertSessionHasNoErrors();
    }

    public function test_deleting_category_keeps_its_posts(): void
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create(['category_id' => $category->id]);

        $this->actingAs($this->admin())
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertNotNull($post->fresh());               // bài viết vẫn còn
        $this->assertNull($post->fresh()->category_id);     // chỉ về "Chưa phân loại"
    }

    public function test_member_cannot_manage_categories(): void
    {
        $member = User::factory()->create();
        $category = Category::factory()->create(['name' => 'Giu nguyen']);

        $this->actingAs($member)
            ->post(route('admin.categories.store'), ['name' => 'Moi'])
            ->assertForbidden();

        $this->actingAs($member)
            ->put(route('admin.categories.update', $category), ['name' => 'Bi doi'])
            ->assertForbidden();

        $this->actingAs($member)
            ->delete(route('admin.categories.destroy', $category))
            ->assertForbidden();

        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseHas('categories', ['name' => 'Giu nguyen']);
    }
}