@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <section class="hero text-center">
        <h1 class="mb-2">Chia sẻ kiến thức, kết nối cộng đồng</h1>
        <p class="mb-0 mx-auto">Đọc những bài viết mới nhất từ các tác giả trong cộng đồng, hoặc tự viết bài của riêng bạn.</p>
    </section>

    {{-- Tìm kiếm và lọc --}}
    <form method="GET" action="{{ route('home') }}" class="card shadow-sm filter-card p-3">
        <div class="row g-2 align-items-center">
            <div class="col-lg-5">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                       placeholder="🔍 Tìm theo từ khóa...">
            </div>
            <div class="col-md-6 col-lg-3">
                <select name="category" class="form-select">
                    <option value="">Tất cả danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-2">
                <select name="tag" class="form-select">
                    <option value="">Tất cả tag</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->slug }}" @selected(request('tag') === $tag->slug)>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">Lọc</button>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">Bỏ lọc</a>
            </div>
        </div>
    </form>

    @if (request()->anyFilled(['q', 'category', 'tag']))
        <p class="text-muted mb-3">Tìm thấy <strong>{{ $posts->total() }}</strong> bài viết.</p>
    @endif

    {{-- Danh sách bài viết --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($posts as $post)
            <div class="col">
                <article class="card post-card shadow-sm h-100">
                    <a href="{{ route('posts.show', ['post' => $post->slug]) }}" class="d-block">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="post-cover" alt="{{ $post->title }}">
                        @else
                            <div class="post-cover-placeholder grad-{{ $post->id % 6 }}">
                                {{ mb_strtoupper(mb_substr($post->title, 0, 1)) }}
                            </div>
                        @endif
                    </a>

                    <div class="card-body d-flex flex-column">
                        @if ($post->category)
                            <div class="mb-2">
                                <a href="{{ route('home', ['category' => $post->category->slug]) }}"
                                   class="cat-chip">{{ $post->category->name }}</a>
                            </div>
                        @endif

                        <h2 class="h5 post-title">
                            <a href="{{ route('posts.show', ['post' => $post->slug]) }}">{{ $post->title }}</a>
                        </h2>

                        <p class="post-excerpt">{{ $post->excerpt(120) }}</p>

                        <div class="mt-auto">
                            @if ($post->tags->isNotEmpty())
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    @foreach ($post->tags as $tag)
                                        <a href="{{ route('home', ['tag' => $tag->slug]) }}" class="tag-chip">#{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            @endif

                            <div class="d-flex align-items-center gap-2 meta border-top pt-3">
                                <span class="avatar avatar-sm">{{ mb_strtoupper(mb_substr($post->user->name, 0, 1)) }}</span>
                                <span class="fw-medium text-body">{{ $post->user->name }}</span>
                                <span class="ms-auto">
                                    {{ $post->published_at?->format('d/m/Y') }} · 💬 {{ $post->comments_count }}
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="card text-center py-5">
                    <div class="fs-1">🔍</div>
                    <p class="text-muted mb-0">Không tìm thấy bài viết nào phù hợp.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
@endsection