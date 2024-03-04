<!DOCTYPE html>
<html lang="es">
@include('layouts.header')

<body>
    <div class="container-fluid my-0 mx-0">
        @include('components.main_header')
        @yield('content')
    </div>

    @include('layouts.footer')
</body>
</html>
