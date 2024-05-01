@extends('layouts.main')

@section('title', $libro->title)
@section('description', $libro->description)
@section('robots', 'index, follow')

@section('featured_image', $libro->featured_image)
@section('published_time', now()->toIso8601String())
@section('modified_time', now()->toIso8601String())
@section('author', 'Juan Pablo Marichal')
@section('type', 'article')
@section('twitter_author', 'JPMarichal')

@section('content')
<div class="container mt-3">
    <h1 class="mb-2">{{$libro->nombre }}</h1>
    <div class="border border-rounded p-2 bg-success text-white text-center mb-3">{{$libro->description}}</div>
    @livewire('escrituras-navigation', ['tipo' => 'libro', 'nombre' => $libro->nombre])

    <x-bladewind::button>Save User</x-bladewind::button>
    
    @foreach ($libro->partes as $parte)
        <h2>{{$parte->nombre}}</h2>
        <div>{{ $parte->description }}</div>
        <ul>
        @foreach ($parte->capitulos as $capitulo)
            <li> <a href="{{ route('capitulos.show', $capitulo->referencia) }}">{{ $capitulo->referencia }}</a></li>
        @endforeach
        </ul>
    @endforeach
</div>
@endsection