<div class="filters-bar mb-3">
    <div class="d-flex flex-column flex-md-row justify-content-between">
        <form action="{{ route('noticias.index') }}" method="GET" class="mb-3 mb-md-0 w-100" style="max-width: 100%;">
            <div class="d-flex justify-content-between">
                <label for="yearSelect" class="visually-hidden">Año</label>
                <select name="year" id="yearSelect" class="form-select mx-2" onchange="updateMonthSelect()">
                    <option value="">Año</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
                <label for="monthSelect" class="visually-hidden">Mes</label>
                <select name="month" id="monthSelect" class="form-select mx-2" disabled>
                    <option value="">Mes</option>
                    <!-- Los meses se llenarán dinámicamente basado en la selección del año -->
                </select>
                <button type="submit" class="btn btn-primary mx-2" style="background-color: blue;">Filtrar</button>
            </div>
        </form>

        <form action="{{ route('noticias.search') }}" method="GET" class="w-100" style="max-width: 100%;">
            <div class="d-flex justify-content-between">
                <input type="text" name="query" placeholder="Buscar noticias..." class="form-control mx-2">
                <button type="submit" class="btn btn-primary mx-2" style="background-color: blue;">Buscar</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const yearSelect = document.getElementById('yearSelect');
    const monthSelect = document.getElementById('monthSelect');
    const monthsByYear = @json($monthsByYear);

    function updateMonthSelect() {
        const selectedYear = yearSelect.value;
        monthSelect.innerHTML = '<option value="">Mes</option>'; // Reset
        if (selectedYear) {
            const months = monthsByYear[selectedYear] || [];
            months.forEach(month => {
                const monthName = new Date(0, month - 1).toLocaleString('es', { month: 'long' });
                const option = new Option(monthName.charAt(0).toUpperCase() + monthName.slice(1), month);
                monthSelect.options.add(option);
            });
            monthSelect.disabled = false;
        } else {
            monthSelect.disabled = true;
        }
    }

    yearSelect.addEventListener('change', updateMonthSelect);
});
</script>
