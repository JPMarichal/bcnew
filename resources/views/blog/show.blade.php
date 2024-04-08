@extends('layouts.main')

@section('content')
    <style>
        .featuredImage {
            background-image: url('{{ $post->featuredImageUrl() }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 600px;
            margin: 15px auto;
        }

        .featuredH1 {
            color: white;
            text-align: center;
            font-size: 40px;
            background-color: black;
            opacity: 0.9;
            padding: 1%;
            margin-top: 260px;
        }
    </style>
    <article class="container mt-5">
        <div class="p-1 mt-0 mb-0 border rounded bg-light small">
            <a href="{{ route('blog.index') }}">
                <i class="fa fa-arrow-left"></i> Artículos
            </a> |
            <a href="javascript:history.back();">
                Atrás
            </a>
        </div>

        <!-- Imagen destacada -->
        @if ($post->featuredImageUrl())
            <header class="featuredImage text-center bg-light border rounded" style="max-height: 400px; overflow: hidden;">

                <h1 class="featuredH1">{{ $post->title }}</h1>
            </header>
        @else
            <h1>{{ $post->title }}</h1>
        @endif
        @if ($post->excerpt)
            <div class="p-2 mb-2 text-center border rounded" style="background-color:#ffffb9">{{ $post->excerpt }}</div>
        @endif
        <section>
            {!! $post->content !!}
        </section>
    </article>
@endsection
