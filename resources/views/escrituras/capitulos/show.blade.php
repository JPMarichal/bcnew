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
    .versiculo {
        padding: 5px;
    }

    .versiculo-par {
        background-color: #F4F9F4;
    }

    .btn-flotante {
        position: fixed;
        z-index: 2;
    }

    #navleft .btn-flotante {
        left: 10px;
        top: 50%;
        /* Centrar verticalmente */
    }

    #navright .btn-flotante {
        right: 10px;
        top: 50%;
        /* Centrar verticalmente */
    }

    .btn-personalizado {
        background-color: white;
        color: black;
        border: 2px solid green;
    }

    .btn-personalizado:hover {
        background-color: green;
        color: white;
        border: 2px solid green;
        /* Mantener el borde */
    }

    #contenido {
        padding-left: 50px;
        /* Ajuste opcional para no superponerse con el botón flotante izquierdo */
        padding-right: 50px;
        /* Ajuste opcional para no superponerse con el botón flotante derecho */
    }

    .collapse-button {
        cursor: pointer;
    }
</style>
<div class="container mt-3">
    <h1 class="mb-2">{{$capitulo->referencia}} <br /> {{$capitulo->title }}</h1>
    <div class="border border-rounded p-2 bg-success text-white text-center mt-0 mb-3">{{$capitulo->description}}</div>
    @livewire('escrituras-navigation', ['tipo' => 'capitulo', 'nombre' => $capitulo->referencia])
    <div class="text-center mb-2">
        <center> <audio src="{{$capitulo->url_audio}}" controls preload='metadata'></audio></center>
    </div>
    <h2 class="text-center p-1" style="border-top: 1px solid green; background-color:#C6E2B8">{{$capitulo->referencia}}</h2>
    <div class="text-center text-small border rounded p-1">
        <a href="{{ route('capitulos.comentarios', $capitulo->referencia) }}" style="text-decoration: none;" target="_blank" rel="noopener noreferrer">
            Ver todos los comentarios
        </a>
        @auth
    @if(auth()->user()->hasRole('Administrador'))
    {{-- Información del id de capítulo, útil solo para el administrador --}}
    <b>Capítulo id:</b> {{ $capitulo->id }}
    @endif
    @endauth
    </div>
    <div class="row">
        <div class="col-1 text-center" id="navleft">
            <a href="{{ route('capitulos.show', ['nombre' => $capituloAnterior->referencia]) }}" class="btn btn-personalizado btn-flotante">
                <i class="fas fa-chevron-left"></i>
            </a>
        </div>
        <div class="col-12" id="contenido">
            @foreach ($capitulo->pericopas as $pericopa)
            <div class="pericopa">
                <h2>
                    {{ $pericopa->titulo }} (v. {{ $pericopa->versiculo_inicial}}-{{ $pericopa->versiculo_final}})
                    @if (!empty($pericopa->descripcion))
                    <button class="btn btn-sm float-end" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescripcion{{$loop->index}}" aria-expanded="false" aria-controls="collapseDescripcion{{$loop->index}}">
                        <b><i class="fas fa-chevron-down"></i></b>
                    </button>
                    @endif
                </h2>
                @if (!empty($pericopa->descripcion))
                <div class="collapse" id="collapseDescripcion{{$loop->index}}">
                    <div class="border rounded p-2 bg-light mb-2">
                        {!! $pericopa->descripcion !!}
                    </div>
                </div>
                @endif
                @foreach ($pericopa->versiculos as $index => $versiculo)
                @livewire('escrituras.versiculo', ['versiculo' => $versiculo, 'esPar' => $index % 2 == 0], key($versiculo->id))
                @endforeach
            </div>
            @endforeach
        </div>
        <div class="col-1 text-center" id="navright">
            <a href="{{ route('capitulos.show', ['nombre' => $capituloSiguiente->referencia]) }}" class="btn btn-personalizado btn-flotante">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>

@endsection
