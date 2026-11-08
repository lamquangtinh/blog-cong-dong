<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    // Trang chủ: danh sách bài đã đăng, có tìm kiếm và lọc
    public function index(Request $request): View
    {
        $keyword = $request->string('q')->trim()->toString();
        $categorySlug = $request->string('category')->toString();
        $tagSlug = $request->string('tag')->toString();

        $posts = Post::published()
            ->with(['user', 'category', 'tags'])
            ->withCount('comments')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                      ->orWhere('body', 'like', "%{$keyword}%");
                });
            })
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
            })
            ->when($tagSlug, function ($query) use ($tagSlug) {
                $query->whereHas('tags', fn ($q) => $q->where('slug', $tagSlug));
            })
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString(); // giữ bộ lọc khi chuyển trang

        return view('home', [
            'posts' => $posts,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    // Trang chi tiết: truy cập bằng slug
    public function show(Post $post): View
    {
        // Bài nháp hoặc hẹn giờ thì khách không được xem
        abort_unless($post->status === Post::STATUS_PUBLISHED, 404);

        $post->load([
            'user',
            'category',
            'tags',
            'comments' => fn ($query) => $query->with('user')->latest(),
        ]);

        // Gắn sẵn bài viết vào từng bình luận để CommentPolicy không phải truy vấn lại
        $post->comments->each->setRelation('post', $post);

        return view('posts.show', ['post' => $post]);
    }
}