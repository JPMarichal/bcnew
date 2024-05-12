{{-- resources/views/boletin/components/dailyPassage.blade.php --}}
<div class="quote-section border rounded p-3">
    @if ($cita)
        <h3 class="p-1">Pasaje del Día</h3>
        <blockquote>
            <h4>Vendrá hambre de oir la palabra de Jehová</h4>
<div class="border rounded p-1">
<p>11 He aquí, vienen días, dice Jehová el Señor, en los cuales enviaré hambre a la tierra, no hambre de pan ni sed de
agua, sino de oír la palabra de Jehová.</p>
<p>12 E irán errantes de mar a mar; desde el norte hasta el oriente andarán buscando la palabra de Jehová y no la hallarán.</p>
</div>
<div class="mt-2 border rounded p-1 text-end">
(Amós 8:11–12)
</div>
        </blockquote>
    @else
        <p>No hay citas disponibles para hoy.</p>
    @endif
</div>
