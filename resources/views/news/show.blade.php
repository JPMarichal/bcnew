@include('layouts.header')

<div class="container mt-5">
    <h1>{{ $newsItem->title }}</h1>

    <x-news.meta-bar :newsItem="$newsItem" />

    <div class="row">
        <!-- Barra flotante a la izquierda -->
        <div class="col-md-1">
            <x-social-share-bar />
        </div>

        <!-- Contenido de la noticia -->
        <div class="col-md-11">
            {!! $newsItem->content !!}
        </div>
    </div>


    <a href="{{ route('noticias.index') }}" class="btn btn-primary mt-3">
        <i class="fas fa-arrow-left"></i> Regresar al listado
    </a>
</div>

@include('layouts.footer')