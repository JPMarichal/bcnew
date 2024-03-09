@if ($paginator->hasPages())
    <nav aria-label="Navegación de página">
        <div class="pagination-container">
            {{-- Enlace de página anterior --}}
            @if ($paginator->onFirstPage())
                <span class="page-link disabled" aria-disabled="true">Anterior</span>
            @else
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a>
            @endif

            {{-- Elementos de paginación --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-link disabled" aria-disabled="true">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-link active" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Enlace de página siguiente --}}
            @if ($paginator->hasMorePages())
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente</a>
            @else
                <span class="page-link disabled" aria-disabled="true">Siguiente</span>
            @endif
        </div>
    </nav>
@endif
