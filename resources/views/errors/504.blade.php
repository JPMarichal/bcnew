@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Tiempo de Espera del Gateway Excedido | ' . Request::path())
@section('description', 'El servidor no ha recibido una respuesta a tiempo para completar la solicitud.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "504 Tiempo de Espera del Gateway Excedido",
  "description": "El servidor, actuando como puerta de enlace o proxy, no ha recibido una respuesta a tiempo del servidor ascendente o aplicación auxiliar, impidiendo completar la solicitud.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">504 - Tiempo de Espera del Gateway Excedido</h1>
    <p class="fs-3">El servidor no ha recibido una respuesta a tiempo para completar tu solicitud.</p>
    <section aria-labelledby="description-504">
        <h2 id="description-504" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Lamentablemente, tu solicitud no puede ser procesada en este momento debido a un retraso en la respuesta desde el servidor ascendente o una aplicación auxiliar. Esto suele ser temporal. Te sugerimos intentar nuevamente en unos minutos. Si el problema persiste, por favor contacta al administrador del sitio.
        </p>
    </section>
    @include('components.error-navigation')
</main>
@endsection
