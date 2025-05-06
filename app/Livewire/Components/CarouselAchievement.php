<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CarouselAchievement extends Component
{
    public $slug;
    public $index;
    public $rankings;
    public $title;
    public $photo;

    public function render()
    {
        return view('livewire.components.carousel-achievement');
    }
}
