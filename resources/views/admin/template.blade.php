<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @yield('meta')
    <meta name="robots" content="noindex, nofollow">
    @include('admin.template-parts.header')
</head>
<body>
    @include('admin.template-parts.navigation')
    @yield('content')
    @include('admin.template-parts.footer')
</body>
</html>
