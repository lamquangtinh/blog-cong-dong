@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
    <h1 class="h3 mb-3">Khu vực quản trị</h1>

    @include('admin._nav')

    {{-- Bộ lọc --}}
    <form method="GET" action="{{ route('admin.posts.index') }}" class="row g-2 mb-3">
        <div class="col-md-5">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Tìm theo tiêu đề...">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Mọi trạng thái</option>
                <option value="draft" @selected(request('status') === 'draft')>Nháp</option>
                <option value="published" @selected(request('status') === 'published')>Đã đăng</option>
                <option value="scheduled" @selected(request('status') === 'scheduled')>Hẹn giờ</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Xóa lọc</a>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Bình luận</th>
                        <th>Ngày tạo</th>
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
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->category?->name ?? '—' }}</td>
                            <td><span class="badge {{ $post->statusBadgeClass() }}">{{ $post->statusLabel() }}</span></td>
                            <td class="text-center">{{ $post->comments_count }}</td>
                            <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Xóa VĨNH VIỄN bài viết này cùng ảnh và bình luận? Không thể khôi phục.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Không có bài viết nào.</td>
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