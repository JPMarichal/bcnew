<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">
<head>
    @include('layouts.header')
</head>
<body>
    <header>
        @include('components.main_header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('layouts.footer')
    </footer>
</body>
</html>
