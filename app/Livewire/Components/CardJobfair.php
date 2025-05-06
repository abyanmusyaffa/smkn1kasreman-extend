<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardJobfair extends Component
{
    public $slug;
    public $photo;
    public $deadline;
    public $title;

    public function render()
    {
        return view('livewire.components.card-jobfair');
    }
}
