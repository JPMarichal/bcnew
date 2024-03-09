@extends('layouts.main')

@section('robots', 'noindex, follow')

@section('title', 'Servicio No Disponible')
@section('description', 'El sitio web está temporalmente fuera de servicio debido a mantenimiento o sobrecarga de recursos.')
@section('author', 'Juan Pablo Marichal')
@section('type', 'website')
@section('twitter_author', 'JPMarichal')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "503 Servicio No Disponible",
  "description": "El servicio no está disponible temporalmente. Esto puede deberse a mantenimiento o sobrecarga de recursos. Intenta acceder nuevamente más tarde.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<main class="container text-center mt-5" role="main">
    <h1 class="display-1 fw-bold">503 - Servicio No Disponible</h1>
    <p class="fs-3">Actualmente el sitio web no está disponible debido a mantenimiento o sobrecarga.</p>
    <section aria-labelledby="description-503">
        <h2 id="description-503" class="visually-hidden">Descripción del Error</h2>
        <p class="lead">
            Estamos realizando mantenimiento programado o estamos experimentando una sobrecarga de tráfico en este momento. Por favor, vuelve a intentarlo más tarde. Apreciamos tu paciencia y comprensión.
        </p>
    </section>
    <nav aria-label="Opciones de navegación durante el mantenimiento">
        <ul class="list-unstyled">
            <li><a href="/" class="text-primary">Inicio</a></li>
            <li><a href="/noticias" class="text-primary">Últimas Noticias</a></li>
            <li><a href="/contacto" class="text-primary">Contacto</a></li>
        </ul>
    </nav>
    <a href="/" class="btn btn-primary">Volver al inicio</a>
</main>
@endsection
