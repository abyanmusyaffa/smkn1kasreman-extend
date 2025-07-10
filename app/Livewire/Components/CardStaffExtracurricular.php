<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardStaffExtracurricular extends Component
{
    public $photo;
    public $name;
    public $role;
    
    public function render()
    {
        return view('livewire.components.card-staff-extracurricular');
    }
}
