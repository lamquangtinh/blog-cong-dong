@extends('layouts.app')

@section('title', 'Bài của tôi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Bài viết của tôi</h1>
        <a href="{{ route('my-posts.create') }}" class="btn btn-success">Viết bài mới</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Ngày đăng / hẹn</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>
                                @if ($post->status === 'published')
                                    <a href="{{ route('posts.show', ['post' => $post->slug]) }}">{{ $post->title }}</a>
                                @else
                                    {{ $post->title }}
                                @endif
                            </td>
                            <td>{{ $post->category?->name ?? '—' }}</td>
                            <td><span class="badge {{ $post->statusBadgeClass() }}">{{ $post->statusLabel() }}</span></td>
                            <td>{{ $post->published_at?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('my-posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Bạn chưa có bài viết nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $posts->links() }}
    </div>
@endsection