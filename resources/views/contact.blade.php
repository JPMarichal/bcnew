@extends('layouts.main')

@section('robots', 'index, follow')
@section('title', 'Contacto - Biblicomentarios')
@section('description', 'Contáctanos para resolver tus dudas o compartir tus comentarios.')

@section('schema_markup')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ContactPage",
  "name": "Contacto",
  "description": "Página de contacto de Biblicomentarios.",
  "publisher": {
    "@type": "Organization",
    "name": "Biblicomentarios"
  }
}
</script>
@endsection

@section('content')
<div class="container mt-5">
    <h1>Contacto</h1>
    <p>En Biblicomentarios estamos siempre dispuestos a escuchar. Ya sea que tengas preguntas, comentarios, o simplemente quieras compartir tus reflexiones, nos encantaría oírte. Tu voz es importante para nosotros y nos esforzamos por mejorar y enriquecer nuestra comunidad con cada aporte. No dudes en llenar el siguiente formulario con tus datos y mensaje. ¡Estamos aquí para ti!</p>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('site.sendContactEmail') }}" id="contactForm">
        @csrf
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Mensaje:</label>
            <textarea class="form-control" id="message" name="message" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-4 mb-5 text-center bg-success">Enviar</button>
    </form>
</div>
@endsection
