<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Blog Cộng Đồng')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Blog Cộng Đồng</a>

            <div class="d-flex flex-wrap align-items-center gap-2">
                @auth
                    <span class="text-white-50 small">Xin chào, {{ auth()->user()->name }}</span>

                    <a href="{{ route('my-posts.index') }}" class="btn btn-sm btn-outline-light">Bài của tôi</a>
                    <a href="{{ route('my-posts.create') }}" class="btn btn-sm btn-success">Viết bài</a>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-warning">Quản trị</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Đăng ký</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="container text-center text-muted py-4 mt-5 border-top">
        &copy; {{ date('Y') }} Blog Cộng Đồng
    </footer>

</body>
</html>