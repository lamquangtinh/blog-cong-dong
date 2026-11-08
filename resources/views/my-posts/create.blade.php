@extends('layouts.app')

@section('title', 'Viết bài mới')

@section('content')
    <h1 class="h3 mb-3">Viết bài mới</h1>

    @include('my-posts._form', [
        'action' => route('my-posts.store'),
        'method' => 'POST',
    ])
@endsection