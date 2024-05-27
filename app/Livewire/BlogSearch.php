<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BlogSearch extends Component
{
    public $searchTerm = '';
    public $posts;

    public function mount()
    {
        $this->posts = collect();
    }

    public function updatedSearchTerm()
    {
        $this->searchPosts();
    }

    public function searchPosts()
    {
        if (empty($this->searchTerm)) {
            $this->posts = collect();
            return;
        }

        $searchTerm = '%' . $this->normalizeString($this->searchTerm) . '%';

        $this->posts = DB::table('posts')
            ->where('status', 'published')
            ->where(function ($query) use ($searchTerm) {
                $query->where(DB::raw('LOWER(title)'), 'like', $searchTerm)
                      ->orWhere(DB::raw('LOWER(content)'), 'like', $searchTerm);
            })
            ->select('id', 'title', 'slug', 'post_type')
            ->get()
            ->groupBy('post_type');
    }

    public function search()
    {
        $this->redirect(route('blog.searchResults', ['term' => $this->searchTerm]));
    }

    public function render()
    {
        return view('livewire.blog-search', ['posts' => $this->posts ?? collect()]);
    }

    private function normalizeString($string)
    {
        return str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'],
            ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'],
            strtolower($string)
        );
    }
}
