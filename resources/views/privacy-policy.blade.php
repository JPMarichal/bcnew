@extends('layouts.main')

@section('robots', 'index, follow')
@section('title', 'Política de Privacidad - Biblicomentarios')
@section('description',
    'Lee nuestra Política de Privacidad para entender cómo recopilamos, usamos y protegemos tu
    información.')

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
    <div class="container mt-0 mb-4">
        <h1>Política de Privacidad</h1>
        <p>En Biblicomentarios, la privacidad de nuestros visitantes es de extrema importancia. Esta Política de Privacidad
            describe detalladamente los tipos de información personal que recopilamos y registramos, cómo la usamos, y cómo
            puedes gestionar tu información personal.</p>

        <h2>Vigencia de la política de privacidad</h2>

        <p>Es preciso advertir que esta Política de Privacidad podría variar en función de exigencias legislativas o de
            autorregulación, por lo que se aconseja a los usuarios que la visiten periódicamente. Será aplicable en caso de
            que los usuarios decidan rellenar algún formulario de cualquiera de sus formularios de contacto donde se recaben
            datos de carácter personal.</p>

        <h2>Base jurídica</h2>

        <p>Biblicomentarios.com ha adecuado esta web a las exigencias de la Ley Orgánica 15/1999, de 13 de diciembre, de
            Protección de Datos de Carácter Personal (LOPD), y al Real Decreto 1720/2007, de 21 de diciembre, conocido como
            el Reglamento de desarrollo de la LOPD. Cumple también con el Reglamento (UE) 2016/679 del Parlamento Europeo y
            del Consejo de 27 de abril de 2016 relativo a la protección de las personas físicas (RGPD), así como con la Ley
            34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y Comercio Electrónico (LSSICE o LSSI).
        </p>

        <h2>Información Recopilada</h2>
        <p>Recopilamos información de diferentes formas, incluido pero no limitado a, cuando visitas nuestro sitio, te
            registras, completas un formulario, y en conexión con otras actividades, servicios, características o recursos
            que ponemos a tu disposición. Se te puede pedir, según sea apropiado, nombre, dirección de correo electrónico,
            número de teléfono. Recopilamos información solo cuando nos la envías voluntariamente.</p>

        <p>A efectos de lo previsto en el Reglamento General de Protección de Datos antes citado, los datos personales que
            envíes a través de los formularios del sitio, recibirán el tratamiento de datos de “Usuarios de la web y
            suscriptores”.</p>

        <h2>Principios aplicados</h2>

        <ul>
            <li><strong>Principio de licitud, lealtad y transparencia:</strong>&nbsp;Siempre voy a requerir tu
                consentimiento para el tratamiento de tus datos personales para uno o varios fines específicos que te
                informaré previamente con absoluta transparencia.</li>
            <li><strong>Principio de minimización de datos:</strong>&nbsp;Solo voy a solicitar datos estrictamente
                necesarios en relación con los fines para los que los requiero. Los mínimos posibles.</li>
            <li><strong>Principio de limitación del plazo de conservación:</strong>&nbsp;los datos serán mantenidos durante
                no más tiempo del necesario para los fines del tratamiento, en función a la finalidad, te informaré del
                plazo de conservación correspondiente, en el caso de suscripciones, periódicamente revisaré mis listas y
                eliminaré aquellos registros inactivos durante un tiempo considerable.</li>
            <li><strong>Principio de integridad y confidencialidad:</strong>&nbsp;Tus datos serán tratados de tal manera que
                se garantice una seguridad adecuada de los datos personales y se garantice confidencialidad. Debes saber que
                tomo todas las precauciones necesarias para evitar el acceso no autorizado o uso indebido de los datos de
                mis usuarios por parte de terceros.</li>
        </ul>

        <h2>Cómo Utilizamos la Información Recopilada</h2>
        <p>La información que recopilamos se utiliza para personalizar tu experiencia, mejorar nuestro sitio, enviar correos
            electrónicos periódicos sobre tu cuenta o otros productos y servicios, y para mostrarte publicidad relevante a
            través de Google AdSense. No vendemos, comerciamos, o alquilamos tu información de identificación personal a
            terceros.</p>

        <h2>Tu Perfil de Usuario y Control de Información</h2>
        <p>Cada usuario registrado en Biblicomentarios cuenta con un perfil personal donde puede ver, editar o eliminar su
            información personal en cualquier momento. Desde tu perfil, también puedes gestionar tus suscripciones y
            preferencias de privacidad. Nos esforzamos por facilitarte el control total sobre tus datos en nuestra
            plataforma.</p>

        <h2>Google AdSense y Analytics</h2>
        <p>Utilizamos Google AdSense para mostrarte anuncios personalizados y Google Analytics para analizar la forma en que
            los usuarios interactúan con nuestro sitio. Ambas herramientas utilizan cookies para recopilar información de
            forma anónima y ofrecer experiencias mejoradas.</p>

        <h2>Seguridad de la Información</h2>
        <p>Adoptamos medidas de seguridad adecuadas para proteger contra el acceso no autorizado, alteración, divulgación o
            destrucción de tu información personal, nombre de usuario, contraseña, información de transacciones y datos
            almacenados en nuestro sitio.</p>

        <h2>Derechos ARCO</h2>
        <p>Respetamos tus derechos de Acceso, Rectificación, Cancelación y Oposición a tus datos personales. En cualquier
            momento, puedes ejercer estos derechos a través de las opciones disponibles en tu perfil de usuario o
            contactándonos directamente.</p>

        <h2>Contacto</h2>
        <p>Si tienes preguntas, comentarios o solicitudes relacionadas con esta Política de Privacidad, puedes contactarnos
            utilizando el formulario de contacto disponible en nuestro sitio. Nos comprometemos a responder de manera
            oportuna y adecuada.</p>

        <a href="{{ route('site.about') }}" class="btn btn-primary mt-3">Acerca de Nosotros</a>
    </div>
@endsection
