{{-- resources/views/boletin/components/dailyQuote.blade.php --}}
<div class="quote-section border rounded p-3">
    @if ($citas)
        <h3>Editorial</h3>
        <div class="border rounded p-1">
            Esta es la editorial.
        </div>
    @else
        <p>No hay citas disponibles para hoy.</p>
    @endif
</div>
