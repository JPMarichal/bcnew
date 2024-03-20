{{-- resources/views/escrituras/versiculos/admin/comentarios.blade.php --}}

@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Comentarios a {{ $versiculo->referencia }} (admin)</h1>
    <hr>
    @foreach ($comentarios as $comentario)
        <div class="comentario">
            <h2>{{ $comentario->titulo }}</h2>
            <div class="px-3">{!! $comentario->comentario !!}</div>
            {{-- Añade aquí botones o acciones para editar o eliminar comentarios --}}
        </div>
    @endforeach
    {{-- Aquí podrías añadir un formulario para añadir nuevos comentarios directamente desde esta interfaz --}}
</div>
@endsection
