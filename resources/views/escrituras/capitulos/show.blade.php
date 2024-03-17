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
    <h1>{{$capitulo->referencia}} <br/> {{$capitulo->title }}</h1>
    <div class="border border-rounded p-2 bg-success text-white text-center">{{$capitulo->description}}</div>
    <p class="mb-4">Aquí puedes incluir el contenido específico del capítulo o cualquier información adicional relevante. Recuerda reemplazar este texto con el contenido real que deseas mostrar.</p>
    <!-- Considera agregar contenido dinámico o estático aquí según sea necesario -->
</div>
@endsection
