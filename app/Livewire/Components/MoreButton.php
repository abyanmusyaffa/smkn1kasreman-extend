<?php

namespace App\Livewire\Components;

use Livewire\Component;

class MoreButton extends Component
{
    public $text;
    public $href;
    public $elemen = 'a';
    public $class;

    public function render()
    {
        return view('livewire.components.more-button');
    }
}
