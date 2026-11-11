<?php

namespace Tests\Unit;

use App\Models\Post;
use Tests\TestCase;

class PostBodyTest extends TestCase
{
    private function html(string $body): string
    {
        return (string) (new Post(['body' => $body]))->bodyHtml();
    }

    public function test_markdown_is_rendered_to_html(): void
    {
        $body = implode("\n", [
            '## Tieu de phu',
            '',
            'Doan van co **chu dam** va `ma`.',
            '',
            '- muc mot',
            '- muc hai',
            '',
            '```php',
            "echo 'xin chao';",
            '```',
        ]);

        $html = $this->html($body);

        $this->assertStringContainsString('<h2>Tieu de phu</h2>', $html);
        $this->assertStringContainsString('<strong>chu dam</strong>', $html);
        $this->assertStringContainsString('<code>ma</code>', $html);
        $this->assertStringContainsString('<li>muc mot</li>', $html);
        $this->assertStringContainsString('<code class="language-php">', $html);
        $this->assertStringContainsString('xin chao', $html);
    }

    public function test_single_line_breaks_are_kept(): void
    {
        $html = $this->html("dong mot\ndong hai");

        $this->assertStringContainsString('dong mot<br>', $html);
        $this->assertStringContainsString('dong hai', $html);
    }

    public function test_raw_html_typed_by_user_is_stripped(): void
    {
        $body = implode("\n", [
            'Xin chao',
            '',
            "<script>alert('xss')</script>",
            '',
            'Anh <img src=x onerror=alert(1)> o day',
            '',
            'Tam biet',
        ]);

        $html = $this->html($body);

        $this->assertStringNotContainsString('<script', $html);
        $this->assertStringNotContainsString('<img', $html);
        $this->assertStringNotContainsString('onerror', $html);
        $this->assertStringContainsString('Xin chao', $html);
        $this->assertStringContainsString('Tam biet', $html);
    }

    public function test_unsafe_links_are_neutralized_but_normal_links_work(): void
    {
        $html = $this->html('[bam vao day](javascript:alert(1)) va [Laravel](https://laravel.com)');

        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertStringContainsString('bam vao day', $html);
        $this->assertStringContainsString('href="https://laravel.com"', $html);
    }

    public function test_excerpt_has_no_markdown_symbols(): void
    {
        $post = new Post(['body' => "## Tieu de\n\nNoi dung `code` **dam**"]);

        $this->assertSame('Tieu de Noi dung code dam', $post->excerpt(200));
        $this->assertSame('Tieu...', (new Post(['body' => 'Tieu de dai']))->excerpt(4));
    }
}