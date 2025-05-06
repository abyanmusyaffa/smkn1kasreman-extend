<?php

namespace App\Livewire\Components;

use Livewire\Component;

class AsideCardArticle extends Component
{
    public $slug;
    public $photo;
    public $title;
    public $category;
    public $createdAt;

    public function render()
    {
        return view('livewire.components.aside-card-article');
    }
}
