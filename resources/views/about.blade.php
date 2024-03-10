@extends('layouts.main')

@section('robots', 'index, follow')
@section('title', 'Acerca de Nosotros - Biblicomentarios')
@section('description', 'Descubre más sobre Biblicomentarios y su compromiso con el estudio académico de las escrituras en armonía con la doctrina de La Iglesia de Jesucristo de los Santos de los Últimos Días.')

@section('schema_markup')
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "name": "Biblicomentarios",
  "url": "{{ url()->current() }}",
  "description": "Biblicomentarios, fundado por Juan Pablo Marichal Catalán, se dedica a mejorar el estudio de las escrituras situándolas en su contexto y aplicación, en armonía con la doctrina de La Iglesia de Jesucristo de los Santos de los Últimos Días.",
  "founder": "Juan Pablo Marichal Catalán",
  "foundingDate": "2015",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Boulevard del Temoluco 47 A 002",
    "addressLocality": "Ciudad de México",
    "addressRegion": "México",
    "postalCode": "07279",
    "addressCountry": "México"
  },
  "contactPoint": {
    "@type": "ContactPoint",
    "contactType": "customer support",
    "email": "contacto@biblicomentarios.com",
    "telephone": "+52-55-4833-6098"
  }
}
</script>
@endsection

@section('content')
<div class="container mt-5">
    <article>
        <h1>Acerca de Nosotros</h1>

        <div class="border border-round p-3 mb-4">
        <section class="about-section">
            <p>Biblicomentarios es una iniciativa particular de Juan Pablo Marichal Catalán, dedicada a enriquecer el estudio de las escrituras por medio de situarlas en su contexto histórico, cultural y doctrinal, con el objetivo de profundizar en su comprensión y aplicación. Nuestro esfuerzo busca mantenerse siempre en armonía con la doctrina y las prácticas de La Iglesia de Jesucristo de los Santos de los Últimos Días, proporcionando material didáctico útil tanto para el aprendizaje individual como para la enseñanza.</p>
            <p>Es importante mencionar que Biblicomentarios no es un sitio oficial de La Iglesia de Jesucristo de los Santos de los Últimos Días, pero se realiza un esmerado intento por respetar y reflejar fielmente sus enseñanzas y principios.</p>
        </section>

        <section class="mission-section mt-4">
            <h2>Nuestra Misión</h2>
            <p>Nuestra misión es proveer a los miembros de la Iglesia y a cualquier interesado, recursos que faciliten un estudio profundo de las escrituras, situándolas en su contexto y destacando su relevancia y aplicación en la vida diaria. Aspiramos a ser un recurso de apoyo en el crecimiento espiritual y académico de los Santos de los Últimos Días alrededor del mundo.</p>
        </section>

        <a href="/" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left"></i> Regresar al inicio
        </a>
        </div>
    </article>
</div>
@endsection
