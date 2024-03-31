<?php

namespace App\Livewire\Taxonomies;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Taxonomy;

class ListTaxonomies extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $taxonomies = Taxonomy::paginate(10);
        return view('livewire.taxonomies.list-taxonomies', compact('taxonomies'));
    }

    public function edit($taxonomyId)
    {
        // Redirige al usuario a la ruta de edición, asumiendo que tienes una ruta nombrada adecuadamente
        return redirect()->route('taxonomies.manage', ['taxonomyId' => $taxonomyId]);
    }
    
    public function deleteTaxonomy($taxonomyId)
    {
        $taxonomy = Taxonomy::findOrFail($taxonomyId);
        $taxonomy->delete();
        session()->flash('message', 'Taxonomía eliminada con éxito.');
    }
}
