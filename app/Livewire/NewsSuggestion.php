<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NewsPost;
use Carbon\Carbon;

class NewsSuggestion extends Component
{
    public $latestNews;
    public $randomNews;

    public function mount()
    {
        $this->latestNews = NewsPost::orderBy('pub_date', 'desc')
                                     ->take(5)
                                     ->get();

        $this->randomNews = NewsPost::where('pub_date', '>', Carbon::now()->subMonths(2))
                                    ->inRandomOrder()
                                    ->take(5)
                                    ->get();
    }
    
    public function render()
    {
        return view('livewire.news-suggestion');
    }
}
