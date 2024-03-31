<?php

namespace App\Livewire\Taxonomies;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Taxonomy;

class ManageTaxonomy extends Component
{
    public $taxonomyId, $name, $slug, $type = 'Clasificador'; // Valor predeterminado

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'string|max:255|unique:taxonomies,slug,' . $this->taxonomyId,
            'type' => 'required|string|max:255', // Asegurar que el tipo es obligatorio
        ];
    }

    public function mount($taxonomyId = null)
    {
        if ($taxonomyId) {
            $taxonomy = Taxonomy::findOrFail($taxonomyId);
            $this->taxonomyId = $taxonomy->id;
            $this->name = $taxonomy->name;
            $this->slug = $taxonomy->slug;
            $this->type = $taxonomy->type;
        }
    }

    public function save()
    {
        try {
            $this->slug = Str::slug($this->name);

            $this->validate();

            Taxonomy::updateOrCreate(
                ['id' => $this->taxonomyId],
                [
                    'name' => $this->name,
                    'slug' => $this->slug,
                    'type' => $this->type,
                    'created_by' => auth()->id(),
                ]
            );

            session()->flash('message', 'Taxonomía guardada con éxito.');
            $this->reset(['name', 'slug', 'type']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors()); // Muestra los errores de validación directamente
        }
    }

    public function render()
    {
        return view('livewire.taxonomies.manage-taxonomy');
    }
}
