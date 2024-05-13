{{-- resources/views/boletin/components/dailyQuote.blade.php --}}
<div class="quote-section border rounded p-3 my-2">
    @if ($cita)
        <h3>Cita del Día</h3>
        <h4>{{ $cita->titulo }}</h4>
        <div class="p-1">
            {{ $cita->texto }}
        </div>
        <div class="mt-2 text-end">
            {{ $cita->referencia }}
        </div>
    @else
        <p>No hay citas disponibles para hoy.</p>
    @endif
</div>
