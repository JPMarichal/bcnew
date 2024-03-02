<div class="filters-bar mb-3">
    <form action="{{ route('noticias.index') }}" method="GET" class="d-flex justify-content-start">
        <select name="year" id="yearSelect" class="form-select mx-2">
            <option value="">Año</option>
            @foreach ($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
        <select name="month" id="monthSelect" class="form-select mx-2" disabled>
            <option value="">Mes</option>
            <!-- Los meses se llenarán dinámicamente basado en la selección del año -->
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const yearSelect = document.getElementById('yearSelect');
    const monthSelect = document.getElementById('monthSelect');
    const monthsByYear = @json($monthsByYear);

    yearSelect.addEventListener('change', function () {
        const selectedYear = this.value;
        const months = monthsByYear[selectedYear] || [];
        monthSelect.innerHTML = '<option value="">Mes</option>'; // Reset
        months.forEach(month => {
            const monthName = new Date(0, month - 1).toLocaleString('es', { month: 'long' });
            const option = new Option(monthName.charAt(0).toUpperCase() + monthName.slice(1), month);
            monthSelect.options.add(option);
        });
        monthSelect.disabled = !months.length;
    });
});
</script>
