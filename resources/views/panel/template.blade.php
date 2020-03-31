<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    @yield('meta')
    <meta name="robots" content="noindex, nofollow">
    @include('panel.template-parts.header')
    <style>
        *:not(i) {
            font-family: IRANSans !important;
        }
    </style>
</head>
<body>
@include('panel.template-parts.navigation')
@yield('content')
@include('panel.template-parts.footer')
</body>
</html>
