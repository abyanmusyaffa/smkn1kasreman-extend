<?php

namespace App\Livewire\Components;

use Livewire\Component;

class AsideCardAchievement extends Component
{
    public $slug;
    public $photo;
    public $title;
    public $rankings;
    public $created_at;

    public function render()
    {
        return view('livewire.components.aside-card-achievement');
    }
}
