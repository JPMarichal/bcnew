<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">
@include('layouts.header')

<body>
    <div class="container-fluid my-0 mx-0">
        @include('components.main_header')
        @yield('content')
    </div>

    @include('layouts.footer')
</body>
</html>
