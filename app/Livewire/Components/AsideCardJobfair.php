<?php

namespace App\Livewire\Components;

use Livewire\Component;

class AsideCardJobfair extends Component
{
    public $slug;
    public $photo;
    public $deadline;
    public $title;
    
    public function render()
    {
        return view('livewire.components.aside-card-jobfair');
    }
}
