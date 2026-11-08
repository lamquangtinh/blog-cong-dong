@extends('layouts.app')

@section('title', 'Sửa bài viết')

@section('content')
    <h1 class="h3 mb-3">Sửa bài viết</h1>

    @include('my-posts._form', [
        'action' => route('my-posts.update', $post),
        'method' => 'PUT',
    ])
@endsection