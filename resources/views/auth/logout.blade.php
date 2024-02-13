@include('layouts.header')
@include('components.main_header')

<div class="mt-3">
    <a href="{{ route('logout') }}" class="btn btn-warning">Cerrar Sesión</a>
</div>

@include('layouts.footer')
