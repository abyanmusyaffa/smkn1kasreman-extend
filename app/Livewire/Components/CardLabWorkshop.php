<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardLabWorkshop extends Component
{
    public $id;
    public $name;
    public $photo;
    public $code;
    public $description;

    public function render()
    {
        return view('livewire.components.card-lab-workshop');
    }
}
