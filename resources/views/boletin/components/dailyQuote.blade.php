{{-- resources/views/boletin/components/dailyQuote.blade.php --}}
<div class="quote-section border rounded p-3">
    @if ($cita)
        <h3>Cita del Día</h3>
        <blockquote>
            <h4>{{ $cita->titulo }}</h4>
            <div class="border rounded p-1">
                {{ $cita->texto }}
            </div>
            <div class="mt-2 border rounded p-1 text-end">
                {{ $cita->referencia }}
            </div>
        </blockquote>
    @else
        <p>No hay citas disponibles para hoy.</p>
    @endif
</div>
