@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Error Interno del Servidor | ' . Request::path())
@section('description', 'Ha ocurrido un error inesperado en el servidor al intentar procesar tu solicitud.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "500 Error Interno del Servidor",
  "description": "El servidor ha encontrado una situación que no sabe manejar. Estamos trabajando para resolver el problema. Por favor, inténtalo de nuevo más tarde.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">500 - Error Interno del Servidor</h1>
    <p class="fs-3"><span class="text-danger">Lo sentimos</span>, ha ocurrido un error inesperado.</p>
    <section aria-labelledby="description-500">
        <h2 id="description-500" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Ha ocurrido un error interno mientras intentábamos procesar tu solicitud. Esto generalmente es temporal y estamos trabajando para solucionarlo lo antes posible. Agradecemos tu paciencia.
        </p>
    </section>
    @include('components.error-navigation')
</main>
@endsection
