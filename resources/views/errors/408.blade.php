@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Tiempo de Espera Excedido | ' . Request::path())
@section('description', 'La solicitud ha tardado demasiado tiempo en completarse y el servidor ha cerrado la conexión.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "408 Tiempo de Espera Excedido",
  "description": "La solicitud no se ha podido completar en el tiempo esperado por el servidor, lo que ha resultado en un tiempo de espera excedido. Esto puede ser temporal, intenta nuevamente en unos momentos.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">408 - Tiempo de Espera Excedido</h1>
    <p class="fs-3"><span class="text-danger">¡Ups!</span> Tu solicitud ha tardado demasiado en completarse.</p>
    <section aria-labelledby="description-408">
        <h2 id="description-408" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            El servidor ha cerrado la conexión porque la solicitud ha excedido el tiempo de espera permitido. Esto suele ser temporal. Te recomendamos intentar nuevamente en unos momentos. Si el problema persiste, por favor contacta al administrador del sitio.
        </p>
    </section>
    <nav aria-label="Opciones de navegación tras el tiempo de espera excedido">
        <ul class="list-unstyled">
            <li><a href="/" class="text-primary">Inicio</a></li>
            <li><a href="/noticias" class="text-primary">Últimas Noticias</a></li>
            <li><a href="/contacto" class="text-primary">Contacto</a></li>
        </ul>
    </nav>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
</main>
@endsection
