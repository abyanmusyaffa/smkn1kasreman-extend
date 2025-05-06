<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardFacility extends Component
{
    public $name;
    public $photo;

    public function render()
    {
        return view('livewire.components.card-facility');
    }
}
