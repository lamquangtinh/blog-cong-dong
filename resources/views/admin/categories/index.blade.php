@extends('layouts.app')

@section('title', 'Quản lý danh mục')

@section('content')
    <h1 class="h3 mb-3">Khu vực quản trị</h1>

    @include('admin._nav')

    <div class="row g-4">
        {{-- Form thêm danh mục --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h5">Thêm danh mục</h2>

                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Thêm</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Danh sách danh mục --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tên</th>
                                <th>Slug</th>
                                <th class="text-center">Số bài</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td class="text-center">{{ $category->posts_count }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                           class="btn btn-sm btn-outline-primary">Sửa</a>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Xóa danh mục này? {{ $category->posts_count }} bài viết sẽ chuyển về Chưa phân loại.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Chưa có danh mục nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection