<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MyPostController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Trang công khai
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Chỉ dành cho khách (đã đăng nhập thì bị chuyển về trang chủ)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Bình luận: phải đăng nhập
Route::middleware('auth')->group(function () {
    Route::post('/posts/{post:slug}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
});

// Thành viên quản lý bài viết của mình
Route::middleware('auth')
    ->prefix('my/posts')
    ->name('my-posts.')
    ->group(function () {
        Route::get('/', [MyPostController::class, 'index'])->name('index');
        Route::get('/create', [MyPostController::class, 'create'])->name('create');
        Route::post('/', [MyPostController::class, 'store'])->name('store');

        // Thùng rác
        Route::get('/trash', [MyPostController::class, 'trash'])->name('trash');
        Route::patch('/{id}/restore', [MyPostController::class, 'restore'])
            ->whereNumber('id')->name('restore');
        Route::delete('/{id}/force', [MyPostController::class, 'forceDestroy'])
            ->whereNumber('id')->name('force-destroy');

        Route::get('/{post}/edit', [MyPostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [MyPostController::class, 'update'])->name('update');
        Route::delete('/{post}', [MyPostController::class, 'destroy'])->name('destroy');
    });

// Khu vực quản trị: phải đăng nhập, rồi phải là admin
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class)
            ->except(['show', 'create']);

        Route::get('/posts', [PostAdminController::class, 'index'])->name('posts.index');
        Route::delete('/posts/{post}', [PostAdminController::class, 'destroy'])->name('posts.destroy');

        Route::get('/comments', [CommentAdminController::class, 'index'])->name('comments.index');
        
    });
   