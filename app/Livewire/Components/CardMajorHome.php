<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardMajorHome extends Component
{
    public $alias;
    public $colSpan;
    public $logo;
    public $expertise_concentration;
    
    public function render()
    {
        return view('livewire.components.card-major-home');
    }
}
