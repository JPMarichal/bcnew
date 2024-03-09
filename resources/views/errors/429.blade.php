@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Demasiadas Solicitudes | ' . Request::path())
@section('description', 'Has enviado demasiadas solicitudes en un corto período de tiempo.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "429 Demasiadas Solicitudes",
  "description": "Se han enviado demasiadas solicitudes en un corto período de tiempo. Por favor, espera un momento antes de intentar nuevamente.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">429 - Demasiadas Solicitudes</h1>
    <p class="fs-3"><span class="text-danger">¡Alto!</span> Has realizado demasiadas solicitudes recientemente.</p>
    <section aria-labelledby="description-429">
        <h2 id="description-429" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Nuestro sistema ha detectado un número inusualmente alto de solicitudes desde tu dirección IP o usuario. Esto puede ocurrir al intentar actualizar una página repetidamente o al usar una herramienta automatizada. Por favor, espera unos minutos antes de intentar nuevamente. Si crees que esto es un error, contacta al administrador del sitio.
        </p>
    </section>
    @include('components.error-navigation')
</main>
@endsection
