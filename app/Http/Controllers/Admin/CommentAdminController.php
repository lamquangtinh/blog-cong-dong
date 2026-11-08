<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\View\View;

class CommentAdminController extends Controller
{
    // Việc xóa dùng lại route comments.destroy của CommentController
    // (CommentPolicy đã cho phép quản trị viên xóa mọi bình luận)
    public function index(): View
    {
        $comments = Comment::with(['user', 'post'])
            ->latest()
            ->paginate(20);

        return view('admin.comments.index', ['comments' => $comments]);
    }
}