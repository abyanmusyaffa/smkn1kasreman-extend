<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardStaff extends Component
{
    public $photo;
    public $name;
    public $role;
    
    public function render()
    {
        return view('livewire.components.card-staff');
    }
}
