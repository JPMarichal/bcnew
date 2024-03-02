<?php

namespace App\View\Components\News;

use Illuminate\View\Component;

class MetaBar extends Component
{
    public $newsItem;

    public function __construct($newsItem)
    {
        $this->newsItem = $newsItem;
    }

    public function render()
    {
        return view('components.news.meta-bar');
    }
}
