@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Método No Permitido | ' . Request::path())
@section('description', 'El método HTTP utilizado no es válido para el recurso solicitado.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "405 Método No Permitido",
  "description": "El método HTTP utilizado en la solicitud no es compatible con el recurso. Por favor, verifica la documentación o contacta al administrador del sitio si crees que esto es un error.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">405 - Método No Permitido</h1>
    <p class="fs-3"><span class="text-danger">Oops!</span> El método HTTP utilizado no es válido para esta solicitud.</p>
    <section aria-labelledby="description-405">
        <h2 id="description-405" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Lo sentimos, pero no se permite el método HTTP utilizado para acceder a esta URL. <br>
            Verifica la URL e inténtalo nuevamente o utiliza un método HTTP diferente. Si necesitas ayuda, no dudes en contactar al administrador del sitio.
        </p>
    </section>
    <nav aria-label="Opciones de navegación tras el error de método no permitido">
        <ul class="list-unstyled">
            <li><a href="/" class="text-primary">Inicio</a></li>
            <li><a href="/noticias" class="text-primary">Últimas Noticias</a></li>
            <li><a href="/contacto" class="text-primary">Contacto</a></li>
        </ul>
    </nav>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
</main>
@endsection
