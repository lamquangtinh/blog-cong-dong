@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('home') }}" class="btn btn-link px-0 mb-2">&larr; Về trang chủ</a>

            <article class="card shadow-sm mb-4">
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top"
                         alt="{{ $post->title }}">
                @endif

                <div class="card-body p-4">
                    <h1 class="h3">{{ $post->title }}</h1>

                    <p class="text-muted small">
                        Tác giả: <strong>{{ $post->user->name }}</strong>
                        · {{ $post->published_at?->format('d/m/Y H:i') }}
                    </p>

                    <div class="mb-3">
                        @if ($post->category)
                            <a href="{{ route('home', ['category' => $post->category->slug]) }}"
                               class="badge text-bg-primary text-decoration-none">
                                {{ $post->category->name }}
                            </a>
                        @endif

                        @foreach ($post->tags as $tag)
                            <a href="{{ route('home', ['tag' => $tag->slug]) }}"
                               class="badge text-bg-light border text-decoration-none">#{{ $tag->name }}</a>
                        @endforeach
                    </div>

                    {{-- e() thoát ký tự HTML để chống XSS, nl2br giữ xuống dòng --}}
                    <div>{!! nl2br(e($post->body)) !!}</div>
                </div>
            </article>

            <section id="comments">
                <h2 class="h5 mb-3">Bình luận ({{ $post->comments->count() }})</h2>

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
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Gửi bình luận</button>
                    </form>
                @else
                    <div class="alert alert-light border">
                        <a href="{{ route('login') }}">Đăng nhập</a> để bình luận.
                    </div>
                @endauth

                @forelse ($post->comments as $comment)
                    <div class="card mb-2">
                        <div class="card-body py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $comment->user->name }}</strong>
                                    <span class="text-muted small">· {{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                </div>

                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                          onsubmit="return confirm('Xóa bình luận này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                    </form>
                                @endcan
                            </div>

                            {{-- pre-line giữ xuống dòng, {{ }} tự thoát HTML --}}
                            <p class="mb-0" style="white-space: pre-line;">{{ $comment->body }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Chưa có bình luận nào.</p>
                @endforelse
            </section>
        </div>
    </div>
@endsection