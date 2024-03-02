@include('layouts.header')

<div class="container mt-5">
    <h1>{{ $newsItem->title }}</h1>
    
    <x-news.meta-bar :newsItem="$newsItem" />
    
    {!! $newsItem->content !!}
    <a href="{{ route('noticias.index') }}" class="btn btn-primary mt-3">
        <i class="fas fa-arrow-left"></i> Regresar al listado
    </a>
</div>

@include('layouts.footer')
