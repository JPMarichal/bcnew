@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Error de Gateway | ' . Request::path())
@section('description', 'El servidor recibió una respuesta inválida de un servidor en curso de comunicación.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "502 Error de Gateway",
  "description": "El servidor, actuando como puerta de enlace o proxy, ha recibido una respuesta inválida desde el servidor upstream.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">502 - Error de Gateway</h1>
    <p class="fs-3"><span class="text-danger">Oops!</span> Ha ocurrido un error al comunicarse con el servidor.</p>
    <section aria-labelledby="description-502">
        <h2 id="description-502" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Estamos experimentando problemas de comunicación con un servidor externo, lo que ha resultado en este error de gateway. Estamos trabajando para resolverlo lo antes posible. Por favor, inténtalo nuevamente más tarde.
        </p>
    </section>
    <nav aria-label="Opciones de navegación tras el error de gateway">
        <ul class="list-unstyled">
            <li><a href="/" class="text-primary">Inicio</a></li>
            <li><a href="/noticias" class="text-primary">Últimas Noticias</a></li>
            <li><a href="/contacto" class="text-primary">Contacto</a></li>
        </ul>
    </nav>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
</main>
@endsection
