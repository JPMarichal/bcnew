@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Solicitud Incorrecta | ' . Request::path())
@section('description', 'La solicitud no puede ser procesada debido a una sintaxis malformada.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "400 Solicitud Incorrecta",
  "description": "La solicitud no puede ser procesada debido a una sintaxis malformada. Asegúrate de que la URL esté escrita correctamente.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">400 - Solicitud Incorrecta</h1>
    <p class="fs-3"><span class="text-danger">Oops!</span> La solicitud no puede ser procesada.</p>
    <section aria-labelledby="description-400">
        <h2 id="description-400" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Lo sentimos, pero no podemos procesar tu solicitud debido a una sintaxis incorrecta. <br>
            Por favor, verifica la URL e inténtalo de nuevo.
        </p>
    </section>
    @include('components.error-navigation')
</main>
@endsection
