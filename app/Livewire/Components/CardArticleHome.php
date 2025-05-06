<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardArticleHome extends Component
{
    public $category;
    public $slug;
    public $photo;
    public $createdAt;
    public $title;
    
    public function render()
    {
        return view('livewire.components.card-article-home');
    }
}
