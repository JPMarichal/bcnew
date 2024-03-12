@extends('layouts.main')

@section('robots', 'index, follow')
@section('title', 'Política de Cookies - Biblicomentarios')
@section('description', 'Descubre cómo utilizamos las cookies en Biblicomentarios para mejorar tu experiencia.')

@section('schema_markup')
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "WebPage",
  "name": "Política de Cookies",
  "description": "Información sobre el uso de cookies en Biblicomentarios.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "Inicio",
      "item": "{{ url('/') }}"
    },{
      "@type": "ListItem",
      "position": 2,
      "name": "Política de Cookies",
      "item": "{{ url()->current() }}"
    }]
  }
}
</script>
@endsection

@section('content')
<div class="container mt-0">
    <article>
        <header>
            <h1>Política de Cookies</h1>
        </header>
        <section>
            <p>En Biblicomentarios, utilizamos cookies para mejorar tu experiencia de navegación. Aquí explicamos qué son las cookies, cómo las usamos en nuestro sitio, y cómo puedes gestionarlas.</p>
        </section>
        
        <section>
            <h2>¿Qué son las cookies?</h2>
            <p>Las cookies son pequeños archivos de texto que los sitios web pueden usar para hacer más eficiente la experiencia del usuario. Las cookies se almacenan en tu dispositivo cuando el sitio web se carga en tu navegador.</p>
        </section>

        <section>
            <h2>Cómo utilizamos las cookies</h2>
            <p>Utilizamos cookies para entender cómo interactúas con nuestro sitio, mantener tus preferencias de sesión, y mejorar y personalizar tu experiencia en nuestro sitio.</p>
        </section>

        <section>
            <h2>Gestión de cookies</h2>
            <p>Tienes el derecho de decidir si aceptas o rechazas las cookies. Puedes ajustar la configuración de tu navegador para rechazar cookies si lo prefieres. Sin embargo, ten en cuenta que esto podría afectar tu capacidad de usar plenamente nuestro sitio web.</p>
        </section>

        <footer>
            <a href="{{ route('site.about') }}" class="btn btn-primary mt-3">Acerca de Nosotros</a>
        </footer>
    </article>
</div>
@endsection
