@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Autenticación Requerida | ' . Request::path())
@section('description', 'Es necesario autenticarse para acceder al recurso solicitado.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "401 Autenticación Requerida",
  "description": "Para acceder al recurso solicitado es necesario autenticarse. Por favor, inicia sesión con tus credenciales.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">401 - Autenticación Requerida</h1>
    <p class="fs-3"><span class="text-danger">Acceso Restringido</span> Es necesario autenticarse.</p>
    <section aria-labelledby="description-401">
        <h2 id="description-401" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Para ver esta página necesitas estar autenticado. Si tienes una cuenta, por favor <a href="/login" class="text-primary">inicia sesión</a>. Si el problema persiste, contacta al administrador del sitio.
        </p>
    </section>
    @include('components.error-navigation')
</main>
@endsection
