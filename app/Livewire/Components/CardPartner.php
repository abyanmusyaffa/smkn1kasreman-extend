<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardPartner extends Component
{
    public $logo;
    public $name;
    public $address;
    public $industry;

    public function render()
    {
        return view('livewire.components.card-partner');
    }
}
