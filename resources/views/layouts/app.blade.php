<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trang chủ') | Blog Cộng Đồng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-md site-navbar">
        <div class="container">
            <a class="navbar-brand brand" href="{{ route('home') }}">
                <span class="brand-mark">B</span> Blog Cộng Đồng
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Mở menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto ms-md-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                           href="{{ route('home') }}">Trang chủ</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                    @auth
                        <a href="{{ route('my-posts.create') }}" class="btn btn-primary btn-sm px-3">✏️ Viết bài</a>

                        <div class="dropdown">
                            <button type="button" class="btn btn-light border d-flex align-items-center gap-2 py-1 px-2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="avatar avatar-sm">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                                <span class="small fw-medium">{{ auth()->user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('my-posts.index') }}">Bài của tôi</a></li>
                                <li><a class="dropdown-item" href="{{ route('my-posts.trash') }}">Thùng rác</a></li>
                                @if (auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Quản trị</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-3">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer py-4 mt-4">
        <div class="container text-center small">
            &copy; {{ date('Y') }} Blog Cộng Đồng · Đồ án cuối khóa Laravel
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>