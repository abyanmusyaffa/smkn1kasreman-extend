<?php

namespace App\Livewire\Components;

use Livewire\Component;

class TitleRight extends Component
{
    public $text;
    public $span;

    public function render()
    {
        return view('livewire.components.title-right');
    }
}
