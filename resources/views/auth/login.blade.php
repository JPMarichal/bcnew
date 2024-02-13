@include('layouts.header')
@include('components.main_header')

<h2 class="mt-5">Ingresa por medio de redes sociales</h2>
<div class="mt-3">
    <a href="{{ route('auth.google') }}" class="btn btn-danger">
        <i class="fab fa-google"></i> Ingresar con Google
    </a>
</div>

@include('layouts.footer')
