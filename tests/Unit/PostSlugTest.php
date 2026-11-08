<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostSlugTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_is_plain_when_not_taken(): void
    {
        $this->assertSame('bai-viet-moi', Post::generateUniqueSlug('Bai viet moi'));
    }

    public function test_slug_gets_numeric_suffix_when_taken(): void
    {
        Post::factory()->create(['slug' => 'bai-viet-moi']);
        $this->assertSame('bai-viet-moi-2', Post::generateUniqueSlug('Bai viet moi'));

        Post::factory()->create(['slug' => 'bai-viet-moi-2']);
        $this->assertSame('bai-viet-moi-3', Post::generateUniqueSlug('Bai viet moi'));
    }

    public function test_slug_of_trashed_post_is_still_reserved(): void
    {
        Post::factory()->create(['slug' => 'bai-viet-moi'])->delete();

        $this->assertSame('bai-viet-moi-2', Post::generateUniqueSlug('Bai viet moi'));
    }

    public function test_slug_falls_back_when_title_has_no_letters(): void
    {
        $this->assertSame('bai-viet', Post::generateUniqueSlug('!!!'));
    }
}