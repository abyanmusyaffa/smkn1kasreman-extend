<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardTeachingFactory extends Component
{
    public $slug;
    public $logo;
    public $name;
    
    public function render()
    {
        return view('livewire.components.card-teaching-factory');
    }
}
