@extends('layouts.main')

@section('title', 'Noticias de la Iglesia de Jesucristo de los Santos de los Últimos Días')
@section('description', 'Mantente al día con las últimas noticias relacionadas con la Iglesia de Jesucristo de los Santos de los Últimos Días.')
@section('robots', 'index, follow')

@if($news->isNotEmpty())
    @section('featured_image', $news->first()->featured_image)
    @section('published_time', now()->toIso8601String())
    @section('modified_time', now()->toIso8601String())
    @section('author', 'Juan Pablo Marichal')
    @section('type', 'article')
    @section('twitter_author', 'JPMarichal')
@endif

@section('content')
<div class="container mt-5">
    <h1>Noticias de la Iglesia de Jesucristo <br />de los Santos de los Ultimos Días</h1>
    <x-news.filters :years="$years" />
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($news as $newsItem)
        <article class="col">
            <div class="card h-100">
                <a href="{{ route('noticias.show', $newsItem->slug) }}">
                    <img src="{{ $newsItem->featured_image }}" class="card-img-top" alt="{{ $newsItem->title }}">
                </a>
                <div class="card-body">
                    <a href="{{ route('noticias.show', $newsItem->slug) }}" style="text-decoration: none; color: inherit;">
                        <h2 class="card-title">{{ $newsItem->title }}</h2>
                    </a>
                    <p class="card-text text-muted" style="font-size: 0.8rem;">
                        {{ \Carbon\Carbon::parse($newsItem->pub_date)->format('d M, Y') }} - {{ $newsItem->country }}
                    </p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('noticias.show', $newsItem->slug) }}" class="btn btn-primary">Leer más</a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        <x-custom-pagination :paginator="$news" />
    </div>
</div>
@endsection
