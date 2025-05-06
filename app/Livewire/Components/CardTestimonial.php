<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardTestimonial extends Component
{
    public $photo;
    public $name;
    public $passing_year;
    public $position;
    public $company;
    public $content;
    public $rating;
    
    public function render()
    {
        return view('livewire.components.card-testimonial');
    }
}
