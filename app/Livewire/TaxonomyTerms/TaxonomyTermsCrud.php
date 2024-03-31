<?php

namespace App\Livewire\TaxonomyTerms;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TaxonomyTerm;
use App\Models\Taxonomy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaxonomyTermsCrud extends Component
{
    use WithPagination;

    public $taxonomyTermId;
    public $name;
    public $taxonomyId = 1;
    public $parentId;
    public $isOpen = 0;

    public $taxonomies = []; // Para almacenar todas las taxonomías disponibles
    public $possibleParents = []; // Para almacenar posibles términos padres

    protected $listeners = ['delete'];

    protected $rules = [
        'name' => 'required|string|max:70',
        'taxonomyId' => 'required',
        'parentId' => 'nullable'
    ];

    public function mount($taxonomyTermId)
    {
        $this->taxonomies = Taxonomy::all(); // Cargar todas las taxonomías
        $this->possibleParents = TaxonomyTerm::where('taxonomy_id', $this->taxonomyId)->get(); // Cargar posibles padres basados en la taxonomía seleccionada
    }

    public function render()
    {
        $this->possibleParents = TaxonomyTerm::where('taxonomy_id', $this->taxonomyId)->get(); // Actualizar posibles padres si cambia la taxonomía seleccionada

        $taxonomyTerms = [
            'taxonomyTerms' => TaxonomyTerm::where('taxonomy_id', $this->taxonomyId)
                                ->orderBy('name', 'asc')
                                ->paginate(10),
        ];

      //  dd($taxonomyTerms);
        return view('livewire.taxonomy-terms.taxonomy-terms-crud',$taxonomyTerms );
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
        $this->dispatch('openModal');
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->taxonomyId = '';
        $this->parentId = null;
        $this->taxonomyTermId = null;
    }

    public function store()
    {
        $this->validate();

        TaxonomyTerm::updateOrCreate(['id' => $this->taxonomyTermId], [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'taxonomy_id' => $this->taxonomyId,
            'parent_id' => $this->parentId,
            'created_by' => Auth::id(),
        ]);

        session()->flash('message', 
            $this->taxonomyTermId ? 'Término actualizado correctamente.' : 'Término creado correctamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $taxonomyTerm = TaxonomyTerm::findOrFail($id);
        $this->taxonomyTermId = $id;
        $this->name = $taxonomyTerm->name;
        $this->taxonomyId = $taxonomyTerm->taxonomy_id;
        $this->parentId = $taxonomyTerm->parent_id;

        $this->openModal();
    }

    public function delete($id)
    {
        TaxonomyTerm::find($id)->delete();
        session()->flash('message', 'Término eliminado correctamente.');
    }
}
