@extends('layouts.main')

@section('title', 'Noticias')
@section('description', 'Noticias de la Iglesia de Jesucristo de los Santos de los Ultimos Días')

@section('content')
<div class="container mt-5">
    <h1>Noticias de la Iglesia de Jesucristo <br />de los Santos de los Ultimos Días</h1>
    <x-news.filters :years="$years" />
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($news as $newsItem)
        <div class="col">
            <div class="card h-100">
                <a href="{{ route('noticias.show', $newsItem->slug) }}">
                    <img src="{{ $newsItem->featured_image }}" class="card-img-top" alt="{{ $newsItem->title }}">
                </a>
                <div class="card-body">
                    <a href="{{ route('noticias.show', $newsItem->slug) }}" style="text-decoration: none; color: inherit;">
                        <h3 class="card-title">{{ $newsItem->title }}</h3>
                    </a>
                    <p class="card-text text-muted" style="font-size: 0.8rem;">
                        {{ \Carbon\Carbon::parse($newsItem->pub_date)->format('d M, Y') }} - {{ $newsItem->country }}
                    </p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('noticias.show', $newsItem->slug) }}" class="btn btn-primary">Leer más</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        <x-custom-pagination :paginator="$news" />
    </div>
</div>
@endsection
