@extends('layouts.main')

@section('title', 'Error en la Aplicación')

@section('content')
<main class="container text-center mt-5">
    <h1>Error en la Aplicación</h1>
    <p>Lo sentimos, ha ocurrido un error inesperado.</p>
    <nav aria-label="Opciones de navegación tras el error de tiempo de espera">
        <ul class="list-unstyled">
            <li><a href="/" class="text-primary">Inicio</a></li>
            <li><a href="/noticias" class="text-primary">Últimas Noticias</a></li>
            <li><a href="/contacto" class="text-primary">Contacto</a></li>
        </ul>
    </nav>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
</main>
@endsection
