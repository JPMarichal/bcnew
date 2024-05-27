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

        $searchTerm = $this->normalizeString($this->searchTerm);
        $words = explode(' ', $searchTerm);
        $phrase = '"' . $searchTerm . '"';

        $this->posts = DB::table('posts')
            ->where('status', 'published')
            ->where(function ($query) use ($phrase, $words) {
                $query->whereRaw('LOWER(title) like ?', [$phrase])
                      ->orWhereRaw('LOWER(content) like ?', [$phrase]);

                foreach ($words as $word) {
                    $query->orWhereRaw('LOWER(title) like ?', ['%' . $word . '%'])
                          ->orWhereRaw('LOWER(content) like ?', ['%' . $word . '%']);
                }
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
