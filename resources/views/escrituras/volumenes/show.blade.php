@extends('layouts.main')

@section('title', $volumen->title)
@section('description', $volumen->description)
@section('robots', 'index, follow')

@section('featured_image', $volumen->featured_image)
@section('published_time', now()->toIso8601String())
@section('modified_time', now()->toIso8601String())
@section('author', 'Juan Pablo Marichal')
@section('type', 'article')
@section('twitter_author', 'JPMarichal')

@section('content')
<div class="container mt-3">
    <h1 class="mb-2">{{$volumen->nombre }}</h1>
    <div class="border border-rounded p-2 bg-success text-white text-center mb-3">{{$volumen->description}}</div>
    @foreach ($volumen->divisiones as $division)
        <h2>{{$division->nombre}}</h2>
        <div>{{ $division->description }}</div>
        <ul>
        @foreach ($division->libros as $libro)
            <li> <a href="{{ route('libros.show', $libro->nombre) }}">{{ $libro->nombre }}</a></li>
        @endforeach
        </ul>
    @endforeach
</div>
@endsection