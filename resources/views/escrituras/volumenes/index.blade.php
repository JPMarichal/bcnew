@extends('layouts.main')

@section('title', 'Volúmenes de las escrituras de la Iglesia de Jesucristo de los Santos de los Últimos Días')
@section('description', 'Explora desde aquí los libros canónicos de las escrituras de la Iglesia de Jesucristo de los Santos de los Últimos Días.')
@section('robots', 'index, follow')

@if($volumenes->isNotEmpty())
    @section('featured_image', $volumenes->first()->featured_image)
    @section('published_time', now()->toIso8601String())
    @section('modified_time', now()->toIso8601String())
    @section('author', 'Juan Pablo Marichal')
    @section('type', 'article')
    @section('twitter_author', 'JPMarichal')
@endif

@section('content')
<div class="container mt-3">
    <h1 class="mb-2">Volúmenes de las Escrituras</h1>
    <P class="mb-4">Los volúmenes o libros canónicos de La Iglesia de Jesucristo de los Santos de los Últimos Días son una fuente de inspiración y guía espiritual. Te invitamos a explorarlos para encontrar respuestas a tus preguntas, consuelo en momentos de dificultad y una profunda conexión con lo divino. Su lectura promete enriquecer tu comprensión de la vida y fortalecer tu fe en Jesucristo. Haz click en el volúmen con que quieras comenzar.</P>
    <div class="row">
        @foreach ($volumenes as $volumen)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <a href="{{ route('volumenes.show', $volumen->nombre) }}">
                    @if($volumen->featured_image)
                    <img src="{{ $volumen->featured_image }}" class="card-img-top" alt="{{ $volumen->nombre }}" style="height: auto; max-height: 150px; width: 100%;">
                    @endif
                </a>
                <div class="card-body">
                    <h4 class="card-title" style="color: darkorange"><a href="{{ route('volumenes.show', $volumen->nombre) }}">{{ $volumen->nombre }}</a></h4>
                    <p class="card-text">{{$volumen->description}}</p>
                    <div><b>Colección:</b> xyz</div>
                    <div class="btn-group row border mt-1" role="group"  style="width:100%" aria-label="Botonera">
                        <a href="#" class="col-3" title="Anything"><i class="fa fa-book"></i></a>
                        <a href="#" class="col-3"><i class="fa fa-eye"></i></a>
                        <a href="#" class="col-3"><i class="fa fa-eye"></i></a>
                        <a href="#" class="col-3"><i class="fa fa-eye"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
