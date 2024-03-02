<div class="filters-bar mb-3">
    <form action="{{ route('noticias.index') }}" method="GET" class="d-flex justify-content-start">
        <select name="month" class="form-select mx-2">
            <option value="">Mes</option>
            @foreach(['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'] as $key => $month)
                <option value="{{ $key }}">{{ $month }}</option>
            @endforeach
        </select>
        <select name="year" class="form-select mx-2">
            <option value="">Año</option>
            @foreach ($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
</div>
