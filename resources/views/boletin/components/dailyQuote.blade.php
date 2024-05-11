{{-- resources/views/boletin/components/dailyQuote.blade.php --}}
<div class="quote-section border rounded p-3">
    @if ($citas)
        <h3>Cita del Día</h3>
        <blockquote>
            <h4>El avance de la inteligencia</h4>
            <div class="border rounded p-1">Cuando meditemos con humildad y aceptemos en toda su plenitud los consejos del Señor, nada podrá
                detener la inteligencia humana.</div>
            <div class="mt-2 border rounded p-1 text-end">Eduardo Ayala, "La Palabra de Sabiduría", Conferencia General, noviembre de 1990</div>
        </blockquote>
    @else
        <p>No hay citas disponibles para hoy.</p>
    @endif
</div>
