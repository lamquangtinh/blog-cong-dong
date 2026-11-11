<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostBodyRenderTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_page_renders_markdown(): void
    {
        $body = implode("\n", [
            '## Tieu de phu',
            '',
            'Doan van co **chu dam**.',
            '',
            '```php',
            "echo 'xin chao';",
            '```',
        ]);
        $post = Post::factory()->create(['body' => $body]);

        $this->get(route('posts.show', ['post' => $post->slug]))
            ->assertOk()
            ->assertSee('<h2>Tieu de phu</h2>', false)
            ->assertSee('<strong>chu dam</strong>', false)
            ->assertSee('<code class="language-php">', false)
            ->assertDontSee('##', false);
    }

    public function test_script_in_post_body_is_not_rendered_on_page(): void
    {
        $post = Post::factory()->create([
            'body' => "Xin chao\n\n<script>alert('xss')</script>\n\nTam biet",
        ]);

        $this->get(route('posts.show', ['post' => $post->slug]))
            ->assertOk()
            ->assertSee('Xin chao')
            ->assertSee('Tam biet')
            ->assertDontSee("<script>alert('xss')</script>", false);
    }
}