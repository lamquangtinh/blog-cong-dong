<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish-scheduled';

    protected $description = 'Tự động đăng các bài hẹn giờ đã đến hạn';

    public function handle(): int
    {
        $count = 0;

        // Bài trong thùng rác tự bị loại (SoftDeletes) nên sẽ không bị đăng nhầm.
        // chunkById an toàn khi vừa duyệt vừa đổi trạng thái bài.
        Post::where('status', Post::STATUS_SCHEDULED)
            ->where('published_at', '<=', now())
            ->chunkById(100, function ($posts) use (&$count) {
                foreach ($posts as $post) {
                    $post->update(['status' => Post::STATUS_PUBLISHED]);
                    $count++;

                    Log::info('Tự động đăng bài hẹn giờ', [
                        'post_id' => $post->id,
                        'published_at' => $post->published_at->toDateTimeString(),
                    ]);
                }
            });

        $this->info("Đã đăng {$count} bài hẹn giờ.");

        return self::SUCCESS;
    }
}