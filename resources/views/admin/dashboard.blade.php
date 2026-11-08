@extends('layouts.app')

@section('title', 'Quản trị')

@section('content')
    <h1 class="h3 mb-3">Khu vực quản trị</h1>

    @include('admin._nav')

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <div class="display-6 fw-bold">{{ $memberCount }}</div>
                    <div class="text-muted">Thành viên</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <div class="display-6 fw-bold">{{ $publishedCount }}</div>
                    <div class="text-muted">Bài đã đăng</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <div class="display-6 fw-bold">{{ $commentCount }}</div>
                    <div class="text-muted">Bình luận</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header fw-semibold">5 bài nhiều bình luận nhất</div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th class="text-end">Bình luận</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topPosts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('posts.show', ['post' => $post->slug]) }}">{{ $post->title }}</a>
                            </td>
                            <td>{{ $post->user->name }}</td>
                            <td class="text-end">{{ $post->comments_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Chưa có bài viết nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection