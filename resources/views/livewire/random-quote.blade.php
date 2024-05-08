<div>
    @if ($quote)
        <div class="quote-container border rounded">
            {!! $quote !!}
        </div>
    @else
        <p>No se encontró ninguna cita para mostrar.</p>
    @endif
</div>
