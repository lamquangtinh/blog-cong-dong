<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'memberCount' => User::where('role', 'member')->count(),
            'publishedCount' => Post::published()->count(),
            'commentCount' => Comment::count(),
            'topPosts' => Post::published()
                ->with('user')
                ->withCount('comments')
                ->orderByDesc('comments_count')
                ->latest('published_at')
                ->limit(5)
                ->get(),
        ]);
    }
}