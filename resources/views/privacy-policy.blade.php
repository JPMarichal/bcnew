@extends('layouts.main')

@section('robots', 'index, follow')
@section('title', 'Política de Privacidad - Biblicomentarios')
@section('description', 'Lee nuestra Política de Privacidad para entender cómo recopilamos, usamos y protegemos tu información.')

@section('schema_markup')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Política de Privacidad",
  "description": "Política de privacidad de Biblicomentarios, detallando el manejo de información personal, uso de Google AdSense y Analytics, y derechos de los usuarios.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<div class="container mt-5 mb-4">
    <h1>Política de Privacidad</h1>
    <p>En Biblicomentarios, la privacidad de nuestros visitantes es de extrema importancia. Esta Política de Privacidad describe detalladamente los tipos de información personal que recopilamos y registramos, cómo la usamos, y cómo puedes gestionar tu información personal.</p>

    <h2>Información Recopilada</h2>
    <p>Recopilamos información de diferentes formas, incluido pero no limitado a, cuando visitas nuestro sitio, te registras, completas un formulario, y en conexión con otras actividades, servicios, características o recursos que ponemos a tu disposición. Se te puede pedir, según sea apropiado, nombre, dirección de correo electrónico, número de teléfono. Recopilamos información solo cuando nos la envías voluntariamente.</p>
    
    <h2>Cómo Utilizamos la Información Recopilada</h2>
    <p>La información que recopilamos se utiliza para personalizar tu experiencia, mejorar nuestro sitio, enviar correos electrónicos periódicos sobre tu cuenta o otros productos y servicios, y para mostrarte publicidad relevante a través de Google AdSense. No vendemos, comerciamos, o alquilamos tu información de identificación personal a terceros.</p>

    <h2>Tu Perfil de Usuario y Control de Información</h2>
    <p>Cada usuario registrado en Biblicomentarios cuenta con un perfil personal donde puede ver, editar o eliminar su información personal en cualquier momento. Desde tu perfil, también puedes gestionar tus suscripciones y preferencias de privacidad. Nos esforzamos por facilitarte el control total sobre tus datos en nuestra plataforma.</p>

    <h2>Google AdSense y Analytics</h2>
    <p>Utilizamos Google AdSense para mostrarte anuncios personalizados y Google Analytics para analizar la forma en que los usuarios interactúan con nuestro sitio. Ambas herramientas utilizan cookies para recopilar información de forma anónima y ofrecer experiencias mejoradas.</p>

    <h2>Seguridad de la Información</h2>
    <p>Adoptamos medidas de seguridad adecuadas para proteger contra el acceso no autorizado, alteración, divulgación o destrucción de tu información personal, nombre de usuario, contraseña, información de transacciones y datos almacenados en nuestro sitio.</p>

    <h2>Derechos ARCO</h2>
    <p>Respetamos tus derechos de Acceso, Rectificación, Cancelación y Oposición a tus datos personales. En cualquier momento, puedes ejercer estos derechos a través de las opciones disponibles en tu perfil de usuario o contactándonos directamente.</p>

    <h2>Contacto</h2>
    <p>Si tienes preguntas, comentarios o solicitudes relacionadas con esta Política de Privacidad, puedes contactarnos utilizando el formulario de contacto disponible en nuestro sitio. Nos comprometemos a responder de manera oportuna y adecuada.</p>

    <a href="{{ route('site.about') }}" class="btn btn-primary mt-3">Acerca de Nosotros</a>
</div>
@endsection
