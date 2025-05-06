<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardAchievement extends Component
{
    public $slug;
    public $title;
    public $rankings;
    public $photo;
    public $createdAt;

    public function render()
    {
        return view('livewire.components.card-achievement');
    }
}
