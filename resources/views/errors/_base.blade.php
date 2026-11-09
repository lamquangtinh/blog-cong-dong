<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex align-items-center min-vh-100">
    <div class="container text-center py-5">
        <div class="error-code mb-3">@yield('code')</div>
        <h1 class="h3 mb-3">@yield('title')</h1>
        <p class="text-muted mx-auto mb-4" style="max-width: 480px;">@yield('message')</p>

        <a href="{{ url('/') }}" class="btn btn-primary px-4">Về trang chủ</a>
        <a href="javascript:history.back()" class="btn btn-outline-secondary px-4">Quay lại</a>
    </div>
</body>
</html>