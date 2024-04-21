<?php
namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SocialShareBar extends Component
{
    public $title; 
    public $description;
    public $keywords;
    public $featuredImage;

    public function __construct(
        $title = null,
        $description = null,
        $keywords = null,
        $featuredImage=null
        ) // Modificar esta línea
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->featuredImage = $featuredImage;
    }

    public function render(): View
    {
        return view('components.social-share-bar', [
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'featuredImage' => $this->featuredImage
        ]);
    }
}
