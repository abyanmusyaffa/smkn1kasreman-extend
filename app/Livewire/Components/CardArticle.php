<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardArticle extends Component
{
    public $slug;
    public $category;
    public $title;
    public $createdAt;
    public $photo;

    public function render()
    {
        return view('livewire.components.card-article');
    }
}
