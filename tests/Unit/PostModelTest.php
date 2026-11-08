<?php

namespace Tests\Unit;

use App\Models\Post;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    public function test_status_label_and_badge_for_each_status(): void
    {
        $published = new Post(['status' => Post::STATUS_PUBLISHED]);
        $scheduled = new Post(['status' => Post::STATUS_SCHEDULED]);
        $draft = new Post(['status' => Post::STATUS_DRAFT]);

        $this->assertSame('Đã đăng', $published->statusLabel());
        $this->assertSame('Hẹn giờ', $scheduled->statusLabel());
        $this->assertSame('Nháp', $draft->statusLabel());

        $this->assertSame('text-bg-success', $published->statusBadgeClass());
        $this->assertSame('text-bg-warning', $scheduled->statusBadgeClass());
        $this->assertSame('text-bg-secondary', $draft->statusBadgeClass());
    }

    public function test_unknown_status_falls_back_to_draft(): void
    {
        $post = new Post(['status' => 'khong-hop-le']);

        $this->assertSame('Nháp', $post->statusLabel());
        $this->assertSame('text-bg-secondary', $post->statusBadgeClass());
    }
}