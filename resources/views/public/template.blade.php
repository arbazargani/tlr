<?php
// $session = factory(App\Session::class, 150)->create();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @yield('meta')
    @include('public.template-parts.header')
</head>
<body>
    @yield('content')
    @include('public.template-parts.footer')
</body>
</html>
