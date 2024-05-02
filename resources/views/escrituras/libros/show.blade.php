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
        <h1 class="mb-2">{{ $libro->nombre }}</h1>
        <div class="border border-rounded p-2 bg-success text-white text-center mb-3">{{ $libro->description }}</div>
        @livewire('escrituras-navigation', ['tipo' => 'libro', 'nombre' => $libro->nombre])

        <x-bladewind::tab-group name="aspectos" style="system">
            <x-slot:headings>
                <x-bladewind::tab-heading name="estructura" active="true" label="Estructura" />

                <x-bladewind::tab-heading name="unsplash-2" label="Marko Pavlichenko" />

                <x-bladewind::tab-heading name="unsplash-3" label="Yoonbae Cho" />

                <x-bladewind::tab-heading name="unsplash-4" label="Sam Carter" />
            </x-slot:headings>

            <x-bladewind::tab-body>

                <x-bladewind::tab-content name="estructura">
                    @foreach ($libro->partes as $parte)
                        <h2>{{ $parte->nombre }}</h2>
                        <div>{{ $parte->description }}</div>
                        <ul>
                            @foreach ($parte->capitulos as $capitulo)
                                <li> <a
                                        href="{{ route('capitulos.show', $capitulo->referencia) }}">{{ $capitulo->referencia }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </x-bladewind::tab-content>

                <x-bladewind::tab-content name="unsplash-2">
                    <img src="/path/to/the/image/file" alt="Picture by Marko Pavlichenko" />
                </x-bladewind::tab-content>

                <x-bladewind::tab-content name="unsplash-3" active="true">
                    <img src="/path/to/the/image/file" alt="Picture by Yoonbae Cho" />
                </x-bladewind::tab-content>

                <x-bladewind::tab-content name="unsplash-4">
                    <img src="/path/to/the/image/file" alt="Picture by Sam Carter" />
                </x-bladewind::tab-content>

            </x-bladewind::tab-body>
        </x-bladewind::tab-group>

    </div>
@endsection
