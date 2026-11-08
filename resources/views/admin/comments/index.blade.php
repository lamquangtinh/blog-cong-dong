@extends('layouts.app')

@section('title', 'Quản lý bình luận')

@section('content')
    <h1 class="h3 mb-3">Khu vực quản trị</h1>

    @include('admin._nav')

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Người viết</th>
                        <th>Nội dung</th>
                        <th>Bài viết</th>
                        <th>Thời gian</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        <tr>
                            <td>{{ $comment->user->name }}</td>
                            <td style="max-width: 320px;">{{ \Illuminate\Support\Str::limit($comment->body, 100) }}</td>
                            <td>
                                @if ($comment->post->status === 'published' && ! $comment->post->trashed())
                                    <a href="{{ route('posts.show', ['post' => $comment->post->slug]) }}">
                                        {{ \Illuminate\Support\Str::limit($comment->post->title, 40) }}
                                    </a>
                                @else
                                    {{ \Illuminate\Support\Str::limit($comment->post->title, 40) }}
                                    <span class="badge text-bg-secondary">không công khai</span>
                                @endif
                            </td>
                            <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Xóa bình luận này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Chưa có bình luận nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $comments->links() }}
    </div>
@endsection