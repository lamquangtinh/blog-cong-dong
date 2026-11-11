@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="article-wrap">
        <a href="{{ route('home') }}" class="btn btn-link px-0 mb-3">&larr; Về trang chủ</a>

        <article>
            <div class="d-flex flex-wrap gap-2 mb-3">
                @if ($post->category)
                    <a href="{{ route('home', ['category' => $post->category->slug]) }}"
                       class="cat-chip">{{ $post->category->name }}</a>
                @endif
                @foreach ($post->tags as $tag)
                    <a href="{{ route('home', ['tag' => $tag->slug]) }}" class="tag-chip">#{{ $tag->name }}</a>
                @endforeach
            </div>

            <h1 class="article-title mb-3">{{ $post->title }}</h1>

            <div class="d-flex align-items-center gap-3 meta mb-4">
                <span class="avatar avatar-lg">{{ mb_strtoupper(mb_substr($post->user->name, 0, 1)) }}</span>
                <div>
                    <div class="fw-semibold text-body">{{ $post->user->name }}</div>
                    <div>
                        {{ $post->published_at?->format('d/m/Y H:i') }}
                        · {{ $post->comments->count() }} bình luận
                    </div>
                </div>
            </div>

            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="article-cover mb-4" alt="{{ $post->title }}">
            @endif

            {{-- e() thoát ký tự HTML để chống XSS, nl2br giữ xuống dòng --}}
            <div class="article-body">{!! $post->bodyHtml() !!}</div>
        </article>

        <hr class="my-5">

        <section id="comments">
            <h2 class="h5 mb-3">💬 Bình luận ({{ $post->comments->count() }})</h2>

            {{-- Form bình luận: chỉ thành viên đã đăng nhập --}}
            @auth
                <form method="POST" action="{{ route('comments.store', ['post' => $post->slug]) }}" class="mb-4">
                    @csrf
                    <textarea name="body" rows="3" maxlength="1000"
                              class="form-control @error('body') is-invalid @enderror"
                              placeholder="Viết bình luận của bạn..." required>{{ old('body') }}</textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary btn-sm mt-2 px-3">Gửi bình luận</button>
                </form>
            @else
                <div class="alert alert-secondary">
                    <a href="{{ route('login') }}">Đăng nhập</a> để tham gia bình luận.
                </div>
            @endauth

            <div class="d-grid gap-3">
                @forelse ($post->comments as $comment)
                    <div class="comment-box">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="avatar avatar-sm">{{ mb_strtoupper(mb_substr($comment->user->name, 0, 1)) }}</span>
                            <strong>{{ $comment->user->name }}</strong>
                            <span class="meta">· {{ $comment->created_at->format('d/m/Y H:i') }}</span>

                            @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="ms-auto"
                                      onsubmit="return confirm('Xóa bình luận này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                </form>
                            @endcan
                        </div>

                        <p class="comment-body">{{ $comment->body }}</p>
                    </div>
                @empty
                    <p class="text-muted mb-0">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        document.querySelectorAll('.article-body pre code').forEach(function (el) { hljs.highlightElement(el); });
    </script>
