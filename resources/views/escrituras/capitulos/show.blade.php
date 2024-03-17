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
<div class="container mt-3">
    <h1 class="mb-2">{{$capitulo->referencia}} <br /> {{$capitulo->title }}</h1>
    <div class="border border-rounded p-2 bg-success text-white text-center mt-0 mb-3">{{$capitulo->description}}</div>
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
@endsection