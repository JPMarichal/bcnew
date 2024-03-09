@extends('layouts.main')
@section('robots', 'noindex, follow')

@section('title', 'Página no encontrada | ' . Request::path())
@section('description', 'La página que estás buscando no existe o ha sido movida.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "404 Página No Encontrada",
  "description": "La página que buscas no existe o ha sido movida. Explora opciones para encontrar lo que buscas o regresa al inicio.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">404 - Página no encontrada</h1>
    <p class="fs-3"><span class="text-danger">Oops!</span> Página no encontrada.</p>
    <section aria-labelledby="description-404">
        <h2 id="description-404" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            La página que estás buscando no existe o ha sido movida. 
            Pero no te preocupes. <br>
            Aquí tienes algunas opciones para encontrar lo que buscas:
        </p>
    </section>
    <nav aria-label="Opciones de navegación para la página no encontrada">
        <ul class="list-unstyled">
            <li><a href="/" class="text-primary">Inicio</a></li>
            <li><a href="/noticias" class="text-primary">Últimas Noticias</a></li>
            <li><a href="/contacto" class="text-primary">Contacto</a></li>
        </ul>
    </nav>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
</main>
@endsection
