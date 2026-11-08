@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    {{-- Form tìm kiếm và lọc --}}
    <form method="GET" action="{{ route('home') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}"
                   class="form-control" placeholder="Tìm theo từ khóa...">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">Tất cả danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="tag" class="form-select">
                <option value="">Tất cả tag</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->slug }}" @selected(request('tag') === $tag->slug)>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill">Lọc</button>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Xóa</a>
        </div>
    </form>

    {{-- Danh sách bài viết --}}
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @forelse ($posts as $post)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top"
                             alt="{{ $post->title }}" style="height: 180px; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        @if ($post->category)
                            <div class="mb-2">
                                <a href="{{ route('home', ['category' => $post->category->slug]) }}"
                                   class="badge text-bg-primary text-decoration-none">
                                    {{ $post->category->name }}
                                </a>
                            </div>
                        @endif

                        <h2 class="h5">
                            <a href="{{ route('posts.show', ['post' => $post->slug]) }}"
                               class="text-decoration-none text-dark">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <p class="text-muted small mb-2">
                            {{ $post->user->name }}
                            · {{ $post->published_at?->format('d/m/Y') }}
                            · {{ $post->comments_count }} bình luận
                        </p>

                        <p class="card-text">{{ \Illuminate\Support\Str::limit($post->body, 140) }}</p>

                        <div class="mt-auto">
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('home', ['tag' => $tag->slug]) }}"
                                   class="badge text-bg-light border text-decoration-none">#{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">Không tìm thấy bài viết nào phù hợp.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
@endsection