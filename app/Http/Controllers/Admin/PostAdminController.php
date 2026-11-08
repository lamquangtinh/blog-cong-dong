<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostAdminController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $keyword = $request->string('q')->trim()->toString();

        $posts = Post::with(['user', 'category'])
            ->withCount('comments')
            ->when(
                in_array($status, [Post::STATUS_DRAFT, Post::STATUS_PUBLISHED, Post::STATUS_SCHEDULED], true),
                fn ($query) => $query->where('status', $status)
            )
            ->when($keyword, fn ($query) => $query->where('title', 'like', "%{$keyword}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.posts.index', ['posts' => $posts]);
    }

    // Xóa vĩnh viễn bài vi phạm.
    // Không dùng xóa mềm vì bài trong thùng rác thì tác giả vẫn khôi phục được.
    public function destroy(Request $request, Post $post): RedirectResponse
    {
        $postId = $post->id;
        $authorId = $post->user_id;
        $title = $post->title;

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Tag và bình luận của bài tự xóa theo nhờ khóa ngoại cascade
        $post->forceDelete();

        Log::warning('Quản trị viên xóa bài viết', [
            'post_id' => $postId,
            'title' => $title,
            'author_id' => $authorId,
            'admin_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Đã xóa bài viết.');
    }
}