@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Acceso Denegado | ' . Request::path())
@section('description', 'No tienes permiso para acceder a esta página.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "403 Acceso Denegado",
  "description": "Intentaste acceder a una página para la cual no tienes permiso. Si crees que esto es un error, por favor contacta al administrador del sitio.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">403 - Acceso Denegado</h1>
    <p class="fs-3"><span class="text-danger">¡Vaya!</span> No tienes permiso para acceder a esta página.</p>
    <section aria-labelledby="description-403">
        <h2 id="description-403" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Lo sentimos, pero no puedes acceder a esta área o recurso. Si crees que deberías tener acceso, por favor verifica tu estado de autenticación o contacta al administrador del sitio. <br>
            Aquí tienes algunas opciones para continuar navegando:
        </p>
    </section>
    <nav aria-label="Opciones de navegación tras el acceso denegado">
        <ul class="list-unstyled">
            <li><a href="/" class="text-primary">Inicio</a></li>
            <li><a href="/noticias" class="text-primary">Últimas Noticias</a></li>
            <li><a href="/contacto" class="text-primary">Contacto</a></li>
        </ul>
    </nav>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
</main>
@endsection
