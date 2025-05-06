<?php

namespace App\Livewire\Components;

use Livewire\Component;

class AsideArticle extends Component
{
    public $articles;
    public $achievements;
    public $jobfairs;

    public function render()
    {
        return view('livewire.components.aside-article');
    }
}
