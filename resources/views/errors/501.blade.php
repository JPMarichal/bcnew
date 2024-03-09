@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'No Implementado | ' . Request::path())
@section('description', 'La solicitud utiliza una función que el servidor no soporta.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "501 No Implementado",
  "description": "La funcionalidad requerida para procesar esta solicitud no está implementada en el servidor. Esto puede deberse a que la característica esté en desarrollo o no esté disponible.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">501 - No Implementado</h1>
    <p class="fs-3">La funcionalidad requerida para completar esta solicitud aún no está implementada.</p>
    <section aria-labelledby="description-501">
        <h2 id="description-501" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Lamentablemente, no podemos procesar tu solicitud en este momento ya que la funcionalidad específica no ha sido implementada en el servidor. Agradecemos tu comprensión.
        </p>
    </section>
    <nav aria-label="Opciones de navegación tras encontrar una funcionalidad no implementada">
        <ul class="list-unstyled">
            <li><a href="/" class="text-primary">Inicio</a></li>
            <li><a href="/noticias" class="text-primary">Últimas Noticias</a></li>
            <li><a href="/contacto" class="text-primary">Contacto</a></li>
        </ul>
    </nav>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
</main>
@endsection
