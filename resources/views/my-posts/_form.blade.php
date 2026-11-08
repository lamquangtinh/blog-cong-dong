@php
    $selectedTags = old('tags', $post->exists ? $post->tags->pluck('id')->all() : []);
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row g-4">
        {{-- Cột trái: tiêu đề và nội dung --}}
        <div class="col-lg-8">
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                       class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Nội dung</label>
                <textarea id="body" name="body" rows="14"
                          class="form-control @error('body') is-invalid @enderror" required>{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Cột phải: danh mục, tag, ảnh, trạng thái --}}
        <div class="col-lg-4">
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục</label>
                <select id="category_id" name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror">
                    <option value="">— Chưa phân loại —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                                @selected((string) old('category_id', $post->category_id) === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Tag</label>
                @foreach ($tags as $tag)
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="tag-{{ $tag->id }}"
                               name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, $selectedTags))>
                        <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>
                @endforeach
                @error('tags.*')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Ảnh (tối đa 2MB)</label>
                @if ($post->image)
                    <div>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Ảnh hiện tại"
                             class="img-thumbnail mb-2" style="max-height: 120px;">
                    </div>
                @endif
                <input type="file" id="image" name="image" accept="image/*"
                       class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="draft" @selected(old('status', $post->status) === 'draft')>Nháp</option>
                    <option value="published" @selected(old('status', $post->status) === 'published')>Đăng ngay</option>
                    <option value="scheduled" @selected(old('status', $post->status) === 'scheduled')>Hẹn giờ đăng</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3" id="scheduled-box" style="display: none;">
                <label for="published_at" class="form-label">Giờ đăng</label>
                <input type="datetime-local" id="published_at" name="published_at"
                       value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                       class="form-control @error('published_at') is-invalid @enderror">
                @error('published_at')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Lưu bài viết</button>
        <a href="{{ route('my-posts.index') }}" class="btn btn-outline-secondary">Hủy</a>
    </div>
</form>

<script>
    // Chỉ hiện ô "Giờ đăng" khi chọn trạng thái "Hẹn giờ đăng"
    const statusSelect = document.getElementById('status');
    const scheduledBox = document.getElementById('scheduled-box');

    function toggleScheduledBox() {
        scheduledBox.style.display = statusSelect.value === 'scheduled' ? 'block' : 'none';
    }

    statusSelect.addEventListener('change', toggleScheduledBox);
    toggleScheduledBox();
</script>