<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardArticleHome extends Component
{
    public $category;
    public $slug;
    public $photo;
    public $created_at;
    public $title;
    public $index;
    
    public function render()
    {
        return view('livewire.components.card-article-home');
    }
}
