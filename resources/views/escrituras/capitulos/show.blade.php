@extends('layouts.main')

@section('title', $capitulo->referencia)
@section('description', $capitulo->description)
@section('robots', 'index, follow')

@section('featured_image', $capitulo->featured_image)
@section('published_time', $capitulo->created_at->toIso8601String())
@section('modified_time', $capitulo->updated_at->toIso8601String())
@section('author', 'Juan Pablo Marichal')
@section('type', 'article')
@section('twitter_author', 'JPMarichal')

@section('content')
<style>
    .btn-flotante {
        position: fixed;
        z-index: 2;
    }
    #navleft .btn-flotante {
        left: 10px;
        top: 50%; /* Centrar verticalmente */
    }
    #navright .btn-flotante {
        right: 10px;
        top: 50%; /* Centrar verticalmente */
    }
    .btn-personalizado {
        background-color: white;
        color: black;
        border: 2px solid green;
    }
    .btn-personalizado:hover {
        background-color: green;
        color: white;
        border: 2px solid green; /* Mantener el borde */
    }
    #contenido {
        padding-left: 50px; /* Ajuste opcional para no superponerse con el botón flotante izquierdo */
        padding-right: 50px; /* Ajuste opcional para no superponerse con el botón flotante derecho */
    }
</style>
<div class="container mt-3">
    <h1 class="mb-2">{{$capitulo->referencia}} <br /> {{$capitulo->title }}</h1>
    <div class="border border-rounded p-2 bg-success text-white text-center mt-0 mb-3">{{$capitulo->description}}</div>
    <div class="row">
        <div class="col-1 text-center" id="navleft">
            <a href="{{ route('capitulos.show', $capituloAnterior->referencia) }}" class="btn btn-personalizado btn-flotante">
                <i class="fas fa-chevron-left"></i>
            </a>
        </div>
        <div class="col-12" id="contenido">
            @foreach ($capitulo->pericopas as $pericopa)
            <div>
                <h2>{{ $pericopa->titulo }}</h2>
                <p>{{ $pericopa->descripcion }}</p>
                @foreach ($pericopa->versiculos as $versiculo)
                <p><strong> {{ $versiculo->num_versiculo }}</strong> {{ $versiculo->contenido }}</p>
                @endforeach
            </div>
            @endforeach
        </div>
        <div class="col-1 text-center" id="navright">
            <a href="{{ route('capitulos.show', $capituloSiguiente->referencia) }}" class="btn btn-personalizado btn-flotante">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection
