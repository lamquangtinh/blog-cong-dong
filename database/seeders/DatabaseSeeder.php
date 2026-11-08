<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Người dùng: 1 admin, 5 thành viên
        User::factory()->admin()->create([
            'name' => 'Quản trị viên',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $users = User::factory(4)->create();
        $users->push(User::factory()->create([
            'name' => 'Thành viên mẫu',
            'email' => 'member@example.com',
            'password' => Hash::make('password'),
        ]));

        // 2. Danh mục và tag
        $categories = collect(['Công nghệ', 'Đời sống', 'Du lịch', 'Ẩm thực', 'Học tập'])
            ->map(fn ($name) => Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]));

        $tags = collect(['laravel', 'php', 'mysql', 'lap-trinh', 'meo-vat', 'review'])
            ->map(fn ($name) => Tag::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]));

        // 3. Bài viết: 25 đã đăng, 5 nháp, 3 hẹn giờ
        $pick = fn () => [
            'user_id' => $users->random()->id,
            'category_id' => $categories->random()->id,
        ];

        $posts = collect();

        for ($i = 0; $i < 25; $i++) {
            $posts->push(Post::factory()->create($pick()));
        }
        for ($i = 0; $i < 5; $i++) {
            $posts->push(Post::factory()->draft()->create($pick()));
        }
        for ($i = 0; $i < 3; $i++) {
            $posts->push(Post::factory()->scheduled()->create($pick()));
        }

        // 4. Gắn 1-3 tag ngẫu nhiên cho mỗi bài
        foreach ($posts as $post) {
            $post->tags()->attach($tags->random(rand(1, 3))->pluck('id')->all());
        }

        // 5. Bình luận cho các bài đã đăng
        foreach ($posts->where('status', Post::STATUS_PUBLISHED) as $post) {
            $count = rand(0, 4);

            for ($i = 0; $i < $count; $i++) {
                Comment::factory()->create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}