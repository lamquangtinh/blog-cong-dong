<?php

namespace App\Http\Controllers;

use App\Mail\NewCommentMail;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        // Chỉ được bình luận dưới bài đã đăng (nháp, hẹn giờ thì 404)
        abort_unless($post->status === Post::STATUS_PUBLISHED, 404);

        $data = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $data['body'],
        ]);

        Log::info('Bình luận mới', [
            'comment_id' => $comment->id,
            'post_id' => $post->id,
            'user_id' => $comment->user_id,
        ]);

        // Báo cho tác giả qua email (đưa vào hàng đợi).
        // Tác giả tự bình luận bài của mình thì không cần báo.
        if ($post->user_id !== $comment->user_id) {
            Mail::to($post->user)->queue(new NewCommentMail($comment));
        }

        return redirect()
            ->to(route('posts.show', ['post' => $post->slug]) . '#comments')
            ->with('success', 'Đã gửi bình luận.');
    }

    public function destroy(Request $request, Comment $comment): RedirectResponse
    {
        Gate::authorize('delete', $comment); // không đủ quyền thì 403

        $comment->delete();

        Log::info('Xóa bình luận', [
            'comment_id' => $comment->id,
            'post_id' => $comment->post_id,
            'comment_author_id' => $comment->user_id,
            'deleted_by' => $request->user()->id,
        ]);

        return back()->with('success', 'Đã xóa bình luận.');
    }
}