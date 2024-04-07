@extends('layouts.main')

@section('content')
    <article class="container mt-5">
        <div class="p-1 mt-0 mb-0 border rounded bg-light small">
            <a href="{{ route('blog.index') }}">
                <i class="fa fa-arrow-left"></i> Artículos
            </a> |
            <a href="javascript:history.back();">
            Atrás
            </a>
        </div>
        <header>
            <h1 class="my-1">{{ $post->title }}</h1>
        </header>
        @if ($post->excerpt)
            <div class="p-2 mb-2 text-center border rounded" style="background-color:#ffffb9">{{ $post->excerpt }}</div>
        @endif
        <!-- Imagen destacada -->
        @if ($post->featuredImageUrl())
            <figure class="text-center bg-light border rounded" style="max-height: 400px; overflow: hidden;">
                <img src="{{ $post->featuredImageUrl() }}" alt="Imagen destacada de {{ $post->title }}"
                    style="max-height: 400px; width: auto; object-fit: cover;" class="img-fluid">
            </figure>
        @endif
        <section>
            {!! $post->content !!}
        </section>
    </article>
@endsection
