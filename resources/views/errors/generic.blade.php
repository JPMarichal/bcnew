@extends('layouts.main')

@section('title', 'Error en la Aplicación')

@section('content')
<main class="container text-center mt-5">
    <h1>Error en la Aplicación</h1>
    <p>Lo sentimos, ha ocurrido un error inesperado.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
</main>
@endsection
