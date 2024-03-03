<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomPagination extends Component
{
    public $paginator;
    public $elements;

    /**
     * Create a new component instance.
     *
     * @param  LengthAwarePaginator  $paginator
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        $this->elements = $this->createElementsFromPaginator($paginator);
    }
/*
    private function createElementsFromPaginator(LengthAwarePaginator $paginator): array
    {
        // Implement your logic here to create the $elements array from the $paginator
        // This is just a placeholder example
        $elements = [];
        foreach ($paginator->items() as $item) {
            $elements[] = ['itemm' => $item];
        }
        return $elements;
    }*/

    private function createElementsFromPaginator(LengthAwarePaginator $paginator): array
{
    $window = \Illuminate\Pagination\UrlWindow::make($paginator);

    // Fusiona los enlaces para las primeras páginas, las páginas alrededor de la actual y las últimas páginas
    $elements = array_filter([
        $window['first'],
        is_array($window['slider']) ? '...' : null,
        $window['slider'],
        is_array($window['last']) ? '...' : null,
        $window['last'],
    ]);

    return $elements;
}


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.custom-pagination');
    }
}
